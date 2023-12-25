<?php
/**
 * Payment Factory class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Payment_Factory' ) ) {
	/**
	 * Static class that offers methods to construct YITH_WCAF_Payment objects
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Payment_Factory {

		/**
		 * Returns a list of payments matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Payment_Data_Store::query).
		 *
		 * @return YITH_WCAF_Payments_Collection|string[]|bool Result set; false on failure.
		 */
		public static function get_payments( $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'payment' );

				$res = $data_store->query( $args );
			} catch ( Exception $e ) {
				return false;
			}

			return $res;
		}

		/**
		 * Returns a payment, given the id
		 *
		 * @param int $id Payment's ID.
		 *
		 * @return YITH_WCAF_Payment|bool Payment object, or false on failure
		 */
		public static function get_payment( $id ) {
			if ( ! $id ) {
				return false;
			}

			try {
				return new YITH_WCAF_Payment( $id );
			} catch ( Exception $e ) {
				return false;
			}
		}
	}
}
