<?php
/**
 * Affiliate Dashboard shortcode - Clicks
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Show_Clicks_Shortcode' ) ) {
	/**
	 * Offer methods for basic shortcode handling
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Show_Clicks_Shortcode extends YITH_WCAF_Show_Summary_Shortcode {

		/* === INIT === */

		/**
		 * Performs any required init operation
		 */
		public function init() {
			// configure shortcode basics.
			$this->tag         = 'yith_wcaf_show_clicks';
			$this->title       = _x( 'YITH Show Visits', '[BUILDERS] Shortcode name', 'yith-woocommerce-affiliates' );
			$this->section     = 'clicks';
			$this->template    = "dashboard-{$this->section}.php";
			$this->description = _x( 'Show affiliate visits to your affiliates', '[BUILDERS] Shortcode description', 'yith-woocommerce-affiliates' );
			$this->supports    = array();
		}

		/* === SECTION HANDLING === */

		/**
		 * Filters variable submitted to template, in order to add section-specific values
		 *
		 * @param array $atts General shortcode attributes, as entered for the shortcode, or as default values.
		 *
		 * @return array Array of filtered template variables.
		 */
		public function get_template_atts( $atts ) {
			$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();

			// retrieves filters form query string.
			if ( isset( $_GET['security'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['security'] ) ), 'filter_items' ) ) {
				$status      = isset( $_GET['status'] ) && in_array( $_GET['status'], array( 'converted', 'not-converted' ), true ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : false;
				$from        = isset( $_GET['from'] ) ? sanitize_text_field( wp_unslash( $_GET['from'] ) ) : false;
				$to          = isset( $_GET['to'] ) ? sanitize_text_field( wp_unslash( $_GET['to'] ) ) : false;
				$orderby     = isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : false;
				$order       = isset( $_GET['order'] ) ? sanitize_text_field( wp_unslash( $_GET['order'] ) ) : false;
				$from        = $from ? gmdate( 'Y-m-d 00:00:00', strtotime( $from ) ) : false;
				$to          = $to ? gmdate( 'Y-m-d 23:59:59', strtotime( $to ) ) : false;
				$filters_set = true;
			} else {
				$status      = false;
				$from        = false;
				$to          = false;
				$orderby     = false;
				$order       = false;
				$filters_set = false;
			}

			$query_args = array_merge(
				array(
					'affiliate_id' => $affiliate->get_id(),
					'orderby'      => ! empty( $orderby ) ? $orderby : 'click_date',
					'order'        => ! empty( $order ) ? $order : 'DESC',
				),
				empty( $status ) ? array() : array(
					'converted' => 'converted' === $status ? 'yes' : 'no',
				),
				empty( $from ) && empty( $to ) ? array() : array(
					'interval' => array(
						'start_date' => $from,
						'end_date'   => $to,
					),
				),
				yith_plugin_fw_is_true( $atts['pagination'] ) ? $this->get_pagination_atts( $atts ) : array()
			);

			$clicks = YITH_WCAF_Click_Factory::get_clicks( $query_args );
			$count  = $clicks->get_total_items();

			/**
			 * APPLY_FILTERS: $tag_shortcode_template_atts
			 *
			 * Filters the array with the attritubes needed for the shortcode template.
			 * <code>$tag</code> will be replaced with the shortcode tag.
			 *
			 * @param array $shortcode_atts Attributes for the shortcode template.
			 */
			return apply_filters(
				"{$this->tag}_shortcode_template_atts",
				array_merge(
					$atts,
					compact( 'affiliate', 'clicks', 'filters_set', 'status', 'from', 'to', 'orderby', 'order', 'count' ),
					// backward compatibility: these attributes are submitted only to support old versions of the templates.
					array(
						'user_id'               => $affiliate->get_user_id(),
						'user'                  => $affiliate->get_user(),
						'affiliate_id'          => $affiliate->get_id(),
						'dashboard_clicks_link' => YITH_WCAF_Dashboard()->get_dashboard_url( 'clicks', 1 ),
						'to_order'              => 'DESC' === $order ? 'ASC' : 'DESC',
						/**
						 * APPLY_FILTERS: yith_wcaf_show_dashboard_links
						 *
						 * Filters whether to show the dashboard links in the Affiliate Dashboard.
						 *
						 * @param bool   $show_dashboard_links Whether to show the dashboard links or not.
						 * @param string $section              Affiliate dashboard section.
						 */
						'show_right_column'     => apply_filters( 'yith_wcaf_show_dashboard_links', yith_plugin_fw_is_true( $atts['show_dashboard_links'] ), 'dashboard_clicks' ),
						'dashboard_links'       => YITH_WCAF_Dashboard()->get_dashboard_navigation_menu(),
						'filter_set'            => $filters_set,
						'ordered'               => $orderby,
						'page_links'            => $this->get_paginate_links( $this->get_current_page(), ceil( $count / $atts['per_page'] ) ),
					)
				)
			);
		}
	}
}
