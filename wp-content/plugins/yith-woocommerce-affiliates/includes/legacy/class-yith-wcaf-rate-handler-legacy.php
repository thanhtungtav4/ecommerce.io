<?php
/**
 * Rate Handler class
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes\Legacy
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Rate_Handler_Legacy' ) ) {
	/**
	 * Legacy Rate Handler
	 *
	 * @deprecated
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Rate_Handler_Legacy {
		/**
		 * Single instance of the class for each token
		 *
		 * @var \YITH_WCAF_Rate_Handler_Legacy
		 * @since 1.0.0
		 */
		protected static $instance = null;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAF_Rate_Handler_Legacy
		 * @since 1.0.2
		 */
		public static function get_instance() {
			_deprecated_function( __METHOD__, '2.0.0', '\YITH_WCAF_Rate_Handler static class (no instance needed)' );

			return new YITH_WCAF_Rate_Handler();
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_Rate_Handler class
 *
 * @return \YITH_WCAF_Rate_Handler_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Rate_Handler() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	_deprecated_function( __FUNCTION__, '2.0.0', '\YITH_WCAF_Rate_Handler static class (no instance needed)' );

	return YITH_WCAF_Rate_Handler::get_instance();
}

/**
 * Unique access to instance of YITH_WCAF_Rate_Handler class
 *
 * @return \YITH_WCAF_Rate_Handler_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Rate_Handler_Premium() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Rate_Handler();
}
