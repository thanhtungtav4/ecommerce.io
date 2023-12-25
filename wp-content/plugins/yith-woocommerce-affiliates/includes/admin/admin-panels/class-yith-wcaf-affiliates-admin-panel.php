<?php
/**
 * Affiliate admin panel handling
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliates_Admin_Panel' ) ) {
	/**
	 * Affiliates admin panel handling
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Affiliates_Admin_Panel extends YITH_WCAF_Abstract_Admin_Panel {

		/**
		 * Current tab name
		 *
		 * @var string
		 */
		protected $tab = 'affiliates';

		/**
		 * Stores name of the query var that identifies single item
		 *
		 * @var string
		 */
		protected $item_query_var = 'affiliate_id';

		/**
		 * Init Affiliates admin panel
		 */
		public function __construct() {
			// init screen options.
			$this->screen_options = array(
				'per_page' => array(
					'label'    => _x( 'Affiliates', '[ADMIN] Affiliates pagination label', 'yith-woocommerce-affiliates' ),
					'default'  => 20,
					'option'   => 'edit_affiliates_per_page',
					'sanitize' => 'intval',
				),
			);

			// init screen columns.
			$this->screen_columns = array(
				'affiliate'  => _x( 'Affiliate', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'id'         => _x( 'ID', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'token'      => _x( 'Token', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'rate'       => _x( 'Rate', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'earnings'   => _x( 'Earnings', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'paid'       => _x( 'Paid', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'balance'    => _x( 'Balance', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'click'      => _x( 'Visits', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'conversion' => _x( 'Conversion', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'conv_rate'  => _x( 'Conv. Rate', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'status'     => _x( 'Status', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
				'actions'    => _x( 'Action', '[ADMIN] Affiliate screen columns', 'yith-woocommerce-affiliates' ),
			);

			// init admin notices.
			$this->admin_notices = array(
				'error_adding_affiliate' => array(
					// translators: 1. Specific error message.
					'message' => _x( 'There was an error while creating the affiliate: %s.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
					'classes' => 'error',
				),
				'added_affiliate'        => array(
					'success' => _x( 'Affiliate created correctly.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
					'error'   => _x( 'There was an error while creating the affiliate.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
				),
				'updated_affiliates'     => array(
					'success' => array(
						'singular' => _x( 'Affiliate updated successfully.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo affiliates updated.
						'plural'   => _x( '%s affiliates updated successfully.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while updating affiliates.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
				),
				'deleted_affiliates'     => array(
					'success' => array(
						'singular' => _x( 'Affiliate deleted successfully.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo affiliates deleted.
						'plural'   => _x( '%s affiliates deleted successfully.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while deleting affiliates.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
				),
				'banned_affiliates'      => array(
					'success' => array(
						'singular' => _x( 'Affiliate banned successfully.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo affiliates banned.
						'plural'   => _x( '%s affiliates banned successfully.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while banning affiliates.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
				),
				'unbanned_affiliates'    => array(
					'success' => array(
						'singular' => _x( 'Affiliate unbanned successfully.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo affiliates unbanned.
						'plural'   => _x( '%s affiliates unbanned successfully.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while unbanning affiliates.', '[ADMIN] Affiliate screen notice message', 'yith-woocommerce-affiliates' ),
				),
			);

			// init admin actions.
			$this->admin_actions = array(
				'create_affiliate' => array( $this, 'create_affiliate_action' ),
				'change_status'    => array( $this, 'change_status_action' ),
			);

			// enqueue tab assets.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );

			// add affiliate modal.
			add_action( 'yith_wcaf_print_affiliates_list_tab', array( $this, 'render_add_modal' ), 20 );
			add_action( 'yith_wcaf_print_affiliates_list_tab', array( $this, 'render_ban_modal' ), 20 );
			add_action( 'yith_wcaf_print_affiliates_list_tab', array( $this, 'render_reject_modal' ), 20 );

			// default hidden columns.
			add_filter( 'default_hidden_columns', array( $this, 'get_default_hidden_columns' ) );

			// set get method.
			$this->set_get_form();

			add_action( 'yith_wcaf_print_affiliates_list_tab', array( $this, 'render_affiliates_list_tab' ) );

			// call parent constructor.
			parent::__construct();
		}

		/**
		 * Get the affiliates list table.
		 *
		 * @return YITH_WCAF_Affiliates_Admin_Table|YITH_WCAF_Affiliates_Admin_Table_Premium
		 */
		protected function get_affiliates_list_table() {
			require_once YITH_WCAF_INC . 'admin/admin-tables/class-yith-wcaf-affiliates-admin-table.php';

			return new YITH_WCAF_Affiliates_Admin_Table();
		}

		/**
		 * Render the Affiliates List tab.
		 */
		public function render_affiliates_list_tab() {
			$list_table = $this->get_affiliates_list_table();

			echo sprintf(
				'<a id="yith-wcaf-create-affiliate" href="#" class="yith-add-button">%s</a>',
				esc_html_x( 'Add affiliate', '[ADMIN] Add new affiliate button, in affiliates tab', 'yith-woocommerce-affiliates' )
			);

			$list_table->prepare_items();
			$list_table->views();
			?>
			<form method="get" id="yith-wcaf-list-table-form" class="yith-plugin-ui--wp-list-auto-h-scroll">
				<?php $list_table->display(); ?>
			</form>
			<script type="text/javascript">
				( function () {
					var heading = document.querySelector( '.yith-plugin-fw__panel__content__page__title' ),
						button  = document.getElementById( 'yith-wcaf-create-affiliate' );
					heading && heading.parentNode.insertBefore( button, heading.nextSibling);
				} )();
			</script>
			<?php
		}

		/* === ADMIN ACTIONS === */

		/**
		 * Register a user as an enabled affiliate (admin panel action handling)
		 *
		 * @return array Array of parameters to be added to return url.
		 * @since 1.0.0
		 */
		public function create_affiliate_action() {
			// nonce verification is performed by \YITH_WCAF_Admin_Actions::process_action.
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$mode       = isset( $_REQUEST['mode'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['mode'] ) ) : 'add_affiliate';
			$customer   = isset( $_REQUEST['customer'] ) ? intval( $_REQUEST['customer'] ) : 0;
			$user_login = isset( $_REQUEST['user_login'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['user_login'] ) ) : '';
			$email      = isset( $_REQUEST['email'] ) ? sanitize_email( wp_unslash( $_REQUEST['email'] ) ) : '';
			$role       = isset( $_REQUEST['role'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['role'] ) ) : '';
			$password   = isset( $_REQUEST['pass1'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['pass1'] ) ) : '';
			$custom_psw = isset( $_REQUEST['use_custom_password'] ) ? (bool) $_REQUEST['use_custom_password'] : false;
			$notify_usr = isset( $_REQUEST['send_user_notification'] );
			// phpcs:enable WordPress.Security.NonceVerification.Recommended

			if ( 'add_affiliate' === $mode && ! $customer ) {
				return array(
					'error_adding_affiliate' => _x( 'You must select a valid user to add as affiliate', '[ADMIN] Error message for affiliate creation', 'yith-woocommerce-affiliates' ),
				);
			} elseif ( 'create_affiliate' === $mode ) {
				if ( ! $user_login ) {
					return array(
						'error_adding_affiliate' => _x( 'You must enter a valid username for the affiliate', '[ADMIN] Error message for affiliate creation', 'yith-woocommerce-affiliates' ),
					);
				}

				if ( ! $email ) {
					return array(
						'error_adding_affiliate' => _x( 'You must enter a valid email for the affiliate', '[ADMIN] Error message for affiliate creation', 'yith-woocommerce-affiliates' ),
					);
				}

				if ( ! $role || ! in_array( $role, array_keys( get_editable_roles() ), true ) ) {
					return array(
						'error_adding_affiliate' => _x( 'You must select a valid role for the affiliate', '[ADMIN] Error message for affiliate creation', 'yith-woocommerce-affiliates' ),
					);
				}

				if ( $custom_psw && ! $password ) {
					return array(
						'error_adding_affiliate' => _x( 'You must enter a valid password for the affiliate', '[ADMIN] Error message for affiliate creation', 'yith-woocommerce-affiliates' ),
					);
				} elseif ( ! $custom_psw ) {
					$password = wp_generate_password( 24 );
				}

				add_filter( 'woocommerce_email_enabled_customer_new_account', $notify_usr ? '__return_true' : '__return_false' );

				$customer = wc_create_new_customer(
					$email,
					$user_login,
					$password
				);

				remove_filter( 'woocommerce_email_enabled_customer_new_account', $notify_usr ? '__return_true' : '__return_false' );
			}

			if ( is_wp_error( $customer ) ) {
				return array(
					'error_adding_affiliate' => wp_strip_all_tags( $customer->get_error_message() ),
				);
			}

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_user_id( $customer );

			// create new affiliate, assign user.
			if ( ! $affiliate ) {
				$affiliate = new YITH_WCAF_Affiliate();
				$affiliate->set_user_id( $customer );
			}

			$affiliate->set_status( 'enabled' );

			// save the application date also when creating a brand new user.
			$affiliate->update_meta_data( 'application_date', current_time( 'mysql' ) );

			// set user role when required.
			if ( 'create_affiliate' === $mode && 'customer' !== $role ) {
				$affiliate->get_user()->add_role( $role );
			}

			// save brand new affiliate and get id.
			$res = $affiliate->save();

			/**
			 * DO_ACTION: yith_wcaf_affiliate_saved
			 *
			 * Allows to trigger some action after saving the affiliate when it is added manually.
			 *
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			do_action( 'yith_wcaf_affiliate_saved', $affiliate );

			return array(
				'added_affiliate' => $res,
			);
		}

		/**
		 * Handle affiliate user status change
		 *
		 * @return array Array of parameters to be added to return url.
		 * @since 1.0.0
		 */
		public function change_status_action() {
			// nonce verification is performed by \YITH_WCAF_Admin_Actions::process_action.
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$affiliate_id = isset( $_REQUEST['affiliate_id'] ) ? intval( $_REQUEST['affiliate_id'] ) : 0;
			$new_status   = isset( $_REQUEST['status'] ) && in_array( $_REQUEST['status'], array( 'enabled', 'disabled', 'banned', 'unbanned' ), true ) ? sanitize_text_field( wp_unslash( $_REQUEST['status'] ) ) : '';
			$message      = isset( $_REQUEST['message'] ) ? wp_kses_post( wp_unslash( $_REQUEST['message'] ) ) : '';
			// phpcs:enable WordPress.Security.NonceVerification.Recommended

			if ( ! $affiliate_id || ! $new_status ) {
				return array(
					'updated_affiliates' => 0,
				);
			}

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_id( $affiliate_id );

			if ( ! $affiliate ) {
				return array(
					'updated_affiliates' => 0,
				);
			}

			if ( in_array( $new_status, array( 'banned', 'unbanned' ), true ) ) {
				// ban/unban affiliates.
				$banned      = 'banned' === $new_status;
				$ban_message = '';

				if ( $banned ) {
					$use_global_message = 'yes' === get_option( 'yith_wcaf_enable_global_ban_message' );
					$ban_message        = $use_global_message ? get_option( 'yith_wcaf_ban_global_message' ) : $message;
				}

				$affiliate->set_banned( $banned );
				$affiliate->update_meta_data( 'ban_message', $ban_message );
				$affiliate->save();
			} elseif ( in_array( $new_status, array( 'enabled', 'disabled' ), true ) ) {
				// enable/disable affiliates.
				$rejected       = 'disabled' === $new_status;
				$reject_message = '';

				if ( $rejected ) {
					$use_global_message = 'yes' === get_option( 'yith_wcaf_enable_global_reject_message' );
					$reject_message     = $use_global_message ? get_option( 'yith_wcaf_ban_reject_global_message' ) : $message;
				}

				$affiliate->set_status( $new_status );
				$affiliate->update_meta_data( 'reject_message', $reject_message );
				$affiliate->save();
			}

			return array(
				'updated_affiliates' => 1,
			);
		}

		/* === PANEL HANDLING METHODS === */

		/**
		 * Returns an array of localized arguments for current panel
		 *
		 * @return array Array of localized variables specific to current panel.
		 */
		public function get_localize() {
			return array(
				'nonces'                        => array(
					'create_affiliate' => wp_create_nonce( 'create_affiliate' ),
					'get_referral_url' => wp_create_nonce( 'get_referral_url' ),
				),
				'labels'                        => array(
					'ban_modal_title'         => _x( 'Ban affiliate', '[ADMIN] Ban affiliate modal', 'yith-woocommerce-affiliates' ),
					'reject_modal_title'      => _x( 'Reject affiliate', '[ADMIN] Ban affiliate modal', 'yith-woocommerce-affiliates' ),
					'generic_confirm_title'   => _x( 'Confirm', '[ADMIN] Confirm modal', 'yith-woocommerce-affiliates' ),
					'generic_confirm_message' => _x( 'This operation cannot be undone. Are you sure you want to proceed?', '[ADMIN] Confirm modal', 'yith-woocommerce-affiliates' ),
				),
				'ban_global_message_enabled'    => false,
				'reject_global_message_enabled' => false,
			);
		}

		/**
		 * Filters columns hidden by default, to add ones for current screen
		 *
		 * @param array $defaults Array of columns hidden by default.
		 *
		 * @return array Hidden columns.
		 */
		public function get_default_hidden_columns( $defaults ) {
			$defaults = array_merge(
				$defaults,
				array(
					'paid',
					'refunds',
					'click',
					'conversion',
				)
			);

			return $defaults;
		}

		/**
		 * Render template for "Add affiliate" modal
		 *
		 * @return void.
		 */
		public function render_add_modal() {
			include YITH_WCAF_DIR . 'views/affiliates/add-modal.php';
		}

		/**
		 * Render template for "Ban affiliate" modal
		 *
		 * @return void.
		 */
		public function render_ban_modal() {
			include YITH_WCAF_DIR . 'views/affiliates/ban-modal.php';
		}

		/**
		 * Render template for "Reject affiliate" modal
		 *
		 * @return void.
		 */
		public function render_reject_modal() {
			include YITH_WCAF_DIR . 'views/affiliates/reject-modal.php';
		}

		/* === BULK ACTIONS === */

		/**
		 * Process bulk actions for current view.
		 *
		 * @return array Array of parameters to be added to return url.
		 */
		public function process_bulk_actions() {
			// nonce was already verified, so there is no need to verify it again.
			// phpcs:disable WordPress.Security.NonceVerification
			$updated      = 0;
			$return_param = 'updated_affiliates';

			$current_action = $this->get_current_action();
			$affiliates     = isset( $_REQUEST['affiliates'] ) ? array_map( 'intval', $_REQUEST['affiliates'] ) : false;

			if ( ! $current_action || ! $affiliates ) {
				return array();
			}

			$affiliates = new YITH_WCAF_Affiliates_Collection( $affiliates );

			switch ( $current_action ) {
				case 'delete':
					$return_param = 'deleted_affiliates';

					foreach ( $affiliates as $affiliate ) {
						$affiliate->delete();
						$updated ++;
					}
					break;
				case 'enable':
					foreach ( $affiliates as $affiliate ) {
						$affiliate->set_status( 'enabled' );
						$affiliate->save();

						$updated ++;
					}
					break;
				case 'disable':
					$use_global_message = 'yes' === get_option( 'yith_wcaf_enable_global_reject_message' );
					$reject_message     = isset( $_REQUEST['message'] ) ? wp_kses_post( wp_unslash( $_REQUEST['message'] ) ) : false;
					$reject_message     = $use_global_message ? get_option( 'yith_wcaf_ban_reject_global_message' ) : $reject_message;

					foreach ( $affiliates as $affiliate ) {
						$affiliate->set_status( 'disabled' );
						$affiliate->update_meta_data( 'reject_message', $reject_message );
						$affiliate->save();

						$updated ++;
					}
					break;
				case 'ban':
					$use_global_message = 'yes' === get_option( 'yith_wcaf_enable_global_ban_message' );
					$ban_message        = isset( $_REQUEST['message'] ) ? wp_kses_post( wp_unslash( $_REQUEST['message'] ) ) : false;
					$ban_message        = $use_global_message ? get_option( 'yith_wcaf_ban_global_message' ) : $ban_message;
					$return_param       = 'banned_affiliates';

					foreach ( $affiliates as $affiliate ) {
						$affiliate->ban();
						$affiliate->update_meta_data( 'ban_message', $ban_message );
						$affiliate->save();

						$updated ++;
					}
					break;
				case 'unban':
					$return_param = 'unbanned_affiliates';

					foreach ( $affiliates as $affiliate ) {
						$affiliate->unban();
						$affiliate->save();

						$updated ++;
					}
					break;
			}

			return array(
				$return_param => $updated,
			);
			// phpcs:enable WordPress.Security.NonceVerification
		}
	}
}
