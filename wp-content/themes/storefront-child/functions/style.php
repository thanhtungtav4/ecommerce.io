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
    if(is_page('dang-ky') || is_page('register')){
        wp_register_style( 'style_login', get_stylesheet_directory_uri().'/assets/css/login.css' );
        wp_enqueue_style('style_login');
    }
    if(!is_user_logged_in()){
       if(is_page('tai-khoan') || is_page('my-account')){
        wp_register_style( 'style_login', get_stylesheet_directory_uri().'/assets/css/login.css' );
        wp_enqueue_style('style_login');
       }
    }
    if(is_user_logged_in()){
        if(is_page('tai-khoan') || is_page('my-account')){
         wp_register_style( 'style_acc', get_stylesheet_directory_uri().'/assets/css/acc.css' );
         wp_enqueue_style('style_acc');
        }
     }
    if(is_checkout() && empty(is_wc_endpoint_url('order-received'))){
        wp_register_style( 'style_checkout', get_stylesheet_directory_uri().'/assets/css/checkout.css' );
        wp_enqueue_style('style_checkout');
    }
    if(is_checkout() && !empty( is_wc_endpoint_url('order-received'))){
        wp_register_style( 'style_thankyou', get_stylesheet_directory_uri().'/assets/css/thankyou.css' );
        wp_enqueue_style('style_thankyou');
    }
    if(is_product()){
        wp_register_style( 'detail-woo', get_stylesheet_directory_uri().'/assets/css/detail_wooo.css' );
        wp_enqueue_style('detail-woo');
    }
    if(is_product()){
        wp_register_style( 'detail-product-mobile', get_stylesheet_directory_uri().'/assets/css/detail-product-mobile.css' );
        wp_enqueue_style('detail-product-mobile');
    }
    if(is_page('lien-he') || is_page('contact-us')){
        wp_enqueue_style( 'style-leaflet', 'https://unpkg.com/leaflet@1.0.3/dist/leaflet.css' );
        wp_enqueue_style( 'style-poly', 'https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css' );
        wp_enqueue_script( 'script-leaflet', 'https://unpkg.com/leaflet@1.0.3/dist/leaflet.js', array('jquery') );
        wp_enqueue_script( 'script-PolylineMeasure', 'https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js', array('jquery'));
    }
}