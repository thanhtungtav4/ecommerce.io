<?php
/**
 * Payment data store
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Payment_Data_Store' ) ) {
	/**
	 * This class implements CRUD methods for Commissions
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Payment_Data_Store implements YITH_WCAF_Object_Data_Store_Interface, YITH_WCAF_Note_Data_Store_Interface {

		use YITH_WCAF_Trait_DB_Object, YITH_WCAF_Trait_DB_Note, YITH_WCAF_Trait_Cacheable;

		/**
		 * Constructor method
		 *
		 * @throws Exception When validation fails.
		 */
		public function __construct() {
			global $wpdb;

			$this->table = $wpdb->yith_payments;

			$this->notes_table = $wpdb->yith_payment_notes;

			$this->notes_external_reference_column = 'payment_id';

			$this->cache_group = 'payments';

			$this->columns = array(
				'affiliate_id'    => '%d',
				'payment_email'   => '%s',
				'gateway'         => '%s',
				'status'          => '%s',
				'amount'          => '%f',
				'created_at'      => '%s',
				'completed_at'    => '%s',
				'transaction_key' => '%s',
				'gateway_details' => '%s',
			);

			$this->orderby = array_merge(
				array_keys( $this->columns ),
				array(
					'ID',
					'affiliate_token',
					'affiliate_earnings',
					'affiliate_paid',
					'affiliate_refunds',
					'user_id',
					'user_login',
					'user_email',
				)
			);

			$this->nullable = array(
				'completed_at',
				'transaction_key',
				'gateway_details',
			);

			$this->props_to_columns = array(
				'email'      => 'payment_email',
				'gateway_id' => 'gateway',
			);
		}

		/* === CRUD === */

		/**
		 * Method to create a new record of a WC_Data based object.
		 *
		 * @param YITH_WCAF_Payment $payment Data object.
		 * @throws Exception When payment cannot be created with current information.
		 */
		public function create( &$payment ) {
			global $wpdb;

			if ( ! $payment->get_affiliate_id() || ! $payment->get_amount() ) {
				throw new Exception( _x( 'Unable to create payment. Missing required params.', '[DEV] Debug message triggered when unable to create payment.', 'yith-woocommerce-affiliates' ) );
			}

			// set time fields, if necessary.
			if ( ! $payment->get_created_time() ) {
				$payment->set_created_at( time() );
			}

			$res = $this->save_object( $payment );

			if ( $res ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_payment_correctly_created
				 *
				 * Filters the id of the payment created.
				 *
				 * @param int $id Payment id.
				 */
				$id = apply_filters( 'yith_wcaf_payment_correctly_created', intval( $wpdb->insert_id ) );

				$payment->set_id( $id );
				$payment->apply_changes();
				$payment->save_commissions();

				$this->clear_cache( $payment );

				/**
				 * DO_ACTION: yith_wcaf_new_payment
				 *
				 * Allows to trigger some action when a new payment is created.
				 *
				 * @param int               $payment_id Payment id.
				 * @param YITH_WCAF_Payment $payment    Payment object.
				 */
				do_action( 'yith_wcaf_new_payment', $payment->get_id(), $payment );
			}
		}

		/**
		 * Method to read a record. Creates a new WC_Data based object.
		 *
		 * @param YITH_WCAF_Payment $payment Data object.
		 * @throws Exception When payment cannot be retrieved with current information.
		 */
		public function read( &$payment ) {
			global $wpdb;

			$payment->set_defaults();

			$id = $payment->get_id();

			if ( ! $id ) {
				throw new Exception( _x( 'Invalid payment.', '[DEV] Debug message triggered when unable to find payment.', 'yith-woocommerce-affiliates' ) );
			}

			$payment_data = $id ? $this->cache_get( 'payment-' . $id ) : false;

			if ( ! $payment_data ) {
				// format query to retrieve payment.
				$query = $wpdb->prepare( "SELECT * FROM {$wpdb->yith_payments} WHERE ID = %d", $id );

				// retrieve commission data.
				$payment_data = $wpdb->get_row( $query ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery

				if ( $payment_data ) {
					$this->cache_set( 'payment-' . $payment_data->ID, $payment_data );
				}
			}

			if ( ! $payment_data ) {
				throw new Exception( _x( 'Invalid payment.', '[DEV] Debug message triggered when unable to find payment.', 'yith-woocommerce-affiliates' ) );
			}

			$payment->set_id( (int) $payment_data->ID );

			// set payment props.
			foreach ( array_keys( $this->columns ) as $column ) {
				$value = $payment_data->$column;

				if ( 'gateway_details' === $column ) {
					$value = maybe_unserialize( $value );
				}

				$payment->{"set_{$this->get_column_prop_name( $column )}"}( $value );
			}

			$payment->set_object_read( true );
		}

		/**
		 * Updates a record in the database.
		 *
		 * @param YITH_WCAF_Payment $payment Data object.
		 */
		public function update( &$payment ) {
			if ( ! $payment->get_id() ) {
				return;
			}

			$this->update_object( $payment );

			$payment->apply_changes();
			$payment->save_commissions();

			$this->clear_cache( $payment );

			/**
			 * DO_ACTION: yith_wcaf_update_payment
			 *
			 * Allows to trigger some action when a payment is updated.
			 *
			 * @param int               $payment_id Payment id.
			 * @param YITH_WCAF_Payment $payment    Payment object.
			 */
			do_action( 'yith_wcaf_update_payment', $payment->get_id(), $payment );
		}

		/**
		 * Deletes a record from the database.
		 *
		 * @param YITH_WCAF_Payment $payment Data object.
		 * @param array             $args    Not in use.
		 *
		 * @return bool result
		 */
		public function delete( &$payment, $args = array() ) {
			global $wpdb;

			$id = $payment->get_id();

			if ( ! $id ) {
				return false;
			}

			/**
			 * DO_ACTION: yith_wcaf_before_delete_payment
			 *
			 * Allows to trigger some action before deleting a payment.
			 *
			 * @param int               $id      Payment id.
			 * @param YITH_WCAF_Payment $payment Payment object.
			 */
			do_action( 'yith_wcaf_before_delete_payment', $id, $payment );

			$this->clear_cache( $payment );

			// delete payment.
			$res = $wpdb->delete( $wpdb->yith_payments, array( 'ID' => $id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

			if ( $res ) {
				/**
				 * DO_ACTION: yith_wcaf_delete_payment
				 *
				 * Allows to trigger some action when a payment is deleted.
				 *
				 * @param int               $id      Payment id.
				 * @param YITH_WCAF_Payment $payment Payment object.
				 */
				do_action( 'yith_wcaf_delete_payment', $id, $payment );

				$payment->delete_commissions();
				$payment->save_commissions();
				$payment->set_id( 0 );

				$this->delete_notes( $payment );

				/**
				 * DO_ACTION: yith_wcaf_deleted_payment
				 *
				 * Allows to trigger some action after deleting a payment.
				 *
				 * @param int               $id      Payment id.
				 * @param YITH_WCAF_Payment $payment Payment object.
				 */
				do_action( 'yith_wcaf_deleted_payment', $id, $payment );
			}

			return $res;
		}

		/**
		 * Returns value for a specific object prop
		 *
		 * @param YITH_WCAF_Payment $object Data object.
		 * @param string            $prop   Prop to retrieve.
		 *
		 * @return mixed Value of the prop retrieved from the object
		 */
		protected function get_prop_value( $object, $prop ) {
			$method = "get_$prop";

			if ( ! method_exists( $object, $method ) ) {
				return false;
			}

			if ( 'gateway_details' === $prop ) {
				return maybe_serialize( $object->get_gateway_details() );
			}

			return $object->$method();
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
		 * Return payments matching filtering criteria
		 *
		 * @param array $args Filtering criteria<br/>:
		 *              [<br/>
		 *              'ID' => false,                   // Payment ID (int)<br/>
		 *              'include' => array()             // array of ids to include in the final set<br/>
		 *              'exclude' => array()             // array of ids to exclude from the final set<br/>
		 *              'user_id' => false,              // Affiliate user ID (int)<br/>
		 *              'affiliate_id' => false,         // Affiliate ID (int)<br/>
		 *              'commissions' => false,          // One or more of the commissions associated to the payments (int|array)<br/>
		 *              'user_login' => false,           // Affiliate user login, or part of it (string)<br/>
		 *              'user_email' => false,           // Affiliate user email, or part of it (string)<br/>
		 *              'payment_email' => false,        // Payment email, or part of it - the one registered within the payment record (string)<br/>
		 *              'status' => false,               // Payment status (string/array of strings; on-hold/pending/completed/cancelled)<br/>
		 *              'amount' => false,               // Payment amount (double)<br/>
		 *              'interval' => false,             // Payment creation date range (array, with at lest one of this index: [start_date(string; mysql date format)|end_date(string; mysql date format)])<br/><br/>
		 *              'completed_between' => false,    // Payment completion  date range (array, with at lest one of this index: [start_date(string; mysql date format)|end_date(string; mysql date format)])<br/><br/>
		 *              'transaction_key' => false,      // Payment transaction key, or part of it (string)<br/>
		 *              's' => false                     // Search string; will search between user_login, user_email, payment_email, transaction_key<br/>
		 *              'orderby' => 'ID',               // sorting direction (ASC/DESC)<br/>
		 *              'order' => 'ASC',                // sorting column (any table valid column)<br/>
		 *              'limit' => 0,                    // limit (int)<br/>
		 *              'offset' => 0                    // offset (int)<br/>
		 *              'fields => '' ,                  // fields to retrieve (count, or any valid column name, optionally prefixed by "id=>" to have result indexed by object ID)<br/>
		 *              ].
		 *
		 * @return YITH_WCAF_Payments_Collection|string[]|int|bool Matching payments, or payments count
		 */
		public function query( $args = array() ) {
			global $wpdb;

			$available_statuses = array_keys( YITH_WCAF_Payments::get_available_statuses() );

			$defaults = array(
				'ID'                => false,
				'include'           => array(),
				'exclude'           => array(),
				'user_id'           => false,
				'affiliate_id'      => false,
				'commissions'       => false,
				'user_login'        => false,
				'user_email'        => false,
				'payment_email'     => false,
				'status'            => false,
				'amount'            => false,
				'interval'          => false,
				'completed_between' => false,
				'transaction_key'   => false,
				's'                 => false,
				'orderby'           => 'ID',
				'order'             => 'DESC',
				'limit'             => 0,
				'offset'            => 0,
				'fields'            => '',
			);

			$args = wp_parse_args( $args, $defaults );

			// checks if we're performing a count query.
			$is_counting = ! empty( $args['fields'] ) && 'count' === $args['fields'];

			// retrieve data from cache, when possible.
			$res = $this->cache_get( $this->get_versioned_cache_key( 'query', $args ) );

			// if no data found in cache, query database.
			if ( false === $res ) {
				$query      = "SELECT
						yp.*,
						ya.token AS affiliate_token,
						ya.earnings AS affiliate_earnings,
						ya.paid AS affiliate_paid,
						ya.refunds AS affiliate_refunds,
						u.ID AS user_id,
						u.user_login AS user_login,
						u.user_email AS user_email
					FROM {$wpdb->yith_payments} AS yp
					LEFT JOIN {$wpdb->yith_affiliates} AS ya ON ya.ID = yp.affiliate_id
					LEFT JOIN {$wpdb->users} AS u ON u.ID = ya.user_id
					WHERE 1 = 1";
				$query_args = array();

				if ( $is_counting ) {
					$query = "SELECT COUNT(*)
						FROM {$wpdb->yith_payments} AS yp
						LEFT JOIN {$wpdb->yith_affiliates} AS ya ON ya.ID = yp.affiliate_id
						LEFT JOIN {$wpdb->users} AS u ON u.ID = ya.user_id
						WHERE 1 = 1";
				}

				if ( ! empty( $args['ID'] ) ) {
					$query       .= ' AND yp.ID = %d';
					$query_args[] = $args['ID'];
				}

				if ( ! empty( $args['include'] ) ) {
					$args['include'] = (array) $args['include'];

					$query     .= ' AND yp.ID IN (' . trim( str_repeat( '%d, ', count( $args['include'] ) ), ', ' ) . ')';
					$query_args = array_merge(
						$query_args,
						$args['include']
					);
				}

				if ( ! empty( $args['exclude'] ) ) {
					$args['exclude'] = (array) $args['exclude'];

					$query     .= ' AND yp.ID IN (' . trim( str_repeat( '%d, ', count( $args['exclude'] ) ), ', ' ) . ')';
					$query_args = array_merge(
						$query_args,
						$args['exclude']
					);
				}

				if ( ! empty( $args['user_id'] ) ) {
					$query       .= ' AND u.ID = %d';
					$query_args[] = $args['user_id'];
				}

				if ( ! empty( $args['affiliate_id'] ) ) {
					$query       .= ' AND ya.ID = %d';
					$query_args[] = $args['affiliate_id'];
				}

				if ( ! empty( $args['commissions'] ) ) {
					$commissions = array_map( 'intval', (array) $args['commissions'] );

					if ( ! empty( $commissions ) ) {
						$query     .= ' AND yp.ID IN (
							SELECT payment_id
							FROM ' . $wpdb->yith_payment_commission . '
							WHERE commission_id IN ( ' . trim( str_repeat( '%d, ', count( $commissions ) ), ', ' ) . ' )
						)';
						$query_args = array_merge(
							$query_args,
							$commissions
						);
					}
				}

				if ( ! empty( $args['user_login'] ) ) {
					$query       .= ' AND u.user_login LIKE %s';
					$query_args[] = '%' . $args['user_login'] . '%';
				}

				if ( ! empty( $args['user_email'] ) ) {
					$query       .= ' AND u.user_email LIKE %s';
					$query_args[] = '%' . $args['user_email'] . '%';
				}

				if ( ! empty( $args['payment_email'] ) ) {
					$query       .= ' AND yp.payment_email LIKE %s';
					$query_args[] = '%' . $args['payment_email'] . '%';
				}

				if ( ! empty( $args['status'] ) ) {
					if ( ! is_array( $args['status'] ) && in_array( $args['status'], $available_statuses, true ) ) {
						$query       .= ' AND yp.status = %s';
						$query_args[] = $args['status'];
					} elseif ( is_array( $args['status'] ) ) {
						$filtered_statuses = array_intersect( $args['status'], $available_statuses );

						if ( $filtered_statuses ) {
							$query     .= ' AND yp.status IN ( ' . trim( str_repeat( '%s, ', count( $filtered_statuses ) ), ', ' ) . ' )';
							$query_args = array_merge(
								$query_args,
								$filtered_statuses
							);
						}
					}
				}

				if ( ! empty( $args['amount'] ) && is_array( $args['amount'] ) && ( isset( $args['amount']['min'] ) || isset( $args['amount']['max'] ) ) ) {
					if ( ! empty( $args['amount']['min'] ) ) {
						$query       .= ' AND yp.amount >= %f';
						$query_args[] = $args['amount']['min'];
					}

					if ( ! empty( $args['amount']['max'] ) ) {
						$query       .= ' AND yp.amount <= %f';
						$query_args[] = $args['amount']['max'];
					}
				}

				if ( ! empty( $args['interval'] ) && is_array( $args['interval'] ) && ( isset( $args['interval']['start_date'] ) || isset( $args['interval']['end_date'] ) ) ) {
					if ( ! empty( $args['interval']['start_date'] ) ) {
						$query       .= ' AND yp.created_at >= %s';
						$query_args[] = $args['interval']['start_date'];
					}

					if ( ! empty( $args['interval']['end_date'] ) ) {
						$query       .= ' AND yp.created_at <= %s';
						$query_args[] = $args['interval']['end_date'];
					}
				}

				if ( ! empty( $args['completed_between'] ) && is_array( $args['completed_between'] ) && ( isset( $args['completed_between']['start_date'] ) || isset( $args['completed_between']['end_date'] ) ) ) {
					if ( ! empty( $args['completed_between']['start_date'] ) ) {
						$query       .= ' AND yp.completed_at >= %s';
						$query_args[] = $args['completed_between']['start_date'];
					}

					if ( ! empty( $args['completed_between']['end_date'] ) ) {
						$query       .= ' AND yp.completed_at <= %s';
						$query_args[] = $args['completed_between']['end_date'];
					}
				}

				if ( ! empty( $args['transaction_key'] ) ) {
					$query       .= ' AND yp.transaction_key LIKE %s';
					$query_args[] = '%' . $args['transaction_key'] . '%';
				}

				if ( ! empty( $args['s'] ) ) {
					$query       .= ' AND ( u.user_login LIKE %s OR u.user_email LIKE %s OR yp.payment_email LIKE %s OR yp.transaction_key LIKE %s )';
					$query_args[] = '%' . $args['s'] . '%';
					$query_args[] = '%' . $args['s'] . '%';
					$query_args[] = '%' . $args['s'] . '%';
					$query_args[] = '%' . $args['s'] . '%';
				}

				if ( ! empty( $args['orderby'] ) && ! $is_counting ) {
					$query .= $this->generate_query_orderby_clause( $args['orderby'], $args['order'] );
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

				$this->cache_set( $this->get_versioned_cache_key( 'query', $args ), $res );
			}

			// if we're counting, return count found.
			if ( $is_counting ) {
				return $res;
			}

			// if we have an empty set from db, return empty array/collection and skip next steps.
			if ( ! $res ) {
				return empty( $args['fields'] ) ? new YITH_WCAF_Payments_Collection() : array();
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
				$res = new YITH_WCAF_Payments_Collection( $ids, $this->get_pagination_data( $args ) );
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
					'affiliate_id' => 0,
					'interval'     => false,
				);

				$args = wp_parse_args( $args, $defaults );

				$query      = "SELECT yp.status, COUNT( yp.status ) AS status_count FROM {$wpdb->yith_payments} AS yp WHERE 1 = 1";
				$query_args = array();

				if ( ! empty( $args['affiliate_id'] ) ) {
					$query       .= ' AND yp.affiliate_id = %d';
					$query_args[] = $args['affiliate_id'];
				}

				if ( ! empty( $args['interval'] ) && is_array( $args['interval'] ) && ( isset( $args['interval']['start_date'] ) || isset( $args['interval']['end_date'] ) ) ) {
					if ( ! empty( $args['interval']['start_date'] ) ) {
						$query       .= ' AND yp.created_at >= %s';
						$query_args[] = $args['interval']['start_date'];
					}

					if ( ! empty( $args['interval']['end_date'] ) ) {
						$query       .= ' AND yp.created_at <= %s';
						$query_args[] = $args['interval']['end_date'];
					}
				}

				$query .= ' GROUP BY yp.status';

				if ( ! empty( $query_args ) ) {
					$query = $wpdb->prepare( $query, $query_args ); // phpcs:ignore WordPress.DB
				}

				$counts = $wpdb->get_results( $query, ARRAY_A ); // phpcs:ignore WordPress.DB

				// format result.
				$statuses = YITH_WCAF_Payments::get_available_statuses();
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

		/* === COMMISSIONS === */

		/**
		 * Returns a list of commissions for current payment, if any
		 *
		 * @param YITH_WCAF_Payment $payment Data object.
		 * @return YITH_WCAF_Commissions_Collection|bool Payment's commissions or false.
		 */
		public function read_commissions( $payment ) {
			global $wpdb;

			if ( ! $payment->get_id() ) {
				return false;
			}

			$ids = $wpdb->get_col( $wpdb->prepare( "SELECT commission_id FROM {$wpdb->yith_payment_commission} WHERE payment_id = %d", $payment->get_id() ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

			if ( ! $ids ) {
				return false;
			}

			return new YITH_WCAF_Commissions_Collection( $ids );
		}

		/**
		 * Updated payment's commission list, when the list of commissions currently stored in payment object
		 *
		 * @param YITH_WCAF_Payment $payment Data object.
		 */
		public function update_commissions( $payment ) {
			global $wpdb;

			$payment_id  = $payment->get_id();
			$commissions = $payment->get_commissions();

			// if we couldn't retrieve commissions, don't proceed any further.
			if ( is_null( $commissions ) ) {
				return;
			}

			// retrieve commission ids.
			$commission_ids = $commissions ? $commissions->get_ids() : array();

			// read original commissions.
			$original_commissions    = $payment->get_original_commissions();
			$original_commission_ids = $original_commissions ? $original_commissions->get_ids() : array();

			// add missing commissions.
			$commissions_to_add = array_diff( $commission_ids, $original_commission_ids );

			if ( ! empty( $commissions_to_add ) ) {
				foreach ( $commissions_to_add as $commission_id ) {
					$wpdb->insert( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
						$wpdb->yith_payment_commission,
						array(
							'commission_id' => $commission_id,
							'payment_id'    => $payment_id,
						),
						array(
							'%d',
							'%d',
						)
					);
				}
			}

			// remove outdated commissions.
			$commissions_to_remove = array_diff( $original_commission_ids, $commission_ids );

			if ( ! empty( $commissions_to_remove ) ) {
				foreach ( $commissions_to_remove as $commission_id ) {
					$wpdb->delete( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
						$wpdb->yith_payment_commission,
						array(
							'payment_id'    => $payment_id,
							'commission_id' => $commission_id,
						),
						array(
							'%d',
							'%d',
						)
					);
				}
			}
		}

		/* === UTILITIES === */

		/**
		 * Clear payments related caches
		 *
		 * @param \YITH_WCAF_Payment|int $payment Payment object, or payment id.
		 * @return void
		 */
		public function clear_cache( $payment ) {
			$payment = YITH_WCAF_Payment_Factory::get_payment( $payment );

			if ( ! $payment || ! $payment->get_id() ) {
				return;
			}

			$this->cache_delete( 'payment-' . $payment->get_id() );
			$this->invalidate_versioned_cache();
		}
	}
}
