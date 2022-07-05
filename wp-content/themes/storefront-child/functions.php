<?php
require_once( get_stylesheet_directory() . '/functions/lang.php' );
require_once( get_stylesheet_directory() . '/functions/optimize.php' );
require_once( get_stylesheet_directory() . '/functions/taxonomy.php' );
require_once( get_stylesheet_directory() . '/functions/acf.php' );
require_once( get_stylesheet_directory() . '/functions/woo.php' );
require_once( get_stylesheet_directory() . '/functions/auth.php' );
require_once( get_stylesheet_directory() . '/functions/url.php' );
require_once( get_stylesheet_directory() . '/functions/breadcrumbs.php' );
require_once( get_stylesheet_directory() . '/functions/smtp.php' );
//only load product detail
require_once( get_stylesheet_directory() . '/functions/woo_detail.php');


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


