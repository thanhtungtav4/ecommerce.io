<?php
/**
 * This class offers methods to check current site instance, and if it changed since first registration
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 2.0.0
 */

defined( 'YITH_WCAF' ) || exit;

if ( ! class_exists( 'YITH_WCAF_Instance' ) ) {
	/**
	 * Instance class
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Instance {

		/**
		 * Current instance
		 *
		 * @var string
		 */
		protected static $current;

		/**
		 * Registered instance
		 *
		 * @var string
		 */
		protected static $registered;

		/**
		 * Init instance handling
		 *
		 * @return void
		 */
		public static function init() {
			// maybe register current instance.
			self::maybe_register();
		}

		/**
		 * Returns current instance (stripped down version of the site url plugin's currently running on)
		 *
		 * @return string Current instance url.
		 */
		public static function current() {
			if ( ! self::$current ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_current_instance
				 *
				 * Filters the current instance (url of the site where the plugin is currently running on).
				 *
				 * @param string $instance Current instance url.
				 */
				self::$current = apply_filters( 'yith_wcaf_current_instance', str_replace( array( 'https://', 'http://', 'www.' ), '', get_site_url() ) );
			}

			return self::$current;
		}

		/**
		 * Returns registered instance (stripped down version of the site url plugin's was originally activated on)
		 *
		 * @return string Registered instance url.
		 */
		public static function registered() {
			if ( ! self::$registered ) {
				self::$registered = get_option( 'yith_wcaf_instance', '' );
			}

			return self::$registered;
		}

		/**
		 * Checks if current instance matches registered one
		 * If no instance was registered yet, register current and return true.
		 *
		 * @return bool Whether current instance matches registered one or not.
		 */
		public static function check() {
			if ( ! self::registered() ) {
				self::maybe_register();
				return true;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_instance_check
			 *
			 * Filters whether the current instance matches the registered one.
			 *
			 * @param bool   $match               Whether the current instance matches the registered one or not.
			 * @param string $current_instance    Current instance.
			 * @param string $registered_instance Registered instance.
			 */
			return apply_filters( 'yith_wcaf_instance_check', self::current() === self::registered(), self::current(), self::registered() );
		}

		/**
		 * Registers current instance (url where the plugin was originally activated)
		 * This is used to perform safety checks later in the plugin; for example, before performing a payment
		 * system double checks that current instance matches registered one, to avoid performing payments from staging installations.
		 *
		 * @return void
		 */
		protected static function maybe_register() {
			if ( self::registered() ) {
				return;
			}

			$current = self::current();

			// register instance.
			update_option( 'yith_wcaf_instance', $current );

			// set class property for furture usage.
			self::$registered = $current;
		}
	}
}
