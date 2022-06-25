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
    <div class="l-container">
        <ul class="c-breadcrumb">
            <li><a href="<?php apply_filters( 'wpml_permalink', get_home_url(), ICL_LANGUAGE_CODE); ?>"><?php _e('Home', 'storefront') ?></a></li>
            <li><?php _e('Cart', 'storefront') ?></li>
        </ul>
        <?php require_once( get_stylesheet_directory() . '/module/list_promotion.php' ); ?>
    </div>
<?php
get_footer();