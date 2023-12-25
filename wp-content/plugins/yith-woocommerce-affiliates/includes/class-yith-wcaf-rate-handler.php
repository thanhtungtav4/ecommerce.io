<?php
/**
 * Rate Handler class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Rate_Handler' ) ) {
	/**
	 * Affiliates Rate Handler
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Rate_Handler extends YITH_WCAF_Rate_Handler_Legacy {

		/* === HELPER METHODS === */

		/**
		 * Returns default rate
		 *
		 * @return float Default store rate.
		 */
		public static function get_default() {
			$general_rate = get_option( 'yith_wcaf_general_rate' );

			/**
			 * APPLY_FILTERS: yith_wcaf_default_rate
			 *
			 * Filters the default rate.
			 *
			 * @param float $general_rate Default rate.
			 */
			return apply_filters( 'yith_wcaf_default_rate', (float) $general_rate );
		}

		/**
		 * Get rate for an affiliate or a product
		 *
		 * @param int|YITH_WCAF_Affiliate $affiliate Affiliate ID or affiliate object.
		 * @param int|WC_Product          $product   Product id or product object (not in use).
		 * @param int|WC_Order            $order     Order id or order object (not in use).
		 *
		 * @return float Rate (product specific rate, if any; otherwise, affiliate specific rate, if any; otherwise, general rate)
		 * @since 1.0.0
		 */
		public static function get_rate( $affiliate = false, $product = false, $order = false ) {
			// retrieve affiliate data.
			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate );

			if ( $affiliate && $affiliate->get_rate() ) {
				// some rule types (specifically user_roles type) are weaker than affiliate own rate.
				$rate = $affiliate->get_rate();
			} else {
				// when cannot retrieve rate by other means, use default.
				$rate = self::get_default();
			}

			/**
			 * Let third party plugin filter rate
			 *
			 * @since 1.0.9
			 */
			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_rate
			 *
			 * Filters the affiliate rate.
			 *
			 * @param float               $rate      Affiliate rate.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 * @param WC_Product          $product   Product object.
			 * @param WC_Order            $order     Order object.
			 */
			return apply_filters( 'yith_wcaf_affiliate_rate', $rate, $affiliate, $product, $order );
		}

		/**
		 * Returns rate formatted for display purposes
		 *
		 * @param int|YITH_WCAF_Affiliate $affiliate Affiliate ID or affiliate object.
		 * @param int!WC_Product          $product   Product id or product object.
		 * @param int|WC_Order            $order     Order id or order object.
		 *
		 * @return string Formatted rate
		 */
		public static function get_formatted_rate( $affiliate = false, $product = false, $order = false ) {
			return yith_wcaf_rate_format( static::get_rate( $affiliate, $product, $order ) );
		}
	}
}
