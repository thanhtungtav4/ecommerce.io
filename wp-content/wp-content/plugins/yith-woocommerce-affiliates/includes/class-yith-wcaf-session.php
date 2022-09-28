<?php
/**
 * Affiliate Session class
 *
 * @author  YITH
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Session' ) ) {
	/**
	 * Offer methods to retrieve and set current affiliate
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Session {

		use YITH_WCAF_Trait_Singleton;

		/**
		 * Referral token variable name
		 *
		 * @var string
		 */
		protected $ref_name = 'ref';

		/**
		 * Referral cookie name
		 *
		 * @var string
		 */
		protected $ref_cookie_name = 'yith_wcaf_referral_token';

		/**
		 * Referral cookie expiration
		 *
		 * @var int
		 */
		protected $ref_cookie_exp = WEEK_IN_SECONDS;

		/**
		 * Stores current token
		 *
		 * @var string
		 */
		protected $token;

		/**
		 * Stores current token origin
		 *
		 * @var string
		 */
		protected $token_origin = '';

		/**
		 * Stores current affiliate, retrieved by query string, cookie, or other means
		 *
		 * @var YITH_WCAF_Affiliate
		 */
		protected $affiliate;

		/**
		 * Constructor method
		 *
		 * @return void
		 */
		public function __construct() {
			$this->retrieve_options();
			$this->get_token();
		}

		/* === GETTERS === */

		/**
		 * Get current token, whether from query string or cookie
		 * Returns false if no token is currently set
		 *
		 * @return string|bool Current token; false if no valid token is set
		 */
		public function get_token() {
			if ( is_null( $this->token ) ) {
				$query_var = $this->get_query_var();

				if ( $query_var ) {
					$token = $query_var;

					// sets token origin as query-string.
					$this->token_origin = 'query-string';
				} elseif ( $this->has_cookie() ) {
					$token = $this->get_cookie();

					// sets token origin as cookie.
					$this->token_origin = 'cookie';
				} else {
					$token              = false;
					$this->token_origin = false;
				}

				if ( ! YITH_WCAF_Affiliates()->is_valid_token( $token ) ) {
					$token = false;
				}

				$this->token = $token;
			}

			// sets cookie with current token.
			$this->set_cookie();

			return $this->token;
		}

		/**
		 * Returns token origin, if any is set.
		 *
		 * @return string|bool Token origin, if any is set; false otherwise.
		 */
		public function get_token_origin() {
			// retrieves token, if we didn't already.
			if ( is_null( $this->token ) ) {
				$this->get_token();
			}

			return $this->token_origin ? $this->token_origin : false;
		}

		/**
		 * Returns current affiliate, if any
		 *
		 * @return YITH_WCAF_Affiliate|bool Current affiliate, if any is set; false otherwise.
		 */
		public function get_affiliate() {
			if ( ! is_null( $this->affiliate ) ) {
				return $this->affiliate;
			}

			$token = $this->get_token();

			if ( ! $token ) {
				return false;
			}

			$this->affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_token( $token );

			return $this->affiliate;
		}

		/**
		 * Returns query var used to store referral token
		 *
		 * @return string Ref name.
		 */
		public function get_ref_name() {
			/**
			 * APPLY_FILTERS: yith_wcaf_ref_name
			 *
			 * Filters the parameter used in the url to store the referral token.
			 *
			 * @param string $param Parameter to store the referral token.
			 */
			return apply_filters( 'yith_wcaf_ref_name', $this->ref_name );
		}

		/**
		 * Returns value for the query string parameter, if set; false otherwise
		 *
		 * @return string|bool Token from query string, if set; false otherwise
		 */
		public function get_query_var() {
			// referral var cannot be passed with a nonce: ignore recommended check.
			// phpcs:disable WordPress.Security.NonceVerification
			$query_var = $this->get_ref_name();

			if ( ! isset( $_GET[ $query_var ] ) ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_session_get_query_var
			 *
			 * Filters the value stored in the query string for the referral token.
			 *
			 * @param string $value Referral token.
			 */
			return apply_filters( 'yith_wcaf_session_get_query_var', sanitize_text_field( wp_unslash( $_GET[ $query_var ] ) ) );
			// phpcs:enable WordPress.Security.NonceVerification
		}

		/**
		 * Init class attributes for admin options
		 *
		 * @return void
		 */
		protected function retrieve_options() {
			$make_cookie_expire = get_option( 'yith_wcaf_referral_make_cookie_expire', 'yes' );
			$cookie_expire      = get_option( 'yith_wcaf_referral_cookie_expire', $this->ref_cookie_exp );

			$this->ref_name        = get_option( 'yith_wcaf_referral_var_name', $this->ref_name );
			$this->ref_cookie_name = get_option( 'yith_wcaf_referral_cookie_name', $this->ref_cookie_name );
			$this->ref_cookie_exp  = 'yes' === $make_cookie_expire ? yith_wcaf_duration_to_secs( $cookie_expire ) : 15 * YEAR_IN_SECONDS;
		}

		/* === SETTERS === */

		/**
		 * Set a new session token, different from the one automatically retrieved by this class
		 *
		 * @param string $token        Token to set.
		 * @param string $token_origin Origin for current token.
		 * @param bool   $set_cookie   Whether to set cookie with new token or not.
		 *
		 * @return void.
		 */
		public function set_token( $token, $token_origin = 'constructor', $set_cookie = false ) {
			$this->token        = $token;
			$this->token_origin = $token_origin;
			$this->affiliate    = null;

			if ( $set_cookie ) {
				$this->set_cookie();
			}
		}

		/**
		 * Reset token and retrieve it again
		 *
		 * @return string|bool Current token; false if no valid token is set
		 */
		public function reset_token() {
			$this->token        = '';
			$this->token_origin = '';
			$this->affiliate    = null;

			return $this->get_token();
		}

		/* === COOKIE HANDLING === */

		/**
		 * Returns query var used to store referral token
		 *
		 * @return string Ref name.
		 */
		public function get_cookie_name() {
			/**
			 * APPLY_FILTERS: yith_wcaf_cookie_name
			 *
			 * Filters the referral cookie name.
			 *
			 * @param string $referral_cookie_name Referral cookie name.
			 */
			return apply_filters( 'yith_wcaf_cookie_name', $this->ref_cookie_name );
		}

		/**
		 * Returns value for the plugin referral cookie, if set; false otherwise
		 *
		 * @return string|bool Token from cookie, if set; false otherwise
		 */
		public function get_cookie() {
			$cookie_name = $this->get_cookie_name();

			if ( ! isset( $_COOKIE[ $cookie_name ] ) ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_session_get_cookie
			 *
			 * Filters the referral cookie value.
			 *
			 * @param string $cookie_value Referral cookie value.
			 */
			return apply_filters( 'yith_wcaf_session_get_cookie', sanitize_text_field( wp_unslash( $_COOKIE[ $cookie_name ] ) ) );
		}

		/**
		 * Returns true if referral cookie is set
		 *
		 * @return bool Whether referral cookie is set.
		 */
		public function has_cookie() {
			/**
			 * APPLY_FILTERS: yith_wcaf_session_has_cookie
			 *
			 * Filters whether the referral cookie has been set.
			 *
			 * @param bool $has_referral_cookie Whether the referral cookie is set or not.
			 */
			return apply_filters( 'yith_wcaf_session_has_cookie', ! empty( $_COOKIE[ $this->get_cookie_name() ] ) );
		}

		/**
		 * Send headers to delete referral cookie
		 *
		 * @return void
		 */
		public function delete_cookie() {
			if ( ! $this->has_cookie() ) {
				return;
			}

			yith_wcaf_delete_cookie( $this->get_cookie_name() );
		}

		/**
		 * Delete all sessions cookies
		 *
		 * @return void
		 */
		public function delete_cookies() {
			$this->delete_cookie();
		}

		/**
		 * Checks whether we should set cookie or not
		 *
		 * @return bool
		 */
		protected function should_set_cookie() {
			/**
			 * APPLY_FILTERS: yith_wcaf_set_ref_cookie
			 *
			 * Filters whether to set the referral cookie.
			 *
			 * @param bool $set_referral_cookie Whether to set referral cookie or not.
			 */
			return ! $this->has_cookie() || $this->token !== $this->get_cookie() && apply_filters( 'yith_wcaf_set_ref_cookie', true );
		}

		/**
		 * Set value for the plugin referral cookie, with current token
		 *
		 * @retun void
		 */
		protected function set_cookie() {
			if ( ! $this->token || ! $this->should_set_cookie() || headers_sent() ) {
				return;
			}

			yith_wcaf_set_cookie( $this->get_cookie_name(), $this->token, (int) $this->ref_cookie_exp );

			/**
			 * DO_ACTION: yith_wcaf_after_set_cookie
			 *
			 * Allows to trigger some action after the referral cookie has been set.
			 */
			do_action( 'yith_wcaf_after_set_cookie' );
		}
	}
}

if ( ! function_exists( 'YITH_WCAF_Session' ) ) {
	/**
	 * Retrieve unique instance of YITH_WCAF_Session class
	 *
	 * @return YITH_WCAF_Session|YITH_WCAF_Session_Premium
	 */
	function YITH_WCAF_Session() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
		return YITH_WCAF_Session::get_instance();
	}
}
