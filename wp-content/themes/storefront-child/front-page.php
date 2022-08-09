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
            <div class="c-carousel_item"><a href="#">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/carousel.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/carousel.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/carousel.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/carousel.jpg" alt="Logo" width="1512" height="600">
                </picture></a></div>
            <div class="c-carousel_item"><a href="#">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/carousel.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/carousel.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/carousel.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/carousel.jpg" alt="Logo" loading="lazy" width="1512" height="600">
                </picture></a></div>
          </div>
        </div>
        <div class="l-container">
          <?php require_once( get_stylesheet_directory() . '/module/list_promotion.php' ); ?>
          <div class="m-product">
            <div class="m-product_top">
              <h4><?php _e('BEST SELLER', 'storefront') ?></h4>
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
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="Logo" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick">
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
                        $image = get_the_post_thumbnail_url(get_the_ID(), array(307, 307), array( 'class' => 'lazyload' ));
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
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="Logo" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick">
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
                             $image = get_the_post_thumbnail_url(get_the_ID(), array(307, 307), array( 'class' => 'lazyload' ));
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
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="<?php the_title() ?>" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick">
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
                             $image = get_the_post_thumbnail_url(get_the_ID(), array(307, 307), array( 'class' => 'lazyload' ));
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
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="<?php the_title() ?>" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick">
                <?php for ($i=0; $i < 2; $i++) { ?>
                  <li>
                    <ul>
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
                             $image = get_the_post_thumbnail_url(get_the_ID(), array(307, 307), array( 'class' => 'lazyload' ));
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
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="<?php the_title() ?>" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick">
                <?php for ($i=0; $i < 2; $i++) { ?>
                  <li>
                    <ul>
                    <?php
                      $current_lang = $sitepress->get_current_language();
                      $cate_id = apply_filters( 'wpml_object_id', 68 , 'product_cat', TRUE  );
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
                             $image = get_the_post_thumbnail_url(get_the_ID(), array(307, 307), array( 'class' => 'lazyload' ));
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
            <div class="m-product__inner">
              <div class="m-product__gallery">
                 <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="<?php the_title() ?>" loading="lazy" width="666" height="912">
                  </picture>
                </a>
              </div>
              <ul class="m-product__slick">
                <?php for ($i=0; $i < 2; $i++) { ?>
                  <li>
                    <ul>
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
                             $image = get_the_post_thumbnail_url(get_the_ID(), array(307, 307), array( 'class' => 'lazyload' ));
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
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" alt="NHỮNG CON SỐ BIẾT NÓI VÀ TRẢI NGHIỆM MUA SẮM" loading="lazy" width="552" height="462">
                </picture>
              </div>
              <ul>
                <li>
                  <h5>Hơn 30.000 khách hàng mỗi năm</h5>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </li>
                <li>
                  <h5>7 năm kinh nghiệm</h5>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </li>
                <li>
                  <h5>Hơn 50 mẫu mã lựa chọn</h5>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </li>
              </ul>
            </div>
          </div>
          <div class="c-shopservice">
            <div class="c-shopservice__inner">
              <div class="c-shopservice__item">
                <h5 class="ttl">PHƯƠNG CHÂM BÁN HÀNG</h5>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" alt="service01" loading="lazy" width="323" height="520">
                </picture>
              </div>
              <div class="c-shopservice__item">
                <h5 class="ttl">SẢN PHẨM VÀ DỊCH VỤ</h5>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" alt="service01" loading="lazy" width="323" height="520">
                </picture>
              </div>
              <div class="c-shopservice__item">
                <h5 class="ttl">CHĂM SÓC KHÁCH HÀNG</h5>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" alt="service01" loading="lazy" width="323" height="520">
                </picture>
              </div>
              <div class="c-shopservice__item">
                <h5 class="ttl">GIAO HÀNG, ĐỔI TRẢ VÀ BẢO HÀNH</h5>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" alt="service01" loading="lazy" width="323" height="520">
                </picture>
              </div>
            </div>
          </div>
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
              <li><a href>
                  <div class="m-new__img">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" alt="item new" loading="lazy" width="437" height="278">
                    </picture>
                  </div>
                  <div class="m-new__content">
                    <h3 class="strong">Hướng dẫn các bước skincare từ cơ bản tới nâng cao</h3>
                    <p class="m-date"><i class="gg-calendar-dates"></i>Tháng Sáu 18, 2021</p>
                    <p>Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và...</p>
                  </div></a></li>
              <li><a href>
                  <div class="m-new__img">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" alt="item new" loading="lazy" width="437" height="278">
                    </picture>
                  </div>
                  <div class="m-new__content">
                    <h3 class="strong">Hướng dẫn các bước skincare từ cơ bản tới nâng cao</h3>
                    <p class="m-date"><i class="gg-calendar-dates"></i>Tháng Sáu 18, 2021</p>
                    <p>Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và...</p>
                  </div></a></li>
              <li><a href>
                  <div class="m-new__img">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" alt="item new" loading="lazy" width="437" height="278">
                    </picture>
                  </div>
                  <div class="m-new__content">
                    <h3 class="strong">Hướng dẫn các bước skincare từ cơ bản tới nâng cao</h3>
                    <p class="m-date"><i class="gg-calendar-dates"></i>Tháng Sáu 18, 2021</p>
                    <p>Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và...</p>
                  </div></a></li>
              <li><a href>
                  <div class="m-new__img">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" alt="item new" loading="lazy" width="437" height="278">
                    </picture>
                  </div>
                  <div class="m-new__content">
                    <h3 class="strong">Hướng dẫn các bước skincare từ cơ bản tới nâng cao</h3>
                    <p class="m-date"><i class="gg-calendar-dates"></i>Tháng Sáu 18, 2021</p>
                    <p>Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và...</p>
                  </div></a></li>
              <li><a href>
                  <div class="m-new__img">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" alt="item new" loading="lazy" width="437" height="278">
                    </picture>
                  </div>
                  <div class="m-new__content">
                    <h3 class="strong">Hướng dẫn các bước skincare từ cơ bản tới nâng cao</h3>
                    <p class="m-date"><i class="gg-calendar-dates"></i>Tháng Sáu 18, 2021</p>
                    <p>Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và...</p>
                  </div></a></li>
              <li><a href>
                  <div class="m-new__img">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" alt="item new" loading="lazy" width="437" height="278">
                    </picture>
                  </div>
                  <div class="m-new__content">
                    <h3 class="strong">Hướng dẫn các bước skincare từ cơ bản tới nâng cao</h3>
                    <p class="m-date"><i class="gg-calendar-dates"></i>Tháng Sáu 18, 2021</p>
                    <p>Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và Đối với các tín đồ làm đẹp, chắc hẳn thuật ngữ skincare đã dần trở nên quen thuộc và...</p>
                  </div></a></li>
            </ul>
          </div>
         
        </div>
      </main>
<?php
get_footer();
