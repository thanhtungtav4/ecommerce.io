<?php
/**
 * Orders Handler class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Orders' ) ) {
	/**
	 * Orders handler
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Orders {

		use YITH_WCAF_Trait_Singleton;

		/**
		 * Commission/Order status map
		 * Contains a record for every commission status, and maps statuses that related order must assume for the commission
		 * to be automatically moved to that status.
		 *
		 * @var mixed
		 * @since 1.0.0
		 */
		protected static $commission_order_status_map = array(
			'pending'         => array( 'completed', 'processing' ),
			'pending-payment' => array(),
			'paid'            => array(),
			'not-confirmed'   => array( 'pending', 'on-hold' ),
			'cancelled'       => array( 'cancelled', 'failed' ),
			'refunded'        => array( 'refunded' ),
		);

		/**
		 * Whether to exclude tax from commission calculation
		 *
		 * @var bool
		 * @since 1.0.0
		 */
		protected $exclude_tax;

		/**
		 * Whether to exclude discount from commission calculation
		 *
		 * @var bool
		 * @since 1.0.0
		 */
		protected $exclude_discounts;

		/**
		 * Constructor method
		 */
		public function __construct() {
			// retrieve options for internal usage.
			$this->retrieve_options();

			// handle order status change.
			add_action( 'woocommerce_order_status_changed', array( $this, 'status_changed' ), 10, 3 );

			// handle order trashing.
			add_action( 'trashed_post', array( $this, 'trashed' ) );
			add_action( 'untrashed_post', array( $this, 'restored' ) );

			// handle refunds.
			add_action( 'woocommerce_refund_created', array( $this, 'refund_created' ) );
			add_action( 'deleted_post_meta', array( $this, 'refund_deleted' ), 10, 4 );
		}

		/* === STATUS MAP === */

		/**
		 * Return commission default status for a given order status
		 *
		 * @param string $order_status Order status.
		 *
		 * @return string Commission status
		 * @since 1.0.0
		 */
		public function map_commission_status( $order_status ) {
			foreach ( self::$commission_order_status_map as $commission_status => $mapped_order_statuses ) {
				if ( ! in_array( $order_status, $mapped_order_statuses, true ) ) {
					continue;
				}

				/**
				 * APPLY_FILTERS: yith_wcaf_map_commission_status
				 *
				 * Filters the commission status.
				 *
				 * @param string $commission_status Commission status.
				 * @param string $order_status      Order status.
				 */
				return apply_filters( 'yith_wcaf_map_commission_status', $commission_status, $order_status );
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_default_commission_status
			 *
			 * Filters the default commission status.
			 *
			 * @param string $default_status Default commission status.
			 * @param string $order_status   Order status.
			 */
			return apply_filters( 'yith_wcaf_default_commission_status', 'pending', $order_status );
		}

		/* === ORDER COMMISSION HANDLING === */

		/**
		 * Create orders commissions, on process checkout action, and when an order is restored from trash
		 *
		 * @param int    $order_id     Order id.
		 * @param string $token        Referral token.
		 * @param string $token_origin Referral token origin.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function create_commissions( $order_id, $token, $token_origin = 'undefined' ) {
			$order     = wc_get_order( $order_id );
			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_token( $token );

			// if no order or user, return.
			/**
			 * APPLY_FILTERS: yith_wcaf_create_order_commissions
			 *
			 * Filters whether to create the order commissions.
			 *
			 * @param bool   $create_commissions Whether to create commissions or not.
			 * @param int    $order_id           Order id.
			 * @param string $token              Referral token.
			 * @param string $token_origin       Referral token origin.
			 */
			if ( ! $order || ! $affiliate || ! $affiliate->is_valid() || ! apply_filters( 'yith_wcaf_create_order_commissions', true, $order_id, $token, $token_origin ) ) {
				return;
			}

			// map commission status on order status.
			$commission_status = $this->map_commission_status( $order->get_status() );

			// saves current token into order metadata.
			$order->update_meta_data( '_yith_wcaf_referral', $token );

			// process commission, add order item meta, register order as processed.
			$items = $order->get_items();

			if ( ! empty( $items ) ) {
				foreach ( $items as $item_id => $item ) {
					/**
					 * Each of order's line items
					 *
					 * @var $item WC_Order_Item_Product
					 */
					$product_id   = $item->get_product_id();
					$variation_id = $item->get_variation_id();

					// retrieves current product id.
					$product_id = $variation_id ? $variation_id : $product_id;

					// checks if product is should be processed.
					if ( ! $this->should_create_product_commission( $product_id, $order_id, $token, $token_origin ) ) {
						continue;
					}

					// retrieves rate to use for commissions.
					$rate = (float) $item->get_meta( '_yith_wcaf_commission_rate' );

					if ( ! $rate ) {
						$rate = YITH_WCAF_Rate_Handler::get_rate( $affiliate, $product_id, $order_id );
					}

					$commission_amount = $this->calculate_line_item_commission( $order, $item_id, $item, $rate );

					/**
					 * APPLY_FILTERS: yith_wcaf_create_order_commission_skip_zero_commissions
					 *
					 * Allow to skip creation of commissions with amount 0.
					 *
					 * @param bool $skip_zero_commissions Whether to skip 0 commissions or not (default: true).
					 */
					if ( $commission_amount < 0.01 && apply_filters( 'yith_wcaf_create_order_commission_skip_zero_commissions', true ) ) {
						continue;
					}

					$commission      = null;
					$commission_args = array(
						'order_id'     => $order_id,
						'affiliate_id' => $affiliate->get_id(),
						'line_item_id' => $item_id,
						'line_total'   => $this->get_line_item_total( $order, $item, $rate ),
						'product_id'   => $product_id,
						'product_name' => wp_strip_all_tags( $item->get_product()->get_formatted_name() ),
						'rate'         => $rate,
						'amount'       => $commission_amount,
						'status'       => $commission_status,
						/**
						 * APPLY_FILTERS: yith_wcaf_create_order_commission_use_current_date
						 *
						 * Filters whether to use the current date for the commission when it is created.
						 *
						 * @param bool $use_current_date Whether to use the current date for the commission, use the order created date when false.
						 */
						'created_at'   => apply_filters( 'yith_wcaf_create_order_commission_use_current_date', true ) ? current_time( 'mysql' ) : $order->get_date_created()->format( 'Y-m-d H:i:S' ),
					);

					/**
					 * APPLY_FILTERS: yith_wcaf_create_item_commission
					 *
					 * Filters whether to create the commissions for the order item.
					 *
					 * @param bool                  $create_commission Whether to create commission for the order item or not.
					 * @param WC_Order_Item_Product $item              Order item object.
					 * @param int                   $item_id           Order item id.
					 * @param int                   $product_id        Product id.
					 * @param array                 $commission_args   Array of arguments for the commission generation.
					 */
					if ( ! apply_filters( 'yith_wcaf_create_item_commission', true, $item, $item_id, $product_id, $commission_args ) ) {
						continue;
					}

					// checks whether a commission already exists for current item.
					$old_id = (int) $item->get_meta( '_yith_wcaf_commission_id' );

					if ( $old_id ) {
						$commission = YITH_WCAF_Commission_Factory::get_commission( $old_id );
					}

					// if no previous commission is found, generate a new one.
					if ( ! $commission ) {
						$commission = new YITH_WCAF_Commission();
					}

					// create or update commission with new props.
					$commission->set_props( $commission_args );
					$commission->save();
				}
			}

			$order->save();
		}

		/**
		 * Regenerate order commissions, deleting old ones, and creating new ones
		 *
		 * @param int    $order_id Order id.
		 * @param string $token    Affiliate token; when omitted, system will use the one stored in order meta.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function regenerate_commissions( $order_id, $token = false ) {
			$order = wc_get_order( $order_id );

			if ( ! $order ) {
				return;
			}

			$token = $token ? $token : $order->get_meta( '_yith_wcaf_referral' );

			if ( ! $token ) {
				return;
			}

			// retrieve old commissions, to check if we'll need to delete something.
			$commissions = YITH_WCAF_Commission_Factory::get_commissions(
				array(
					'order_id' => $order_id,
				)
			);

			// flag that tells whether we can proceed with creation of new commissions.
			$proceed = true;

			// delete previous commissions (if one commission is paid or pending-payment, process is aborted).
			if ( ! $commissions->is_empty() ) {
				$proceed = $this->delete_commissions( $order_id, false, true );
			}

			// re-create commissions.
			if ( $proceed ) {
				$this->create_commissions( $order_id, $token );
			}
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
		public function delete_commissions( $order_id, $force = false, $delete_rates = false ) {
			$order = wc_get_order( $order_id );

			if ( ! $order ) {
				return false;
			}

			$order_commissions = YITH_WCAF_Commission_Factory::get_commissions(
				array(
					'order_id' => $order_id,
				)
			);

			if ( ! empty( $order_commissions ) ) {
				foreach ( $order_commissions as $commission ) {
					if ( $commission->is_dead() && ! $force ) {
						return false;
					}
				}

				foreach ( $order_commissions as $commission ) {
					$this->delete_commission( $commission->get_id(), $force, $delete_rates );
				}
			}

			return true;
		}

		/**
		 * Delete a single order commissions, removing in the same time data stored within order item meta
		 *
		 * @param int  $commission_id Commission id.
		 * @param bool $force         Force deletion, even if status is a dead_status.
		 * @param bool $delete_rate   Delete rate stored within order items, to get fresh values when adding new affiliate.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function delete_commission( $commission_id, $force = false, $delete_rate = false ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

			if ( ! $commission ) {
				return;
			}

			$commission->delete( $force, $delete_rate );
		}

		/**
		 * Retrieves amount used for commission calculation for a given order and item
		 *
		 * @param WC_Order              $order     Order object.
		 * @param WC_Order_Item_Product $line_item Order item object.
		 * @param float                 $rate      Commission rate.
		 */
		public function get_line_item_total( $order, $line_item, $rate = false ) {
			// choose method to retrieve item total.
			$get_item_amount = $this->exclude_discounts ? 'get_line_total' : 'get_line_subtotal';
			$item_amount     = (float) $order->$get_item_amount( $line_item, ! $this->exclude_tax, false );

			/**
			 * APPLY_FILTERS: yith_wcaf_line_item_commission_total
			 *
			 * Filters the item amount used to calculate the commission.
			 *
			 * @param float                 $item_amount   Item amount to calculate commission.
			 * @param WC_Order              $order         Order object.
			 * @param int                   $order_item_id Order item id.
			 * @param WC_Order_Item_Product $line_item     Order item object.
			 * @param float                 $rate          Commission rate.
			 */
			return apply_filters( 'yith_wcaf_line_item_commission_total', abs( $item_amount ), $order, $line_item->get_id(), $line_item, $rate );
		}

		/**
		 * Calculate single line item commission, for a given order, item and rate
		 *
		 * @param WC_Order              $order        Order object.
		 * @param int                   $line_item_id Order item id.
		 * @param WC_Order_Item_Product $line_item    Order item object.
		 * @param float                 $rate         Commission rate.
		 *
		 * @return float Commission amount
		 * @since 1.0.0
		 */
		protected function calculate_line_item_commission( $order, $line_item_id, $line_item, $rate ) {
			// if rate is false, stop here.
			if ( ! $rate ) {
				return 0;
			}

			$line_total = $this->get_line_item_total( $order, $line_item, $rate );

			// if total is 0 after discounts then go no further.
			if ( ! $line_total ) {
				return 0;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_use_percentage_rates
			 *
			 * Filters whether to use percentage rates in the commissions system.
			 *
			 * @param bool $use_percentage_rates Whether to use percentage rates for the commissions, fixed amounts when false.
			 */
			$use_percentage_rates = apply_filters( 'yith_wcaf_use_percentage_rates', true, $order, $line_item_id, $line_item );

			// get total amount for commission.
			if ( $use_percentage_rates ) {
				$amount = $line_total * $rate / 100;
			} else {
				$amount = $rate;
			}

			// if commission amount is 0 then go no further.
			if ( ! $amount ) {
				return 0;
			}

			// if commission result greater than line item total, return line item total.
			/**
			 * APPLY_FILTERS: yith_wcaf_line_total_check_amount_total
			 *
			 * Filters whether to check if the commission amount is greater than the line item total.
			 *
			 * @param bool $check_total_amount Whether to check if the commission amount is greater than the line item total or not.
			 */
			if ( $amount >= $line_total && apply_filters( 'yith_wcaf_line_total_check_amount_total', true ) ) {
				return $line_total;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_line_item_commission
			 *
			 * Filters the generated commission amount.
			 *
			 * @param float                  $amount               Commission amount.
			 * @param WC_Order               $order                Order object.
			 * @param int                    $line_item_id         Order item id.
			 * @param WC_Order_Item_Product  $line_item            Order item object.
			 * @param float                  $rate                 Commission rate.
			 * @param bool                   $use_percentage_rates Whether to use percentage rate to calculate commissions.
			 */
			return apply_filters( 'yith_wcaf_line_item_commission', $amount, $order, $line_item_id, $line_item, $rate, $use_percentage_rates );
		}

		/**
		 * Checks whether commission can be created for a specific product
		 *
		 * @param int    $product_id   Product id.
		 * @param int    $order_id     Order id.
		 * @param string $token        Affiliate token.
		 * @param string $token_origin Token origin.
		 *
		 * @return bool Whether to create commission or not.
		 */
		protected function should_create_product_commission( $product_id, $order_id = false, $token = false, $token_origin = false ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_create_product_commission
			 *
			 * Filters whether create commissions for specific products.
			 *
			 * @param bool   $create_product_commission Whether to create commissions for products or not.
			 * @param int    $product_id                Product id.
			 * @param int    $order_id                  Order id.
			 * @param string $token                     Referral token.
			 * @param string $token_origin              Referral token origin.
			 */
			return apply_filters( 'yith_wcaf_create_product_commission', true, $product_id, $order_id, $token, $token_origin );
		}

		/* === STATUS CHANGE HANDLING === */

		/**
		 * Changes status of commissions related to an order, after of a status change for the order
		 *
		 * @param int    $order_id   Order id.
		 * @param string $old_status Old order status.
		 * @param string $new_status New order status.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function status_changed( $order_id, $old_status, $new_status ) {
			$order = wc_get_order( $order_id );

			if ( ! $order ) {
				return;
			}

			if ( $order->has_status( 'trash' ) ) {
				return;
			}

			// click handling.
			YITH_WCAF_Clicks()->maybe_register_conversion( $order_id );

			$items = $order->get_items();

			if ( empty( $items ) ) {
				return;
			}

			$commission_status = $this->map_commission_status( $new_status );
			$commissions       = YITH_WCAF_Commission_Factory::get_commissions(
				array(
					'order_id' => $order_id,
				)
			);

			if ( $commissions->is_empty() ) {
				return;
			}

			foreach ( $commissions as $commission ) {
				// if we're paying commission, please skip any user total change.
				if ( $commission->is_dead() ) {
					continue;
				}

				$commission->set_status( $commission_status );
				$commission->save();
			}

			$action = in_array( $commission_status, YITH_WCAF_Commissions::get_assigned_statuses(), true ) ? 'confirmed' : 'unconfirmed';

			/**
			 * DO_ACTION: yith_wcaf_order_$action_commissions
			 *
			 * Allows to trigger some action when changing the commission status.
			 * <code>$action</code> will be replaced with the action to apply depending on the commission status.
			 *
			 * @param WC_Order $order       Order object.
			 * @param array    $commissions Commissions.
			 */
			do_action( "yith_wcaf_order_{$action}_commissions", $order, $commissions );
		}

		/**
		 * Handle order trashing action
		 *
		 * @param int $post_id Post id.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function trashed( $post_id ) {
			$order = wc_get_order( $post_id );

			if ( ! $order ) {
				return;
			}

			$this->delete_commissions( $post_id, true );
		}

		/**
		 * Handle order restoring action
		 *
		 * @param int $post_id Post id.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function restored( $post_id ) {
			$order = wc_get_order( $post_id );

			if ( ! $order ) {
				return;
			}

			$token = $order->get_meta( '_yith_wcaf_referral' );

			if ( ! $token ) {
				return;
			}

			$this->create_commissions( $post_id, $token );
		}

		/* === REFUND HANDLING === */

		/**
		 * Handle order refund creation
		 *
		 * @param int $refund_id Refund id.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function refund_created( $refund_id ) {
			$refund = wc_get_order( $refund_id );

			if ( ! $refund ) {
				return;
			}

			$order = wc_get_order( $refund->get_parent_id() );

			if ( ! $order ) {
				return;
			}

			if ( $order->has_status( 'refunded' ) ) {
				return;
			}

			$refund_partials = array();

			foreach ( $refund->get_items() as $item_id => $item ) {
				// retrieve amount refunded.
				$refunded_item = $item->get_meta( '_refunded_item_id' );

				// retrieve commission id for current item.
				try {
					$commission_id = wc_get_order_item_meta( $refunded_item, '_yith_wcaf_commission_id' );
				} catch ( Exception $e ) {
					continue;
				}

				// if no commission id is found, continue.
				if ( ! $commission_id ) {
					continue;
				}

				// retrieve commission object for found commission id.
				$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

				// if no commission is found, continue.
				if ( ! $commission ) {
					continue;
				}

				// calculate amount of the item's refund that affects current commission.
				$refunded_amount = $this->calculate_line_item_commission( $refund, $item_id, $item, $commission->get_rate() );

				// translators: 1. Refunded amount. 2. Refund id.
				$message = sprintf( __( 'Refunded %1$s due to refund #%2$s creation', 'yith-woocommerce-affiliates' ), wc_price( $refunded_amount ), $refund_id );

				// decrease commission amount and increase total refunds.
				$commission->update_amount( -1 * $refunded_amount, $message );
				$commission->update_refunds( $refunded_amount );
				$commission->save();

				// save amount refunded.
				$refund_partials[ $commission->get_id() ] = -1 * $refunded_amount;
			}

			// save list of refunded commissions for this refund.
			$refund->update_meta_data( '_refunded_commissions', $refund_partials );
			$refund->save();
		}

		/**
		 * Handle order refund deletion
		 *
		 * @param mixed  $meta_ids   Order meta ids (meta containing refunded commission id stored within the order).
		 * @param int    $object_id  Order id.
		 * @param string $meta_key   Meta key (_refunded_commission).
		 * @param mixed  $meta_value Meta value (commission refunded).
		 */
		public function refund_deleted( $meta_ids, $object_id, $meta_key, $meta_value ) {
			if ( '_refunded_commissions' !== $meta_key ) {
				return;
			}

			$refund = wc_get_order( $object_id );

			if ( ! $refund ) {
				return;
			}

			$order = wc_get_order( $refund->get_parent_id() );

			if ( ! $order || $order->has_status( 'refunded' ) ) {
				return;
			}

			if ( ! empty( $meta_value ) ) {
				foreach ( $meta_value as $commission_id => $refund ) {
					$commission = YITH_WCAF_Commission_Factory::get_commission( $commission_id );

					if ( ! $commission ) {
						continue;
					}

					// translators: 1. Restored amount. 2. Refund id.
					$message = sprintf( __( 'Restored %1$s due to refund #%2$s deletion', 'yith-woocommerce-affiliates' ), wc_price( abs( $refund ) ), $object_id );

					$commission->update_amount( -1 * (float) $refund, $message );
					$commission->update_refunds( (float) $refund );
					$commission->save();
				}
			}
		}

		/* === UTILITIES === */

		/**
		 * Returns value for exclude tax option
		 *
		 * @return bool
		 */
		public function exclude_tax() {
			/**
			 * APPLY_FILTERS: yith_wcaf_orders_exclude_tax
			 *
			 * Filters whether the commissions will be calculated excluding taxes.
			 *
			 * @param bool $exclude_tax Whether to exclude tax or not.
			 */
			return apply_filters( 'yith_wcaf_orders_exclude_tax', $this->exclude_tax );
		}

		/**
		 * Returns value for exclude tax option
		 *
		 * @return bool
		 */
		public function exclude_discounts() {
			/**
			 * APPLY_FILTERS: yith_wcaf_orders_exclude_discounts
			 *
			 * Filters whether the commissions will be calculated excluding order discounts.
			 *
			 * @param bool $exclude_discounts Whether to exclude discount or not.
			 */
			return apply_filters( 'yith_wcaf_orders_exclude_discounts', $this->exclude_discounts );
		}

		/**
		 * Retrieve options needed to generate commissions
		 *
		 * @return void
		 */
		protected function retrieve_options() {
			$this->exclude_tax       = yith_plugin_fw_is_true( get_option( 'yith_wcaf_commission_exclude_tax', 'yes' ) );
			$this->exclude_discounts = yith_plugin_fw_is_true( get_option( 'yith_wcaf_commission_exclude_discount', 'yes' ) );
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Orders class
 *
 * @return \YITH_WCAF_Orders
 * @since 1.0.0
 */
function YITH_WCAF_Orders() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Orders::get_instance();
}
