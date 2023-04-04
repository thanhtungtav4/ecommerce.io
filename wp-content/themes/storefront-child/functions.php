<?php
require_once( get_stylesheet_directory() . '/functions/global.php' );
require_once( get_stylesheet_directory() . '/functions/security.php');
require_once( get_stylesheet_directory() . '/functions/lang.php' );
require_once( get_stylesheet_directory() . '/functions/optimize.php' );
require_once( get_stylesheet_directory() . '/functions/resource.php' );
//control load js css
require_once( get_stylesheet_directory() . '/functions/taxonomy.php' );
require_once( get_stylesheet_directory() . '/functions/acf.php' );
require_once( get_stylesheet_directory() . '/functions/woo.php' );
require_once( get_stylesheet_directory() . '/functions/auth.php' );
require_once( get_stylesheet_directory() . '/functions/url.php' );
require_once( get_stylesheet_directory() . '/functions/breadcrumbs.php' );
require_once( get_stylesheet_directory() . '/functions/smtp.php' );
require_once( get_stylesheet_directory() . '/functions/style.php' );
//only load product detail
require_once( get_stylesheet_directory() . '/functions/woo_detail.php');
require_once( get_stylesheet_directory() . '/functions/recently.php' );
// if(!wp_is_mobile()){
// 	require_once( get_stylesheet_directory() . '/functions/gallery-slider/woo-product-gallery-image-slider.php' );
// }
// if(wp_is_mobile()){
// 	require_once( get_stylesheet_directory() . '/functions/product_single_mobile.php' );
// }
require_once( get_stylesheet_directory() . '/functions/product_single_mobile.php' );
// control order status if vnpay succes pay
// account
require_once( get_stylesheet_directory() . '/functions/woo_account.php');
// account
require_once( get_stylesheet_directory() . '/functions/widgets.php');
require_once( get_stylesheet_directory() . '/functions/quantity.php');
// job
require_once( get_stylesheet_directory() . '/functions/job.php');
//add shortcode show product
require_once( get_stylesheet_directory() . '/functions/shortcode.php');
require_once( get_stylesheet_directory() . '/functions/schema.php');
require_once( get_stylesheet_directory() . '/functions/quickview.php');
// add Advanced Custom Fields to WooCommerce Attributes
require_once( get_stylesheet_directory() . '/functions/acf-wcattributes.php');

// custome hook using is cart
require_once( get_stylesheet_directory() . '/functions/checkout.php');
// load in review
require_once( get_stylesheet_directory() . '/functions/comment.php');
//load in cart page
require_once( get_stylesheet_directory() . '/functions/cart.php');
//fetch data
require_once( get_stylesheet_directory() . '/functions/fetchdata.php');

function shapeSpace_disable_scripts_styles() {
  if(is_front_page()){
    wp_dequeue_script('firebase');
    wp_dequeue_script('devvn-nhanhvn-script');
    wp_dequeue_script('magnific-popup');
    wp_dequeue_script('firebase-auth');
    wp_dequeue_script('xoo-ml-phone-js');
    wp_dequeue_script('select2');
    wp_dequeue_script('xoo-ml-phone-js');
    wp_dequeue_script('yith-wcaf-shortcodes');
    wp_dequeue_script('jquery-ui-autocomplete');
    wp_dequeue_script('masonry.pkgd');
    wp_dequeue_script('devvn-shortcode-reviews');
    wp_dequeue_script('woo-variation-swatches');
    wp_dequeue_script('owl.carousel');
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('yith-wcaf');
    wp_dequeue_style('storefront-gutenberg-blocks');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('devvn-nhanhvn-style');
    wp_dequeue_style('magnific-popup');
    wp_dequeue_style('devvn-shortcode-reviews-style');
    wp_dequeue_style('woocommerce-inline');
    wp_dequeue_style('woo-variation-swatches');
    wp_dequeue_style('xoo-ml-style');
    wp_dequeue_style('storefront-style');
    wp_dequeue_style('storefront-icons');
    wp_dequeue_style('storefront-fonts');
    wp_dequeue_style('dashicons');
    wp_dequeue_style('storefront-woocommerce-style');
  }
}
add_action('wp_enqueue_scripts', 'shapeSpace_disable_scripts_styles', 100);

// function shapeSpace_inspect_script_style() {

// 	global $wp_scripts, $wp_styles;

// 	echo "\n" .'<!--'. "\n\n";

// 	echo 'SCRIPT IDs:'. "\n";

// 	foreach($wp_scripts->queue as $handle) echo $handle . "\n";

// 	echo "\n" .'STYLE IDs:'. "\n";

// 	foreach($wp_styles->queue as $handle) echo $handle . "\n";

// 	echo "\n" .'-->'. "\n\n";

// }
// add_action('wp_print_scripts', 'shapeSpace_inspect_script_style');