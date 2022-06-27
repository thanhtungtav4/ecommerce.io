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
<li <?php wc_product_class( '', $product ); ?>>
<div class="img">
    <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
  </div>
  <div class="info">
    <div class="content">
      <div class="name">
        <a href="<?php the_permalink();?>"><?php the_title();?></a>
      </div>
      <div class="m-control">
        <div class="number-input">
          <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()"></button> <?php echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key);  ?>
          <input class="quantity" min="0" name="quantity" value="1" type="number">
          <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"></button>
        </div>
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
      </div>
    </div>
		<?php if ( $price_html = $product->get_price_html() ) : ?>
			<span class="price"><?php echo $price_html; ?></span>
		<?php endif; ?>
  </div>
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
</li>