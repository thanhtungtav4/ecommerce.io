<?php
/**
 * Affiliate Dashboard shortcode - Summary
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Show_Summary_Shortcode' ) ) {
	/**
	 * Offer methods for basic shortcode handling
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Show_Summary_Shortcode extends YITH_WCAF_Affiliate_Dashboard_Shortcode {

		/* === INIT === */

		/**
		 * Performs any required init operation
		 */
		public function init() {
			// configure shortcode basics.
			$this->tag         = 'yith_wcaf_show_summary';
			$this->title       = _x( 'YITH Show Summary', '[BUILDERS] Shortcode name', 'yith-woocommerce-affiliates' );
			$this->section     = 'summary';
			$this->template    = "dashboard-{$this->section}.php";
			$this->description = _x( 'Show dashboard summary to your affiliates', '[BUILDERS] Shortcode description', 'yith-woocommerce-affiliates' );
			$this->supports    = array();
		}

		/**
		 * Returns attributes accepted for current shortcode
		 *
		 * @return array Array of supported attributes.
		 */
		public function get_atts() {
			$attributes = parent::get_atts();

			if ( isset( $attributes['section'] ) ) {
				unset( $attributes['section'] );
			}

			return $attributes;
		}

		/**
		 * Renders shortcode
		 *
		 * @param array  $atts    Array of shortcode attributes.
		 * @param string $content Shortcode content.
		 *
		 * @return string Shortcode content.
		 */
		public function render( $atts = array(), $content = '' ) {
			$atts = $this->parse_atts( $atts );

			$atts['section'] = $this->section;

			return parent::render( $atts, $content );
		}

		/* === SECTION HANDLING === */

		/**
		 * Returns shortcode attributes accepted for current section
		 *
		 * @return array Array of additional shortcode attributes.
		 */
		public function get_section_atts() {
			return array(
				'pagination'   => array(
					'default' => 'yes',
				),
				'per_page'     => array(
					'default' => isset( $_REQUEST['per_page'] ) ? intval( $_REQUEST['per_page'] ) : 10, // phpcs:ignore WordPress.Security.NonceVerification
				),
				'current_page' => array(
					'default' => 1,
				),
			);
		}
	}
}
