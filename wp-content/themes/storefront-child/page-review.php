<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */
get_header(); ?>
  <?php do_shortcode('[devvn_list_reviews number="15" has_img="1"]') ?>
<?php
//do_action( 'storefront_sidebar' );
get_footer();