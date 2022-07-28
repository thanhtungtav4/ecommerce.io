<?php
function wpgis_enqueue_scripts() {
	if (!is_admin()) {
		if ( class_exists( 'WooCommerce' ) && is_product() ) {
			wp_enqueue_script('wpgis-slick-js', get_stylesheet_directory_uri().'/functions/gallery-slider/assets/js/slick.min.js',  NULL, NULL, true);
			wp_enqueue_script('wpgis-fancybox-js', get_stylesheet_directory_uri().'/functions/gallery-slider/assets/js/jquery.fancybox.js', NULL, NULL, true);
			wp_enqueue_script('wpgis-zoom-js', get_stylesheet_directory_uri().'/functions/gallery-slider/assets/js/jquery.zoom.min.js', NULL, NULL, true);
			wp_enqueue_style('wpgis-fancybox-css', get_stylesheet_directory_uri().'/functions/gallery-slider/assets/css/fancybox.css');
			wp_enqueue_style('wpgis-front-css', get_stylesheet_directory_uri().'/functions/gallery-slider/assets/css/wpgis-front.css');
			wp_enqueue_script('wpgis-front-js', get_stylesheet_directory_uri().'/functions/gallery-slider/assets/js/wpgis.front.js', NULL, NULL, true);
			$translation_array = array(
				'wpgis_slider_layout'   => 'horizontal',
				'wpgis_slidetoshow'  => '1',
				'wpgis_slidetoscroll'    => '1',
				'wpgis_sliderautoplay'   => '1',
				'wpgis_arrowdisable'=> '0',
				'wpgis_arrowinfinite'=> '0',
				'wpgis_arrowcolor'=> '#ffffff',
				'wpgis_arrowbgcolor'=> 'transparent',
				'wpgis_show_lightbox'=> '1',
				'wpgis_show_zoom'=> '1',
			);

			wp_localize_script( 'wpgis-front-js', 'object_name', $translation_array );

			// Enqueued script with localized data.
			wp_enqueue_script( 'wpgis-front-js' );

		}
	}
}
add_action( 'wp_enqueue_scripts', 'wpgis_enqueue_scripts' );

remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_product_thumbnails', 'wpgis_show_product_thumbnails', 20 );
add_action( 'woocommerce_before_single_product_summary', 'wpgis_show_product_image', 10 );


// Single Product Image
function wpgis_show_product_image() {
	// Woocmmerce 3.0+ Slider Fix
	require_once( get_stylesheet_directory() . '/functions/gallery-slider/inc/product-image.php');
}

// Single Product Thumbnails
function wpgis_show_product_thumbnails() {
	// Woocmmerce 3.0+ Slider Fix
	require_once( get_stylesheet_directory() . '/functions/gallery-slider/inc/product-thumbnails.php');
}
