<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget1 cart_inner <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<?php if ( empty( $product_permalink ) ) : ?>
						<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php else : ?>
							<a class="cart_img" href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo $thumbnail;; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php endif; ?>
                        <div class="cart_content">
                          <div class="cart_content_top">
							<a href="<?php echo $product_permalink ?>">
							  <strong><?php echo $product_name?></strong>
                              <p>8h/ngày | 3 tháng</p>
                              <p>Độ cận: 0.5</p></a>
                            <div class="btn_area1">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s"  title="Remove product from cart" class="remove1 remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><svg width="35" height="35" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="35" height="35" rx="5" fill="#EB6A6A"/><path fill-rule="evenodd" clip-rule="evenodd" d="M7.518 7.81 8.81 6.519 28.482 26.19l-1.292 1.292-2.604-2.603c-.33.467-.87.77-1.485.77a1.83 1.83 0 0 1-1.063-3.318l-1.265-1.265h-6.838a1.839 1.839 0 0 1-1.834-1.834c0-.32.083-.623.23-.88l1.237-2.246-2.026-4.271L7.518 7.81zm7.425 9.589-1.008 1.833h5.005L17.106 17.4h-2.163zm10.908-8.25H14.045l1.833 1.833h8.424l-2.53 4.584h-1.32l1.778 1.778c.495-.128.908-.45 1.146-.89l3.282-5.948c.34-.605-.11-1.357-.807-1.357zm-13.74 14.667c0-1.009.815-1.834 1.824-1.834 1.008 0 1.833.825 1.833 1.834a1.839 1.839 0 0 1-1.833 1.833 1.83 1.83 0 0 1-1.825-1.833z" fill="#fff"/></svg></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_attr__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $cart_item_key ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
								?>

							</div>
                          </div>
                          <div class="cart_content_bottom">
                            <p>x <?php echo $cart_item['quantity'] ?></p>
                            <p><?php echo $product_price ?></p>
                          </div>
                        </div>
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<p class="woocommerce-mini-cart__total total">
		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
	</p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php _e( 'No products in the cart.', 'storefront' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
