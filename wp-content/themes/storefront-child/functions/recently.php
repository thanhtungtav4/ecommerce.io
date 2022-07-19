<?php
/**
 * Track user woocommerce viewed products.
 */
function dorzki_wc_track_product_views() {

	if( ! is_singular( 'product' ) || is_active_widget( false, false, 'woocommerce_recently_viewed_products', true ) ) {
		return;
	}

	global $post;

	if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {

		$viewed_products = array();

	} else {

		$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) );

	}

	$keys = array_flip( $viewed_products );

	if ( isset( $keys[ $post->ID ] ) ) {

		unset( $viewed_products[ $keys[ $post->ID ] ] );

	}

	$viewed_products[] = $post->ID;

	if ( count( $viewed_products ) > 15 ) {

		array_shift( $viewed_products );

	}

	wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );

}

add_action( 'template_redirect', 'dorzki_wc_track_product_views', 20 );
/**
 * /**
 * Display recently viewed products.
 */
function dorzki_wc_display_products_viewed() {

	if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {
		return;
	}
	$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) );

	$products = array_slice( $viewed_products, 0, 8 );
	$ids = implode( ',', $products );
	echo do_shortcode( "[products ids='{$ids}']" );

}

add_action( 'woocommerce_after_cart', 'dorzki_wc_display_products_viewed' );