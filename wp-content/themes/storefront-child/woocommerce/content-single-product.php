<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div class="l-container">
  <ul class="c-breadcrumb">
    <li><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE : print get_site_url().'/');   ?>"><?php _e('Home', 'storefront') ?></a></li>
    <!-- <li> <a href="#">Sản phẩm</a></li> -->
    <?php
      $primary_term_id = yoast_get_primary_term_id('product_cat');
      $postTerm = get_term( $primary_term_id );
      $is_lang = ICL_LANGUAGE_CODE == 'en' ? 'en/' : '';
      if ( $postTerm && ! is_wp_error( $postTerm ) ) {
        echo '<li><a href="' .  esc_url(get_site_url().'/'. $is_lang . $postTerm->slug) .'">';
        echo $postTerm->name;
        echo '</a></li>';
      }
    ?>
    <li></li>
    <li><?php echo the_title(); ?></li>
  </ul>
<?php  do_action('woocommerce_rating_custome')?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generateWs_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
		<div class="single_top">
	  		<?php do_action('nt_woocommerce_template_single_title'); ?>
			<?php do_action('nt_woocommerce_template_single_price'); ?>
		</div>
		<div class="single_top">
			<?php do_action( 'nt_woocommerce_template_single_add_to_cart' ); ?>
		</div>
		<a href="/kien-thuc-kinh-ap-trong-hub/" target="_blank" class="how_to">Hướng dẫn tính độ cận - loạn</a>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	//do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>
	<?php require_once( get_stylesheet_directory() . '/module/list_promotion.php' ); ?>
	<?php
		/**
		 * Hook: tungnt custome position view data_tabs
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 */
		do_action( 'tungnt_woocommerce_output_product_data_tabs' );
	?>
	
	<?php  require_once( get_stylesheet_directory() . '/module/detail_list_product_suggest.php' ); ?>
	<div class="m-product">
            <div class="m-product_top">
              <h4><?php _e('NEWS', 'storefront'); ?></h4>
              <div class="m-product__nav">
                <button class="m-product__prev m-new__prev">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z"></path>
                  </svg>
                </button>
                <button class="m-product__next m-new__next">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z" fill="#2B2929"></path>
                  </svg>
                </button>
              </div>
            </div>
            <ul class="m-new__slick w-100">
            <?php
                if(get_field('list_news_show', 'option')){
                  $args = array(
                    'post_type'   => 'post',
                    'post_status' => 'publish',
                    'post__in' => get_field('list_news_show', 'option'),
                  );
                }
                else{
                  $args = array(
                    'post_type'   => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 5,
                  );
                }
                $the_query = new WP_Query($args);
                if($the_query->have_posts()):
                while ( $the_query->have_posts() ) : $the_query->the_post();
                $image = get_the_post_thumbnail_url(get_the_ID(), array(350, 222), array( 'class' => 'lazyload' ));
              ?>
                <?php require( get_stylesheet_directory() . '/module/new_item_loop.php' ); ?>
              <?php
                endwhile;
                endif;
                // Reset Post Data
                wp_reset_postdata();
              ?>
            </ul>
          </div>
	<?php  require_once( get_stylesheet_directory() . '/module/footer_info.php' ); ?>
	
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
