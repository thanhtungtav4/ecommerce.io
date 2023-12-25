<?php
/**
 * Static class that will perform required operations to offer support for WPML plugin suite
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_WPML_Compatibility' ) ) {
	/**
	 * This class is only included when WPML is active
	 * It adds options and functionality to make YITH WooCommerce Affiliates work on multi-language environment
	 * set up with WPML plugins suite
	 *
	 * WARNING: no multi-currency is currently offered.
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_WPML_Compatibility {

		/**
		 * Performs all required add_actions to init class
		 */
		public static function init() {
			add_filter( 'yith_wcaf_use_dashboard_pretty_permalinks', '__return_false' );
			add_filter( 'yith_wcaf_dashboard_page_id', array( self::class, 'translate_dashboard_page' ) );
		}

		/**
		 * Filter dashboard page id to show content in current language
		 *
		 * @param int $dashboard_page_id Dashboard page id.
		 * @return int Translated page id.
		 */
		public static function translate_dashboard_page( $dashboard_page_id ) {
			if ( function_exists( 'wpml_object_id_filter' ) ) {
				$dashboard_page_id = wpml_object_id_filter( $dashboard_page_id, 'page', true );
			} elseif ( function_exists( 'icl_object_id' ) ) {
				$dashboard_page_id = icl_object_id( $dashboard_page_id, 'page', true );
			}

			return $dashboard_page_id;
		}
	}
}
