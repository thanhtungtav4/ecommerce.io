<?php
/**
 * Gateways Table class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Gateways_Admin_Table' ) ) {
	/**
	 * WooCommerce Affiliates Table
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Gateways_Admin_Table extends YITH_WCAF_Abstract_Admin_Table {
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
						'singular'      => 'gateway',
						'plural'        => 'gateways',
						'ajax'          => false,
						'empty_message' => _x( 'Sorry! There is no gateway registered yet.', '[ADMIN] Affiliate empty table message', 'yith-woocommerce-affiliates' ),
					)
				)
			);
		}

		/**
		 * Returns content for column Name
		 *
		 * @param YITH_WCAF_Abstract_Gateway $item Current item.
		 * @return string Column content.
		 */
		public function column_name( $item ) {
			if ( empty( $item->get_name() ) ) {
				return _x( 'N/A', '[ADMIN] Empty admin table column', 'yith-woocommerce-affiliates' );
			}

			return $item->get_name();
		}

		/**
		 * Returns content for column Availability
		 *
		 * @param YITH_WCAF_Abstract_Gateway $item Current item.
		 * @return string Column content.
		 */
		public function column_availability( $item ) {
			if ( ! $item->is_available() ) {
				return $item->why_not_available();
			}

			return '<i class="yith-icon yith-icon-green-check-mark"></i>';
		}

		/**
		 * Returns content for column Action
		 *
		 * @param YITH_WCAF_Abstract_Gateway $item Current item.
		 * @return string Column content.
		 */
		public function column_actions( $item ) {
			if ( ! $item->is_available() || ! $item->has_settings() ) {
				return '';
			}

			$available_actions = array(
				'edit' => array(
					'label' => _x( 'Edit', '[ADMIN] Gateways table', 'yith-woocommerce-affiliates' ),
					'icon'  => 'edit',
					'data'  => array(
						'action'   => 'get_gateway_edit_form',
						'security' => wp_create_nonce( 'get_gateway_edit_form' ),
					),
				),
			);

			$links = '';

			foreach ( $available_actions as $action_id => $action_details ) {
				$links .= yith_plugin_fw_get_component(
					array_merge(
						array(
							'type'  => 'action-button',
							'url'   => '#',
							'class' => $action_id,
						),
						$action_details
					),
					false
				);
			}

			return $links;
		}

		/**
		 * Returns content for column Enabled
		 *
		 * @param YITH_WCAF_Abstract_Gateway $item Current item.
		 * @return string Column content.
		 */
		public function column_enabled( $item ) {
			$column = yith_plugin_fw_get_field(
				array_merge(
					array(
						'id'    => '',
						'name'  => '',
						'value' => $item->is_enabled() ? 'yes' : 'no',
						'type'  => 'onoff',
					),
					$item->is_available() ? array() : array(
						'class'             => 'disabled',
						'custom_attributes' => array(
							'disabled' => 'disabled',
						),
					)
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
				'name'         => _x( 'Name', '[ADMIN] Gateways table headings', 'yith-woocommerce-affiliates' ),
				'availability' => _x( 'Available', '[ADMIN] Gateways table headings', 'yith-woocommerce-affiliates' ),
				'enabled'      => _x( 'Active', '[ADMIN] Gateways table headings', 'yith-woocommerce-affiliates' ),
				'actions'      => '',
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
		 * @param YITH_WCAF_Abstract_Gateway $item Current item row.
		 */
		public function single_row( $item ) {
			echo '<tr class="gateway-item" data-id="' . esc_attr( $item->get_id() ) . '" data-name="' . esc_attr( $item->get_name() ) . '">';
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
			$this->items = YITH_WCAF_Gateways::get_gateways();
		}
	}
}
