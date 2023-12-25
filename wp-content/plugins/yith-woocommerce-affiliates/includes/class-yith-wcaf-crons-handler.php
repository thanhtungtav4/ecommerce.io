<?php
/**
 * Static class that will handle all crons for the plugin
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Crons_Handler' ) ) {
	/**
	 * WooCommerce Affiliates Crons Handler
	 *
	 * @since 3.0.0
	 */
	class YITH_WCAF_Crons_Handler {
		/**
		 * Array of events to schedule
		 *
		 * @var array
		 */
		protected static $crons = array();

		/**
		 * Performs all required add_actions to handle forms
		 *
		 * @return void
		 */
		public static function init() {
			add_filter( 'cron_schedules', array( self::class, 'add_schedules' ) );

			self::schedule();
		}

		/**
		 * Returns registered crons
		 *
		 * @param string $context Context of the operation.
		 *
		 * @return array Array of registered crons and callbacks
		 */
		public static function get_crons( $context = 'view' ) {
			// no crons defined for this version; leave space for third party code to add some.
			if ( 'view' === $context ) {
				/**
				 * APPLY_FILTERS: yith_wcaf_crons
				 *
				 * Filters the registered crons.
				 *
				 * @param array $crons Registered crons.
				 */
				return apply_filters( 'yith_wcaf_crons', self::$crons );
			}

			return self::$crons;
		}

		/**
		 * Schedule events not scheduled yet; register callbacks for each event
		 *
		 * @return void
		 */
		public static function schedule() {
			$crons = static::get_crons();

			if ( empty( $crons ) ) {
				return;
			}

			foreach ( $crons as $hook => $data ) {
				// if hook shouldn't be scheduled, remove any existing schedule and move on.
				if ( ! self::should_schedule( $hook ) ) {
					wp_unschedule_hook( $hook );
					continue;
				}

				// add cron handling.
				add_action( $hook, $data['callback'] );

				// schedule next execution, when needed.
				if ( ! wp_next_scheduled( $hook ) ) {
					wp_schedule_event( time() + MINUTE_IN_SECONDS, $data['schedule'], $hook );
				}
			}
		}

		/**
		 * Checks if a specific recurring hook should be scheduled or not.
		 *
		 * @param string $shook Hook to check.
		 *
		 * @return bool Whether hook should be scheduled or not.
		 */
		public static function should_schedule( $shook ) {
			$crons = static::get_crons();

			if ( ! isset( $crons[ $shook ] ) ) {
				return false;
			}

			$cron_data = $crons[ $shook ];

			if ( ! isset( $cron_data['condition'] ) ) {
				return true;
			}

			return (bool) call_user_func( $cron_data['condition'] );
		}

		/**
		 * Adds schedules to wp cron default system
		 *
		 * @param array $schedules Schedules to add to defaults.
		 *
		 * @return array Filtered array of "to add" schedules
		 * @since 1.0.0
		 */
		public static function add_schedules( $schedules ) {
			$schedules = array_merge(
				$schedules,
				array(
					'monthly' => array(
						'interval' => DAY_IN_SECONDS * 30,
						'display'  => _x( 'Once a month', '[ADMIN] Cron schedule (not visible)', 'yith-woocommerce-affiliates' ),
					),
				)
			);

			return $schedules;
		}
	}
}
