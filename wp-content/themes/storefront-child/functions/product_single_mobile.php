<?php
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    add_action('nt_woocommerce_template_single_title', 'wc_custome_title');
    function wc_custome_title(){
      woocommerce_template_single_title();
    }
    // custome override detail single title only in mobile

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    add_action('nt_woocommerce_template_single_price', 'wc_custome_price');
    function wc_custome_price(){
        woocommerce_template_single_price();
    }

    // add to card
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    add_action('nt_woocommerce_template_single_add_to_cart', 'wc_custome_cart');
    function wc_custome_cart(){
        woocommerce_template_single_add_to_cart();
    }

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    add_action('nt_woocommerce_template_single_rating', 'wc_custome_rating');
    function wc_custome_rating(){
        woocommerce_template_single_rating();
    }


    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

// define the woocommerce_dropdown_variation_attribute_options_args callback
function filter_woocommerce_dropdown_variation_attribute_options_args( $array ) {

    // Find the name of the attribute for the slug we passed in to the function
    $attribute_name = wc_attribute_label($array['attribute']);

    // Create a string for our select
    $select_text = 'Chọn độ cận';

    $array['show_option_none'] = __( $select_text, 'woocommerce' );
    return $array;
};

// add the filter
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'filter_woocommerce_dropdown_variation_attribute_options_args', 10, 1 );