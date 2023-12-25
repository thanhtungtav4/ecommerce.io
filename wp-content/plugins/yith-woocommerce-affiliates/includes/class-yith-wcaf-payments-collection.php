<?php
/**
 * Payments Collection
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Payments_Collection' ) ) {
	/**
	 * Behaves as an array of YITH_WCAF_Commission
	 */
	class YITH_WCAF_Payments_Collection extends YITH_WCAF_Abstract_Objects_Collection {

		/**
		 * Retrieves a specific object, giver the id
		 *
		 * @param int $payment_id Id of the object to retrieve.
		 *
		 * @return YITH_WCAF_Payment Object retrieved.
		 */
		public function get_object( $payment_id ) {
			return YITH_WCAF_Payment_Factory::get_payment( $payment_id );
		}

		/* === UTILITIES === */

		/**
		 * Returns total amount for current collection (paid and pending)
		 *
		 * @return float Total collection amount
		 */
		public function get_total_amount() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $payment ) {
					return $sum + $payment->get_amount();
				}
			);
		}

		/**
		 * Returns total paid for current collection
		 *
		 * @return float Total paid for collection
		 */
		public function get_total_paid() {
			$objects = $this->get_objects();

			return array_reduce(
				$objects,
				function( $sum, $payment ) {
					if ( ! $payment->has_status( 'completed' ) ) {
						return $sum;
					}

					return $sum + $payment->get_refunds();
				}
			);
		}
	}
}
