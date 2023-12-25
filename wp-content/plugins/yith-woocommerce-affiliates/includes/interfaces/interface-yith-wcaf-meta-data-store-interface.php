<?php
/**
 * Meta handling data store interface
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Interfaces
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! interface_exists( 'YITH_WCAF_Meta_Data_Store_Interface' ) ) {
	interface YITH_WCAF_Meta_Data_Store_Interface {
		/**
		 * Returns an array of meta for an object.
		 *
		 * @param  WC_Data $data Data object.
		 * @return array
		 */
		public function read_meta( &$data );

		/**
		 * Deletes meta based on meta ID.
		 *
		 * @param  WC_Data $data Data object.
		 * @param  object  $meta Meta object (containing at least ->id).
		 * @return bool
		 */
		public function delete_meta( &$data, $meta );

		/**
		 * Add new piece of meta.
		 *
		 * @param  WC_Data $data Data object.
		 * @param  object  $meta Meta object (containing ->key and ->value).
		 * @return int meta ID
		 */
		public function add_meta( &$data, $meta );

		/**
		 * Update meta.
		 *
		 * @param  WC_Data $data Data object.
		 * @param  object  $meta Meta object (containing ->id, ->key and ->value).
		 */
		public function update_meta( &$data, $meta );
	}
}
