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

	//woocommerce_product_loop_start();
	echo '<div class="m-product">';
	echo '<div class="m-product_top">';
	echo "<h4>";
	echo _e('Recently viewed products', 'storefront');
	echo "</h4>";
	echo '<div class="m-product__nav">';
	echo  '<button class="m-item__prev">';
	echo	"<svg width='46' height='46' viewBox='0 0 46 46' fill='none' xmlns='http://www.w3.org/2000/svg'>";
	echo	  "<circle cx='23' cy='23' r='22' stroke-width='2'></circle>";
	echo	  "<path d='M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z'></path>";
	echo	'</svg>';
	echo  '</button>';
	echo  '<button class="m-item__next">';
	echo	"<svg width='46' height='46' viewBox='0 0 46 46' fill='none' xmlns='http://www.w3.org/2000/svg'>";
	echo	  "<circle cx='23' cy='23' r='22' stroke-width='2'></circle>";
	echo	  "<path d='M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z' fill='#2B2929'></path>";
	echo	'</svg>';
	echo  '</button>';
	echo '</div>';
	echo '</div>';
	echo '<ul>';
	echo '<div class="m-product__inner w-100">';
    echo '<ul class="m-item w-100">';
	foreach ( $products as $product ) :

			$post_object = get_post( $product );

			setup_postdata( $GLOBALS['post'] =& $post_object );

			wc_get_template_part( 'content', 'product-item' );

	endforeach;
	wp_reset_postdata();
	echo '</ul>';
	echo '</div>';

}

add_action( 'woocommerce_after_cart', 'dorzki_wc_display_products_viewed' );