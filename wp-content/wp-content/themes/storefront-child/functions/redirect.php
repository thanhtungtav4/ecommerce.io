<?php
function logged_in_redirect() {

  if ( is_user_logged_in() && is_page( 'dang-ky' ) )
  {
      wp_redirect(get_permalink( get_option('woocommerce_myaccount_page_id') ) );
      exit;
  }

}
add_action( 'template_redirect', 'logged_in_redirect' );