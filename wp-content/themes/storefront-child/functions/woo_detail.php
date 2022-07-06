<?php
//Data Tab
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
add_action('tungnt_woocommerce_output_product_data_tabs', 'nt_woocommerce_output_product_data_tabs');
function nt_woocommerce_output_product_data_tabs(){
  woocommerce_output_product_data_tabs();
}
//Data Tab
//Move rating
// add_action('woocommerce_rating_custome', 'single_rating_display');
// function single_rating_display(){
//   woocommerce_template_single_rating();
// }
//Move rating