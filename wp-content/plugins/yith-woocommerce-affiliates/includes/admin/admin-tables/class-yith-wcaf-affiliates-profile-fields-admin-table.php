<?php
/**
 * Affiliate Profile Fields Table class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliates_Profile_Fields_Admin_Table' ) ) {
	/**
	 * WooCommerce Affiliates Table
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Affiliates_Profile_Fields_Admin_Table extends YITH_WCAF_Abstract_Admin_Table {
		/**
		 * Class constructor method
		 *
		 * @param array $args Arguments for the parent constructor.
		 * @since 1.0.0
		 */
		public function __construct( $args = array() ) {
			// Set parent defaults.
			parent::__construct(
				array_merge(
					$args,
					array(
						'singular'      => 'affiliate-field',
						'plural'        => 'affiliate-fields',
						'ajax'          => false,
						'empty_message' => _x( 'Sorry! There is no field registered yet.', '[ADMIN] Affiliate empty table message', 'yith-woocommerce-affiliates' ),
					)
				)
			);
		}

		/**
		 * Returns content for column Name
		 *
		 * @param array $item Current item.
		 * @return string Column content.
		 */
		public function column_name( $item ) {
			if ( empty( $item['name'] ) ) {
				return _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			}

			$column = $item['name'];

			if ( $item['admin_tooltip'] ) {
				$column .= wc_help_tip( $item['admin_tooltip'] );
			}

			return $column;
		}

		/**
		 * Returns content for column Type
		 *
		 * @param array $item Current item.
		 * @return string Column content.
		 */
		public function column_type( $item ) {
			$supported_types = YITH_WCAF_Affiliates_Profile::get_supported_field_types();

			if ( empty( $item['type'] ) ) {
				return _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			}

			if ( isset( $supported_types[ $item['type'] ] ) ) {
				return $supported_types[ $item['type'] ];
			}

			return ucfirst( $item['type'] );
		}

		/**
		 * Returns content for column Type
		 *
		 * @param array $item Current item.
		 * @return string Column content.
		 */
		public function column_label( $item ) {
			if ( empty( $item['label'] ) ) {
				return _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			}

			return wp_strip_all_tags( $item['label'] );
		}

		/**
		 * Returns content for column Type
		 *
		 * @param array $item Current item.
		 * @return string Column content.
		 */
		public function column_required( $item ) {
			if ( empty( $item['required'] ) ) {
				return '-';
			}

			return '<i class="yith-icon yith-icon-green-check-mark"></i>';
		}

		/**
		 * Returns content for column Enabled
		 *
		 * @param array $item Current item.
		 * @return string Column content.
		 */
		public function column_enabled( $item ) {
			$column = yith_plugin_fw_get_field(
				array(
					'id'                => '',
					'name'              => '',
					'value'             => ! empty( $item['enabled'] ) ? 'yes' : 'no',
					'type'              => 'onoff',
					'class'             => $item['reserved'] ? 'disabled' : '',
					'custom_attributes' => $item['reserved'] ? array( 'disabled' => true ) : array(),
				)
			);

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
				'name'     => _x( 'Name', '[ADMIN] Affiliates profile fields table headings', 'yith-woocommerce-affiliates' ),
				'type'     => _x( 'Type', '[ADMIN] Affiliates profile fields table headings', 'yith-woocommerce-affiliates' ),
				'label'    => _x( 'Label', '[ADMIN] Affiliates profile fields table headings', 'yith-woocommerce-affiliates' ),
				'required' => _x( 'Required', '[ADMIN] Affiliates profile fields table headings', 'yith-woocommerce-affiliates' ),
				'enabled'  => _x( 'Active', '[ADMIN] Affiliates profile fields table headings', 'yith-woocommerce-affiliates' ),
			);

			return $columns;
		}

		/**
		 * Returns hidden columns for current table
		 *
		 * @return mixed Array of hidden columns
		 * @since 1.0.0
		 */
		public function get_hidden_columns() {
			return array();
		}

		/**
		 * Generates content for a single row of the table.
		 *
		 * @since 3.1.0
		 *
		 * @param array $item Current item row.
		 */
		public function single_row( $item ) {
			echo '<tr class="affiliate-field-item" data-id="' . esc_attr( $item['name'] ) . '" data-item="' . esc_attr( wc_esc_json( wp_json_encode( $item ) ) ) . '">';
			$this->single_row_columns( $item );
			echo '</tr>';
		}

		/**
		 * Prepare items for table
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function prepare_items() {
			// sets columns headers.
			$columns  = $this->get_columns();
			$hidden   = $this->get_hidden_columns();
			$sortable = $this->get_sortable_columns();

			$this->_column_headers = array( $columns, $hidden, $sortable );

			// retrieve data for table.
			$this->items = YITH_WCAF_Affiliates_Profile::get_fields();
		}
	}
}
