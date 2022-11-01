<?php
// is using cart page
function wc_cart_item_data( $cart_item, $flat = false) {
	$item_data = array();
	if ( $cart_item['data']->is_type( 'variation' ) && is_array( $cart_item['variation'] ) ) {
    foreach ( $cart_item['variation'] as $name => $value ) {
      if($name == 'attribute_pa_mau-sac'){
        $taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );
        if ( taxonomy_exists( $taxonomy ) ) {
          // If this is a term slug, get the term's nice name.
          $term = get_term_by( 'slug', $value, $taxonomy );
          if ( ! is_wp_error( $term ) && $term && $term->name ) {
            $value = $term->name;
          }
        } else {
          // If this is a custom option slug, get the options name.
          $value = apply_filters( 'woocommerce_variation_option_name', $value, null, $taxonomy, $cart_item['data'] );
        }
        // Check the nicename against the title.
        if ( '' === $value || wc_is_attribute_in_product_name( $value, $cart_item['data']->get_name() ) ) {
          continue;
        }
        var_dump($cart_item['data']);
        return $value;
      }
      return '';
    }
	}
 }