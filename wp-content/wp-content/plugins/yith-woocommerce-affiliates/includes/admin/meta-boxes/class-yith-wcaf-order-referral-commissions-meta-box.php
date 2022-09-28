<?php
/**
 * Registers Order Referral Commission meta box
 *
 * @author  YITH
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Order_Referral_Commissions_Meta_Box' ) ) {
	/**
	 * Class that manages meta boxes.
	 */
	class YITH_WCAF_Order_Referral_Commissions_Meta_Box {
		/**
		 * Print commission order metabox
		 *
		 * @param WP_POST $post Current order post object.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public static function print( $post ) {
			// set order id.
			$order_id = $post->ID;

			// if we're on wc subscription page, use subscription parent order.
			if ( 'shop_subscription' === $post->post_type ) {
				$order_id = $post->post_parent;
			}

			$order      = wc_get_order( $order_id );
			$referral   = '';
			$user_email = '';
			$username   = '';

			// define variables to be used on template.
			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_order_id( $order );

			if ( $affiliate ) {
				$referral = $affiliate->get_user_id();

				if ( $referral ) {
					$user_data  = $affiliate->get_user();
					$user_email = $user_data->user_email;
					$username   = $affiliate->get_formatted_name();
				}
			}

			// commissions tables.
			$table_class       = class_exists( 'YITH_WCAF_Commissions_Admin_Table_Premium' ) ? 'YITH_WCAF_Commissions_Admin_Table_Premium' : 'YITH_WCAF_Commissions_Admin_Table';
			$commissions_table = new $table_class(
				array(
					'table_classes' => array( 'small-status' ),
				)
			);

			$commissions_table->set_query_var( 'order_id', $order_id );
			$commissions_table->set_items_per_page( -1 );
			$commissions_table->set_visible_columns( array( 'id', 'status', 'rate', 'amount' ) );
			$commissions_table->hide_tablenav();
			$commissions_table->prepare_items();

			$template_name = 'referral-commissions-metabox.php';

			if ( defined( 'YITH_WCAF_PREMIUM' ) ) {
				$template_name = 'referral-commissions-metabox-premium.php';
			}

			include YITH_WCAF_DIR . 'views/meta-boxes/' . $template_name;
		}

		/* === ACTIONS HANDLING === */

		/**
		 * Assigns a specific order to an affiliate
		 *
		 * @param int $order_id Order being saved.
		 *
		 * @return void
		 */
		public static function add_order_affiliate( $order_id ) {
			if ( ! isset( $_POST['woocommerce_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['woocommerce_meta_nonce'] ) ), 'woocommerce_save_data' ) ) {
				return;
			}

			if ( ! isset( $_POST['referral_token'] ) ) {
				return;
			}

			$token = sanitize_text_field( wp_unslash( $_POST['referral_token'] ) );

			YITH_WCAF_Orders()->assign_commissions( $order_id, $token );
		}

		/**
		 * Removes an affiliate from an existing order
		 *
		 * @return void
		 */
		public static function delete_order_affiliate() {
			if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'delete_order_affiliate' ) ) {
				return;
			}

			if ( ! isset( $_GET['order_id'] ) ) {
				return;
			}

			$order_id = (int) $_GET['order_id'];

			YITH_WCAF_Orders()->unassign_commissions( $order_id );

			wp_safe_redirect( get_edit_post_link( $order_id, 'redirect' ) );
			die;
		}
	}
}
