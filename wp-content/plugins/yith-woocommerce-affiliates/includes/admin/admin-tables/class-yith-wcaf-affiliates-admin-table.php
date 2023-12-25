<?php
/**
 * Affiliate Table class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliates_Admin_Table' ) ) {
	/**
	 * WooCommerce Affiliates Table
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Affiliates_Admin_Table extends YITH_WCAF_Abstract_Admin_Table {
		/**
		 * Class constructor method
		 *
		 * @param array $args Arguments for the parent constructor.
		 * @since 1.0.0
		 */
		public function __construct( $args = array() ) {
			// sets available filters.
			$this->filters = array(
				'status'       => array(
					'default' => 'all',
				),
				'affiliate_id' => array(
					'sanitize'  => 'intval',
					'query_var' => '_affiliate_id',
				),
				'orderby'      => array(
					'default' => 'ID',
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
						'singular'      => 'affiliate',
						'plural'        => 'affiliates',
						'ajax'          => false,
						'empty_message' => _x( 'Sorry! There is no affiliate registered yet.', '[ADMIN] Affiliate empty table message', 'yith-woocommerce-affiliates' ),
					)
				)
			);
		}

		/* === DISPLAY METHODS === */

		/**
		 * Shows empty message for items in the table
		 *
		 * @return void
		 */
		public function display_empty_message() {
			parent::display_empty_message();
			?>
			<a id="yith-wcaf-create-affiliate" href="#" role="button" class="button yith-add-button yith-plugin-fw__button--xxl" >
				<?php echo esc_html_x( 'Add affiliate', '[ADMIN] Add new affiliate button, in affiliates tab', 'yith-woocommerce-affiliates' ); ?>
			</a>
            <script type="text/javascript">
                ( function () {
                    var heading = document.querySelector( '.yith-plugin-fw__panel__content__page__title' ),
                        button  = document.getElementById( 'yith-wcaf-create-affiliate' );
                    heading && heading.parentNode.insertBefore( button, heading.nextSibling);
                } )();
            </script>
			<?php
		}

		/* === COLUMNS METHODS === */

		/**
		 * Print column with affiliate token
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_token( $item ) {
			$column = $item['token'];

			return $column;
		}

		/**
		 * Print column with affiliate status (enabled/disabled)
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_status( $item ) {
			$banned  = $item->is_banned();
			$enabled = $item->get_enabled();

			if ( $banned ) {
				$formatted_status = _x( 'Banned', '[ADMIN] Affiliate status in admin table', 'yith-woocommerce-affiliates' );
				$status           = 'banned';
			} else {
				switch ( $enabled ) {
					case 0:
						$formatted_status = _x( 'Pending', '[ADMIN] Affiliate status in admin table', 'yith-woocommerce-affiliates' );
						$status           = 'pending';
						break;
					case - 1:
						$formatted_status = _x( 'Rejected', '[ADMIN] Affiliate status in admin table', 'yith-woocommerce-affiliates' );
						$status           = 'disabled';
						break;
					case 1:
					default:
						$formatted_status = _x( 'Accepted', '[ADMIN] Affiliate status in admin table', 'yith-woocommerce-affiliates' );
						$status           = 'enabled';
						break;
				}
			}

			$reduced = $this->table_has_class( 'small-status' );

			if ( $reduced ) {
				$shortened_status = substr( $formatted_status, 0, 1 );

				$column = sprintf( '<mark class="%1$s small tips status-badge" data-tip="%2$s">%3$s</mark>', $item->get_status(), $formatted_status, $shortened_status );
			} else {
				$column = sprintf( '<mark class="%1$s status-badge">%2$s</mark>', $status, $formatted_status );
			}

			return $column;
		}

		/**
		 * Print column with affiliate custom rate (if any)
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_rate( $item ) {
			$column = '';
			if ( ! empty( $item->get_rate() ) ) {
				$column .= yith_wcaf_rate_format( $item->get_rate(), 2 );
			} else {
				$column .= _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			}

			return $column;
		}

		/**
		 * Print column with affiliate earnings (total commission earned, including paid and refunded one)
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_earnings( $item ) {
			$column  = '';
			$column .= wc_price( $item->get_total() );

			return $column;
		}

		/**
		 * Print column with affiliate paid (total of paid commissions)
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_paid( $item ) {
			$column  = '';
			$column .= wc_price( $item->get_paid() );

			return $column;
		}

		/**
		 * Print column with affiliate balance (earnings - refund - paid)
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_balance( $item ) {
			$column  = '';
			$column .= wc_price( $item->get_balance() );

			return $column;
		}

		/**
		 * Print column with affiliate clicks
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_click( $item ) {
			$column  = '';
			$column .= $item->get_clicks_count();

			return $column;
		}

		/**
		 * Print column with affiliate conversions
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_conversion( $item ) {
			$column  = '';
			$column .= $item->get_conversions();

			return $column;
		}

		/**
		 * Print column with affiliate conversion rate ( conversion / clicks * 100 )
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_conv_rate( $item ) {
			$column = '';
			if ( $item->get_conversion_rate() ) {
				$column .= sprintf( '%.2f%%', number_format( $item->get_conversion_rate(), 2 ) );
			} else {
				$column .= _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
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
				'cb'         => '<input type="checkbox" />',
				'affiliate'  => _x( 'Affiliate', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'id'         => _x( 'ID', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'token'      => _x( 'Token', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'rate'       => _x( 'Rate', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'earnings'   => _x( 'Earnings', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'paid'       => _x( 'Paid', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'balance'    => _x( 'Balance', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'click'      => _x( 'Visits', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'conversion' => _x( 'Conversion', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'conv_rate'  => _x( 'Conversion rate', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'status'     => _x( 'Status', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
				'actions'    => _x( 'Actions', '[ADMIN] Affiliates table headings', 'yith-woocommerce-affiliates' ),
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
				'id'         => array( 'ID', true ),
				'token'      => array( 'token', true ),
				'rate'       => array( 'rate', false ),
				'affiliate'  => array( 'user_login', false ),
				'earnings'   => array( 'totals', false ),
				'refunds'    => array( 'refunds', false ),
				'paid'       => array( 'paid', false ),
				'balance'    => array( 'balance', false ),
				'click'      => array( 'click', false ),
				'conversion' => array( 'conversion', false ),
				'conv_rate'  => array( 'conv_rate', false ),
			);

			return $sortable_columns;
		}

		/* === OTHER METHODS === */

		/**
		 * Generates content for a single row of the table.
		 *
		 * @since 3.1.0
		 *
		 * @param YITH_WCAF_Affiliate $item Current item row.
		 */
		public function single_row( $item ) {
			echo '<tr class="affiliate-item ' . esc_attr( $item->is_banned() ? 'banned' : $item->get_status() ) . '" data-full_name="' . esc_attr( $item->get_formatted_name() ) . '">';
			$this->single_row_columns( $item );
			echo '</tr>';
		}

		/**
		 * Returns an array of per available views for current table
		 *
		 * @return array
		 */
		public function get_available_views() {
			return array_merge(
				parent::get_available_views(),
				wp_list_pluck( YITH_WCAF_Affiliates::get_available_statuses(), 'slug' ),
				array(
					'banned',
				)
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
				$label = _x( 'All', '[ADMIN] Affiliates view', 'yith-woocommerce-affiliates' );
			} elseif ( 'banned' === $view ) {
				$label = _nx( 'Banned', 'Banned', $count, '[ADMIN] Affiliates view', 'yith-woocommerce-affiliates' );
			} else {
				$label = YITH_WCAF_Affiliates::get_readable_status( $view, $count );
			}

			return parent::get_view_label( $label, $count );
		}

		/**
		 * Returns an array of per view items count
		 *
		 * @param array $query_args Query arguments.
		 * @return array
		 */
		public function get_per_view_count( $query_args ) {
			return YITH_WCAF_Affiliates()->per_status_count( false, $query_args );
		}

		/**
		 * Return list of available bulk actions
		 *
		 * @return array Available bulk action
		 * @since 1.0.0
		 */
		public function get_bulk_actions() {
			$actions = array(
				'delete'  => _x( 'Delete affiliate', '[ADMIN] Affiliates bulk actions', 'yith-woocommerce-affiliates' ),
				'enable'  => _x( 'Change status to accepted', '[ADMIN] Affiliates bulk actions', 'yith-woocommerce-affiliates' ),
				'disable' => _x( 'Change status to rejected', '[ADMIN] Affiliates bulk actions', 'yith-woocommerce-affiliates' ),
				'ban'     => _x( 'Ban affiliate', '[ADMIN] Affiliates bulk actions', 'yith-woocommerce-affiliates' ),
				'unban'   => _x( 'Unban affiliate', '[ADMIN] Affiliates bulk actions', 'yith-woocommerce-affiliates' ),
			);

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
			$per_page     = $this->get_items_per_page( 'edit_affiliates_per_page' );
			$current_page = $this->get_pagenum();
			$affiliates   = YITH_WCAF_Affiliates()->get_affiliates(
				array_merge(
					array(
						'limit'  => $per_page,
						'offset' => ( ( $current_page - 1 ) * $per_page ),
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
			$this->items = $affiliates;

			// sets pagination args.
			$this->set_pagination_args(
				array(
					'total_items' => $affiliates->get_total_items(),
					'per_page'    => $per_page,
					'total_pages' => $affiliates->get_total_pages(),
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

			// set correct 'enabled' and 'banned' values.
			if ( ! empty( $query_vars['status'] ) && ! in_array( $query_vars['status'], array( 'all', 'banned' ), true ) ) {
				$query_args['enabled'] = sanitize_text_field( wp_unslash( $query_vars['status'] ) );
				$query_args['banned']  = 'unbanned';
			} elseif ( ! empty( $query_vars['status'] ) && 'banned' === $query_vars['status'] ) {
				$query_args['banned'] = 'banned';
			}

			return $query_args;
		}
	}
}
