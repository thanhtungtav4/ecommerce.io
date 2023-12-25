<?php
/**
 * General object data store interface
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Interfaces
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! interface_exists( 'YITH_WCAF_Object_Data_Store_Interface' ) ) {
	interface YITH_WCAF_Object_Data_Store_Interface {
		/**
		 * Method to create a new record of a WC_Data based object.
		 *
		 * @param WC_Data $data Data object.
		 */
		public function create( &$data );

		/**
		 * Method to read a record. Creates a new WC_Data based object.
		 *
		 * @param WC_Data $data Data object.
		 */
		public function read( &$data );

		/**
		 * Updates a record in the database.
		 *
		 * @param WC_Data $data Data object.
		 */
		public function update( &$data );

		/**
		 * Deletes a record from the database.
		 *
		 * @param WC_Data $data Data object.
		 *
		 * @return bool result
		 */
		public function delete( &$data );
	}
}
