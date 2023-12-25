<?php
/**
 * Trait that implements singleton behaviour on a class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Traits
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! trait_exists( 'YITH_WCAF_Trait_Singleton' ) ) {
	/**
	 * This class implements singleton management on the object that uses it
	 * It will define static method ::get_instance(), that has to be called to retrieve single instance of the class
	 *
	 * Classes that uses this trait <b>should also define <code>__construct</code> as protected</b>
	 *
	 * @since 2.0.0
	 */
	trait YITH_WCAF_Trait_Singleton {
		/**
		 * Single instance of the class
		 *
		 * @var object
		 * @since 1.0.0
		 */
		protected static $instance = null;

		/**
		 * Returns single instance of the class
		 *
		 * @return object
		 * @since 1.0.2
		 */
		public static function get_instance() {
			$class   = static::class;
			$premium = "{$class}_Premium";

			if ( class_exists( $premium ) ) {
				return $premium::get_instance();
			}

			if ( is_null( self::$instance ) ) {
				static::$instance = new static();
			}

			return static::$instance;
		}
	}
}
