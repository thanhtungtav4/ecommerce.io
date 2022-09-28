<?php
add_action( 'login_header', 'login_extra_header' );

function login_extra_header() {
    ?>
    <?php get_header() ?>
    <?php
}
//Custom login page
function clp_login_head() {

  echo '<style>'; //Begin custom styles
  echo '.login #nav a, .login #backtoblog a { color: # !important; }'; //Login page link color
  echo '.login h1 a { background:url("' . get_bloginfo('stylesheet_directory') . '/assets/images/logo.png"); width: 79px; height: 57px; }'; //Login page logo
  echo '.login .container{background:url("' . get_bloginfo('stylesheet_directory') . '/assets/images/login.jpg");height: 100vh;width: 100vw;background-repeat: no-repeat;background-size: cover;  background-position: center;}';
  echo '#wp-submit{width: 100%;background-color: #eb6a6a;border: 1px solid;font-weight: 400; font-size: 2rem;margin-top: 2rem;}';
  echo '</style>'; //End custom styles

}
add_action('login_head', 'clp_login_head');
add_action( 'login_footer', 'login_extra_footer' );
function login_extra_footer() {
    ?>
    <?php get_footer() ?>
    <?php
}