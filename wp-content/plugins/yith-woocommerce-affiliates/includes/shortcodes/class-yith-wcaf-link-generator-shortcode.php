<?php
/**
 * Link generator shortcode
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Link_Generator_Shortcode' ) ) {
	/**
	 * Offer methods for basic shortcode handling
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Link_Generator_Shortcode extends YITH_WCAF_Abstract_Shortcode {

		/* === INIT === */

		/**
		 * Performs any required init operation
		 */
		public function init() {
			// configure shortcode basics.
			$this->tag         = 'yith_wcaf_link_generator';
			$this->title       = _x( 'YITH Affiliates Link Generator', '[BUILDERS] Shortcode name', 'yith-woocommerce-affiliates' );
			$this->template    = 'link-generator.php';
			$this->description = _x( 'Show link generator form to your affiliates', '[BUILDERS] Shortcode description', 'yith-woocommerce-affiliates' );
			$this->supports    = array(
				'gutenberg',
				'elementor',
			);
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
			if ( ! YITH_WCAF_Dashboard()->can_user_see_section( false, 'link-generator' ) ) {
				return '';
			}

			$atts = $this->get_template_atts( $this->parse_atts( $atts ) );

			// enqueue required assets.
			$this->enqueue();

			// retrieve shortcode template.
			ob_start();
			yith_wcaf_get_template( $this->template, $atts, 'shortcodes' );

			return ob_get_clean();
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

			$generated_url = YITH_WCAF_Form_Handler::get_last_result( 'generate_referral_url' );
			$original_url  = YITH_WCAF_Form_Handler::get_posted_data( 'original_url' );
			$original_url  = $original_url ? $original_url : '';

			if ( ! $generated_url && $affiliate ) {
				$generated_url = $affiliate->get_referral_url();
			}

			return parent::get_template_atts(
				array_merge(
					$atts,
					compact( 'affiliate', 'generated_url', 'original_url' ),
					$this->get_share_atts( $generated_url ),
					// backward compatibility: these attributes are submitted only to support old versions of the templates.
					array(
						'user_id'           => $affiliate ? $affiliate->get_user_id() : false,
						'user'              => $affiliate ? $affiliate->get_user() : false,
						'affiliate_id'      => $affiliate ? $affiliate->get_id() : false,
						'affiliate_token'   => $affiliate ? $affiliate->get_token() : false,
						'referral_link'     => $affiliate ? $affiliate->get_referral_url() : false,
						'username'          => YITH_WCAF_Form_Handler::get_posted_data( 'username' ),
						/**
						 * APPLY_FILTERS: yith_wcaf_show_dashboard_links
						 *
						 * Filters whether to show the dashboard links in the Affiliate Dashboard.
						 *
						 * @param bool   $show_dashboard_links Whether to show the dashboard links or not.
						 * @param string $section              Affiliate dashboard section.
						 */
						'show_right_column' => apply_filters( 'yith_wcaf_show_dashboard_links', false, 'link_generator' ),
						'dashboard_links'   => YITH_WCAF_Dashboard()->get_dashboard_navigation_menu(),
					)
				)
			);
		}

		/**
		 * Returns attributes for sharing section
		 *
		 * @param string $generated_url Referral link.
		 *
		 * @return array Array of sharing attributes.
		 */
		public function get_share_atts( $generated_url = '' ) {
			// retrieve share options.
			$share_enabled = yith_plugin_fw_is_true( get_option( 'yith_wcaf_share' ) );
			$share_socials = get_option( 'yith_wcaf_share_socials', array() );

			$share_enabled = $share_enabled && ! empty( $share_socials );

			$atts = array(
				'share_enabled' => $share_enabled,
			);

			if ( $share_enabled ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_socials_share_title
				 *
				 * Filters the title of the socials share section for the referral URL.
				 *
				 * @param $socials_share_title Title to share the referral URL.
				 */
				$share_title    = apply_filters( 'yith_wcaf_socials_share_title', __( 'Share your referral URL on:', 'yith-woocommerce-affiliates' ) );
				$share_link_url = $generated_url;

				/**
				 * APPLY_FILTERS: yith_wcaf_share_title
				 *
				 * Filters the title to share the referral URL.
				 *
				 * @param $share_title Title to share the referral URL.
				 */
				$share_links_title     = apply_filters( 'yith_wcaf_share_title', rawurlencode( get_option( 'yith_wcaf_socials_title' ) ) );
				$share_twitter_summary = rawurlencode( str_replace( '%referral_url%', '', get_option( 'yith_wcaf_socials_text' ) ) );
				$share_summary         = rawurlencode( str_replace( '%referral_url%', $share_link_url, get_option( 'yith_wcaf_socials_text' ) ) );
				$share_image_url       = rawurlencode( get_option( 'yith_wcaf_socials_image_url' ) );

				$share_atts = array(
					'share_facebook_enabled'  => in_array( 'facebook', $share_socials, true ),
					'share_twitter_enabled'   => in_array( 'twitter', $share_socials, true ),
					'share_pinterest_enabled' => in_array( 'pinterest', $share_socials, true ),
					'share_email_enabled'     => in_array( 'email', $share_socials, true ),
					'share_whatsapp_enabled'  => in_array( 'whatsapp', $share_socials, true ),
					'share_title'             => $share_title,
					'share_link_url'          => $share_link_url,
					'share_link_title'        => $share_links_title,
					'share_twitter_summary'   => $share_twitter_summary,
					'share_summary'           => $share_summary,
					'share_image_url'         => $share_image_url,
				);

				$atts['share_atts'] = $share_atts;
			}

			return $atts;
		}

		/**
		 * Returns Icon used for Elementor widget
		 *
		 * @return string Icon.
		 */
		protected function get_elementor_icon() {
			return 'eicon-anchor';
		}
	}
}
