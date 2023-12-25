<?php
/**
 * Checkout Handler class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Checkout' ) ) {
	/**
	 * Checkout handler
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Checkout {

		use YITH_WCAF_Trait_Singleton;

		/**
		 * Constructor method
		 */
		public function __construct() {
			// register checkout handling.
			add_action( 'woocommerce_checkout_order_processed', array( $this, 'process_checkout' ), 10, 1 );
			add_action( 'woocommerce_rest_insert_shop_order_object', array( $this, 'process_checkout' ), 10, 1 );
			add_action( 'woocommerce_store_api_checkout_order_processed', array( $this, 'process_checkout' ), 10, 1 );

			// delete commissions for awaiting payment orders.
			add_action( 'woocommerce_after_checkout_validation', array( $this, 'delete_order_awaiting_payment_commissions' ) );

			// PayPal hotfix.
			add_filter( 'woocommerce_paypal_args', array( $this, 'paypal_return_url_hotfix' ), 10, 1 );
		}

		/* === CHECKOUT HANDLING METHODS === */

		/**
		 * Check if we should process checkout handling for a specific order just created
		 *
		 * @param WC_Order $order Order object.
		 * @param string   $token Affiliate token.
		 *
		 * @return bool Whether to process handling or not.
		 */
		public function should_process_checkout( $order, $token ) {
			if ( ! $token || ! $order || ! $order instanceof WC_Order ) {
				return false;
			}

			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $token );

			if ( ! $affiliate || ! $order ) {
				return false;
			}

			$affiliate_user = $affiliate->get_user();

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_avoid_auto_commission
			 *
			 * Filters whether to avoid auto-commissions for the affiliate.
			 *
			 * @param bool                $avoid_auto_commission Whether to avoid auto-commissions or not.
			 * @param YITH_WCAF_Affiliate $affiliate             Affiliate object.
			 */
			$avoid_auto_commissions = apply_filters( 'yith_wcaf_affiliate_avoid_auto_commission', yith_plugin_fw_is_true( get_option( 'yith_wcaf_commission_avoid_auto_referral', 'yes' ) ), $affiliate );

			if (
				$avoid_auto_commissions && (
					$order->get_customer_id() === $affiliate_user->ID ||
					$order->get_billing_email() === $affiliate_user->user_email
				)
			) {
				return false;
			}

			return YITH_WCAF_Affiliates()->is_valid_token( $token );
		}

		/**
		 * Process checkout handling, registering order meta data
		 *
		 * @param int|\WC_Order $order Order id or order object.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function process_checkout( $order ) {
			// retrieve current affiliate.
			$affiliate = YITH_WCAF_Session()->get_affiliate();

			// if no affiliate is set, return.
			if ( ! $affiliate ) {
				return;
			}

			// retrieve current token and order.
			$token = $affiliate->get_token();
			$order = wc_get_order( $order );

			// if no order is found, return.
			if ( ! $order ) {
				return;
			}

			$order_id = $order->get_id();

			if ( $this->should_process_checkout( $order, $token ) ) {
				/**
				 * DO_ACTION: yith_wcaf_process_checkout_with_affiliate
				 *
				 * Allows to trigger some action when an order is processed with an affiliate associated.
				 *
				 * @param WC_Order $order Order object.
				 * @param string   $token Affiliate token.
				 */
				do_action( 'yith_wcaf_process_checkout_with_affiliate', $order, $token );

				// create order commissions.
				YITH_WCAF_Orders()->create_commissions( $order_id, $token, YITH_WCAF_Session()->get_token_origin() );

				// register hit.
				$order->update_meta_data( '_yith_wcaf_click_id', YITH_WCAF_Clicks()->get_last_hit() );
				$order->save();
			}

			// delete token cookie.
			$this->delete_cookie_after_process();
		}

		/**
		 * Delete commissions and restore affiliate for orders awaiting payments
		 *
		 * @return void
		 * @since 1.0.5
		 */
		public function delete_order_awaiting_payment_commissions() {
			// retrieve order id.
			$order_id = (int) WC()->session->order_awaiting_payment;
			if ( ! $order_id ) {
				return;
			}

			// retrieve awaiting order object.
			$order = wc_get_order( $order_id );

			if ( ! $order || ! $order->has_status( array( 'pending', 'failed' ) ) ) {
				return;
			}

			// retrieve commissions for the order.
			$commissions = YITH_WCAF_Commissions()->get_commissions(
				array(
					'order_id' => $order_id,
				)
			);

			// delete each commission create for the order.
			if ( ! empty( $commissions ) ) {
				foreach ( $commissions as $commission ) {
					$commission->delete( true );
				}
			}

			// re-init affiliate class with session order store affiliate.
			$token = $order->get_meta( '_yith_wcaf_referral' );

			if ( $token ) {
				YITH_WCAF_Session()->set_token( $token );
			}
		}

		/**
		 * Delete cookie after an order is processed with current token
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function delete_cookie_after_process() {
			YITH_WCAF_Session()->delete_cookies();
		}

		/* === MISC === */

		/**
		 * Changes return url, to make sure that user would return to store with referral code, if there was any when he left
		 *
		 * @param array $args Array of arguments for PayPal processing.
		 * @return array Array of filtered arguments for PayPal processing.
		 */
		public function paypal_return_url_hotfix( $args ) {
			$token = YITH_WCAF_Session()->get_token();

			if ( $token && isset( $args['cancel_return'] ) ) {
				$ref_name = YITH_WCAF_Session()->get_ref_name();

				$args['cancel_return'] = add_query_arg( $ref_name, $token, $args['cancel_return'] );
			}

			return $args;
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Checkout class
 *
 * @return \YITH_WCAF_Checkout
 * @since 1.0.0
 */
function YITH_WCAF_Checkout() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Checkout::get_instance();
}
