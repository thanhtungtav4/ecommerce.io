<?php
/**
 * Commission Collection
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Commissions_Collection' ) ) {
	/**
	 * Behaves as an array of YITH_WCAF_Commission
	 */
	class YITH_WCAF_Commissions_Collection extends YITH_WCAF_Abstract_Objects_Collection {

		/**
		 * Retrieves a specific object, giver the id
		 *
		 * @param int $commission_id Id of the object to retrieve.
		 *
		 * @return YITH_WCAF_Commission Object retrieved.
		 */
		public function get_object( $commission_id ) {
			return YITH_WCAF_Commission_Factory::get_commission( $commission_id );
		}

		/* === UTILITIES === */

		/**
		 * Returns total amount for current collection
		 *
		 * @return float Total collection amount
		 */
		public function get_total_amount() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $commission ) {
					return $sum + $commission->get_amount();
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
				function( $sum, $commission ) {
					return $sum + $commission->get_refunds();
				}
			);
		}

		/**
		 * Returns a new collection of commissions, calculated as a subset of current collection
		 *
		 * @param array $args Filtering criteria (@see YITH_WCAF_Commission_Data_Store::query).
		 * @return bool|YITH_WCAF_Payments_Collection
		 */
		public function filter( $args = array() ) {
			$ids = $this->get_ids();

			if ( ! $ids ) {
				return false;
			}

			return YITH_WCAF_Commission_Factory::get_commissions(
				array_merge(
					$args,
					array(
						'include' => $ids,
					)
				)
			);
		}
	}
}
