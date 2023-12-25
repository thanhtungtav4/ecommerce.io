<?php
/**
 * Click Collection
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Clicks_Collection' ) ) {
	/**
	 * Behaves as an array of YITH_WCAF_Click
	 */
	class YITH_WCAF_Clicks_Collection extends YITH_WCAF_Abstract_Objects_Collection {

		/**
		 * Retrieves a specific object, given the id
		 *
		 * @param int $click_id Id of the object to retrieve.
		 *
		 * @return YITH_WCAF_Click Object retrieved.
		 */
		public function get_object( $click_id ) {
			return YITH_WCAF_Click_Factory::get_click( $click_id );
		}
	}
}
