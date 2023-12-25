<?php
/**
 * Click data store
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Click_Data_Store' ) ) {
	/**
	 * This class implements CRUD methods for Clicks
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Click_Data_Store implements YITH_WCAF_Object_Data_Store_Interface {

		use YITH_WCAF_Trait_DB_Object, YITH_WCAF_Trait_Cacheable;

		/**
		 * Constructor method
		 */
		public function __construct() {
			global $wpdb;

			$this->table = $wpdb->yith_clicks;

			$this->cache_group = 'clicks';

			$this->columns = array(
				'affiliate_id' => '%d',
				'link'         => '%s',
				'origin'       => '%s',
				'origin_base'  => '%s',
				'IP'           => '%s',
				'click_date'   => '%s',
				'order_id'     => '%d',
				'conv_date'    => '%s',
				'conv_time'    => '%d',
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
					'count_converted',
					'conversion_rate',
					'avg_conversion_time',
					'affiliate_id',
					'time_interval',
				),
			);

			$this->nullable = array(
				'origin',
				'origin_base',
				'order_id',
				'conv_date',
				'conv_time',
			);

			$this->props_to_columns = array(
				'date'            => 'click_date',
				'conversion_date' => 'conv_date',
				'conversion_time' => 'conv_time',
			);
		}

		/* === CRUD === */

		/**
		 * Method to create a new record of a WC_Data based object.
		 *
		 * @param YITH_WCAF_Click $click Data object.
		 * @throws Exception When click cannot be created with current information.
		 */
		public function create( &$click ) {
			global $wpdb;

			if ( ! $click->get_link() ) {
				throw new Exception( _x( 'Unable to register visit. Missing required params.', '[DEV] Debug message triggered when unable to create click record.', 'yith-woocommerce-affiliates' ) );
			}

			// set time fields, if necessary.
			if ( ! $click->get_date() ) {
				$click->set_date( time() );
			}

			$res = $this->save_object( $click );

			if ( $res ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_click_correctly_created
				 *
				 * Filters the id of the click created.
				 *
				 * @param int $id Click id.
				 */
				$id = apply_filters( 'yith_wcaf_click_correctly_created', intval( $wpdb->insert_id ) );

				$click->set_id( $id );
				$click->apply_changes();

				$this->clear_cache( $click );

				/**
				 * DO_ACTION: yith_wcaf_new_click
				 *
				 * Allows to trigger some action when a new click is created.
				 *
				 * @param int             $click_id Click id.
				 * @param YITH_WCAF_Click $click    Click object.
				 */
				do_action( 'yith_wcaf_new_click', $click->get_id(), $click );
			}
		}

		/**
		 * Method to read a record. Creates a new WC_Data based object.
		 *
		 * @param YITH_WCAF_Click $click Data object.
		 * @throws Exception When click cannot be retrieved with current information.
		 */
		public function read( &$click ) {
			global $wpdb;

			$click->set_defaults();

			$id = $click->get_id();

			if ( ! $id ) {
				throw new Exception( _x( 'Invalid visit.', '[DEV] Debug message triggered when unable to find click record.', 'yith-woocommerce-affiliates' ) );
			}

			$click_data = $id ? $this->cache_get( 'click-' . $id ) : false;

			if ( ! $click_data ) {
				// format query to retrieve click.
				$query = $wpdb->prepare( "SELECT * FROM {$wpdb->yith_clicks} WHERE ID = %d", $id );

				// retrieve click data.
				$click_data = $wpdb->get_row( $query ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery

				if ( $click_data ) {
					$this->cache_set( 'click-' . $click_data->ID, $click_data );
				}
			}

			if ( ! $click_data ) {
				throw new Exception( _x( 'Invalid click.', '[DEV] Debug message triggered when unable to find click record.', 'yith-woocommerce-affiliates' ) );
			}

			$click->set_id( (int) $click_data->ID );

			// set affiliate props.
			foreach ( array_keys( $this->columns ) as $column ) {
				$click->{"set_{$this->get_column_prop_name( $column )}"}( $click_data->$column );
			}

			$click->set_object_read( true );
		}

		/**
		 * Updates a record in the database.
		 *
		 * @param YITH_WCAF_Click $click Data object.
		 */
		public function update( &$click ) {
			if ( ! $click->get_id() ) {
				return;
			}

			$this->update_object( $click );

			$click->apply_changes();

			$this->clear_cache( $click );

			/**
			 * DO_ACTION: yith_wcaf_update_click
			 *
			 * Allows to trigger some action when a click is updated.
			 *
			 * @param int             $click_id Click id.
			 * @param YITH_WCAF_Click $click    Click object.
			 */
			do_action( 'yith_wcaf_update_click', $click->get_id(), $click );
		}

		/**
		 * Deletes a record from the database.
		 *
		 * @param YITH_WCAF_Click $click Data object.
		 * @param array           $args      Not in use.
		 *
		 * @return bool result
		 */
		public function delete( &$click, $args = array() ) {
			global $wpdb;

			$id = $click->get_id();

			if ( ! $id ) {
				return false;
			}

			/**
			 * DO_ACTION: yith_wcaf_before_delete_click
			 *
			 * Allows to trigger some action before deleting a click.
			 *
			 * @param int             $id    Click id.
			 * @param YITH_WCAF_Click $click Click object.
			 */
			do_action( 'yith_wcaf_before_delete_click', $id, $click );

			$this->clear_cache( $click );

			// delete affiliate.
			$res = $wpdb->delete( $wpdb->yith_clicks, array( 'ID' => $id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

			if ( $res ) {
				/**
				 * DO_ACTION: yith_wcaf_delete_click
				 *
				 * Allows to trigger some action when a click is deleted.
				 *
				 * @param int             $id    Click id.
				 * @param YITH_WCAF_Click $click Click object.
				 */
				do_action( 'yith_wcaf_delete_click', $id, $click );

				$click->set_id( 0 );

				/**
				 * DO_ACTION: yith_wcaf_deleted_click
				 *
				 * Allows to trigger some action after deleting a click.
				 *
				 * @param int             $id    Click id.
				 * @param YITH_WCAF_Click $click Click object.
				 */
				do_action( 'yith_wcaf_deleted_click', $id, $click );
			}

			return $res;
		}

		/* === QUERY === */

		/**
		 * Return count of clicks matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Click_Data_Store::query).
		 * @return int Count of matching clicks.
		 */
		public function count( $args = array() ) {
			$args['fields'] = 'count';

			return (int) $this->query( $args );
		}

		/**
		 * Return clicks matching filtering criteria
		 *
		 * @param array $args Filtering criteria<br/>:
		 *              [<br/>
		 *              'ID' => false,                   // Click ID (int)<br/>
		 *              'include' => array()             // array of ids to include in the final set<br/>
		 *              'exclude' => array()             // array of ids to exclude from the final set<br/>
		 *              'user_id' => false,              // click related user id (int)<br/>
		 *              'affiliate_id' => false,         // click affiliate id (int)<br/>
		 *              'referrer_login' => false,       // click related user login, or part of it (string)<br/>
		 *              'link' => false,                 // click visited link, or part of it (string)<br/>
		 *              'origin' => false,               // click origin link, or part of it (string)<br/>
		 *              'origin_base' => false,          // click origin link base, or part of it (string)<br/>
		 *              'ip' => false,                   // click user IP, or part of it (string)<br/>
		 *              'interval' => false,             // click date range (array, with at lest one of this index: [start_date(string; mysql date format)|end_date(string; mysql date format)])<br/>
		 *              'converted' => false,            // whether click converted or not (yes/no)<br/>
		 *              'order_id' => false,             // click related order id (int)<br/>
		 *              'order' => 'DESC',               // sorting direction (ASC/DESC)<br/>
		 *              'orderby' => 'ID',               // sorting column (any table valid column)<br/>
		 *              'limit' => 0,                    // limit (int)<br/>
		 *              'offset' => 0                    // offset (int)<br/>
		 *              ].
		 *
		 * @return YITH_WCAF_Clicks_Collection|string[]|int|bool Matching clicks, or clicks count
		 */
		public function query( $args = array() ) {
			global $wpdb;

			// checks if we're performing a count query.
			$is_counting = ! empty( $args['fields'] ) && 'count' === $args['fields'];

			// retrieve data from cache, when possible.
			$cache_key = $this->get_versioned_cache_key( 'query', $args );
			$res       = $this->cache_get( $cache_key );

			// if no data found in cache, query database.
			if ( false === $res ) {
				$query = "SELECT
							yc.*,
							ya.user_id AS user_id,
							u.user_login AS user_login,
							u.user_email AS user_email
						   FROM {$wpdb->yith_clicks} AS yc
						   LEFT JOIN {$wpdb->yith_affiliates} AS ya ON ya.ID = yc.affiliate_id
						   LEFT JOIN {$wpdb->users} AS u ON u.ID = ya.user_id
						   WHERE 1 = 1";

				if ( $is_counting ) {
					$query = "SELECT COUNT(*)
						FROM {$wpdb->yith_clicks} AS yc
						LEFT JOIN {$wpdb->yith_affiliates} AS ya ON ya.ID = yc.affiliate_id
						LEFT JOIN {$wpdb->users} AS u ON u.ID = ya.user_id
						WHERE 1 = 1";
				}

				$where_components = $this->build_where_condition( $args );

				$query     .= $where_components['where'];
				$query_args = $where_components['query_args'];

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
				return empty( $args['fields'] ) ? new YITH_WCAF_Clicks_Collection() : array();
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
				// or get the complete click object.
				$res = new YITH_WCAF_Clicks_Collection( $ids, $this->get_pagination_data( $args ) );
			}

			return $res;
		}

		/**
		 * Produces general stats for commissions
		 *
		 * @param array $args Array of parameters for stats generation:
		 *              [<br/>
		 *              'affiliate_id' => false,   // commission related affiliate id (int|int[])<br/>
		 *              'link' => false,           // click visited link, or part of it (string)<br/>
		 *              'origin' => false,         // click origin link, or part of it (string)<br/>
		 *              'origin_base' => false,    // click origin link base, or part of it (string)<br/>
		 *              'interval' => false        // a single interval, as described in @see \YITH_WCAF_Click_Data_Store::query; can only filter results<br/>
		 *              'intervals' => false       // an array of intervals, as described in @see \YITH_WCAF_Click_Data_Store::query; can be optionally used to group query<br/>
		 *              'orderby' => 'ID',         // sorting column (any table valid column)<br/>
		 *              'order' => 'ASC',          // sorting direction (ASC/DESC)<br/>
		 *              'limit' => 0,              // limit (int)<br/>
		 *              'offset' => 0              // offset (int)<br/>
		 *              'stats => '' ,             // stats to include in the return set<br/>
		 *              'group_by => '' ,          // how to group results (affiliate_id|time_interval|<empty>)<br/>
		 *              ].
		 */
		public function get_stats( $args = array() ) {
			global $wpdb;

			$defaults = array(
				'stats'        => array(
					'count',
					'count_converted',
					'conversion_rate',
					'avg_conversion_time',
				),
				'affiliate_id' => false,
				'link'         => false,
				'origin'       => false,
				'origin_base'  => false,
				'interval'     => false,
				'intervals'    => false,
				'orderby'      => 'ID',
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
				$query_from   = "{$wpdb->yith_clicks} AS yc";
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

					if ( in_array( 'count_converted', $request_stats, true ) ) {
						$query_select .= ', SUM( CASE WHEN yc.order_id IS NOT NULL THEN 1 ELSE 0 END ) AS count_converted';
					}

					if ( in_array( 'conversion_rate', $request_stats, true ) ) {
						$query_select .= ', SUM( CASE WHEN yc.order_id IS NOT NULL THEN 1 ELSE 0 END ) /  COUNT( ID ) * 100 AS conversion_rate';
					}

					if ( in_array( 'avg_conversion_time', $request_stats, true ) ) {
						$query_select .= ', AVG( yc.conv_time ) as avg_conversion_time';
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
						$intervals_case .= ' WHEN yc.click_date >= %s AND yc.click_date <= %s THEN %s';

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

				if ( ! empty( $args['affiliate_id'] ) ) {
					$args['affiliate_id'] = (array) $args['affiliate_id'];

					$query_where .= ' AND yc.affiliate_id IN (' . trim( str_repeat( '%d, ', count( $args['affiliate_id'] ) ), ', ' ) . ')';
					$query_args   = array_merge(
						$query_args,
						$args['affiliate_id']
					);
				}

				if ( ! empty( $args['link'] ) ) {
					$query_where .= ' AND yc.link LIKE %s';
					$query_args[] = '%' . $args['link'] . '%';
				}

				if ( ! empty( $args['origin'] ) ) {
					$query_where .= ' AND yc.origin LIKE %s';
					$query_args[] = '%' . $args['origin'] . '%';
				}

				if ( ! empty( $args['origin_base'] ) ) {
					$query_where .= ' AND yc.origin_base LIKE %s';
					$query_args[] = '%' . $args['origin_base'] . '%';
				}

				if ( ! empty( $args['interval'] ) && is_array( $args['interval'] ) && ( isset( $args['interval']['start_date'] ) || isset( $args['interval']['end_date'] ) ) ) {
					if ( ! empty( $args['interval']['start_date'] ) ) {
						$query_where .= ' AND yc.click_date >= %s';
						$query_args[] = $args['interval']['start_date'];
					}

					if ( ! empty( $args['interval']['end_date'] ) ) {
						$query_where .= ' AND yc.click_date <= %s';
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

						$intervals_where .= ' yc.click_date >= %s AND yc.click_date <= %s OR';

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

				if ( ! empty( $args['group_by'] ) && in_array( $args['group_by'], array( 'affiliate_id', 'time_interval' ), true ) ) {
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
		 * Delete all clicks matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Click_Data_Store::query).
		 *
		 * @return int Number of deleted rows.
		 */
		public function delete_all( $args = array() ) {
			global $wpdb;

			$query = "DELETE FROM {$wpdb->yith_clicks} WHERE 1=1";

			$where_components = $this->build_where_condition( $args );

			$query    .= $where_components['where'];
			$query_arg = $where_components['query_args'];

			if ( ! empty( $query_arg ) ) {
				$query = $wpdb->prepare( $query, $query_arg ); // phpcs:ignore WordPress.DB
			}

			return $wpdb->query( $query ); // phpcs:ignore WordPress.DB
		}

		/**
		 * Returns count of affiliate, grouped by status
		 *
		 * @param string $status Specific status to count, or all to obtain a global statistic; if left empty, returns array of counts per status.
		 * @param array  $args   Array of arguments to filter status query<br/>
		 *                [<br/>
		 *                'user_id' => false   // search string (string)<br/>
		 *                'interval' => false, // click date range (array, with at lest one of this index: [start_date(string; mysql date format)|end_date(string; mysql date format)])<br/>
		 *                ].
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
					'user_id'  => 0,
					'interval' => false,
				);

				$args = wp_parse_args( $args, $defaults );

				$query_args = array();
				$query      = "SELECT IF (yc.order_id IS NULL, 'not-converted', 'converted' ) AS status,
						COUNT( yc.ID ) AS status_count 
					FROM {$wpdb->yith_clicks} AS yc 
					LEFT JOIN {$wpdb->yith_affiliates} AS ya ON ya.ID = yc.affiliate_id
					WHERE 1 = 1";

				if ( ! empty( $args['user_id'] ) ) {
					$query       .= ' AND ya.user_id = %d';
					$query_args[] = $args['user_id'];
				}

				if ( ! empty( $args['interval'] ) && is_array( $args['interval'] ) && ( isset( $args['interval']['start_date'] ) || isset( $args['interval']['end_date'] ) ) ) {
					if ( ! empty( $args['interval']['start_date'] ) ) {
						$query       .= ' AND yc.click_date >= %s';
						$query_args[] = $args['interval']['start_date'];
					}

					if ( ! empty( $args['interval']['end_date'] ) ) {
						$query       .= ' AND yc.click_date <= %s';
						$query_args[] = $args['interval']['end_date'];
					}
				}

				$query .= ' GROUP BY status';

				if ( ! empty( $query_args ) ) {
					$query = $wpdb->prepare( $query, $query_args ); // phpcs:ignore WordPress.DB
				}

				$counts = $wpdb->get_results( $query, ARRAY_A ); // phpcs:ignore WordPress.DB

				// format result.
				$statuses = YITH_WCAF_Clicks::get_available_statuses();
				$counts   = $counts ? array_combine( wp_list_pluck( $counts, 'status' ), wp_list_pluck( $counts, 'status_count' ) ) : array();

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

		/**
		 * Creates where clause for queries
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Click_Data_Store::query).
		 *
		 * @return array Array describing where condition:
		 * [
		 *     'where' => '',          // where condition
		 *     'query_args' => array() // array of arguments to prepare this part of the query
		 * ].
		 */
		protected function build_where_condition( $args = array() ) {
			$where      = '';
			$query_args = array();

			$defaults = array(
				'ID'             => false,
				'include'        => array(),
				'exclude'        => array(),
				'user_id'        => false,
				'affiliate_id'   => false,
				'referrer_login' => false,
				'referrer_email' => false,
				'link'           => false,
				'origin'         => false,
				'origin_base'    => false,
				'ip'             => false,
				'interval'       => false,
				'converted'      => false,
				'order_id'       => false,
			);

			$args = wp_parse_args( $args, $defaults );

			if ( ! empty( $args['ID'] ) ) {
				$where       .= ' AND yc.ID = %d';
				$query_args[] = $args['ID'];
			}

			if ( ! empty( $args['include'] ) ) {
				$args['include'] = (array) $args['include'];

				$where     .= ' AND yc.ID IN (' . trim( str_repeat( '%d, ', count( $args['include'] ) ), ', ' ) . ')';
				$query_args = array_merge(
					$query_args,
					$args['include']
				);
			}

			if ( ! empty( $args['exclude'] ) ) {
				$args['exclude'] = (array) $args['exclude'];

				$where     .= ' AND yc.ID NOT IN (' . trim( str_repeat( '%d, ', count( $args['exclude'] ) ), ', ' ) . ')';
				$query_args = array_merge(
					$query_args,
					$args['exclude']
				);
			}

			if ( ! empty( $args['affiliate_id'] ) ) {
				$where       .= ' AND yc.affiliate_id = %d';
				$query_args[] = $args['affiliate_id'];
			}

			if ( ! empty( $args['user_id'] ) ) {
				$where       .= ' AND ya.user_id = %d';
				$query_args[] = $args['user_id'];
			}

			if ( ! empty( $args['referrer_login'] ) ) {
				$where       .= ' AND u.user_login LIKE %s';
				$query_args[] = '%' . $args['referrer_login'] . '%';
			}

			if ( ! empty( $args['referrer_email'] ) ) {
				$where       .= ' AND u.user_email LIKE %s';
				$query_args[] = '%' . $args['referrer_email'] . '%';
			}

			if ( ! empty( $args['link'] ) ) {
				$where       .= ' AND yc.link LIKE %s';
				$query_args[] = '%' . $args['link'] . '%';
			}

			if ( ! empty( $args['origin'] ) ) {
				$where       .= ' AND yc.origin LIKE %s';
				$query_args[] = '%' . $args['origin'] . '%';
			}

			if ( ! empty( $args['origin_base'] ) ) {
				$where       .= ' AND yc.origin_base LIKE %s';
				$query_args[] = '%' . $args['origin_base'] . '%';
			}

			if ( ! empty( $args['ip'] ) ) {
				$where       .= ' AND yc.IP LIKE %s';
				$query_args[] = '%' . $args['ip'] . '%';
			}

			if ( ! empty( $args['interval'] ) && is_array( $args['interval'] ) && ( isset( $args['interval']['start_date'] ) || isset( $args['interval']['end_date'] ) ) ) {
				if ( ! empty( $args['interval']['start_date'] ) ) {
					$where       .= ' AND yc.click_date >= %s';
					$query_args[] = $args['interval']['start_date'];
				}

				if ( ! empty( $args['interval']['end_date'] ) ) {
					$where       .= ' AND yc.click_date <= %s';
					$query_args[] = $args['interval']['end_date'];
				}
			}

			if ( ! empty( $args['converted'] ) && 'yes' === $args['converted'] ) {
				$where .= ' AND order_id IS NOT NULL';
			} elseif ( ! empty( $args['converted'] ) && 'no' === $args['converted'] ) {
				$where .= ' AND order_id IS NULL';
			}

			if ( ! empty( $args['order_id'] ) ) {
				$where       .= ' AND yc.order_id = %d';
				$query_args[] = $args['order_id'];
			}

			return compact( 'where', 'query_args' );
		}

		/* === UTILITIES === */

		/**
		 * Clear click related caches
		 *
		 * @param \YITH_WCAF_Click|int $click Click object or click id.
		 * @return void
		 */
		public function clear_cache( $click ) {
			$click = YITH_WCAF_Click_Factory::get_click( $click );

			if ( ! $click || ! $click->get_id() ) {
				return;
			}

			$this->cache_delete( 'click-' . $click->get_id() );
			$this->invalidate_versioned_cache();
		}
	}
}
