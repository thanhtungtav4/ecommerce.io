<?php
/**
 * Affiliate Dashboard class - Dedicated page
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Dashboard_Page' ) ) {
	/**
	 * Offer methods related to affiliate dashboard page
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Dashboard_Page extends YITH_WCAF_Abstract_Dashboard {

		/**
		 * Constructor method
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// init dashboard page.
			add_filter( 'the_title', array( $this, 'filter_title' ) );
			add_filter( 'woocommerce_get_breadcrumb', array( $this, 'filter_breadcrumb' ), 10 );
			add_action( 'template_redirect', array( $this, 'filter_headers' ) );

			parent::__construct();
		}

		/* === PAGE METHODS === */

		/**
		 * Get dashboard page id
		 *
		 * @return int|bool Dashboard page id, or false on failure.
		 */
		public function get_dashboard_page_id() {
			$dashboard_page_id = get_option( 'yith_wcaf_dashboard_page_id' );

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
		 * @return string|bool Dashboard url, or false on failure
		 * @since 1.0.0
		 */
		public function get_dashboard_base_url() {
			$dashboard_page_id = self::get_dashboard_page_id();

			if ( ! $dashboard_page_id ) {
				return false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_dashboard_base_url
			 *
			 * Filters the base url for the Affiliate Dashboard.
			 *
			 * @param string $base_url Base url.
			 */
			return apply_filters( 'yith_wcaf_dashboard_base_url', get_permalink( $dashboard_page_id ) );
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
			return apply_filters( 'yith_wcaf_is_dashboard_page', is_page( self::get_dashboard_page_id() ) );
		}

		/* === INIT DASHBOARD PAGE === */

		/**
		 * Filter dashboard pages title
		 *
		 * @param string $title Current page title.
		 *
		 * @return string Filtered page title
		 * @since 1.0.0
		 */
		public function filter_title( $title ) {
			global $wp_query;

			if ( ! is_null( $wp_query ) && ! is_admin() && is_main_query() && in_the_loop() && is_page() && $this->is_dashboard_page() ) {
				$current_endpoint = self::get_current_dashboard_endpoint();

				if ( $current_endpoint ) {
					$endpoints = YITH_WCAF_Endpoints::get_dashboard_endpoints();
					$title     = isset( $endpoints[ $current_endpoint ] ) ? $endpoints[ $current_endpoint ] : $title;
				}

				remove_filter( 'the_title', array( self::class, 'filter_title' ) );
			}

			return $title;
		}

		/**
		 * Filters breadcrumb for Affiliate Dashboard page
		 *
		 * @param array $crumbs Default WooCommerce crumbs.
		 * @return array Filtered array crumbs
		 */
		public function filter_breadcrumb( $crumbs ) {
			global $post;

			if ( ! self::is_dashboard_endpoint() ) {
				return $crumbs;
			}

			$current_endpoint = self::get_current_dashboard_endpoint();

			if ( $current_endpoint ) {
				$endpoints = YITH_WCAF_Endpoints::get_dashboard_endpoints();
				$title     = $endpoints[ $current_endpoint ];

				if ( $post ) {
					array_pop( $crumbs );

					$crumbs[] = array(
						$post->post_title,
						self::get_dashboard_url(),
					);
				}

				$crumbs[] = array(
					$title,
				);
			}

			return $crumbs;
		}

		/**
		 * Sends same origin header for Affiliate Dashboard page, to avoid it from being retrieved via i-frame
		 *
		 * @returns void
		 * @since 1.2.2
		 */
		public function filter_headers() {
			if ( $this->is_dashboard_page() ) {
				send_frame_options_header();
			}
		}
	}
}
