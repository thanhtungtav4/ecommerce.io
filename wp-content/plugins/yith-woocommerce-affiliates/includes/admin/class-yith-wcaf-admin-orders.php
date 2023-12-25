<?php
/**
 * Applies changes to default WooCommerce's Order view
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Admin_Orders' ) ) {
	/**
	 * Class that applies changes to Order edit view.
	 */
	class YITH_WCAF_Admin_Orders {

		/**
		 * Init class
		 *
		 * @return void
		 */
		public static function init() {
			add_filter( 'woocommerce_hidden_order_itemmeta', array( self::class, 'hide_order_item_meta' ) );
		}

		/**
		 * Hide order item meta related to the plugin
		 *
		 * @param array $to_hide Array of order item meta to hide.
		 *
		 * @return mixed Filtered array of values
		 * @since 1.0.0
		 */
		public static function hide_order_item_meta( $to_hide ) {
			$to_hide = array_merge(
				$to_hide,
				array(
					'_yith_wcaf_commission_id',
					'_yith_wcaf_commission_rate',
					'_yith_wcaf_commission_amount',
				)
			);

			return $to_hide;
		}
	}
}
