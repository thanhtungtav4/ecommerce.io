<?php
/**
 * Affiliate Dashboard class - My Account endpoint
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Dashboard_My_Account' ) ) {
	/**
	 * Offer methods related to affiliate dashboard page
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Dashboard_My_Account extends YITH_WCAF_Abstract_Dashboard {

		/**
		 * Stores unique endpoint for My Account page that will make as gateway for all Affiliate Dashboard sections
		 *
		 * @var string
		 */
		protected static $default_endpoint = 'affiliate-dashboard';

		/**
		 * Constructor method
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// init dashboard page.
			add_filter( 'woocommerce_account_menu_items', array( $this, 'add_menu_items' ) );
			add_filter( 'woocommerce_account_menu_item_classes', array( $this, 'add_menu_item_classes' ), 10, 2 );
			add_filter( 'woocommerce_get_breadcrumb', array( $this, 'filter_breadcrumb' ) );
			add_filter( 'woocommerce_account_endpoint_page_not_found', array( $this, 'endpoint_page_not_found' ) );

			// init special query vars for My Account page.
			$this->init_query_vars();

			parent::__construct();
		}

		/* === ENDPOINTS METHODS === */

		/**
		 * Checks if current url contains default my-account dashboard endpoint
		 *
		 * @return bool
		 */
		public static function is_default_endpoint() {
			global $wp;

			return isset( $wp->query_vars[ self::$default_endpoint ] );
		}

		/**
		 * Returns filtered version of default endpoint (useful when you can to change endpoint)
		 *
		 * @return string
		 */
		public static function get_default_endpoint() {
			/**
			 * APPLY_FILTERS: yith_wcaf_my_account_default_endpoint
			 *
			 * Filters the default endpoint.
			 *
			 * @param string $default_endpoint Default endpoint.
			 */
			return apply_filters( 'yith_wcaf_my_account_default_endpoint', wc_sanitize_endpoint_slug( self::$default_endpoint ) );
		}

		/**
		 * Returns rewrite for any given endpoint
		 * Under My Account page, Dashboard endpoints have different rewrite, in order to be subitems of {@see \YITH_WCAF_Dashboard_My_Account::$default_endpoint}
		 *
		 * @param string $endpoint Endpoint key.
		 * @return string Endpoint rewrite
		 */
		public static function get_endpoint_rewrite( $endpoint ) {
			$default = self::get_default_endpoint();
			$rewrite = parent::get_endpoint_rewrite( $endpoint );

			/**
			 * APPLY_FILTERS: yith_wcaf_my_account_endpoint_rewrite
			 *
			 * Filters the rewrite for a given endpoint.
			 *
			 * @param string $rewrite Endpoint rewrite.
			 * @param string $endpoint Endpoint key.
			 */
			return apply_filters( 'yith_wcaf_my_account_endpoint_rewrite', "$default/$rewrite", $endpoint );
		}

		/* === PAGE METHODS === */

		/**
		 * Get dashboard page id
		 *
		 * @return int Dashboard page id.
		 */
		public function get_dashboard_page_id() {
			$dashboard_page_id = wc_get_page_id( 'myaccount' );

			if ( ! $dashboard_page_id ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_page_id
			 *
			 * Filters the id of the Affiliate Dashboard page.
			 *
			 * @param int $dashboard_page_id Affiliate Dashboard page id.
			 */
			return apply_filters( 'yith_wcaf_dashboard_page_id', $dashboard_page_id );
		}

		/**
		 * Return affiliate dashboard url
		 *
		 * @param string $endpoint Optional endpoint of the page.
		 * @param string $value    Optional value to pass to the endpoint.
		 *
		 * @return string Dashboard url, or home url if no dashboard page is set
		 * @since 1.0.0
		 */
		public function get_dashboard_base_url( $endpoint = '', $value = '' ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_base_url
			 *
			 * Filters the base url for the Affiliate Dashboard.
			 *
			 * @param string $base_url Base url.
			 */
			return apply_filters( 'yith_wcaf_dashboard_base_url', wc_get_page_permalink( 'myaccount' ) );
		}

		/**
		 * Returns true if current page is Affiliate Dashboard page
		 *
		 * @return bool Whether current page is Affiliate Dashboard page
		 * @since 1.2.2
		 */
		public function is_dashboard_page() {
			/**
			 * APPLY_FILTERS: yith_wcaf_is_dashboard_page
			 *
			 * Filters whether the current page is the Affiliate Dashboard page.
			 *
			 * @param bool $is_affiliate_dashboard Whether the page is the Affiliate Dashboard or not.
			 */
			return apply_filters( 'yith_wcaf_is_dashboard_page', is_account_page() && ( self::is_default_endpoint() || ! ! self::get_current_dashboard_endpoint() ) );
		}

		/* === INIT DASHBOARD PAGE === */

		/**
		 * Filters breadcrumb for Affiliate Dashboard page
		 *
		 * @param array $crumbs Default WooCommerce crumbs.
		 * @return array Filtered array crumbs
		 */
		public function filter_breadcrumb( $crumbs ) {
			if ( ! self::is_dashboard_page() ) {
				return $crumbs;
			}

			$account_permalink = wc_get_page_permalink( 'myaccount' );

			foreach ( $crumbs as & $crumb ) {
				if ( $crumb[1] && $crumb[1] === $account_permalink ) {
					$crumb[1] = $this->get_dashboard_url();
				}
			}

			return $crumbs;
		}

		/**
		 * Filter endpoint title, for affiliates endpoints
		 *
		 * @param string $endpoint_title Original endpoint title.
		 * @return string Filtered endpoint title.
		 */
		public function filter_endpoint_title( $endpoint_title ) {
			$current_endpoint = self::get_current_dashboard_endpoint();

			if ( $current_endpoint ) {
				$endpoints      = YITH_WCAF_Endpoints::get_dashboard_endpoints();
				$endpoint_title = $endpoints[ $current_endpoint ];
			} else {
				$endpoint_title = _x( 'Affiliate Dashboard', '[FRONTEND] My account page title for Affiliate Dashboard', 'yith-woocommerce-affiliates' );
			}

			return $endpoint_title;
		}

		/**
		 * Init WC query vars
		 *
		 * @return void
		 */
		public function init_query_vars() {
			$query = WC()->query;

			if ( ! $query ) {
				return;
			}

			$endpoints = self::get_dashboard_endpoints();

			if ( ! empty( $endpoints ) ) {
				foreach ( $endpoints as $endpoint => $label ) {
					$query->query_vars[ $endpoint ] = self::get_endpoint_rewrite( $endpoint );

					add_action( 'woocommerce_account_' . $endpoint . '_endpoint', array( $this, 'print_content' ) );
					add_filter( 'woocommerce_endpoint_' . $endpoint . '_title', array( $this, 'filter_endpoint_title' ) );
				}
			}

			$query->query_vars[ self::$default_endpoint ] = self::get_default_endpoint();

			add_action( 'woocommerce_account_' . self::$default_endpoint . '_endpoint', array( $this, 'print_content' ) );
			add_action( 'woocommerce_endpoint_' . self::$default_endpoint . '_title', array( $this, 'filter_endpoint_title' ) );
		}

		/**
		 * Add menu items to My Account page
		 *
		 * @param array $menu_items Existing menu items.
		 * @return array Filtered menu items
		 */
		public function add_menu_items( $menu_items ) {
			// adds Affiliate Dashboard endpoint.
			$menu_items[ self::$default_endpoint ] = _x( 'Affiliate Dashboard', '[FRONTEND] My Account menu item', 'yith-woocommerce-affiliates' );

			// if we're on affiliate dashboard endpoint, add also subsections.
			/**
			 * APPLY_FILTERS: yith_wcaf_myaccount_dashboard_add_extended_items
			 *
			 * Filters whether to add subsections in the Affiliate Dashboard endpoint.
			 *
			 * @param bool $add_subsections Whether to add subsections in the Affiliate Dashboard endpoint or not.
			 */
			if ( ! apply_filters( 'yith_wcaf_myaccount_dashboard_add_extended_items', false ) || ! $this->is_dashboard_page() ) {
				return $menu_items;
			}

			$affiliate_menu_items = $this->get_dashboard_navigation_menu();

			if ( ! empty( $affiliate_menu_items ) ) {
				foreach ( $affiliate_menu_items as $endpoint => $options ) {
					// we already added dashboard endpoint, which has its unique handling.
					if ( 'summary' === $endpoint ) {
						continue;
					}

					$menu_items[ $endpoint ] = $options['label'];
				}
			}

			return $menu_items;
		}

		/**
		 * Add classes to Affiliate Dashboard's menu item on My Account navigation.
		 *
		 * @param array  $classes  Original item's classes.
		 * @param string $endpoint Current endpoint.
		 *
		 * @return array Filtered array of classes;
		 */
		public function add_menu_item_classes( $classes, $endpoint ) {
			$endpoints = self::get_dashboard_endpoints();

			if ( ! apply_filters( 'yith_wcaf_myaccount_dashboard_add_extended_items', false ) && self::$default_endpoint === $endpoint && $this->is_dashboard_page() ) {
				$classes[] = 'is-active';
			}

			if ( array_key_exists( $endpoint, $endpoints ) ) {
				$classes[] = 'yith-wcaf-dashboard-navigation-link';
				$classes[] = 'yith-wcaf-dashboard-navigation-child';
			}

			return $classes;
		}

		/**
		 * Print endpoint content
		 * Just print affiliate dashboard shortcode for all endpoints, as shortcode will check query-vars
		 * and output correct content
		 */
		public function print_content() {
			echo do_shortcode( '[yith_wcaf_affiliate_dashboard]' );
		}

		/**
		 * Disable 404 error on plugin's endpoint when not in My Account page
		 *
		 * @param bool $not_found Whether we should return 404 error or not.
		 * @return bool Whether we should return 404 error or not.
		 */
		public function endpoint_page_not_found( $not_found ) {
			if ( self::is_dashboard_endpoint() ) {
				return false;
			}

			return $not_found;
		}
	}
}
