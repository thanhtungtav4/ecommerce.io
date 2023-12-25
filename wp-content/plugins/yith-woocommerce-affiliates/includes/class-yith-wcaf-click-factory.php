<?php
/**
 * Click Factory class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Click_Factory' ) ) {
	/**
	 * Static class that offers methods to construct YITH_WCAF_Click objects
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Click_Factory {

		/**
		 * Returns a list of click matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Click_Data_Store::query).
		 *
		 * @return YITH_WCAF_Clicks_Collection|string[]|bool Result set; false on failure.
		 */
		public static function get_clicks( $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'click' );

				$res = $data_store->query( $args );
			} catch ( Exception $e ) {
				return false;
			}

			return $res;
		}

		/**
		 * Returns a click, given the id
		 *
		 * @param int $id Clicks's ID.
		 *
		 * @return YITH_WCAF_Click|bool Click object, or false on failure
		 */
		public static function get_click( $id ) {
			if ( ! $id ) {
				return false;
			}

			try {
				return new YITH_WCAF_Click( $id );
			} catch ( Exception $e ) {
				return false;
			}
		}
	}
}
