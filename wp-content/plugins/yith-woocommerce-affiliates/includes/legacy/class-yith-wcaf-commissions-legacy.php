<?php
/**
 * Commission Handler class - LEGACY
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes\Legacy
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Commissions_Legacy' ) ) {
	/**
	 * Legacy Commission Handler
	 *
	 * @deprecated 2.0.0
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Commissions_Legacy {

		/* === COMMISSION HANDLING METHODS === */

		/**
		 * Add a new commission
		 *
		 * @param array $commission_args Data of the commission to add<br/>
		 * [<br/>
		 *     'order_id' => 0,                             // Commission related order id (int)<br/>
		 *     'affiliate_id' => 0,                         // Commission related affiliate id (int)<br/>
		 *     'line_item_id' => 0,                         // Commission related line item id (int)<br/>
		 *     'rate' => 0,                                 // Commission rate (float)<br/>
		 *     'amount' => 0,                               // Commission amount (float)<br/>
		 *     'status' => 'pending',                       // Commission status ({@link \YITH_WCAF_Commission_Handler::$_available_commission_status})<br/>
		 *     'created_at' => current_time( 'mysql' ),     // Date of commission creation (mysql date format; default to server current time)<br/>
		 *     'last_edit' => current_time( 'mysql' )       // Date of last commission edit (mysql date format; default to server current time)<br/>
		 * ].
		 *
		 * @return int|bool Id of commission added to DB; false on failure
		 * @see   \YITH_WCAF_Commission_Handler::$_available_commission_status
		 * @since 1.0.0
		 */
		public function add( $commission_args = array() ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commission_Data_Store::create' );

			try {
				$commission = new YITH_WCAF_Commission( $commission_args );
				$commission->save();
			} catch ( Exception $e ) {
				return false;
			}

			return $commission->get_id();
		}

		/**
		 * Update commission db row.
		 * To change commission status or commission amount, refer to {@link \YITH_WCAF_Commission_Handler::change_commission_status} and {@link \YITH_WCAF_Commission_Handler::change_commission_amount}
		 *
		 * @param int   $commission_id Commission id.
		 * @param array $args          Args to use on update procedure<br/>
		 * [<br/>
		 *     'order_id' => 0,                             // Commission related order id (int)<br/>
		 *     'affiliate_id' => 0,                         // Commission related affiliate id (int)<br/>
		 *     'line_item_id' => 0,                         // Commission related line item id (int)<br/>
		 *     'rate' => 0,                                 // Commission rate (float)<br/>
		 *     'amount' => 0,                               // Commission amount (float)<br/>
		 *     'status' => 'pending',                       // Commission status ({@link \YITH_WCAF_Commission_Handler::$_available_commission_status})<br/>
		 *     'created_at' => current_time( 'mysql' ),     // Date of commission creation (mysql date format; default to server current time)<br/>
		 * ].
		 *
		 * @return int|bool Number of update rows; false on failure
		 * @see   \YITH_WCAF_Commission_Handler::$_available_commission_status
		 * @since 1.0.0
		 */
		public function update( $commission_id, $args ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commission_Data_Store::update' );

			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return false;
			}

			$commission->set_props( $args );

			return $commission->save();
		}

		/**
		 * Delete commission row from db
		 *
		 * @param int $commission_id Commission to delete.
		 *
		 * @return int|bool Number of deleted row; false on error
		 * @since 1.0.0
		 */
		public function delete( $commission_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commission_Data_Store::delete' );

			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return false;
			}

			return $commission->delete();
		}

		/**
		 * Delete a single commissions, removing in the same time data stored within order item meta
		 *
		 * @param int  $commission_id Commission id.
		 * @param bool $force         Force deletion, even if status is a dead_status.
		 * @param bool $delete_rate   Delete rate stored within order items, to get fresh values when adding new affiliate.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function delete_single_commission( $commission_id, $force = false, $delete_rate = false ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commission_Data_Store::delete' );

			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return;
			}

			$commission->delete(
				$force,
				array(
					'delete_rates' => $delete_rate,
				)
			);
		}

		/**
		 * Restore item form trash
		 *
		 * @param int $commission_id Commission id.
		 *
		 * @return bool operation status
		 */
		public function restore_from_trash( $commission_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commission::restore' );

			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission || ! $commission->is_trashed() ) {
				return false;
			}

			$commission->restore();

			// translators: 1. Current user login. 2. New commission status.
			$message = sprintf( __( 'Item restored from trash; the system automatically assigned %2$s status.', 'yith-woocommerce-affiliates' ), YITH_WCAF_Commissions::get_readable_status( $commission->get_status() ) );
			$commission->add_note( $message );

			return $commission->save();
		}

		/* === COMMISSION NOTES METHODS === */

		/**
		 * Add note to a commission
		 *
		 * @param array $commission_note Array of commission note arguments<br/>
		 * [<br/>
		 *     'commission_id' => 0,                    // Commission id (int)<br/>
		 *     'note_content' => '',                    // Note content (string)<br/>
		 *     'note_date' => current_time( 'mysql' )   // Note date (mysql date format; default to current server time)<br/>
		 * ].
		 *
		 * @return bool Status of the operation.
		 * @since 1.0.0
		 */
		public function add_note( $commission_note ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commission::add_note' );

			list( $commission_id, $note_content ) = yith_plugin_fw_extract( $commission_note, 'commission_id', 'note_content' );

			if ( ! $commission_id || ! $note_content ) {
				return false;
			}

			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return false;
			}

			$commission->add_note( $note_content );

			return true;
		}

		/**
		 * Delete a given note
		 * NOTE: this is no longer possible without provide object id too
		 *
		 * @param int $commission_note_id Commission note id.
		 *
		 * @return int|bool Number of rows deleted, or false on failure
		 * @since 1.0.0
		 */
		public function delete_note( $commission_note_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commission_Data_Store::delete_note' );

			return false;
		}

		/* === ORDER HANDLING METHODS === */

		/**
		 * Create orders commissions, on process checkout action, and when an order is untrashed
		 *
		 * @param int    $order_id     Order id.
		 * @param string $token        Referral token.
		 * @param string $token_origin Referral token origin.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function create_order_commissions( $order_id, $token, $token_origin = 'undefined' ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Orders::create_commissions' );

			YITH_WCAF_Orders()->create_commissions( $order_id, $token, $token_origin );
		}

		/**
		 * Regenerate order commissions, deleting old ones, and regenerating them
		 *
		 * @param int    $order_id Order id.
		 * @param string $token    Affiliate token.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function regenerate_order_commissions( $order_id, $token = false ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Orders::regenerate_commissions' );

			YITH_WCAF_Orders()->regenerate_commissions( $order_id, $token );
		}

		/**
		 * Delete order commissions, when an order is trashed
		 *
		 * @param int  $order_id     Order id.
		 * @param bool $force        Force deletion, even if status is a dead_status.
		 * @param bool $delete_rates Delete rates stored within order items, to get fresh values when adding new affiliate.
		 *
		 * @return bool Operation status
		 * @since 1.0.0
		 */
		public function delete_order_commissions( $order_id, $force = false, $delete_rates = false ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Orders::delete_commissions' );

			return YITH_WCAF_Orders()->delete_commissions( $order_id, $force, $delete_rates );
		}

		/* === HELPER METHODS === */

		/**
		 * Count commissions matching search params
		 *
		 * @param array $args Search params (@see \YITH_WCAF_Commission_Data_store::count).
		 *
		 * @return int Commission count
		 * @see   \YITH_WCAF_Commission_Handler::get_commissions
		 * @since 1.0.0
		 */
		public function count_commission( $args = array() ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commissions::count_commissions' );

			try {
				$data_store = WC_Data_Store::load( 'commission' );

				$count = $data_store->count( $args );
			} catch ( Exception $e ) {
				return 0;
			}

			return $count;
		}

		/**
		 * Return commission default status for a given order status
		 *
		 * @param string $order_status Order status.
		 *
		 * @return string Commission status
		 * @since 1.0.0
		 */
		public function map_commission_status( $order_status ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Orders::map_commission_status' );

			return YITH_WCAF_Orders()->map_commission_status( $order_status );
		}

		/**
		 * Return a list of available commission status
		 *
		 * @return mixed Available status
		 * @since 1.0.0
		 */
		public function get_available_status() {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commissions::get_available_statuses' );

			return YITH_WCAF_Commissions::get_available_statuses();
		}

		/**
		 * Return "dead status", that don't allow any status change
		 *
		 * @return array Dead status
		 * @since 1.0.0
		 */
		public function get_dead_status() {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commissions::get_dead_statuses' );

			return YITH_WCAF_Commissions::get_dead_statuses();
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAF_Commissions_Legacy
		 * @since 1.0.2
		 */
		public static function get_instance() {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Commissions' );

			return YITH_WCAF_Commissions::get_instance();
		}
	}
}

/**
 * Create class alias, to allow for interaction with the legacy class, with its previous name.
 *
 * @since 2.0.0
 */
class_alias( 'YITH_WCAF_Commissions_Legacy', 'YITH_WCAF_Commission_Handler' );
class_alias( 'YITH_WCAF_Commissions_Legacy', 'YITH_WCAF_Commission_Handler_Premium' );

/**
 * Unique access to instance of YITH_WCAF_Commission_Handler class
 *
 * @return \YITH_WCAF_Commissions_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Commission_Handler() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	_deprecated_function( __FUNCTION__, '2.0.0', '\YITH_WCAF_Commissions' );

	return YITH_WCAF_Commissions::get_instance();
}

/**
 * Unique access to instance of YITH_WCAF_Commission_Handler class
 *
 * @return \YITH_WCAF_Commissions_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Commission_Handler_Premium() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Commission_Handler();
}
