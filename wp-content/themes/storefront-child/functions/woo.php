<?php
//auto update cart number item by ajax
add_filter( 'woocommerce_add_to_cart_fragments', 'refresh_cart_count', 50, 1 );
function refresh_cart_count( $fragments ){
    ob_start();
    ?>
    <span class="m-cart_num" id="m-cart_num"><?php
    $cart_count = WC()->cart->get_cart_contents_count();
    echo sprintf ( _n( '%d', '%d', $cart_count ), $cart_count );
    ?></span>
    <?php
     $fragments['#m-cart_num'] = ob_get_clean();
    return $fragments;
}
//auto update cart number item by ajax

//Move of Cross-Sells in page cart
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart_contents', 'woocommerce_cross_sell_display' );
//Move of Cross-Sells in page cart

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
   global $post, $product;
   if ( has_term( 'phu-kien-lens', 'product_cat' ) ) {
      switch( $currency ) {
         case 'VND': $currency_symbol = 'VNĐ'; break;
         }
   }
   else{
      switch( $currency ) {
         case 'VND': $currency_symbol = 'VNĐ/cặp'; break;
         }
   }

   return $currency_symbol;
}

// custome add to cart btn
// Dynamically Update Variable Product Price With Current Variation Price
add_action( 'woocommerce_variable_add_to_cart', 'bbloomer_update_price_with_variation_price' );

function bbloomer_update_price_with_variation_price() {
   global $product;
   $price = $product->get_price_html();
   wc_enqueue_js( "
      $(document).on('found_variation', 'form.cart', function( event, variation ) {
         if(variation.price_html) $('.summary > p.price').html(variation.price_html);
         $('.woocommerce-variation-price').hide();
      });
      $(document).on('hide_variation', 'form.cart', function( event, variation ) {
         $('.summary > p.price').html('" . $price . "');
      });
   " );
}
// !Dynamically Update Variable Product Price With Current Variation Price
//Luôn hiển thị giá biến thể đơn
add_filter( 'woocommerce_show_variation_price', '__return_true' );
//!Luôn hiển thị giá biến thể đơn

remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );

add_action('woocommerce_pagination_tungnt', 'add_woocommerce_pagination');
function add_woocommerce_pagination(){
   woocommerce_pagination();
}

add_filter('woocommerce_variable_sale_price_html', 'shop_variable_product_price', 10, 2);
add_filter('woocommerce_variable_price_html','shop_variable_product_price', 10, 2 );
function shop_variable_product_price( $price, $product ){
   if(!is_product()){
      $variation_min_reg_price = $product->get_variation_regular_price('min', true);
      $variation_min_sale_price = $product->get_variation_sale_price('min', true);
      if ( $product->is_on_sale() && !empty($variation_min_sale_price)){
          if ( !empty($variation_min_sale_price) )
              $price = '<del class="strike">' .  wc_price($variation_min_reg_price) . '</del>
          <ins class="highlight">' .  wc_price($variation_min_sale_price) . '</ins>';
      } else {
          if(!empty($variation_min_reg_price))
              $price = '<ins class="highlight">'.wc_price( $variation_min_reg_price ).'</ins>';
          else
              $price = '<ins class="highlight">'.wc_price( $product->regular_price ).'</ins>';
      }
      return $price;
   }
   return $price;
}