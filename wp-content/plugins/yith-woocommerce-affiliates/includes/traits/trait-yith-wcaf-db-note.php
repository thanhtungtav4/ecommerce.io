<?php
/**
 * Notes handling traits
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Traits
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! trait_exists( 'YITH_WCAF_Trait_DB_Note' ) ) {
	/**
	 * This class implements basic handling for notes
	 * Offers methods that will create/read/update/delete notes from DB, given table name and basic info about the note
	 *
	 * It expects every note to be related to an external object, whose id is stored in \YITH_WCAF_Trait_DB_Note::$notes_external_reference_column
	 * Some methods will make use of the WC_Data external object, reading its id using \WC_Data::get_id()
	 *
	 * @since 2.0.0
	 */
	trait YITH_WCAF_Trait_DB_Note {

		/**
		 * Name of the table where notes are stored
		 *
		 * @var string
		 */
		protected $notes_table;

		/**
		 * Name of the column where is stored external reference id
		 *
		 * @var string
		 */
		protected $notes_external_reference_column;

		/**
		 * Returns an array of notes for an object.
		 *
		 * @param WC_Data|int $data Data object, or numeric id.
		 *
		 * @return array
		 */
		public function read_notes( &$data ) {
			global $wpdb;

			$id = $this->get_id_from_data( $data );

			if ( ! $id ) {
				return array();
			}

			// phpcs:disable WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$notes = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT *
						FROM {$this->notes_table}
						WHERE {$this->notes_external_reference_column} = %d
						ORDER BY note_date DESC",
					$id
				)
			);
			// phpcs:enable WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared

			return $notes;
		}

		/**
		 * Deletes note based on note ID.
		 *
		 * @param WC_Data|int        $data Data object, or numeric id.
		 * @param YITH_WCAF_Note|int $note Note object (containing at least ->id), or numeric id.
		 *
		 * @return bool
		 */
		public function delete_note( &$data, $note ) {
			global $wpdb;

			$id      = $this->get_id_from_data( $data );
			$note_id = $note instanceof YITH_WCAF_Note ? $note->id : (int) $note;

			if ( ! $id || ! $note_id ) {
				return false;
			}

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			return $wpdb->delete(
				$this->notes_table,
				array(
					'ID'                                   => $note_id,
					$this->notes_external_reference_column => $id,
				),
				array(
					'%d',
					'%d',
				)
			);
		}

		/**
		 * Deletes all notes for an external object.
		 *
		 * @param WC_Data|int $data Data object, or numeric id.
		 *
		 * @return bool
		 */
		public function delete_notes( &$data ) {
			global $wpdb;

			$id = $this->get_id_from_data( $data );

			if ( ! $id ) {
				return false;
			}

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			return $wpdb->delete(
				$this->notes_table,
				array(
					$this->notes_external_reference_column => $id,
				),
				array(
					'%d',
				)
			);
		}

		/**
		 * Add new note.
		 *
		 * @param WC_Data|int    $data Data object, or numeric id.
		 * @param YITH_WCAF_Note $note Note object (containing ->content).
		 *
		 * @return int Note ID
		 */
		public function add_note( &$data, $note ) {
			global $wpdb;

			$id = $this->get_id_from_data( $data );

			if ( ! $id || empty( $note->content ) ) {
				return false;
			}

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$wpdb->insert(
				$this->notes_table,
				array(
					'note_content'                         => $note->content,
					$this->notes_external_reference_column => $id,
					'note_date'                            => gmdate( 'Y-m-d H:i:s' ),
				),
				array(
					'%s',
					'%d',
					'%s',
				)
			);

			return $wpdb->insert_id;
		}

		/**
		 * Update note.
		 *
		 * @param WC_Data|int $data Data object, or numeric id.
		 * @param object      $note Note object (containing ->id and ->content).
		 */
		public function update_note( &$data, $note ) {
			global $wpdb;

			$id = $this->get_id_from_data( $data );

			if ( ! $id || ! $note->id || empty( $note->content ) ) {
				return false;
			}

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			return $wpdb->update(
				$this->notes_table,
				array(
					'note_content' => $note->id,
				),
				array(
					'%s',
				),
				array(
					'ID'                                   => $note->id,
					$this->notes_external_reference_column => $id,
				),
				array(
					'%d',
					'%d',
				)
			);
		}

		/**
		 * Retrieves id from submitted data
		 *
		 * @param WC_Data|int $data Data object or numeric id.
		 *
		 * @return int|bool Numeric id, or false on failure.
		 */
		protected function get_id_from_data( &$data ) {
			if ( is_numeric( $data ) ) {
				$id = (int) $data;
			} elseif ( $data instanceof WC_Data ) {
				$id = $data->get_id();
			} else {
				$id = false;
			}

			return $id;
		}
	}
}
