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
		'<a href="%s" data-quantity="%s" class="%s" %s>
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 20 20" version="1.1">
				<g id="surface1">
				<path style=" stroke:none;fill-rule:nonzero;fill:#ffff;fill-opacity:1;" d="M 7.417969 8.789062 C 7.761719 8.789062 8.042969 8.507812 8.042969 8.164062 L 8.042969 5.726562 C 8.042969 4.636719 8.929688 3.75 10.019531 3.75 C 11.109375 3.75 11.996094 4.636719 11.996094 5.726562 L 11.996094 8.164062 C 11.996094 8.507812 12.273438 8.789062 12.621094 8.789062 C 12.964844 8.789062 13.246094 8.507812 13.246094 8.164062 L 13.246094 5.726562 C 13.246094 3.949219 11.796875 2.5 10.019531 2.5 C 8.238281 2.5 6.792969 3.949219 6.792969 5.726562 L 6.792969 8.164062 C 6.792969 8.507812 7.070312 8.789062 7.417969 8.789062 Z M 7.417969 8.789062 "/>
				<path style=" stroke:none;fill-rule:nonzero;fill:#ffff;fill-opacity:1;" d="M 17.1875 7.382812 L 13.871094 7.382812 L 13.871094 8.164062 C 13.871094 8.851562 13.308594 9.414062 12.621094 9.414062 C 11.929688 9.414062 11.371094 8.851562 11.371094 8.164062 L 11.371094 7.382812 L 8.667969 7.382812 L 8.667969 8.164062 C 8.667969 8.851562 8.105469 9.414062 7.417969 9.414062 C 6.726562 9.414062 6.167969 8.851562 6.167969 8.164062 L 6.167969 7.382812 L 2.8125 7.382812 C 2.640625 7.382812 2.535156 7.519531 2.574219 7.6875 L 4.761719 16.59375 C 4.894531 17.09375 5.421875 17.5 5.9375 17.5 L 14.0625 17.5 C 14.582031 17.5 15.105469 17.09375 15.238281 16.59375 L 17.425781 7.6875 C 17.464844 7.519531 17.359375 7.382812 17.1875 7.382812 Z M 17.1875 7.382812 "/>
				</g>
				</svg>
		</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		esc_html( $product->add_to_cart_text() )
	),
	$product,
	$args
);
