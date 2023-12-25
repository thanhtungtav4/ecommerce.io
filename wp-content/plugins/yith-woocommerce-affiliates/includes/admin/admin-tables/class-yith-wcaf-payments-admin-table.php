<?php
/**
 * Payments Table class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Payments_Admin_Table' ) ) {
	/**
	 * WooCommerce Payments Table
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Payments_Admin_Table extends YITH_WCAF_Abstract_Admin_Table {
		/**
		 * Class constructor method
		 *
		 * @param array $args Arguments for the parent constructor.
		 * @since 1.0.0
		 */
		public function __construct( $args = array() ) {
			// set available filters.
			$this->filters = array(
				'status'       => array(
					'default' => 'all',
				),
				'from'         => array(
					'query_var' => '_from',
				),
				'to'           => array(
					'query_var' => '_to',
				),
				'affiliate_id' => array(
					'sanitize'  => 'intval',
					'query_var' => '_affiliate_id',
				),
				'commissions'  => array(
					'sanitize'  => 'intval',
					'query_var' => '_commission_id',
				),
				'orderby'      => array(
					'default' => 'created_at',
				),
				'order'        => array(
					'default' => 'DESC',
				),
			);

			// Set parent defaults.
			parent::__construct(
				array_merge(
					$args,
					array(
						'singular'      => 'payment',
						'plural'        => 'payments',
						'ajax'          => false,
						'empty_message' => _x( 'Sorry! There is no payment registered yet.', '[ADMIN] Affiliate empty table message', 'yith-woocommerce-affiliates' ),
					)
				)
			);
		}

		/* === COLUMNS METHODS === */

		/**
		 * Print a column with payment email
		 *
		 * @param YITH_WCAF_Payment $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_payment_method( $item ) {
			$payment_email = $item->get_email();
			$gateway       = $item->get_gateway();
			$affiliate     = $item->get_affiliate();

			if ( $gateway ) {
				$column = sprintf( '<b>%1$s</b><br/><small>%2$s</small>', $gateway->get_name(), nl2br( $item->get_formatted_gateway_details() ) );
			} elseif ( $payment_email ) {
				$column = sprintf( '<a href="mailto:%1$s">%1$s</a>', $payment_email );
			} elseif ( $affiliate && $affiliate->get_payment_email() ) {
				$column = sprintf( '<a href="mailto:%1$s">%1$s</a>', $affiliate->get_payment_email() );
			} else {
				$column = _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			}

			return $column;
		}

		/**
		 * Print a column with payment related commissions
		 *
		 * @param YITH_WCAF_Payment $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_commissions( $item ) {
			$column      = '';
			$commissions = $item->get_commissions();

			if ( ! $commissions ) {
				$column .= _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			} else {
				$items = array();

				foreach ( $commissions as $commission ) {
					$commission_id = $commission->get_id();

					$items[] = sprintf( '<a href="%s">%d</a>', YITH_WCAF_Admin()->get_tab_url( 'commissions', '', array( 'commission_id' => $commission_id ) ), $commission_id );
				}

				$column = implode( ' | ', $items );
			}

			return $column;
		}

		/**
		 * Print a column with payment creation date
		 *
		 * @param YITH_WCAF_Payment $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_created_at( $item ) {
			$column = '';

			$date_created = $item->get_created_at( 'edit' );

			if ( ! $date_created ) {
				return $column;
			}

			$column .= $date_created->date_i18n( wc_date_format() );

			return $column;
		}

		/**
		 * Returns columns available in table
		 *
		 * @return array Array of columns of the table
		 * @since 1.0.0
		 */
		public function get_columns() {
			$columns = array(
				'cb'             => '<input type="checkbox" />',
				'id'             => _x( 'ID', '[ADMIN] Payments table heading', 'yith-woocommerce-affiliates' ),
				'affiliate'      => _x( 'Affiliate', '[ADMIN] Payments table heading', 'yith-woocommerce-affiliates' ),
				'payment_method' => _x( 'Payment method', '[ADMIN] Payments table heading', 'yith-woocommerce-affiliates' ),
				'amount'         => _x( 'Amount', '[ADMIN] Payments table heading', 'yith-woocommerce-affiliates' ),
				'created_at'     => _x( 'Created on', '[ADMIN] Payments table heading', 'yith-woocommerce-affiliates' ),
				'status'         => _x( 'Status', '[ADMIN] Payments table heading', 'yith-woocommerce-affiliates' ),
				'actions'        => _x( 'Actions', '[ADMIN] Payments table heading', 'yith-woocommerce-affiliates' ),
			);

			return $columns;
		}

		/**
		 * Returns column to be sortable in table
		 *
		 * @return array Array of sortable columns
		 * @since 1.0.0
		 */
		public function get_sortable_columns() {
			$sortable_columns = array(
				'status'       => array( 'status', false ),
				'id'           => array( 'ID', false ),
				'affiliate'    => array( 'user_login', false ),
				'amount'       => array( 'amount', false ),
				'created_at'   => array( 'created_at', true ),
				'completed_at' => array( 'completed_at', true ),
			);

			return $sortable_columns;
		}

		/**
		 * Returns an array of per view items count
		 *
		 * @param array $query_args Query arguments.
		 * @return array
		 */
		public function get_per_view_count( $query_args ) {
			return YITH_WCAF_Payments()->per_status_count( false, $query_args );
		}

		/**
		 * Returns an array of per available views for current table
		 *
		 * @return array
		 */
		public function get_available_views() {
			return array_merge(
				parent::get_available_views(),
				wp_list_pluck( YITH_WCAF_Payments::get_available_statuses(), 'slug' )
			);
		}

		/**
		 * Returns labels to be used for a specific view
		 *
		 * @param string $view  View slug.
		 * @param int    $count Count of items in the view (to choose between singular/plural).
		 *
		 * @return string
		 */
		public function get_view_label( $view, $count = 0 ) {
			if ( 'all' === $view ) {
				$label = _x( 'All', '[ADMIN] Payments view', 'yith-woocommerce-affiliates' );
			} else {
				$label = YITH_WCAF_Payments::get_readable_status( $view, $count );
			}

			return parent::get_view_label( $label, $count );
		}

		/**
		 * Return list of available bulk actions
		 *
		 * @return array Available bulk action
		 * @since 1.0.0
		 */
		public function get_bulk_actions() {
			$actions = array(
				'switch_to_completed' => _x( 'Change status to completed', '[ADMIN] Payments bulk actions', 'yith-woocommerce-affiliates' ),
				'switch_to_on-hold'   => _x( 'Change status to on hold', '[ADMIN] Payments bulk actions', 'yith-woocommerce-affiliates' ),
				'switch_to_cancelled' => _x( 'Change status to canceled', '[ADMIN] Payments bulk actions', 'yith-woocommerce-affiliates' ),
				'delete'              => _x( 'Delete', '[ADMIN] Payments bulk actions', 'yith-woocommerce-affiliates' ),
			);

			$gateways = YITH_WCAF_Gateways::get_available_gateways();

			if ( ! empty( $gateways ) ) {
				foreach ( $gateways as $id => $gateway ) {
					// avoid to list here gateways that do not support masspay.
					if ( ! $gateway->supports_masspay() ) {
						continue;
					}

					// translators: 1. Payment gateway label.
					$actions[ 'pay_via_' . $id ] = sprintf( _x( 'Pay via %s', '[ADMIN] Payments bulk actions', 'yith-woocommerce-affiliates' ), $gateway->get_name() );
				}
			}

			return $actions;
		}

		/**
		 * Print filters for current table
		 *
		 * @param string $which Top / Bottom.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function extra_tablenav( $which ) {
			if ( 'top' !== $which ) {
				return;
			}

			$this->print_hidden_fields();
			$this->print_affiliate_filter();
			$this->print_datepicker( '_from' );
			$this->print_datepicker( '_to' );
			$this->print_filter_button();
			$this->print_reset_button();
		}

		/**
		 * Prepare items for table
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function prepare_items() {
			$query_args = $this->get_query_args();

			// sets pagination arguments.
			$per_page     = $this->get_items_per_page( 'edit_payments_per_page' );
			$current_page = $this->get_pagenum();
			$payments     = YITH_WCAF_Payments()->get_payments(
				array_merge(
					array(
						'limit'  => $per_page,
						'offset' => ( ( $current_page - 1 ) * $per_page ),
					),
					$query_args
				)
			);

			// sets columns headers.
			$columns               = $this->get_columns();
			$hidden                = $this->get_hidden_columns();
			$sortable              = $this->get_sortable_columns();
			$this->_column_headers = array( $columns, $hidden, $sortable );

			// retrieve data for table.
			$this->items = $payments;

			// sets pagination args.
			$this->set_pagination_args(
				array(
					'total_items' => $payments->get_total_items(),
					'per_page'    => $per_page,
					'total_pages' => $payments->get_total_pages(),
				)
			);
		}
	}
}
