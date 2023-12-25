<?php
/**
 * Blocks registration class
 * This is a wrapper clas that will register all blocks specifically built for this plugin
 * Plugins register blocks in \YITH_WCAF_Abstract_Shortcode too, but in that case block will just echo the shortcode
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Blocks' ) ) {
	/**
	 * Affiliate Blocks
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_Blocks {

		/**
		 * Array of available blocks
		 *
		 * @var array
		 */
		protected static $blocks = array();

		/**
		 * Performs all required add_shortcode
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public static function init() {
			// register blocks.
			self::init_blocks();

			// register assets.
			add_action( 'wp_enqueue_scripts', array( static::class, 'register_scripts' ) );
		}

		/**
		 * Register script and style needed to declare and render blocks
		 */
		public static function register_scripts() {
			// TODO: implement this method
		}

		/**
		 * Init shortcodes available and register them
		 *
		 * @return void
		 */
		public static function init_blocks() {
			$blocks = static::get_blocks();

			if ( empty( $blocks ) ) {
				return;
			}

			foreach ( $blocks as $block ) {
				$block_name  = "yith_wcaf_$block";
				$block_class = "{$block_name}_block";

				if (
					! class_exists( $block_class ) ||
					! method_exists( $block_class, 'register' )
				) {
					continue;
				}

				$block_class::register();
			}
		}

		/**
		 * Returns list of registered blocks
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return array
		 */
		public static function get_blocks( $context = 'view' ) {
			// init blocks for the plugin.
			if ( empty( self::$blocks ) ) {
				self::$blocks = array(
					'set_referrer',
				);
			}

			if ( 'view' === $context ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_blocks
				 *
				 * Filters the available blocks.
				 *
				 * @param array $blocks Available blocks.
				 */
				return apply_filters( 'yith_wcaf_blocks', self::$blocks );
			}

			return self::$blocks;
		}
	}
}
