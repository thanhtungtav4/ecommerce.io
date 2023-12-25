<?php
/**
 * "Show if Affiliate" shortcode
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Show_If_Affiliate_Shortcode' ) ) {
	/**
	 * Offer methods for basic shortcode handling
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Show_If_Affiliate_Shortcode extends YITH_WCAF_Abstract_Shortcode {

		/* === INIT === */

		/**
		 * Performs any required init operation
		 */
		public function init() {
			// configure shortcode basics.
			$this->tag         = 'yith_wcaf_show_if_affiliate';
			$this->title       = _x( 'YITH Affiliates "Show if"', '[BUILDERS] Shortcode name', 'yith-woocommerce-affiliates' );
			$this->template    = '';
			$this->description = _x( 'Show content only under specific conditions', '[BUILDERS] Shortcode description', 'yith-woocommerce-affiliates' );
		}

		/**
		 * Returns attributes accepted for current shortcode
		 *
		 * @return array Array of supported attributes.
		 */
		public function get_atts() {
			if ( empty( $this->attributes ) ) {
				$this->attributes = array(
					'show_to' => array(
						'type'    => 'text',
						'label'   => _x( 'Choose who should see the content (valid_affiliates/enabled_affiliates/all_affiliates/{user role}/logged_in_users/anyone)', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
						'default' => 'enabled_affiliates',
					),
				);
			}

			return $this->attributes;
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
			$atts = $this->get_template_atts( $this->parse_atts( $atts ) );

			list( $show_to ) = yith_plugin_fw_extract( $atts, 'show_to' );

			// accepts list of show_to.
			$show_to = explode( ',', $show_to );
			$show_to = is_array( $show_to ) ? array_map( 'trim', $show_to ) : array();

			// define variable that will tell us if we need to show content.
			$render_content = false;

			foreach ( $show_to as $rule ) {
				$not = false;

				// check for possible NOT condition.
				if ( 0 === strpos( $rule, '-' ) ) {
					$rule = substr( $rule, 1 );
					$not  = true;
				}

				switch ( $rule ) {
					case 'valid_affiliates':
						$affiliate      = YITH_WCAF_Affiliate_Factory::get_current_affiliate();
						$render_content = $affiliate && $affiliate->is_valid();
						break;
					case 'enabled_affiliates':
						$affiliate      = YITH_WCAF_Affiliate_Factory::get_current_affiliate();
						$render_content = $affiliate && $affiliate->has_status( 'enabled' );
						break;
					case 'all_affiliates':
						$render_content = ! ! YITH_WCAF_Affiliate_Factory::get_current_affiliate();
						break;
					case 'logged_in_users':
						$render_content = is_user_logged_in();
						break;
					case 'anyone':
						$render_content = true;
						break;
					default:
						if ( is_user_logged_in() ) {
							$user = wp_get_current_user();

							if ( in_array( $rule, $user->roles, true ) ) {
								$render_content = true;
							}
						}
						break;
				}

				// if we're checking a not condition, reverse result.
				if ( $not ) {
					$render_content = ! $render_content;
				}

				/**
				 * APPLY_FILTERS: yith_wcaf_show_if_affiliate_result
				 *
				 * Filters whether to render the content when using <code>yith_wcaf_show_if_affiliate</code> shortcode.
				 *
				 * @param bool   $render_content Whether to render content or not.
				 * @param string $rule           Rule to render content.
				 * @param bool   $not            Whether to render content or not
				 */
				$render_content = apply_filters( 'yith_wcaf_show_if_affiliate_result', $render_content, $rule, $not );

				// if at least one rule matched, break and show content.
				if ( $render_content ) {
					break;
				}
			}

			// if current user didn't matched any rule, return empty content.
			if ( ! $render_content ) {
				return '';
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_show_if_affiliate_content_callbacks
			 *
			 * Filters the content callback when using <code>yith_wcaf_show_if_affiliate</code> shortcode.
			 *
			 * @param array $shortcode_callbacks Shortcode callbacks.
			 */
			$callbacks = apply_filters(
				'yith_wcaf_show_if_affiliate_content_callbacks',
				array(
					'do_shortcode',
				)
			);

			ob_start();

			if ( ! empty( $callbacks ) ) {
				foreach ( $callbacks as $callback ) {
					$content = $callback( $content );
				}
			}

			echo wp_kses_post( $content );

			return ob_get_clean();
		}
	}
}
