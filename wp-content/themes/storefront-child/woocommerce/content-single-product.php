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
    <li><a href="#">Home</a></li>
    <li> <a href="#">Sản phẩm</a></li>
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
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
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
          <div class="m-product">
            <div class="m-product_top">
              <h4>KÍNH Y TẾ CHUYÊN DỤNG</h4>
              <div class="m-product__nav">
                <button class="m-product__prev">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z"></path>
                  </svg>
                </button>
                <button class="m-product__next">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z" fill="#2B2929"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="m-product__inner w-100">
              <ul class="m-product__slick m-product__slick02 w-100">
                <li>
                  <ul>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
                <li>
                  <ul>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          <div class="c-info">
            <div class="list">
              <h4>KÍNH Y TẾ CHUYÊN DỤNG</h4>
              <ul>
                <li> <a href="#">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info.jpg" alt="info" loading="lazy" width="667" height="132">
                    </picture></a></li>
                <li> <a href="#">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info02.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info02.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info02.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info02.jpg" alt="info" loading="lazy" width="667" height="132">
                    </picture></a></li>
                <li> <a href="#">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info03.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info03.webp" type="image/webp">
                    </picture><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info03.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/info03.jpg" alt="info" loading="lazy" width="667" height="132"></a></li>
              </ul>
            </div>
            <div class="video">
              <h4>KÍNH Y TẾ CHUYÊN DỤNG</h4><a href="#">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtubeItem.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtubeItem.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtubeItem.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtubeItem.jpg" alt="info" loading="lazy" width="664" height="421">
                </picture></a>
            </div>
          </div>
        </div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
