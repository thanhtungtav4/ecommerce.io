<?php

defined( 'ABSPATH' ) or die( 'Keep Silent' );


function woo_variation_swatches_register_widgets() {
	unregister_widget( 'WC_Widget_Layered_Nav' );
	register_widget( 'Woo_Variation_Swatches_Widget_Layered_Nav' );
}

add_action( 'widgets_init', 'woo_variation_swatches_register_widgets' );


if ( ! function_exists( 'woo_variation_swatches_layered_nav' ) ):
	function woo_variation_swatches_layered_nav( $term_html, $term, $link, $count ) {
		$taxonomy = wvs_get_wc_attribute_taxonomy( $term->taxonomy );
	}
endif;

//add_filter( 'woocommerce_layered_nav_term_html', 'woo_variation_swatches_layered_nav', 10, 4 );

