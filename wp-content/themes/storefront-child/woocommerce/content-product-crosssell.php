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
<tr class="woocommerce-cart-form__cart-item cart_item cross-sells">
  <td class="product-thumbnail">
  	<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
  </td>
  <td class="product-name" data-title="Product">
		<a href="<?php the_permalink();?>"><?php the_title();?></a>
  </td>
  <!-- <td class="product-price" data-title=""></td> -->
  <td class="product-quantity" data-title="Quantity">
		<?php if ( $price_html = $product->get_price_html() ) : ?>
			<div class="product-subtotal" data-title="Subtotal">
				<span class="woocommerce-Price-amount amount">
					<bdi><?php echo $price_html; ?>&nbsp;
					</bdi>
				</span>
			</div>
		<?php endif; ?>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
  </td>
</tr>