<?php
/**
 * Adds additional fields to Coupons edit screen
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Admin_Coupons' ) ) {
	/**
	 * Class that manages admin fields for Coupons.
	 */
	class YITH_WCAF_Admin_Coupons {

		/**
		 * Init admin handling of the coupon, when enabled
		 *
		 * @return void
		 */
		public static function init() {
			$enable_coupon_handling = get_option( 'yith_wcaf_coupon_enable', 'no' );

			if ( 'yes' !== $enable_coupon_handling ) {
				return;
			}

			add_filter( 'woocommerce_coupon_data_tabs', array( self::CLASS, 'add_coupon_tab' ) );
			add_action( 'woocommerce_coupon_data_panels', array( self::CLASS, 'print_coupon_tab' ), 10, 2 );
			add_action( 'woocommerce_coupon_options_save', array( self::CLASS, 'save_coupon_tab' ), 10, 2 );
		}

		/**
		 * Add custom tab to coupon edit page
		 *
		 * @param array $tabs Array of currently defined tabs.
		 *
		 * @return array Array of filtered tabs
		 */
		public static function add_coupon_tab( $tabs ) {

			$tabs['affiliates'] = array(
				'label'  => _x( 'Affiliates', '[ADMIN] Name for the affiliates coupon tab', 'yith-woocommerce-affiliates' ),
				'target' => 'affiliates_coupon_data',
				'class'  => '',
			);

			return $tabs;

		}

		/**
		 * Print custom tab into coupon edit page
		 *
		 * @param int       $coupon_id Coupon ID.
		 * @param WC_Coupon $coupon    Coupon object.
		 *
		 * @return void
		 */
		public static function print_coupon_tab( $coupon_id, $coupon ) {
			include YITH_WCAF_DIR . 'views/coupons/tab-content.php';
		}

		/**
		 * Save fields from custom coupon tab
		 *
		 * @param int       $coupon_id Coupon ID.
		 * @param WC_Coupon $coupon    Coupon object.
		 *
		 * @return void
		 */
		public static function save_coupon_tab( $coupon_id, $coupon ) {
			$prev_value = $coupon->get_meta( 'coupon_referrer' );
			$new_value  = isset( $_POST['coupon_referrer'] ) ? intval( $_POST['coupon_referrer'] ) : false;

			if ( ! isset( $_POST['woocommerce_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['woocommerce_meta_nonce'] ) ), 'woocommerce_save_data' ) ) {
				return;
			}

			$coupon->update_meta_data( 'coupon_referrer', $new_value );
			$coupon->save_meta_data();

			if ( $new_value && (int) $prev_value !== $new_value ) {
				/**
				 * DO_ACTION: yith_wcaf_affiliate_coupon_saved
				 *
				 * Allows to trigger when saving the affiliate data in the coupon.
				 *
				 * @param WC_Coupon $coupon     Coupon object.
				 * @param int       $new_value  New value to save.
				 * @param string    $prev_value Previous value saved
				 */
				do_action( 'yith_wcaf_affiliate_coupon_saved', $coupon, $new_value, $prev_value );
			}

			// clear query cache.
			try {
				$data_store = WC_Data_Store::load( 'affiliate_coupon' );
				$data_store->clear_cache();
			} catch ( Exception $e ) {
				return;
			}
		}
	}
}
