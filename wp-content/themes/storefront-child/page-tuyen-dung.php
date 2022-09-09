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
// Get all term ID's in a given taxonomy
$taxonomy_terms_location = get_terms( 'location', array(
  'hide_empty' => 0,
) );
$taxonomy_terms_linh_vuc = get_terms( 'linh_vuc', array(
'hide_empty' => 0,
) );
$args = array(
'post_type' => 'tuyen_dung', // we will sort posts by date
'post_status' => 'publish',
'orderby'     => 'title',
'order'       => 'ASC',
'posts_per_page' => '6',
'suppress_filters' => 1,
);
get_header(); ?>
      <main class="l-main">
      <div class="m-search job">
          <div class="l-container">
            <p class="ttl">CƠ HỘI VIỆC LÀM CÙNG <br class="only-pc">  CARAS LENS</p>
            <div class="m-search_inner">
              <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="job_filter">
                <input type="text" name="title" placeholder="Bạn đang tìm kiếm" id="search">
                <select id="jobname" name="jobname">
                  <option value="" selected>Chọn Công việc</option>
                  <?php if($taxonomy_terms_linh_vuc) : ?>
                    <?php foreach($taxonomy_terms_linh_vuc as $key => $item) :?>
                      <option value="<?php echo $item->slug ?>"><?php echo $item->name ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <select id="location" name="location">
                  <option value="" selected>Chọn Vị Trí</option>
                  <?php if($taxonomy_terms_location) : ?>
                    <?php foreach($taxonomy_terms_location as $key => $item) :?>
                      <option value="<?php echo $item->slug ?>"><?php echo $item->name ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <input type="hidden" name="action" value="filter_job_action">
                <input class="search-submit" type="submit" value="search">
              </form>
              <ul>
                <li class="key">KEYWORD</li>
                <li><a hrer="#">Full-time</a></li>
                <li><a hrer="#">Part-time</a></li>
                <li><a hrer="#">Nhân viên Bán hàng</a></li>
                <li><a hrer="#">Designer</a></li>
                <li><a hrer="#">Hà Nội</a></li>
                <li><a hrer="#">Hồ Chí Minh</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="l-container">
          <div class="m-product mt-2">
            <div class="m-product_top">
            </div>
            <ul class="m-new__slick job w-100" id="response">
            </ul>
          </div>
          <div class="m-job">
            <h2 class="ttl">LÀM VIỆC TẠI CARAS</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id diam vel quam elementum pulvinar etiam. Massa tincidunt dui ut ornare lectus sit amet est placerat. Egestas purus viverra accumsan in. Arcu cursus vitae congue mauris rhoncus aenean. Non nisi est sit amet facilisis magna etiam. Augue lacus viverra vitae congue eu.</p>
          </div>
          <div class="c-sure">
            <ul class="slick-sure">
              <li>
                <p>Freeship nội thành cho đơn <strong>từ 250.000đ</strong>– Tỉnh <strong>từ 400.000đ</strong></p>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/delivery_icon.svg" type="image/svg"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/delivery_icon.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/delivery_icon.png" alt="Freeship nội thành cho đơn từ 250.000đ – Tỉnh từ 400.000đ" loading="lazy" width="161" height="134">
                </picture>
              </li>
              <li>
                <p>Khám thị lực và tư vấn <strong>miễn phí </strong>(đặt lịch trước)</p>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/eye_icon.svg" type="image/svg"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/eye_icon.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/eye_icon.jpg" alt="Khám thị lực và tư vấn miễn phí (đặt lịch trước)" loading="lazy" width="161" height="134">
                </picture>
              </li>
              <li>
                <p>Thanh toán <strong>quẹt thẻ tận nơi </strong>(áp dụng nội thành HN, TP.HCM)</p>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/credit_icon.svg" type="image/svg"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/credit_icon.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/credit_icon.jpg" alt="Thanh toán quẹt thẻ tận nơi (áp dụng nội thành HN, TP.HCM)" loading="lazy" width="161" height="134">
                </picture>
              </li>
              <li>
                <p>Chế độ bảo <strong>hành vàng cho </strong>trường hợp rách, xước, đồ cộm  </p>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thumb_icon.svg" type="image/svg"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thumb_icon.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thumb_icon.jpg" alt="Chế độ bảo hành vàng cho trường hợp rách, xước, đồ cộm" loading="lazy" width="161" height="134">
                </picture>
              </li>
            </ul>
          </div>
          <div class="m-job prosper">
            <h2 class="ttl">THÀNH TỰU CỦA CARAS</h2>
            <div class="m-job_inner">
              <div class="image">
                <ul>
                  <li>
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" alt="THÀNH TỰU CỦA CARAS" loading="lazy" width="323" height="290">
                    </picture>
                  </li>
                  <li>
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" alt="THÀNH TỰU CỦA CARAS" loading="lazy" width="323" height="290">
                    </picture>
                  </li>
                  <li>
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" alt="THÀNH TỰU CỦA CARAS" loading="lazy" width="323" height="290">
                    </picture>
                  </li>
                  <li>
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/experience.png" alt="THÀNH TỰU CỦA CARAS" loading="lazy" width="323" height="290">
                    </picture>
                  </li>
                </ul>
              </div>
              <div class="content">
                <p class="ttl">Hơn 30.000 khách hàng mỗi năm</p>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                <p class="ttl">7 năm kinh nghiệm</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <p class="ttl">Hơn 50 mẫu mã lựa chọn</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <p class="ttl">Hơn 50 mẫu mã lựa chọn</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
              </div>
            </div>
          </div>
          <div class="m-product">
            <div class="m-product_top">
              <h4>VỊ TRÍ TUYỂN DỤNG</h4>
            </div>
            <ul class="m-new__slick job w-100">
              <?php 
                $query = new WP_Query( $args );
                if( $query->have_posts() ) :
                  while( $query->have_posts() ): $query->the_post();
                  include( get_stylesheet_directory() . '/module/item_job.php' );
                  endwhile;
                  wp_reset_postdata();
                else :
                  echo 'No Job found';
                endif;
              ?>
            </ul>
          </div>
        </div>
      </main>
<?php
//do_action( 'storefront_sidebar' );
get_footer();