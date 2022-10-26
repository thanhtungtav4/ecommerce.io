<?php
function productData() {
  $params = array(
    'post_type' => 'product',
    'post__in' => array($_POST['id']),
  );
  $product = new WP_Query($params);
  $response = '';
  if ( $product->have_posts() ) :
    while ( $product->have_posts() ) : $product->the_post();
      $response .= get_template_part( 'template-parts/content', 'quickview' );
    endwhile;
  else  :
    $response = '';
  endif;
  wp_reset_query();
  echo $response;
  exit;
}
add_action('wp_ajax_productData', 'productData');
add_action('wp_ajax_nopriv_productData', 'productData');