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
