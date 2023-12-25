<?php
/**
 * Settings admin panel handling
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Settings_Admin_Panel' ) ) {
	/**
	 * Affiliates admin panel handling
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Settings_Admin_Panel extends YITH_WCAF_Abstract_Admin_Panel {

		/**
		 * Current tab name
		 *
		 * @var string
		 */
		protected $tab = 'settings';

		/**
		 * Init Affiliates admin panel
		 */
		public function __construct() {
			// register custom fields.
			add_action( 'yith_wcaf_print_admin_duration_field', array( $this, 'print_duration_field' ), 10, 1 );

			// enqueue tab assets.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );

			add_action( 'yith_wcaf_print_profile_fields_list_tab', array( $this, 'render_profile_fields_list_table' ) );
			add_action('yith_wcaf_render_gateways_list_table', array( $this, 'render_gateways_list_table' ) );


			// call parent constructor.
			parent::__construct();
		}

		/**
		 * Render the Affiliates Profile fields List tab.
		 */
		public static function render_gateways_list_table() {
			$list_table = new YITH_WCAF_Gateways_Admin_Table();
			$list_table->prepare_items();
			$list_table->views();
			?>
            <div id="yith_wcaf_gateways">
				<?php $list_table->display(); ?>
            </div>
			<?php
		}


		/**
		 * Get instance for Affiliate Profile Fields list table.
		 *
		 * @return YITH_WCAF_Affiliates_Profile_Fields_Admin_Table
		 */
		public static function get_profile_fields_list_table() {
			return new YITH_WCAF_Affiliates_Profile_Fields_Admin_Table();
		}


		/**
		 * Render the Affiliates Profile fields List tab.
		 */
		public static function render_profile_fields_list_table() {
			$list_table = self::get_profile_fields_list_table();
			$list_table->prepare_items();
			$list_table->views();
			?>
			<div id="yith_wcaf_profile_fields">
				<?php $list_table->display(); ?>
			</div>
			<?php
		}


		/* === CUSTOM FIELDS === */

		/**
		 * Prints template for duration field
		 * Note this field is obtained with default fw inline-fields type; it is used as shortcut to avoid to set
		 * all the required options each time.
		 *
		 * @param array $field Array of options for current field.
		 */
		public function print_duration_field( $field ) {
			$field['value'] = yith_wcaf_secs_to_duration( $field['value'] );

			yith_plugin_fw_get_field(
				array_merge(
					$field,
					array(
						'type'   => 'inline-fields',
						'fields' => array(
							'amount' => array(
								'type'              => 'number',
								'custom_attributes' => array(
									'min'  => 1,
									'step' => 1,
								),
							),
							'unit'   => array(
								'type'    => 'select',
								'options' => self::get_time_units(),
							),
						),
					)
				),
				true
			);
		}

		/* === PANEL HANDLING === */

		/**
		 * Returns variable to localize for current panel
		 *
		 * @return array Array of variables to localize.
		 */
		public function get_localize() {
			$change_profile_field_status_nonce = wp_create_nonce( 'change_profile_field_status' );
			$change_gateway_status_nonce       = wp_create_nonce( 'change_gateway_status' );

			return array(
				'nonces' => array(
					'enable_profile_field'  => $change_profile_field_status_nonce,
					'disable_profile_field' => $change_profile_field_status_nonce,
					'enable_gateway'        => $change_gateway_status_nonce,
					'disable_gateway'       => $change_gateway_status_nonce,
					'save_gateway_options'  => wp_create_nonce( 'save_gateway_options' ),
				),
			);
		}

		/* === UTILS === */

		/**
		 * Get time units used across admin options.
		 *
		 * @return array Array of time units.
		 */
		public static function get_time_units() {
			$available_units = array(
				'sec'   => _x( 'Seconds', '[ADMIN] Duration field', 'yith-woocommerce-affiliates' ),
				'min'   => _x( 'Minutes', '[ADMIN] Duration field', 'yith-woocommerce-affiliates' ),
				'hour'  => _x( 'Hours', '[ADMIN] Duration field', 'yith-woocommerce-affiliates' ),
				'day'   => _x( 'Days', '[ADMIN] Duration field', 'yith-woocommerce-affiliates' ),
				'week'  => _x( 'Weeks', '[ADMIN] Duration field', 'yith-woocommerce-affiliates' ),
				'month' => _x( 'Months', '[ADMIN] Duration field', 'yith-woocommerce-affiliates' ),
			);

			return $available_units;
		}
	}
}
