<?php
/**
 * Affiliate Dashboard shortcode - Payments
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Show_Payments_Shortcode' ) ) {
	/**
	 * Offer methods for basic shortcode handling
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Show_Payments_Shortcode extends YITH_WCAF_Show_Summary_Shortcode {

		/* === INIT === */

		/**
		 * Performs any required init operation
		 */
		public function init() {
			// configure shortcode basics.
			$this->tag         = 'yith_wcaf_show_payments';
			$this->title       = _x( 'YITH Show Payments', '[BUILDERS] Shortcode name', 'yith-woocommerce-affiliates' );
			$this->section     = 'payments';
			$this->template    = "dashboard-{$this->section}.php";
			$this->description = _x( 'Show affiliate payments to your affiliates', '[BUILDERS] Shortcode description', 'yith-woocommerce-affiliates' );
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
				$status      = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : false;
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
					'orderby'      => ! empty( $orderby ) ? $orderby : 'created_at',
					'order'        => ! empty( $order ) ? $order : 'DESC',
				),
				empty( $status ) ? array() : array(
					'status' => $status,
				),
				empty( $from ) && empty( $to ) ? array() : array(
					'interval' => array(
						'start_date' => $from,
						'end_date'   => $to,
					),
				),
				yith_plugin_fw_is_true( $atts['pagination'] ) ? $this->get_pagination_atts( $atts ) : array()
			);

			$payments = YITH_WCAF_Payment_Factory::get_payments( $query_args );
			$count    = $payments->get_total_items();

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
					compact( 'affiliate', 'payments', 'filters_set', 'status', 'from', 'to', 'orderby', 'order', 'count' ),
					// backward compatibility: these attributes are submitted only to support old versions of the templates.
					array(
						'user_id'                 => $affiliate->get_user_id(),
						'user'                    => $affiliate->get_user(),
						'affiliate_id'            => $affiliate->get_id(),
						'dashboard_payments_link' => YITH_WCAF_Dashboard()->get_dashboard_url( 'clicks', 1 ),
						'to_order'                => 'DESC' === $order ? 'ASC' : 'DESC',
						/**
						 * APPLY_FILTERS: yith_wcaf_show_dashboard_links
						 *
						 * Filters whether to show the dashboard links in the Affiliate Dashboard.
						 *
						 * @param bool   $show_dashboard_links Whether to show the dashboard links or not.
						 * @param string $section              Affiliate dashboard section.
						 */
						'show_right_column'       => apply_filters( 'yith_wcaf_show_dashboard_links', yith_plugin_fw_is_true( $atts['show_dashboard_links'] ), 'dashboard_clicks' ),
						'dashboard_links'         => YITH_WCAF_Dashboard()->get_dashboard_navigation_menu(),
						'show_invoice'            => get_option( 'yith_wcaf_payment_require_invoice', 'no' ),
						'filter_set'              => $filters_set,
						'ordered'                 => $orderby,
						'page_links'              => $this->get_paginate_links( $this->get_current_page( $atts ), ceil( $count / $atts['per_page'] ) ),
					)
				)
			);
		}
	}
}
