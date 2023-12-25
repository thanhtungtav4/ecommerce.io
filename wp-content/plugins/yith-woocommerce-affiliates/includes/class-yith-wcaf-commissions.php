<?php
/**
 * Commission Handler class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Commissions' ) ) {
	/**
	 * WooCommerce Commission Handler
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Commissions extends YITH_WCAF_Commissions_Legacy {

		use YITH_WCAF_Trait_Singleton;

		/**
		 * Available commission status
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected static $available_statuses;

		/**
		 * List of "un-assigned" status slugs
		 * When in any of these status, commission is still not credited to the affiliate
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected static $unassigned_statuses = array(
			'not-confirmed',
			'cancelled',
			'refunded',
			'trash',
		);

		/**
		 * List of "assigned" status slugs
		 * When in any of these status, commission is already credited to the affiliate
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected static $assigned_statuses = array(
			'pending',
			'pending-payment',
			'paid',
		);

		/**
		 * List of paid status slugs
		 * When in any of these status, commission is to be considered paid to the affiliate
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected static $payment_statuses = array(
			'paid',
			'pending-payment',
		);

		/**
		 * List of dead status slugs
		 * When in any of these status, commission cannot any longer change status.
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected static $dead_statuses = array(
			'pending-payment',
			'paid',
		);

		/**
		 * Map of allowed status change
		 *
		 * @var mixed
		 * @since 1.0.0
		 */
		protected static $available_status_changes = array(
			'pending'         => array(
				'pending-payment',
				'not-confirmed',
				'cancelled',
				'refunded',
				'paid',
				'trash',
			),
			'pending-payment' => array(
				'pending',
				'paid',
				'trash',
			),
			'paid'            => array(
				'pending-payment',
				'trash',
			),
			'not-confirmed'   => array(
				'pending',
				'cancelled',
				'refunded',
				'trash',
			),
			'cancelled'       => array(
				'pending',
				'not-confirmed',
				'refunded',
				'trash',
			),
			'refunded'        => array(
				'pending',
				'not-confirmed',
				'cancelled',
				'trash',
			),
			'trash'           => array(
				'pending',
				'pending-payment',
				'paid',
				'not-confirmed',
				'cancelled',
				'refunded',
			),
		);

		/* === COMMISSION STATUES === */

		/**
		 * Returns available statuses for commissions
		 *
		 * @return array
		 */
		public static function get_available_statuses() {
			if ( empty( self::$available_statuses ) ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_commissions_statuses
				 *
				 * Filters the available statuses for the commissions.
				 *
				 * @param array $available_statuses Available statuses.
				 */
				self::$available_statuses = apply_filters(
					'yith_wcaf_commissions_statuses',
					array(
						'pending'         => array(
							'slug' => 'pending',
							'name' => _x( 'Pending', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Pending', 'Pending', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
						),
						'pending-payment' => array(
							'slug' => 'pending-payment',
							'name' => _x( 'Pending Payment', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Pending Payment', 'Pending Payment', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
						),
						'paid'            => array(
							'slug' => 'paid',
							'name' => _x( 'Paid', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Paid', 'Paid', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
						),
						'not-confirmed'   => array(
							'slug' => 'not-confirmed',
							'name' => _x( 'Not confirmed', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Not confirmed', 'Not confirmed', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
						),
						'cancelled'       => array(
							'slug' => 'cancelled',
							'name' => _x( 'Canceled', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Canceled', 'Canceled', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
						),
						'refunded'        => array(
							'slug' => 'refunded',
							'name' => _x( 'Refunded', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Refunded', 'Refunded', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
						),
						'trash'           => array(
							'slug' => 'trash',
							'name' => _x( 'In trash', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'In trash', 'In trash', '[ADMIN] Commission status', 'yith-woocommerce-affiliates' ),
						),
					)
				);
			}

			return self::$available_statuses;
		}

		/**
		 * Return a map of available status changes for commissions
		 *
		 * @return array Array of valid status changes, in the following format:
		 * [
		 *     origin_status => [ ... destination_statuses ] // array of valid destination statuses
		 * ]
		 */
		public static function get_available_status_changes() {
			/**
			 * APPLY_FILTERS: yith_wcaf_available_commission_status_changes
			 *
			 * Filters the available status changes for commissions.
			 *
			 * @param array $available_status_changes Array of valid status changes.
			 */
			return apply_filters( 'yith_wcaf_available_commission_status_changes', self::$available_status_changes );
		}

		/**
		 * Return a human friendly version of a commission status
		 *
		 * @param string $status Status to convert to human friendly form.
		 * @param int    $count  Count of items (used to conditionally show plural form).
		 *
		 * @return string Human friendly status
		 * @since 1.3.0
		 */
		public static function get_readable_status( $status, $count = false ) {
			$statuses = self::get_available_statuses();

			// if status is not among supported IDs, assume a slug was passed.
			if ( ! isset( $statuses[ $status ] ) ) {
				$statuses = array_combine( wp_list_pluck( $statuses, 'slug' ), $statuses );
			}

			if ( false !== $count ) {
				$label = translate_nooped_plural( $statuses[ $status ]['noop'], $count, 'yith-woocommerce-affiliates' );
			} else {
				$label = isset( $statuses[ $status ] ) ? $statuses[ $status ]['name'] : '';
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_commission_status_name
			 *
			 * Filters the name of the commission status.
			 *
			 * @param string $label  Status name.
			 * @param string $status Status.
			 * @param int    $count  Count of items.
			 */
			return apply_filters( 'yith_wcaf_commission_status_name', $label, $status, $count );
		}

		/**
		 * Return "un-assigned" statuses
		 * When in any of these status, commission is still not credited to the affiliate
		 *
		 * @return array Un-assigned statuses
		 * @since 1.0.0
		 */
		public static function get_unassigned_statuses() {
			/**
			 * APPLY_FILTERS: yith_wcaf_unassigned_commission_statuses
			 *
			 * Filters the unassigned statuses for commissions.
			 *
			 * @param array $unassigned_statuses Array of unassigned statuses.
			 */
			return apply_filters( 'yith_wcaf_unassigned_commission_statuses', self::$unassigned_statuses );
		}

		/**
		 * Return "assigned" statuses
		 * When in any of these status, commission is already credited to the affiliate
		 *
		 * @return array Assigned statuses
		 * @since 1.0.0
		 */
		public static function get_assigned_statuses() {
			/**
			 * APPLY_FILTERS: yith_wcaf_assigned_commission_statuses
			 *
			 * Filters the assigned statuses for commissions.
			 *
			 * @param array $assigned_statuses Array of assigned statuses.
			 */
			return apply_filters( 'yith_wcaf_assigned_commission_statuses', self::$assigned_statuses );
		}

		/**
		 * Return "payment" statuses
		 * When in any of these status, commission is to be considered paid to the affiliate
		 *
		 * @return array Payment statuses.
		 * @since 1.0.0
		 */
		public static function get_payment_statuses() {
			/**
			 * APPLY_FILTERS: yith_wcaf_payment_commission_statuses
			 *
			 * Filters the payment statuses for commissions.
			 *
			 * @param array $payment_statuses Array of payment statuses.
			 */
			return apply_filters( 'yith_wcaf_payment_commission_statuses', self::$payment_statuses );
		}

		/**
		 * Return "dead" statuses
		 * When in any of these status, commission cannot any longer change status.
		 *
		 * @return array Dead statuses.
		 * @since 1.0.0
		 */
		public static function get_dead_statuses() {
			/**
			 * APPLY_FILTERS: yith_wcaf_dead_commission_statuses
			 *
			 * Filters the dead statuses for commissions.
			 *
			 * @param array $dead_statuses Array of dead statuses.
			 */
			return apply_filters( 'yith_wcaf_dead_commission_statuses', self::$dead_statuses );
		}

		/**
		 * Returns an array of available status for a given commission
		 *
		 * @param int $commission_id Commission id.
		 *
		 * @return mixed Array of available status to switch to
		 * @since 1.0.0
		 */
		public static function get_available_status_change( $commission_id ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return array();
			}

			if ( ! in_array( $commission->get_status(), array_keys( self::$available_status_changes ), true ) ) {
				return array();
			}

			return self::$available_status_changes [ $commission['status'] ];
		}

		/**
		 * Returns true if status change is valid
		 *
		 * @param string $old_status Origin status.
		 * @param string $new_status Destination status.
		 *
		 * @eturn bool
		 */
		public static function is_valid_status_change( $old_status, $new_status ) {
			if ( ! in_array( $old_status, array_keys( self::$available_status_changes ), true ) ) {
				return false;
			}

			return in_array( $new_status, self::$available_status_changes[ $old_status ], true );
		}

		/* === HELPER METHODS === */

		/**
		 * Count commissions matching search params
		 *
		 * @param array $args Search params (@see \YITH_WCAF_Commission_Data_store::count).
		 *
		 * @return int Commission count
		 * @since 1.0.0
		 */
		public function count_commissions( $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'commission' );

				$count = $data_store->count( $args );
			} catch ( Exception $e ) {
				return 0;
			}

			return $count;
		}

		/**
		 * Retrieve commissions matching search params
		 *
		 * @param array $args mixed Search params (@see \YITH_WCAF_Commission_Data_store::query).
		 *
		 * @return YITH_WCAF_Commissions_Collection Array with found commissions, or false on failure
		 * @since 1.0.0
		 */
		public function get_commissions( $args = array() ) {
			return YITH_WCAF_Commission_Factory::get_commissions( $args );
		}

		/**
		 * Retrieve the commission with the given commission id
		 *
		 * @param int $commission_id Commission id.
		 *
		 * @return YITH_WCAF_Commission Commission object, or false on failure
		 * @since 1.0.0
		 */
		public function get_commission( $commission_id ) {
			return YITH_WCAF_Commission_Factory::get_commission( $commission_id );
		}

		/**
		 * Check if a commission with the given id exists in DB
		 *
		 * @param int $commission_id Commission id.
		 *
		 * @return bool Whether commission exists or not
		 * @since 1.0.0
		 */
		public function commission_exists( $commission_id ) {
			return ! ! YITH_WCAF_Commission_Factory::get_commission( $commission_id );
		}

		/**
		 * Return an array of refunds registered for given commission
		 *
		 * @param int $commission_id Commission id.
		 *
		 * @return array Array of partial refund amounts, indexed by refund id.
		 * @since 1.0.0
		 */
		public function get_commission_refunds( $commission_id ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return array();
			}

			return $commission->get_refund_partials();
		}

		/**
		 * Return sum of all refunds registered for a given commission
		 *
		 * @param int $commission_id Commission id.
		 *
		 * @return float Total refund
		 * @since 1.0.0
		 */
		public function get_total_commission_refund( $commission_id ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return 0;
			}

			return $commission->get_refunds_from_partials();
		}

		/**
		 * Change affiliate id of a specific commission, updating in the same time totals for both affiliates
		 *
		 * @param int    $commission_id    Id of the commission.
		 * @param int    $new_affiliate_id Id of the receiver affiliate.
		 * @param string $note             Note to add to the commission.
		 *
		 * @return void
		 * @since 1.2.4
		 */
		public function change_commission_affiliate( $commission_id, $new_affiliate_id, $note = '' ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return;
			}

			$commission->set_affiliate_id( $new_affiliate_id );
			$commission->save();

			if ( ! empty( $note ) ) {
				$commission->add_note( $note );
			}
		}

		/**
		 * Change a commission amount, updating also referral amounts, if necessary
		 *
		 * @param int    $commission_id Commission id.
		 * @param float  $difference    Signed amount to sum to commission total.
		 * @param string $note          Note to register within the commission, to document amount change.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function change_commission_amount( $commission_id, $difference, $note = '' ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return;
			}

			$commission->update_amount( $difference, $note );
			$commission->save();
		}

		/**
		 * Change commission refunds
		 *
		 * @param int    $commission_id Commission id.
		 * @param float  $difference    Signed amount to sum to commission total refunds.
		 * @param string $note          Note to register within the commission, to document amount change.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function change_commission_refund( $commission_id, $difference, $note = '' ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return;
			}

			$commission->update_refunds( $difference, $note );
			$commission->save();
		}

		/**
		 * Change commission status, updating referral totals if necessary
		 *
		 * @param int    $commission_id Commission id.
		 * @param string $new_status    New commission status.
		 * @param string $note          Note to register within the commission, to document status change.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function change_commission_status( $commission_id, $new_status, $note = '' ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return;
			}

			$commission->set_status( $new_status, $note );
			$commission->save();
		}

		/**
		 * Returns count of commissions, grouped by status
		 *
		 * @param string $status Specific status to count, or all to obtain a global statistic; if left empty, returns array of counts per status.
		 * @param array  $args   Array of arguments to filter status query (@see \YITH_WCAF_Commission_Data_Store::per_status_count).
		 *
		 * @return int|array Count per state, or array indexed by status, with status count
		 * @use \YITH_WCAF_Commission_Data_Store::::per_status_count
		 */
		public function per_status_count( $status = 'all', $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'commission' );

				$count = $data_store->per_status_count( $status, $args );
			} catch ( Exception $e ) {
				return 0;
			}

			return $count;
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Commission_Handler class
 *
 * @return \YITH_WCAF_Commissions
 * @since 1.0.0
 */
function YITH_WCAF_Commissions() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Commissions::get_instance();
}
