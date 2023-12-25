<?php
/**
 * Commission data store
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Commission_Data_Store' ) ) {
	/**
	 * This class implements CRUD methods for Commissions
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Commission_Data_Store implements YITH_WCAF_Object_Data_Store_Interface, YITH_WCAF_Note_Data_Store_Interface {

		use YITH_WCAF_Trait_DB_Object, YITH_WCAF_Trait_DB_Note, YITH_WCAF_Trait_Cacheable;

		/**
		 * Constructor method
		 *
		 * @throws Exception When validation fails.
		 */
		public function __construct() {
			global $wpdb;

			$this->table = $wpdb->yith_commissions;

			$this->notes_table = $wpdb->yith_commission_notes;

			$this->notes_external_reference_column = 'commission_id';

			$this->cache_group = 'commissions';

			$this->columns = array(
				'order_id'     => '%d',
				'line_item_id' => '%d',
				'line_total'   => '%f',
				'affiliate_id' => '%d',
				'product_id'   => '%d',
				'product_name' => '%s',
				'rate'         => '%f',
				'amount'       => '%f',
				'refunds'      => '%f',
				'status'       => '%s',
				'created_at'   => '%s',
				'last_edit'    => '%s',
			);

			$this->orderby = array(
				'query' => array_merge(
					array_keys( $this->columns ),
					array(
						'ID',
						'user_id',
						'user_login',
						'user_email',
					)
				),
				'stats' => array(
					'count',
					'total_earnings',
					'total_refunds',
					'total_paid',
					'store_gross_total',
					'store_net_total',
					'affiliate_id',
					'time_interval',
				),
			);
		}

		/* === CRUD === */

		/**
		 * Method to create a new record of a WC_Data based object.
		 *
		 * @param YITH_WCAF_Commission $commission Data object.
		 * @throws Exception When commission cannot be created with current information.
		 */
		public function create( &$commission ) {
			global $wpdb;

			if ( ! $commission->get_order_id() || ! $commission->get_order_item_id() || ! $commission->get_affiliate_id() ) {
				throw new Exception( _x( 'Unable to create commission. Missing required params.', '[DEV] Debug message triggered when unable to create commission.', 'yith-woocommerce-affiliates' ) );
			}

			// set time fields, if necessary.
			if ( ! $commission->get_created_time() ) {
				$commission->set_created_at( time() );
			}

			if ( ! $commission->get_edited_time() ) {
				$commission->set_last_edit( time() );
			}

			$res = $this->save_object( $commission );

			if ( $res ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_commission_correctly_created
				 *
				 * Filters the id of the commission created.
				 *
				 * @param int $id Commission id.
				 */
				$id = apply_filters( 'yith_wcaf_commission_correctly_created', intval( $wpdb->insert_id ) );

				$commission->set_id( $id );
				$commission->apply_changes();

				$this->add_order_item_meta( $commission );
				$this->clear_cache( $commission );

				/**
				 * DO_ACTION: yith_wcaf_new_commission
				 *
				 * Allows to trigger some action when a new commission is created.
				 *
				 * @param int                  $commission_id Commission id.
				 * @param YITH_WCAF_Commission $commission    Commission object.
				 */
				do_action( 'yith_wcaf_new_commission', $commission->get_id(), $commission );
			}
		}

		/**
		 * Method to read a record. Creates a new WC_Data based object.
		 *
		 * @param YITH_WCAF_Commission $commission Data object.
		 * @throws Exception When commission cannot be retrieved with current information.
		 */
		public function read( &$commission ) {
			global $wpdb;

			$commission->set_defaults();

			$id = $commission->get_id();

			if ( ! $id ) {
				throw new Exception( _x( 'Invalid commission.', '[DEV] Debug message triggered when unable to find commission.', 'yith-woocommerce-affiliates' ) );
			}

			$commission_data = $id ? $this->cache_get( 'commission-' . $id ) : false;

			if ( ! $commission_data ) {
				// format query to retrieve commission.
				$query = $wpdb->prepare( "SELECT * FROM {$wpdb->yith_commissions} WHERE ID = %d", $id );

				// retrieve commission data.
				$commission_data = $wpdb->get_row( $query ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery

				if ( $commission_data ) {
					$this->cache_set( 'commission-' . $commission_data->ID, $commission_data );
				}
			}

			if ( ! $commission_data ) {
				throw new Exception( _x( 'Invalid commission.', '[DEV] Debug message triggered when unable to find commission.', 'yith-woocommerce-affiliates' ) );
			}

			$commission->set_id( (int) $commission_data->ID );

			// set commission props.
			foreach ( array_keys( $this->columns ) as $column ) {
				$commission->{"set_{$this->get_column_prop_name( $column )}"}( $commission_data->$column );
			}

			$commission->set_object_read( true );
		}

		/**
		 * Updates a record in the database.
		 *
		 * @param YITH_WCAF_Commission $commission Data object.
		 */
		public function update( &$commission ) {
			if ( ! $commission->get_id() ) {
				return;
			}

			// set updated date.
			$commission->set_last_edit( time() );

			$this->delete_order_item_meta( $commission );
			$this->update_object( $commission );

			$commission->apply_changes();

			$this->add_order_item_meta( $commission );
			$this->clear_cache( $commission );

			/**
			 * DO_ACTION: yith_wcaf_update_commission
			 *
			 * Allows to trigger some action when a commission is updated.
			 *
			 * @param int                  $commission_id Commission id.
			 * @param YITH_WCAF_Commission $commission    Commission object.
			 */
			do_action( 'yith_wcaf_update_commission', $commission->get_id(), $commission );
		}

		/**
		 * Deletes a record from the database.
		 *
		 * @param YITH_WCAF_Commission $commission Data object.
		 * @param array                $args       Contains additional arguments
		 * [
		 *     'force_delete' => bool, // not in use.
		 *     'delete_rates' => bool  // whether to delete rates stored in order item.
		 * ].
		 *
		 * @return bool result
		 */
		public function delete( &$commission, $args = array() ) {
			global $wpdb;

			$id = $commission->get_id();

			if ( ! $id ) {
				return false;
			}

			/**
			 * DO_ACTION: yith_wcaf_before_delete_commission
			 *
			 * Allows to trigger some action before deleting a commission.
			 *
			 * @param int                  $id         Commission id.
			 * @param YITH_WCAF_Commission $commission Commission object.
			 */
			do_action( 'yith_wcaf_before_delete_commission', $id, $commission );

			$this->delete_order_item_meta( $commission, isset( $args['delete_rates'] ) ? $args['delete_rates'] : false );
			$this->clear_cache( $commission );

			// delete commission.
			$res = $wpdb->delete( $wpdb->yith_commissions, array( 'ID' => $id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

			if ( $res ) {
				/**
				 * DO_ACTION: yith_wcaf_delete_commission
				 *
				 * Allows to trigger some action when a commission is deleted.
				 *
				 * @param int                  $id         Commission id.
				 * @param YITH_WCAF_Commission $commission Commission object.
				 */
				do_action( 'yith_wcaf_delete_commission', $id, $commission );

				$commission->set_id( 0 );

				$this->delete_notes( $payment );

				/**
				 * DO_ACTION: yith_wcaf_deleted_commission
				 *
				 * Allows to trigger some action after deleting a commission.
				 *
				 * @param int                  $id         Commission id.
				 * @param YITH_WCAF_Commission $commission Commission object.
				 */
				do_action( 'yith_wcaf_deleted_commission', $id, $commission );
			}

			return $res;
		}

		/* === QUERY === */

		/**
		 * Return count of commissions matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Commission_Data_Store::query).
		 * @return int Count of matching commissions.
		 */
		public function count( $args = array() ) {
			$args['fields'] = 'count';

			return (int) $this->query( $args );
		}

		/**
		 * Return commissions matching filtering criteria
		 *
		 * @param array $args Filtering criteria<br/>:
		 *              [<br/>
		 *              'ID' => false,             // commission ID (int)<br/>
		 *              'include' => array()       // array of ids to include in the final set<br/>
		 *              'exclude' => array()       // array of ids to exclude from the final set<br/>
		 *              'order_id' => false,       // commission related order id (int)<br/>
		 *              'line_item_id' => false,   // commission related line item id (int)<br/>
		 *              'user_id' => false,        // commission related affiliate user id (int)<br/>
		 *              'affiliate_id' => false,   // commission related affiliate id (int)<br/>
		 *              'status' => false,         // commission status ({@link \YITH_WCAF_Commissions::$available_statuses})<br/>
		 *              'status__not_in' => false, // commission status differs ({@link \YITH_WCAF_Commissions::$available_statuses})<br/>
		 *              'user_login' => false,     // commission related affiliate user login, or part of it (string)<br/>
		 *              'user_email' => false,     // commission related affiliate user email, or part of it (string)<br/>
		 *              'product_id' => false,     // commission related line item product id (int)<br/>
		 *              'product_name' => false,   // commission related line item product name, or part of it (string)<br/>
		 *              'rate' => false,           // commission rate range (array, with at lest one of this index: [min(float)|max(float)])<br/>
		 *              'amount' => false,         // commission amount range (array, with at lest one of this index: [min(float)|max(float)])<br/>
		 *              'interval' => false        // commission date range (array, with at lest one of this index: [start_date(string; mysql date format)|end_date(string; mysql date format)])<br/>
		 *              'orderby' => 'ID',         // sorting direction (ASC/DESC)<br/>
		 *              'order' => 'ASC',          // sorting column (any table valid column)<br/>
		 *              'limit' => 0,              // limit (int)<br/>
		 *              'offset' => 0              // offset (int)<br/>
		 *              'fields => '' ,            // fields to retrieve (count, or any valid column name, optionally prefixed by "id=>" to have result indexed by object ID)<br/>
		 *              ].
		 *
		 * @return YITH_WCAF_Commissions_Collection|string[]|int|bool Matching commissions, or commissions count
		 */
		public function query( $args = array() ) {
			global $wpdb;

			$available_statuses = array_keys( YITH_WCAF_Commissions::get_available_statuses() );

			$defaults = array(
				'ID'             => false,
				'include'        => array(),
				'exclude'        => array(),
				'order_id'       => false,
				'line_item_id'   => false,
				'user_id'        => false,
				'affiliate_id'   => false,
				'status'         => false,
				'status__not_in' => false,
				'user_login'     => false,
				'user_email'     => false,
				'product_id'     => false,
				'product_name'   => false,
				'rate'           => false,
				'amount'         => false,
				'interval'       => false,
				'orderby'        => 'ID',
				'order'          => 'DESC',
				'limit'          => 0,
				'offset'         => 0,
				'fields'         => '',
			);

			$args = wp_parse_args( $args, $defaults );

			// checks if we're performing a count query.
			$is_counting = ! empty( $args['fields'] ) && 'count' === $args['fields'];

			// retrieve data from cache, when possible.
			$cache_key = $this->get_versioned_cache_key( 'query', $args );
			$res       = $this->cache_get( $cache_key );

			// if no data found in cache, query database.
			if ( false === $res ) {
				$query      = "SELECT
						yc.*,
						u.ID AS user_id,
						u.user_login AS user_login,
						u.user_email AS user_email
					FROM {$wpdb->yith_commissions} AS yc
					LEFT JOIN {$wpdb->yith_affiliates} AS ya ON ya.ID = yc.affiliate_id
					LEFT JOIN {$wpdb->users} AS u ON u.ID = ya.user_id
					WHERE 1 = 1";
				$query_args = array();

				if ( $is_counting ) {
					$query = "SELECT COUNT(*)
						FROM {$wpdb->yith_commissions} AS yc
						LEFT JOIN {$wpdb->yith_affiliates} AS ya ON ya.ID = yc.affiliate_id
						LEFT JOIN {$wpdb->users} AS u ON u.ID = ya.user_id
						WHERE 1 = 1";
				}

				if ( ! empty( $args['ID'] ) ) {
					$query       .= ' AND yc.ID = %d';
					$query_args[] = $args['ID'];
				}

				if ( ! empty( $args['include'] ) ) {
					$args['include'] = (array) $args['include'];

					$query     .= ' AND yc.ID IN (' . trim( str_repeat( '%d, ', count( $args['include'] ) ), ', ' ) . ')';
					$query_args = array_merge(
						$query_args,
						$args['include']
					);
				}

				if ( ! empty( $args['exclude'] ) ) {
					$args['exclude'] = (array) $args['exclude'];

					$query     .= ' AND yc.ID NOT IN (' . trim( str_repeat( '%d, ', count( $args['exclude'] ) ), ', ' ) . ')';
					$query_args = array_merge(
						$query_args,
						$args['exclude']
					);
				}

				if ( ! empty( $args['order_id'] ) ) {
					$query       .= ' AND yc.order_id = %d';
					$query_args[] = $args['order_id'];
				}

				if ( ! empty( $args['line_item_id'] ) ) {
					$query       .= ' AND yc.line_item_id = %d';
					$query_args[] = $args['line_item_id'];
				}

				if ( ! empty( $args['user_id'] ) ) {
					$query       .= ' AND ya.user_id = %d';
					$query_args[] = $args['user_id'];
				}

				if ( ! empty( $args['affiliate_id'] ) ) {
					$query       .= ' AND yc.affiliate_id = %d';
					$query_args[] = $args['affiliate_id'];
				}

				if ( ! empty( $args['status'] ) ) {
					$args['status'] = array_intersect( (array) $args['status'], $available_statuses );

					$query     .= ' AND yc.status IN ( ' . trim( str_repeat( '%s, ', count( $args['status'] ) ), ', ' ) . ' )';
					$query_args = array_merge(
						$query_args,
						$args['status']
					);
				}

				if ( ! empty( $args['status__not_in'] ) ) {
					$args['status__not_in'] = array_intersect( (array) $args['status__not_in'], $available_statuses );

					$query     .= ' AND yc.status NOT IN ( ' . trim( str_repeat( '%s, ', count( $args['status__not_in'] ) ), ', ' ) . ' )';
					$query_args = array_merge(
						$query_args,
						$args['status__not_in']
					);
				}

				if ( ! empty( $args['user_login'] ) ) {
					$query       .= ' AND u.user_login LIKE %s';
					$query_args[] = '%' . $args['user_login'] . '%';
				}

				if ( ! empty( $args['user_email'] ) ) {
					$query       .= ' AND u.user_email LIKE %s';
					$query_args[] = '%' . $args['user_email'] . '%';
				}

				if ( ! empty( $args['product_id'] ) ) {
					$query       .= ' AND yc.product_id = %d';
					$query_args[] = $args['product_id'];
				}

				if ( ! empty( $args['product_name'] ) ) {
					$query       .= ' AND yc.product_name LIKE %s';
					$query_args[] = '%' . $args['product_name'] . '%';
				}

				if ( ! empty( $args['rate'] ) && is_array( $args['rate'] ) && ( isset( $args['rate']['min'] ) || isset( $args['rate']['max'] ) ) ) {
					if ( ! empty( $args['rate']['min'] ) ) {
						$query       .= ' AND yc.rate >= %f';
						$query_args[] = $args['rate']['min'];
					}

					if ( ! empty( $args['rate']['max'] ) ) {
						$query       .= ' AND yc.rate <= %f';
						$query_args[] = $args['rate']['max'];
					}
				}

				if ( ! empty( $args['amount'] ) && is_array( $args['amount'] ) && ( isset( $args['amount']['min'] ) || isset( $args['amount']['max'] ) ) ) {
					if ( ! empty( $args['amount']['min'] ) ) {
						$query       .= ' AND yc.amount >= %f';
						$query_args[] = $args['amount']['min'];
					}

					if ( ! empty( $args['amount']['max'] ) ) {
						$query       .= ' AND yc.amount <= %f';
						$query_args[] = $args['amount']['max'];
					}
				}

				if ( ! empty( $args['interval'] ) && is_array( $args['interval'] ) && ( isset( $args['interval']['start_date'] ) || isset( $args['interval']['end_date'] ) ) ) {
					if ( ! empty( $args['interval']['start_date'] ) ) {
						$query       .= ' AND yc.created_at >= %s';
						$query_args[] = $args['interval']['start_date'];
					}

					if ( ! empty( $args['interval']['end_date'] ) ) {
						$query       .= ' AND yc.created_at <= %s';
						$query_args[] = $args['interval']['end_date'];
					}
				}

				if ( empty( $args['fields'] ) || 'count' !== $args['fields'] ) {
					$query .= ' GROUP BY yc.ID';
				}

				if ( ! empty( $args['orderby'] ) && ! $is_counting ) {
					$query .= $this->generate_query_orderby_clause( $args['orderby'], $args['order'], 'query' );
				}

				if ( ! empty( $args['limit'] ) && 0 < (int) $args['limit'] && ! $is_counting ) {
					$query .= sprintf( ' LIMIT %d, %d', ! empty( $args['offset'] ) ? $args['offset'] : 0, $args['limit'] );
				}

				if ( ! empty( $query_args ) ) {
					$query = $wpdb->prepare( $query, $query_args ); // phpcs:ignore WordPress.DB
				}

				if ( $is_counting ) {
					$res = (int) $wpdb->get_var( $query ); // phpcs:ignore WordPress.DB
				} else {
					$res = $wpdb->get_results( $query, ARRAY_A ); // phpcs:ignore WordPress.DB
				}

				$this->cache_set( $cache_key, $res );
			}

			// if we're counting, return count found.
			if ( $is_counting ) {
				return $res;
			}

			// if we have an empty set from db, return empty array/collection and skip next steps.
			if ( ! $res ) {
				return empty( $args['fields'] ) ? new YITH_WCAF_Commissions_Collection() : array();
			}

			$ids = array_map( 'intval', wp_list_pluck( $res, 'ID' ) );

			if ( ! empty( $args['fields'] ) ) {
				// extract required field.
				$indexed = 0 === strpos( $args['fields'], 'id=>' );
				$field   = $indexed ? substr( $args['fields'], 4 ) : $args['fields'];
				$field   = 'ids' === $field ? 'ID' : $field;

				$res = wp_list_pluck( $res, $field );

				if ( $indexed ) {
					$res = array_combine( $ids, $res );
				}
			} else {
				// or get the complete affiliate object.
				$res = new YITH_WCAF_Commissions_Collection( $ids, $this->get_pagination_data( $args ) );
			}

			return $res;
		}

		/**
		 * Produces general stats for commissions
		 *
		 * @param array $args Array of parameters for stats generation:
		 *              [<br/>
		 *              'include' => array()       // array of ids to include in stats calculation<br/>
		 *              'exclude' => array()       // array of ids to exclude stats calculation<br/>
		 *              'order_id' => false,       // commission related order id (int)<br/>
		 *              'line_item_id' => false,   // commission related line item id (int)<br/>
		 *              'affiliate_id' => false,   // commission related affiliate id (int|int[])<br/>
		 *              'product_id' => false,     // commission related line item product id (int)<br/>
		 *              'product_name' => false,   // commission related line item product name, or part of it (string)<br/>
		 *              'interval' => false        // a single interval, as described in @see \YITH_WCAF_Commission_Data_Store::query; can only filter results<br/>
		 *              'intervals' => false       // an array of intervals, as described in @see \YITH_WCAF_Commission_Data_Store::query; can be optionally used to group query<br/>
		 *              'orderby' => 'ID',         // sorting column (any table valid column)<br/>
		 *              'order' => 'ASC',          // sorting direction (ASC/DESC)<br/>
		 *              'limit' => 0,              // limit (int)<br/>
		 *              'offset' => 0              // offset (int)<br/>
		 *              'stats => '' ,             //stats to include in the return set<br/>
		 *              'group_by => '' ,          // how to group results (affiliate_id|product_id|time_interval|<empty>)<br/>
		 *              ].
		 */
		public function get_stats( $args = array() ) {
			global $wpdb;

			$defaults = array(
				'stats'        => array(
					'count',
					'total_earnings',
					'total_refunds',
					'total_paid',
					'store_gross_total',
					'store_net_total',
				),
				'include'      => array(),
				'exclude'      => array(),
				'order_id'     => false,
				'line_item_id' => false,
				'affiliate_id' => false,
				'product_id'   => false,
				'product_name' => false,
				'interval'     => false,
				'intervals'    => false,
				'orderby'      => 'affiliate_id',
				'order'        => 'DESC',
				'limit'        => 0,
				'offset'       => 0,
				'group_by'     => '',
			);

			$args = wp_parse_args( $args, $defaults );

			// skip if no stat is requested (request error).
			if ( empty( $args['stats'] ) ) {
				return array();
			}

			// skip if grouping by intervals but no interval defined.
			if ( empty( $args['intervals'] ) && 'time_interval' === $args['group_by'] ) {
				return array();
			}

			// retrieve data from cache, when possible.
			$cache_key = $this->get_versioned_cache_key( 'stats', $args );
			$res       = $this->cache_get( $cache_key );

			if ( ! $res ) {
				// initialize query parts.
				$query_select = '';
				$query_from   = "{$wpdb->yith_commissions} AS yc";
				$query_where  = '1=1';
				$query_group  = '';
				$query_order  = '';
				$query_limit  = '';

				// initialize query args.
				$query_args = array();

				if ( ! empty( $args['stats'] ) ) {
					$request_stats = (array) $args['stats'];

					if ( in_array( 'count', $request_stats, true ) ) {
						$query_select .= ', COUNT( yc.ID ) AS count';
					}

					if ( in_array( 'total_earnings', $request_stats, true ) ) {
						$query_select .= ', SUM( yc.amount ) AS total_earnings';
					}

					if ( in_array( 'total_refunds', $request_stats, true ) ) {
						$query_select .= ', SUM( yc.refunds ) AS total_refunds';
					}

					if ( in_array( 'total_paid', $request_stats, true ) ) {
						$paid_statues  = YITH_WCAF_Commissions::get_payment_statuses();
						$query_select .= ', SUM( CASE WHEN yc.status IN ( ' . trim( str_repeat( '%s, ', count( $paid_statues ) ), ', ' ) . ' ) THEN amount ELSE 0 END ) AS total_paid';
						$query_args    = array_merge(
							$query_args,
							$paid_statues
						);
					}

					if ( in_array( 'store_gross_total', $request_stats, true ) ) {
						$query_select .= ', SUM( yc.line_total ) AS store_gross_total';
					}

					if ( in_array( 'store_net_total', $request_stats, true ) ) {
						$query_select .= ', SUM( yc.line_total - yc.amount ) AS store_net_total';
					}
				}

				if ( ! empty( $args['intervals'] ) && 'time_interval' === $args['group_by'] ) {
					$intervals      = (array) $args['intervals'];
					$intervals_case = 'CASE';

					foreach ( $intervals as $interval ) {
						if ( empty( $interval ) || ! isset( $interval['start_date'] ) || ! isset( $interval['end_date'] ) ) {
							continue;
						}

						$interval_label  = "{$interval['start_date']}-{$interval['end_date']}";
						$intervals_case .= ' WHEN yc.created_at >= %s AND yc.created_at <= %s THEN %s';

						$query_args[] = $interval['start_date'];
						$query_args[] = $interval['end_date'];
						$query_args[] = $interval_label;
					}

					$intervals_case .= ' END';

					$query_select .= ", {$intervals_case} AS time_interval";
				}

				if ( 'affiliate_id' === $args['group_by'] ) {
					$query_select .= ', yc.affiliate_id';
				}

				if ( 'product_id' === $args['group_by'] ) {
					$query_select .= ', yc.product_id, yc.product_name';
				}

				if ( ! empty( $args['include'] ) ) {
					$args['include'] = (array) $args['include'];

					$query_where .= ' AND yc.ID IN (' . trim( str_repeat( '%d, ', count( $args['include'] ) ), ', ' ) . ')';
					$query_args   = array_merge(
						$query_args,
						$args['include']
					);
				}

				if ( ! empty( $args['exclude'] ) ) {
					$args['exclude'] = (array) $args['exclude'];

					$query_where .= ' AND yc.ID NOT IN (' . trim( str_repeat( '%d, ', count( $args['exclude'] ) ), ', ' ) . ')';
					$query_args   = array_merge(
						$query_args,
						$args['exclude']
					);
				}

				if ( ! empty( $args['order_id'] ) ) {
					$query_where .= ' AND yc.order_id = %d';
					$query_args[] = $args['order_id'];
				}

				if ( ! empty( $args['line_item_id'] ) ) {
					$query_where .= ' AND yc.line_item_id = %d';
					$query_args[] = $args['line_item_id'];
				}

				if ( ! empty( $args['affiliate_id'] ) ) {
					$args['affiliate_id'] = (array) $args['affiliate_id'];

					$query_where .= ' AND yc.affiliate_id IN (' . trim( str_repeat( '%d, ', count( $args['affiliate_id'] ) ), ', ' ) . ')';
					$query_args   = array_merge(
						$query_args,
						$args['affiliate_id']
					);
				}

				if ( ! empty( $args['product_id'] ) ) {
					$query_where .= ' AND yc.product_id = %d';
					$query_args[] = $args['product_id'];
				}

				if ( ! empty( $args['product_name'] ) ) {
					$query_where .= ' AND yc.product_name LIKE %s';
					$query_args[] = '%' . $args['product_name'] . '%';
				}

				if ( ! empty( $args['interval'] ) && is_array( $args['interval'] ) && ( isset( $args['interval']['start_date'] ) || isset( $args['interval']['end_date'] ) ) ) {
					if ( ! empty( $args['interval']['start_date'] ) ) {
						$query_where .= ' AND yc.created_at >= %s';
						$query_args[] = $args['interval']['start_date'];
					}

					if ( ! empty( $args['interval']['end_date'] ) ) {
						$query_where .= ' AND yc.created_at <= %s';
						$query_args[] = $args['interval']['end_date'];
					}
				}

				if ( ! empty( $args['intervals'] ) ) {
					$intervals       = (array) $args['intervals'];
					$intervals_where = 'AND (';

					foreach ( $intervals as $interval ) {
						if ( empty( $interval ) || ! isset( $interval['start_date'] ) || ! isset( $interval['end_date'] ) ) {
							continue;
						}

						$intervals_where .= ' yc.created_at >= %s AND yc.created_at <= %s OR';

						$query_args[] = $interval['start_date'];
						$query_args[] = $interval['end_date'];
					}

					$intervals_where  = trim( $intervals_where, 'OR' );
					$intervals_where .= ')';

					$query_where .= " {$intervals_where}";
				}

				if ( ! empty( $args['orderby'] ) ) {
					$query_order .= $this->generate_query_orderby_clause( $args['orderby'], $args['order'], 'stats' );
				}

				if ( ! empty( $args['group_by'] ) && in_array( $args['group_by'], array( 'affiliate_id', 'product_id', 'time_interval' ), true ) ) {
					$query_group .= sprintf( ' GROUP BY %s', esc_sql( $args['group_by'] ) );
				}

				if ( ! empty( $args['limit'] ) && 0 < (int) $args['limit'] ) {
					$query_limit .= sprintf( ' LIMIT %d, %d', ! empty( $args['offset'] ) ? $args['offset'] : 0, $args['limit'] );
				}

				// clean components.
				$query_select = trim( $query_select, ',' );
				$query_where  = trim( $query_where, ',' );

				// compose query.
				$query = "SELECT {$query_select} FROM {$query_from} WHERE {$query_where} {$query_group} {$query_order} {$query_limit}";

				// prepare query if necessary.
				if ( ! empty( $query_args ) ) {
					$query = $wpdb->prepare( $query, $query_args ); // phpcs:ignore WordPress.DB
				}

				$res = $wpdb->get_results( $query, ARRAY_A ); // phpcs:ignore WordPress.DB

				$this->cache_set( $cache_key, $res );
			}

			if ( ! $res ) {
				return array();
			}

			switch ( $args['group_by'] ) {
				case 'affiliate_id':
				case 'product_id':
				case 'time_interval':
					$res = array_combine( wp_list_pluck( $res, $args['group_by'] ), $res );
					break;
				default:
					$res = array_shift( $res );
					break;
			}

			return $res;
		}

		/**
		 * Returns count of commissions, grouped by status
		 *
		 * @param string $status Specific status to count, or all to obtain a global statistic; if left empty, returns array of counts per status.
		 * @param array  $args   Array of arguments to filter status query<br/>
		 *               [<br/>
		 *               'user_id' => false,        // commission related affiliate user id (int)<br/>
		 *               'product_id' => false,     // commission related line item product id (int)<br/>
		 *               'interval' => false        // commission date range (array, with at lest one of this index: [start_date(string; mysql date format)|end_date(string; mysql date format)])<br/>
		 *               ].
		 *
		 * @return int|array Count per state, or array indexed by status, with status count
		 */
		public function per_status_count( $status = false, $args = array() ) {
			global $wpdb;

			$res = $this->cache_get( 'per_status_counts' );

			if ( empty( $res ) ) {
				$res = array();
			}

			if ( ! $res ) {
				$defaults = array(
					'user_id'    => 0,
					'product_id' => 0,
					'interval'   => false,
				);

				$args = wp_parse_args( $args, $defaults );

				$query      = "SELECT
						yc.status AS status,
						COUNT( yc.ID ) AS status_count
					FROM {$wpdb->yith_commissions} AS yc
					LEFT JOIN {$wpdb->yith_affiliates} AS ya ON ya.ID = yc.affiliate_id
					WHERE 1 = 1";
				$query_args = array();

				if ( ! empty( $args['product_id'] ) ) {
					$query       .= ' AND yc.product_id = %d';
					$query_args[] = $args['product_id'];
				}

				if ( ! empty( $args['user_id'] ) ) {
					$query       .= ' AND ya.user_id = %d';
					$query_args[] = $args['user_id'];
				}

				if ( ! empty( $args['interval'] ) && is_array( $args['interval'] ) && ( isset( $args['interval']['start_date'] ) || isset( $args['interval']['end_date'] ) ) ) {
					if ( ! empty( $args['interval']['start_date'] ) ) {
						$query       .= ' AND yc.created_at >= %s';
						$query_args[] = $args['interval']['start_date'];
					}

					if ( ! empty( $args['interval']['end_date'] ) ) {
						$query       .= ' AND yc.created_at <= %s';
						$query_args[] = $args['interval']['end_date'];
					}
				}

				$query .= ' GROUP BY yc.status';

				if ( ! empty( $query_args ) ) {
					$query = $wpdb->prepare( $query, $query_args ); // phpcs:ignore WordPress.DB
				}

				$counts = $wpdb->get_results( $query, ARRAY_A ); // phpcs:ignore WordPress.DB

				// format result.
				$counts   = $counts ? array_combine( wp_list_pluck( $counts, 'status' ), wp_list_pluck( $counts, 'status_count' ) ) : array();
				$statuses = YITH_WCAF_Commissions::get_available_statuses();

				foreach ( $statuses as $status_id => $status_options ) {
					$res[ $status_options['slug'] ] = isset( $counts[ $status_id ] ) ? $counts[ $status_id ] : 0;
				}

				$this->cache_set( 'per_status_counts', $res );
			}

			if ( ! $status ) {
				return $res;
			} elseif ( 'all' === $status ) {
				return array_sum( $res );
			} else {
				if ( array_key_exists( $status, $res ) ) {
					return $res[ $status ];
				} else {
					return 0;
				}
			}
		}

		/* === ORDER ITEM META === */

		/**
		 * Registers metadata for commission item.
		 *
		 * @param YITH_WCAF_Commission $commission Data object.
		 *
		 * @return bool result
		 */
		public function add_order_item_meta( &$commission ) {
			$item = $commission->get_order_item();

			if ( ! $item ) {
				return false;
			}

			$item->update_meta_data( '_yith_wcaf_commission_id', $commission->get_id() );
			$item->update_meta_data( '_yith_wcaf_commission_rate', $commission->get_rate() );
			$item->update_meta_data( '_yith_wcaf_commission_amount', $commission->get_amount() );

			return $item->save();
		}

		/**
		 * Deletes metadata for commission item.
		 *
		 * @param YITH_WCAF_Commission $commission   Data object.
		 * @param bool                 $delete_rates Whether to delete rate stored in order item.
		 *
		 * @return bool result
		 */
		public function delete_order_item_meta( &$commission, $delete_rates = false ) {
			$item = $commission->get_order_item();

			if ( ! $item ) {
				return false;
			}

			$item->delete_meta_data( '_yith_wcaf_commission_id' );
			$item->delete_meta_data( '_yith_wcaf_commission_amount' );

			$delete_rates && $item->delete_meta_data( '_yith_wcaf_commission_rate' );

			return $item->save();
		}

		/* === UTILITIES === */

		/**
		 * Clear commissions related caches
		 *
		 * @param \YITH_WCAF_Commission|int|string $commission Commission object, affiliate token, or affiliate id.
		 * @return void
		 */
		public function clear_cache( $commission ) {
			$commission = YITH_WCAF_Commission_Factory::get_commission( $commission );

			if ( ! $commission || ! $commission->get_id() ) {
				return;
			}

			$this->cache_delete( 'commission-' . $commission->get_id() );
			$this->invalidate_versioned_cache();
		}

		/**
		 * Assigns commissions that are currently registered for a specific token to an affiliate, when they don't have
		 * a valid affiliate already.
		 *
		 * @param int    $affiliate_id Affiliate id.
		 * @param string $search_token Token to search.
		 *
		 * @return void.
		 */
		public function process_orphan_commissions( $affiliate_id, $search_token ) {
			global $wpdb;

			if ( yith_plugin_fw_is_wc_custom_orders_table_usage_enabled() ) {
				$query = "SELECT im.meta_value
					FROM {$wpdb->prefix}woocommerce_order_itemmeta as im
					LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS i USING( order_item_id )
					LEFT JOIN {$wpdb->prefix}wc_orders_meta AS om ON i.order_id = om.order_id
					WHERE im.meta_key = %s AND om.meta_key = %s AND om.meta_value = %s";
			} else {
				$query = "SELECT im.meta_value
					FROM {$wpdb->prefix}woocommerce_order_itemmeta as im
					LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS i USING( order_item_id )
					LEFT JOIN {$wpdb->postmeta} AS pm ON i.order_id = pm.post_id
					WHERE im.meta_key = %s AND pm.meta_key = %s AND pm.meta_value = %s";
			}

			$query_args = array(
				'_yith_wcaf_commission_id',
				'_yith_wcaf_referral',
				$search_token,
			);

			$orphan_commissions = $wpdb->get_col( $wpdb->prepare( $query, $query_args ) ); // phpcs:ignore WordPress.DB

			if ( ! empty( $orphan_commissions ) ) {
				$commissions = new YITH_WCAF_Commissions_Collection( $orphan_commissions );

				foreach ( $commissions as $commission ) {
					$affiliate = $commission->get_affiliate();

					if ( ! empty( $affiliate ) ) {
						continue;
					}

					$commission->set_affiliate_id( $affiliate_id );
					$commission->save();
				}
			}
		}
	}
}
