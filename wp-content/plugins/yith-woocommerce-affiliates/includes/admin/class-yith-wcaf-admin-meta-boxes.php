<?php
/**
 * Registers metaboxes for the plugin
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Admin_Meta_Boxes' ) ) {
	/**
	 * Class that manages meta boxes.
	 */
	class YITH_WCAF_Admin_Meta_Boxes {

		/**
		 * List of available meta boxes
		 *
		 * @var array
		 */
		protected static $meta_boxes = array();

		/**
		 * Init method.
		 *
		 * @since 2.0.0
		 */
		public static function init() {
			// init meta boxes.
			static::init_meta_boxes();

			// register meta boxes.
			add_action( 'add_meta_boxes', array( self::class, 'add_meta_boxes' ) );
		}

		/**
		 * Retrieves meta boxes currently registered
		 *
		 * @return array Registered meta boxes.
		 */
		public static function get_meta_boxes() {
			if ( empty( self::$meta_boxes ) ) {
				static::init_meta_boxes();
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_admin_meta_boxes
			 *
			 * Filters the meta boxes registered in the backend.
			 *
			 * @param array $meta_boxes Registered meta boxes.
			 */
			return apply_filters( 'yith_wcaf_admin_meta_boxes', self::$meta_boxes );
		}

		/**
		 * Add meta boxes to WordPress
		 *
		 * @return void
		 */
		public static function add_meta_boxes() {
			$meta_boxes = self::get_meta_boxes();

			if ( empty( $meta_boxes ) ) {
				return;
			}

			foreach ( $meta_boxes as $meta_box_id => $meta_box ) {
				$meta_box = wp_parse_args(
					$meta_box,
					array(
						'title'   => '',
						'screens' => null,
						'context' => 'advanced',
					)
				);

				$meta_box_class = "{$meta_box_id}_Meta_Box";

				add_meta_box( $meta_box_id, $meta_box['title'], array( $meta_box_class, 'print' ), $meta_box['screens'], $meta_box['context'] );
			}
		}

		/**
		 * Init internal list of meta boxes
		 *
		 * @return array Array of defined metaboxes
		 */
		protected static function init_meta_boxes() {
			self::$meta_boxes = array_merge(
				self::$meta_boxes,
				array(
					'yith_wcaf_order_referral_commissions' => array(
						'title'   => _x( 'Referral commissions', '[ADMIN] MetaBox title', 'yith-woocommerce-affiliates' ),
						'screens' => array( 'shop_order', 'woocommerce_page_wc-orders', 'shop_subscription' ),
						'context' => 'side',
					),
				)
			);

			return self::$meta_boxes;
		}
	}
}
