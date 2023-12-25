<?php
/**
 * Commission Factory class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Commission_Factory' ) ) {
	/**
	 * Static class that offers methods to construct YITH_WCAF_Commission objects
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Commission_Factory {

		/**
		 * Returns a list of commissions matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Commission_Data_Store::query).
		 *
		 * @return YITH_WCAF_Commissions_Collection|string[]|bool Result set; false on failure.
		 */
		public static function get_commissions( $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'commission' );

				$res = $data_store->query( $args );
			} catch ( Exception $e ) {
				return false;
			}

			return $res;
		}

		/**
		 * Returns a commission, given the id
		 *
		 * @param int $id Commission's ID.
		 *
		 * @return YITH_WCAF_Commission|bool Commission object, or false on failure
		 */
		public static function get_commission( $id ) {
			if ( ! $id ) {
				return false;
			}

			try {
				return new YITH_WCAF_Commission( $id );
			} catch ( Exception $e ) {
				return false;
			}
		}
	}
}
