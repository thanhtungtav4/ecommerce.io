<?php
/**
 * Affiliate Dashboard Table
 *
 * @author  YITH
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Dashboard_Table' ) ) {
	/**
	 * Offer methods to print tables inside dashboard pages
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Dashboard_Table {

		/**
		 * Table columns
		 *
		 * @var array
		 */
		protected $columns;

		/**
		 * Collection of objects to show in current table
		 *
		 * @var YITH_WCAF_Abstract_Objects_Collection
		 */
		protected $collection;

		/**
		 * Array of additional parameters for current table
		 *
		 * @var array
		 */
		protected $args;

		/**
		 * Array of filters for current table
		 *
		 * @var array
		 */
		protected $filters;

		/**
		 * Values submitted for current table's filters
		 *
		 * @var array
		 */
		protected $filter_values;

		/**
		 * Construct table object
		 *
		 * @param YITH_WCAF_Abstract_Objects_Collection $collection Collection of objects to show in table rows.
		 * @param array                                 $args       Array of additional parameters.
		 */
		public function __construct( $collection, $args = array() ) {
			$this->args = wp_parse_args(
				$args,
				array(
					'endpoint'      => '',
					'columns'       => array(),
					'singular'      => 'item',
					'plural'        => 'items',
					'items'         => 'items',
					'disable_sort'  => false,
					'filters'       => false,
					'pagination'    => false,
					'count'         => false,
					'per_page'      => 10,
					'current_page'  => 1,
					'empty_message' => _x( 'Sorry! No item found.', '[FRONTEND] Generic message for empty tables on dashboard', 'yith-woocommerce-affiliates' ),
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_$items_table_columns
			 *
			 * Filters the columns of the items table in the dashboard.
			 * <code>$item</code> will be replaced with the item that is being displayed in the table.
			 *
			 * @param array $columns Table columns.
			 */
			$this->columns = apply_filters( "yith_wcaf_dashboard_{$this->args['items']}_table_columns", $args['columns'] );

			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_$items_table_collection
			 *
			 * Filters the objects to show in the table.
			 * <code>$item</code> will be replaced with the item that is being displayed in the table.
			 *
			 * @param YITH_WCAF_Abstract_Objects_Collection $collection Collection of objects to show in table rows.
			 */
			$this->collection = apply_filters( "yith_wcaf_dashboard_{$this->args['items']}_table_collection", $collection );
		}

		/**
		 * Checks if table contains a specific type of items (based on arguments passed during creation)
		 *
		 * @param string $what Kind of items to check.
		 * @return bool Whether table contains passed items.
		 */
		public function contains( $what ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_$items_table_contains
			 *
			 * Filters whether the table contains a specific type of items.
			 * <code>$item</code> will be replaced with the item that is being displayed in the table.
			 *
			 * @param bool                      $contains        Whether the table contains a specific type of items or not.
			 * @param string                    $what            Kind of items to check.
			 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
			 */
			return apply_filters( "yith_wcaf_dashboard_{$this->args['items']}_table_contains", $what === $this->args['items'], $what, $this );
		}

		/* === RENDER METHODS === */

		/**
		 * Renders current table
		 */
		public function render() {
			$this->render_topbar();

			$this->start_table();
			$this->render_heading();
			$this->render_body();
			$this->stop_table();

			$this->render_bottombar();
		}

		/**
		 * Render table topbar (filters, etc)
		 */
		protected function render_topbar() {
			?>
			<div class="yith-wcaf-table-top-bar">
				<form method="get">
					<?php
					/**
					 * DO_ACTION: yith_wcaf_before_dashboard_table_topbar
					 *
					 * Allows to render some content before the table topbar in the dashboard.
					 *
					 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
					 */
					do_action( 'yith_wcaf_before_dashboard_table_topbar', $this );

					/**
					 * DO_ACTION: yith_wcaf_before_dashboard_$items_table_topbar
					 *
					 * Allows to render some content before the table topbar in the dashboard.
					 * <code>$item</code> will be replaced with the item that is being displayed in the table.
					 *
					 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
					 */
					do_action( "yith_wcaf_before_dashboard_{$this->args['items']}_table_topbar", $this );

					$this->render_filters();
					$this->render_table_options();

					/**
					 * DO_ACTION: yith_wcaf_after_dashboard_$items_table_topbar
					 *
					 * Allows to render some content after the table topbar in the dashboard.
					 * <code>$item</code> will be replaced with the item that is being displayed in the table.
					 *
					 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
					 */
					do_action( "yith_wcaf_after_dashboard_{$this->args['items']}_table_topbar", $this );

					/**
					 * DO_ACTION: yith_wcaf_after_dashboard_table_topbar
					 *
					 * Allows to render some content after the table topbar in the dashboard.
					 *
					 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
					 */
					do_action( 'yith_wcaf_after_dashboard_table_topbar', $this );
					?>
					<?php wp_nonce_field( 'filter_items', 'security', false ); ?>
				</form>
			</div>
			<?php
		}

		/**
		 * Render filters  for current table, if enabled in the option
		 */
		protected function render_filters() {
			$filters = $this->get_filters();
			$values  = $this->get_filter_values();

			if ( empty( $filters ) ) {
				return;
			}
			?>
			<div class="table-filters">
				<?php
				foreach ( $filters as $filter ) {
					$renderer = "render_{$filter}_filter";
					$this->$renderer();
				}

				?>
				<input type="submit" value="<?php echo esc_html_x( 'Filter', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ); ?>"/>
				<?php if ( ! empty( $values ) ) : ?>
					<a href="<?php echo esc_url( YITH_WCAF_Dashboard()->get_dashboard_url( $this->args['endpoint'] ) ); ?>">
						<?php echo esc_html_x( 'Reset', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ); ?>
					</a>
				<?php endif; ?>
			</div>
			<?php
		}

		/**
		 * Render table options (items per row, etc), if enabled on table configuration
		 */
		protected function render_table_options() {
			?>
			<div class="table-options pull-right">
				<?php
				/**
				 * DO_ACTION: yith_wcaf_before_dashboard_table_options
				 *
				 * Allows to render some content before the table options in the dashboard.
				 *
				 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
				 */
				do_action( 'yith_wcaf_before_dashboard_table_options', $this );

				/**
				 * DO_ACTION: yith_wcaf_before_dashboard_$items_table_options
				 *
				 * Allows to render some content before the table options in the dashboard.
				 * <code>$item</code> will be replaced with the item that is being displayed in the table.
				 *
				 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
				 */
				do_action( "yith_wcaf_before_dashboard_{$this->args['items']}_table_options", $this );

				if ( $this->args['pagination'] ) :
					$per_page = $this->get_filter_values( 'per_page' );
					$per_page = $per_page ? $per_page : $this->args['per_page'];
					?>
					<label for="per_page" class="per-page">
						<?php echo esc_html_x( 'Items per page:', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ); ?>
						<input max="100" min="1" step="1" type="number" name="per_page" value="<?php echo esc_attr( $per_page ); ?>"/>
					</label>
					<?php
				endif;

				/**
				 * DO_ACTION: yith_wcaf_after_dashboard_$items_table_options
				 *
				 * Allows to render some content after the table options in the dashboard.
				 * <code>$item</code> will be replaced with the item that is being displayed in the table.
				 *
				 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
				 */
				do_action( "yith_wcaf_after_dashboard_{$this->args['items']}_table_options", $this );

				/**
				 * DO_ACTION: yith_wcaf_after_dashboard_table_options
				 *
				 * Allows to render some content after the table options in the dashboard.
				 *
				 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
				 */
				do_action( 'yith_wcaf_after_dashboard_table_options', $this );
				?>
			</div>
			<?php
		}

		/**
		 * Starts table tab
		 */
		protected function start_table() {
			/**
			 * DO_ACTION: yith_wcaf_before_dashboard_table
			 *
			 * Allows to render some content before the table in the dashboard.
			 *
			 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
			 */
			do_action( 'yith_wcaf_before_dashboard_table', $this );

			/**
			 * DO_ACTION: yith_wcaf_before_dashboard_$items_table
			 *
			 * Allows to render some content before the table in the dashboard.
			 * <code>$item</code> will be replaced with the item that is being displayed in the table.
			 *
			 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
			 */
			do_action( "yith_wcaf_before_dashboard_{$this->args['items']}_table", $this );
			?>
			<table id="yith_wcaf_dashboard_<?php echo esc_attr( $this->args['items'] ); ?>_table" class="shop_table shop_table_responsive yith-wcaf-table">
			<?php
		}

		/**
		 * Render <thead> element for current table
		 */
		protected function render_heading() {
			?>
			<thead>
				<?php foreach ( $this->columns as $key => $label ) : ?>
					<th class="column-<?php echo esc_attr( $key ); ?>">
						<?php if ( $this->is_column_sortable( $key ) ) : ?>
							<a rel="nofollow" href="<?php echo esc_url( $this->get_sort_url( $key ) ); ?>">
								<?php echo esc_html( $label ); ?>
							</a>
						<?php else : ?>
							<?php echo esc_html( $label ); ?>
						<?php endif; ?>
					</th>
				<?php endforeach; ?>
			</thead>
			<?php
		}

		/**
		 * Render <tbody> element for current table
		 */
		protected function render_body() {
			?>
			<tbody>
				<?php if ( $this->collection->is_empty() ) : ?>
					<?php $this->render_empty_row(); ?>
				<?php else : ?>
					<?php foreach ( $this->collection as $object ) : ?>
						<tr id="<?php echo esc_attr( $object->get_id() ); ?>">
							<?php foreach ( $this->columns as $key => $label ) : ?>
								<td class="column-<?php echo esc_attr( $key ); ?>"  <?php echo $label ? wp_kses_post( "data-title='{$label}'" ) : ''; ?> >
									<?php $this->render_cell( $object, $key ); ?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
			<?php
		}

		/**
		 * Render empty body, when table has no item
		 */
		protected function render_empty_row() {
			?>
			<tr class="empty-table">
				<td colspan="<?php echo count( $this->columns ); ?>">
					<?php
					echo esc_html( $this->args['empty_message'] );
					?>
				</td>
			</tr>
			<?php
		}

		/**
		 * Render specific table cell (identified by row-object and column-key)
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 * @param string                    $field  Column key.
		 */
		protected function render_cell( $object, $field ) {
			$getter   = "get_{$field}";
			$renderer = "render_{$field}_column";

			if ( has_action( "yith_wcaf_dashboard_{$this->args['items']}_table_render_{$field}_column" ) ) {
				/**
				 * DO_ACTION: yith_wcaf_dashboard_$items_table_render_$field_column
				 *
				 * Allows to render some content for the field column in the dashboard table.
				 * <code>$item</code> will be replaced with the item that is being displayed in the table.
				 * <code>$field</code> will be replaced with the column key.
				 *
				 * @param YITH_WCAF_Abstract_Object $object          Row object.
				 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
				 */
				do_action( "yith_wcaf_dashboard_{$this->args['items']}_table_render_{$field}_column", $object, $this );
			} elseif ( method_exists( $this, $renderer ) ) {
				$this->$renderer( $object );
			} elseif ( method_exists( $object, $getter ) ) {
				$cell_value = $object->$getter();

				if ( empty( $cell_value ) ) {
					$this->render_empty_cell( $object, $field );
				} else {
					echo wp_kses_post( $cell_value );
				}
			} else {
				$this->render_empty_cell( $object, $field );
			}
		}

		/**
		 * Render empty cell for the table
		 *
		 * @param WC_Data $object Row object.
		 * @param string  $field  Column key.
		 */
		protected function render_empty_cell( $object, $field ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_$items_table_empty_cell
			 *
			 * Filters the content of the empty cell in the dashboard tables.
			 * <code>$item</code> will be replaced with the item that is being displayed in the table.
			 *
			 * @param string $label Label for the empty cell in the table.
			 */
			$empty = apply_filters(
				"yith_wcaf_dashboard_{$this->args['items']}_table_empty_cell",
				esc_html_x( 'N/A', '[FRONTEND] Default column content for dashboard tables', 'yith-woocommerce-affiliates' ),
				$field,
				$object
			);

			echo wp_kses_post( $empty );
		}

		/**
		 * Ends table tab
		 */
		protected function stop_table() {
			?>
			</table>
			<?php
			/**
			 * DO_ACTION: yith_wcaf_after_dashboard_$items_table
			 *
			 * Allows to render some content after the table in the dashboard.
			 * <code>$item</code> will be replaced with the item that is being displayed in the table.
			 *
			 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
			 */
			do_action( "yith_wcaf_after_dashboard_{$this->args['items']}_table", $this );

			/**
			 * DO_ACTION: yith_wcaf_after_dashboard_table
			 *
			 * Allows to render some content after the table in the dashboard.
			 *
			 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
			 */
			do_action( 'yith_wcaf_after_dashboard_table', $this );
		}

		/**
		 * Render table bottombar (pagination, etc)
		 */
		protected function render_bottombar() {
			?>
			<div class="yith-wcaf-table-bottom-bar">
				<?php
				/**
				 * DO_ACTION: yith_wcaf_before_dashboard_table_bottmbar
				 *
				 * Allows to render some content before the table bottombar in the dashboard.
				 *
				 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
				 */
				do_action( 'yith_wcaf_before_dashboard_table_bottmbar', $this );

				/**
				 * DO_ACTION: yith_wcaf_before_dashboard_$items_table_bottmbar
				 *
				 * Allows to render some content before the table bottombar in the dashboard.
				 * <code>$item</code> will be replaced with the item that is being displayed in the table.
				 *
				 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
				 */
				do_action( "yith_wcaf_before_dashboard_{$this->args['items']}_table_bottmbar", $this );

				$this->render_pagination();

				/**
				 * DO_ACTION: yith_wcaf_after_dashboard_$items_table_bottmbar
				 *
				 * Allows to render some content after the table bottombar in the dashboard.
				 * <code>$item</code> will be replaced with the item that is being displayed in the table.
				 *
				 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
				 */
				do_action( "yith_wcaf_after_dashboard_{$this->args['items']}_table_bottmbar", $this );

				/**
				 * DO_ACTION: yith_wcaf_after_dashboard_table_bottmbar
				 *
				 * Allows to render some content after the table bottombar in the dashboard.
				 *
				 * @param YITH_WCAF_Dashboard_Table $dashboard_table Dashboard table object.
				 */
				do_action( 'yith_wcaf_after_dashboard_table_bottmbar', $this );
				?>
			</div>
			<?php
		}

		/**
		 * Render pagination links for current table
		 */
		protected function render_pagination() {
			if ( ! $this->args['pagination'] ) {
				return;
			}

			$current  = get_query_var( $this->args['endpoint'] );
			$current  = $current ? $current : $this->args['current_page'];
			$per_page = (int) $this->get_filter_values( 'per_page' );
			$per_page = $per_page ? $per_page : (int) $this->args['per_page'];
			$pages    = ceil( (int) $this->args['count'] / $per_page );

			?>
			<nav class="woocommerce-pagination">
				<?php
				echo wp_kses_post(
					paginate_links(
						array(
							'base'      => YITH_WCAF_Dashboard()->get_dashboard_url( $this->args['endpoint'], '%#%' ),
							'format'    => '%#%',
							'current'   => $current,
							'total'     => $pages,
							'show_all'  => false,
							'prev_next' => true,
						)
					)
				);
				?>
			</nav>
			<?php
		}

		/* ==== FILTER METHODS === */

		/**
		 * Returns filters available for current table
		 *
		 * @return array Array of available filters.
		 */
		protected function get_filters() {
			if ( ! empty( $this->filters ) ) {
				return $this->filters;
			}

			if ( empty( $this->args['filters'] ) || ! is_array( $this->args['filters'] ) ) {
				return array();
			}

			$supported_filters = array(
				'status',
				'product',
				'interval',
			);

			$this->filters = array_intersect(
				$this->args['filters'],
				$supported_filters
			);

			return $this->filters;
		}

		/**
		 * Returns values submitted for filters defined for current table
		 *
		 * @param string $field Field to retrieve, if any.
		 * @return array|string Filters' values, or value for a specific filter if $field is non-empty
		 */
		protected function get_filter_values( $field = '' ) {
			$filters = $this->get_filters();
			$values  = $this->filter_values;

			if ( empty( $values ) ) {
				$values = $field ? false : array();

				if ( empty( $filters ) ) {
					return $values;
				}

				if ( ! isset( $_REQUEST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ), 'filter_items' ) ) {
					return $values;
				}

				// set up order by parameters.
				$filters[] = 'orderby';
				$filters[] = 'order';

				// set up interval parameters.
				if ( in_array( 'interval', $filters, true ) ) {
					$filters[] = 'from';
					$filters[] = 'to';
				}

				// set up pagination parameters.
				if ( $this->args['pagination'] ) {
					$filters[] = 'per_page';
				}

				foreach ( $filters as $filter ) {
					if ( ! isset( $_REQUEST[ $filter ] ) ) {
						continue;
					}

					$values[ $filter ] = sanitize_text_field( wp_unslash( $_REQUEST[ $filter ] ) );
				}

				$this->filter_values = $values;
			}

			if ( $field ) {
				return isset( $values[ $field ] ) ? $values[ $field ] : false;
			}

			return $values;
		}

		/**
		 * Renders select to filter items per status
		 */
		protected function render_status_filter() {
			if ( empty( $this->args['endpoint'] ) ) {
				return;
			}

			$handler = 'YITH_WCAF_' . $this->args['endpoint'];

			if ( ! function_exists( $handler ) ) {
				return;
			}

			$handler_obj = $handler();

			if ( ! is_object( $handler_obj ) || ! method_exists( $handler_obj, 'get_available_statuses' ) ) {
				return;
			}

			$statuses        = $handler_obj->get_available_statuses();
			$selected_status = $this->get_filter_values( 'status' );

			?>
			<select name="status" id="status">
				<option value="">
					<?php echo esc_html_x( 'All status', '[FRONTEND] Dashboard table filters', 'yith-woocommerce-affiliates' ); ?>
				</option>

				<?php foreach ( $statuses as $status_slug => $status ) : ?>
					<?php
					if ( 'trash' === $status_slug ) {
						continue;
					}
					?>
					<option value="<?php echo esc_attr( $status_slug ); ?>" <?php selected( $status_slug, $selected_status ); ?> >
						<?php echo esc_html( $status['name'] ); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<?php
		}

		/**
		 * Renders select to filter items per product
		 */
		protected function render_product_filter() {
			$product_id   = $this->get_filter_values( 'product' );
			$product_name = '';

			if ( $product_id ) {
				$product      = wc_get_product( $product_id );
				$product_name = $product ? $product->get_formatted_name() : $product_name;
			}

			?>
			<input
				type="hidden"
				class="product-search wc-product-search"
				name="product_id"
				data-placeholder="<?php echo esc_html_x( 'All products', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ); ?>"
				value="<?php echo esc_attr( $product_id ); ?>"
				data-selected="<?php echo esc_attr( $product_name ); ?>"
			/>
			<?php
		}

		/**
		 * Renders date-range picker, to filter items by date
		 */
		protected function render_interval_filter() {
			$from = $this->get_filter_values( 'from' );
			$to   = $this->get_filter_values( 'to' );

			$formatted_from = yith_wcaf_js_date_format( $from );
			$formatted_to   = yith_wcaf_js_date_format( $to );
			?>
			<input
				type="text"
				class="yith-wcaf-enhanced-date-picker datepicker"
				placeholder="<?php echo esc_html_x( 'From:', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ); ?>"
				value="<?php echo esc_attr( $formatted_from['date'] ); ?>"
				data-altField=".hidden-from"
				data-altFormat="yy-mm-dd"
				data-format="<?php echo esc_attr( $formatted_from['format'] ); ?>"
			/>
			<input type="hidden" value="<?php echo esc_attr( $from ); ?>" name="from" class="hidden-from" />
			<input
				type="text"
				class="yith-wcaf-enhanced-date-picker datepicker"
				placeholder="<?php echo esc_html_x( 'To:', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ); ?>"
				value="<?php echo esc_attr( $formatted_to['date'] ); ?>"
				data-altField=".hidden-to"
				data-altFormat="yy-mm-dd"
				data-format="<?php echo esc_attr( $formatted_from['format'] ); ?>"
			/>
			<input type="hidden" value="<?php echo esc_attr( $to ); ?>" name="to" class="hidden-to" />
			<?php
		}

		/* === COLUMN METHODS === */

		/**
		 * Render column for "ID" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_id_column( $object ) {
			$id = $object->get_id();

			echo esc_html( sprintf( '#%s', $id ) );
		}

		/**
		 * Render column for "status" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_status_column( $object ) {
			if ( ! method_exists( $object, 'get_status' ) ) {
				$this->render_empty_cell( $object, 'status' );
				return;
			}

			$status = $object->get_status();
			$label  = $status;

			if ( method_exists( $object, 'get_formatted_status' ) ) {
				$label = $object->get_formatted_status();
			}

			?>
			<mark class="status-badge <?php echo esc_attr( $status ); ?>">
				<?php echo esc_html( $label ); ?>
			</mark>
			<?php
		}

		/**
		 * Render column for "amount" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_amount_column( $object ) {
			if ( method_exists( $object, 'get_formatted_amount' ) ) {
				echo wp_kses_post( $object->get_formatted_amount() );
			} elseif ( method_exists( $object, 'get_amount' ) ) {
				echo wp_kses_post( wc_price( $object->get_amount() ) );
			} else {
				$this->render_empty_cell( $object, 'amount' );
			}
		}

		/**
		 * Render column for "rate" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_rate_column( $object ) {
			if ( method_exists( $object, 'get_formatted_rate' ) ) {
				echo wp_kses_post( $object->get_formatted_rate() );
			} elseif ( method_exists( $object, 'get_rate' ) ) {
				echo esc_html( yith_wcaf_rate_format( $object->get_rate() ) );
			} else {
				$this->render_empty_cell( $object, 'rate' );
			}
		}

		/**
		 * Render column for "product" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_product_column( $object ) {
			if ( ! method_exists( $object, 'get_product' ) ) {
				$this->render_empty_cell( $object, 'product' );
				return;
			}

			$product = $object->get_product();

			if ( ! $product ) {
				$this->render_empty_cell( $object, 'product' );
				return;
			}

			?>
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
				<?php echo wp_kses_post( $product->get_formatted_name() ); ?>
			</a>
			<?php
		}

		/**
		 * Render column for "invoice" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_invoice_column( $object ) {
			if ( ! method_exists( $object, 'get_invoice_url' ) ) {
				$this->render_empty_cell( $object, 'invoice' );
				return;
			}

			$invoice_url = $object->get_invoice_url();

			if ( ! $invoice_url || ! $object->has_status( array( 'completed', 'on-hold' ) ) ) {
				$this->render_empty_cell( $object, 'invoice' );
				return;
			}

			?>
			<a href="<?php echo esc_url( $invoice_url ); ?>">
				#<?php echo wp_kses_post( $object->get_id() ); ?>
			</a>
			<?php
		}

		/**
		 * Render column for "created_at" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_created_at_column( $object ) {
			if ( ! method_exists( $object, 'get_created_at' ) ) {
				$this->render_empty_cell( $object, 'created_at' );
				return;
			}

			$this->render_formatted_date( $object->get_created_at( 'edit' ), $object, 'created_at' );
		}

		/**
		 * Render column for "completed_at" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_completed_at_column( $object ) {
			if ( ! method_exists( $object, 'get_completed_at' ) ) {
				$this->render_empty_cell( $object, 'completed_at' );
				return;
			}

			$this->render_formatted_date( $object->get_completed_at( 'edit' ), $object, 'completed_at' );
		}

		/**
		 * Render column for "click_date" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_click_date_column( $object ) {
			if ( ! method_exists( $object, 'get_date' ) ) {
				$this->render_empty_cell( $object, 'click_date' );
				return;
			}

			$this->render_formatted_date( $object->get_date( 'edit' ), $object, 'click_date' );
		}

		/**
		 * Render column for "date" field
		 *
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 */
		public function render_date_column( $object ) {
			if ( ! method_exists( $object, 'get_date' ) ) {
				$this->render_empty_cell( $object, 'date' );
				return;
			}

			$this->render_formatted_date( $object->get_date( 'edit' ), $object, 'date' );
		}

		/**
		 * Render generic date column inside the table
		 *
		 * @param WC_DateTime               $date   Date to render.
		 * @param YITH_WCAF_Abstract_Object $object Row object.
		 * @param string                    $field  Field in the object containing date.
		 */
		public function render_formatted_date( $date, $object = null, $field = '' ) {
			if ( ! $date ) {
				$this->render_empty_cell( $object, $field );
				return;
			}

			echo esc_html( $date->date_i18n( wc_date_format() ) );
		}

		/**
		 * Checks whether a specific column is sortable
		 *
		 * @param string $column Column key.
		 * @return bool Whether column is sortable or not.
		 */
		protected function is_column_sortable( $column ) {
			if ( false === $this->args['disable_sort'] ) {
				return true;
			} elseif ( is_array( $this->args['disable_sort'] ) && ! in_array( $column, $this->args['disable_sort'], true ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Returns url to sort table for a specific column
		 *
		 * @param string $column Column key.
		 * @return string Url to sort table.
		 */
		protected function get_sort_url( $column ) {
			if ( ! $this->is_column_sortable( $column ) ) {
				return '#';
			}

			$current_orderby = $this->get_filter_values( 'orderby' );
			$current_order   = $this->get_filter_values( 'order' );
			$next_order      = 'DESC' === $current_order ? 'ASC' : 'DESC';

			$args = array(
				'orderby' => $column,
				'order'   => $column === $current_orderby ? $next_order : 'DESC',
			);

			return wp_nonce_url( add_query_arg( $args ), 'filter_items', 'security' );
		}

	}
}
