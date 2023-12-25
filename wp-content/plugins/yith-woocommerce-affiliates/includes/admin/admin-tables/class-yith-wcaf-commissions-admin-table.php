<?php
/**
 * Commissions Table class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Commissions_Admin_Table' ) ) {
	/**
	 * WooCommerce Commissions Table
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Commissions_Admin_Table extends YITH_WCAF_Abstract_Admin_Table {

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
				'order_id'     => array(
					'sanitize'  => 'intval',
					'query_var' => '_order_id',
				),
				'product_id'   => array(
					'sanitize'  => 'intval',
					'query_var' => '_product_id',
				),
				'orderby'      => array(
					'default' => 'created_at',
				),
				'order'        => array(
					'default' => 'DESC',
				),
			);

			parent::__construct(
				array_merge(
					$args,
					array(
						'singular'      => 'commission',
						'plural'        => 'commissions',
						'ajax'          => false,
						'empty_message' => _x( 'Sorry! There is no commission registered yet.', '[ADMIN] Affiliate empty table message', 'yith-woocommerce-affiliates' ),
					)
				)
			);
		}

		/* === COLUMNS METHODS === */

		/**
		 * Print column with commission product details
		 *
		 * @param YITH_WCAF_Commission $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_product( $item ) {
			$product = $item->get_product();

			if ( ! $product ) {
				return $item->get_product_name();
			}

			$column = sprintf( '%s<div class="product-details">%s</div>', $product->get_image( array( 50, 50 ) ), $product->get_title() );

			return $column;
		}

		/**
		 * Print column with commission category details
		 *
		 * @param YITH_WCAF_Commission $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_category( $item ) {
			$product_id = $item->get_product_id();
			$categories = wp_get_post_terms( $product_id, 'product_cat' );

			if ( empty( $categories ) ) {
				$column = _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			} else {
				$column_items = array();

				foreach ( $categories as $category ) {
					$column_items[] = $category->name;
				}

				$column = implode( ' | ', $column_items );
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_category_column
			 *
			 * Filters the output of the category column in the Commissions table.
			 *
			 * @param string $column     Column output.
			 * @param int    $product_id Product id.
			 * @param string $items      Items to display in the table.
			 */
			return apply_filters( 'yith_wcaf_category_column', $column, $product_id, 'commissions' );
		}

		/**
		 * Print column with commission rate
		 *
		 * @param YITH_WCAF_Commission $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_rate( $item ) {
			return $item->get_formatted_rate();
		}

		/**
		 * Print column with commission date
		 *
		 * @param YITH_WCAF_Commission $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_date( $item ) {
			return $item->get_created_at( 'edit' )->date_i18n( wc_date_format() );
		}

		/**
		 * Print column with line item total
		 *
		 * @param YITH_WCAF_Commission $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_line_item_total( $item ) {
			return $item->get_formatted_line_total();
		}

		/**
		 * Print column with commission active payemtns (should be one single element)
		 *
		 * @param YITH_WCAF_Commission $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_payments( $item ) {
			$column          = '';
			$active_payments = $item->get_active_payments();

			if ( empty( $active_payments ) ) {
				$column .= _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			} else {
				$items = array();

				foreach ( $active_payments as $active_payment ) {
					$items[] = sprintf( '#%d', $active_payment->get_id() );
				}

				$column = implode( ' | ', $items );
			}

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
				'cb'              => '<input type="checkbox" />',
				'id'              => _x( 'ID', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'date'            => _x( 'Date', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'affiliate'       => _x( 'Affiliate', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'order'           => _x( 'Order', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'product'         => _x( 'Product', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'line_item_total' => _x( 'Total', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'rate'            => _x( 'Rate', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'amount'          => _x( 'Commission', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'category'        => _x( 'Category', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'payments'        => _x( 'Payment', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'status'          => _x( 'Status', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
				'actions'         => _x( 'Actions', '[ADMIN] Commissions table heading', 'yith-woocommerce-affiliates' ),
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
				'id'        => array( 'ID', false ),
				'status'    => array( 'status', false ),
				'order'     => array( 'order_id', false ),
				'affiliate' => array( 'user_login', false ),
				'product'   => array( 'product_name', false ),
				'rate'      => array( 'rate', false ),
				'amount'    => array( 'amount', false ),
				'date'      => array( 'created_at', true ),
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
			return YITH_WCAF_Commissions()->per_status_count( false, $query_args );
		}

		/**
		 * Returns an array of per available views for current table
		 *
		 * @return array
		 */
		public function get_available_views() {
			return array_merge(
				parent::get_available_views(),
				wp_list_pluck( YITH_WCAF_Commissions::get_available_statuses(), 'slug' )
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
				$label = _x( 'All', '[ADMIN] Commissions view', 'yith-woocommerce-affiliates' );
			} else {
				$label = YITH_WCAF_Commissions::get_readable_status( $view, $count );
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
				'switch_to_pending'       => _x( 'Change status to pending', '[ADMIN] Commissions bulk actions', 'yith-woocommerce-affiliates' ),
				'switch_to_not-confirmed' => _x( 'Change status to not confirmed', '[ADMIN] Commissions bulk actions', 'yith-woocommerce-affiliates' ),
				'switch_to_cancelled'     => _x( 'Change status to canceled', '[ADMIN] Commissions bulk actions', 'yith-woocommerce-affiliates' ),
				'switch_to_refunded'      => _x( 'Change status to refunded', '[ADMIN] Commissions bulk actions', 'yith-woocommerce-affiliates' ),
				'pay'                     => _x( 'Create a payment manually', '[ADMIN] Commissions bulk actions', 'yith-woocommerce-affiliates' ),
			);

			if ( 'trash' === $this->get_query_var( 'status' ) ) {
				// add restore/delete permanently options when we're in trash view.
				$actions = yith_wcaf_append_items(
					$actions,
					'',
					array(
						'restore' => _x( 'Restore', '[ADMIN] Commissions bulk actions', 'yith-woocommerce-affiliates' ),
						'delete'  => _x( 'Delete permanently', '[ADMIN] Commissions bulk actions', 'yith-woocommerce-affiliates' ),
					),
					'before'
				);

				// remove any payment option when commission is in trash.
				unset( $actions['pay'] );
			} else {
				// add automatic bulk payments.
				$available_gateways = YITH_WCAF_Gateways::get_available_gateways();
				if ( ! empty( $available_gateways ) ) {
					foreach ( $available_gateways as $gateway_id => $gateway ) {
						// translators: 1. Payment gateway label.
						$actions[ "pay_via_{$gateway_id}" ] = sprintf( _x( 'Pay via %s', '[ADMIN] Commissions bulk actions', 'yith-woocommerce-affiliates' ), $gateway->get_name() );
					}
				}

				// add move to trash action when we're outside of trash view.
				$actions['move_to_trash'] = _x( 'Move to trash', '[ADMIN] Commissions bulk actions', 'yith-woocommerce-affiliates' );
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
			$this->print_product_filter();
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
			$per_page     = $this->get_items_per_page( 'edit_commissions_per_page' );
			$current_page = $this->get_pagenum();

			/**
			 * APPlY_FILTERS: yith_wcaf_prepare_items_commissions
			 *
			 * Filters the array with the arguments to get the commissions.
			 *
			 * @param array $args Array of arguments.
			 */
			$commissions = YITH_WCAF_Commissions()->get_commissions(
				array_merge(
					apply_filters(
						'yith_wcaf_prepare_items_commissions',
						array(
							'limit'  => $per_page,
							'offset' => ( ( $current_page - 1 ) * $per_page ),
						)
					),
					$query_args
				)
			);

			// sets columns headers.
			$columns  = $this->get_columns();
			$hidden   = $this->get_hidden_columns();
			$sortable = $this->get_sortable_columns();

			$this->_column_headers = array( $columns, $hidden, $sortable );

			// retrieve data for table.
			$this->items = $commissions;

			// sets pagination args.
			$this->set_pagination_args(
				array(
					'total_items' => $commissions->get_total_items(),
					'per_page'    => $per_page,
					'total_pages' => $commissions->get_total_pages(),
				)
			);
		}

		/* === FILTER METHODS === */

		/**
		 * Prepare query arguments from filter parameters
		 *
		 * @return array Array of query parameters.
		 */
		public function get_query_args() {
			$query_vars = $this->get_query_vars();
			$query_args = parent::get_query_args();

			// set correct 'status' and 'status__not_in' values.
			if ( ! empty( $query_vars['status'] ) && 'all' !== $query_vars['status'] ) {
				$query_args['status'] = $query_vars['status'];
			} else {
				$query_args['status__not_in'] = 'trash';
			}

			return $query_args;
		}
	}
}
