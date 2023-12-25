<?php
/**
 * Affiliate data store
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliate_Data_Store' ) ) {
	/**
	 * This class implements CRUD methods for Affiliates
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Affiliate_Data_Store extends WC_Customer_Data_store implements YITH_WCAF_Object_Data_Store_Interface, YITH_WCAF_Meta_Data_Store_Interface {

		use YITH_WCAF_Trait_DB_Object, YITH_WCAF_Trait_Cacheable;

		/**
		 * Data stored in meta keys, but not considered "meta".
		 * This array is forcefully empty, as all plugin's meta are prefixed, so no data retrieved by
		 * \YITH_WCAF_Affiliate_Data_Store::read_meta should be excluded from meta.
		 *
		 * @var array
		 */
		protected $internal_meta_keys = array();

		/**
		 * Constructor method
		 */
		public function __construct() {
			global $wpdb;

			$this->table = $wpdb->yith_affiliates;

			$this->cache_group = 'affiliates';

			$this->columns = array(
				'token'         => '%s',
				'user_id'       => '%d',
				'rate'          => '%f',
				'earnings'      => '%f',
				'refunds'       => '%f',
				'paid'          => '%f',
				'click'         => '%f',
				'conversion'    => '%f',
				'enabled'       => '%d',
				'banned'        => '%d',
				'payment_email' => '%s',
			);

			$this->orderby = array_merge(
				array_keys( $this->columns ),
				array(
					'ID',
					'affiliate_id',
					'totals',
					'balance',
					'conv_rate',
					'user_login',
					'user_email',
					'display_name',
					'user_nicename',
				)
			);

			$this->nullable = array(
				'rate',
			);

			$this->props_to_columns = array(
				'conversions'  => 'conversion',
				'clicks_count' => 'click',
				'status'       => 'enabled',
			);
		}

		/* === CRUD === */

		/**
		 * Method to create a new record of a WC_Data based object.
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Data object.
		 * @throws Exception When affiliate cannot be created with current information.
		 */
		public function create( &$affiliate ) {
			global $wpdb;

			if ( ! $affiliate->get_user_id() ) {
				throw new Exception( _x( 'Unable to create affiliate. Missing required params.', '[DEV] Debug message triggered when unable to create filter session.', 'yith-woocommerce-affiliates' ) );
			}

			if ( ! $affiliate->get_token() ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_affiliate_default_token_algorithm
				 *
				 * Filters the default algorithm method to generate affiliate token.
				 *
				 * @param string $algorithm Algorithm to use to generate token.
				 */
				$affiliate->set_token( $this->generate_token( $affiliate, apply_filters( 'yith_wcaf_affiliate_default_token_algorithm', 'user_id' ) ) );
			}

			$res = $this->save_object( $affiliate );

			if ( $res ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_affiliate_correctly_created
				 *
				 * Filters the id of the affiliate created.
				 *
				 * @param int $id Affiliate id.
				 */
				$id = apply_filters( 'yith_wcaf_affiliate_correctly_created', intval( $wpdb->insert_id ) );

				$affiliate->set_id( $id );
				$affiliate->save_meta_data();
				$affiliate->apply_changes();

				if ( yith_plugin_fw_is_true( get_option( 'yith_wcaf_referral_registration_process_orphan_commissions', 'no' ) ) ) {
					try {
						$commissions_data_store = WC_Data_Store::load( 'commission' );
						$commissions_data_store->process_orphan_commissions( $id, $affiliate->get_token() );
					} catch ( Exception $e ) { // phpcs:ignore
						// do nothing.
					}
				}

				$this->add_role( $affiliate );
				$this->clear_cache( $affiliate );

				/**
				 * DO_ACTION: yith_wcaf_new_affiliate
				 *
				 * Allows to trigger some action when a new affiliate is created.
				 *
				 * @param int                 $affiliate_id Affiliate id.
				 * @param YITH_WCAF_Affiliate $affiliate    Affiliate object.
				 */
				do_action( 'yith_wcaf_new_affiliate', $affiliate->get_id(), $affiliate );
			}
		}

		/**
		 * Method to read a record. Creates a new WC_Data based object.
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Data object.
		 * @throws Exception When affiliate cannot be retrieved with current information.
		 */
		public function read( &$affiliate ) {
			global $wpdb;

			$affiliate->set_defaults();

			$id    = $affiliate->get_id();
			$token = $affiliate->get_token();

			if ( ! $id && ! $token ) {
				throw new Exception( _x( 'Invalid affiliate.', '[DEV] Debug message triggered when unable to find affiliate.', 'yith-woocommerce-affiliates' ) );
			}

			$affiliate_data = false;

			if ( $id ) {
				$affiliate_data = $this->cache_get( 'affiliate-' . $id );
			} elseif ( $token ) {
				$affiliate_data = $this->cache_get( 'affiliate-token-' . $token );
			}

			if ( ! $affiliate_data ) {
				// format query to retrieve affiliate.
				$query = false;

				if ( $id ) {
					$query = $wpdb->prepare( "SELECT * FROM {$wpdb->yith_affiliates} WHERE ID = %d", $id );
				} elseif ( $token ) {
					$query = $wpdb->prepare( "SELECT * FROM {$wpdb->yith_affiliates} WHERE token = %s", $token );
				}

				// retrieve affiliate data.
				$affiliate_data = $wpdb->get_row( $query ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery

				if ( $affiliate_data ) {
					$this->cache_set( 'affiliate-' . $affiliate_data->ID, $affiliate_data );
					$this->cache_set( 'affiliate-token-' . $affiliate_data->token, $affiliate_data );
				}
			}

			if ( ! $affiliate_data ) {
				throw new Exception( _x( 'Invalid affiliate.', '[DEV] Debug message triggered when unable to find affiliate.', 'yith-woocommerce-affiliates' ) );
			}

			$affiliate->set_id( (int) $affiliate_data->ID );

			// set affiliate props.
			foreach ( array_keys( $this->columns ) as $column ) {
				$affiliate->{"set_{$this->get_column_prop_name( $column )}"}( $affiliate_data->$column );
			}

			// set legacy payment email.
			$affiliate->set_payment_email( $affiliate_data->payment_email );

			$affiliate->set_object_read( true );
		}

		/**
		 * Updates a record in the database.
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Data object.
		 */
		public function update( &$affiliate ) {
			if ( ! $affiliate->get_id() ) {
				return;
			}

			// make sure to assign unique token on update.
			$changes = $affiliate->get_changes();

			if ( ! empty( $changes['token'] ) ) {
				$unique_token = $this->ensure_unique_token( $changes['token'], $affiliate );

				if ( $unique_token !== $changes['token'] ) {
					$affiliate->set_token( $unique_token );
				}
			}

			// proceed with object update.
			$this->update_object( $affiliate );

			$affiliate->save_meta_data();
			$affiliate->apply_changes();

			$this->clear_cache( $affiliate );

			/**
			 * DO_ACTION: yith_wcaf_update_affiliate
			 *
			 * Allows to trigger some action when an affiliate is updated.
			 *
			 * @param int                 $affiliate_id Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate    Affiliate object.
			 */
			do_action( 'yith_wcaf_update_affiliate', $affiliate->get_id(), $affiliate );
		}

		/**
		 * Deletes a record from the database.
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Data object.
		 * @param array               $args      Not in use.
		 *
		 * @return bool result
		 */
		public function delete( &$affiliate, $args = array() ) {
			global $wpdb;

			$id = $affiliate->get_id();

			if ( ! $id ) {
				return false;
			}

			/**
			 * DO_ACTION: yith_wcaf_before_delete_affiliate
			 *
			 * Allows to trigger some action before deleting an affiliate.
			 *
			 * @param int                 $id        Affiliate id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			do_action( 'yith_wcaf_before_delete_affiliate', $id, $affiliate );

			$this->clear_cache( $affiliate );

			// delete affiliate.
			$res = $wpdb->delete( $wpdb->yith_affiliates, array( 'ID' => $id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

			if ( $res ) {
				/**
				 * DO_ACTION: yith_wcaf_delete_affiliate
				 *
				 * Allows to trigger some action when an affiliate is deleted.
				 *
				 * @param int                 $id        Affiliate id.
				 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
				 */
				do_action( 'yith_wcaf_delete_affiliate', $id, $affiliate );

				$this->remove_role( $affiliate );
				$this->delete_all_meta( $affiliate );
				$affiliate->set_id( 0 );

				/**
				 * DO_ACTION: yith_wcaf_deleted_affiliate
				 *
				 * Allows to trigger some action after deleting an affiliate.
				 *
				 * @param int                 $id        Affiliate id.
				 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
				 */
				do_action( 'yith_wcaf_deleted_affiliate', $id, $affiliate );
			}

			return $res;
		}

		/**
		 * Returns token by user id, if possible
		 *
		 * @param int $user_id User id to search.
		 *
		 * @return string|bool Affiliate token, if found; false otherwise.
		 */
		public function get_token_by_user_id( $user_id ) {
			global $wpdb;

			$token = $this->cache_get( 'token-by-user_id-' . $user_id );

			if ( ! $token ) {
				$token = $wpdb->get_var( $wpdb->prepare( "SELECT token FROM {$wpdb->yith_affiliates} WHERE user_id = %d", $user_id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery

				if ( $token ) {
					$this->cache_set( 'token-by-user_id-' . $user_id, $token );
				}
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_get_token_by_user_id
			 *
			 * Filters the affiliate token given the user id.
			 *
			 * @param string $token   Affiliate token.
			 * @param int    $user_id User id.
			 */
			return apply_filters( 'yith_wcaf_get_token_by_user_id', $token, $user_id );
		}

		/* === QUERY === */

		/**
		 * Return count of affiliates matching filtering criteria
		 *
		 * @param array $args Filtering criteria (@see \YITH_WCAF_Affiliate_Data_Store::query).
		 * @return int Count of matching affiliates.
		 */
		public function count( $args = array() ) {
			$args['fields'] = 'count';

			return (int) $this->query( $args );
		}

		/**
		 * Return affiliates matching filtering criteria
		 *
		 * @param array $args Filtering criteria<br/>:
		 *              [<br/>
		 *              'ID' => false,                   // affiliate id (int)<br/>
		 *              'affiliate_id' => false,         // affiliate id (alternative for previous key) (int)<br/>
		 *              'include' => array()             // array of ids to include in the final set<br/>
		 *              'exclude' => array()             // array of ids to exclude from the final set<br/>
		 *              'user_id' => false,              // affiliate related user id (int)<br/>
		 *              'user_login' => false,           // affiliate related user login, or part of it (string)<br/>
		 *              'user_email' => false,           // affiliate related user EMAIL, or part of it (string)<br/>
		 *              'payment_email' => false,        // affiliate payment email, or part of it (string)<br/>
		 *              'rate' => false,                 // affiliate rate range (array, with at lest one of this index: [min(float)|max(float)])<br/>
		 *              'earnings' => false,             // affiliate earnings range (array, with at lest one of this index: [min(float)|max(float)])<br/>
		 *              'paid' => false,                 // affiliate paid range (array, with at lest one of this index: [min(float)|max(float)])<br/>
		 *              'balance' => false,              // affiliate balance range (array, with at lest one of this index: [min(float)|max(float)])<br/>
		 *              'clicks' => false,               // affiliate clicks range (array, with at lest one of this index: [min(float)|max(float)])<br/>
		 *              'conversions' => false,          // affiliate conversions range (array, with at lest one of this index: [min(float)|max(float)])<br/>
		 *              'conv_rate' => false,            // affiliate conversion rate range (array, with at lest one of this index: [min(float)|max(float)])<br/>
		 *              'enabled' => false,              // affiliate status (new/enabled/disabled)<br/>
		 *              'banned' => false,               // affiliates ban status (banned/unbanned)<br/>
		 *              's' => false                     // search string (string)<br/>
		 *              'interval' => false              // affiliate registration date range (array, with at lest one of this index: [start_date(string; mysql date format)|end_date(string; mysql date format)])<br/>
		 *              'order' => 'DESC',               // sorting direction (ASC/DESC)<br/>
		 *              'orderby' => 'ID',               // sorting column (any table valid column)<br/>
		 *              'limit' => 0,                    // limit (int)<br/>
		 *              'offset' => 0,                   // offset (int)<br/>
		 *              'fields => '' ,                  // fields to retrieve (count, or any valid column name, optionally prefixed by "id=>" to have result indexed by object ID)<br/>
		 *              ].
		 *
		 * @return YITH_WCAF_Affiliates_Collection|string[]|int|bool Matching affiliates, or affiliates count
		 */
		public function query( $args = array() ) {
			global $wpdb;

			$defaults = array(
				'ID'            => false,
				'affiliate_id'  => false,
				'include'       => array(),
				'exclude'       => array(),
				'user_id'       => false,
				'user_login'    => false,
				'user_email'    => false,
				'payment_email' => false,
				'rate'          => false,
				'earnings'      => false,
				'paid'          => false,
				'balance'       => false,
				'clicks'        => false,
				'conversions'   => false,
				'conv_rate'     => false,
				'enabled'       => false,
				'banned'        => false,
				's'             => false,
				'interval'      => false,
				'order'         => 'DESC',
				'orderby'       => 'ID',
				'limit'         => 0,
				'offset'        => 0,
				'fields'        => '',
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
						ya.*,
       					ya.ID AS affiliate_id, 
						( ya.earnings + ya.refunds ) AS totals,
						( ya.earnings - ya.paid ) AS balance,
						( ya.conversion / ya.click * 100 ) AS conv_rate,
						u.user_login,
						u.user_email,
						u.display_name,
						u.user_nicename
					FROM {$wpdb->yith_affiliates} AS ya
					LEFT JOIN {$wpdb->users} AS u ON u.ID = ya.user_id
					WHERE 1 = 1";
				$query_args = array();

				if ( $is_counting ) {
					$query = "SELECT COUNT(*)
						FROM {$wpdb->yith_affiliates} AS ya
						LEFT JOIN {$wpdb->users} AS u ON u.ID = ya.user_id
						WHERE 1 = 1";
				}

				if ( ! empty( $args['ID'] ) ) {
					$query       .= ' AND ya.ID = %d';
					$query_args[] = $args['ID'];
				}

				if ( ! empty( $args['affiliate_id'] ) ) {
					$query       .= ' AND ya.ID = %d';
					$query_args[] = $args['affiliate_id'];
				}

				if ( ! empty( $args['include'] ) ) {
					$args['include'] = (array) $args['include'];

					$query     .= ' AND ya.ID IN (' . trim( str_repeat( '%d, ', count( $args['include'] ) ), ', ' ) . ')';
					$query_args = array_merge(
						$query_args,
						$args['include']
					);
				}

				if ( ! empty( $args['exclude'] ) ) {
					$args['exclude'] = (array) $args['exclude'];

					$query     .= ' AND ya.ID NOT IN (' . trim( str_repeat( '%d, ', count( $args['exclude'] ) ), ', ' ) . ')';
					$query_args = array_merge(
						$query_args,
						$args['exclude']
					);
				}

				if ( ! empty( $args['user_id'] ) ) {
					$query       .= ' AND ya.user_id = %d';
					$query_args[] = $args['user_id'];
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
					$query       .= ' AND ya.payment_email LIKE %s';
					$query_args[] = '%' . $args['payment_email'] . '%';
				}

				if ( ! empty( $args['rate'] ) ) {
					if ( is_array( $args['rate'] ) && ( isset( $args['rate']['min'] ) || isset( $args['rate']['max'] ) ) ) {
						if ( ! empty( $args['rate']['min'] ) ) {
							$query       .= ' AND ya.rate >= %f';
							$query_args[] = $args['rate']['min'];
						}

						if ( ! empty( $args['rate']['max'] ) ) {
							$query       .= ' AND ya.rate <= %f';
							$query_args[] = $args['rate']['max'];
						}
					} elseif ( 'NULL' === $args['rate'] ) {
						$query .= ' AND ya.rate IS NULL';
					} elseif ( 'NOT NULL' === $args['rate'] ) {
						$query .= ' AND ya.rate IS NOT NULL';
					}
				}

				if ( ! empty( $args['earnings'] ) && is_array( $args['earnings'] ) && ( isset( $args['earnings']['min'] ) || isset( $args['earnings']['max'] ) ) ) {
					if ( ! empty( $args['earnings']['min'] ) ) {
						$query       .= ' AND ( ya.earnings + ya.refunds ) >= %f';
						$query_args[] = $args['earnings']['min'];
					}

					if ( ! empty( $args['earnings']['max'] ) ) {
						$query       .= ' AND ( ya.earnings + ya.refunds ) <= %f';
						$query_args[] = $args['earnings']['max'];
					}
				}

				if ( ! empty( $args['paid'] ) && is_array( $args['paid'] ) && ( isset( $args['paid']['min'] ) || isset( $args['paid']['max'] ) ) ) {
					if ( ! empty( $args['paid']['min'] ) ) {
						$query       .= ' AND ya.paid >= %f';
						$query_args[] = $args['paid']['min'];
					}

					if ( ! empty( $args['paid']['max'] ) ) {
						$query       .= ' AND ya.paid <= %f';
						$query_args[] = $args['paid']['max'];
					}
				}

				if ( ! empty( $args['balance'] ) && is_array( $args['balance'] ) && ( isset( $args['balance']['min'] ) || isset( $args['balance']['max'] ) ) ) {
					if ( ! empty( $args['balance']['min'] ) ) {
						$query       .= ' AND ( ya.earnings - ya.paid ) >= %f';
						$query_args[] = $args['balance']['min'];
					}

					if ( ! empty( $args['balance']['max'] ) ) {
						$query       .= ' AND ( ya.earnings - ya.paid ) <= %f';
						$query_args[] = $args['balance']['max'];
					}
				}

				if ( ! empty( $args['clicks'] ) && is_array( $args['clicks'] ) && ( isset( $args['clicks']['min'] ) || isset( $args['clicks']['max'] ) ) ) {
					if ( ! empty( $args['clicks']['min'] ) ) {
						$query       .= ' AND ya.click >= %f';
						$query_args[] = $args['clicks']['min'];
					}

					if ( ! empty( $args['clicks']['max'] ) ) {
						$query       .= ' AND ya.click <= %f';
						$query_args[] = $args['clicks']['max'];
					}
				}

				if ( ! empty( $args['conversion'] ) && is_array( $args['conversion'] ) && ( isset( $args['conversion']['min'] ) || isset( $args['conversion']['max'] ) ) ) {
					if ( ! empty( $args['conversion']['min'] ) ) {
						$query       .= ' AND ya.conversion >= %f';
						$query_args[] = $args['conversion']['min'];
					}

					if ( ! empty( $args['conversion']['max'] ) ) {
						$query       .= ' AND ya.conversion <= %f';
						$query_args[] = $args['conversion']['max'];
					}
				}

				if ( ! empty( $args['conv_rate'] ) && is_array( $args['conv_rate'] ) && ( isset( $args['conv_rate']['min'] ) || isset( $args['conv_rate']['max'] ) ) ) {
					if ( ! empty( $args['conv_rate']['min'] ) ) {
						$query       .= ' AND ( ya.conversion / ya.click * 100 ) >= %f';
						$query_args[] = $args['conv_rate']['min'];
					}

					if ( ! empty( $args['conv_rate']['max'] ) ) {
						$query       .= ' AND ( ya.conversion / ya.click * 100 ) <= %f';
						$query_args[] = $args['conv_rate']['max'];
					}
				}

				if ( ! empty( $args['enabled'] ) ) {
					$query .= ' AND ya.enabled = %d';
					switch ( $args['enabled'] ) {
						case 'new':
							$query_args[] = 0;
							break;
						case 'disabled':
							$query_args[] = - 1;
							break;
						case 'enabled':
						default:
							$query_args[] = 1;
							break;
					}
				}

				if ( ! empty( $args['banned'] ) ) {
					$query       .= ' AND ya.banned = %d';
					$query_args[] = 'banned' === $args['banned'] ? 1 : 0;
				}

				if ( ! empty( $args['s'] ) ) {
					$query .= " AND (
						u.user_login LIKE %s OR
						u.user_email LIKE %s OR
						ya.token LIKE %s OR
						ya.payment_email LIKE %s OR
						ya.user_id IN ( SELECT um.user_id FROM {$wpdb->usermeta} AS um WHERE um.meta_value LIKE %s AND ( um.meta_key = %s OR um.meta_key = %s ) )
						)";

					$search_string = '%' . $args['s'] . '%';
					$query_args    = array_merge(
						$query_args,
						array(
							$search_string,
							$search_string,
							$search_string,
							$search_string,
							$search_string,
							'first_name',
							'last_name',
						)
					);
				}

				if ( ! empty( $args['interval'] ) && is_array( $args['interval'] ) && ( isset( $args['interval']['start_date'] ) || isset( $args['interval']['end_date'] ) ) ) {
					if ( ! empty( $args['interval']['start_date'] ) ) {
						$query       .= ' AND u.user_registered >= %s';
						$query_args[] = $args['interval']['start_date'];
					}

					if ( ! empty( $args['interval']['end_date'] ) ) {
						$query       .= ' AND u.user_registered <= %s';
						$query_args[] = $args['interval']['end_date'];
					}
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

				$this->cache_set( $cache_key, $res );
			}

			// if we're counting, return count found.
			if ( $is_counting ) {
				return $res;
			}

			// if we have an empty set from db, return empty array/collection and skip next steps.
			if ( ! $res ) {
				return empty( $args['fields'] ) ? new YITH_WCAF_Affiliates_Collection() : array();
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
				$res = new YITH_WCAF_Affiliates_Collection( $ids, $this->get_pagination_data( $args ) );
			}

			return $res;
		}

		/**
		 * Returns count of affiliate, grouped by status
		 *
		 * @param string $status Specific status to count, or all to obtain a global statistic; if left empty, returns array of counts per status.
		 * @param array  $args   Array of arguments to filter status query<br/>
		 *                [<br/>
		 *                's' => false // search string (string)<br/>
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
					's' => '',
				);

				$args = wp_parse_args( $args, $defaults );

				$query_args = array();
				$query      = "SELECT ya.enabled AS status,
						COUNT( ya.ID ) AS status_count 
					FROM {$wpdb->yith_affiliates} AS ya 
					LEFT JOIN {$wpdb->users} AS u ON u.ID = ya.user_id
					WHERE 1 = 1
					AND ya.banned = 0";
				$query2     = "SELECT COUNT( ya.ID ) FROM {$wpdb->yith_affiliates} as ya WHERE ya.banned = 1";

				if ( ! empty( $args['s'] ) ) {
					$search_condition = ' AND ( u.user_login LIKE %s OR u.user_email LIKE %s OR ya.token LIKE %s OR ya.payment_email LIKE %s )';

					$query  .= $search_condition;
					$query2 .= $search_condition;

					$search_string = '%' . $args['s'] . '%';
					$query_args    = array_merge(
						$query_args,
						array(
							$search_string,
							$search_string,
							$search_string,
							$search_string,
						)
					);
				}

				$query .= ' GROUP BY status';

				if ( ! empty( $query_args ) ) {
					$query  = $wpdb->prepare( $query, $query_args ); // phpcs:ignore WordPress.DB
					$query2 = $wpdb->prepare( $query2, $query_args ); // phpcs:ignore WordPress.DB
				}

				$counts = $wpdb->get_results( $query, ARRAY_A ); // phpcs:ignore WordPress.DB
				$banned = $wpdb->get_var( $query2 ); // phpcs:ignore WordPress.DB

				// format result.
				$statuses = YITH_WCAF_Affiliates::get_available_statuses();
				$counts   = $counts ? array_combine( wp_list_pluck( $counts, 'status' ), wp_list_pluck( $counts, 'status_count' ) ) : array();

				foreach ( $statuses as $status_id => $status_options ) {
					$res[ $status_options['slug'] ] = isset( $counts[ $status_id ] ) ? $counts[ $status_id ] : 0;
				}

				// add banned count.
				$res['banned'] = $banned;

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

		/* === META === */

		/**
		 * Returns an array of meta for an object.
		 *
		 * @param WC_Data $affiliate Data object.
		 *
		 * @return array
		 */
		public function read_meta( &$affiliate ) {
			global $wpdb;

			if ( ! $affiliate->get_id() || ! $affiliate->get_user_id() ) {
				return array();
			}

			$meta = $this->cache_get( 'affiliate-' . $affiliate->get_id() . '-meta' );

			if ( ! $meta ) {
				$meta = $wpdb->get_results( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
					$wpdb->prepare(
						"SELECT *, umeta_id AS meta_id, SUBSTRING( meta_key, 12 ) AS meta_key
						FROM {$wpdb->usermeta}
						WHERE meta_key LIKE %s
						AND user_id = %d",
						'_yith_wcaf_%',
						$affiliate->get_user_id()
					)
				);

				$this->cache_set( 'affiliate-' . $affiliate->get_id() . '-meta', $meta );
			}

			return $meta;
		}

		/**
		 * Removes all meta for an affiliate
		 *
		 * @param WC_Data $affiliate Data object.
		 */
		public function delete_all_meta( &$affiliate ) {
			global $wpdb;

			if ( ! $affiliate->get_id() || ! $affiliate->get_user_id() ) {
				return array();
			}

			$wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$wpdb->prepare(
					"DELETE FROM {$wpdb->usermeta}
						WHERE meta_key LIKE %s
						AND user_id = %d",
					'_yith_wcaf_%',
					$affiliate->get_user_id()
				)
			);
		}

		/**
		 * Deletes meta based on meta ID.
		 *
		 * @param WC_Data $affiliate Data object.
		 * @param object  $meta Meta object (containing at least ->id).
		 * @return bool
		 */
		public function delete_meta( &$affiliate, $meta ) {
			if ( ! $affiliate->get_id() || ! $affiliate->get_user_id() ) {
				return false;
			}

			return delete_metadata_by_mid( 'user', $meta->id );
		}

		/**
		 * Add new piece of meta.
		 *
		 * @param WC_Data $affiliate Data object.
		 * @param object  $meta Meta object (containing ->key and ->value).
		 * @return int|bool Meta ID ot false on failure
		 */
		public function add_meta( &$affiliate, $meta ) {
			if ( ! $affiliate->get_id() || ! $affiliate->get_user_id() ) {
				return false;
			}

			return add_user_meta( $affiliate->get_user_id(), "_yith_wcaf_{$meta->key}", $meta->value );
		}

		/**
		 * Update meta.
		 *
		 * @param WC_Data $affiliate Data object.
		 * @param object  $meta Meta object (containing ->id, ->key and ->value).
		 */
		public function update_meta( &$affiliate, $meta ) {
			if ( ! $affiliate->get_id() || ! $affiliate->get_user_id() ) {
				return false;
			}

			return update_user_meta( $affiliate->get_user_id(), "_yith_wcaf_{$meta->key}", $meta->value );
		}

		/* === ROLE HANDLING === */

		/**
		 * Add role to user becoming an affiliate
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Affiliate.
		 * @return void.
		 */
		public function add_role( $affiliate ) {
			$user = $affiliate->get_user();

			/**
			 * APPLY_FILTERS: yith_wcaf_add_affiliate_role
			 *
			 * Filters whether to add the Affiliate role.
			 *
			 * @param bool                $add_role  Whether to add the role or not.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 */
			if ( ! $user || is_wp_error( $user ) || ! apply_filters( 'yith_wcaf_add_affiliate_role', true, $affiliate ) ) {
				return;
			}

			$user->add_role( YITH_WCAF_Affiliates::get_role() );
		}

		/**
		 * Remove role from user that is no longer an affiliate
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Affiliate.
		 * @return void.
		 */
		public function remove_role( $affiliate ) {
			$user = $affiliate->get_user();

			if ( ! $user || is_wp_error( $user ) ) {
				return;
			}

			$user->remove_role( YITH_WCAF_Affiliates::get_role() );
		}

		/* === UTILITIES === */

		/**
		 * Clear affiliate related caches
		 *
		 * @param \YITH_WCAF_Affiliate|int|string $affiliate Affiliate object, affiliate token, or affiliate id.
		 * @return void
		 */
		public function clear_cache( $affiliate ) {
			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_token( $affiliate );

			if ( ! $affiliate || ! $affiliate->get_id() ) {
				return;
			}

			$this->cache_delete( 'affiliate-' . $affiliate->get_id() );
			$this->cache_delete( 'affiliate-token-' . $affiliate->get_token() );
			$this->cache_delete( 'token-by-user_id-' . $affiliate->get_user_id() );
			$this->cache_delete( 'affiliate-' . $affiliate->get_id() . '-meta' );

			$this->invalidate_versioned_cache();
		}

		/**
		 * Generate token for the session
		 *
		 * Token is the string that will be used when creating affiliate referral url.
		 * Plugin provides various algorithm to generate a token, including custom handling
		 * It will anyway double check for uniqueness, before returning.
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Affiliate for which we're creating token.
		 * @param string              $algorithm Algorithm to use to generate token.
		 *
		 * @return string Generated token.
		 */
		public function generate_token( &$affiliate, $algorithm = 'user_id' ) {
			if ( ! $affiliate instanceof YITH_WCAF_Affiliate ) {
				return false;
			}

			if ( $affiliate->get_token() ) {
				return $affiliate->get_token();
			}

			switch ( $algorithm ) {
				case 'user_id':
				case 'username':
				case 'random':
					$token = $this->{"get_{$algorithm}_token"}( $affiliate );
					break;
				default:
					// Unknown algorithm.
					/**
					 * APPLY_FILTERS: yith_wcaf_generate_token
					 *
					 * Filters whether to generate affiliate token.
					 *
					 * @param bool                $generate_token Whether to generate affiliate token or not.
					 * @param YITH_WCAF_Affiliate $affiliate      Affiliate object.
					 * @param string              $algorithm      Algorithm to use to generate token.
					 */
					$token = apply_filters( 'yith_wcaf_generate_token', false, $affiliate, $algorithm );
			}

			if ( ! $token ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_token
			 *
			 * Filters the default affiliate token.
			 *
			 * @param string              $default_token Default token.
			 * @param YITH_WCAF_Affiliate $affiliate     Affiliate object.
			 * @param string              $algorithm     Algorithm to use to generate token.
			 */
			return apply_filters( 'yith_wcaf_affiliate_token', $this->ensure_unique_token( $token, $affiliate ), $affiliate, $algorithm );
		}

		/**
		 * Makes sure the token we're going to assign to an affiliate is unique
		 *
		 * @param string              $token     Token to asses uniqueness.
		 * @param YITH_WCAF_Affiliate $affiliate Affiliate object that will receive token.
		 *
		 * @return string Unique token.
		 */
		protected function ensure_unique_token( $token, &$affiliate ) {
			global $wpdb;

			$suffix = '';
			$query  = "SELECT ID FROM {$wpdb->yith_affiliates} WHERE token = %s AND ID <> %d LIMIT 1";

			do {
				$generated_token = ! ! $suffix ? "$token-$suffix" : $token;

				$token_exists = $wpdb->get_var( $wpdb->prepare( $query, $generated_token, $affiliate->get_id() ) ); // phpcs:ignore WordPress.DB
				$suffix++;
			} while ( $token_exists );

			return $generated_token;
		}

		/**
		 * Generate token using User id
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Affiliate for which we're creating token.
		 *
		 * @return string Generated token
		 */
		protected function get_user_id_token( $affiliate ) {
			if ( ! $affiliate instanceof YITH_WCAF_Affiliate ) {
				return false;
			}

			return $affiliate ? (string) $affiliate->get_user_id() : false;
		}

		/**
		 * Generate token using Username
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Affiliate for which we're creating token.
		 *
		 * @return string Generated token
		 */
		protected function get_username_token( $affiliate ) {
			if ( ! $affiliate instanceof YITH_WCAF_Affiliate ) {
				return false;
			}

			$user = $affiliate ? $affiliate->get_user() : false;

			return $user ? $user->user_login : false;
		}

		/**
		 * Generate token as a random string
		 *
		 * @return string Generated token
		 */
		protected function get_random_token() {
			$dictionary = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

			/**
			 * APPLY_FILTERS: yith_wcaf_random_token_length
			 *
			 * Filters the length of the random token to be generated.
			 *
			 * @param int $length Token lenght.
			 */
			$nchars = apply_filters( 'yith_wcaf_random_token_length', 5 );
			$token  = '';

			for ( $i = 0; $i <= $nchars - 1; $i++ ) {
				$token .= $dictionary[ wp_rand( 0, strlen( $dictionary ) - 1 ) ];
			}

			return $token;
		}

		/**
		 * Returns value for a specific object prop
		 *
		 * @param YITH_WCAF_Affiliate $affiliate Data object.
		 * @param string              $prop      Prop to retrieve.
		 *
		 * @return mixed Value of the prop retrieved from the object
		 */
		protected function get_prop_value( $affiliate, $prop ) {
			if ( 'status' === $prop ) {
				return $affiliate->get_enabled();
			}

			$method = "get_$prop";

			if ( ! method_exists( $affiliate, $method ) ) {
				return false;
			}

			return $affiliate->$method();
		}
	}
}
