<?php
require_once( get_stylesheet_directory() . '/functions/optimize.php' );
require_once( get_stylesheet_directory() . '/functions/taxonomy.php' );
require_once( get_stylesheet_directory() . '/functions/acf.php' );
require_once( get_stylesheet_directory() . '/functions/woo.php' );

// control order status if vnpay succes pay
add_action( 'woocommerce_thankyou', 'bbloomer_thankyou_change_order_status' );
function bbloomer_thankyou_change_order_status( $order_id ){
   if( ! $order_id ) return;
   $order = wc_get_order( $order_id );
	 $is_payment = $order->get_payment_method();
	 if($is_payment == 'vnpay'){
			$order->update_status( 'wc-completed' );
	 	}
	 else{
		$order->update_status( 'wc-processing' );
	 }
}
// !control order status if vnpay succes pay
//WPML - Add a floating language switcher
// use call do_action( 'wp_language_switcher' );
// https://wpml.org/documentation/support/wpml-coding-api/shortcodes/#wpml_language_selector_widget
add_action('wp_language_switcher', 'wpml_floating_language_switcher');
function wpml_floating_language_switcher() {
        do_action('wpml_language_switcher');
}
//WPML - Add a floating language switcher

