<?php
/**
 * Loop Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product, $devvn_review_settings;

if ( ! wc_review_ratings_enabled() ) {
    return;
}

$review_count = $product->get_review_count();

if($review_count || $devvn_review_settings['loop_rating_zero']) {
    echo '<div class="devvn_rating_loop">';
        echo '<div class="drloop_item">';
        echo wc_get_rating_html($product->get_average_rating()); // WordPress.XSS.EscapeOutput.OutputNotEscaped.
        printf(_n('%s review', '%s reviews', $review_count, 'devvn-reviews'), '<span class="count">' . esc_html($review_count) . '</span>');
        echo '</div>';
        /*echo '<div class="drloop_item sold_item">';
            echo do_shortcode('[devvn_sold id="'.$product->get_id().'"]');
        echo '</div>';*/
    echo '</div>';
}