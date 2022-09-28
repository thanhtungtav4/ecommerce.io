<?php
/**
 * Admin class
 *
 * @author  YITH
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Admin' ) ) {
	/**
	 * WooCommerce Affiliates Admin
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Admin {

		use YITH_WCAF_Trait_Singleton;

		/**
		 * List of available tab for affiliates panel
		 *
		 * @var array
		 * @access public
		 * @since  1.0.0
		 */
		protected $available_tabs = array();

		/**
		 * Admin page slug
		 *
		 * @var string
		 */
		protected $page_slug = 'yith_wcaf_panel';

		/**
		 * Instance of panel object
		 *
		 * @var YIT_Plugin_Panel_WooCommerce
		 */
		protected $panel;

		/**
		 * Instance of tab object
		 *
		 * @var YITH_WCAF_Abstract_Admin_Panel
		 */
		protected $tab;

		/**
		 * Constructor method
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			// start by requiring and initializing dependencies.
			$this->install();

			// register plugin panel.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_filter( 'woocommerce_screen_ids', array( $this, 'register_woocommerce_screen' ) );

			// register plugin links & meta row.
			add_filter( 'plugin_action_links_' . YITH_WCAF_INIT, array( $this, 'action_links' ) );
			add_filter( 'yith_show_plugin_row_meta', array( $this, 'add_plugin_meta' ), 10, 5 );
		}

		/* === INSTALL METHODS === */

		/**
		 * Execute admin panel installation
		 *
		 * @return void
		 * @since 2.0.0
		 */
		public function install() {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );
		}

		/**
		 * Startup admin panel
		 *
		 * @return void
		 */
		public function init() {
			// do startup operations.
			YITH_WCAF_Admin_Profile::init();
			YITH_WCAF_Admin_Meta_Boxes::init();
			YITH_WCAF_Admin_Orders::init();

			// load current tab.
			$this->load_tab();
		}

		/* === HELPER METHODS === */

		/**
		 * Return array of screen ids related to affiliates plugin
		 *
		 * @return mixed Array of available screens
		 * @since 1.0.0
		 */
		public function get_screen_ids() {
			$base           = sanitize_title( 'YITH Plugins' );
			$main_screen_id = "{$base}_page_{$this->page_slug}";

			$screen_ids = array(
				$main_screen_id,
				"{$main_screen_id}_dashboard",
				"{$main_screen_id}_affiliates",
				"{$main_screen_id}_clicks",
				"{$main_screen_id}_commissions",
				"{$main_screen_id}_payments",
				"{$main_screen_id}_rates",
				"{$main_screen_id}_settings",
				'user-edit',
				'shop_subscription',
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_screen_ids
			 *
			 * Filters the screen ids related to the plugin.
			 *
			 * @param array $screen_ids Screen ids.
			 */
			return apply_filters( 'yith_wcaf_screen_ids', $screen_ids );
		}

		/**
		 * Returns true if current screen belongs to affiliate plugin
		 *
		 * @return bool Whether we're on an internal screen or not.
		 */
		public function is_own_screen() {
			$is_own_screen = false;

			if ( ! did_action( 'current_screen' ) ) {
				// if we don't have screen yet, fallback to query string check.
				$is_own_screen = isset( $_GET['page'] ) && $this->page_slug === $_GET['page']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			} else {
				// otherwise rely on screen object.
				$screen = get_current_screen();

				$is_own_screen = $screen && in_array( $screen->id, $this->get_screen_ids(), true );
			}

			return $is_own_screen;
		}

		/**
		 * Returns slug for the panel's page
		 *
		 * @return string Panel's page slug
		 */
		public function get_panel_slug() {
			return $this->page_slug;
		}

		/**
		 * Returns base url of the panel
		 *
		 * @return string Panel's base url
		 */
		public function get_panel_url() {
			/**
			 * APPLY_FILTERS: yith_wcaf_admin_panel_url
			 *
			 * Filters the url of the plugin panel.
			 *
			 * @param string $panel_url Plugin panel url.
			 */
			return apply_filters( 'yith_wcaf_admin_panel_url', add_query_arg( 'page', $this->page_slug, admin_url( 'admin.php' ) ) );
		}

		/**
		 * Returns screen id of the main plugin panel
		 *
		 * @return string Plugin panel screen id
		 */
		public function get_panel_screen_id() {
			$screen_ids = $this->get_screen_ids();
			$base_id    = is_array( $screen_ids ) ? array_shift( $screen_ids ) : '';

			/**
			 * APPLY_FILTERS: yith_wcaf_admin_panel_screen_id
			 *
			 * Filters the screen id of the plugin panel.
			 *
			 * @param string $base_id Screen id of the plugin panel.
			 */
			return apply_filters( 'yith_wcaf_admin_panel_screen_id', $base_id );
		}

		/* === PLUGIN PANEL METHODS === */

		/**
		 * Returns available tabs
		 *
		 * @return array.
		 */
		public function get_available_tabs() {
			// sets available tab.
			if ( empty( $this->available_tabs ) ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_available_admin_tabs
				 *
				 * Filter the available tabs in the plugin panel.
				 *
				 * @param array $tabs Admin tabs.
				 */
				$this->available_tabs = apply_filters(
					'yith_wcaf_available_admin_tabs',
					array(
						'affiliates'  => _x( 'Affiliates', '[ADMIN] Panel tabs', 'yith-woocommerce-affiliates' ),
						'commissions' => _x( 'Commissions', '[ADMIN] Panel tabs', 'yith-woocommerce-affiliates' ),
						'settings'    => _x( 'General Options', '[ADMIN] Panel tabs', 'yith-woocommerce-affiliates' ),
					)
				);
			}

			// returns existing tabs.
			return $this->available_tabs;
		}

		/**
		 * Returns minimum capability needed to manage plugin's panel
		 *
		 * @return string Capability, filtered by yith_wcaf_panel_capability filter.
		 */
		public function get_panel_capability() {
			/**
			 * APPLY_FILTERS: yith_wcaf_panel_capability
			 *
			 * Filters the minimum capability needed to manage the plugin panel.
			 *
			 * @param string $capability Capability.
			 */
			return apply_filters( 'yith_wcaf_panel_capability', 'manage_woocommerce' );
		}

		/**
		 * Return true if current user can manage admin panel
		 *
		 * @return bool Whether current user can manage panel.
		 */
		public function current_user_can_manage_panel() {
			return current_user_can( $this->get_panel_capability() );
		}

		/**
		 * Register panel
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_panel() {
			$args = array(
				'create_menu_page' => true,
				'parent_slug'      => '',
				'page_title'       => 'YITH WooCommerce Affiliates',
				'menu_title'       => 'Affiliates',
				'capability'       => $this->get_panel_capability(),
				'class'            => yith_set_wrapper_class( 'yith-plugin-ui--classic-wp-list-style' ),
				'parent'           => '',
				'parent_page'      => 'yith_plugin_panel',
				'page'             => $this->page_slug,
				'admin-tabs'       => $this->get_available_tabs(),
				'options-path'     => YITH_WCAF_DIR . 'plugin-options',
				'plugin_slug'      => YITH_WCAF_SLUG,
				'plugin-url'       => YITH_WCAF_URL,
				'help_tab'         => array(
					'main_video' => array(
						'desc' => _x( 'Check this video to learn how to <b>set up an affiliate program for your online shop:</b>', '[HELP TAB] Video title', 'yith-woocommerce-affiliates' ),
						'url'  => array(
							'en' => 'https://www.youtube.com/embed/Xfq858W3eX4',
							'it' => 'https://www.youtube.com/embed/Wjer5r0CzbU',
							'es' => 'https://www.youtube.com/embed/c5-TBKsLlwg',
						),
					),
					'playlists'  => array(
						'en' => 'https://www.youtube.com/playlist?list=PLDriKG-6905nRkvGiijQUpbFESzaBK271',
						'it' => 'https://www.youtube.com/playlist?list=PL9c19edGMs0-f57-xmvZ18QHKv--zjEiE',
						'es' => 'https://www.youtube.com/playlist?list=PL9Ka3j92PYJPMCrWAWzfZmpURKeuF97xA',
					),
					'hc_url'     => 'https://support.yithemes.com/hc/en-us/categories/360003475758-YITH-WOOCOMMERCE-AFFILIATES',
				),
			);

			// registers premium tab.
			if ( ! defined( 'YITH_WCAF_PREMIUM' ) ) {
				$args['premium_tab'] = array(
					'main_image_url'   => YITH_WCAF_ASSETS_URL . 'images/premium/get-premium-affiliate.jpg',
					'premium_features' => array(
						__( '<b>Get access to advanced reports</b> (hits, commissions, earnings, best affiliates, popular products, etc.) in the integrated dashboard', 'yith-woocommerce-affiliates' ),
						__( 'Create a <b>custom advanced form for your affiliate’s registration</b> process: add unlimited fields to the form, such as Website or Blog url, Links of their social channels, a small bio, etc. ', 'yith-woocommerce-affiliates' ),
						__( 'Override the default commission rate and <b>set a different rate value for specific users, user roles or products</b>', 'yith-woocommerce-affiliates' ),
						__( '<b>Exclude specific products, categories, tag, user or user roles</b> from the affiliation program', 'yith-woocommerce-affiliates' ),
						__( '<b>Automatic payment of the commissions</b> (with PayPal or Stripe) when the affiliate reaches a threshold, on a specific month date (ex: each 1st of every month), on a specific month date only if the threshold is achieved or schedule a daily payment. ', 'yith-woocommerce-affiliates' ),
						__( '<b>Let affiliates to ask their commissions withdrawal</b> (and upload or generate invoices for their requests)', 'yith-woocommerce-affiliates' ),
						__( '<b>Get access to the report of clicks</b> generated from referrers in a summarising table with main information and their conversion status', 'yith-woocommerce-affiliates' ),
						__( '<b>Access to the affiliate’s detail page</b> from the affiliates table, to check the affiliate’s personal info, commissions, statistics, etc.', 'yith-woocommerce-affiliates' ),
						__( 'Regular updates, translations and premium support', 'yith-woocommerce-affiliates' ),
					),
				);
			}

			// load plugin-fw class when needed.
			if ( ! class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
				require_once YITH_WCAF_DIR . 'plugin-fw/lib/yit-plugin-panel-wc.php';
			}

			$this->panel = new YIT_Plugin_Panel_WooCommerce( $args );
		}

		/**
		 * Returns current tab
		 *
		 * @return string|bool Current tab, or false if not on a plugin's tab.
		 */
		public function get_current_tab() {
			if ( ! $this->is_own_screen() ) {
				return false;
			}

			$available_tabs = array_keys( $this->get_available_tabs() );

			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$current_tab    = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : $available_tabs[0];
			$current_subtab = isset( $_GET['sub_tab'] ) ? sanitize_text_field( wp_unslash( $_GET['sub_tab'] ) ) : false;
			// phpcs:enable WordPress.Security.NonceVerification.Recommended

			if ( ! in_array( $current_tab, $available_tabs, true ) ) {
				return false;
			}

			if ( $current_subtab ) {
				$formatted_subtab = str_replace( "$current_tab-", '', $current_subtab );

				// exception for -list subtabs.
				if ( 'list' === $formatted_subtab ) {
					return $current_tab;
				}

				// exception for settings tab.
				if ( 'settings' === $current_tab ) {
					return $current_tab;
				}

				return $formatted_subtab;
			}

			return $current_tab;
		}

		/**
		 * Returns instance of the YITH_WCAF_Abstract_Admin_Panel object for current tab
		 *
		 * @return YITH_WCAF_Abstract_Admin_Panel
		 */
		public function get_current_tab_instance() {
			return $this->tab;
		}

		/**
		 * Returns instance of the YITH_WCAF_Abstract_Admin_Panel object for an arbitrary tab
		 *
		 * @param string|bool $tab Tab slug; if false defaults to current tab.
		 * @return YITH_WCAF_Abstract_Admin_Panel
		 */
		public function get_tab_instance( $tab = false ) {
			if ( ! $tab ) {
				return $this->tab;
			}

			$class_name = $this->get_tab_class_name( $tab );

			if ( ! $class_name || ! class_exists( $class_name ) ) {
				return null;
			}

			return new $class_name();
		}

		/**
		 * Returns namd of the class that mangas passed admin tab
		 *
		 * @param string|bool $tab Tab to print; false to use current tab.
		 * @return string|bool Class name; false when provided tab is invalid.
		 */
		public function get_tab_class_name( $tab = false ) {
			if ( ! $tab ) {
				$tab = $this->get_current_tab();
			}

			if ( ! $tab ) {
				return false;
			}

			$class_name = 'YITH_WCAF_' . ucfirst( $tab ) . '_Admin_Panel';

			return $class_name;
		}

		/**
		 * Returns url of a specific plugin's admin tab
		 *
		 * @param string|bool $tab     Tab you want to point to; false to use current tab.
		 * @param string|bool $subtab  Subtab you want to point to; false to use current tab.
		 * @param array       $args    Optional: additional arguments for the url.
		 *
		 * @return string|bool Tab url, false when invalid tab is provided.
		 */
		public function get_tab_url( $tab = false, $subtab = false, $args = array() ) {
			$available_tabs = array_keys( $this->get_available_tabs() );

			if ( ! $tab || ! in_array( $tab, $available_tabs, true ) ) {
				$tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : $available_tabs[0]; // phpcs:ignore WordPress.Security.NonceVerification
			}

			if ( ! $tab ) {
				return false;
			}

			if ( false === $subtab ) {
				$subtab = isset( $_GET['sub_tab'] ) ? sanitize_text_field( wp_unslash( $_GET['sub_tab'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
			}

			$args = array_filter(
				array_merge(
					$args,
					array(
						'tab'     => $tab,
						'sub_tab' => $subtab,
					)
				)
			);

			return add_query_arg( $args, $this->get_panel_url() );
		}

		/**
		 * Loads class that manges current screen, when available
		 *
		 * @return void
		 * @since 2.0.0
		 */
		public function load_tab() {
			if ( ! $this->is_own_screen() ) {
				return;
			}

			$class_name = $this->get_tab_class_name();

			if ( ! $class_name || ! class_exists( $class_name ) ) {
				return;
			}

			$this->tab = new $class_name();
		}

		/**
		 * Enqueue admin side scripts
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function enqueue() {
			$screen = get_current_screen();
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			// enqueue styles.
			if ( $this->is_own_screen() || in_array( $screen->id, array( 'shop_order', 'shop_coupon', 'user-edit', 'profile' ), true ) ) {
				wp_register_style( 'yith-wcaf-admin', YITH_WCAF_URL . "assets/css/yith-wcaf-admin{$suffix}.css", array( 'yith-plugin-fw-fields' ), YITH_WCAF::VERSION );

				/**
				 * DO_ACTION: yith_wcaf_before_admin_style_enqueue
				 *
				 * Allows to trigger some action before enqueueing the styles in the backend.
				 */
				do_action( 'yith_wcaf_before_admin_style_enqueue' );

				wp_enqueue_style( 'yith-wcaf-admin' );
			}

			// enqueue general scripts.
			if ( in_array( $screen->id, array( 'shop_order', 'shop_coupon', 'user-edit', 'profile' ), true ) ) {
				wp_register_script( 'yith-wcaf-admin', YITH_WCAF_URL . 'assets/js/admin/yith-wcaf.bundle' . $suffix . '.js', array( 'jquery', 'yith-plugin-fw-fields' ), YITH_WCAF::VERSION, true );

				/**
				 * DO_ACTION: yith_wcaf_before_admin_script_enqueue
				 *
				 * Allows to trigger some action before enqueueing the scripts in the backend.
				 */
				do_action( 'yith_wcaf_before_admin_script_enqueue' );

				wp_enqueue_script( 'yith-wcaf-admin' );
				wp_localize_script( 'yith-wcaf-admin', 'yith_wcaf', $this->get_global_localize() );
			}
		}

		/**
		 * Returns an array of variables to localize
		 *
		 * @param array $args Additional arguments to localize.
		 *
		 * @return array Variables to localize in a js object.
		 */
		public function get_global_localize( $args = array() ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_admin_global_localize
			 *
			 * Filters the array with the variables to localize into the plugin script.
			 *
			 * @param array $localize Array with variables to localize.
			 */
			return apply_filters(
				'yith_wcaf_admin_global_localize',
				array_merge_recursive(
					$args,
					array(
						'ajax_url' => admin_url( 'admin-ajax.php' ),
					)
				)
			);
		}

		/**
		 * Register affiliate panel as woocommerce screen
		 *
		 * @param mixed $screens Array of current woocommerce screens.
		 *
		 * @return mixed Filtered array of woocommerce screens
		 * @since 1.0.0
		 */
		public function register_woocommerce_screen( $screens ) {
			$screens = array_merge(
				$screens,
				$this->get_screen_ids()
			);

			return $screens;
		}

		/* === PLUGIN LINK METHODS === */

		/**
		 * Add plugin action links
		 *
		 * @param array $links Array of pugin links.
		 *
		 * @return array Filtered links array
		 * @since 1.0.0
		 */
		public function action_links( $links ) {
			$links = yith_add_action_links( $links, 'yith_wcaf_panel', defined( 'YITH_WCAF_PREMIUM' ), YITH_WCAF_SLUG );

			return $links;
		}

		/**
		 * Adds plugin row meta
		 *
		 * @param array  $new_row_meta_args Array of data to filter.
		 * @param array  $plugin_meta       Array of plugin meta.
		 * @param string $plugin_file       Path to init file.
		 * @param array  $plugin_data       Array of plugin data.
		 * @param string $status            Not used.
		 * @param string $init_file         Constant containing plugin int path.
		 *
		 * @return array Filtered array of plugin meta
		 * @since 1.0.0
		 */
		public function add_plugin_meta( $new_row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status, $init_file = 'YITH_WCAF_INIT' ) {
			if ( defined( $init_file ) && constant( $init_file ) === $plugin_file ) {
				$new_row_meta_args['slug'] = 'yith-woocommerce-affiliates';
			}

			return $new_row_meta_args;
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Admin class
 *
 * @return \YITH_WCAF_Admin
 * @since 1.0.0
 */
function YITH_WCAF_Admin() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Admin::get_instance();
}
