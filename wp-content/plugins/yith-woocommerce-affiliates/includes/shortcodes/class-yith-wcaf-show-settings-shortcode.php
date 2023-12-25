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

if ( ! class_exists( 'YITH_WCAF_Show_Settings_Shortcode' ) ) {
	/**
	 * Offer methods for basic shortcode handling
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Show_Settings_Shortcode extends YITH_WCAF_Show_Summary_Shortcode {

		/* === INIT === */

		/**
		 * Performs any required init operation
		 */
		public function init() {
			// configure shortcode basics.
			$this->tag         = 'yith_wcaf_show_settings';
			$this->title       = _x( 'YITH Show Settings', '[BUILDERS] Shortcode name', 'yith-woocommerce-affiliates' );
			$this->section     = 'settings';
			$this->template    = "dashboard-{$this->section}.php";
			$this->description = _x( 'Show affiliate settings to your affiliates', '[BUILDERS] Shortcode description', 'yith-woocommerce-affiliates' );
			$this->supports    = array();
		}

		/* === SECTION HANDLING === */

		/**
		 * Returns shortcode attributes accepted for current section
		 *
		 * @return array Array of additional shortcode attributes.
		 */
		public function get_section_atts() {
			return array();
		}

		/**
		 * Filters variable submitted to template, in order to add section-specific values
		 *
		 * @param array $atts General shortcode attributes, as entered for the shortcode, or as default values.
		 *
		 * @return array Array of filtered template variables.
		 */
		public function get_template_atts( $atts ) {
			$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();
			$user      = $affiliate->get_user();

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
					compact( 'affiliate' ),
					// backward compatibility: these attributes are submitted only to support old versions of the templates.
					array(
						'user_id'           => $affiliate->get_user_id(),
						'user'              => $affiliate->get_user(),
						'affiliate_id'      => $affiliate->get_id(),
						'payment_email'     => $affiliate->get_payment_email(),
						/**
						 * APPLY_FILTERS: yith_wcaf_show_dashboard_links
						 *
						 * Filters whether to show the dashboard links in the Affiliate Dashboard.
						 *
						 * @param bool   $show_dashboard_links Whether to show the dashboard links or not.
						 * @param string $section              Affiliate dashboard section.
						 */
						'show_right_column' => apply_filters( 'yith_wcaf_show_dashboard_links', 'yes' === $atts['show_dashboard_links'], 'dashboard_clicks' ),
						'dashboard_links'   => YITH_WCAF_Dashboard()->get_dashboard_navigation_menu(),
						'affiliate_name'    => $user->first_name,
						'affiliate_surname' => $user->last_name,
					)
				)
			);
		}
	}
}
