<?php
/**
 * Click Handler class - LEGACY
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes\Legacy
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Clicks_Legacy' ) ) {
	/**
	 * Legacy Clicks Handler
	 *
	 * @deprecated
	 * @since 1.0.0
	 */
	class YITH_WCAF_Clicks_Legacy {
		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAF_Clicks_Legacy
		 * @since 1.0.2
		 */
		public static function get_instance() {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Clicks' );

			return YITH_WCAF_Clicks::get_instance();
		}
	}
}

/**
 * Create class alias, to allow for interaction with the legacy class, with its previous name.
 *
 * @since 2.0.0
 */
class_alias( 'YITH_WCAF_Clicks_Legacy', 'YITH_WCAF_Click_Handler' );
class_alias( 'YITH_WCAF_Clicks_Legacy', 'YITH_WCAF_Click_Handler_Premium' );

/**
 * Unique access to instance of YITH_WCAF_Click_Handler class
 *
 * @deprecated 2.0.0
 *
 * @return \YITH_WCAF_Clicks_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Click_Handler() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	_deprecated_function( __FUNCTION__, '2.0.0', '\YITH_WCAF_Clicks' );

	return YITH_WCAF_Clicks::get_instance();
}

/**
 * Unique access to instance of YITH_WCAF_Click_Handler class
 *
 * @deprecated 2.0.0
 *
 * @return \YITH_WCAF_Clicks_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Click_Handler_Premium() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Click_Handler();
}
