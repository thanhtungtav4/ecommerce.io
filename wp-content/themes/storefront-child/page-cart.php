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
            <li><a href="<?php echo get_site_url().'/'.ICL_LANGUAGE_CODE ?>"><?php _e('Home', 'storefront') ?></a></li>
            <li><?php _e('Cart', 'storefront') ?></li>
        </ul>
        <?php require_once( get_stylesheet_directory() . '/module/list_promotion.php' ); ?>
        <div class="c-tab c-tabCart">
            <div class="c-tab_top">
              <button class="button tablinks active" onclick="openTab(event, 'cart')"><?php _e('Cart', 'storefront') ?></button>
              <button class="button tablinks" onclick="openTab(event, 'parameter')"><?php _e('Delivery', 'storefront') ?></button>
              <button class="button tablinks" onclick="openTab(event, 'insurane')"><?php _e('Completed', 'storefront') ?></button>
            </div>
            <div class="c-tab_content">
              <div class="c-tab_item" id="cart" style="display: block;">
                <form class="c-tabCart_inner woocommerce-cart-form"  action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                  <ul class="m-cart" >
                  <?php
                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                      $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                      $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                      if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                        ?>
                          <li <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>>
                            <div class="img">
                            <?php
                              $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                              if ( ! $product_permalink ) {
                                echo $thumbnail; // PHPCS: XSS ok.
                              } else {
                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                              }
                              ?>
                            </div>
                            <div class="info">
                              <div class="content">
                                <div class="name">
                                <?php
                                    if ( ! $product_permalink ) {
                                      echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                    } else {
                                      echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                    }

                                    do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                    // Meta data.
                                    echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                    // Backorder notification.
                                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                      echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                    }
                                ?>
                                  <p class="only-sp" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                    <?php
                                      echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                    ?>
                                  </p>
                                </div>
                                <div class="m-control">
                                  <div class="number-input product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                                  <?php
                                    if ( $_product->is_sold_individually() ) {
                                      $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                    } else {
                                      $product_quantity = woocommerce_quantity_input(
                                        array(
                                          'input_name'   => "cart[{$cart_item_key}][qty]",
                                          'input_value'  => $cart_item['quantity'],
                                          'max_value'    => $_product->get_max_purchase_quantity(),
                                          'min_value'    => '0',
                                          'product_name' => $_product->get_name(),
                                        ),
                                        $_product,
                                        false
                                      );
                                    }

                                    echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                    ?>
                                    <!-- <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()"></button>
                                    <input class="quantity" min="0" name="quantity" value="1" type="number">
                                    <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"></button> -->
                                  </div>
                                  <?php
                                  echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    'woocommerce_cart_item_remove_link',
                                    sprintf(
                                      '<a href="%s" class="btn_remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg width="35" height="35" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="35" height="35" rx="5" fill="#EB6A6A"/><path fill-rule="evenodd" clip-rule="evenodd" d="M7.518 7.81 8.81 6.519 28.482 26.19l-1.292 1.292-2.604-2.603c-.33.467-.87.77-1.485.77a1.83 1.83 0 0 1-1.063-3.318l-1.265-1.265h-6.838a1.839 1.839 0 0 1-1.834-1.834c0-.32.083-.623.23-.88l1.237-2.246-2.026-4.271L7.518 7.81zm7.425 9.589-1.008 1.833h5.005L17.106 17.4h-2.163zm10.908-8.25H14.045l1.833 1.833h8.424l-2.53 4.584h-1.32l1.778 1.778c.495-.128.908-.45 1.146-.89l3.282-5.948c.34-.605-.11-1.357-.807-1.357zm-13.74 14.667c0-1.009.815-1.834 1.824-1.834 1.008 0 1.833.825 1.833 1.834a1.839 1.839 0 0 1-1.833 1.833 1.83 1.83 0 0 1-1.825-1.833z" fill="#fff"/></svg></a>',
                                      esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                      esc_html__( 'Remove this item', 'woocommerce' ),
                                      esc_attr( $product_id ),
                                      esc_attr( $_product->get_sku() )
                                    ),
                                    $cart_item_key
                                  );
                                ?>
                                </div>
                              </div>
                              <div class="price only-pc" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                <?php
                                echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                ?>
                                </div>
                            </div>
                          </li>
                    <?php
                      }
                    }
                    ?>
                    <?php do_action( 'woocommerce_after_cart_contents' ); ?>

                  </ul>
                  <div class="c-sidebar">
                    <div class="c-sidebar_item">
                      <h4><?php esc_html_e( 'Cart totals', 'woocommerce' ); ?></h4>
                      <?php if ( wc_coupons_enabled() ) { ?>
                        <div class="coupon">
                          <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
                          <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
                          <?php do_action( 'woocommerce_cart_coupon' ); ?>
                        </div>
					            <?php } ?>

                      <!-- <button type="submit" class="button" name="update_cart" value="<?php //esc_attr_e( 'Update cart', 'woocommerce' ); ?>">
                      <?php //esc_html_e( 'Update cart', 'woocommerce' ); ?>
                      </button> -->

                      <?php do_action( 'woocommerce_cart_actions' ); ?>

                      <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                      <?php
                        /**
                         * Cart collaterals hook.
                         *
                         * @hooked woocommerce_cross_sell_display
                         * @hooked woocommerce_cart_totals - 10
                         */
                        do_action( 'woocommerce_cart_collaterals' );
                      ?>
                    </div>
                    <div class="c-sidebar_item">
                      <p class="how">Bảo vệ mắt sáng khỏe cùng nước nhỏ mắt chuyên dụng thay vì sử dụng loại nước nhỏ mắt thông thường. Bởi vì:</p>
                      <div class="how_item">
                        <svg width="42" height="28" viewBox="0 0 42 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M0.833374 14C4.00504 5.95167 11.8334 0.25 21 0.25C30.1667 0.25 37.995 5.95167 41.1667 14C37.995 22.0483 30.1667 27.75 21 27.75C11.8334 27.75 4.00504 22.0483 0.833374 14ZM37.17 14C34.145 7.82167 27.9484 3.91667 21 3.91667C14.0517 3.91667 7.85504 7.82167 4.83004 14C7.85504 20.1783 14.0334 24.0833 21 24.0833C27.9667 24.0833 34.145 20.1783 37.17 14ZM21 9.41667C23.53 9.41667 25.5834 11.47 25.5834 14C25.5834 16.53 23.53 18.5833 21 18.5833C18.47 18.5833 16.4167 16.53 16.4167 14C16.4167 11.47 18.47 9.41667 21 9.41667ZM12.75 14C12.75 9.45333 16.4534 5.75 21 5.75C25.5467 5.75 29.25 9.45333 29.25 14C29.25 18.5467 25.5467 22.25 21 22.25C16.4534 22.25 12.75 18.5467 12.75 14Z" fill="#2B2929"></path>
                        </svg>
                        <p> Thuốc nhỏ chuyên dụng sẽ phù hợp với từng loại kính áp tròng mà bạn đang đeo nên giúp cho đôi mắt khỏe mạnh hơn.  </p>
                      </div>
                      <div class="how_item">
                        <svg width="43" height="43" viewBox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g id="blur_circular_24px">
                            <path id="icon/image/blur_circular_24px" fill-rule="evenodd" clip-rule="evenodd" d="M21.5 3.58325C11.61 3.58325 3.58337 11.6099 3.58337 21.4999C3.58337 31.3899 11.61 39.4166 21.5 39.4166C31.39 39.4166 39.4167 31.3899 39.4167 21.4999C39.4167 11.6099 31.39 3.58325 21.5 3.58325ZM18.8125 12.5416C18.8125 13.0433 18.4184 13.4374 17.9167 13.4374C17.415 13.4374 17.0209 13.0433 17.0209 12.5416C17.0209 12.0399 17.415 11.6458 17.9167 11.6458C18.4184 11.6458 18.8125 12.0399 18.8125 12.5416ZM16.125 17.9166C16.125 16.9312 16.9313 16.1249 17.9167 16.1249C18.9021 16.1249 19.7084 16.9312 19.7084 17.9166C19.7084 18.902 18.9021 19.7083 17.9167 19.7083C16.9313 19.7083 16.125 18.902 16.125 17.9166ZM16.125 25.0833C16.125 24.0978 16.9313 23.2916 17.9167 23.2916C18.9021 23.2916 19.7084 24.0978 19.7084 25.0833C19.7084 26.0687 18.9021 26.8749 17.9167 26.8749C16.9313 26.8749 16.125 26.0687 16.125 25.0833ZM12.5417 17.0208C12.04 17.0208 11.6459 17.4149 11.6459 17.9166C11.6459 18.4183 12.04 18.8124 12.5417 18.8124C13.0434 18.8124 13.4375 18.4183 13.4375 17.9166C13.4375 17.4149 13.0434 17.0208 12.5417 17.0208ZM17.0209 30.4583C17.0209 29.9566 17.415 29.5624 17.9167 29.5624C18.4184 29.5624 18.8125 29.9566 18.8125 30.4583C18.8125 30.9599 18.4184 31.3541 17.9167 31.3541C17.415 31.3541 17.0209 30.9599 17.0209 30.4583ZM12.5417 24.1874C12.04 24.1874 11.6459 24.5816 11.6459 25.0833C11.6459 25.5849 12.04 25.9791 12.5417 25.9791C13.0434 25.9791 13.4375 25.5849 13.4375 25.0833C13.4375 24.5816 13.0434 24.1874 12.5417 24.1874ZM25.0834 16.1249C24.098 16.1249 23.2917 16.9312 23.2917 17.9166C23.2917 18.902 24.098 19.7083 25.0834 19.7083C26.0688 19.7083 26.875 18.902 26.875 17.9166C26.875 16.9312 26.0688 16.1249 25.0834 16.1249ZM25.9792 12.5416C25.9792 13.0433 25.585 13.4374 25.0834 13.4374C24.5817 13.4374 24.1875 13.0433 24.1875 12.5416C24.1875 12.0399 24.5817 11.6458 25.0834 11.6458C25.585 11.6458 25.9792 12.0399 25.9792 12.5416ZM30.4584 24.1874C29.9567 24.1874 29.5625 24.5816 29.5625 25.0833C29.5625 25.5849 29.9567 25.9791 30.4584 25.9791C30.96 25.9791 31.3542 25.5849 31.3542 25.0833C31.3542 24.5816 30.96 24.1874 30.4584 24.1874ZM29.5625 17.9166C29.5625 17.4149 29.9567 17.0208 30.4584 17.0208C30.96 17.0208 31.3542 17.4149 31.3542 17.9166C31.3542 18.4183 30.96 18.8124 30.4584 18.8124C29.9567 18.8124 29.5625 18.4183 29.5625 17.9166ZM7.16671 21.4999C7.16671 29.4191 13.5809 35.8332 21.5 35.8332C29.4192 35.8332 35.8334 29.4191 35.8334 21.4999C35.8334 13.5808 29.4192 7.16659 21.5 7.16659C13.5809 7.16659 7.16671 13.5808 7.16671 21.4999ZM25.0834 29.5624C24.5817 29.5624 24.1875 29.9566 24.1875 30.4583C24.1875 30.9599 24.5817 31.3541 25.0834 31.3541C25.585 31.3541 25.9792 30.9599 25.9792 30.4583C25.9792 29.9566 25.585 29.5624 25.0834 29.5624ZM23.2917 25.0833C23.2917 24.0978 24.098 23.2916 25.0834 23.2916C26.0688 23.2916 26.875 24.0978 26.875 25.0833C26.875 26.0687 26.0688 26.8749 25.0834 26.8749C24.098 26.8749 23.2917 26.0687 23.2917 25.0833Z" fill="#2B2929"></path>
                          </g>
                        </svg>
                        <p> Trong thuốc nhỏ mắt thường có chứa lượng nhiều muối và một số thành phần khác gây khô mắt khi đeo lens.</p>
                      </div>
                      <div class="how_item pgb-5">
                        <svg width="43" height="43" viewBox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g id="sentiment_very_dissatisfied_24px">
                            <path id="icon/social/sentiment_very_dissatisfied_24px" fill-rule="evenodd" clip-rule="evenodd" d="M3.58337 21.4999C3.58337 11.592 11.5921 3.58325 21.4821 3.58325C31.39 3.58325 39.4167 11.592 39.4167 21.4999C39.4167 31.4078 31.3721 39.4166 21.4821 39.4166C11.5921 39.4166 3.58337 31.4078 3.58337 21.4999ZM14.0109 21.4999L15.91 19.6008L17.8092 21.4999L19.7084 19.6008L17.8092 17.7016L19.7084 15.8024L17.8092 13.9033L15.91 15.8024L14.0109 13.9033L12.1117 15.8024L14.0109 17.7016L12.1117 19.6008L14.0109 21.4999ZM21.5 24.1874C17.3255 24.1874 13.778 26.8033 12.3446 30.4583H30.6555C29.2221 26.8033 25.6746 24.1874 21.5 24.1874ZM21.5 35.8332C13.5809 35.8332 7.16671 29.4191 7.16671 21.4999C7.16671 13.5808 13.5809 7.16659 21.5 7.16659C29.4192 7.16659 35.8334 13.5808 35.8334 21.4999C35.8334 29.4191 29.4192 35.8332 21.5 35.8332ZM27.09 15.8024L28.9892 13.9033L30.8884 15.8024L28.9892 17.7016L30.8884 19.6008L28.9892 21.4999L27.09 19.6008L25.1909 21.4999L23.2917 19.6008L25.1909 17.7016L23.2917 15.8024L25.1909 13.9033L27.09 15.8024Z" fill="#2B2929"></path>
                          </g>
                        </svg>
                        <p> Có nguy cơ khô giác mạc, thậm chí mắt còn bị đỏ và cộm gây nên sự khó chịu cho người sử dụng."		</p>
                      </div>
                    </div>
                  </div>
                  <?php do_action( 'woocommerce_after_cart_table' ); ?>
                </form>
                <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
                <?php do_action( 'woocommerce_after_cart' ); ?>

              </div>
            </div>
          </div>
    </div>
<?php
get_footer();