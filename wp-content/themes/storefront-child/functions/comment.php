<?php
/**
 * parameter type int
 * parameter include is product category id
 * return all id product for category id
 */
 function get_ProductByCategory($id = []){
  $product_args = array(
    'post_status' => 'publish',
    'limit' => -1,
    'field'    => 'ids',
    // 'category__in' => 82,
    //more options according to wc_get_products() docs
  );
  $products = wc_get_products($product_args);
  var_dump($products);
 }