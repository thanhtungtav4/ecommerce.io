<?php
/**
 * Basic database object handling traits
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Traits
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! trait_exists( 'YITH_WCAF_Trait_DB_Object' ) ) {
	/**
	 * This class implements basic handling for database object
	 * It will offer methods to create/update an object, given a column list and a WC_Data reference object
	 *
	 * @since 2.0.0
	 */
	trait YITH_WCAF_Trait_DB_Object {

		/**
		 * Table
		 *
		 * @var string
		 */
		protected $table;

		/**
		 * Name of the column that contains row identifier.
		 *
		 * @var string
		 */
		protected $id_column = 'ID';

		/**
		 * Database structure.
		 *
		 * @var array
		 */
		protected $columns = array();

		/**
		 * Array of columns that should be set to NULL when no value is passed
		 *
		 * @var array
		 */
		protected $nullable = array();

		/**
		 * Array of valid values for orderby clause in the query
		 *
		 * @var array
		 */
		protected $orderby = array();

		/**
		 * Maps object properties to database columns
		 * Every prop not included in this list, match the column name
		 *
		 * @var array
		 */
		protected $props_to_columns = array();

		/**
		 * Save object into database
		 *
		 * @param WC_Data $object Object to save.
		 *
		 * @return mixed Status of the operation
		 */
		public function save_object( $object ) {
			global $wpdb;

			list( $columns, $types, $values ) = yith_plugin_fw_extract( $this->generate_query_structure( $object, false ), 'columns', 'types', 'values' );

			$query_columns = implode( ', ', array_map( 'esc_sql', $columns ) );
			$query_values  = implode( ', ', $types );
			$query         = "INSERT INTO {$this->table} ( {$query_columns} ) VALUES ( {$query_values} ) ";

			$res = $wpdb->query( $wpdb->prepare( $query, $values ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery

			return $res;
		}

		/**
		 * Update object in database
		 *
		 * @param WC_Data $object Object to update.
		 *
		 * @return mixed Status of the operation
		 */
		public function update_object( $object ) {
			$res = false;

			if ( ! empty( $object->get_changes() ) ) {
				list( $columns, $types, $values ) = yith_plugin_fw_extract( $this->generate_query_structure( $object ), 'columns', 'types', 'values' );

				if ( empty( $columns ) ) {
					return false;
				}

				$res = $this->update_raw( array_combine( $columns, $types ), $values, array( $this->id_column => '%d' ), array( $object->get_id() ) );
			}

			return $res;
		}

		/**
		 * Raw update method; useful when it is needed to update a bunch of affiliates
		 *
		 * @param array $columns           Array of columns to update, in the following format: 'column_id' => 'column_type'.
		 * @param array $column_values     Array of values to apply to the query; must have same number of elements of columns, and they must respect defined types.
		 * @param array $conditions        Array of where conditions, in the following format: 'column_id' => 'columns_type'.
		 * @param array $conditions_values Array of values to apply to where condition; must have same number of elements of columns, and they must respect defined types.
		 *
		 * @return mixed Status of the operation.
		 */
		public function update_raw( $columns, $column_values, $conditions = array(), $conditions_values = array() ) {
			global $wpdb;

			// calculate where statement.
			$query_where = '';

			if ( ! empty( $conditions ) ) {
				$query_where = array();

				foreach ( $conditions as $column => $value ) {
					$query_where[] = $column . '=' . $value;
				}

				$query_where = ' WHERE ' . implode( ' AND ', $query_where );
			}

			// calculate set statement.
			$query_columns = array();

			foreach ( $columns as $column => $value ) {
				$query_columns[] = $column . '=' . $value;
			}

			$query_columns = implode( ', ', $query_columns );

			// build query, and execute it.
			$query = "UPDATE {$this->table} SET {$query_columns} {$query_where}";

			$values = $conditions ? array_merge( $column_values, $conditions_values ) : $column_values;

			return $wpdb->query( $wpdb->prepare( $query, $values ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery
		}

		/**
		 * Get column name for a specific property
		 *
		 * @param string $prop Property to search for.
		 *
		 * @return string Column name.
		 */
		protected function get_prop_column_name( $prop ) {
			if ( ! isset( $this->props_to_columns[ $prop ] ) ) {
				return $prop;
			}

			return $this->props_to_columns[ $prop ];
		}

		/**
		 * Get property name for a column
		 *
		 * @param string $column Column to search for.
		 *
		 * @return string Property name.
		 */
		protected function get_column_prop_name( $column ) {
			$columns_to_props = array_flip( $this->props_to_columns );

			if ( ! isset( $columns_to_props[ $column ] ) ) {
				return $column;
			}

			return $columns_to_props[ $column ];
		}

		/**
		 * Returns list of valid orderby values, given context
		 *
		 * @param string|bool $context Context of the orderby clause.
		 * @return array Array of valid order by values.
		 */
		protected function get_valid_orderby( $context = false ) {
			if ( $context && isset( $this->orderby[ $context ] ) ) {
				return $this->orderby[ $context ];
			} elseif ( 0 === count( array_filter( array_keys( $this->orderby ), 'is_string' ) ) ) {
				return $this->orderby;
			}

			return array();
		}

		/**
		 * Generate data structure used by methods of this class to create queries
		 *
		 * @param WC_Data $object       Data object.
		 * @param bool    $changes_only Create structure only for updated fields.
		 *
		 * @return array Structure containing details about the query, in the following format
		 * [
		 *     'columns' => array(), // each of table columns
		 *     'types' => array(),   // type for each column
		 *     'values' => array()   // value for each column, retrieved from the data object
		 * ]
		 */
		protected function generate_query_structure( $object, $changes_only = true ) {
			$columns = array();
			$types   = array();
			$values  = array();
			$changes = $object->get_changes();

			foreach ( $this->columns as $column_name => $column_type ) {
				$prop = $this->get_column_prop_name( $column_name );

				if ( $changes_only && ! array_key_exists( $prop, $changes ) ) {
					continue;
				}

				$value = $this->get_prop_value( $object, $prop );

				$columns[] = $column_name;
				$types[]   = $value || ! in_array( $column_name, $this->nullable, true ) ? $column_type : 'NULL';

				if ( $value || ! in_array( $column_name, $this->nullable, true ) ) {
					$values[] = $value;
				}
			}

			return compact( 'columns', 'types', 'values' );
		}

		/**
		 * Generate orderby clause starting from data submitted for the query
		 *
		 * @param string|array $orderby Order by value; can be a simple column name, or an array containing a list of columns
		 *                              In the array, each column can also specify values (for a FILED ordering) and order, to use instead of general one.
		 * @param string       $order   Order value.
		 * @param string|bool  $context Context for the orderby clause.
		 *
		 * @return string Order by clause.
		 */
		protected function generate_query_orderby_clause( $orderby, $order, $context = false ) {
			$orderby = (array) $orderby;
			$order   = strtoupper( $order );
			$clause  = '';

			if ( ! in_array( $order, array( 'ASC', 'DESC' ), true ) ) {
				$order = 'DESC';
			}

			$orders = $this->get_valid_orderby( $context );

			foreach ( $orderby as $order_key => $order_value ) {
				if ( is_string( $order_value ) && in_array( $order_value, $orders, true ) ) {
					$clause .= " {$order_value} {$order},";
				} elseif ( in_array( $order_key, $orders, true ) ) {
					if ( in_array( $order_value, array( 'ASC', 'DESC' ), true ) ) {
						$clause .= " {$order_key} {$order_value},";
					} elseif ( ! empty( $order_value ) && is_array( $order_value ) ) {
						if ( isset( $order_value['values'] ) ) {
							$field_values = $order_value['values'];
							$field_order  = isset( $order_value['order'] ) ? $order_value['order'] : $order;
						} else {
							$field_values = $order_value;
							$field_order  = $order;
						}

						$clause .= " FIELD( {$order_key}, " . implode( ', ', $field_values ) . " ) {$field_order},";
					}
				}
			}

			if ( empty( $clause ) ) {
				return '';
			}

			$clause = ' ORDER BY ' . rtrim( $clause, ',' );

			return $clause;
		}

		/**
		 * Returns value for a specific object prop
		 *
		 * @param WC_Data $object Data object.
		 * @param string  $prop   Prop to retrieve.
		 *
		 * @return mixed Value of the prop retrieved from the object
		 */
		protected function get_prop_value( $object, $prop ) {
			$method = "get_$prop";

			if ( ! method_exists( $object, $method ) ) {
				return false;
			}

			return $object->$method();
		}

		/**
		 * Returns pagination parameters for current query
		 *
		 * @param array $args Array of query arguments (@see \YITH_WCAF_Affiliate_Data_Store::query).
		 *
		 * @return array Array of pagination data.
		 */
		protected function get_pagination_data( $args ) {
			if ( empty( $args['limit'] ) || 0 >= (int) $args['limit'] ) {
				return array();
			}

			return array(
				'per_page' => (int) $args['limit'],
				'offset'   => isset( $args['offset'] ) ? (int) $args['offset'] : 0,
				'items'    => $this->count( $args ),
			);
		}
	}
}
