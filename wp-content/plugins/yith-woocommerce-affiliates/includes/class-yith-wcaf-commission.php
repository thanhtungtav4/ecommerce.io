<?php
/**
 * Commission class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Commission' ) ) {

	/**
	 * Commission object
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Commission extends YITH_WCAF_Abstract_Object {

		/**
		 * Stores meta in cache for future reads.
		 *
		 * A group must be set to to enable caching.
		 *
		 * @var string
		 */
		protected $cache_group = 'commissions';

		/**
		 * Stores affiliate object for current commission
		 *
		 * @var YITH_WCAF_Affiliate
		 */
		protected $affiliate = null;

		/**
		 * Stores order object for current commission
		 *
		 * @var WC_Order
		 */
		protected $order = null;

		/**
		 * Stores order item object for current commission
		 *
		 * @var WC_Order_Item_Product
		 */
		protected $item = null;

		/**
		 * Stores product object for current commission
		 *
		 * @var WC_Product
		 */
		protected $product = null;

		/**
		 * Stores commission notes.
		 *
		 * @var YITH_WCAF_Note[]
		 */
		protected $notes = array();

		/**
		 * Constructor
		 *
		 * @param int|\YITH_WCAF_Commission $commission Commission identifier.
		 *
		 * @throws Exception When not able to load Data Store class.
		 */
		public function __construct( $commission = 0 ) {
			// set default values.
			$this->data = array(
				'order_id'     => 0,
				'line_item_id' => 0,
				'line_total'   => 0,
				'product_id'   => 0,
				'product_name' => '',
				'affiliate_id' => 0,
				'rate'         => 0,
				'amount'       => 0,
				'refunds'      => 0,
				'status'       => 'pending',
				'created_at'   => '',
				'last_edit'    => '',
			);

			parent::__construct();

			if ( is_numeric( $commission ) && $commission > 0 ) {
				$this->set_id( $commission );
			} elseif ( $commission instanceof self ) {
				$this->set_id( $commission->get_id() );
			} else {
				$this->set_object_read( true );
			}

			$this->data_store = WC_Data_Store::load( 'commission' );

			if ( $this->get_id() > 0 ) {
				$this->data_store->read( $this );
			}
		}

		/* === GETTERS === */

		/**
		 * Return order id for current commission
		 *
		 * @param string $context Context of the operation.
		 * @return int Order id.
		 */
		public function get_order_id( $context = 'view' ) {
			return (int) $this->get_prop( 'order_id', $context );
		}

		/**
		 * Returns order object for current commission
		 *
		 * @param string $context Context of the operation.
		 * @param bool   $refresh Whether to read order again from db, even if a cached version exists.
		 * @return WC_Order Order object.
		 */
		public function get_order( $context = 'view', $refresh = false ) {
			$order_id = $this->get_order_id( $context );

			if ( ! $order_id ) {
				return null;
			}

			if ( empty( $this->order ) || $order_id !== $this->order->get_id() || $refresh ) {
				$this->order = wc_get_order( $order_id );
			}

			return $this->order;
		}

		/**
		 * Return order item id for current commission
		 *
		 * @param string $context Context of the operation.
		 * @return int Order item id.
		 */
		public function get_line_item_id( $context = 'view' ) {
			return (int) $this->get_prop( 'line_item_id', $context );
		}

		/**
		 * Return order item id for current commission
		 *
		 * @param string $context Context of the operation.
		 * @return int Order item id.
		 */
		public function get_order_item_id( $context = 'view' ) {
			return $this->get_line_item_id( $context );
		}

		/**
		 * Returns order item object for current commission
		 *
		 * @param string $context Context of the operation.
		 * @param bool   $refresh Whether to read order item again from db, even if a cached version exists.
		 * @return WC_Order_Item_Product Order item object.
		 */
		public function get_order_item( $context = 'view', $refresh = false ) {
			$item_id = $this->get_order_item_id( $context );

			if ( ! $item_id ) {
				return null;
			}

			if ( empty( $this->item ) || $item_id !== $this->item->get_id() || $refresh ) {
				$order = $this->get_order();

				if ( ! $order ) {
					return null;
				}

				$this->item = $order->get_item( $item_id );
			}

			return $this->item;
		}

		/**
		 * Returns total of the line that was used to generate current commission
		 *
		 * @param string $context Context of the operation.
		 * @return float Line total.
		 */
		public function get_line_total( $context = 'view' ) {
			return (float) $this->get_prop( 'line_total', $context );
		}

		/**
		 * Returns formatted amount for the line item
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Array of arguments for wc_price function.
		 *
		 * @return string HTML for the formatted line item total.
		 */
		public function get_formatted_line_total( $context = 'view', $args = array() ) {
			$order = $this->get_order( $context );

			if ( ! $order ) {
				return '';
			}

			return wc_price(
				$this->get_line_total( $context ),
				array_merge(
					array(
						'currency' => $order->get_currency(),
					),
					$args
				)
			);
		}

		/**
		 * Return product id for current commission
		 *
		 * @param string $context Context of the operation.
		 * @return int Product id.
		 */
		public function get_product_id( $context = 'view' ) {
			return (int) $this->get_prop( 'product_id', $context );
		}

		/**
		 * Return product name for current commission
		 *
		 * @param string $context Context of the operation.
		 * @return string Product name.
		 */
		public function get_product_name( $context = 'view' ) {
			return $this->get_prop( 'product_name', $context );
		}

		/**
		 * Returns product object for current commission
		 *
		 * @param string $context Context of the operation.
		 * @param bool   $refresh Whether to read product again from db, even if a cached version exists.
		 * @return WC_Product Product object.
		 */
		public function get_product( $context = 'view', $refresh = false ) {
			$product_id = $this->get_product_id( $context );

			if ( ! $product_id ) {
				return null;
			}

			if ( empty( $this->product ) || $product_id !== $this->product->get_id() || $refresh ) {
				$this->product = wc_get_product( $product_id );
			}

			return $this->product;
		}

		/**
		 * Return affiliate id for current commission
		 *
		 * @param string $context Context of the operation.
		 * @return int Affiliate id.
		 */
		public function get_affiliate_id( $context = 'view' ) {
			return (int) $this->get_prop( 'affiliate_id', $context );
		}

		/**
		 * Return affiliate object for current commission
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
		 * Return rate for current commission
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return float Commission specific rate.
		 */
		public function get_rate( $context = 'view' ) {
			return (float) $this->get_prop( 'rate', $context );
		}

		/**
		 * Return formatted rate for current commission
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Commission specific rate.
		 */
		public function get_formatted_rate( $context = 'view' ) {
			return yith_wcaf_rate_format( $this->get_rate( $context ) );
		}

		/**
		 * Return amount for current commission
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return float Commission amount.
		 */
		public function get_amount( $context = 'view' ) {
			return (float) $this->get_prop( 'amount', $context );
		}

		/**
		 * Return formatted amount for current commission
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Additional arguments for wc_price function.
		 *
		 * @return string Formatted commission amount.
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
		 * Return currency for current commissions
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Currency for current commission, or general store commission.
		 */
		public function get_currency( $context = 'view' ) {
			$order = $this->get_order( $context );

			if ( ! $order ) {
				return get_woocommerce_currency();
			}

			return $order->get_currency( $context );
		}

		/**
		 * Return refunds for current commission
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return float Commission refund amount.
		 */
		public function get_refunds( $context = 'view' ) {
			return (float) $this->get_prop( 'refunds', $context );
		}

		/**
		 * Return current status of the commission, as stored in database
		 *
		 * @param string|array $statuses Array of statues to check.
		 *
		 * @return bool Whether commission has status.
		 */
		public function has_status( $statuses ) {
			if ( ! is_array( $statuses ) ) {
				$statuses = (array) $statuses;
			}

			return in_array( $this->get_status(), $statuses, true );
		}

		/**
		 * Return current status of the affiliate, as a slug
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Affiliate status.
		 */
		public function get_status( $context = 'view' ) {
			$available_statuses = YITH_WCAF_Commissions::get_available_statuses();
			$current_status     = $this->get_prop( 'status', $context );

			// if status is unknown, default to new.
			if ( ! isset( $available_statuses[ $current_status ] ) ) {
				return $available_statuses['pending']['slug'];
			}

			return $available_statuses[ $current_status ]['slug'];
		}

		/**
		 * Returns all possible destination statuses for current commission
		 *
		 * @return array Array of status slugs.
		 */
		public function get_available_status_changes() {
			$available_changes = YITH_WCAF_Commissions::get_available_status_changes();
			$status            = $this->get_status();

			if ( ! isset( $available_changes[ $status ] ) ) {
				return array();
			}

			return $available_changes[ $status ];
		}

		/**
		 * Checks if current commission can move to a specified status
		 *
		 * @param string $destination_status Destination status slug.
		 * @return bool Whether commission can change status
		 */
		public function can_change_status( $destination_status ) {
			$available_statuses = wp_list_pluck( YITH_WCAF_Commissions::get_available_statuses(), 'slug' );

			if ( ! in_array( $destination_status, $available_statuses, true ) ) {
				return false;
			}

			return in_array( $destination_status, $this->get_available_status_changes(), true );
		}

		/**
		 * Checks whether current commission is credited to the affiliate
		 *
		 * @return bool
		 */
		public function is_assigned() {
			return $this->has_status( YITH_WCAF_Commissions::get_assigned_statuses() );
		}

		/**
		 * Checks whether current commission is yet to be credited to the affiliate
		 *
		 * @return bool
		 */
		public function is_unassigned() {
			return $this->has_status( YITH_WCAF_Commissions::get_unassigned_statuses() );
		}

		/**
		 * Checks whether current commission is dead (no further status change is allowed)
		 *
		 * @return bool
		 */
		public function is_dead() {
			return $this->has_status( YITH_WCAF_Commissions::get_dead_statuses() );
		}

		/**
		 * Checks whether current commission is paid (or in the process of being paid)
		 *
		 * @return bool
		 */
		public function is_paid() {
			return $this->has_status( YITH_WCAF_Commissions::get_payment_statuses() );
		}

		/**
		 * Checks whether current commission can be paid (considering its current status)
		 *
		 * @return bool
		 */
		public function can_be_paid() {
			return ! $this->is_paid() && ! $this->is_trashed() && $this->can_change_status( 'pending-payment' );
		}

		/**
		 * Checks whether current commission is trashed
		 *
		 * @return bool
		 */
		public function is_trashed() {
			return $this->has_status( 'trash' );
		}

		/**
		 * Return current status of the affiliate, as a localized string
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return string Affiliate shortened status.
		 */
		public function get_formatted_status( $context = 'view' ) {
			$available_statuses = YITH_WCAF_Commissions::get_available_statuses();
			$current_status     = $this->get_prop( 'status', $context );

			// if status is unknown, default to new.
			if ( ! isset( $available_statuses[ $current_status ] ) ) {
				return $available_statuses['pending']['name'];
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_commission_{$current_status}_status_label
			 *
			 * Filters the label for the commission status.
			 * <code>$current_status</code> will be replaced with the commission status.
			 *
			 * @param string $label The commission status label.
			 */
			return apply_filters( "yith_wcaf_commission_{$current_status}_status_label", $available_statuses[ $current_status ]['name'] );
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
		 * Return object representing date commission was last edited.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return WC_DateTime|string Last edit date.
		 */
		public function get_last_edit( $context = 'view' ) {
			$last_edit = $this->get_prop( 'last_edit', $context );

			if ( $last_edit && 'view' === $context ) {
				return $last_edit->date_i18n( 'Y-m-d H:i:s' );
			}

			return $last_edit;
		}

		/**
		 * Return object representing date commission was last edited.
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return WC_DateTime|string Last edit date.
		 */
		public function get_edited_time( $context = 'view' ) {
			$last_edit = $this->get_prop( 'last_edit', $context );

			if ( ! $last_edit ) {
				return false;
			}

			return $last_edit->getTimestamp();
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

				if ( ! empty( $available_status_changes ) && ! $this->has_status( 'trash' ) ) {
					foreach ( $available_status_changes as $status ) {
						if ( in_array( $status, YITH_WCAF_Commissions::get_dead_statuses(), true ) ) {
							continue;
						}

						// avoid direct ( pending-payment -> pending ) status change.
						if ( $this->has_status( 'pending-payment' ) && 'pending' === $status ) {
							continue;
						}

						// avoid "Trash" action button.
						if ( 'trash' === $status ) {
							continue;
						}

						$readable_status = YITH_WCAF_Commissions()->get_readable_status( $status );

						$this->admin_actions[ "switch_to_{$status}" ] = array(
							// translators: 1. Status name.
							'label' => sprintf( _x( 'Change status to %s', '[ADMIN] Single commission actions', 'yith-woocommerce-affiliates' ), strtolower( $readable_status ) ),
							'url'   => YITH_WCAF_Admin_Actions::get_action_url(
								'change_status',
								array(
									'commission_id' => $item_id,
									'status'        => $status,
								)
							),
							'class' => $status,
						);
					}
				}

				if ( $this->can_be_paid() && class_exists( 'YITH_WCAF_Gateways' ) ) {
					$available_gateways = YITH_WCAF_Gateways::get_available_gateways();

					$this->admin_actions['mark_as_paid'] = array(
						'label' => _x( 'Mark as paid', '[ADMIN] Single commission actions', 'yith-woocommerce-affiliates' ),
						'url'   => YITH_WCAF_Admin_Actions::get_action_url(
							'pay',
							array(
								'commission_id' => $item_id,
							)
						),
						'class' => 'completed',
					);

					if ( ! empty( $available_gateways ) ) {
						foreach ( $available_gateways as $gateway_id => $gateway ) {
							$this->admin_actions[ "pay_via_{$gateway_id}" ] = array(
								// translators: 1. Payment gateway label.
								'label' => sprintf( _x( 'Pay via %s', '[ADMIN] Single commission actions', 'yith-woocommerce-affiliates' ), $gateway->get_name() ),
								'url'   => YITH_WCAF_Admin_Actions::get_action_url(
									'pay',
									array(
										'commission_id' => $item_id,
										'gateway'       => $gateway_id,
									)
								),
								'class' => "pay pay-via-{$gateway_id}",
							);
						}
					}
				}
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_commission_admin_actions
			 *
			 * Filters the available actions for each commission in the commissions table.
			 *
			 * @param array                $actions    Actions.
			 * @param int                  $id         Commission id.
			 * @param YITH_WCAF_Commission $commission Commission object.
			 */
			return apply_filters( 'yith_wcaf_commission_admin_actions', parent::get_admin_actions(), $this->get_id(), $this );
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

			return YITH_WCAF_Admin()->get_tab_url( 'commissions', '', array( 'commission_id' => $this->get_id() ) );
		}

		/**
		 * Returns an array representation of this object
		 * It is a slightly extended form of $this->get_data()
		 *
		 * @return array Formatted array representing current commission.
		 */
		public function to_array() {
			$data      = $this->data;
			$affiliate = $this->get_affiliate();
			$user      = $affiliate ? $affiliate->get_user() : false;

			$return = array_merge(
				array(
					'ID' => $this->get_id(),
				),
				$data,
				array(
					'user_id'    => $user ? $user->ID : 0,
					'user_login' => $user ? $user->user_login : '',
					'user_email' => $user ? $user->user_email : '',
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_commission_to_array
			 *
			 * Filters data returned when converting a commission object to an array.
			 *
			 * @param array                $array      Commission in array format.
			 * @param int                  $id         Commission id.
			 * @param YITH_WCAF_Commission $commission Commission object.
			 */
			return apply_filters( 'yith_wcaf_commission_to_array', $return, $this->get_id(), $this );
		}

		/* === PAYMENTS === */

		/**
		 * Returns a list of commission's payment, eventually matching filtering criteria
		 *
		 * @param array $args Optional array of filtering criteria.
		 *
		 * @return YITH_WCAF_Payments_Collection|bool List of payments, if any; false on failure.
		 */
		public function get_payments( $args = array() ) {
			$payments = YITH_WCAF_Payment_Factory::get_payments(
				array_merge(
					array(
						'commissions' => $this->get_id(),
					),
					$args
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_commission_payments
			 *
			 * Filters payments found for current commission, for filters passed.
			 *
			 * @param YITH_WCAF_Payments_Collection $payments   Payments collection (may be empty).
			 * @param int                           $id         Commission id.
			 * @param YITH_WCAF_Commission          $commission Commission object.
			 * @param array                         $args       Array of filtering criteria used for the query.
			 */
			return apply_filters( 'yith_wcaf_commission_payments', $payments, $this->get_id(), $this, $args );
		}

		/**
		 * Returns commission's active payments, if any
		 *
		 * @return YITH_WCAF_Payments_Collection|bool List of payments, if any; false on failure.
		 */
		public function get_active_payments() {
			$payments = $this->get_payments(
				array(
					'status' => YITH_WCAF_Payments::get_active_statuses(),
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_commission_active_payments
			 *
			 * Filters active payments found for current commission.
			 *
			 * @param YITH_WCAF_Payments_Collection $payments   Payments collection (may be empty).
			 * @param int                           $id         Commission id.
			 * @param YITH_WCAF_Commission          $commission Commission object.
			 */
			return apply_filters( 'yith_wcaf_commission_active_payments', $payments, $this->get_id(), $this );
		}

		/**
		 * Returns a list of commission's inactive payments
		 *
		 * @return YITH_WCAF_Payments_Collection|bool List of payments, if any; false on failure.
		 */
		public function get_inactive_payments() {
			$payments = $this->get_payments(
				array(
					'status' => YITH_WCAF_Payments::get_inactive_statuses(),
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_commission_inactive_payments
			 *
			 * Filters inactive payments found for current commission.
			 *
			 * @param YITH_WCAF_Payments_Collection $payments   Payments collection (may be empty).
			 * @param int                           $id         Commission id.
			 * @param YITH_WCAF_Commission          $commission Commission object.
			 */
			return apply_filters( 'yith_wcaf_commission_inactive_payments', $payments, $this->get_id(), $this );
		}

		/* === SETTERS === */

		/**
		 * Set order id for the commission
		 *
		 * @param int $order_id Order id.
		 */
		public function set_order_id( $order_id ) {
			$order_id = (int) $order_id;

			$this->set_prop( 'order_id', $order_id );
		}

		/**
		 * Set line item id for the commission
		 *
		 * @param int $line_item_id Line item id.
		 */
		public function set_line_item_id( $line_item_id ) {
			$line_item_id = (int) $line_item_id;

			$this->set_prop( 'line_item_id', $line_item_id );
		}

		/**
		 * Set line total for current commissions
		 *
		 * @param float $line_total Line total used to calulate current commission.
		 */
		public function set_line_total( $line_total ) {
			$line_total = (float) $line_total;

			if ( $line_total < 0 ) {
				$line_total = 0;
			}

			$this->set_prop( 'line_total', $line_total );
		}

		/**
		 * Set product id for the commission
		 *
		 * @param int $product_id Product id.
		 */
		public function set_product_id( $product_id ) {
			$product_id = (int) $product_id;

			$this->set_prop( 'product_id', $product_id );
		}

		/**
		 * Set product name for the commission
		 *
		 * @param int $product_name Product id.
		 */
		public function set_product_name( $product_name ) {
			$this->set_prop( 'product_name', $product_name );
		}

		/**
		 * Set line item id for the commission
		 *
		 * @param int $order_item_id Line item id.
		 */
		public function set_order_item_id( $order_item_id ) {
			$this->set_line_item_id( $order_item_id );
		}

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
		 * Set rate for the commission
		 *
		 * @param float $rate Commission rate.
		 */
		public function set_rate( $rate ) {
			$rate = (float) $rate;

			/**
			 * APPLY_FILTERS: yith_wcaf_max_rate_value
			 *
			 * Filters the maximum rate value.
			 *
			 * @param int $max_rate_value Maximum rate value.
			 */
			if ( $rate < 0 || $rate > apply_filters( 'yith_wcaf_max_rate_value', 100 ) ) {
				return;
			}

			$this->set_prop( 'rate', $rate );
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
		 * Update amount of the commission, forcing save operation
		 *
		 * @param float  $difference Amount to add (or subtract, depending on the sign) to commission amount.
		 * @param string $note   Note to register with the commission.
		 */
		public function update_amount( $difference, $note = '' ) {
			$difference = (float) $difference;

			if ( $this->is_dead() ) {
				return;
			}

			$old_amount = $this->get_amount();

			$this->set_prop( 'amount', $old_amount + $difference );

			if ( ! empty( $note ) ) {
				$this->add_note( $note );
			}
		}

		/**
		 * Set refunds for the commission
		 *
		 * @param float $refunds Commission refunds.
		 */
		public function set_refunds( $refunds ) {
			$refunds = (float) $refunds;

			if ( $refunds < 0 ) {
				$refunds = 0;
			}

			$this->set_prop( 'refunds', $refunds );
		}

		/**
		 * Update refunds of the commission, forcing save operation
		 *
		 * @param float  $difference Amount to add (or subtract, depending on the sign) to commission refunds.
		 * @param string $note   Note to register with the commission.
		 */
		public function update_refunds( $difference, $note = '' ) {
			$difference = (float) $difference;

			if ( $this->is_dead() ) {
				return;
			}

			$old_amount = $this->get_refunds();

			$this->set_prop( 'refunds', $old_amount + $difference );

			if ( ! empty( $note ) ) {
				$this->add_note( $note );
			}
		}

		/**
		 * Set commission status
		 *
		 * @param string $status Status for the commission.
		 * @param string $note   Note to register with the commission.
		 * @param bool   $force  Whether to force status change, even if checks fail.
		 */
		public function set_status( $status, $note = '', $force = false ) {
			$available_statuses = YITH_WCAF_Commissions::get_available_statuses();
			$statuses           = wp_list_pluck( $available_statuses, 'slug' );

			if ( $this->object_read && ! $this->can_change_status( $status ) && ! $force ) {
				return;
			}

			$new_status = array_flip( $statuses )[ $status ];
			$old_status = $this->get_status();

			if ( false === $new_status ) {
				return;
			}

			if ( 'refunded' !== $old_status && 'refunded' === $new_status ) {
				$this->set_refunds( $this->get_amount() + $this->get_refunds() );
				$this->set_amount( 0 );
			} elseif ( 'refunded' === $old_status && 'refunded' !== $new_status ) {
				$commission_refunds = $this->get_refunds_from_partials();

				$this->set_amount( $this->get_refunds() + $commission_refunds );
				$this->set_refunds( -1 * $commission_refunds );
			}

			$this->set_prop( 'status', $status );

			if ( ! empty( $note ) ) {
				$this->add_note( $note );
			}
		}

		/**
		 * Trash commission
		 *
		 * @param string $note Note to register with the commission.
		 * @return bool Status of the operation
		 */
		public function trash( $note = '' ) {
			if ( $this->is_trashed() || ! $this->can_change_status( 'trash' ) ) {
				return false;
			}

			$this->set_status( 'trash', $note );

			return true;
		}

		/**
		 * Restore commission from trash
		 *
		 * @param string $note Note to register with the commission.
		 */
		public function restore( $note = '' ) {
			if ( ! $this->is_trashed() ) {
				return;
			}

			$order = $this->get_order();

			if ( ! $order ) {
				$new_status = 'pending';
			} else {
				$new_status = YITH_WCAF_Orders()->map_commission_status( $order->get_status() );
			}

			$this->set_status( $new_status, $note );
		}

		/**
		 * Set date commission was created
		 *
		 * @param int|string $created_at Date of creation (timestamp or date).
		 */
		public function set_created_at( $created_at ) {
			$this->set_date_prop( 'created_at', $created_at );
		}

		/**
		 * Set date commission was last edited
		 *
		 * @param int|string $last_edit Date of last edit (timestamp or date).
		 */
		public function set_last_edit( $last_edit ) {
			$this->set_date_prop( 'last_edit', $last_edit );
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

			// executes required adjustments to affiliate object after changes.
			if ( array_intersect( array_keys( $changes ), array( 'affiliate_id', 'amount', 'refunds', 'status' ) ) ) {
				$this->sync_affiliate( $old_data, $changes );
			}

			// execute status change actions.
			if ( isset( $changes['status'] ) ) {
				$commission_id = $this->get_id();
				$new_status    = $this->get_status();

				// retrieve old status slug.
				$available_statuses = YITH_WCAF_Commissions::get_available_statuses();

				$old_status = $old_data['status'];
				$old_status = isset( $available_statuses[ $old_status ] ) ? $available_statuses[ $old_status ]['slug'] : '';

				/**
				 * DO_ACTION: yith_wcaf_commission_status_$new_status
				 *
				 * Allows to trigger some action when the commission status changes into a new status.
				 * <code>$new_status</code> will be replaced with the new status for the commission.
				 *
				 * @param int $commission_id Commission id.
				 */
				do_action( "yith_wcaf_commission_status_{$new_status}", $commission_id );

				/**
				 * DO_ACTION: yith_wcaf_commission_status_$old_status_to_$new_status
				 *
				 * Allows to trigger some action when the commission status changes from the old status into the new status.
				 * <code>$old_status</code> will be replaced with the old commission status.
				 * <code>$new_status</code> will be replaced with the new commission status.
				 *
				 * @param int $commission_id Commission id.
				 */
				do_action( "yith_wcaf_commission_status_{$old_status}_to_{$new_status}", $commission_id );

				/**
				 * DO_ACTION: yith_wcaf_commission_status_changed
				 *
				 * Allows to trigger some action when the commission status has changed.
				 *
				 * @param int    $commission_id Commission id.
				 * @param string $new_status    New status.
				 * @param string $old_status    Old status.
				 */
				do_action( 'yith_wcaf_commission_status_changed', $commission_id, $new_status, $old_status );
			}

			return $new_id;
		}

		/**
		 * Delete an object, set the ID to 0, and return result.
		 *
		 * @param bool $force_delete Whether to delete commission even if it is dead already.
		 * @param bool $delete_rates Whether we should delete registered rates from item.
		 * @return bool result
		 */
		public function delete( $force_delete = false, $delete_rates = true ) {
			if ( ! $this->data_store || $this->is_dead() && ! $force_delete ) {
				return false;
			}

			$this->data_store->delete(
				$this,
				array(
					'force_delete' => $force_delete,
					'delete_rates' => $delete_rates,
				)
			);

			$this->set_id( 0 );
			$this->set_prop( 'affiliate_id', 0 ); // force affiliate id to 0.
			$this->sync_affiliate( $this->get_data(), $this->get_changes() );

			return true;
		}

		/* === EXTERNAL OBJECTS HANDLING === */

		/**
		 * Returns an array of partial refunds for the commission, indexed by refund id
		 *
		 * @return array Array of partial refund amounts, indexed by refund id.
		 */
		public function get_refund_partials() {
			$refunds = array();
			$order   = $this->get_order();

			if ( $order ) {
				$refunds_objects = $order->get_refunds();

				if ( $refunds_objects ) {
					foreach ( $refunds_objects as $refund ) {
						/**
						 * Each of refund objects.
						 *
						 * @var $refund WC_Order_Refund
						 */
						$refunded_commissions = $refund->get_meta( '_refunded_commissions' );

						if ( ! empty( $refunded_commissions ) && isset( $refunded_commissions[ $this->get_id() ] ) ) {
							$refunds[ $refund->get_id() ] = $refunded_commissions[ $this->get_id() ];
						}
					}
				}
			}

			return $refunds;
		}

		/**
		 * Returns total refund amount for the commission, as calculated from refund partials
		 *
		 * @return float Amount of commission refunds, as calculated from refund partials.
		 */
		public function get_refunds_from_partials() {
			return (float) array_sum( $this->get_refund_partials() );
		}

		/**
		 * Sync changes to affiliate object when saving data for the commission
		 *
		 * @param array $old_data Array of old commission data.
		 * @param array $new_data Array of new commission data.
		 */
		protected function sync_affiliate( $old_data, $new_data ) {
			// retrieve new and old affiliate (they might be the same).
			$new_affiliate = $this->get_affiliate( 'view', true );

			if ( isset( $new_data['affiliate_id'] ) && $new_data['affiliate_id'] !== $old_data['affiliate_id'] ) {
				$old_affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_id( $old_data['affiliate_id'] );
			} else {
				$old_affiliate = $new_affiliate;
			}

			// retrieve old commission status.
			$old_status = $old_data['status'];

			// register conditional tags  for old status.
			$was_assigned = in_array( $old_status, YITH_WCAF_Commissions::get_assigned_statuses(), true );
			$was_paid     = in_array( $old_status, YITH_WCAF_Commissions::get_payment_statuses(), true );

			// register conditional tags for new status.
			$is_assigned = $this->is_assigned();
			$is_paid     = $this->is_paid();

			// updated counters for the previous affiliate.
			if ( $was_assigned && $old_affiliate ) {
				$old_affiliate->update_earnings( -1 * $old_data['amount'] );
				$old_affiliate->update_refunds( -1 * $old_data['refunds'] );
			}

			if ( $was_paid && $old_affiliate ) {
				$old_affiliate->update_paid( -1 * $old_data['amount'] );
			}

			// updated counters for the current affiliate.
			if ( $is_assigned && $new_affiliate ) {
				$new_affiliate->update_earnings( $this->get_amount() );
				$new_affiliate->update_refunds( $this->get_refunds() );
			}

			if ( $is_paid && $new_affiliate ) {
				$new_affiliate->update_paid( $this->get_amount() );
			}

			// save affiliates.
			$new_affiliate && $new_affiliate->save();

			if ( $old_affiliate && $old_affiliate->get_id() !== $this->get_affiliate_id() ) {
				$old_affiliate->save();
			}
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
