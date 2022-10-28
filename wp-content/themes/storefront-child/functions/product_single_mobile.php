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