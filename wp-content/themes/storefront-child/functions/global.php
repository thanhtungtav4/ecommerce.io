<?php
define( 'Placeholder', get_stylesheet_directory_uri() . '/assets/images/placeholder.svg' );
function my_jquery_enqueue() {
  wp_deregister_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'my_jquery_enqueue' );