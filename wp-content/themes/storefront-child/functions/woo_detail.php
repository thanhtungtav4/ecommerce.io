<?php
//Data Tab
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
add_action('tungnt_woocommerce_output_product_data_tabs', 'nt_woocommerce_output_product_data_tabs');
function nt_woocommerce_output_product_data_tabs(){
  woocommerce_output_product_data_tabs();
}
//Data Tab