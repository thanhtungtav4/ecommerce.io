<?php
/**
 * BACS Gateway class
 *
 * @author  YITH
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_BACS_Gateway' ) ) {
	/**
	 * BACS Gateway
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_BACS_Gateway extends YITH_WCAF_Abstract_Gateway {

		/**
		 * Constructor method
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			// init class attributes.
			$this->id = 'bacs';

			/**
			 * APPLY_FILTERS: yith_wcaf_direct_bank_transfer_label
			 *
			 * Filters the name of the <code>Direct bank/wire transfer</code> gateway.
			 *
			 * @param string $gateway_name Gateway name.
			 */
			$this->name = apply_filters( 'yith_wcaf_direct_bank_transfer_label', _x( 'Direct bank/wire transfer', '[ADMIN] Gateway name', 'yith-woocommerce-affiliates' ) );

			parent::__construct();
		}

		/**
		 * Init fields for the gateway
		 *
		 * @return void
		 */
		protected function init_fields() {
			$this->fields = array(
				'bacs_name'  => array(
					/**
					 * APPLY_FILTERS: yith_wcaf_account_name_label
					 *
					 * Filters the label of the account name field in the <code>Direct bank/wire transfer</code> gateway.
					 *
					 * @param string $label Field label.
					 */
					'label'   => apply_filters( 'yith_wcaf_account_name_label', _x( 'Account name', '[ADMIN] PayPal gateway affiliate settings.', 'yith-woocommerce-affiliates' ) ),
					'type'    => 'text',
					'desc'    => _x( 'Enter the name for the receiver\'s account.', '[ADMIN] PayPal gateway affiliate settings.', 'yith-woocommerce-affiliates' ),
					'default' => '',
				),
				'bacs_iban'  => array(
					/**
					 * APPLY_FILTERS: yith_wcaf_iban_label
					 *
					 * Filters the label of the IBAN field in the <code>Direct bank/wire transfer</code> gateway.
					 *
					 * @param string $label Field label.
					 */
					'label'   => apply_filters( 'yith_wcaf_iban_label', _x( 'IBAN', '[ADMIN] PayPal gateway affiliate settings.', 'yith-woocommerce-affiliates' ) ),
					'type'    => 'text',
					'desc'    => _x( 'Enter the IBAN code for the receiver\'s account.', '[ADMIN] PayPal gateway affiliate settings.', 'yith-woocommerce-affiliates' ),
					'default' => '',
				),
				'bacs_swift' => array(
					/**
					 * APPLY_FILTERS: yith_wcaf_swift_code_label
					 *
					 * Filters the label of the swift code field in the <code>Direct bank/wire transfer</code> gateway.
					 *
					 * @param string $label Field label.
					 */
					'label'   => apply_filters( 'yith_wcaf_swift_code_label', _x( 'Swift code', '[ADMIN] PayPal gateway affiliate settings.', 'yith-woocommerce-affiliates' ) ),
					'type'    => 'text',
					'desc'    => _x( 'Enter the Swift code for the receiver\'s account.', '[ADMIN] PayPal gateway affiliate settings.', 'yith-woocommerce-affiliates' ),
					'default' => '',
				),
			);
		}

		/* === PAYMENT METHODS === */

		/**
		 * Execute a mass payment
		 *
		 * @param int|int[] $payment_ids Array of registered payments to issue to paypal servers.
		 *
		 * @return mixed Array with operation status and messages
		 * @since 1.0.0
		 */
		public function process_payment( $payment_ids ) {
			// mass pay is not supported; retrieve first one.
			if ( is_array( $payment_ids ) ) {
				$payment_id = array_shift( $payment_ids );
			} else {
				$payment_id = (int) $payment_ids;
			}

			// translators: 1. Payment ID.
			$this->log( sprintf( _x( 'Trying to pay %s with BACS', '[ADMIN] Gateway logs.', 'yith-woocommerce-affiliates' ), $payment_id ) );

			// retrieve payment object.
			$payment = YITH_WCAF_Payment_Factory::get_payment( (int) $payment_id );

			if ( ! $payment ) {
				// translators: 1. Payment ID.
				$this->log( sprintf( _x( 'Unable to find payment object (#%s)', '[ADMIN] Gateway logs.', 'yith-woocommerce-affiliates' ), $payment_id ), 'error' );

				return array(
					'status'   => false,
					'messages' => _x( 'Payments failed', '[ADMIN] Gateway messages.', 'yith-woocommerce-affiliates' ),
				);
			}

			$affiliate = $payment->get_affiliate();

			if ( ! $affiliate ) {
				// translators: 1. Payment ID.
				$message = sprintf( _x( 'Unable to find affiliate for payment (#%s)', '[ADMIN] Gateway logs.', 'yith-woocommerce-affiliates' ), $payment_id );

				$this->log( $message, 'warning' );
				$payment->add_note( $message );

				return array(
					'status'   => false,
					'messages' => _x( 'Payments failed', '[ADMIN] Gateway messages.', 'yith-woocommerce-affiliates' ),
				);
			}

			if ( ! $this->can_pay_affiliate( $affiliate ) ) {
				// translators: 1. Affiliate ID.
				$message = sprintf( _x( 'Cannot pay affiliate #%s with this gateway', '[ADMIN] Gateway logs.', 'yith-woocommerce-affiliates' ), $affiliate->get_id() );

				$this->log( $message, 'warning' );
				$payment->add_note( $message );

				return array(
					'status'   => false,
					'messages' => _x( 'Payments failed', '[ADMIN] Gateway messages.', 'yith-woocommerce-affiliates' ),
				);
			}

			$payment_gateway_details = $payment->get_gateway_details();
			$payment_details         = $payment_gateway_details;

			if ( ! $payment_details ) {
				$payment_details = $affiliate->get_gateway_preferences( $this->id );
			}

			list( $account_name, $account_iban, $account_swift ) = yith_plugin_fw_extract( $payment_details, 'bacs_name', 'bacs_iban', 'bacs_swift' );

			if ( ! $account_name || ! $account_iban ) {
				// translators: 1. Payment ID. 2. Account name. 2. IBAN. 3. Swift code.
				$message = sprintf( _x( 'Missing required information for payment #%1$s (Name -> %2$s, IBAN -> %3$s, Swift -> %4$s)', '[ADMIN] Gateway logs.', 'yith-woocommerce-affiliates' ), $payment_id, $account_name, $account_iban, $account_swift );

				$this->log( $message, 'warning' );
				$payment->add_note( $message );

				return array(
					'status'   => false,
					'messages' => _x( 'Missing required payment information', '[ADMIN] Gateway messages.', 'yith-woocommerce-affiliates' ),
				);
			}

			$payment->add_note( _x( 'Payment marked as paid via BACS.', '[ADMIN] Payment notes.', 'yith-woocommerce-affiliates' ) );
			$payment->set_status( 'completed' );
			$payment->set_gateway_details(
				array(
					'bacs_name'  => $account_name,
					'bacs_iban'  => $account_iban,
					'bacs_swift' => $account_swift,
				)
			);
			$payment->save();

			/**
			 * DO_ACTION: yith_wcaf_payment_sent
			 *
			 * Allows to trigger some action when the payment is sent.
			 *
			 * @param YITH_WCAF_Payment $payment Payment object.
			 */
			do_action( 'yith_wcaf_payment_sent', $payment );

			// translators: 1. Payment ID.
			$this->log( sprintf( _x( 'Payment %s processed successfully with BACS', '[ADMIN] Gateway logs.', 'yith-woocommerce-affiliates' ), $payment_id ) );

			// returns a status array to the caller.
			return array(
				'status'   => true,
				'messages' => _x( 'Payments sent', '[ADMIN] Gateway messages.', 'yith-woocommerce-affiliates' ),
			);
		}
	}
}
