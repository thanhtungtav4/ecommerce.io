<?php
/***
 * add style to product detail page
 */
add_action('init', 'register_custom_styles_product');
function register_custom_styles_product() {
    wp_register_style( 'style_detail_product', get_stylesheet_directory_uri().'/assets/css/detail-product.css' );
}
add_action( 'wp_enqueue_scripts', 'conditionally_enqueue_styles_scripts' );
function conditionally_enqueue_styles_scripts() {
    if ( is_product() ) {
        wp_enqueue_style( 'style_detail_product' );
    }
    if(is_cart()){
        wp_enqueue_script( 'script_cart', get_stylesheet_directory_uri().'/assets/js/cart.js' );
    }
}