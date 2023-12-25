<?php
/**
 * Payment Handler class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Clases
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Payments' ) ) {
	/**
	 * Payments Handler
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Payments extends YITH_WCAF_Payments_Legacy {

		use YITH_WCAF_Trait_Singleton;

		/**
		 * Available payment status
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected static $available_statuses;

		/**
		 * List of "inactive" status slugs
		 * When in any of these status, payment is considered dead, and other payment may be issued for same commissions.
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected static $inactive_statuses = array(
			'cancelled',
		);

		/**
		 * List of "active" status slugs
		 * When in any of these status, payment is active, and commissions reserved.
		 *
		 * @var array
		 * @since 1.0.0
		 */
		protected static $active_statuses = array(
			'pending',
			'completed',
			'on-hold',
		);

		/**
		 * List of "pending" status slugs
		 * When in any of these status, payment is pending, and no other payment can be created for the affiliate.
		 *
		 * @var array
		 * @since 2.0.0
		 */
		protected static $pending_statuses = array(
			'pending',
			'on-hold',
		);

		/**
		 * List of "completed" status slugs
		 * When in any of these status, payment is completed,  and new payments can be created for the affiliate.
		 *
		 * @var array
		 * @since 2.0.0
		 */
		protected static $completed_statuses = array(
			'completed',
			'cancelled',
		);

		/**
		 * List of "payment" status slugs
		 * When in any of these status, payment is issued to gateway, and cannot be changed
		 *
		 * @var array
		 * @since 2.0.0
		 */
		protected static $payment_statuses = array(
			'completed',
			'pending',
		);

		/**
		 * Map of allowed status change
		 *
		 * @var mixed
		 * @since 1.0.0
		 */
		protected static $available_status_changes = array(
			'on-hold'   => array(
				'completed',
				'cancelled',
				'pending',
			),
			'pending'   => array(
				'completed',
				'cancelled',
			),
			'cancelled' => array(
				'on-hold',
			),
			'completed' => array(
				'on-hold',
			),
		);

		/* === PAYMENT STATUES === */

		/**
		 * Returns available statuses for commissions
		 *
		 * @return array
		 */
		public static function get_available_statuses() {
			if ( empty( self::$available_statuses ) ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_payments_statuses
				 *
				 * Filters the available statuses for the payments.
				 *
				 * @param array $available_statuses Available statuses.
				 */
				self::$available_statuses = apply_filters(
					'yith_wcaf_payments_statuses',
					array(
						'pending'   => array(
							'slug' => 'pending',
							'name' => _x( 'Pending', '[ADMIN] Payment status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Pending', 'Pending', '[ADMIN] Payment status', 'yith-woocommerce-affiliates' ),
						),
						'completed' => array(
							'slug' => 'completed',
							'name' => _x( 'Completed', '[ADMIN] Payment status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Completed', 'Completed', '[ADMIN] Payment status', 'yith-woocommerce-affiliates' ),
						),
						'cancelled' => array(
							'slug' => 'cancelled',
							'name' => _x( 'Canceled', '[ADMIN] Payment status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'Canceled', 'Canceled', '[ADMIN] Payment status', 'yith-woocommerce-affiliates' ),
						),
						'on-hold'   => array(
							'slug' => 'on-hold',
							'name' => _x( 'On hold', '[ADMIN] Payment status', 'yith-woocommerce-affiliates' ),
							'noop' => _nx_noop( 'On hold', 'On hold', '[ADMIN] Payment status', 'yith-woocommerce-affiliates' ),
						),
					)
				);
			}

			return self::$available_statuses;
		}

		/**
		 * Return a human friendly version of a payment status
		 *
		 * @param string $status Status to convert to human friendly form.
		 * @param int    $count  Count of items (used to conditionally show plural form).
		 *
		 * @return string Human friendly status
		 * @since 1.0.0
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
			 * APPLY_FILTERS: yith_wcaf_payments_status_name
			 *
			 * Filters the name of the payment status.
			 *
			 * @param string $label  Status name.
			 * @param string $status Status.
			 */
			return apply_filters( 'yith_wcaf_payments_status_name', $label, $status );
		}

		/**
		 * Return "inactive" statuses
		 * When in any of these status, payment is considered dead, and other payment may be issued for same commissions.
		 *
		 * @return array Inactive statuses
		 * @since 1.0.0
		 */
		public static function get_inactive_statuses() {
			/**
			 * APPLY_FILTERS: yith_wcaf_inactive_payment_statuses
			 *
			 * Filters the inactive statuses for payments.
			 *
			 * @param array $inactive_statuses Array of inactive statuses.
			 */
			return apply_filters( 'yith_wcaf_inactive_payment_statuses', self::$inactive_statuses );
		}

		/**
		 * Return "active" statuses
		 * When in any of these status, payment is active, and commissions reserved.
		 *
		 * @return array Active statuses
		 * @since 1.0.0
		 */
		public static function get_active_statuses() {
			/**
			 * APPLY_FILTERS: yith_wcaf_active_payment_statuses
			 *
			 * Filters the active statuses for payments.
			 *
			 * @param array $active_statuses Array of active statuses.
			 */
			return apply_filters( 'yith_wcaf_active_payment_statuses', self::$active_statuses );
		}

		/**
		 * Return "pending" statuses
		 * When in any of these status, payment is pending, and no other payment can be created for the affiliate.
		 *
		 * @return array Pending statuses
		 * @since 1.0.0
		 */
		public static function get_pending_statuses() {
			/**
			 * APPLY_FILTERS: yith_wcaf_pending_payment_statuses
			 *
			 * Filters the pending statuses for payments.
			 *
			 * @param array $pending_statuses Array of pending statuses.
			 */
			return apply_filters( 'yith_wcaf_pending_payment_statuses', self::$pending_statuses );
		}

		/**
		 * Return "completed" statuses
		 * When in any of these status, payment is completed,  and new payments can be created for the affiliate.
		 *
		 * @return array Completed statuses
		 * @since 1.0.0
		 */
		public static function get_completed_statuses() {
			/**
			 * APPLY_FILTERS: yith_wcaf_completed_payment_statuses
			 *
			 * Filters the completed statuses for payments.
			 *
			 * @param array $completed_statuses Array of completed statuses.
			 */
			return apply_filters( 'yith_wcaf_completed_payment_statuses', self::$completed_statuses );
		}

		/**
		 * List of "payment" status slugs
		 * When in any of these status, payment is issued to gateway, and cannot be changed
		 *
		 * @return array Completed statuses
		 * @since 1.0.0
		 */
		public static function get_payment_statuses() {
			/**
			 * APPLY_FILTERS: yith_wcaf_paid_payment_statuses
			 *
			 * Filters the paid statuses for payments.
			 *
			 * @param array $payment_statuses Array of paid statuses.
			 */
			return apply_filters( 'yith_wcaf_paid_payment_statuses', self::$payment_statuses );
		}

		/**
		 * Return a map of available status changes for payments
		 *
		 * @return array Array of valid status changes, in the following format:
		 * [
		 *     origin_status => [ ... destination_statuses ] // array of valid destination statuses
		 * ]
		 */
		public static function get_available_status_changes() {
			/**
			 * APPLY_FILTERS: yith_wcaf_available_payment_status_changes
			 *
			 * Filters the available status changes for payments.
			 *
			 * @param array $available_status_changes Array of valid status changes.
			 */
			return apply_filters( 'yith_wcaf_available_payment_status_changes', self::$available_status_changes );
		}

		/* === HELPER METHODS === */

		/**
		 * Count payments matching filtering params
		 *
		 * @param array $args Filtering params (@see YITH_WCAF_Payment_Data_Store::query).
		 *
		 * @return int Payments count
		 * @see   \YITH_WCAF_Payments::get_payments
		 * @since 1.0.0
		 */
		public function count_payments( $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'payment' );

				$count = $data_store->count( $args );
			} catch ( Exception $e ) {
				return 0;
			}

			return $count;
		}

		/**
		 * Retrieve payments matching filtering params
		 *
		 * @param array $args Filtering params (@see YITH_WCAF_Payment_Data_Store::query).
		 *
		 * @return YITH_WCAF_Payments_Collection|bool Array with found commissions, or false on failure
		 * @since 1.0.0
		 */
		public function get_payments( $args = array() ) {
			return YITH_WCAF_Payment_Factory::get_payments( $args );
		}

		/**
		 * Retrieve a payment with given id
		 *
		 * @param int $payment_id Payment id.
		 *
		 * @return YITH_WCAF_Payment|bool Retrieved payment, or false on failure.
		 * @since 1.0.0
		 */
		public function get_payment( $payment_id ) {
			return YITH_WCAF_Payment_Factory::get_payment( $payment_id );
		}

		/**
		 * Returns an array of commission related to a given payment
		 *
		 * @param int $payment_id Payment id.
		 *
		 * @return YITH_WCAF_Payments_Collection|bool Array of retrieved commissions; false on failure.
		 * @since 1.0.0
		 */
		public function get_payment_commissions( $payment_id ) {
			$payment = YITH_WCAF_Payment_Factory::get_payment( $payment_id );

			if ( ! $payment ) {
				return false;
			}

			return $payment->get_commissions();
		}

		/**
		 * Return an array of payments related to a given commission
		 *
		 * @param int    $commission_id Commission id.
		 * @param string $status        Searched payment status; valid values are 'all' (all payments), 'active' (on-hold, pending and completed payments) and 'inactive' (cancelled payments).
		 *
		 * @return mixed Array of payments, or false on failure
		 * @since 1.0.0
		 */
		public function get_commission_payments( $commission_id, $status = 'all' ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return false;
			}

			if ( 'active' === $status ) {
				return $commission->get_active_payments();
			} elseif ( 'inactive' === $status ) {
				return $commission->get_inactive_payments();
			}

			return $commission->get_payments();
		}

		/**
		 * Register payments for a bunch of commissions; will create different mass pay foreach affiliate referred by commissions
		 *
		 * @param int[]|int   $commission_ids       Array of commissions to pay IDs, or single commission id.
		 * @param bool        $proceed_with_payment Not in use.
		 * @param bool|string $gateway_id           Not in use.
		 *
		 * @return mixed Array with payment status, when \$proceed_with_payment is enabled; false otherwise
		 */
		public function register_payment( $commission_ids, $proceed_with_payment = true, $gateway_id = false ) {
			// if no commission passed, return.
			if ( empty( $commission_ids ) ) {
				return array(
					'status'   => false,
					'messages' => __( 'You have to select at least one commission', 'yith-woocommerce-affiliates' ),
				);
			}

			// if single commission id provided, convert it to array.
			$commission_ids = (array) $commission_ids;
			$can_be_paid    = array();
			$cannot_be_paid = array();

			// groups commissions per affiliate/currency.
			$raw_payments = array();

			foreach ( $commission_ids as $commission_id ) {
				$commission = YITH_WCAF_Commissions()->get_commission( $commission_id );

				// if can't find commission, continue.
				if ( ! $commission ) {
					continue;
				}

				// if current status doesn't allow payments, continue.
				$available_status_change = YITH_WCAF_Commissions::get_available_status_change( $commission_id );

				if ( ! in_array( 'pending-payment', $available_status_change, true ) ) {
					continue;
				}

				$commission_id = $commission->get_id();
				$affiliate_id  = $commission->get_affiliate_id();
				$affiliate     = $commission->get_affiliate();

				// if can't find affiliate, continue.
				if ( ! $affiliate ) {
					continue;
				}

				$payment_email = $affiliate->get_payment_email();

				// if there is no payment registered for the affiliate, set one.
				if ( ! isset( $raw_payments[ $affiliate_id ] ) ) {
					$raw_payments[ $affiliate_id ]                 = array();
					$raw_payments[ $affiliate_id ]['affiliate_id'] = $affiliate_id;
					$raw_payments[ $affiliate_id ]['email']        = $payment_email;
					$raw_payments[ $affiliate_id ]['gateway_id']   = $gateway_id ? $gateway_id : '';
				}

				$commission_currency = $commission->get_currency();

				if ( ! isset( $raw_payments[ $affiliate_id ]['payments'][ $commission_currency ] ) ) {
					$raw_payments[ $affiliate_id ]['payments'][ $commission_currency ] = array(
						'amount'      => 0,
						'commissions' => array(),
					);
				}

				$raw_payments[ $affiliate_id ]['payments'][ $commission_currency ]['commissions'][] = $commission_id;
				$raw_payments[ $affiliate_id ]['payments'][ $commission_currency ]['amount']       += $commission->get_amount();

				$can_be_paid[] = $commission_id;
			}

			// retrieve commissions that cannot be paid.
			$cannot_be_paid = array_diff( $commission_ids, $can_be_paid );

			// register one payment for each affiliate/currency pair.
			$payments = array();

			if ( ! empty( $raw_payments ) ) {
				foreach ( $raw_payments as $payments_args ) {
					$payments_to_create = $payments_args['payments'];

					if ( empty( $payments_to_create ) ) {
						continue;
					}

					foreach ( $payments_to_create as $currency => $payment_args ) {
						$payment = new YITH_WCAF_Payment();

						$payment_args = array_merge(
							$payment_args,
							$payments_args,
							array(
								'currency' => $currency,
							)
						);

						unset( $payment_args['payments'] );

						$payment->set_props( $payment_args );

						// set gateway data, if any.
						if ( $gateway_id && class_exists( 'YITH_WCAF_Gateways' ) && YITH_WCAF_Gateways::is_valid_gateway( $gateway_id ) ) {
							$payment->set_gateway_id( $gateway_id );
							$payment->set_gateway_details( $affiliate->get_gateway_preferences( $gateway_id ) );
						}

						$payment->save();

						$payments[] = $payment;
					}
				}
			}

			/**
			 * DO_ACTION: yith_wcaf_after_register_payment
			 *
			 * Allows to trigger some action after the payments has been registered.
			 *
			 * @param array  $payments   Array of payments.
			 * @param string $gateway_id Gateway id to use for payments.
			 */
			do_action( 'yith_wcaf_after_register_payment', $payments, $gateway_id );

			return array(
				'status'         => true,
				'messages'       => __( 'Payment correctly registered', 'yith-woocommerce-affiliates' ),
				'payments'       => $payments,
				'can_be_paid'    => $can_be_paid,
				'cannot_be_paid' => $cannot_be_paid,
			);
		}

		/**
		 * Returns count of payments, grouped by status
		 *
		 * @param string $status Specific status to count, or all to obtain a global statistic.
		 * @param array  $args   Array of arguments to filter status query<br/>
		 *                [<br/>
		 *                'affiliate_id' => false,         // Affiliate ID (int)<br/>
		 *                'interval' => false,             // Payment creation date range (array, with at lest one of this index: [start_date(string; mysql date format)|end_date(string; mysql date format)])<br/><br/>
		 *                ].
		 *
		 * @return int|array Count per state, or array indexed by status, with status count.
		 * @since 1.0.0
		 */
		public function per_status_count( $status = 'all', $args = array() ) {
			try {
				$data_store = WC_Data_Store::load( 'payment' );

				$count = $data_store->per_status_count( $status, $args );
			} catch ( Exception $e ) {
				return 0;
			}

			return $count;
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Payment_Handler class
 *
 * @return \YITH_WCAF_Payments
 * @since 1.0.0
 */
function YITH_WCAF_Payments() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Payments::get_instance();
}
