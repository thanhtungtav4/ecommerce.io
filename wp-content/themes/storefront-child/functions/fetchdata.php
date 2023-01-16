<?php
/**
 * parameter ID category
 * return ids product
*/
  function fetchProductByCategoryID($id){
    $args = array(
      'post_type'             => 'product',
      'post_status'           => 'publish',
      'posts_per_page'        => '8',
      'tax_query'             => array(
          array(
              'taxonomy'      => 'product_cat',
              'field' => 'term_id', //This is optional, as it defaults to 'term_id'
              'terms'         => $id,
              'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
          ),
      )
  );
  $products = new WP_Query($args);
  var_dump($products);
}