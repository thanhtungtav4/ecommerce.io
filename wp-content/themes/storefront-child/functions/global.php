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
// add page templace
function makewp_exclude_page_templates( $post_templates ) {
  if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
  unset( $post_templates['templates/my-full-width-post-template.php'] );
  }
  return $post_templates;
  }
  add_filter( 'theme_page_templates', 'makewp_exclude_page_templates' );
/**
* Remove WPML notices
**/
// if( ! function_exists( 'm7_remove_wmpl_notices' ) ) :
//   function m7_remove_wmpl_notices() {
//       remove_action('admin_notices', array( WP_Installer(), 'show_site_key_nags' ) );
//       remove_action( 'admin_notices', array( WP_Installer(), 'setup_plugins_page_notices' ) );
//   }
//   endif;
// add_action( 'init', 'm7_remove_wmpl_notices', 11 );
//
if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'post-thumb', 327, 172, true  ); // 300 pixels wide (and unlimited height)
  add_image_size( 'post-thumb-smail', 137, 82, true  );
  add_image_size( 'product-thumb', 324, 324, true  );
}
// To set Default Length
add_filter( 'woocommerce_product_get_length', 'xa_product_default_length' );
add_filter( 'woocommerce_product_variation_get_length', 'xa_product_default_length' );	// For variable product variations

if( ! function_exists('xa_product_default_length') ) {
	function xa_product_default_length( $length) {

		$default_length = 10;			// Provide default Length
		if( empty($length) ) {
			return $default_length;
		}
		else {
			return $length;
		}
	}
}
// To set Default Width
add_filter( 'woocommerce_product_get_width', 'xa_product_default_width');
add_filter( 'woocommerce_product_variation_get_width', 'xa_product_default_width' );	// For variable product variations

if( ! function_exists('xa_product_default_width') ) {
	function xa_product_default_width( $width) {

		$default_width = 11;			// Provide default Width
		if( empty($width) ) {
			return $default_width;
		}
		else {
			return $width;
		}
	}
}
// To set Default Height
add_filter( 'woocommerce_product_get_height', 'xa_product_default_height');
add_filter( 'woocommerce_product_variation_get_height', 'xa_product_default_height' );	// For variable product variations

if( ! function_exists('xa_product_default_height')) {
	function xa_product_default_height( $height) {

		$default_height = 12;			// Provide default Height
		if( empty($height) ) {
			return $default_height;
		}
		else {
			return $height;
		}
	}
}
// To set Default Weight
add_filter( 'woocommerce_product_get_weight', 'xa_product_default_weight' );
add_filter( 'woocommerce_product_variation_get_weight', 'xa_product_default_weight' );	// For variable product variations

if( ! function_exists('xa_product_default_weight') ) {
	function xa_product_default_weight( $weight) {

		$default_weight = 0.5;			// Provide default Weight
		if( empty($weight) ) {
			return $default_weight;
		}
		else {
			return $weight;
		}
	}
}
// Update jquery version
function replace_core_jquery_version() {
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core',  get_stylesheet_directory_uri().'/assets/js/jquery.js', array(), '3.6.1' );
	wp_deregister_script( 'jquery-migrate' );
	wp_register_script( 'jquery-migrate', get_stylesheet_directory_uri().'/assets/js/jquery-migrate.js', array(), '3.4.0' );
}
add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );