<?php
/**
 * Payment Handler class - LEGACY
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes\Legacy
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Payments_Legacy' ) ) {
	/**
	 * Legacy Payment Handler
	 *
	 * @deprecated 2.0.0
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Payments_Legacy {

		/* === PAYMENT HANDLING METHODS === */

		/**
		 * Add a payment, registering related commissions
		 *
		 * @param array $args       Params for new payment<br />
		 * [<br />
		 *     'affiliate_id' => 0,                     // Affiliate id (int)<br />
		 *     'payment_email' => '',                   // Payment email (string)<br />
		 *     'status' => 'pending',                   // Status (valid payment status on-hold/pending/completed/cancelled)<br />
		 *     'amount' => 0,                           // Amount (double)<br />
		 *     'created_at' => current_time( 'mysql' ), // Date of creationg (mysql date format; default to current server time)<br />
		 *     'completed_at' => '',                    // Date of complete (mysql date format; default to null)<br />
		 *     'transaction_key' => ''                  // Payment transaction key (string; default null)<br />
		 * ].
		 * @param array $commissions Array of commission to register within payment.
		 *
		 * @return int|bool New payment id; false on failure
		 * @since 1.0.0
		 */
		public function add( $args = array(), $commissions = array() ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Payment_Data_Store::create' );

			try {
				$payment = new YITH_WCAF_Payment( $args );
				$payment->set_commissions( $commissions );
				$payment->save();
			} catch ( Exception $e ) {
				return false;
			}

			return $payment->get_id();
		}

		/**
		 * Update a payment
		 *
		 * @param int   $payment_id Payment id.
		 * @param array $args       Params for new payment<br />
		 * [<br />
		 *     'affiliate_id' => 0,                     // Affiliate id (int)<br />
		 *     'payment_email' => '',                   // Payment email (string)<br />
		 *     'status' => 'pending',                   // Status (valid payment status on-hold/pending/completed)<br />
		 *     'amount' => 0,                           // Amount (double)<br />
		 *     'created_at' => current_time( 'mysql' ), // Date of creationg (mysql date format; default to current server time)<br />
		 *     'completed_at' => '',                    // Date of complete (mysql date format; default to null)<br />
		 *     'transaction_key' => ''                  // Payment transaction key (string; default null)<br />
		 * ].
		 *
		 * @return int|bool Updated rows; false on failure
		 * @since 1.0.0
		 */
		public function update( $payment_id, $args = array() ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Payment_Data_Store::update' );

			$payment = YITH_WCAF_Payment_Factory::get_payment( $payment_id );

			if ( ! $payment ) {
				return false;
			}

			$payment->set_props( $args );

			return $payment->save();
		}

		/**
		 * Delete a payment id and all associated commissions relationship
		 *
		 * @param int $payment_id Payment id.
		 *
		 * @return int|bool Number of deleted rows on payment table; false on failure
		 * @since 1.0.0
		 */
		public function delete( $payment_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Payment_Data_Store::delete' );

			$payment = YITH_WCAF_Payment_Factory::get_payment( $payment_id );

			if ( ! $payment ) {
				return false;
			}

			return $payment->delete();
		}

		/**
		 * Retrieve last id registered by DB
		 *
		 * @return int|bool Last id entered in payments table or false on failure
		 * @since 1.3.0
		 */
		public function last_id() {
			return false;
		}

		/* === HELPER METHODS === */

		/**
		 * Change payment status
		 *
		 * @param int    $payment_id Payment id.
		 * @param string $new_status New status for the payment.
		 *
		 * @return int|bool Number of updated lines; false on failure
		 * @since 1.0.0
		 */
		public function change_payment_status( $payment_id, $new_status ) {
			$payment = $this->get_payment( $payment_id );

			if ( ! $payment ) {
				return false;
			}

			$payment->set_status( $new_status );
			return $payment->save();
		}

		/**
		 * Handle IPN notification (gateway should call specific action to trigger this method)
		 *
		 * @param array $payment_detail Payment details received by Gateway.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function handle_notification( $payment_detail ) {
			_deprecated_function( '\YITH_WCAF_Payments_Premium::handle_notification', '2.0.0', 'Use gateway specific methods' );

			$request_id = $payment_detail['unique_id'];

			$payment = $this->get_payment( $request_id );

			if ( ! $payment ) {
				return;
			}

			if ( ! $payment->has_status( 'pending' ) ) {
				return;
			}

			if ( 'Completed' === $payment_detail['status'] ) {
				$new_status = 'completed';
			} elseif ( in_array( $payment_detail['status'], array( 'Failed', 'Returned', 'Reversed', 'Blocked' ), true ) ) {
				$new_status = 'cancelled';
			} else {
				$new_status = 'pending';
			}

			if ( 'pending' !== $new_status ) {
				$payment->set_status( $new_status );

				if ( 'completed' === $new_status ) {
					$payment->set_transaction_key( $payment_detail['txn_id'] );
				}

				$payment->save();
			}
		}

		/* === PAYMENT NOTES METHODS === */

		/**
		 * Add note to a payment
		 *
		 * @param array $payment_note Array of payment note arguments<br/>
		 * [<br/>
		 *     'payment_id' => 0,                       // Payment id (int)<br/>
		 *     'note_content' => '',                    // Note content (string)<br/>
		 *     'note_date' => current_time( 'mysql' )   // Note date (mysql date format; default to current server time)<br/>
		 * ].
		 *
		 * @return int Added note id; 0 on failure
		 * @since 1.0.0
		 */
		public function add_note( $payment_note ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Payment::add_note' );

			list( $payment_id, $note_content ) = yith_plugin_fw_extract( $payment_note, 'payment_id', 'note_content' );

			if ( ! $payment_id || ! $note_content ) {
				return false;
			}

			$payment = YITH_WCAF_Payment_Factory::get_payment( $payment_id );

			if ( ! $payment ) {
				return false;
			}

			$payment->add_note( $note_content );

			return true;
		}

		/**
		 * Delete a given note
		 * NOTE: this is no longer possible without provide object id too
		 *
		 * @param int $payment_note_id Payment note id.
		 *
		 * @return int|bool Number of rows deleted, or false on failure
		 * @since 1.0.0
		 */
		public function delete_note( $payment_note_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Payment_Data_Store::delete_note' );

			return false;
		}

		/* === WITHDRAW METHODS */

		/**
		 * Check whether payment has invoice
		 *
		 * @param int $payment_id Payment ID.
		 *
		 * @return bool Whether payment has invoice or not
		 */
		public function has_invoice( $payment_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Payment::has_invoice' );

			$payment = YITH_WCAF_Payment_Factory::get_payment( $payment_id );

			if ( ! $payment ) {
				return false;
			}

			return $payment->has_invoice();
		}

		/**
		 * Get path to invoice
		 *
		 * @param int $payment_id Payment ID.
		 *
		 * @return string Path to invoice, or empty if there is no invoice
		 */
		public function get_invoice_path( $payment_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Invoices::get_invoice_path' );

			return YITH_WCAF_Invoices()->get_invoice_path( $payment_id );
		}

		/**
		 * Get url to invoice
		 *
		 * @param int $payment_id Payment ID.
		 *
		 * @return string Url to invoice, or empty if there is no invoice
		 */
		public function get_invoice_url( $payment_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Invoices::get_invoice_url' );

			return YITH_WCAF_Invoices()->get_invoice_url( $payment_id );
		}

		/**
		 * Get url to let user download invoice
		 *
		 * @param int $payment_id Payment ID.
		 *
		 * @return string Url to download invoice, or empty if there is no invoice
		 */
		public function get_invoice_publishable_url( $payment_id ) {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Invoices::get_invoice_publishable_url' );

			return YITH_WCAF_Invoices()->get_invoice_publishable_url( $payment_id );
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAF_Payments_Legacy
		 * @since 1.0.2
		 */
		public static function get_instance() {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Payments::get_instance' );

			return YITH_WCAF_Payments::get_instance();
		}
	}
}

/**
 * Create class alias, to allow for interaction with the legacy class, with its previous name.
 *
 * @since 2.0.0
 */
class_alias( 'YITH_WCAF_Payments_Legacy', 'YITH_WCAF_Payment_Handler' );
class_alias( 'YITH_WCAF_Payments_Legacy', 'YITH_WCAF_Payment_Handler_Premium' );

/**
 * Unique access to instance of YITH_WCAF_Payment_Handler class
 *
 * @return \YITH_WCAF_Payments_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Payment_Handler() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	_deprecated_function( __FUNCTION__, '2.0.0', '\YITH_WCAF_Payments::get_instance' );

	return YITH_WCAF_Payments::get_instance();
}

/**
 * Unique access to instance of YITH_WCAF_Payment_Handler class
 *
 * @return \YITH_WCAF_Payments_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Payment_Handler_Premium() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Payment_Handler();
}
