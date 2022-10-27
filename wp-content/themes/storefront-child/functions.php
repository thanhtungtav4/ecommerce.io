<?php
require_once( get_stylesheet_directory() . '/functions/global.php' );
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
if(!wp_is_mobile()){
	require_once( get_stylesheet_directory() . '/functions/gallery-slider/woo-product-gallery-image-slider.php' );
}
if(wp_is_mobile()){
	require_once( get_stylesheet_directory() . '/functions/product_single_mobile.php' );
}

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


