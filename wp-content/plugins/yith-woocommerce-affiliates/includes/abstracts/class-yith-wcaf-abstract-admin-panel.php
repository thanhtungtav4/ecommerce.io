<?php
/**
 * General admin panel handling
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Abstract_Admin_Panel' ) ) {
	/**
	 * Wraps general method used in admin panel
	 *
	 * @since 1.0.0
	 */
	abstract class YITH_WCAF_Abstract_Admin_Panel {

		/**
		 * Current tab name
		 *
		 * @var string
		 */
		protected $tab = '';

		/**
		 * Stores name of the query var that identifies single item
		 *
		 * @var string
		 */
		protected $item_query_var = '';

		/**
		 * List of messages to prompt to the admin when needed
		 * Expected format:
		 * [
		 *     query_var => [
		 *         success     => success message; can contain 1 placeholder, that will be replaced by querystring value
		 *                        can also be an array containing singular and plural indexes; in this case querystring param
		 *                        will be converted to int, and appropriate message will be shown
		 *                        Replacement will happen even in this case.
		 *         error       => same as above, for error messages,
		 *         message     => same as above, for generic messages,
		 *         classes     => classes to add to message container, instead of default (default updated),
		 *         dismissible => Whether message is dismissible or not (default true)
		 *     ],
		 *     ...
		 * ]
		 *
		 * @var array
		 */
		protected $admin_notices = array();

		/**
		 * List of admin actions supported for this view.
		 * Expected format:
		 * [
		 *     // standard format.
		 *     action_slug => callback,
		 *
		 *     // verbose format.
		 *     action_slug => [
		 *         callback     => Callable function,
		 *         nonce_action => String to use to verify nonce
		 *     ]
		 *     ...
		 * ]
		 *
		 * @var array
		 */
		protected $admin_actions = array();

		/**
		 * Stores additional screen options for this view
		 * Expected format:
		 * [
		 *     screen_option_slug => [
		 *         label    => Label for the option,
		 *         default  => Default value,
		 *         option   => Option name; used to store value for current used,
		 *         sanitize => Callback used to sanitize value to save,
		 *     ],
		 *     ...
		 * ]
		 *
		 * @var array
		 */
		protected $screen_options = array();

		/**
		 * Stores columns for current screen
		 * Expected format:
		 * [
		 *     column_slug => Column name,
		 *     ...
		 * ]
		 *
		 * @var array
		 */
		protected $screen_columns = array();

		/**
		 * Init panel
		 *
		 * @return void
		 */
		public function __construct() {
			$base_screen_id = $this->get_screen_id();

			// admin notices.
			add_action( 'admin_notices', array( $this, 'print_notices' ) );

			// init screen.
			add_action( 'current_screen', array( $this, 'init_screen' ) );

			// admin actions.
			add_action( 'admin_init', array( $this, 'init_admin_actions' ) );

			// bulk actions.
			add_action( 'admin_init', array( $this, 'maybe_process_bulk_actions' ) );

			// screen options.
			add_action( 'current_screen', array( $this, 'add_screen_option' ) );
			add_filter( 'set-screen-option', array( $this, 'set_screen_option' ), 10, 3 );
			add_filter( "manage_{$base_screen_id}_columns", array( $this, 'add_screen_columns' ) );
		}

		/* === HELPER METHODS === */

		/**
		 * Returns true if we're on panel tab
		 *
		 * @return bool Whether current screen is handled by this class or not.
		 */
		public function is_current_tab() {
			return YITH_WCAF_Admin()->is_own_screen() && YITH_WCAF_Admin()->get_current_tab() === $this->tab;
		}

		/**
		 * Get current tab url
		 *
		 * @param array $args Arguments to add to the url.
		 * @return string Current tab url.
		 */
		public function get_tab_url( $args = array() ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_admin_tab_url
			 *
			 * Filters the url for the current tab in the backend.
			 *
			 * @param string $url Tab url.
			 */
			return apply_filters( 'yith_wcaf_admin_tab_url', add_query_arg( $args, YITH_WCAF_Admin()->get_tab_url( $this->tab, '', $args ) ) );
		}

		/* === ADMIN NOTICES === */

		/**
		 * Print admin notices, depending on query vars in url
		 */
		public function print_notices() {
			if ( empty( $this->admin_notices ) ) {
				return;
			}

			foreach ( $this->admin_notices as $query_var => $message_options ) {
				if ( ! isset( $_GET[ $query_var ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
					continue;
				}

				$value     = sanitize_text_field( wp_unslash( $_GET[ $query_var ] ) ); // phpcs:ignore WordPress.Security.NonceVerification
				$num_value = (int) $value;
				$classes   = isset( $message_options['classes'] ) ? $message_options['classes'] : '';

				// add status class, when missing.
				if ( false === strpos( $classes, 'updated' ) && false === strpos( $classes, 'error' ) ) {
					$classes .= ! ! $value ? ' updated' : 'error';
				}

				if ( ! isset( $message_options['is_dismissible'] ) || $message_options['is_dismissible'] ) {
					$classes .= ' is-dismissible';
				}

				if ( $value && isset( $message_options['success'] ) ) {
					if ( is_array( $message_options['success'] ) && array( 'singular', 'plural' ) === array_keys( $message_options['success'] ) ) {
						$message = 1 === $num_value ? $message_options['success']['singular'] : $message_options['success']['plural'];
					} else {
						$message = $message_options['success'];
					}
				} elseif ( ! $value && isset( $message_options['error'] ) ) {
					if ( is_array( $message_options['error'] ) && array( 'singular', 'plural' ) === array_keys( $message_options['error'] ) ) {
						$message = 1 === $num_value ? $message_options['error']['singular'] : $message_options['error']['plural'];
					} else {
						$message = $message_options['error'];
					}
				} elseif ( isset( $message_options['message'] ) ) {
					if ( is_array( $message_options['message'] ) && array( 'singular', 'plural' ) === array_keys( $message_options['message'] ) ) {
						$message = 1 === $num_value ? $message_options['message']['singular'] : $message_options['message']['plural'];
					} else {
						$message = $message_options['message'];
					}
				} else {
					continue;
				}

				$message = sprintf( $message, $value );

				?>
				<div class="notice <?php echo esc_attr( $classes ); ?>">
					<p>
						<?php echo esc_html( $message ); ?>
					</p>
				</div>
				<?php
			}
		}

		/* === ADMIN ACTIONS === */

		/**
		 * Init admin actions for this view
		 *
		 * @return void
		 */
		public function init_admin_actions() {
			if ( empty( $this->admin_actions ) ) {
				return;
			}

			$action_handler = YITH_WCAF_Admin_Actions::get_instance();

			foreach ( $this->admin_actions as $action => $callback ) {
				$action_handler->add_action( $action, $callback );
			}
		}

		/* === SCREEN OPTIONS === */

		/**
		 * Add Screen option
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_screen_option() {
			if ( ! $this->is_current_tab() ) {
				return;
			}

			if ( empty( $this->screen_options ) ) {
				return;
			}

			foreach ( $this->screen_options as $slug => $options ) {
				add_screen_option( $slug, $options );
			}
		}

		/**
		 * Save custom screen options
		 *
		 * @param bool   $set    Value to filter (default to false).
		 * @param string $option Custom screen option key.
		 * @param mixed  $value  Custom screen option value.
		 *
		 * @return mixed Value to be saved as user meta; false if no value should be saved
		 */
		public function set_screen_option( $set, $option, $value ) {
			if ( ! $this->is_current_tab() ) {
				return false;
			}

			$screen_option_slug = array_search( $option, wp_list_pluck( $this->screen_options, 'option' ), true );

			if ( false === $screen_option_slug ) {
				return false;
			}

			$screen_option = $this->screen_options[ $screen_option_slug ];

			if ( isset( $screen_option['sanitize'] ) ) {
				$value = call_user_func( $screen_option['sanitize'], $value );
			}

			if ( ! $value ) {
				return false;
			}

			return $value;
		}

		/**
		 * Add Screen columns for current screen
		 *
		 * @param array $columns Array of defined columns.
		 *
		 * @return array Filtered array of columns
		 */
		public function add_screen_columns( $columns ) {
			if ( ! empty( $this->screen_columns ) ) {
				$columns = array_merge(
					$columns,
					$this->screen_columns
				);
			}

			return $columns;
		}

		/* === BULK ACTIONS === */

		/**
		 * Returns current query string action, if any
		 *
		 * @retutn string Current action.
		 */
		public function get_current_action() {
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$current_action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '';
			$current_action = ( '-1' === $current_action && isset( $_REQUEST['action2'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['action2'] ) ) : $current_action;
			// phpcs:enable WordPress.Security.NonceVerification.Recommended

			return $current_action;
		}

		/**
		 * Checks whether system should process bulk actions or not
		 *
		 * @return bool|string Current action, if system should process bulk actions; false otherwise.
		 */
		public function should_process_bulk_actions() {
			$current_action = $this->get_current_action();

			if ( ! $current_action || '-1' === $current_action ) {
				return false;
			}

			if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), "bulk-{$this->tab}" ) ) {
				return false;
			}

			return $current_action;
		}

		/**
		 * Process bulk actions when needed
		 */
		public function maybe_process_bulk_actions() {
			if ( ! $this->should_process_bulk_actions() ) {
				return;
			}

			$params = array_merge(
				$this->process_bulk_actions(),
				$this->is_single_item() ? array(
					$this->item_query_var => $this->get_single_item_id(),
				) : array()
			);

			wp_safe_redirect( add_query_arg( $params, YITH_WCAF_Admin()->get_tab_url() ) );
			die;
		}

		/**
		 * Process bulk actions for current view.
		 *
		 * @return array Array of parameters to be added to redirect uri.
		 */
		public function process_bulk_actions() {
			// do something on child classes, if needed.
			return array();
		}

		/* === PANEL HANDLING === */

		/**
		 * Checks if current screen should show item detail
		 *
		 * @return bool
		 */
		public function is_single_item() {
			return ! empty( $this->item_query_var ) && isset( $_REQUEST[ $this->item_query_var ] ); // phpcs:ignore WordPress.Security.NonceVerification
		}

		/**
		 * Returns id for item being currently shown
		 *
		 * @return bool|int
		 */
		public function get_single_item_id() {
			if ( ! $this->is_single_item() ) {
				return false;
			}

			return isset( $_REQUEST[ $this->item_query_var ] ) ? intval( $_REQUEST[ $this->item_query_var ] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification
		}

		/**
		 * Returns screen id for current tab
		 *
		 * @return string
		 */
		public function get_screen_id() {
			$main_screen_id = YITH_WCAF_Admin()->get_panel_screen_id();

			/**
			 * APPLY_FILTERS: yith_wcaf_admin_panel_$tab_screen_id
			 *
			 * Filters the screen id for the current tab in the plugin panel.
			 * <code>$tab</code> will be replaced with the current tab in the plugin panel.
			 *
			 * @param string $screen_id Screen id for current tab.
			 */
			return apply_filters( "yith_wcaf_admin_panel_{$this->tab}_screen_id", "{$main_screen_id}_{$this->tab}" );
		}

		/**
		 * Init screen for current tab
		 *
		 * @param WP_Screen $screen Currently set screen (mabe replace it).
		 * @return void
		 */
		public function init_screen( $screen ) {
			$current_screen_id = $this->get_screen_id();

			if ( ! $current_screen_id || $current_screen_id === $screen->id ) {
				return;
			}

			set_current_screen( $current_screen_id );
		}

		/**
		 * Enqueue required assets for current panel.
		 * This method should be hooked to admin_enqueue_scripts when needed by the extending panel.
		 *
		 * @return void.
		 */
		public function enqueue_assets() {
			YITH_WCAF_Scripts::enqueue(
				'yith-wcaf-admin-' . $this->tab,
				'admin',
				array(
					'jquery',
					'wp-mediaelement',
					'jquery-ui-datepicker',
					'selectWoo',
					'woocommerce_settings',
				)
			);

			$this->localize_scripts();
		}

		/**
		 * Localize scripts for current tab
		 *
		 * @return void
		 */
		public function localize_scripts() {
			$localized_args = YITH_WCAF_Admin()->get_global_localize( $this->get_localize() );

			wp_localize_script( 'yith-wcaf-admin-' . $this->tab, 'yith_wcaf', $localized_args );
		}

		/**
		 * Returns variable to localize for current panel
		 *
		 * @return array Array of variables to localize.
		 */
		public function get_localize() {
			/**
			 * APPLY_FILTERS: yith_wcaf_admin_panel_$tab_script_localize
			 *
			 * Filters the array with the variables to localize into the plugin script.
			 * <code>$tab</code> will be replaced with the current tab in the plugin panel.
			 *
			 * @param array $localize Array with variables to localize.
			 */
			return apply_filters( "yith_wcaf_admin_panel_{$this->tab}_script_localize", array() );
		}

		/**
		 * When invoked, will set form for current panel tab with GET method.
		 *
		 * @since 2.2.0
		 */
		protected function set_get_form() {
			add_filter(
				'yit_admin_panel_form_method',
				function() {
					return 'GET';
				}
			);
		}
	}
}
