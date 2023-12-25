<?php
/**
 * Payments admin panel handling
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Payments_Admin_Panel' ) ) {
	/**
	 * Affiliates admin panel handling
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Payments_Admin_Panel extends YITH_WCAF_Abstract_Admin_Panel {

		/**
		 * Current tab name
		 *
		 * @var string
		 */
		protected $tab = 'payments';

		/**
		 * Stores name of the query var that identifies single item
		 *
		 * @var string
		 */
		protected $item_query_var = 'payment_id';

		/**
		 * Init Commissions admin panel
		 */
		public function __construct() {
			// init screen options.
			$this->screen_options = array(
				'per_page' => array(
					'label'    => _x( 'Payments', '[ADMIN] Payments pagination label', 'yith-woocommerce-affiliates' ),
					'default'  => 20,
					'option'   => 'edit_payments_per_page',
					'sanitize' => 'intval',
				),
			);

			// init screen columns.
			$this->screen_columns = array(
				'id'            => _x( 'ID', '[ADMIN] Payments screen columns', 'yith-woocommerce-affiliates' ),
				'affiliate'     => _x( 'Affiliate', '[ADMIN] Payments screen columns', 'yith-woocommerce-affiliates' ),
				'payment_email' => _x( 'Payment email', '[ADMIN] Payments screen columns', 'yith-woocommerce-affiliates' ),
				'amount'        => _x( 'Amount', '[ADMIN] Payments screen columns', 'yith-woocommerce-affiliates' ),
				'created_at'    => _x( 'Created on', '[ADMIN] Payments screen columns', 'yith-woocommerce-affiliates' ),
				'status'        => _x( 'Status', '[ADMIN] Payments screen columns', 'yith-woocommerce-affiliates' ),
				'actions'       => _x( 'Action', '[ADMIN] Commissions screen columns', 'yith-woocommerce-affiliates' ),
			);

			// init admin notices.
			$this->admin_notices = array(
				'updated_payments' => array(
					'success' => array(
						'singular' => _x( 'Payment record updated successfully.', '[ADMIN] Payments action messages', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo commissions updated.
						'plural'   => _x( '%s payment records updated successfully.', '[ADMIN] Payments action messages', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while updating payment records.', '[ADMIN] Payments action messages', 'yith-woocommerce-affiliates' ),
				),
				'deleted_payments' => array(
					'success' => array(
						'singular' => _x( 'Payment record deleted successfully.', '[ADMIN] Payments action messages', 'yith-woocommerce-affiliates' ),
						// translators: 1. number fo commissions updated.
						'plural'   => _x( '%s payment records deleted successfully.', '[ADMIN] Payments action messages', 'yith-woocommerce-affiliates' ),
					),
					'error'   => _x( 'There was an error while deleting payment records.', '[ADMIN] Payments action messages', 'yith-woocommerce-affiliates' ),
				),
				'payment_error'    => array(
					// translators: 1. Specific error messages.
					'message' => _x( 'An error occurred while processing the payment: %s.', '[ADMIN] Payments action messages', 'yith-woocommerce-affiliates' ),
					'classes' => 'error',
				),
				'payments_done'    => array(
					// translators: 1. List of commission ids.
					'message' => _x( 'Payment %s issued successfully.', '[ADMIN] Payments action messages', 'yith-woocommerce-affiliates' ),
					'classes' => 'updated',
				),
				'payments_failed'  => array(
					// translators: 1. List of commission ids.
					'message' => _x( 'Payment %s could not be completed.', '[ADMIN] Payments action messages', 'yith-woocommerce-affiliates' ),
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

			// set get method.
			$this->set_get_form();

			add_action( 'yith_wcaf_print_payments_list_tab', array( $this, 'render_list_table' ) );

			// call parent constructor.
			parent::__construct();
		}

		/**
		 * Get the affiliates list table.
		 *
		 * @return YITH_WCAF_Payments_Admin_Table
		 */
		protected function get_payments_list_table() {
			return new YITH_WCAF_Payments_Admin_Table();
		}

		/**
		 * Render the Affiliates List tab.
		 */
		public function render_list_table() {
			$list_table = $this->get_payments_list_table();

			$list_table->prepare_items();
			$list_table->views();
			?>
			<form method="get" id="yith-wcaf-list-table-form" class="yith-plugin-ui--wp-list-auto-h-scroll">
				<?php $list_table->display(); ?>
			</form>
			<?php
		}

		/**
		 * Get current tab url
		 *
		 * @param array $args Arguments to add to the url.
		 *
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
			return apply_filters( 'yith_wcaf_admin_tab_url', add_query_arg( $args, YITH_WCAF_Admin()->get_tab_url( 'commissions', 'commissions-payments', $args ) ) );
		}

		/* === ADMIN ACTIONS === */

		/**
		 * Handle payment status change triggered via the panel
		 *
		 * @return array Array of parameters to be added to return url.
		 */
		public function change_status_action() {
			// nonce verification is performed by \YITH_WCAF_Admin_Actions::process_action.
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$payment_id = isset( $_REQUEST['payment_id'] ) ? intval( $_REQUEST['payment_id'] ) : 0;
			$new_status = isset( $_REQUEST['status'] ) && in_array( $_REQUEST['status'], wp_list_pluck( YITH_WCAF_Payments::get_available_statuses(), 'slug' ), true ) ? sanitize_text_field( wp_unslash( $_REQUEST['status'] ) ) : '';
			// phpcs:enable WordPress.Security.NonceVerification.Recommended

			if ( ! $payment_id || ! $new_status ) {
				return array(
					'updated_payments' => 0,
				);
			}

			$payment = YITH_WCAF_Payment_Factory::get_payment( $payment_id );

			if ( ! $payment ) {
				return array(
					'updated_payments' => 0,
				);
			}

			$user       = wp_get_current_user();
			$old_status = $payment->get_formatted_status();

			// translators: 1. Old status. 2. New status. 3. Username.
			$message = sprintf( _x( 'Status changed from %1$s to %2$s by %3$s.', '[ADMIN] Status change note', 'yith-woocommerce-affiliates' ), $old_status, YITH_WCAF_Payments::get_readable_status( $new_status ), $user->user_login );

			$payment->set_status( $new_status, $message );
			$payment->save();

			return array(
				'updated_payments' => 1,
			);
		}

		/**
		 * Handle payment pay action, triggered via the panel
		 *
		 * @return array Array of parameters to be added to return url.
		 */
		public function pay_action() {
			// nonce verification is performed by \YITH_WCAF_Admin_Actions::process_action.
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$payment_id = isset( $_REQUEST['payment_id'] ) ? intval( $_REQUEST['payment_id'] ) : 0;
			$gateway_id = isset( $_REQUEST['gateway'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['gateway'] ) ) : '';
			// phpcs:enable WordPress.Security.NonceVerification.Recommended

			if ( ! $payment_id || ! $gateway_id || ! YITH_WCAF_Gateways::is_available_gateway( $gateway_id ) ) {
				return array(
					'paid_commissions' => 0,
				);
			}

			$gateway = YITH_WCAF_Gateways::get_gateway( $gateway_id );

			$res = $gateway->pay( $payment_id );

			if ( ! $res['status'] ) {
				$errors = is_array( $res['messages'] ) ? implode( ', ', $res['messages'] ) : $res['messages'];

				return array(
					'payment_failed' => rawurlencode( $errors ),
				);
			} elseif ( empty( $res['cannot_be_paid'] ) ) {
				return array(
					'payments_done' => $payment_id,
				);
			} else {
				return array(
					'payments_failed' => $payment_id,
				);
			}
		}

		/* === PANEL HANDLING METHODS === */

		/**
		 * Returns variable to localize for current panel
		 *
		 * @return array Array of variables to localize.
		 */
		public function get_localize() {
			return array(
				'labels' => array(
					'generic_confirm_title'   => _x( 'Confirm', '[ADMIN] Confirm modal', 'yith-woocommerce-affiliates' ),
					'generic_confirm_message' => _x( 'This operation cannot be undone. Are you sure you want to proceed?', '[ADMIN] Confirm modal', 'yith-woocommerce-affiliates' ),
				),
			);
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
			$return_param = 'updated_payments';

			if ( ! $this->should_process_bulk_actions() ) {
				return array();
			}

			$user           = wp_get_current_user();
			$current_action = $this->get_current_action();
			$payments       = isset( $_REQUEST['payments'] ) ? array_map( 'intval', $_REQUEST['payments'] ) : false;

			if ( ! $current_action || ! $payments ) {
				return array();
			}

			$payments = new YITH_WCAF_Payments_Collection( $payments );

			if ( preg_match( '^pay_via_([a-zA-Z_-]*)$^', $current_action, $matches ) ) {
				$current_action = 'pay';
				$gateway_id     = isset( $matches[1] ) ? $matches[1] : false;
			}

			switch ( $current_action ) {
				case 'switch_to_completed':
				case 'switch_to_on-hold':
				case 'switch_to_cancelled':
					$new_status = str_replace( 'switch_to_', '', $current_action );

					foreach ( $payments as $payment ) {
						// translators: 1. Old status. 2. New status. 3. Username.
						$message = sprintf( _x( 'Status changed from %1$s to %2$s by %3$s.', '[ADMIN] Status change note', 'yith-woocommerce-affiliates' ), $payment->get_formatted_status(), YITH_WCAF_Payments::get_readable_status( $new_status ), $user->user_login );

						$payment->set_status( $new_status, $message );
						$payment->save();
						$updated ++;
					}
					break;
				case 'delete':
					$return_param = 'deleted_payments';

					foreach ( $payments as $payment ) {
						$payment->delete( true );
						$updated ++;
					}
					break;
				case 'pay':
					if ( ! YITH_WCAF_Gateways::is_available_gateway( $gateway_id ) ) {
						return array();
					}

					$gateway = YITH_WCAF_Gateways::get_gateway( $gateway_id );
					$to_pay  = array();

					foreach ( $payments as $payment ) {
						if ( ! $payment->can_be_paid() ) {
							continue;
						}

						$to_pay[] = $payment->get_id();
					}

					$res = $gateway->pay( $to_pay );

					if ( ! $res['status'] ) {
						$errors = is_array( $res['messages'] ) ? implode( ', ', $res['messages'] ) : $res['messages'];

						return array(
							'payment_error' => rawurlencode( $errors ),
						);
					} else {
						return array_filter(
							array(
								'payments_done'   => implode( ', ', isset( $res['can_be_paid'] ) ? $res['can_be_paid'] : array() ),
								'payments_failed' => implode( ', ', isset( $res['cannot_be_paid'] ) ? $res['cannot_be_paid'] : array() ),
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
