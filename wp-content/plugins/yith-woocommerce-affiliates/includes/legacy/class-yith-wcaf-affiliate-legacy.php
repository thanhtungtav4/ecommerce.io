<?php
/**
 * Affiliate class - LEGACY
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes\Legacy
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliate_Legacy' ) ) {
	/**
	 * Legacy Affiliate
	 *
	 * @deprecated 2.0.0
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Affiliate_Legacy extends YITH_WCAF_Abstract_Object {

		/**
		 * Return current ref variable name
		 *
		 * @return string Ref variable name
		 * @since 1.0.0
		 */
		public static function get_ref_name() {
			_deprecated_function( __FUNCTION__, '2.0.0', '\YITH_WCAF_Session::get_ref_name' );

			return YITH_WCAF_Session()->get_ref_name();
		}

		/**
		 * Return token origin (cookie/query-string/constructor)
		 *
		 * @return string|bool Current token origin; false if none set
		 * @since 1.0.0
		 */
		public static function get_token_origin() {
			_deprecated_function( __FUNCTION__, '2.0.0', '\YITH_WCAF_Session::get_token_origin' );

			return YITH_WCAF_Session()->get_token_origin();
		}

		/**
		 * Return current affiliate data
		 *
		 * @return mixed Current affiliate user; false if none set
		 * @since 1.0.0
		 */
		public static function get_affiliate() {
			_deprecated_function( __FUNCTION__, '2.0.0', '\YITH_WCAF_Session::get_affiliate' );

			return YITH_WCAF_Session()->get_affiliate();
		}

		/**
		 * Executes again _retrieve_token()
		 * Please, note that this method should be called *ALWAYS* before template_redirect, as this is the last safe hook
		 * to set a cookie (_retrieve_token() calls set cookie)
		 *
		 * @return bool/string New token retrieved; false if something went wrong
		 * @since 1.0.9
		 */
		public static function reset_token() {
			_deprecated_function( __FUNCTION__, '2.0.0', '\YITH_WCAF_Session::reset_token' );

			return YITH_WCAF_Session()->reset_token();
		}

		/**
		 * Returns single instance of the class
		 *
		 * @param string $token Affiliate token.
		 *
		 * @return \YITH_WCAF_Affiliate
		 * @since 1.0.2
		 */
		public static function get_instance( $token = null ) {
			_deprecated_function( __FUNCTION__, '2.0.0', 'methods from \YITH_WCAF_Affiliate_Factory class' );

			if ( $token ) {
				$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate( (string) $token );
			} else {
				$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate( 'session' );
			}

			// return empty object when no occurrence found.
			if ( ! $affiliate ) {
				return new YITH_WCAF_Affiliate();
			}

			return $affiliate;
		}
	}
}

/**
 * Create class alias, to allow for interaction with the legacy class, with its previous name.
 *
 * @since 2.0.0
 */
class_alias( 'YITH_WCAF_Affiliate_Legacy', 'YITH_WCAF_Affiliate_Premium' );

/**
 * Unique access to instance of YITH_WCAF_Affiliate_Legacy class
 *
 * @param string $token Unique affiliate token.
 *
 * @return \YITH_WCAF_Affiliate_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Affiliate( $token = null ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	_deprecated_function( __FUNCTION__, '2.0.0', 'methods from \YITH_WCAF_Affiliate_Factory class' );

	return YITH_WCAF_Affiliate::get_instance( $token );
}

/**
 * Unique access to instance of YITH_WCAF_Affiliate_Legacy class
 *
 * @param string $token Unique affiliate token.
 *
 * @return \YITH_WCAF_Affiliate_Legacy
 * @since 1.0.0
 */
function YITH_WCAF_Affiliate_Premium( $token = null ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCAF_Affiliate( $token );
}
