<?php
/**
 * We will Dequeue the jQuery UI script as example.
 */
function wp_remove_scripts() {
    wp_dequeue_script( 'storefront-header-cart-js' );
    wp_deregister_script( 'storefront-header-cart-js' );
    wp_dequeue_script( 'storefront-handheld-footer-bar-js' );
    wp_deregister_script( 'storefront-handheld-footer-bar-js' );
  }
  add_action( 'wp_enqueue_scripts', 'wp_remove_scripts', 99 );