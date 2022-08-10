<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<div class="l-container">
          <ul class="c-breadcrumb">
            <li><a href="#">Home</a></li>
            <li> <a href="#">Sản phẩm   </a></li>
            <li> <a href="#">Kính áp tròng nữ        </a></li>
            <li><?php single_cat_title(); ?></li>
          </ul>
        </div>
        <div class="l-container">
          <div class="m-pcategory">
            <div id="btn-filter" onClick="opent_filter()">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20 5H18.8293C18.4175 3.83481 17.3062 3 16 3C14.6938 3 13.5825 3.83481 13.1707 5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H13.1707C13.5825 8.16519 14.6938 9 16 9C17.3062 9 18.4175 8.16519 18.8293 7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5ZM16 7C16.5523 7 17 6.55228 17 6C17 5.44772 16.5523 5 16 5C15.4477 5 15 5.44772 15 6C15 6.55228 15.4477 7 16 7ZM3 12C3 11.4477 3.44772 11 4 11H5.17071C5.58254 9.83481 6.69378 9 8 9C9.30622 9 10.4175 9.83481 10.8293 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H10.8293C10.4175 14.1652 9.30622 15 8 15C6.69378 15 5.58254 14.1652 5.17071 13H4C3.44772 13 3 12.5523 3 12ZM8 13C8.55229 13 9 12.5523 9 12C9 11.4477 8.55229 11 8 11C7.44772 11 7 11.4477 7 12C7 12.5523 7.44772 13 8 13ZM4 17C3.44772 17 3 17.4477 3 18C3 18.5523 3.44772 19 4 19H13.1707C13.5825 20.1652 14.6938 21 16 21C17.3062 21 18.4175 20.1652 18.8293 19H20C20.5523 19 21 18.5523 21 18C21 17.4477 20.5523 17 20 17H18.8293C18.4175 15.8348 17.3062 15 16 15C14.6938 15 13.5825 15.8348 13.1707 17H4ZM17 18C17 18.5523 16.5523 19 16 19C15.4477 19 15 18.5523 15 18C15 17.4477 15.4477 17 16 17C16.5523 17 17 17.4477 17 18Z" fill="black"></path>
              </svg>
            </div>
            <div class="m-pcategory_inner">
              <div class="m-pcategory_filter" id="is_filter">
                <h5 class="title">FILTER</h5>
                <div class="m-pcategory_filter_inner">
                  <ul>
                    <li>Contact List</li>
                    <li>Contact List</li>
                    <li>Contact List</li>
                    <li>Contact List</li>
                    <li>Contact List</li>
                    <li>Contact List</li>
                    <li>Contact List</li>
                    <li>Contact List</li>
                  </ul>
                </div>
              </div>
              <div class="m-pcategory_list">
                <h5 class="title"><?php single_cat_title(); ?></h5>
                <div class="tool">
                  <div class="left"><a href="#">
                      <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 4.5H4V0.5H0V4.5ZM6 16.5H10V12.5H6V16.5ZM4 16.5H0V12.5H4V16.5ZM0 10.5H4V6.5H0V10.5ZM10 10.5H6V6.5H10V10.5ZM12 0.5V4.5H16V0.5H12ZM10 4.5H6V0.5H10V4.5ZM12 10.5H16V6.5H12V10.5ZM16 16.5H12V12.5H16V16.5Z" fill="#1E1C1C"></path>
                      </svg></a><a href="#">
                      <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 6.05547V3.83325H20V6.05547H0ZM0 11.6111H20V9.38883H0V11.6111ZM0 17.1666H20V14.9443H0V17.1666Z" fill="#1E1C1C"></path>
                      </svg></a></div>
                  <div class="right">
                    <p><strong>Hiển Thị</strong></p>
                    <form action="/">
                      <select id="per_page" name="orderby" onchange="this.form.submit">
                        <option value="">Tất cả</option>
                        <option value="popularity">Thứ tự theo mức độ phổ biến</option>
                      </select>
                      <input type="submit" value="Submit" hidden>
                    </form>
										<?php do_action( 'woocommerce_before_shop_loop' ); ?>
                  </div>
                </div>
								<?php
									if ( woocommerce_product_loop() ) {

										/**
										 * Hook: woocommerce_before_shop_loop.
										 *
										 * @hooked woocommerce_output_all_notices - 10
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 */
									//	do_action( 'woocommerce_before_shop_loop' );

										woocommerce_product_loop_start();

										if ( wc_get_loop_prop( 'total' ) ) {
											while ( have_posts() ) {
												the_post();

												/**
												 * Hook: woocommerce_shop_loop.
												 */
												//do_action( 'woocommerce_shop_loop' );

												wc_get_template_part('content-product-item');
											}
										}

										woocommerce_product_loop_end();

										/**
										 * Hook: woocommerce_after_shop_loop.
										 *
										 * @hooked woocommerce_pagination - 10
										 */
										//do_action( 'woocommerce_after_shop_loop' );
									} else {
										/**
										 * Hook: woocommerce_no_products_found.
										 *
										 * @hooked wc_no_products_found - 10
										 */
										do_action( 'woocommerce_no_products_found' );
									}
										/**
										 * Hook: woocommerce_after_main_content.
										 *
										 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
										 */
										do_action( 'woocommerce_after_main_content' );

								?>
									<?php do_action('woocommerce_pagination_tungnt'); ?>
              </div>

            </div>
          </div>
        </div>
<?php

get_footer( 'shop' );
