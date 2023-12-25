<?php
/**
 * Endpoint related functions and actions.
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 2.0.0
 */

defined( 'YITH_WCAF' ) || exit;

if ( ! class_exists( 'YITH_WCAF_Endpoints' ) ) {
	/**
	 * Endpoint class
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Endpoints {

		/**
		 * Available endpoints
		 *
		 * @var array
		 */
		protected static $available_endpoints = array();

		/**
		 * Hooks actions required to install endpoints
		 *
		 * @return void
		 */
		public static function init() {
			// install endpoints.
			add_action( 'init', array( self::class, 'install_endpoints' ) );

			// register query vars.
			add_filter( 'query_vars', array( self::class, 'add_query_vars' ), 0 );
		}

		/* === HELPER METHODS === */

		/**
		 * Returns an array of filtered available endpoints
		 *
		 * @return array Array of available endpoints
		 * @since 1.3.0
		 */
		public static function get_available_endpoints() {
			/**
			 * Doing it wrong added to prevent \YITH_WCAF_Endpoints::get_dashboard_endpoints from being called before \YITH_WCAF_install::init
			 *
			 * @since 1.6.4
			 */
			if ( ! did_action( 'init' ) ) {
				_doing_it_wrong( 'get_dashboard_endpoints', '\YITH_WCAF_Endpoints::get_dashboard_endpoints should be called after init', '1.6.4' );
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_get_available_endpoints
			 *
			 * Filters the available endpoints in the Affiliate Dashboard.
			 *
			 * @param array $available_endpoints Available endpoints.
			 */
			return apply_filters( 'yith_wcaf_get_available_endpoints', self::maybe_init_available_endpoints() );
		}

		/**
		 * Return current dashboard endpoint
		 *
		 * @return string|bool Current request endpoint, or false if none set
		 * @since 1.0.0
		 */
		public static function get_current_endpoint() {
			global $wp;

			foreach ( self::get_available_endpoints() as $endpoint => $title ) {
				if ( isset( $wp->query_vars[ $endpoint ] ) ) {
					return $endpoint;
				}
			}

			return false;
		}

		/**
		 * Returns endpoints specifically defined for Affiliate Dashboard
		 *
		 * @eturn array Array of dashboard endpoints
		 */
		public static function get_dashboard_endpoints() {
			// all available endpoints are dashboard endpoints, at least for now.
			/**
			 * APPLY_FILTERS: yith_wcaf_get_dashboard_endpoints
			 *
			 * Filters the available dashboard endpoints.
			 *
			 * @param array $available_endpoints Available endpoints.
			 */
			return apply_filters( 'yith_wcaf_get_dashboard_endpoints', self::get_available_endpoints() );
		}

		/**
		 * Returns rewrite for a specific endpoint
		 * By default rewrite is just the same as endpoint, but third party code may change this bahaveiour using
		 * yith_wcaf_endpoint_rewrite filter
		 * My Account dashboard will change default endpoint rewrite for usage in Account page
		 *
		 * @param string $endpoint Endpoint slug.
		 * @return string|bool Rewrite for the submitted endpoint, or false if endpoint isn't recognized
		 */
		public static function get_endpoint_rewrite( $endpoint ) {
			if ( ! $endpoint || ! array_key_exists( $endpoint, self::get_available_endpoints() ) ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_endpoint_rewrite
			 *
			 * Filters the rewrite for a specific endpoint.
			 *
			 * @param string $endpoint Endpoint rewrite.
			 */
			return wc_sanitize_endpoint_slug( apply_filters( 'yith_wcaf_endpoint_rewrite', $endpoint, $endpoint ) );
		}

		/* === INIT ENDPOINTS === */

		/**
		 * Register plugins query vars
		 *
		 * @param mixed $vars Available query vars.
		 *
		 * @return mixed Filtered query vars
		 * @since 1.0.0
		 */
		public static function add_query_vars( $vars ) {
			foreach ( self::get_available_endpoints() as $endpoint => $title ) {
				$vars[] = $endpoint;
			}

			return $vars;
		}

		/**
		 * Init available endpoints, and return base array.
		 *
		 * @return array
		 */
		public static function maybe_init_available_endpoints() {
			// if we didn't already, register default endpoints.
			if ( empty( self::$available_endpoints ) ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_available_endpoints
				 *
				 * Filters the available endpoints in the Affiliate Dashboard.
				 *
				 * @param array $available_endpoints Available endpoints.
				 */
				self::$available_endpoints = apply_filters(
					'yith_wcaf_available_endpoints',
					array_merge(
						array(
							'commissions' => _x( 'Commissions', '[GLOBAL] Endpoint title', 'yith-woocommerce-affiliates' ),
						),
						function_exists( 'YITH_WCAF_Clicks' ) && YITH_WCAF_Clicks()->are_hits_registered() ? array(
							'clicks' => _x( 'Visits', '[GLOBAL] Endpoint title', 'yith-woocommerce-affiliates' ),
						) : array(),
						function_exists( 'YITH_WCAF_Coupons' ) && YITH_WCAF_Coupons()->are_coupons_enabled() ? array(
							'coupons' => _x( 'Coupons', '[GLOBAL] Endpoint title', 'yith-woocommerce-affiliates' ),
						) : array(),
						array(
							'payments'      => _x( 'Payments', '[GLOBAL] Endpoint title', 'yith-woocommerce-affiliates' ),
							'generate-link' => _x( 'Link generator', '[GLOBAL] Endpoint title', 'yith-woocommerce-affiliates' ),
							'settings'      => _x( 'Settings', '[GLOBAL] Endpoint title', 'yith-woocommerce-affiliates' ),
						)
					)
				);
			}

			// return available endpoints.
			return self::$available_endpoints;
		}

		/**
		 * Install available endpoints
		 *
		 * @return void
		 */
		public static function install_endpoints() {
			foreach ( self::get_available_endpoints() as $endpoint => $title ) {
				add_rewrite_endpoint( self::get_endpoint_rewrite( $endpoint ), EP_ROOT | EP_PAGES );
			}

			/**
			 * Flush rewrite rule only on specific conditions (flush can be very expensive operation, and should be avoided
			 * as long as possible)
			 *
			 * @since 1.3.0 Added option _yith_wcaf_flush_rewrite_rules; developers can set it to true, to force rewrite
			 * rules flush on next page load
			 *
			 * @since 2.0.0 No db check performed any longer, only condition that triggers flush is _yith_wcaf_flush_rewrite_rules
			 * option; plugin sets this to true internally when updating db.
			 */
			if ( ! get_option( '_yith_wcaf_flush_rewrite_rules', false ) ) {
				return;
			}

			update_option( '_yith_wcaf_flush_rewrite_rules', false );
			flush_rewrite_rules();
		}

	}
}
