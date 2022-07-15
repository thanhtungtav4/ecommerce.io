<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

echo apply_filters(
	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf(
		'<a href="%s" data-quantity="%s" class="btn_area__del btn_area_custome %s" %s>
		<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path fill-rule="evenodd" clip-rule="evenodd" d="M12.76 8.70833H10.9267V5.95833H8.17668V4.125H10.9267V1.375H12.76V4.125H15.51V5.95833H12.76V8.70833ZM5.43584 18.7917C5.43584 17.7833 6.25168 16.9583 7.26001 16.9583C8.26834 16.9583 9.09334 17.7833 9.09334 18.7917C9.09334 19.8 8.26834 20.625 7.26001 20.625C6.25168 20.625 5.43584 19.8 5.43584 18.7917ZM16.4267 16.9583C15.4183 16.9583 14.6025 17.7833 14.6025 18.7917C14.6025 19.8 15.4183 20.625 16.4267 20.625C17.435 20.625 18.26 19.8 18.26 18.7917C18.26 17.7833 17.435 16.9583 16.4267 16.9583ZM15.0975 12.375H8.26834L7.26001 14.2083H18.26V16.0417H7.26001C5.86668 16.0417 4.98668 14.5475 5.65584 13.3192L6.89334 11.0825L3.59334 4.125H1.76001V2.29167H4.75751L8.66251 10.5417H15.0975L18.645 4.125L20.24 5.005L16.7017 11.4308C16.39 11.9992 15.785 12.375 15.0975 12.375Z" fill="white"/>
		</svg>
		</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
	),
	$product,
	$args
);
