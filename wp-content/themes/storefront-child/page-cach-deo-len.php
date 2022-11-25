<?php
   /**
    * The template for displaying all pages.
    *
    * This is the template that displays all pages by default.
    * Please note that this is the WordPress construct of pages
    * and that other 'pages' on your WordPress site will use a
    * different template.
    *
    * @package storefront
    */
   get_header(); ?>
<main class="l-main">
   <div class="m-docs">
      <div class="m-docs_top">
         <h1 class="m-ttl">THƯ VIỆN KIẾN THỨC KÍNH ÁP TRÒNG - CARAS.E</h1>
      </div>
      <div class="l-container">
         <nav class="m-docs_nav">
            <a href="#kien-thuc-co-ban-ve-contact-lens">Kiến thức cơ bản về contact lens</a>
            <a href="#chuan-bi-truoc-khi-mua-lens">Chuẩn bị trước khi mua lens</a>
            <a href="#kien-thuc-cho-nguoi-moi-deo-lens">Kiến thức cho người mới đeo lens</a>
            <a href="#kien-thuc-cho-nguoi-deo-lens-lau-nam">Kiến thức cho người đeo lens lâu năm</a>
            <a href="#life-and-contact-lens">Life & Contact Lens</a>
         </nav>
         <div class="m-product" id="kien-thuc-co-ban-ve-contact-lens">
            <div class="m-product_top">
               <h4>KIẾN THỨC CƠ BẢN VỀ CONTACT LENS</h4>
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
                  $args = array(
                    'post_type'   => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 5,
                  );
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
         <a class="m-btn" href="#">Xem Toàn bộ</a>
         <div class="m-product" id="chuan-bi-truoc-khi-mua-lens">
            <div class="m-product_top">
               <h4>ĐỌC GÌ TRƯỚC KHI MUA LENS?</h4>
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
                $args = array(
                  'post_type'   => 'post',
                  'post_status' => 'publish',
                  'posts_per_page' => 5,
                );
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
         <a class="m-btn" href="#">Xem Toàn bộ</a>
         <div class="m-docs_post" id="kien-thuc-cho-nguoi-moi-deo-lens">
            <h2>KIẾN THỨC CHO NGƯỜI MỚI ĐEO LENS</h2>
            <div class="m-docs_inner">
               <h3 class="m-ttl3">Ngày 1</h3>
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
                    'posts_per_page' => 3,
                  );
                }
                $the_query = new WP_Query($args);
                if($the_query->have_posts()):
                while ( $the_query->have_posts() ) : $the_query->the_post();
                $image = get_the_post_thumbnail_url(get_the_ID(), array(350, 222), array( 'class' => 'lazyload' ));
              ?>
                <div class="m-docs_item">
                  <a href="#">Tư vấn các vấn đề về thẻ tín dụng, vay tín chấp các ngân hàng</a>
                  <div class="m-docs_info">
                     <a href="#">Marketing </a>
                     <p>14 MIN READ</p>
                  </div>
                </div>
              <?php
                endwhile;
                endif;
                // Reset Post Data
                wp_reset_postdata();
              ?>
            </div>
            <div class="m-docs_inner">
               <h3 class="m-ttl3">Ngày 2</h3>
               <div class="m-docs_item">
                  <a href="#">Tư vấn các vấn đề về thẻ tín dụng, vay tín chấp các ngân hàng</a>
                  <div class="m-docs_info">
                     <a href="#">Marketing </a>
                     <p>14 MIN READ</p>
                  </div>
               </div>
            </div>
            <div class="m-docs_inner">
               <h3 class="m-ttl3">Ngày 3</h3>
               <div class="m-docs_item">
                  <a href="#">Tư vấn các vấn đề về thẻ tín dụng, vay tín chấp các ngân hàng</a>
                  <div class="m-docs_info">
                     <a href="#">Marketing </a>
                     <p>14 MIN READ</p>
                  </div>
               </div>
            </div>
            <div class="m-docs_inner">
               <h3 class="m-ttl3">Ngày 4</h3>
               <div class="m-docs_item">
                  <a href="#">Tư vấn các vấn đề về thẻ tín dụng, vay tín chấp các ngân hàng</a>
                  <div class="m-docs_info">
                     <a href="#">Marketing </a>
                     <p>14 MIN READ</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="m-product" id="kien-thuc-cho-nguoi-deo-lens-lau-nam">
            <div class="m-product_top">
               <h4>KIẾN THỨC CHO NGƯỜI ĐEO LENS LÂU NĂM</h4>
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
                  $args = array(
                    'post_type'   => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 5,
                  );
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
         <a class="m-btn" href="#">Xem Toàn bộ</a>
         <div class="m-product" id="life-and-contact-lens">
            <div class="m-product_top">
               <h4>LIFE & CONTACT LENS</h4>
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
                  $args = array(
                    'post_type'   => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 5,
                  );
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
         <a class="m-btn" href="#">Xem Toàn bộ</a>
      </div>
   </div>
</main>
<?php
get_footer();