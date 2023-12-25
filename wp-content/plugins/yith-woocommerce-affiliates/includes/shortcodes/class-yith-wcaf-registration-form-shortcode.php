<?php
/**
 * Affiliate registration form shortcode
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH/Affiliates/Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Registration_Form_Shortcode' ) ) {
	/**
	 * Registration shortcode
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Registration_Form_Shortcode extends YITH_WCAF_Abstract_Shortcode {

		/**
		 * Temporary storage for gloabl user
		 * Used to store global object while redering shortcode on backend (user will be temporarily logged out)
		 *
		 * @var WP_User
		 */
		protected $global_user;

		/* === INIT === */

		/**
		 * Performs any required init operation
		 */
		public function init() {
			// configure shortcode basics.
			$this->tag         = 'yith_wcaf_registration_form';
			$this->title       = _x( 'YITH Affiliates Registration Form', '[BUILDERS] Shortcode name', 'yith-woocommerce-affiliates' );
			$this->template    = 'registration-form.php';
			$this->description = _x( 'Show registration form to your affiliates', '[BUILDERS] Shortcode description', 'yith-woocommerce-affiliates' );
			$this->supports    = array(
				'gutenberg',
				'elementor',
			);
		}

		/**
		 * Returns attributes accepted for current shortcode
		 *
		 * @return array Array of supported attributes.
		 */
		public function get_atts() {
			if ( empty( $this->attributes ) ) {
				$this->attributes = array(
					'show_login_form' => array(
						'type'      => 'select',
						'label'     => _x( 'Show login form', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
						'default'   => get_option( 'yith_wcaf_referral_registration_show_login_form' ),
						'options'   => array(
							'no'  => _x( 'Hide login form', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
							'yes' => _x( 'Show login form', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
						),
						'elementor' => true,
						'gutenberg' => true,
					),
					'login_title'     => array(
						'type'      => 'text',
						'label'     => _x( 'Title to show above login form', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
						'default'   => _x( 'Login', '[FRONTEND] Affiliate login form', 'yith-woocommerce-affiliates' ),
						'elementor' => true,
						'gutenberg' => true,
					),
					'register_title'  => array(
						'type'      => 'text',
						'label'     => _x( 'Title to show above register form', '[BUILDERS] Shortcode attributes', 'yith-woocommerce-affiliates' ),
						'default'   => _x( 'Register', '[FRONTEND] Affiliate registration form', 'yith-woocommerce-affiliates' ),
						'elementor' => true,
						'gutenberg' => true,
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
			YITH_WCAF_Shortcodes::$is_registration_form = true;

			$atts = $this->parse_atts( $atts );

			// enqueue required assets.
			$this->enqueue();

			// remove privacy text from our registration.
			remove_action( 'woocommerce_register_form', 'wc_registration_privacy_policy_text', 20 );

			// retrieve shortcode template.
			ob_start();
			yith_wcaf_get_template( $this->template, $atts, 'shortcodes' );

			$return = ob_get_clean();

			// adds back privacy text.
			add_action( 'woocommerce_register_form', 'wc_registration_privacy_policy_text', 20 );

			YITH_WCAF_Shortcodes::$is_registration_form = false;

			return $return;
		}

		/* === BUILDERS SUPPORT === */

		/**
		 * Returns Icon used for Elementor widget
		 *
		 * @return string Icon.
		 */
		protected function get_elementor_icon() {
			return 'eicon-form-horizontal';
		}

		/**
		 * Performs required tweaks before builder rendering
		 *
		 * @param string $builder   Specific builder.
		 * @param string $shortcode Specific shortcode.
		 */
		protected function do_pre_builder_render_tweaks( $builder, $shortcode ) {
			global $current_user;

			$this->global_user = $current_user;
			$current_user      = null; // phpcs:ignore WordPress.WP.GlobalVariablesOverride

			define( 'XMLRPC_REQUEST', true );
		}

		/**
		 * Performs required tweaks after builder rendering
		 *
		 * @param string $builder   Specific builder.
		 * @param string $shortcode Specific shortcode.
		 */
		protected function do_post_builder_render_tweaks( $builder, $shortcode ) {
			global $current_user;

			$current_user      = $this->global_user; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
			$this->global_user = null;
		}
	}
}
