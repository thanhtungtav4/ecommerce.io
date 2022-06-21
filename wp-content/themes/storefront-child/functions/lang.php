<?php
  function storefront_child_theme_setup() {
    load_child_theme_textdomain( 'storefront', get_stylesheet_directory() . '/languages' );
    load_theme_textdomain( 'storefront_child', get_stylesheet_directory() . '/languages');
  }
  add_action( 'after_setup_theme', 'storefront_child_theme_setup' );

// !control order status if vnpay succes pay
//WPML - Add a floating language switcher
// use call do_action( 'wp_language_switcher' );
// https://wpml.org/documentation/support/wpml-coding-api/shortcodes/#wpml_language_selector_widget
add_action('wp_language_switcher', 'wpml_floating_language_switcher');
function wpml_floating_language_switcher() {
        do_action('wpml_language_switcher');
}
//WPML - Add a floating language switcher