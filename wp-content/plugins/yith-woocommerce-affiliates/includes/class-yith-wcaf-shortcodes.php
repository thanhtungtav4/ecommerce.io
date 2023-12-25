<?php
/**
 * Shortcodes class
 * Behaves as a Factory for shortcode instances, while installing existing shortcodes.
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Shortcodes' ) ) {
	/**
	 * Affiliate Shortcode
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Shortcodes {

		/**
		 * True while printing affiliate dashboard
		 *
		 * @var bool Whether we're currently printing affiliate dashboard
		 */
		public static $is_affiliate_dashboard = false;

		/**
		 * True while printing affiliate registration form
		 *
		 * @var bool Whether we're currently printing affiliate registration form
		 */
		public static $is_registration_form = false;

		/**
		 * Array of available shortcodes
		 *
		 * @var array
		 */
		protected static $shortcodes = array();

		/**
		 * Array of instances of classes that manage shortcodes
		 *
		 * @var YITH_WCAF_Abstract_Shortcode[]
		 */
		protected static $instances = array();

		/**
		 * Performs all required add_shortcode
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public static function init() {
			add_action( 'init', array( static::class, 'init_shortcodes' ) );
		}

		/**
		 * Init shortcodes available and register them
		 *
		 * @return void
		 */
		public static function init_shortcodes() {
			$shortcodes = static::get_shortcodes();

			if ( empty( $shortcodes ) ) {
				return;
			}

			foreach ( $shortcodes as $shortcode_tag ) {
				$shortcode_tag   = "yith_wcaf_$shortcode_tag";
				$shortcode_class = "{$shortcode_tag}_shortcode";

				if ( isset( self::$instances[ $shortcode_tag ] ) ) {
					continue;
				}

				if ( class_exists( "{$shortcode_class}_Premium" ) ) {
					$shortcode_class = "{$shortcode_class}_Premium";
				}

				if ( ! class_exists( $shortcode_class ) ) {
					continue;
				}

				self::$instances[ $shortcode_tag ] = new $shortcode_class();

				add_shortcode( $shortcode_tag, array( self::$instances[ $shortcode_tag ], 'render' ) );
			}
		}

		/**
		 * Returns list of registered shortcodes
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return array
		 */
		public static function get_shortcodes( $context = 'view' ) {
			// init shortcodes for the plugin.
			if ( empty( self::$shortcodes ) ) {
				self::$shortcodes = array(
					'registration_form',
					'affiliate_dashboard',
					'link_generator',
					'show_if_affiliate',
					'show_summary',
					'show_clicks',
					'show_commissions',
					'show_payments',
					'show_settings',
				);
			}

			if ( 'view' === $context ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_shortcodes
				 *
				 * Filters the available shortcodes.
				 *
				 * @param array $shortcodes Available shortcodes.
				 */
				return apply_filters( 'yith_wcaf_shortcodes', self::$shortcodes );
			}

			return self::$shortcodes;
		}

		/**
		 * Renders a specific shortcode
		 *
		 * @param string $tag  Shortcode to render.
		 * @param array  $atts Attributes for the shortcode.
		 *
		 * @return string Shortcode content.
		 */
		public static function render( $tag, $atts = array() ) {
			if ( ! did_action( 'init' ) ) {
				_doing_it_wrong( '\YITH_WCAF_Shortcodes::render', '\YITH_WCAF_Shortcodes::render should be called after init', '2.0.0' );
				return '';
			}

			if ( empty( self::$instances[ $tag ] ) ) {
				return '';
			}

			return self::$instances[ $tag ]->render( $atts );
		}

		/**
		 * Get instance of a specific shortcode
		 *
		 * @param string $shortcode Shortcode to retrieve.
		 * @return YITH_WCAF_Abstract_Shortcode Shortcode instance, in found; null otherwise
		 */
		public static function get_instance( $shortcode ) {
			if ( ! did_action( 'init' ) ) {
				_doing_it_wrong( '\YITH_WCAF_Shortcodes::get_instance', '\YITH_WCAF_Shortcodes::get_instance should be called after init', '2.0.0' );
				return null;
			}

			if ( ! $shortcode || empty( self::$instances[ $shortcode ] ) ) {
				return null;
			}

			return self::$instances[ $shortcode ];
		}
	}
}
