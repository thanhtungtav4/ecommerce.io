<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
	<?php

	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	//do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item' );
	?>
<li>
    <a href="<?php echo get_permalink(); ?>">
			<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
    </a>
    <div class="m-product__content">
        <div class="m-product__content-top">
            <div class="inner"><a href="<?php echo get_permalink(); ?>">
                <h3 class="strong"><?php the_title(); ?></h3>
							</a>
            <ul class="color">
                <li><span class="is-brown"></span></li>
                <li><span class="is-gray"></span></li>
                <li><span class="is-choco"></span></li>
            </ul>
            </div>
            <a class="favorite-btn" href="#">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/heart.png" alt="favorite" loading="lazy" width="16" height="16">
            </a>
        </div>
        <div class="m-product__content-bottom">
        <p>
            <span  class="time">
                <?php
                    echo get_field('time_deo')
                ?>
            </span>
            <br>
            <span>
                <?php echo wc_get_product()->get_price_html(); ?>
            </span>
        </p>
        <div class="btn_area">
            <a class="btn_area__add" onclick="quickview('<?php echo get_the_ID() ?>')">
                <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_eye.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_eye.svg" alt="quick view" loading="lazy" width="16" height="20">
            </a>
            <?php woocommerce_template_loop_add_to_cart();?>
            </div>
        </div>
    </div>
</li>