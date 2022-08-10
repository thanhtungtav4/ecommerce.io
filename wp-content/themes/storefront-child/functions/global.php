<?php
define( 'Placeholder', get_stylesheet_directory_uri() . '/assets/images/placeholder.svg' );
define( 'PlaceholderNews', get_stylesheet_directory_uri() . '/assets/images/placeholder-new.png' );
function add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
  remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
}
add_action( 'after_setup_theme', 'add_woocommerce_support' );
add_action('init','remove_storefront_sort_pagination');
function remove_storefront_sort_pagination(){
remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
}