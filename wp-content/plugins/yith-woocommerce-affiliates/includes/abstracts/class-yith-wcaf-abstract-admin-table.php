<?php
/**
 * General admin table handling
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Abstract_Admin_Table' ) ) {
	/**
	 * Wraps general method used in admin panel
	 *
	 * @since 1.0.0
	 */
	abstract class YITH_WCAF_Abstract_Admin_Table extends WP_List_Table {

		/**
		 * The current list of items.
		 *
		 * @var YITH_WCAF_Abstract_Objects_Collection
		 */
		public $items;

		/**
		 * Number of items per page; if this param is empty, screen option will be used instead
		 *
		 * @var int $items_per_page
		 */
		protected $items_per_page;

		/**
		 * Visible columns; if this param is empty, screen option will be used instead
		 *
		 * @var array $visible_columns
		 */
		protected $visible_columns;

		/**
		 * Filters available for current table
		 *
		 * @var array $filters
		 */
		protected $filters;

		/**
		 * An array of available views
		 *
		 * @var array
		 */
		protected $views;

		/**
		 * Query variables matching defined filters
		 *
		 * @var array $query_vars
		 */
		protected $query_vars = array();

		/**
		 * Array that contains tablenavs to show.
		 *
		 * @var array
		 */
		protected $tablenav_to_show = array(
			'top',
		);

		/**
		 * Class constructor method
		 *
		 * @param array $args Arguments for the parent constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct( $args ) {
			$tab    = YITH_WCAF_Admin()->get_tab_instance();
			$screen = $tab ? $tab->get_screen_id() : false;
			$screen = $screen ? $screen : YITH_WCAF_Admin()->get_panel_screen_id();

			// Set parent defaults.
			parent::__construct(
				array_merge(
					$args,
					array(
						'screen' => $screen,
					)
				)
			);
		}

		/* === COLUMNS METHODS === */

		/**
		 * Print default column content
		 *
		 * @param YITH_WCAF_Abstract_Object $item        Item of the row.
		 * @param string                    $column_name Column name.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_default( $item, $column_name ) {
			if ( isset( $item->$column_name ) ) {
				return esc_html( $item->$column_name );
			} else {
				// Show the whole array for troubleshooting purposes.
				/**
				 * APPLY_FILTERS: yith_wcaf_$plural_table_column_default
				 *
				 * Filters the content of the default column in the table in the backend.
				 * <code>$plural</code> will be replaced with the plural form of the item in the table.
				 *
				 * @param YITH_WCAF_Abstract_Object $item        Item of the row.
				 * @param string                    $column_name Column name.
				 */
				return apply_filters( "yith_wcaf_{$this->_args['plural']}_table_column_default", print_r( $item, true ), $item, $column_name ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions
			}
		}

		/**
		 * Print a column with checkbox for bulk actions
		 *
		 * @param YITH_WCAF_Abstract_Object $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_cb( $item ) {
			return sprintf(
				'<input class="item-selector" type="checkbox" name="%1$s[]" value="%2$s" />',
				$this->_args['plural'],
				$item->get_id()
			);
		}

		/**
		 * Print column with object ID
		 *
		 * @param YITH_WCAF_Abstract_Object $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_id( $item ) {
			$column = sprintf( '<strong>#%s</strong>', $item->get_id() );

			return $column;
		}

		/**
		 * Print column with object status
		 *
		 * @param YITH_WCAF_Abstract_Object $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_status( $item ) {
			$reduced = $this->table_has_class( 'small-status' );

			if ( $reduced ) {
				$formatted_status = $item->get_formatted_status();
				$shortened_status = method_exists( $item, 'get_shortened_status' ) ? $item->get_shortened_status() : $formatted_status;

				$column = sprintf( '<mark class="%1$s small tips status-badge" data-tip="%2$s">%3$s</mark>', $item->get_status(), $item->get_formatted_status(), $shortened_status );
			} else {
				$column = sprintf( '<mark class="%1$s status-badge">%2$s</mark>', $item->get_status(), $item->get_formatted_status() );
			}

			return $column;
		}

		/**
		 * Print column with affiliate user details
		 *
		 * @param YITH_WCAF_Abstract_Object $item Current item row.
		 * @param array                     $args Array of additional arguments.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_affiliate( $item, $args = array() ) {
			$column = '';

			if ( $item instanceof YITH_WCAF_Affiliate ) {
				$affiliate = $item;
			} elseif ( method_exists( $item, 'get_affiliate' ) ) {
				$affiliate = $item->get_affiliate();
			}

			if ( empty( $affiliate ) ) {
				return $column;
			}

			$user = $affiliate->get_user();

			if ( ! $user ) {
				return $column;
			}

			$username      = $affiliate->get_formatted_name();
			$user_email    = $user->user_email;
			$payment_email = $affiliate->get_payment_email();
			$payment_email = ! empty( $payment_email ) ? $payment_email : _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );

			$args = wp_parse_args(
				$args,
				array(
					'show_links'         => false,
					'show_payment_email' => false,
					'row_actions'        => false,
				)
			);

			list( $show_links, $show_payment_email, $row_actions ) = yith_plugin_fw_extract( $args, 'show_links', 'show_payment_email', 'row_actions' );

			$column .= get_avatar( $user->ID, 50 );
			$column .= '<div class="affiliate-details">';

			if ( $show_links ) {
				$column .= sprintf( '<a href="%1$s">%2$s</a>', $affiliate->get_admin_edit_url(), $username );
			} else {
				$column .= $username;
			}

			if ( $show_links ) {
				$column .= sprintf( '<small class="meta email"><a href="mailto:%1$s">%1$s</a></small>', $user_email );
			} else {
				$column .= sprintf( '<small class="meta email">%1$s</small>', $user_email );
			}

			if ( $show_payment_email ) {
				$column .= sprintf( '<small class="meta email">%1$s: %2$s</small>', _x( 'Payment', '[ADMIN] Label for payment email on admin tables', 'yith-woocommerce-affiliates' ), $payment_email );
			}

			if ( $row_actions ) {
				$column .= $this->row_actions( $row_actions );
			}

			$column .= '</div>';

			/**
			 * APPLY_FILTERS: yith_wcaf_admin_table_affiliate_column
			 *
			 * Filters the content of the affiliate column in the table in the backend.
			 *
			 * @param string                    $column Column content.
			 * @param YITH_WCAF_Abstract_Object $item   Current item row.
			 */
			return apply_filters( 'yith_wcaf_admin_table_affiliate_column', $column, $item );
		}

		/**
		 * Print column with object amount
		 *
		 * @param YITH_WCAF_Abstract_Object $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_amount( $item ) {
			$column = '';

			if ( ! method_exists( $item, 'get_formatted_amount' ) ) {
				return $column;
			}

			$column .= '<strong>' . $item->get_formatted_amount() . '</strong>';

			/**
			 * APPLY_FILTERS: yith_wcaf_payments_table_column_amount
			 *
			 * Filters the content of the amount column in the table in the backend.
			 *
			 * @param string                    $column Column content.
			 * @param YITH_WCAF_Abstract_Object $item   Current item row.
			 */
			return apply_filters( 'yith_wcaf_payments_table_column_amount', $column, $item );
		}

		/**
		 * Print column with order details
		 *
		 * @param YITH_WCAF_Abstract_Object $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_order( $item ) {
			$column   = '';
			$order_id = $item->get_order_id();
			$order    = $item->get_order();

			if ( ! $order ) {
				return _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			}

			$customer_tip  = array();
			$address       = $order->get_formatted_billing_address();
			$billing_phone = $order->get_billing_phone();
			$user_id       = $order->get_user_id();

			if ( $address ) {
				$customer_tip[] = _x( 'Billing information:', '[ADMIN] Order column on admin tables', 'yith-woocommerce-affiliates' );
				$customer_tip[] = $address;
			}

			if ( $billing_phone ) {
				$customer_tip[] = _x( 'Tel.:', '[ADMIN] Order column on admin tables', 'yith-woocommerce-affiliates' ) . ' ' . $billing_phone;
			}

			$column .= '<div class="tips" data-tip="' . wc_sanitize_tooltip( implode( '<br/>', $customer_tip ) ) . '">';

			if ( $user_id ) {
				$user_info = get_userdata( $order->get_user_id() );
			}

			if ( ! empty( $user_info ) ) {
				$username = '<a href="user-edit.php?user_id=' . absint( $user_info->ID ) . '">';

				if ( $user_info->first_name || $user_info->last_name ) {
					$username .= esc_html( ucfirst( $user_info->first_name ) . ' ' . ucfirst( $user_info->last_name ) );
				} else {
					$username .= esc_html( ucfirst( $user_info->display_name ) );
				}

				$username .= '</a>';

			} else {
				$billing_first_name = $order->get_billing_first_name();
				$billing_last_name  = $order->get_billing_last_name();

				if ( $billing_first_name || $billing_last_name ) {
					$username = trim( $billing_first_name . ' ' . $billing_last_name );
				} else {
					$username = _x( 'Guest', '[ADMIN] Order column on admin tables', 'yith-woocommerce-affiliates' );
				}
			}

			// translators: 1. Order number 2. Username.
			$column .= sprintf(
				'<a href="%1$s">#%2$s</a><div class="order-details">%3$s %4$s</div>',
				get_edit_post_link( $order_id ),
				$order->get_order_number(),
				_x( 'by', '[ADMIN] Commission order column', 'yith-woocommerce-affiliates' ),
				$username
			);

			$column .= '</div>';

			return $column;
		}

		/**
		 * Print column with affiliate actions
		 *
		 * @param YITH_WCAF_Abstract_Object $item Current item row.
		 *
		 * @return string Column content
		 * @since 1.0.0
		 */
		public function column_actions( $item ) {
			$actions = $item->get_admin_actions();
			$links   = '';

			if ( ! empty( $actions ) ) {
				// first of all check for 'view' action.
				if ( isset( $actions['view'] ) ) {
					$links .= yith_plugin_fw_get_component(
						array(
							'type'   => 'action-button',
							'action' => $actions['view']['label'],
							'icon'   => 'eye',
							'url'    => $actions['view']['url'],
						),
						false
					);

					unset( $actions['view'] );
				}

				// then check for 'edit' action.
				if ( isset( $actions['edit'] ) ) {
					$links .= yith_plugin_fw_get_component(
						array(
							'type'   => 'action-button',
							'action' => $actions['edit']['label'],
							'icon'   => 'edit',
							'url'    => $actions['edit']['url'],
						),
						false
					);

					unset( $actions['edit'] );
				}

				// then process all other actions.
				$additional_actions = array();

				foreach ( $actions as $action_id => $action_details ) {
					list( $label, $url ) = yith_plugin_fw_extract( $action_details, 'label', 'url' );

					if ( ! $url || ! $label ) {
						continue;
					}

					$additional_action = array(
						'name'  => $label,
						'url'   => $url,
						'class' => $action_id,
					);

					if ( 'delete' === $action_id ) {
						$additional_action['confirm_data'] = array(
							'title'               => _x( 'Confirm delete', '[ADMIN] Confirmation popup before deleting an item', 'yith-woocommerce-affiliates' ),
							'message'             => _x( 'Are you sure you want to delete this item?', '[ADMIN] Confirmation popup before deleting an item', 'yith-woocommerce-affiliates' ),
							'confirm-button'      => _x( 'Delete', '[ADMIN] Confirmation popup before deleting an item', 'yith-woocommerce-affiliates' ),
							'confirm-button-type' => 'delete',
						);
					}

					$additional_actions[] = $additional_action;
				}

				if ( ! empty( $additional_actions ) ) {
					$links .= yith_plugin_fw_get_component(
						array(
							'type'   => 'action-button',
							'action' => 'show-more',
							'icon'   => 'more',
							'menu'   => $additional_actions,
						),
						false
					);
				}
			}

			return $links;
		}

		/**
		 * Returns columns available in table
		 *
		 * @return array Array of columns of the table
		 * @since 1.0.0
		 */
		public function get_columns() {
			$columns = array(
				'cb' => '<input type="checkbox" />',
				'id' => _x( 'ID', '[ADMIN] General table column', 'yith-woocommerce-affiliates' ),
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
				'id' => array( 'ID', true ),
			);

			return $sortable_columns;
		}

		/**
		 * Returns hidden columns for current table
		 *
		 * @return mixed Array of hidden columns
		 * @since 1.0.0
		 */
		public function get_hidden_columns() {
			if ( $this->visible_columns ) {
				return array_diff( array_keys( $this->get_columns() ), $this->visible_columns );
			}

			return get_hidden_columns( $this->screen );
		}

		/**
		 * Allow to set visible columns
		 *
		 * @param array $columns Columns to show.
		 */
		public function set_visible_columns( $columns ) {
			$this->visible_columns = array_intersect( $columns, array_keys( $this->get_columns() ) );
		}

		/* === ITEMS METHODS === */

		/**
		 * Whether the table has items to display or not
		 *
		 * @return bool
		 */
		public function has_items() {
			return $this->items && ( $this->items instanceof YITH_WCAF_Abstract_Objects_Collection && ! $this->items->is_empty() || count( $this->items ) );
		}

		/**
		 * Gets the number of items to display on a single page.
		 *
		 * @param string $option  Option to read to retrieve items per page.
		 * @param int    $default Default value.
		 * @return int
		 */
		protected function get_items_per_page( $option, $default = 20 ) {
			if ( $this->items_per_page ) {
				return $this->items_per_page;
			}

			return parent::get_items_per_page( $option, $default );
		}

		/**
		 * Sets number of items to show per page
		 *
		 * @param int $items_per_page Number of items per page.
		 */
		public function set_items_per_page( $items_per_page ) {
			$this->items_per_page = $items_per_page;
		}

		/* === DISPLAY METHODS === */

		/**
		 * Checks whether passed tablenav should be shown or not
		 * If no param is passed, will return true if at least one of the tablenav is shown
		 *
		 * @param string $which Tablenav position.
		 * @return bool Whether to show it or not.
		 */
		public function should_show_tablenav( $which = false ) {
			if ( ! $which ) {
				return ! empty( $this->tablenav_to_show );
			}

			return in_array( $which, $this->tablenav_to_show, true );
		}

		/**
		 * Hides tablenav for current table (before display)
		 *
		 * @param string $which Tablenav position.
		 */
		public function show_tablenav( $which = '' ) {
			if ( ! empty( $which ) ) {
				$this->tablenav_to_show[] = $which;
			} else {
				$this->tablenav_to_show = array(
					'top',
					'bottom',
				);
			}
		}

		/**
		 * Hides tablenav for current table (before display)
		 *
		 * @param string $which Tablenav position.
		 */
		public function hide_tablenav( $which = '' ) {
			if ( ! empty( $which ) ) {
				$this->tablenav_to_show = array_diff(
					$this->tablenav_to_show,
					array(
						$which,
					)
				);
			} else {
				$this->tablenav_to_show = array();
			}
		}

		/**
		 * Displays the table or empty state.
		 */
		public function display() {
			?>
			<div class="table-container  <?php echo esc_attr( implode( ' ', $this->get_container_classes() ) ); ?>">
				<?php
				if ( ! $this->has_items() && ! ( $this->should_show_tablenav() && $this->is_filtered() ) ) {
					$this->display_empty_state();
				} else {
					parent::display();
				}
				?>
			</div>
			<?php
		}

		/**
		 * Gets a list of CSS classes for the WP_List_Table table container.
		 *
		 * @since 3.1.0
		 *
		 * @return string[] Array of CSS classes for the container tag.
		 */
		protected function get_container_classes() {
			return isset( $this->_args['classes'] ) ? $this->_args['classes'] : array();
		}

		/**
		 * Gets a list of CSS classes for the WP_List_Table table tag.
		 *
		 * @since 3.1.0
		 *
		 * @return string[] Array of CSS classes for the table tag.
		 */
		protected function get_table_classes() {
			$classes = array_merge(
				parent::get_table_classes(),
				isset( $this->_args['table_classes'] ) ? $this->_args['table_classes'] : array()
			);

			// remove fixed class, because with a lot of info will be shown and it could be counterproductive.
			if ( in_array( 'fixed', $classes, true ) ) {
				$pos = array_search( 'fixed', $classes, true );

				unset( $classes[ $pos ] );
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_admin_table_classes
			 *
			 * Filters the list with the CSS clasees for the table in the backend.
			 *
			 * @param array                          $classes     List of CSS classes.
			 * @param YITH_WCAF_Abstract_Admin_Table $admin_table Admin table object.
			 */
			return apply_filters( 'yith_wcaf_admin_table_classes', $classes, $this );
		}

		/**
		 * Checks whether table has a specific class
		 *
		 * @param string $class Class to test.
		 * @return bool Whether table has test class or not.
		 */
		protected function table_has_class( $class ) {
			return in_array( $class, $this->get_table_classes(), true );
		}

		/**
		 * Generates the table navigation above or below the table
		 *
		 * @param string $which Position for current tablenav.
		 */
		protected function display_tablenav( $which ) {
			if ( ! $this->should_show_tablenav( $which ) ) {
				return;
			}

			parent::display_tablenav( $which );
		}

		/**
		 * Displays empty state for the table.
		 */
		protected function display_empty_state() {
			?>
			<p class="no-items-found">
				<i class="yith-icon yith-icon-<?php echo esc_attr( $this->_args['plural'] ); ?>"></i>
				<?php $this->display_empty_message(); ?>
			</p>
			<?php
		}

		/**
		 * Shows empty message for items in the table
		 *
		 * @return void
		 */
		protected function display_empty_message() {
			if ( empty( $this->_args['empty_message'] ) ) {
				return;
			}

			?>
			<span class="no-items-message">
				<?php echo esc_html( $this->_args['empty_message'] ); ?>
			</span>
			<?php
		}

		/* === FILTER METHODS === */

		/**
		 * Checks if current view is filtered
		 *
		 * @return bool Whether current view is filtered or not
		 */
		public function is_filtered() {
			// list of query vars that don't produce a "filtered" view.
			$ignored_query_vars = array(
				'order',
				'orderby',
				'status',
			);

			$query_vars = array_keys( $this->get_query_vars() );
			$query_vars = array_diff( $query_vars, $ignored_query_vars );

			return ! ! $query_vars;
		}

		/**
		 * Returns currently set view (empty if no view is enabled)
		 *
		 * @return string Current view, or empty if no view is set.
		 */
		public function get_current_view() {
			return $this->get_query_var( 'status' );
		}

		/**
		 * Returns available table views
		 *
		 * @return array Array with available views
		 * @since 1.0.0
		 */
		public function get_views() {
			$available_views = $this->get_available_views();
			$views           = array();

			if ( empty( $available_views ) ) {
				return $views;
			}

			$current    = $this->get_current_view();
			$query_args = $this->get_query_args();

			// retrieve status counts.
			$status_counts = $this->get_per_view_count( $query_args );

			foreach ( $available_views as $view ) {
				if ( 'all' === $view ) {
					$count = array_sum( $status_counts );
				} else {
					$count = isset( $status_counts[ $view ] ) ? $status_counts[ $view ] : 0;
				}

				if ( ! $count ) {
					continue;
				}

				$views[ $view ] = sprintf(
					'<a href="%s" class="%s">%s <span class="count">(%s)</span></a>',
					esc_url( add_query_arg( 'status', $view, YITH_WCAF_Admin()->get_tab_url() ) ),
					$current === $view ? 'current' : '',
					$this->get_view_label( $view ),
					$count
				);
			}

			return $views;
		}

		/**
		 * Returns an array of per available views for current table
		 *
		 * @return array
		 */
		public function get_available_views() {
			return array( 'all' );
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
			/**
			 * APPLY_FILTERS: yith_wcaf_$plural_table_view_label
			 *
			 * Filters the label to be used for a specific view in the table in the backend.
			 * <code>$plural</code> will be replaced with the plural form of the item in the table.
			 *
			 * @param string $view  View slug.
			 * @param int    $count Count of items in the view (to choose between singular/plural).
			 */
			return apply_filters( "yith_wcaf_{$this->_args['plural']}_table_view_label", $view, $count );
		}

		/**
		 * Returns an array of per view items count
		 *
		 * @param array $query_args Query arguments.
		 * @return array
		 */
		public function get_per_view_count( $query_args ) {
			return array();
		}

		/**
		 * Set query var
		 *
		 * @param string $var   Var to set.
		 * @param string $value Value to set.
		 */
		public function set_query_var( $var, $value ) {
			$this->maybe_init_query_vars();

			$this->query_vars[ $var ] = $value;
		}

		/**
		 * Returns value of a specific query_var, if set
		 *
		 * @param string $var Var to get.
		 * @return string|bool|int Value to retrieve; false on failure.
		 */
		public function get_query_var( $var ) {
			$query_vars = $this->get_query_vars();

			if ( ! isset( $query_vars[ $var ] ) ) {
				return false;
			}

			return $query_vars[ $var ];
		}

		/**
		 * Returns query vars currently set
		 *
		 * @return array Array of query vars.
		 */
		public function get_query_vars() {
			return $this->maybe_init_query_vars();
		}

		/**
		 * Returns query vars currently set, using real query_var as array index
		 * This method can be used to append currently existing query_vars to an url
		 *
		 * @return array Array of query vars.
		 */
		public function get_raw_query_vars() {
			$filters    = $this->filters;
			$query_vars = $this->get_query_vars();
			$raw_vars   = array();

			foreach ( $query_vars as $query_var_index => $query_var_value ) {
				if ( ! isset( $filters[ $query_var_index ] ) ) {
					continue;
				}

				$query_var = isset( $filters[ $query_var_index ]['query_var'] ) ? $filters[ $query_var_index ]['query_var'] : $query_var_index;

				$raw_vars[ $query_var ] = $query_var_value;
			}

			return $raw_vars;
		}

		/**
		 * Prepare query arguments from filter parameters
		 * Each table can override and customize this method depending on expected query arguments.
		 *
		 * @return array Array of query parameters.
		 */
		public function get_query_args() {
			$query_args = $this->get_query_vars();

			if ( isset( $query_args['from'] ) ) {
				$query_args['interval']['start_date'] = gmdate( 'Y-m-d 00:00:00', strtotime( $query_args['from'] ) );
				unset( $query_args['from'] );
			}

			if ( isset( $query_args['to'] ) ) {
				$query_args['interval']['end_date'] = gmdate( 'Y-m-d 23:59:59', strtotime( $query_args['to'] ) );
				unset( $query_args['to'] );
			}

			if ( isset( $query_args['status'] ) && 'all' === $query_args['status'] ) {
				unset( $query_args['status'] );
			}

			return $query_args;
		}

		/**
		 * Init query vars array using defined filters
		 *
		 * @return array Array of retrieved query vars.
		 */
		protected function maybe_init_query_vars() {
			if ( ! empty( $this->query_vars ) ) {
				return $this->query_vars;
			}

			if ( empty( $this->filters ) ) {
				return array();
			}

			foreach ( $this->filters as $var => $filter ) {
				$query_var = isset( $filter['query_var'] ) ? $filter['query_var'] : $var;

				if ( isset( $_REQUEST[ $query_var ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
					$value = sanitize_text_field( wp_unslash( $_REQUEST[ $query_var ] ) ); // phpcs:ignore WordPress.Security.NonceVerification
				} elseif ( isset( $filter['default'] ) ) {
					$value = $filter['default'];
				} else {
					$value = false;
				}

				if ( ! $value ) {
					continue;
				}

				if ( isset( $filter['sanitize'] ) && is_callable( $filter['sanitize'] ) ) {
					$value = call_user_func( $filter['sanitize'], $value );
				}

				if ( isset( $filter['validate'] ) && is_callable( $filter['validate'] ) && ! call_user_func( $filter['validate'], $value ) ) {
					continue;
				}

				$this->query_vars[ $var ] = $value;
			}

			return $this->query_vars;
		}

		/**
		 * Prints a select that allows filter items of the table
		 *
		 * @param array $args Array of arguments
		 * [
		 *    'name'    => '',
		 *    'classes' => '',
		 *    'data'    => array(),
		 *    'options' => array(),
		 *    'value'   => '',
		 * ].
		 * @return void
		 */
		protected function print_filter_select( $args = array() ) {
			$defaults = array(
				'name'    => '',
				'classes' => '',
				'data'    => array(),
				'options' => array(),
				'value'   => '',
			);

			$args = wp_parse_args( $args, $defaults );

			list( $name, $classes, $data, $options, $value ) = yith_plugin_fw_extract( $args, 'name', 'classes', 'data', 'options', 'value' );

			$data_attr = '';

			if ( ! empty( $data ) ) {
				foreach ( $data as $data_key => $data_value ) {
					$data_key   = esc_attr( $data_key );
					$data_value = esc_attr( $data_value );
					$data_attr .= "data-{$data_key}=\"{$data_value}\" ";
				}
			}

			?>
			<select name="<?php echo esc_attr( $name ); ?>" class="<?php echo esc_attr( $classes ); ?>" <?php echo wp_kses_post( $data_attr ); ?> >
				<?php if ( ! empty( $options ) ) : ?>
					<?php foreach ( $options as $option_key => $option_label ) : ?>
						<option value="<?php echo esc_attr( $option_label ); ?>" <?php selected( $option_label, $value ); ?> >
							<?php echo esc_html( $option_label ); ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<?php
		}

		/**
		 * Prints a select that allows filter items of the table
		 *
		 * @param array $args Array of arguments
		 * [
		 *    'type'        => '',
		 *    'name'        => '',
		 *    'classes'     => '',
		 *    'data'        => array(),
		 *    'value'       => '',
		 *    'placeholder' => '',
		 * ].
		 * @return void
		 */
		protected function print_filter_input( $args = array() ) {
			$defaults = array(
				'type'        => 'text',
				'name'        => '',
				'classes'     => '',
				'data'        => array(),
				'value'       => '',
				'placeholder' => '',
			);

			$args = wp_parse_args( $args, $defaults );

			list( $type, $name, $classes, $data, $value, $placeholder ) = yith_plugin_fw_extract( $args, 'type', 'name', 'classes', 'data', 'value', 'placeholder' );

			$data_attr = '';

			if ( ! empty( $data ) ) {
				foreach ( $data as $data_key => $data_value ) {
					$data_key   = esc_attr( $data_key );
					$data_value = esc_attr( $data_value );
					$data_attr .= "data-{$data_key}=\"{$data_value}\" ";
				}
			}

			?>
			<input
				type="<?php echo esc_attr( $type ); ?>"
				name="<?php echo esc_attr( $name ); ?>"
				class="<?php echo esc_attr( $classes ); ?>"
				value="<?php echo esc_attr( $value ); ?>"
				placeholder="<?php echo esc_attr( $placeholder ); ?>"
				<?php echo wp_kses_post( $data_attr ); ?>
			/>
			<?php
		}

		/**
		 * Prints a select that allows filter items by affiliate id.
		 *
		 * @param string $name Name for the select.
		 * @param array  $args Array of optional arguments (@see \YITH_WCAF_Abstract_Admin_Table::print_filter_select).
		 * @return void
		 */
		protected function print_affiliate_filter( $name = '_affiliate_id', $args = array() ) {
			// retrieve selected user.
			$selected_user = '';
			$query_vars    = $this->get_raw_query_vars();
			$affiliate_id  = isset( $query_vars[ $name ] ) ? $query_vars[ $name ] : false;

			if ( ! empty( $affiliate_id ) ) {
				$affiliate     = YITH_WCAF_Affiliate_Factory::get_affiliate( $affiliate_id );
				$selected_user = $affiliate ? $affiliate->get_formatted_name() : $selected_user;
			}

			$this->print_filter_select(
				array_merge_recursive(
					array(
						'value'   => $affiliate_id,
						'name'    => $name,
						'classes' => 'yith-wcaf-enhanced-select',
						'data'    => array(
							'action'      => 'yith_wcaf_get_affiliates_ids',
							'security'    => wp_create_nonce( 'search-affiliates' ),
							'placeholder' => _x( 'Select an affiliate', '[ADMIN] Affiliate filter placeholder', 'yith-woocommerce-affiliates' ),
						),
						'options' => array(
							$affiliate_id => $selected_user,
						),
					),
					$args
				)
			);
		}

		/**
		 * Prints a select that allows filter items by product id.
		 *
		 * @param string $name Name for the select.
		 * @param array  $args Array of optional arguments (@see \YITH_WCAF_Abstract_Admin_Table::print_filter_select).
		 * @return void
		 */
		protected function print_product_filter( $name = '_product_id', $args = array() ) {
			$selected_product = '';
			$query_vars       = $this->get_raw_query_vars();
			$product_id       = isset( $query_vars[ $name ] ) ? $query_vars[ $name ] : false;

			if ( ! empty( $product_id ) ) {
				$product = wc_get_product( $product_id );

				if ( $product ) {
					$selected_product = '#' . $product_id . ' &ndash; ' . $product->get_title();
				}
			}

			$this->print_filter_select(
				array_merge_recursive(
					array(
						'value'   => $product_id,
						'name'    => $name,
						'classes' => 'wc-product-search',
						'data'    => array(
							'placeholder' => _x( 'Select a product', '[ADMIN] Product filter placeholder', 'yith-woocommerce-affiliates' ),
						),
						'options' => array(
							$product_id => $selected_product,
						),
					),
					$args
				)
			);
		}

		/**
		 * Prints a field that allows filter items by date
		 *
		 * @param string $name Name for the field.
		 * @param array  $args Array of optional arguments (@see \YITH_WCAF_Abstract_Admin_Table::print_filter_input).
		 * @return void
		 */
		protected function print_datepicker( $name = '_from', $args = array() ) {
			$query_vars  = $this->get_raw_query_vars();
			$value       = isset( $query_vars[ $name ] ) ? $query_vars[ $name ] : false;
			$placeholder = '';

			// set default placeholders.
			if ( '_from' === $name ) {
				$placeholder = _x( 'From:', '[ADMIN] Tables date pickers', 'yith-woocommerce-affiliates' );
			} elseif ( '_to' === $name ) {
				$placeholder = _x( 'To:', '[ADMIN] Tables date pickers', 'yith-woocommerce-affiliates' );
			}

			$formatted_value = yith_wcaf_js_date_format( $value );

			$this->print_filter_input(
				array_merge_recursive(
					array(
						'value'       => $formatted_value['date'],
						'classes'     => 'date-picker',
						'placeholder' => $placeholder,
						'data'        => array(
							'format'    => $formatted_value['format'],
							'altField'  => '.hidden-' . trim( $name, '_' ),
							'altFormat' => 'yy-mm-dd',
						),
					),
					$args
				)
			);
			?>
				<input class="hidden-<?php echo esc_attr( trim( $name, '_' ) ); ?>" type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>"/>
				<span class="yith-icon yith-icon-calendar yith-icon--right-overlay"></span>
			<?php
		}

		/**
		 * Prints reset button that removes any filter currently applied
		 *
		 * @return void
		 */
		protected function print_filter_button() {
			submit_button(
				_x( 'Filter', '[ADMIN] Filter button label', 'yith-woocommerce-affiliates' ),
				'button',
				'filter_action',
				false,
				array(
					'id' => 'post-query-submit',
				)
			);
		}

		/**
		 * Prints Export CSV button
		 *
		 * @return void
		 */
		protected function print_export_csv_button() {
			echo sprintf(
				'<a href="%s" class="button action primary">%s</a>',
				esc_url(
					YITH_WCAF_Admin_Actions::get_action_url(
						'export_csv',
						$this->get_raw_query_vars()
					)
				),
				esc_html_x( 'Export CSV', '[ADMIN] Export CSV button on admin screens', 'yith-woocommerce-affiliates' )
			);
		}

		/**
		 * Prints reset button that removes any filter currently applied
		 *
		 * @return void
		 */
		protected function print_reset_button() {
			if ( ! $this->is_filtered() ) {
				return;
			}

			echo sprintf(
				'<a href="%s" class="button button-secondary action reset-button">%s</a>',
				esc_url( YITH_WCAF_Admin()->get_tab_url() ),
				esc_html_x( 'Reset', '[ADMIN] Reset button label', 'yith-woocommerce-affiliates' )
			);
		}

		/**
		 * Print hidden fields required tro keep selections during filtering
		 *
		 * @return void
		 */
		protected function print_hidden_fields() {
			$this->print_status_hidden();

			?>
			<input type="hidden" name="page" class="post_status_page" value="<?php echo esc_attr( YITH_WCAF_Admin()->get_panel_slug() ); ?>"/>
			<input type="hidden" name="tab" class="post_status_page" value="<?php echo esc_attr( YITH_WCAF_Admin()->get_current_raw_tab() ); ?>"/>
			<input type="hidden" name="sub_tab" class="post_status_page" value="<?php echo esc_attr( YITH_WCAF_Admin()->get_current_raw_subtab() ); ?>"/>
			<?php
		}

		/**
		 * Print hidden field that will keep view selection during filtering
		 *
		 * @return void.
		 */
		protected function print_status_hidden() {
			$current_view = $this->get_current_view();

			if ( ! $current_view ) {
				return;
			}

			?>
			<input type="hidden" name="status" class="post_status_page" value="<?php echo esc_attr( $current_view ); ?>"/>
			<?php
		}
	}
}
