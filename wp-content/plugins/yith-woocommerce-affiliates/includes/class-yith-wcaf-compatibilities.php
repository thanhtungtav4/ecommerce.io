<?php
/**
 * Static class that will handle compatibilities with third party plugins
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Compatibilities' ) ) {
	/**
	 * Affiliates Compatibilities Handler
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Compatibilities {

		/**
		 * Available compatibilities
		 *
		 * @var array
		 */
		protected static $compatibilities = array();

		/**
		 * Performs all required add_actions to handle compatibilities
		 *
		 * @return void
		 */
		public static function init() {
			$compatibilities = self::get_compatibilities();

			if ( empty( $compatibilities ) ) {
				return;
			}

			foreach ( $compatibilities as $plugin_id => $compatibility_details ) {
				if ( isset( $compatibility_details['condition'] ) && ! call_user_func( $compatibility_details['condition'] ) ) {
					continue;
				}
				if ( isset( $compatibility_details['class'] ) ) {
					$class_name = $compatibility_details['class'];
				} else {
					$plugin_name = str_replace( '-', '_', $plugin_id );
					$class_name  = "YITH_WCAF_{$plugin_name}_Compatibility";
				}

				if ( ! class_exists( $class_name ) ) {
					continue;
				}

				$class_name::init();
			}
		}

		/**
		 * Returns available compatibilities
		 *
		 * @return array
		 */
		public static function get_compatibilities() {
			if ( empty( self::$compatibilities ) ) {
				self::$compatibilities = array(
					'wpml'                          => array(
						'condition' => function() {
							return defined( 'ICL_PLUGIN_PATH' );
						},
					),
					'yith-woocommerce-subscription' => array(
						'condition' => function() {
							return class_exists( 'YWSBS_Subscription' );
						},
					),
					'woocommerce-subscription'      => array(
						'condition' => function() {
							return class_exists( 'WC_Subscription' );
						},
					),
				);
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_compatibilities
			 *
			 * Filters the available plugin compatibilities.
			 *
			 * @param array $compatibilities Available compatibilities.
			 */
			return apply_filters( 'yith_wcaf_compatibilities', self::$compatibilities );
		}
	}
}
