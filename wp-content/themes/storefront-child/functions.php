<?php
/***
 * Brand
 */
function cptui_register_my_taxes_thuong_hieu() {

	/**
	 * Taxonomy: Thương Hiệu.
	 */

	$labels = [
		"name" => __( "Thương Hiệu", "custom-post-type-ui" ),
		"singular_name" => __( "Thương Hiệu", "custom-post-type-ui" ),
	];


	$args = [
		"label" => __( "Thương Hiệu", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'thuong_hieu', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "thuong_hieu",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy( "thuong_hieu", [ "product" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_thuong_hieu' );

/***
 * ! Brand
 */
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

#Disable Self Pingbacks in WordPress Using Plugins
function no_self_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link )
			if ( 0 === strpos( $link, $home ) )
					unset($links[$l]);
}

add_action( 'pre_ping', 'no_self_ping' );
add_filter('xmlrpc_enabled', '__return_false');
#!Disable Self Pingbacks in WordPress Using Plugins

//WPML - Add a floating language switcher
// use call do_action( 'wp_language_switcher' );
// https://wpml.org/documentation/support/wpml-coding-api/shortcodes/#wpml_language_selector_widget
add_action('wp_language_switcher', 'wpml_floating_language_switcher');
function wpml_floating_language_switcher() {
        do_action('wpml_language_switcher');
}
//WPML - Add a floating language switcher