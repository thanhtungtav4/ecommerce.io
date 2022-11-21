<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header(); ?>

<main class="l-main">
        <div class="c-carousel">
          <div class="c-carousel_inner">
            <div class="c-carousel_item">
              <a href="#">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/launching-web.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/launching-web.webp" type="image/webp">
                  <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/launching-web.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/launching-web.jpg" alt="launching-web" width="1512" height="600">
                </picture></a></div>
            <div class="c-carousel_item">
              <a href="https://caraslens.com/bo-suu-tap-kinh-ap-trong-tu-nhien/">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lavier-collection-homepage.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lavier-collection-homepage.webp" type="image/webp">
                  <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lavier-collection-homepage.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lavier-collection-homepage.jpg" alt="lavier collection homepage" width="1512" height="600">
                </picture></a></div>
          </div>
        </div>
        <div class="l-container">
          <?php require_once( get_stylesheet_directory() . '/module/list_promotion.php' ); ?>
          <div class="m-product">
            <div class="m-product_top">
              <h4><?php _e('BEST SELLER', 'storefront') ?></h4>
              <div class="m-product__nav">
                <button class="m-product__prev m-product__prev001">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z"></path>
                  </svg>
                </button>
                <button class="m-product__next m-product__next001">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z" fill="#2B2929"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="/best-seller-contact-lenses/">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best-seller-contact-lens.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best-seller-contact-lens.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best-seller-contact-lens.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best-seller-contact-lens.jpg" alt="BEST SELLER - BÁN CHẠY NHẤT" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick m-product__slick001">
                <?php for ($i=0; $i < 2; $i++) { ?>
                  <li>
                    <ul>
                    <?php
                      $current_lang = $sitepress->get_current_language();
                      $cate_id = apply_filters( 'wpml_object_id', 142 , 'product_cat', TRUE  );
                      $count = 0;
                      // change category id here
                      $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 8,
                        'orderby' => 'date',
                        'suppress_filters' => 1,
                        'tax_query' => array(
                          array(
                            'taxonomy' => 'product_cat',
                            'terms' => $cate_id,
                            'operator' => 'IN',
                          ),
                      ),
                      );
                      $loop = new WP_Query( $args );
                      if ( $loop->have_posts() ) {
                        while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <?php
                        $image = get_the_post_thumbnail_url(get_the_ID(), 'product-thumb', array( 'class' => 'lazyload' ));
                    ?>
                    <?php require( get_stylesheet_directory() . '/module/product_item_loop.php' ); ?>
                    <?php
                        $count++;
                        endwhile;
                      }
                    ?>
                    </ul>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div class="m-product">
            <div class="m-product_top">
              <h4><?php _e('SCHOOL-TO-WORK CONTACT LENSES', 'storefront') ?></h4>
              <div class="m-product__nav">
                <button class="m-product__prev m-product__prev002">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z"></path>
                  </svg>
                </button>
                <button class="m-product__next m-product__next002">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z" fill="#2B2929"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="/lens-deo-di-hoc-va-di-lam/">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-tu-nhien.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-tu-nhien.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-tu-nhien.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-tu-nhien.jpg" alt="TỰ NHIÊN - ĐI HỌC ĐI LÀM" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick m-product__slick002">
                <?php for ($i=0; $i < 2; $i++) { ?>
                  <li>
                    <ul>
                    <?php
                      $current_lang = $sitepress->get_current_language();
                      $cate_id = apply_filters( 'wpml_object_id', 63 , 'product_cat', TRUE  );
                      $count = 0;
                      // change category id here
                      $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 8,
                        'orderby' => 'date',
                        'suppress_filters' => 1,
                        'tax_query' => array(
                          array(
                            'taxonomy' => 'product_cat',
                            'terms' => $cate_id,
                            'operator' => 'IN',
                          ),
                      ),
                      );
                      $loop = new WP_Query( $args );
                      if ( $loop->have_posts() ) {
                        $firstLoop = true;
                        while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <?php
                             $image = get_the_post_thumbnail_url(get_the_ID(), 'product-thumb', array( 'class' => 'lazyload' ));
                            ?>
                        <?php require( get_stylesheet_directory() . '/module/product_item_loop.php' ); ?>
                        <?php
                        $count++;
                        endwhile;
                      }
                    ?>
                    </ul>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div class="m-product">
            <div class="m-product_top">
              <h4><?php _e('LIGHT COLOR - HANG OUT, TAKE A PHOTO', 'storefront') ?></h4>
              <div class="m-product__nav">
                <button class="m-product__prev m-product__prev003">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z"></path>
                  </svg>
                </button>
                <button class="m-product__next m-product__next003">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z" fill="#2B2929"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-sang-mau.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-sang-mau.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-sang-mau.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-sang-mau.jpg" alt="<?php the_title() ?>" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick m-product__slick003">
                <?php for ($i=0; $i < 2; $i++) { ?>
                  <li>
                    <ul>
                    <?php
                      $current_lang = $sitepress->get_current_language();
                      $cate_id = apply_filters( 'wpml_object_id', 64 , 'product_cat', TRUE  );
                      $count = 0;
                      // change category id here
                      $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 8,
                        'orderby' => 'date',
                        'suppress_filters' => 1,
                        'tax_query' => array(
                          array(
                            'taxonomy' => 'product_cat',
                            'terms' => $cate_id,
                            'operator' => 'IN',
                          ),
                      ),
                      );
                      $loop = new WP_Query( $args );
                      if ( $loop->have_posts() ) {
                        $firstLoop = true;
                        while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <?php
                             $image = get_the_post_thumbnail_url(get_the_ID(), 'product-thumb', array( 'class' => 'lazyload' ));
                            ?>
                          <?php require( get_stylesheet_directory() . '/module/product_item_loop.php' ); ?>
                        <?php
                        $count++;
                        endwhile;
                      }
                    ?>
                    </ul>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div class="m-product">
            <div class="m-product_top">
              <h4><?php _e('FOR MEN', 'storefront') ?></h4>
              <div class="m-product__nav m-product__nav004">
                <button class="m-product__prev m-product__prev004">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z"></path>
                  </svg>
                </button>
                <button class="m-product__next m-product__next004">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z" fill="#2B2929"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-nam-homepage.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-nam-homepage.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-nam-homepage.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-nam-homepage.jpg" alt="<?php the_title() ?>" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick m-product__slick004">
                <?php for ($i=0; $i < 2; $i++) { ?>
                  <li>
                    <ul class="item_show">
                    <?php
                      $current_lang = $sitepress->get_current_language();
                      $cate_id = apply_filters( 'wpml_object_id', 61 , 'product_cat', TRUE  );
                      $count = 0;
                      // change category id here
                      $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 8,
                        'orderby' => 'date',
                        'suppress_filters' => 1,
                        'tax_query' => array(
                          array(
                            'taxonomy' => 'product_cat',
                            'terms' => $cate_id,
                            'operator' => 'IN',
                          ),
                      ),
                      );
                      $loop = new WP_Query( $args );
                      if ( $loop->have_posts() ) {
                        $firstLoop = true;
                        while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <?php
                             $image = get_the_post_thumbnail_url(get_the_ID(), 'product-thumb', array( 'class' => 'lazyload' ));
                            ?>
                            <?php require( get_stylesheet_directory() . '/module/product_item_loop.php' ); ?>
                        <?php
                        $count++;
                        endwhile;
                      }
                    ?>
                    </ul>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div class="m-product">
            <div class="m-product_top">
              <h4><?php _e('SPECIALIZED MEDICAL CONTACT LENSES', 'storefront') ?></h4>
              <div class="m-product__nav">
                <button class="m-product__prev m-product__prev005">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z"></path>
                  </svg>
                </button>
                <button class="m-product__next m-product__next005">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z" fill="#2B2929"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="/lens-trong-suot/">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-y-te-homepage.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-y-te-homepage.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-y-te-homepage.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lens-y-te-homepage.jpg" alt="<?php the_title() ?>" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick m-product__slick005">
                <?php for ($i=0; $i < 2; $i++) { ?>
                  <li>
                    <ul>
                    <?php
                      $current_lang = $sitepress->get_current_language();
                      $cate_id = apply_filters( 'wpml_object_id', 60 , 'product_cat', TRUE  );
                      $count = 0;
                      // change category id here
                      $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 8,
                        'orderby' => 'date',
                        'suppress_filters' => 1,
                        'tax_query' => array(
                          array(
                            'taxonomy' => 'product_cat',
                            'terms' => $cate_id,
                            'operator' => 'IN',
                          ),
                      ),
                      );
                      $loop = new WP_Query( $args );
                      if ( $loop->have_posts() ) {
                        $firstLoop = true;
                        while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <?php
                              $image = get_the_post_thumbnail_url(get_the_ID(), 'product-thumb', array( 'class' => 'lazyload' ));
                            ?>
                            <?php require( get_stylesheet_directory() . '/module/product_item_loop.php' ); ?>
                        <?php
                        $count++;
                        endwhile;
                      }
                    ?>
                    </ul>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div class="m-product">
            <div class="m-product_top">
              <h4><?php _e('CONTACT LENS ACCESSORIES', 'storefront') ?></h4>
              <div class="m-product__nav">
                <button class="m-product__prev m-product__prev006">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z"></path>
                  </svg>
                </button>
                <button class="m-product__next m-product__next006">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z" fill="#2B2929"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="/phu-kien-lens/">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/phu-kien-lens-homepage.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/phu-kien-lens-homepage.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/phu-kien-lens-homepage.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/phu-kien-lens-homepage.jpg" alt="phu kien lens" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick m-product__slick006">
                <?php for ($i=0; $i < 2; $i++) { ?>
                  <li>
                    <ul class="item_show_">
                    <?php
                      $current_lang = $sitepress->get_current_language();
                      $cate_id = apply_filters( 'wpml_object_id', 75 , 'product_cat', TRUE  );
                      $count = 0;
                      // change category id here
                      $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 8,
                        'orderby' => 'date',
                        'suppress_filters' => 1,
                        'tax_query' => array(
                          array(
                            'taxonomy' => 'product_cat',
                            'terms' => $cate_id,
                            'operator' => 'IN',
                          ),
                      ),
                      );
                      $loop = new WP_Query( $args );
                      if ( $loop->have_posts() ) {
                        $firstLoop = true;
                        while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <?php
                             $image = get_the_post_thumbnail_url(get_the_ID(), 'product-thumb', array( 'class' => 'lazyload' ));
                            ?>
                            <?php require( get_stylesheet_directory() . '/module/product_item_loop.php' ); ?>
                        <?php
                        $count++;
                        endwhile;
                      }
                    ?>
                    </ul>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div class="c-experience">
            <h4>NHỮNG CON SỐ BIẾT NÓI VÀ TRẢI NGHIỆM MUA SẮM</h4>
            <div class="c-experience__inner">
              <div class="image">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dong-lens-carase.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dong-lens-carase.webp" type="image/webp">
                  <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dong-lens-carase.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dong-lens-carase.png" alt="NHỮNG CON SỐ BIẾT NÓI VÀ TRẢI NGHIỆM MUA SẮM" loading="lazy" width="552" height="462">
                </picture>
              </div>
              <ul>
                <li>
                  <h5>Hơn 80.000 khách hàng mỗi năm</h5>
                  <p>CARAS.E - Thương hiệu Kính Áp Tròng được tin dùng bởi chất lượng theo tiêu chuẩn Mỹ, tích hợp công nghệ hiện đại, tiên tiến nhất, mang đến đôi mắt sáng khoẻ cho hơn 80.000 khách hàng.</p>
                </li>
                <li>
                  <h5>8 Năm kinh nghiệm</h5>
                  <p>CARAS.E với hơn 8 năm hoạt động trên thị trường, tự hào mang đến các giải pháp giúp <br>
                  khách hàng đẹp hơn, tự tin hơn, và có trải nghiệm mua sắm trên mức mong đợi - Thương hiệu kính áp tròng hàng đầu trong lòng người tiêu dùng.</p>
                </li>
                <li>
                  <h5>Hơn 50 mẫu mã lựa chọn</h5>
                  <p>CARAS.E - Nhãn hàng đầu tiên sở hữu kính áp tròng cỡ nhỏ an toàn và chuẩn với mắt của người châu Á. Chúng tôi cung cấp hơn 50 mẫu sản phẩm kính áp tròng đa dạng cho khách hàng thoải mái lựa chọn.</p>
                </li>
              </ul>
            </div>
          </div>
          <?php require( get_stylesheet_directory() . '/module/shopservice.php' ); ?>
          <div class="m-product">
            <div class="m-product_top">
              <h4>TIN TỨC</h4>
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

        </div>
      </main>
<?php
get_footer();
