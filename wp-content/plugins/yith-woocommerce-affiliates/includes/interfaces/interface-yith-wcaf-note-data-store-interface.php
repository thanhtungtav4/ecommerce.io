<?php
/**
 * Note handling data store interfaceNote
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Interfaces
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! interface_exists( 'YITH_WCAF_Note_Data_Store_Interface' ) ) {
	interface YITH_WCAF_Note_Data_Store_Interface {
		/**
		 * Returns an array of notes for an object.
		 *
		 * @param WC_Data|int $data Data object, or numeric id.
		 * @return array
		 */
		public function read_notes( &$data );

		/**
		 * Deletes note based on note ID.
		 *
		 * @param WC_Data|int        $data Data object, or data id.
		 * @param YITH_WCAF_Note|int $note Note object (containing at least ->id), or numeric id.
		 * @return bool
		 */
		public function delete_note( &$data, $note );

		/**
		 * Add new note.
		 *
		 * @param WC_Data|int    $data Data object, or data id.
		 * @param YITH_WCAF_Note $note Note object (containing ->content).
		 * @return int Note ID
		 */
		public function add_note( &$data, $note );

		/**
		 * Update note.
		 *
		 * @param WC_Data|int    $data Data object, or data id.
		 * @param YITH_WCAF_Note $note Note object (containing ->id and ->content).
		 */
		public function update_note( &$data, $note );
	}
}
