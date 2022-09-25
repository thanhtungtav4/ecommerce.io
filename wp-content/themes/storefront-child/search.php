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
get_header();
$type = $_GET['post_type'];
?>
   <main class="l-main">
        <?php if($type == "post")  : ?>
        <div class="m-search">
          <div class="l-container">
            <p class="ttl">Tổng hợp bài viết của <br class="only-pc">  CARAS LENS</p>
            <div class="m-search_inner">
              <form action="<?php echo home_url(); ?>" id="search-form" method="get"> 
                <input type="text"  name="s" placeholder="Bạn đang tìm kiếm" id="search">
                <input class="search-submit" type="submit" value="search">
                <input type="hidden" name="post_type" value="post" />
              </form>
            </div>
          </div>
        </div>
        <div class="m-noti">
          <div class="l-container">
            <p>Bạn đang “bị lạc đường” trong nguồn kiến thức của Caras? Bạn bị bối rối? Click chọn <br> các chủ đề bên dưới để tìm đúng bài viết bạn thực sự quan tâm!</p>
          </div>
        </div>
        <div class="m-category">
          <div class="l-container">
            <ul>
             
              <li><a href="/kien-thuc-kinh-ap-trong/">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.webp" type="image/webp">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" alt="Kính Áp Tròng" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Kính Áp Tròng</p></a></li>
              <li><a href="/kien-thuc-trang-diem/">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/trang-diem.webp" type="image/webp">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/trang-diem.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/trang-diem.jpg" alt="Trang Điểm" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Trang Điểm</p></a></li>
              <li><a href="/kien-thuc-trang-diem-mat/">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/trang-diem-mat.webp" type="image/webp">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/trang-diem-mat.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/trang-diem-mat.jpg" alt="Trang Điểm Mắt" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Trang Điểm Mắt</p></a></li>
              <li><a href="/kien-thuc-bao-ve-mat/">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bao-ve-mat.webp" type="image/webp">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bao-ve-mat.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" alt="Cách bảo vệ mắt" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Cách bảo vệ mắt</p></a></li>
              <li><a href="/kien-thuc-tat-khuc-xa-va-benh-ve-mat/">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tat-khuc-xa-va-benh-ve-mat.webp" type="image/webp">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tat-khuc-xa-va-benh-ve-mat.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/tat-khuc-xa-va-benh-ve-mat.jpg" alt="Tật khúc xạ & Các bệnh về mắt" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Tật khúc xạ & Các bệnh về mắt</p></a></li>
            </ul>
          </div>
        </div>
        <div class="l-container">
          <div class="m-news">
            <div class="m-ttl">
              <h5 class="title">Kết Quả tìm kiếm cho "<?php echo get_search_query() ?>"</h5>
              <h5 class="title only-pc">Bài viết mới nhất</h5>
            </div>
            <div class="m-news_inner">
                <div class="m-news_list"> 
            <?php
            if ( have_posts() ) :
                ?>
                <?php
                // Start the Loop.
                while ( have_posts() ) :
                    the_post();
                    ?>
                       <?php require( get_stylesheet_directory() . '/module/category_new_item.php' ); ?>
                    <?php
                endwhile;

                the_posts_pagination();

            else :

                echo 'No post';

            endif;
            ?>
            </div>
              <div class="m-news_item_siderbar">
                <h5 class="title only-sp">Bài viết mới nhất</h5>
                  <?php $args = array(
	                      'post_type' => 'post',
                        'post_status ' => 'publish',
                        'posts_per_page' => '5' );
                        $the_query = new WP_Query( $args );
                        if ( $the_query->have_posts() ) : 
	                ?>
                  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                  <div class="m-news_item">
                    <a href="<?php the_permalink() ?>">
                      <div class="m-news_img">
                        <picture>
                          <?php if( !empty(get_the_post_thumbnail()) ) : ?>
                            <img class="lazyload" src="<?php the_post_thumbnail_url('post-thumb', array( 'class' => 'lazyload' ));  ?>" data-src="<?php the_post_thumbnail_url('post-thumb', array( 'class' => 'lazyload' ));  ?>" alt="<?php the_title() ?>" loading="lazy" width="377" height="255">
                          <?php else : ?>
                            <img class="lazyload" src="<?php print_r(PlaceholderNews) ?>" data-src="<?php print_r(PlaceholderNews)  ?>" alt="<?php the_title() ?>" loading="lazy" width="377" height="255">
                          <?php endif; ?>   
                        </picture>
                      </div>
                      <div class="content">
                        <h4 class="truncate"><?php the_title() ?></h4>
                        <div class="info">
                          <p>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9925 0.5C3.8525 0.5 0.5 3.86 0.5 8C0.5 12.14 3.8525 15.5 7.9925 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 7.9925 0.5ZM8 14C4.685 14 2 11.315 2 8C2 4.685 4.685 2 8 2C11.315 2 14 4.685 14 8C14 11.315 11.315 14 8 14ZM7.25 4.25H8.375V8.1875L11.75 10.19L11.1875 11.1125L7.25 8.75V4.25Z" fill="#ABABAB"></path>
                            </svg><?php the_field('time_read') ?>p đọc
                          </p>
                          <p>
                            <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M0.833008 7C2.27467 3.34167 5.83301 0.75 9.99967 0.75C14.1663 0.75 17.7247 3.34167 19.1663 7C17.7247 10.6583 14.1663 13.25 9.99967 13.25C5.83301 13.25 2.27467 10.6583 0.833008 7ZM17.3497 7C15.9747 4.19167 13.158 2.41667 9.99967 2.41667C6.84134 2.41667 4.02467 4.19167 2.64967 7C4.02467 9.80833 6.83301 11.5833 9.99967 11.5833C13.1663 11.5833 15.9747 9.80833 17.3497 7ZM9.99967 4.91667C11.1497 4.91667 12.083 5.85 12.083 7C12.083 8.15 11.1497 9.08333 9.99967 9.08333C8.84967 9.08333 7.91634 8.15 7.91634 7C7.91634 5.85 8.84967 4.91667 9.99967 4.91667ZM6.24967 7C6.24967 4.93333 7.93301 3.25 9.99967 3.25C12.0663 3.25 13.7497 4.93333 13.7497 7C13.7497 9.06667 12.0663 10.75 9.99967 10.75C7.93301 10.75 6.24967 9.06667 6.24967 7Z" fill="#ABABAB"></path>
                            </svg>1100
                          </p>
                        </div>
                      </div>
                    </a>
                  </div>
                  <?php endwhile; ?>
                  <?php wp_reset_postdata(); ?>
                  <?php  endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if($type == "product")  : ?>
            
        <?php endif; ?>
        <div class="l-container mt-2">
            <?php require_once( get_stylesheet_directory() . '/module/footer_info.php' ); ?>
          </div>
      </main>
<?php
//do_action( 'storefront_sidebar' );
get_footer();
