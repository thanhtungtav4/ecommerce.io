<?php
//Data Tab
add_action( 'woocommerce_before_variations_form', 'add_quantity_field_before_variations_form', 10 );
function add_quantity_field_before_variations_form() {
    global $product;

    do_action( 'woocommerce_before_add_to_cart_quantity' );
    woocommerce_quantity_input(
        array(
            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
        )
    );
    do_action( 'woocommerce_after_add_to_cart_quantity' );
}
//Data Tab
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
add_action('tungnt_woocommerce_output_product_data_tabs', 'nt_woocommerce_output_product_data_tabs');
function nt_woocommerce_output_product_data_tabs(){
  woocommerce_output_product_data_tabs();
}
//Data Tab
//REMOVE PRODUCT META
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_filter( 'woocommerce_single_product_carousel_options', 'sf_update_woo_flexslider_options' );
/** 
 * Filer WooCommerce Flexslider options - Add Dot Pagination Instead of Thumbnails
 */
function sf_update_woo_flexslider_options( $options ) {

    $options['controlNav'] = true;

    return $options;
}
