<?php
/**
 * Commissions admin panel handling
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Commissions_Admin_Panel' ) ) {
	/**
	 * Affiliates admin panel handling
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Commissions_Admin_Panel extends YITH_WCAF_Abstract_Admin_Panel {

		/**
		 * Current tab name
		 *
		 * @var string
		 */
		protected $tab = 'commissions';

		/**
		 * Stores name of the query var that identifies single item
		 *
		 * @var string
		 */
		protected $item_query_var = 'commission_id';

		/**
		 * Init Commissions admin panel
		 */
		public function __construct() {
			// init screen options.
			$this->screen_options = array(
				'per_page' => array(
					'label'    => _x( 'Commissions', '[ADMIN] Commissions pagination label', 'yith-woocommerce-affiliates' ),
					'default'  => 20,
					'option'   => 'edit_commissions_per_page',
					'sanitize' => 'intval',
				),
			);

			// init screen columns.
			$this->screen_columns = array(
				'id'              => _x( 'ID', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'date'            => _x( 'Date', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'affiliate'       => _x( 'Affiliate', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'order'           => _x( 'Order', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'product'         => _x( 'Product', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'line_item_total' => _x( 'Total', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'rate'            => _x( 'Rate', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'amount'          => _x( 'Commission', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'category'        => _x( 'Category', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'payments'        => _x( 'Payment', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'status'          => _x( 'Status', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
				'actions'         => _x( 'Action', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
			);

			// init admin notices.
			$this->admin_notices = array(
				'updated_commissions'       => array(
					'success' => array(
						'singular' => _x( 'Commission updated successfully.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo commissions updated.
						'plural'   => _x( '%s commissions updated successfully.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while updating commissions.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
				),
				'trashed_commissions'       => array(
					'success' => array(
						'singular' => _x( 'Commission moved to trash successfully.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo commissions updated.
						'plural'   => _x( '%s commissions moved to trash successfully.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while moving commissions to the trash.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
				),
				'restored_commissions'      => array(
					'success' => array(
						'singular' => _x( 'Commission restored successfully.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo commissions updated.
						'plural'   => _x( '%s commissions restored successfully.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while restoring commissions.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
				),
				'deleted_commissions'       => array(
					'success' => array(
						'singular' => _x( 'Commission deleted successfully.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo commissions updated.
						'plural'   => _x( '%s commissions deleted successfully.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while deleting commissions.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
				),
				'commission_payment_failed' => array(
					// translators: 1. Specific error messages.
					'message' => _x( 'An error occurred while processing the payment: %s.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
					'classes' => 'error',
				),
				'commissions_paid'          => array(
					// translators: 1. List of commission ids.
					'message' => _x( 'Commission(s) %s paid successfully.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
					'classes' => 'updated',
				),
				'commissions_unpaid'        => array(
					// translators: 1. List of commission ids.
					'message' => _x( 'Commission(s) %s could not be paid.', '[ADMIN] Commissions action messages', 'yith-woocommerce-affiliates' ),
					'classes' => 'error',
				),
			);

			// init admin actions.
			$this->admin_actions = array(
				'change_status' => array( $this, 'change_status_action' ),
				'pay'           => array( $this, 'pay_action' ),
			);

			// enqueue tab assets.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );

			// default hidden columns.
			add_filter( 'default_hidden_columns', array( $this, 'get_default_hidden_columns' ) );

			// set get method.
			$this->set_get_form();

			add_action( 'yith_wcaf_print_commissions_list_tab', array( $this, 'render_list_table' ) );

			// call parent constructor.
			parent::__construct();
		}


		/**
		 * Get affiliates commissions table.
		 *
		 * @return YITH_WCAF_Commissions_Admin_Table
		 */
		protected function get_list_table() {
			return new YITH_WCAF_Commissions_Admin_Table();
		}

		/**
		 * Render the Affiliates Commissions List tab.
		 */
		public function render_list_table(){
			$list_table = $this->get_list_table();

			$list_table->prepare_items();
			$list_table->views();
			?>
			<form method="get" id="yith-wcaf-list-table-form" class="yith_wcaf_commissions yith-plugin-ui--wp-list-auto-h-scroll">
				<?php $list_table->display(); ?>
			</form>
			<?php
		}

		/* === ADMIN ACTIONS === */

		/**
		 * Handle commission status change triggered via the panel
		 *
		 * @return array Array of parameters to be added to return url.
		 */
		public function change_status_action() {
			// nonce verification is performed by \YITH_WCAF_Admin_Actions::process_action.
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$commission_id = isset( $_REQUEST['commission_id'] ) ? intval( $_REQUEST['commission_id'] ) : 0;
			$new_status    = isset( $_REQUEST['status'] ) && in_array( $_REQUEST['status'], wp_list_pluck( YITH_WCAF_Commissions::get_available_statuses(), 'slug' ), true ) ? sanitize_text_field( wp_unslash( $_REQUEST['status'] ) ) : '';
			// phpcs:enable WordPress.Security.NonceVerification.Recommended

			if ( ! $commission_id || ! $new_status ) {
				return array(
					'updated_commissions' => 0,
				);
			}

			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return array(
					'updated_commissions' => 0,
				);
			}

			$user       = wp_get_current_user();
			$old_status = $commission->get_formatted_status();

			// translators: 1. Old status. 2. New status. 3. Username.
			$message = sprintf( _x( 'Status changed from %1$s to %2$s by %3$s.', '[ADMIN] Status change note', 'yith-woocommerce-affiliates' ), $old_status, YITH_WCAF_Commissions::get_readable_status( $new_status ), $user->user_login );

			$commission->set_status( $new_status, $message );
			$commission->save();

			return array(
				'updated_commissions' => 1,
			);
		}

		/**
		 * Handle commission pay action, triggered via the panel
		 *
		 * @return array Array of parameters to be added to return url.
		 */
		public function pay_action() {
			// nonce verification is performed by \YITH_WCAF_Admin_Actions::process_action.
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$commission_id = isset( $_REQUEST['commission_id'] ) ? intval( $_REQUEST['commission_id'] ) : 0;
			$gateway       = isset( $_REQUEST['gateway'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['gateway'] ) ) : '';
			// phpcs:enable WordPress.Security.NonceVerification.Recommended

			if ( ! $commission_id ) {
				return array(
					'paid_commissions' => 0,
				);
			}

			$gateway = YITH_WCAF_Gateways::is_available_gateway( $gateway ) ? $gateway : false;
			$res     = YITH_WCAF_Payments()->register_payment( $commission_id, true, $gateway );

			if ( ! $res['status'] ) {
				$errors = is_array( $res['messages'] ) ? implode( ', ', $res['messages'] ) : $res['messages'];

				return array(
					'commission_payment_failed' => rawurlencode( $errors ),
				);
			} elseif ( empty( $res['cannot_be_paid'] ) ) {
				return array(
					'commissions_paid' => $commission_id,
				);
			} else {
				return array(
					'commissions_unpaid' => $commission_id,
				);
			}
		}

		/* === PANEL HANDLING METHODS === */

		/**
		 * Filters columns hidden by default, to add ones for current screen
		 *
		 * @param array $defaults Array of columns hidden by default.
		 * @return array Hidden columns.
		 */
		public function get_default_hidden_columns( $defaults ) {
			$defaults = array_merge(
				$defaults,
				array(
					'category',
					'payments',
				)
			);

			return $defaults;
		}

		/* === BULK ACTIONS === */

		/**
		 * Process bulk actions for current view.
		 *
		 * @return array Array of parameters to be added to redirect uri.
		 */
		public function process_bulk_actions() {
			// nonce was already verified, so there is no need to verify it again.
			// phpcs:disable WordPress.Security.NonceVerification
			$updated      = 0;
			$return_param = 'updated_commissions';

			if ( ! $this->should_process_bulk_actions() ) {
				return array();
			}

			$user           = wp_get_current_user();
			$current_action = $this->get_current_action();
			$commissions    = isset( $_REQUEST['commissions'] ) ? array_map( 'intval', $_REQUEST['commissions'] ) : false;

			if ( ! $current_action || ! $commissions ) {
				return array();
			}

			$commissions = new YITH_WCAF_Commissions_Collection( $commissions );

			// check if we're processing custom payment action, and set required variables.
			if ( preg_match( '^pay_via_([a-zA-Z_-]*)$^', $current_action, $matches ) ) {
				$current_action = 'pay';
				$gateway_id     = isset( $matches[1] ) ? $matches[1] : false;
			}

			// process other actions.
			switch ( $current_action ) {
				case 'switch_to_pending':
				case 'switch_to_not-confirmed':
				case 'switch_to_cancelled':
				case 'switch_to_refunded':
					$new_status = str_replace( 'switch_to_', '', $current_action );

					foreach ( $commissions as $commission ) {
						// translators: 1. Old status. 2. New status. 3. Username.
						$message = sprintf( _x( 'Status changed from %1$s to %2$s by %3$s.', '[ADMIN] Status change note', 'yith-woocommerce-affiliates' ), $commission->get_formatted_status(), YITH_WCAF_Commissions::get_readable_status( $new_status ), $user->user_login );

						$commission->set_status( $new_status, $message );
						$commission->save();
						$updated ++;
					}
					break;
				case 'move_to_trash':
					$return_param = 'trashed_commissions';

					// translators: 1. Current user login.
					$message = sprintf( _x( 'Moved to the trash by %s.', '[ADMIN] Status change note', 'yith-woocommerce-affiliates' ), $user->user_login );

					foreach ( $commissions as $commission ) {
						$commission->trash( $message );
						$commission->save();
						$updated ++;
					}
					break;
				case 'restore':
					$return_param = 'restored_commissions';

					foreach ( $commissions as $commission ) {
						if ( ! $commission->is_trashed() ) {
							continue;
						}

						$commission->restore();

						// translators: 1. Current user login. 2. New commission status.
						$message = sprintf( _x( '%1$s restored this item; the system automatically assigned %2$s status.', '[ADMIN] Status change note', 'yith-woocommerce-affiliates' ), $user->user_login, YITH_WCAF_Commissions::get_readable_status( $commission->get_status() ) );
						$commission->add_note( $message );
						$commission->save();
						$updated ++;
					}
					break;
				case 'delete':
					$return_param = 'deleted_commissions';

					foreach ( $commissions as $commission ) {
						$commission->delete( true );
						$updated ++;
					}
					break;
				case 'pay':
					$proceed = ! ! $gateway_id;

					$res = YITH_WCAF_Payments()->register_payment( $commissions->get_ids(), $proceed, $gateway_id );

					if ( ! $res['status'] ) {
						$errors = is_array( $res['messages'] ) ? implode( ', ', $res['messages'] ) : $res['messages'];

						return array(
							'commission_payment_failed' => rawurlencode( $errors ),
						);
					} else {
						return array_filter(
							array(
								'commissions_paid'   => implode( ', ', $res['can_be_paid'] ),
								'commissions_unpaid' => implode( ', ', $res['cannot_be_paid'] ),
							)
						);
					}
			}

			return array(
				$return_param => $updated,
			);
			// phpcs:enable WordPress.Security.NonceVerification
		}
	}
}
