<?php
/**
 * parameter type int
 * parameter include is product category id
 * return all id product for category id
 */
 function get_ProductByCategory($id = []){
  $all_ids = get_posts( array(
    'post_type' => 'product',
    'numberposts' => -1,
    'post_status' => 'publish',
    'fields' => 'ids',
    'tax_query' => array(
      array(
         'taxonomy' => 'product_cat',
         'field' => 'id',
         'terms' => array(15, 79),
         'operator' => 'IN',
      )
   ),
  ) );
 }