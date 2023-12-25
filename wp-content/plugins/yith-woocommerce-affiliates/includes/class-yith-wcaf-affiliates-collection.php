<?php
/**
 * Affiliates Collection
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliates_Collection' ) ) {
	/**
	 * Behaves as an array of YITH_WCAF_Affiliate
	 */
	class YITH_WCAF_Affiliates_Collection extends YITH_WCAF_Abstract_Objects_Collection {

		/**
		 * Retrieves a specific object, giver the id
		 *
		 * @param int $affiliate_id Id of the object to retrieve.
		 *
		 * @return YITH_WCAF_Affiliate Object retrieved.
		 */
		public function get_object( $affiliate_id ) {
			return YITH_WCAF_Affiliate_Factory::get_affiliate_by_id( $affiliate_id );
		}

		/* === UTILITIES === */

		/**
		 * Returns overall total for current collection
		 *
		 * @return float Total for current collection
		 */
		public function get_total() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $affiliate ) {
					return $sum + $affiliate->get_total();
				}
			);
		}

		/**
		 * Returns total earnings for current collection
		 *
		 * @return float Total collection earnings
		 */
		public function get_total_earnings() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $affiliate ) {
					return $sum + $affiliate->get_earnings();
				}
			);
		}

		/**
		 * Returns total refunds for current collection
		 *
		 * @return float Total collection refunds
		 */
		public function get_total_refunds() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $affiliate ) {
					return $sum + $affiliate->get_refunds();
				}
			);
		}

		/**
		 * Returns total balance for current collection
		 *
		 * @return float Total collection balance
		 */
		public function get_total_balance() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $affiliate ) {
					return $sum + $affiliate->get_balance();
				}
			);
		}

		/**
		 * Returns total paid for current collection
		 *
		 * @return float Total collection paid
		 */
		public function get_total_paid() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $affiliate ) {
					return $sum + $affiliate->get_paid();
				}
			);
		}

		/**
		 * Returns total clicks for current collection
		 *
		 * @return float Total collection clicks
		 */
		public function get_total_clicks() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $affiliate ) {
					return $sum + $affiliate->get_clicks_count();
				}
			);
		}

		/**
		 * Returns total conversions for current collection
		 *
		 * @return float Total collection conversions
		 */
		public function get_total_conversions() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $affiliate ) {
					return $sum + $affiliate->get_conversions();
				}
			);
		}
	}
}
