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
						<a class="cart_img" href="<?php echo WC()->cart->get_cart_url(); ?>">
												<img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-cart.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-cart.jpg" alt="Logo" loading="lazy" width="80" height="80"></a>
                        <div class="cart_content">
                          <div class="cart_content_top"><a href="#"><strong>LAVIER BROWN</strong>
                              <p>8h/ngày | 3 tháng</p>
                              <p>Độ cận: 0.5</p></a>
                            <div class="btn_area">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="btn_area__del remove1 remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M1.15515 1.35552L2.04144 0.469238L15.5306 13.9584L14.6443 14.8447L12.8592 13.0595C12.6329 13.3801 12.262 13.5875 11.8409 13.5875C11.1494 13.5875 10.59 13.0218 10.59 12.3304C10.59 11.9092 10.7974 11.5384 11.1117 11.3121L10.2443 10.4447H5.55515C4.86372 10.4447 4.29801 9.87895 4.29801 9.18752C4.29801 8.96752 4.35458 8.7601 4.45515 8.5841L5.30372 7.0441L3.91458 4.11495L1.15515 1.35552ZM6.24658 7.93038L5.55515 9.18752H8.98715L7.73001 7.93038H6.24658ZM13.7266 2.27324H5.63058L6.88772 3.53038H12.6643L10.9294 6.67324H10.0243L11.2437 7.89267C11.5832 7.80467 11.866 7.58467 12.0294 7.28295L14.2797 3.20352C14.5123 2.78867 14.2043 2.27324 13.7266 2.27324ZM4.30429 12.3304C4.30429 11.639 4.86372 11.0732 5.55515 11.0732C6.24658 11.0732 6.81229 11.639 6.81229 12.3304C6.81229 13.0218 6.24658 13.5875 5.55515 13.5875C4.86372 13.5875 4.30429 13.0218 4.30429 12.3304Z" fill="white"/>
									</svg></a>',
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
                            <p>x 1</p>
                            <p>400.000VND</p>
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

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
