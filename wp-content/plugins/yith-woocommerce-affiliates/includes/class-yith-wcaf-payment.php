<?php
/**
 * Payment class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Payment' ) ) {

	/**
	 * Payment object
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Payment extends YITH_WCAF_Abstract_Object {

		/**
		 * Stores meta in cache for future reads.
		 *
		 * A group must be set to to enable caching.
		 *
		 * @var string
		 */
		protected $cache_group = 'payments';

		/**
		 * Stores affiliate object for current payment
		 *
		 * @var YITH_WCAF_Affiliate
		 */
		protected $affiliate = null;

		/**
		 * Stores payment notes.
		 *
		 * @var YITH_WCAF_Note[]
		 */
		protected $notes = array();

		/**
		 * Stores commissions' objects for current payment
		 *
		 * @var YITH_WCAF_Commissions_Collection
		 */
		protected $commissions = null;

		/**
		 * Stores commissions' objects for current payment, before any change
		 *
		 * @var YITH_WCAF_Commissions_Collection
		 */
		protected $original_commissions = null;

		/**
		 * Constructor
		 *
		 * @param int|\YITH_WCAF_Payment $payment Payment identifier.
		 *
		 * @throws Exception When not able to load Data Store class.
		 */
		public function __construct( $payment = 0 ) {
			// set default values.
			$this->data = array(
				'affiliate_id'    => 0,
				'email'           => '',
				'gateway_id'      => '',
				'status'          => 'on-hold',
				'amount'          => 0,
				'created_at'      => '',
				'completed_at'    => '',
				'transaction_key' => '',
				'gateway_details' => array(),
			);

			parent::__construct();

			if ( is_numeric( $payment ) && $payment > 0 ) {
				$this->set_id( $payment );
			} elseif ( $payment instanceof self ) {
				$this->set_id( $payment->get_id() );
			} else {
				$this->set_object_read( true );
			}

			$this->data_store = WC_Data_Store::load( 'payment' );

			if ( $this->get_id() > 0 ) {
				$this->data_store->read( $this );
			}
		}

		/* === GETTERS === */

		/**
		 * Return affiliate id for current payment
		 *
		 * @param string $context Context of the operation.
		 * @return int Affiliate id.
		 */
		public function get_affiliate_id( $context = 'view' ) {
			return (int) $this->get_prop( 'affiliate_id', $context );
		}

		/**
		 * Return affiliate object for current payment
		 *
		 * @param string $context Context of the operation.
		 * @param bool   $refresh Whether to read affiliate again from db, even if a cached version exists.
		 * @return YITH_WCAF_Affiliate Affiliate object.
		 */
		public function get_affiliate( $context = 'view', $refresh = false ) {
			$affiliate_id = $this->get_affiliate_id( $context );

			if ( ! $affiliate_id ) {
				return null;
			}

			if ( empty( $this->affiliate ) || $affiliate_id !== $this->affiliate->get_id() || $refresh ) {
				$this->affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_id( $affiliate_id );
			}

			return $this->affiliate;
		}

		/**
		 * Return payment email for current payment (deprecated)
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Payment email.
		 */
		public function get_email( $context = 'view' ) {
			return $this->get_prop( 'email', $context );
		}

		/**
		 * Return gateway id for current payment
		 *
		 * @param string $context Context of the operation.
		 * @return string Gateway id (textual slug).
		 */
		public function get_gateway_id( $context = 'view' ) {
			return $this->get_prop( 'gateway_id', $context );
		}

		/**
		 * Return gateway object for current payment
		 *
		 * @param string $context Context of the operation.
		 * @return YITH_WCAF_Abstract_Gateway Gateway object.
		 */
		public function get_gateway( $context = 'view' ) {
			return YITH_WCAF_Gateways::get_gateway( $this->get_gateway_id( $context ) );
		}

		/**
		 * Returns formatted gateway name
		 *
		 * @param string $context Context of the operation.
		 * @return string Gateway name.
		 */
		public function get_formatted_gateway( $context = 'view' ) {
			$gateway = $this->get_gateway( $context );

			if ( ! $gateway ) {
				return _x( 'Manual payment', '[ADMIN] Placeholder gateway', 'yith-woocommerce-affiliates' );
			}

			return $gateway->get_name();
		}

		/**
		 * Return amount for current payment
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return float Payment amount.
		 */
		public function get_amount( $context = 'view' ) {
			return (float) $this->get_prop( 'amount', $context );
		}

		/**
		 * Return formatted amount for current payment
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Additional arguments for wc_price function.
		 *
		 * @return string Formatted payment amount.
		 */
		public function get_formatted_amount( $context = 'view', $args = array() ) {
			$amount = (float) $this->get_prop( 'amount', $context );

			return wc_price(
				$amount,
				array_merge(
					array(
						'currency' => $this->get_currency(),
					),
					$args
				)
			);
		}

		/**
		 * Return current status of the payment, as stored in database
		 *
		 * @param string|array $statuses Array of statues to check.
		 *
		 * @return bool Whether payment has status.
		 */
		public function has_status( $statuses ) {
			if ( ! is_array( $statuses ) ) {
				$statuses = (array) $statuses;
			}

			return in_array( $this->get_status(), $statuses, true );
		}

		/**
		 * Return current status of the payment, as a slug
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string payment status.
		 */
		public function get_status( $context = 'view' ) {
			$available_statuses = YITH_WCAF_Payments::get_available_statuses();
			$current_status     = $this->get_prop( 'status', $context );

			// if status is unknown, default to new.
			if ( ! isset( $available_statuses[ $current_status ] ) ) {
				return $available_statuses['on-hold']['slug'];
			}

			return $available_statuses[ $current_status ]['slug'];
		}

		/**
		 * Checks whether current payment is active or not
		 *
		 * @return bool
		 */
		public function is_active() {
			return $this->has_status( YITH_WCAF_Payments::get_active_statuses() );
		}

		/**
		 * Checks whether current payment is inactive or not
		 *
		 * @return bool
		 */
		public function is_inactive() {
			return $this->has_status( YITH_WCAF_Payments::get_inactive_statuses() );
		}

		/**
		 * Checks whether current payment is pending (waiting for gateway confirmation, no other payment can be created)
		 *
		 * @return bool
		 */
		public function is_pending() {
			return $this->has_status( YITH_WCAF_Payments::get_pending_statuses() );
		}

		/**
		 * Checks whether current payment is paid (or in the process of being paid)
		 *
		 * @return bool
		 */
		public function is_paid() {
			return $this->has_status( YITH_WCAF_Payments::get_payment_statuses() );
		}

		/**
		 * Checks if current payment can be sent through a gateway to issue payment
		 *
		 * @return bool Whether payment can be processed.
		 */
		public function can_be_paid() {
			/**
			 * APPLY_FILTERS: yith_wcaf_payment_can_be_paid
			 *
			 * Filters whether the current payment can be paid.
			 *
			 * @param bool              $can_be_paid Whether the payment can be paid or not.
			 * @param YITH_WCAF_Payment $payment     Payment object.
			 * @param int               $id          Payment id.
			 */
			return apply_filters( 'yith_wcaf_payment_can_be_paid', ! $this->is_paid() && $this->can_change_status( 'pending' ), $this, $this->get_id() );
		}

		/**
		 * Returns all possible destination statuses for current payment
		 *
		 * @return array Array of status slugs.
		 */
		public function get_available_status_changes() {
			$available_changes = YITH_WCAF_payments::get_available_status_changes();
			$status            = $this->get_status();

			if ( ! isset( $available_changes[ $status ] ) ) {
				return array();
			}

			return $available_changes[ $status ];
		}

		/**
		 * Checks if current payment can move to a specified status
		 *
		 * @param string $destination_status Destination status slug.
		 * @return bool Whether payment can change status
		 */
		public function can_change_status( $destination_status ) {
			$available_statuses = wp_list_pluck( YITH_WCAF_Payments::get_available_statuses(), 'slug' );

			if ( ! in_array( $destination_status, $available_statuses, true ) ) {
				return false;
			}

			return in_array( $destination_status, $this->get_available_status_changes(), true );
		}

		/**
		 * Return current status of the payment, as a localized string
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Payment formatted status.
		 */
		public function get_formatted_status( $context = 'view' ) {
			$available_statuses = YITH_WCAF_Payments::get_available_statuses();
			$current_status     = $this->get_prop( 'status', $context );

			// if status is unknown, default to new.
			if ( ! isset( $available_statuses[ $current_status ] ) ) {
				return $available_statuses['pending']['name'];
			}

			return $available_statuses[ $current_status ]['name'];
		}

		/**
		 * Return shortened version of the formatted status
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Commission shortened status.
		 */
		public function get_shortened_status( $context = 'view' ) {
			$formatted_status = $this->get_formatted_status( $context );
			$status_words     = explode( ' ', $formatted_status );
			$status_initials  = array_map(
				function( $item ) {
					return strtoupper( substr( $item, 0, 1 ) );
				},
				$status_words
			);

			return implode( '', $status_initials );
		}

		/**
		 * Return object representing date commission was created.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return WC_DateTime|string Creation date.
		 */
		public function get_created_at( $context = 'view' ) {
			$created_at = $this->get_prop( 'created_at', $context );

			if ( $created_at && 'view' === $context ) {
				return $created_at->date_i18n( 'Y-m-d H:i:s' );
			}

			return $created_at;
		}

		/**
		 * Return object representing date commission was created.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return WC_DateTime|string Creation date.
		 */
		public function get_created_time( $context = 'view' ) {
			$created_at = $this->get_prop( 'created_at', $context );

			if ( ! $created_at ) {
				return false;
			}

			return $created_at->getTimestamp();
		}

		/**
		 * Return object representing date commission was created.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return WC_DateTime|string Creation date.
		 */
		public function get_completed_at( $context = 'view' ) {
			$completed_at = $this->get_prop( 'completed_at', $context );

			if ( $completed_at && 'view' === $context ) {
				return $completed_at->date_i18n( 'Y-m-d H:i:s' );
			}

			return $completed_at;
		}

		/**
		 * Return object representing date commission was created.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return WC_DateTime|string Creation date.
		 */
		public function get_completed_time( $context = 'view' ) {
			$completed_at = $this->get_prop( 'completed_at', $context );

			if ( ! $completed_at ) {
				return false;
			}

			return $completed_at->getTimestamp();
		}

		/**
		 * Return transaction unique key, if any.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Transaction key.
		 */
		public function get_transaction_key( $context = 'view' ) {
			return $this->get_prop( 'transaction_key', $context );
		}

		/**
		 * Return gateway details, if any
		 * Gateway details are a collection of info used by the gateway to process the transaction,
		 * and stored in the payment record
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return array Gateway details.
		 */
		public function get_gateway_details( $context = 'view' ) {
			return $this->get_prop( 'gateway_details', $context );
		}

		/**
		 * Returns gateway details, formatted for view (@see \YITH_WCAF_Payment::get_gateway_details)
		 *
		 * @return string Formatted gateway details.
		 */
		public function get_formatted_gateway_details() {
			$gateway_id = $this->get_gateway_id();
			$details    = $this->get_gateway_details();

			if ( ! $gateway_id || ! class_exists( 'YITH_WCAF_Gateways' ) ) {
				return '';
			}

			$gateway = YITH_WCAF_Gateways::get_gateway( $gateway_id );

			if ( ! $gateway || ! $gateway->has_fields() ) {
				return '';
			}

			$fields    = $gateway->get_fields();
			$formatted = '';

			foreach ( $fields as $field_id => $field ) {
				$value      = isset( $details[ $field_id ] ) ? $details[ $field_id ] : _x( 'N/A', '[ADMIN] General empty field', 'yith-woocommerce-affiliates' );
				$formatted .= "{$field['label']}: {$value}\n";
			}

			return $formatted;
		}

		/**
		 * Returns a list of actions that admin can perform over these object, including url to perform them.
		 *
		 * @return array Array of valid actions.
		 */
		public function get_admin_actions() {
			if ( empty( $this->admin_actions ) ) {
				$item_id                  = $this->get_id();
				$available_status_changes = $this->get_available_status_changes();

				if ( ! empty( $available_status_changes ) ) {
					foreach ( $available_status_changes as $status ) {
						if ( 'pending' === $status ) {
							continue;
						}

						$readable_status = YITH_WCAF_Payments()->get_readable_status( $status );

						$this->admin_actions[ "switch_to_{$status}" ] = array(
							// translators: 1. Status name.
							'label' => sprintf( _x( 'Change status to %s', '[ADMIN] Single payment actions', 'yith-woocommerce-affiliates' ), strtolower( $readable_status ) ),
							'url'   => YITH_WCAF_Admin_Actions::get_action_url(
								'change_status',
								array(
									'payment_id' => $item_id,
									'status'     => $status,
								)
							),
							'class' => $status,
						);
					}
				}

				if ( $this->can_be_paid() && class_exists( 'YITH_WCAF_Gateways' ) ) {
					$available_gateways = YITH_WCAF_Gateways::get_available_gateways();

					if ( ! empty( $available_gateways ) ) {
						foreach ( $available_gateways as $gateway_id => $gateway ) {
							$this->admin_actions[ "pay_via_{$gateway_id}" ] = array(
								// translators: 1. Payment gateway label.
								'label' => sprintf( _x( 'Pay via %s', '[ADMIN] Single payment actions', 'yith-woocommerce-affiliates' ), $gateway->get_name() ),
								'url'   => YITH_WCAF_Admin_Actions::get_action_url(
									'pay',
									array(
										'payment_id' => $item_id,
										'gateway'    => $gateway_id,
									)
								),
								'class' => "pay pay-via-{$gateway_id}",
							);
						}
					}
				}
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_payment_admin_actions
			 *
			 * Filters the available actions for each payment in the payments table.
			 *
			 * @param array             $actions Actions.
			 * @param int               $id      Payment id.
			 * @param YITH_WCAF_Payment $payment Payment object.
			 */
			return apply_filters( 'yith_wcaf_payment_admin_actions', parent::get_admin_actions(), $this->get_id(), $this );
		}

		/**
		 * Get admin edit url for current object
		 *
		 * @return string|bool Admin edit url; false on failure
		 */
		public function get_admin_edit_url() {
			if ( ! is_admin() ) {
				return false;
			}

			if ( ! YITH_WCAF_Admin()->current_user_can_manage_panel() ) {
				return false;
			}

			return YITH_WCAF_Admin()->get_tab_url( 'commissions', 'commissions-payments', array( 'payment_id' => $this->get_id() ) );
		}

		/**
		 * Returns currency for this payment (by default it will return store currency)
		 *
		 * @return string Payment currency
		 */
		public function get_currency() {
			return get_woocommerce_currency();
		}

		/* === INVOICE === */

		/**
		 * Check whether payment has invoice
		 *
		 * @return bool Whether invoice exists or not.
		 */
		public function has_invoice() {
			if ( ! function_exists( 'YITH_WCAF_Invoices' ) || ! YITH_WCAF_Invoices()->show_invoices_to_affiliate() ) {
				return false;
			}

			return ! ! YITH_WCAF_Invoices()->get_invoice_path( $this->get_id() );
		}

		/**
		 * Get url to invoice
		 *
		 * @return string|bool Url to invoice, or false if there is no invoice
		 */
		public function get_invoice_url() {
			if ( ! $this->has_invoice() ) {
				return false;
			}

			return YITH_WCAF_Invoices()->get_invoice_publishable_url( $this->get_id() );
		}

		/* === COMMISSIONS === */

		/**
		 * Read commissions if null.
		 *
		 * @since 3.0.0
		 */
		protected function maybe_read_commissions() {
			if ( is_null( $this->commissions ) ) {
				$this->read_commissions();
			}
		}

		/**
		 * Read Commissions from the database. Ignore any internal properties.
		 *
		 * @since 2.6.0
		 * @param bool $force_read True to force a new DB read (and update cache).
		 */
		public function read_commissions( $force_read = false ) {
			$this->meta_data = array();
			$cache_loaded    = false;

			if ( ! $this->get_id() ) {
				return;
			}

			if ( ! $this->data_store ) {
				return;
			}

			if ( ! empty( $this->cache_group ) ) {
				// Prefix by group allows invalidation by group until https://core.trac.wordpress.org/ticket/4476 is implemented.
				$cache_key = WC_Cache_Helper::get_cache_prefix( $this->cache_group ) . WC_Cache_Helper::get_cache_prefix( 'object_' . $this->get_id() ) . 'object_commissions_' . $this->get_id();
			}

			if ( ! $force_read ) {
				if ( ! empty( $this->cache_group ) ) {
					$cached_commissions = wp_cache_get( $cache_key, $this->cache_group );
					$cache_loaded       = ! empty( $cached_commissions );
				}
			}

			if ( $cache_loaded ) {
				$commissions = new YITH_WCAF_Commissions_Collection( $cached_commissions );
			} else {
				$commissions = $this->data_store->read_commissions( $this );
			}

			if ( ! $commissions ) {
				return;
			}

			// sets class attributes.
			$this->commissions          = $commissions;
			$this->original_commissions = $commissions;

			if ( ! $cache_loaded && ! empty( $this->cache_group ) ) {
				wp_cache_set( $cache_key, $this->commissions->get_ids(), $this->cache_group );
			}
		}

		/**
		 * Returns a list of payment's commissions, eventually matching filtering criteria
		 *
		 * @param array $args Optional array of filtering criteria.
		 *
		 * @return YITH_WCAF_Commissions_Collection|bool List of commissions, if any; false on failure.
		 */
		public function get_commissions( $args = array() ) {
			$this->maybe_read_commissions();

			if ( empty( $this->commissions ) ) {
				return false;
			}

			if ( empty( $args ) ) {
				return $this->commissions;
			}

			return $this->commissions->filter( $args );
		}

		/**
		 * Returns original set of commissions for current object
		 *
		 * @return YITH_WCAF_Commissions_Collection|bool List of commissions, if any; false on failure.
		 */
		public function get_original_commissions() {
			$this->maybe_read_commissions();

			if ( empty( $this->original_commissions ) ) {
				return false;
			}

			return $this->original_commissions;
		}

		/**
		 * Adds a commission by commission id
		 *
		 * @param int $commission_id Commission id.
		 */
		public function add_commission( $commission_id ) {
			$this->maybe_read_commissions();

			if ( is_null( $this->commissions ) ) {
				$this->commissions = new YITH_WCAF_Commissions_Collection();
			}

			$this->commissions->add( $commission_id );
		}

		/**
		 * Removes a commission by commission id
		 *
		 * @param int $commission_id Commission id.
		 */
		public function remove_commission( $commission_id ) {
			$this->maybe_read_commissions();

			if ( is_null( $this->commissions ) ) {
				return;
			}

			$this->commissions->remove( $commission_id );
		}

		/**
		 * Sets a new commission list for current payment
		 *
		 * @param array $commission_ids Array of commission ids to set.
		 * @return void
		 */
		public function set_commissions( $commission_ids ) {
			$this->commissions = new YITH_WCAF_Commissions_Collection( $commission_ids );
		}

		/**
		 * Delete commission list
		 *
		 * @return void
		 */
		public function delete_commissions() {
			// this is required to besure that original_commissions are correctly stored.
			$this->maybe_read_commissions();

			// deletes existing commissions.
			$this->commissions = false;
		}

		/**
		 * Saves current commission list for the object.
		 * If $this->commissions is null, we assume no change was applied to commissions list
		 *
		 * @return void
		 */
		public function save_commissions() {
			if ( ! $this->data_store || is_null( $this->commissions ) ) {
				return;
			}

			$this->data_store->update_commissions( $this );

			if ( ! empty( $this->cache_group ) ) {
				$cache_key = WC_Cache_Helper::get_cache_prefix( $this->cache_group ) . WC_Cache_Helper::get_cache_prefix( 'object_' . $this->get_id() ) . 'object_commissions_' . $this->get_id();
				wp_cache_delete( $cache_key, $this->cache_group );
			}
		}

		/**
		 * Returns true when commissions have been changes
		 *
		 * @return bool Whether commissions were changed or not.
		 */
		public function commissions_need_update() {
			$this->maybe_read_commissions();

			if ( is_null( $this->commissions ) ) {
				return false;
			}

			$commissions             = $this->commissions;
			$commission_ids          = $commissions ? $commissions->get_ids() : array();
			$original_commissions    = $this->original_commissions;
			$original_commission_ids = $original_commissions ? $original_commissions->get_ids() : array();

			return ! ! array_diff( $commission_ids, $original_commission_ids );
		}

		/* === SETTERS === */

		/**
		 * Set affiliate id for the commission
		 *
		 * @param int $affiliate_id Affiliate id for current commission.
		 */
		public function set_affiliate_id( $affiliate_id ) {
			$affiliate_id = (int) $affiliate_id;

			// checks that we're referring an existing user.
			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_id( $affiliate_id );

			if ( ! $affiliate ) {
				return;
			}

			$this->set_prop( 'affiliate_id', $affiliate_id );
			$this->affiliate = $affiliate;
		}

		/**
		 * Set payment email for the payment
		 *
		 * @param string $payment_email Payment email.
		 */
		public function set_email( $payment_email ) {
			if ( ! is_email( $payment_email ) ) {
				return;
			}

			$this->set_prop( 'email', $payment_email );
		}

		/**
		 * Return gateway id for current payment
		 *
		 * @param string $gateway_id Gateway slug.
		 */
		public function set_gateway_id( $gateway_id ) {
			if ( ! YITH_WCAF_Gateways::is_valid_gateway( $gateway_id ) ) {
				return;
			}

			$this->set_prop( 'gateway_id', $gateway_id );
		}

		/**
		 * Set amount for the commission
		 *
		 * @param float $amount Commission amount.
		 */
		public function set_amount( $amount ) {
			$amount = (float) $amount;

			if ( $amount < 0 ) {
				$amount = 0;
			}

			$this->set_prop( 'amount', $amount );
		}

		/**
		 * Set payment status
		 *
		 * @param string $status Status for the payment.
		 * @param string $note   Optional note to register within the payment.
		 * @param bool   $force  Whether to force status change, even if checks fail.
		 */
		public function set_status( $status, $note = '', $force = false ) {
			$available_statuses = YITH_WCAF_Payments::get_available_statuses();
			$statuses           = wp_list_pluck( $available_statuses, 'slug' );

			if ( $this->object_read && ! $this->can_change_status( $status ) && ! $force ) {
				return;
			}

			$new_status = array_flip( $statuses )[ $status ];

			if ( false === $new_status ) {
				return;
			}

			$this->set_prop( 'status', $new_status );

			if ( 'completed' === $new_status ) {
				$this->set_completed_at( time() );
			}

			if ( ! empty( $note ) ) {
				$this->add_note( $note );
			}
		}

		/**
		 * Set date payment was created
		 *
		 * @param int|string $created_at Date of creation (timestamp or date).
		 */
		public function set_created_at( $created_at ) {
			$this->set_date_prop( 'created_at', $created_at );
		}

		/**
		 * Set date payment was completed
		 *
		 * @param int|string $completed_at Date payment was completed (timestamp or date).
		 */
		public function set_completed_at( $completed_at ) {
			$this->set_date_prop( 'completed_at', $completed_at );
		}

		/**
		 * Set transaction key for the payment
		 *
		 * @param string $transaction_key Transaction key.
		 */
		public function set_transaction_key( $transaction_key ) {
			$this->set_prop( 'transaction_key', $transaction_key );
		}

		/**
		 * Set gateway details
		 *
		 * @param array $gateway_details Gateway details.
		 */
		public function set_gateway_details( $gateway_details ) {
			$this->set_prop( 'gateway_details', $gateway_details );
		}

		/**
		 * Set gateway details
		 *
		 * @param array $gateway_details Gateway details.
		 */
		public function update_gateway_details( $gateway_details ) {
			$old_gateway_details = $this->get_gateway_details();

			$this->set_prop(
				'gateway_details',
				array_merge(
					$old_gateway_details,
					$gateway_details
				)
			);
		}

		/**
		 * Delete gateway details
		 */
		public function delete_gateway_details() {
			$this->set_prop( 'gateway_details', array() );
		}

		/* === CAPABILITIES CHECK === */

		/**
		 * Checks whether specified user can perform operations over current object
		 *
		 * @param int    $user_id    User to check.
		 * @param string $capability Capability to check; child objects may implement their logic for vaiours capabilities, if needed.
		 *
		 * @return bool Whether current use can perform action or not.
		 */
		public function user_can( $user_id, $capability ) {
			$object_type = strtolower( self::class );

			if ( in_array( $capability, array( 'read', 'download_invoice' ), true ) && $this->is_user_owner( $user_id ) ) {
				$can = true;
			} else {
				$can = user_can( $user_id, YITH_WCAF_Admin()->get_panel_capability() );
			}

			/**
			 * APPLY_FILTERS: $object_type_user_can
			 *
			 * Filters whether the user can perform operations over current payment.
			 * <code>$object_type</code> will be replaced with the object type the operation will be performed to.
			 *
			 * @param bool   $can        Whether the user can perform operations or not.
			 * @param int    $user_id    User id.
			 * @param string $capability Capability to check.
			 */
			return apply_filters( "{$object_type}_user_can", $can, $user_id, $capability );
		}

		/* === OVERRIDES === */

		/**
		 * Save should create or update based on object existence.
		 *
		 * @return int
		 */
		public function save() {
			$changes  = $this->get_changes();
			$old_data = $this->get_data();

			$new_id = parent::save();

			// executes required adjustments to commissions object after changes.
			if ( array_intersect( array_keys( $changes ), array( 'status' ) ) || $this->commissions_need_update() ) {
				$did_status_change = in_array( 'status', array_keys( $changes ), true );

				$this->sync_commissions( $did_status_change );
			}

			// execute status change actions.
			if ( isset( $changes['status'] ) ) {
				$payment_id = $this->get_id();
				$new_status = $this->get_status();

				// retrieve old status slug.
				$available_statuses = YITH_WCAF_Payments::get_available_statuses();

				$old_status = $old_data['status'];
				$old_status = isset( $available_statuses[ $old_status ] ) ? $available_statuses[ $old_status ]['slug'] : '';

				/**
				 * DO_ACTION: yith_wcaf_payment_status_$new_status
				 *
				 * Allows to trigger some action when the payment status changes into a new status.
				 * <code>$new_status</code> will be replaced with the new status for the payment.
				 *
				 * @param int $payment_id Payment id.
				 */
				do_action( "yith_wcaf_payment_status_{$new_status}", $payment_id );

				/**
				 * DO_ACTION: yith_wcaf_payment_status_$old_status_to_$new_status
				 *
				 * Allows to trigger some action when the payment status changes from the old status into the new status.
				 * <code>$old_status</code> will be replaced with the old payment status.
				 * <code>$new_status</code> will be replaced with the new payment status.
				 *
				 * @param int $payment_id Payment id.
				 */
				do_action( "yith_wcaf_payment_status_{$old_status}_to_{$new_status}", $payment_id );

				/**
				 * DO_ACTION: yith_wcaf_payment_status_changed
				 *
				 * Allows to trigger some action when the payment status has changed.
				 *
				 * @param int    $payment_id Payment id.
				 * @param string $new_status New status.
				 * @param string $old_status Old status.
				 */
				do_action( 'yith_wcaf_payment_status_changed', $payment_id, $new_status, $old_status );
			}

			return $new_id;
		}

		/**
		 * Delete an object, set the ID to 0, and return result.
		 *
		 * @param bool $force_delete Whether to delete forcefully payment.
		 * @return bool result
		 */
		public function delete( $force_delete = false ) {
			if ( ! $this->data_store ) {
				return false;
			}

			$this->data_store->delete(
				$this,
				array(
					'force_delete' => $force_delete,
				)
			);

			$this->set_id( 0 );
			$this->sync_commissions();

			return true;
		}

		/* === EXTERNAL OBJECTS HANDLING === */

		/**
		 * Sync changes to commissions object when saving data for the commission
		 *
		 * @param bool $process_all Whether to process all commissions, instead of just new ones (EG: payment status has changed).
		 */
		protected function sync_commissions( $process_all = false ) {
			$payment_id = $this->get_id();

			// if we need to process all commissions, we need to retrieve them first.
			if ( $process_all ) {
				$this->maybe_read_commissions();
			}

			// retrieve new and original commissions.
			$commissions             = $this->commissions;
			$commission_ids          = $commissions ? $commissions->get_ids() : array();
			$original_commissions    = $this->original_commissions;
			$original_commission_ids = $original_commissions ? $original_commissions->get_ids() : array();

			// if ->commissions is null, we assume no change has been applied to commissions.
			if ( is_null( $commissions ) ) {
				return;
			}

			// process new commissions, and switch status accordingly.
			$new_commissions = $process_all ? $commission_ids : array_diff( $commission_ids, $original_commission_ids );

			foreach ( $new_commissions as $commission_id ) {
				$commission = $commissions[ $commission_id ];

				if ( ! $commission || ! $commission instanceof YITH_WCAF_Commission ) {
					continue;
				}

				if ( $this->has_status( 'completed' ) ) {
					$new_status = 'paid';
				} elseif ( $this->is_pending() ) {
					$new_status = 'pending-payment';
				} else {
					$order      = $commission->get_order();
					$new_status = $order ? YITH_WCAF_Orders()->map_commission_status( $order->get_status() ) : 'pending';
				}

				// force commission status change.
				$message = sprintf(
					// translators: 1. Old status. 2. New status. 3. Payment id.
					_x( 'The commission status changed from %1$s to %2$s because of changes to payment #%3$s.', '[ADMIN] Note added to commission when status changes because of related payment operation', 'yith-woocommerce-affiliates' ),
					$commission->get_formatted_status(),
					YITH_WCAF_Commissions::get_readable_status( $new_status ),
					$payment_id
				);

				$commission->set_status( $new_status, $message, true );
				$commission->save();
			}

			// process old commissions, and switch status accordingly.
			$old_commissions = array_diff( $original_commission_ids, $commission_ids );

			foreach ( $old_commissions as $commission_id ) {
				$commission = $original_commissions[ $commission_id ];

				if ( ! $commission || ! $commission instanceof YITH_WCAF_Commission ) {
					continue;
				}

				$order      = $commission->get_order();
				$new_status = $order ? YITH_WCAF_Orders()->map_commission_status( $order->get_status() ) : 'pending';

				$message = sprintf(
				// translators: 1. Old status. 2. New status. 3. Payment id.
					_x( 'The commission status changed from %1$s to %2$s because of changes to payment #%3$s.', '[ADMIN] Note added to commission when status changes because of related payment operation', 'yith-woocommerce-affiliates' ),
					$commission->get_formatted_status(),
					YITH_WCAF_Commissions::get_readable_status( $new_status ),
					$payment_id
				);

				$commission->set_status( $new_status, $message, true );
				$commission->save();
			}

			// now that everything is synced up on db, original_commissions are current commissions.
			$this->original_commissions = $this->commissions;
		}

		/* === NOTES === */

		/**
		 * Adds a note for current commissions
		 *
		 * @param string $content Note content.
		 */
		public function add_note( $content ) {
			try {
				$data_store = $this->get_data_store();
				$new_note   = new YITH_WCAF_Note(
					array(
						'content' => $content,
					)
				);

				$data_store->add_note( $this, $new_note );
			} catch ( Exception $e ) {
				return;
			}
		}

		/**
		 * Returns all notes defined for current commissions
		 *
		 * @return YITH_WCAF_Note[] Array of notes for current commission.
		 */
		public function get_notes() {
			if ( empty( $this->notes ) ) {
				try {
					$data_store = $this->get_data_store();
					$raw_notes  = $data_store->read_notes( $this );

					if ( ! empty( $raw_notes ) ) {
						foreach ( $raw_notes as $note ) {
							$this->notes[] = new YITH_WCAF_Note(
								array(
									'id'         => $note->ID,
									'content'    => $note->note_content,
									'created_at' => $note->note_date,
								)
							);
						}
					}
				} catch ( Exception $e ) {
					return array();
				}
			}

			return $this->notes;
		}
	}
}
