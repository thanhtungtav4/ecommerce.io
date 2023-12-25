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
add_action( 'woocommerce_after_cart_contents_nt', 'woocommerce_cross_sell_display' );
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
         case 'VND': $currency_symbol = 'VNĐ/chiếc'; break;
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

/***
 * change price variable select in product page detail
 */
add_action('woocommerce_before_add_to_cart_form', 'selected_variation_price_replace_variable_price_range');
function selected_variation_price_replace_variable_price_range(){
    global $product;

    if( $product->is_type('variable') ):
    ?>
    <style> .woocommerce-variation-price {display:none;} </style>
    <script>
    jQuery(function($) {
        var p = 'p.price'
            q = $(p).html();

        $('form.cart').on('show_variation', function( event, data ) {
            if ( data.price_html ) {
                $(p).html(data.price_html);
            }
        }).on('hide_variation', function( event ) {
            $(p).html(q);
        });
    });
    </script>
    <?php
    endif;
}
/***
 * !change price variable select in product page detail
 */

/***
 * show min price in loop && !page prodcut detail
 */
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

/***
 * show min price in loop && !page prodcut detail
 */
add_action( 'woocommerce_before_cart_totals', 'custom_before_cart_totals' );
function custom_before_cart_totals() {
    print '<h2 class="ttl_cart">';
    print 'Total amount';
    print '</h2>';
}

function news_post() {

	if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {
		return;
	}
	$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) );

	$products = array_slice( $viewed_products, 0, 8 );

	//woocommerce_product_loop_start();
	echo '<div class="m-product">';
	echo '<div class="m-product_top">';
	echo "<h4>";
	echo _e('R1ecently viewed products', 'storefront');
	echo "</h4>";
	echo '<div class="m-product__nav">';
	echo  '<button class="m-item__prev">';
	echo	"<svg width='46' height='46' viewBox='0 0 46 46' fill='none' xmlns='http://www.w3.org/2000/svg'>";
	echo	  "<circle cx='23' cy='23' r='22' stroke-width='2'></circle>";
	echo	  "<path d='M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z'></path>";
	echo	'</svg>';
	echo  '</button>';
	echo  '<button class="m-item__next">';
	echo	"<svg width='46' height='46' viewBox='0 0 46 46' fill='none' xmlns='http://www.w3.org/2000/svg'>";
	echo	  "<circle cx='23' cy='23' r='22' stroke-width='2'></circle>";
	echo	  "<path d='M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z' fill='#2B2929'></path>";
	echo	'</svg>';
	echo  '</button>';
	echo '</div>';
	echo '</div>';
	echo '<ul>';
	echo '<div class="m-product__inner w-100">';
    echo '<ul class="m-item w-100">';
	foreach ( $products as $product ) :

			$post_object = get_post( $product );

			setup_postdata( $GLOBALS['post'] =& $post_object );

			wc_get_template_part( 'content', 'product-item' );

	endforeach;
	wp_reset_postdata();
	echo '</ul>';
	echo '</div>';

}

//add_action( 'woocommerce_after_cart', 'news_post', 2 );

