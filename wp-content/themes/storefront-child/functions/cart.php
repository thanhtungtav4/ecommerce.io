<?php
function productVariation(){
  global $woocommerce;

  $items                = $woocommerce->cart->get_cart_item( $_POST['key'] );
  $product_woo_ck       = wc_get_product( $items['product_id'] );
  $selected_variation   = $items['variation'];
  $selected_qty         = $items['quantity'];
  $available_variations = $product_woo_ck->get_available_variations();
  $attributes           = $product_woo_ck->get_variation_attributes();

  ?>
  <script type='text/javascript' src='<?php echo plugins_url(); ?>/woocommerce/assets/js/frontend/add-to-cart-variation.min.js?ver=<?php echo WC_VERSION; ?>'></script>
  <form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product_woo_ck->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $available_variations ) ); ?>">
    <table class="variations" cellspacing="0">
      <tbody>
        <?php foreach ( $attributes as $attribute_name => $options ) : ?>
          <tr>
            <td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
            <td class="value">
              <?php
              $selected = $selected_variation[ 'attribute_' . sanitize_title( $attribute_name ) ];

              wc_dropdown_variation_attribute_options(
                array(
                  'options'   => $options,
                  'attribute' => $attribute_name,
                  'product'   => $product_woo_ck,
                  'selected'  => $selected,
                )
              );

              echo end( $attributes ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce' ) . '</a>' ) : '';
              ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="single_variation_wrap">
      <div class="woocommerce-variation single_variation" style="">
        <div class="woocommerce-variation-description"></div>
        <div class="woocommerce-variation-price">
          <span class="price"></span>
        </div>
        <div class="woocommerce-variation-availability"></div>
      </div>
      <div class="woocommerce-variation-add-to-cart variations_button woocommerce-variation-add-to-cart-enabled">
        <img src="<?php echo WUVIC_WOO_UPDATE_CART_ASSESTS_URL . 'img/loader.gif'; ?>" alt="Smiley face" height="42" width="42" id="loder_img_btn" style="display:none;">
        <div class="quantity">
          <?php woocommerce_quantity_input( array( 'input_value' => isset( $selected_qty ) ? wc_stock_amount( $selected_qty ) : 1 ) ); ?>
        </div>
        <input type="hidden" id="product_thumbnail" value='<?php echo $product_woo_ck->get_image(); ?>'>
        <button type="submit" class="single_add_to_cart_button button alt <?php echo get_option( 'WOO_CK_WUVIC_update_btn_class' ); ?>" id="single_add_to_cart_button_id">
          <?php echo get_option( 'WOO_CK_WUVIC_update_btn_text' ) ?: 'Update'; ?>
        </button>
        <span id="cancel" class="<?php echo get_option( 'WOO_CK_WUVIC_cancel_btn_class' ); ?>" onclick="cancel_update_variations('<?php echo $_POST['current_key_value']; ?>');" title="Close" style="cursor: pointer; ">
          <?php echo get_option( 'WOO_CK_WUVIC_cancel_btn' ) ?: 'Cancel'; ?>
        </span>
        <input type="hidden" name="add-to-cart" value="<?php echo absint( $product_woo_ck->get_id() ); ?>">
        <input type="hidden" name="product_id" value="<?php echo absint( $product_woo_ck->get_id() ); ?>">
        <input type="hidden" name="variation_id" class="variation_id" value="9">
        <input name="old_key" class="old_key" type="hidden" value="<?php echo $_POST['current_key_value']; ?>">
      </div>
    </div>
  </form>
  <?php
  die();
}
add_action('wp_ajax_productVariation', 'productVariation');
add_action('wp_ajax_nopriv_productVariation', 'productVariation');