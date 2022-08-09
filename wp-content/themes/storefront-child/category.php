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
        <div class="m-search">
          <div class="l-container">
            <p class="ttl">Tổng hợp bài viết của <br class="only-pc">  CARAS LENS</p>
            <div class="m-search_inner">
              <form>
                <input type="text" placeholder="Bạn đang tìm kiếm" id="search">
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
        <div class="m-noti">
          <div class="l-container">
            <p>Bạn đang “bị lạc đường” trong nguồn kiến thức của Caras? Bạn bị bối rối? Click chọn <br> các chủ đề bên dưới để tìm đúng bài viết bạn thực sự quan tâm!</p>
          </div>
        </div>
        <div class="m-category">
          <div class="l-container">
            <ul>
              <li><a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" alt="Kính Áp Tròng" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Các Tật Khúc Xạ & Bệnh Về Mắt</p></a></li>
              <li><a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" alt="Kính Áp Tròng" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Kính Áp Tròng</p></a></li>
              <li><a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" alt="Kính Áp Tròng" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Kính Áp Tròng</p></a></li>
              <li><a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" alt="Kính Áp Tròng" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Kính Áp Tròng</p></a></li>
              <li><a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" alt="Kính Áp Tròng" loading="lazy" width="258" height="258">
                  </picture>
                  <p>Kính Áp Tròng</p></a></li>
            </ul>
          </div>
        </div>
        <div class="l-container">
          <div class="m-news">
            <div class="m-ttl">
              <h5 class="title">Bài viết nổi bật</h5>
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
                <div class="m-news_item"><a href="#">
                    <div class="m-news_img">
                      <picture>
                        <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" alt="Kính Áp Tròng" loading="lazy" width="137" height="96">
                      </picture>
                    </div>
                    <div class="content">
                      <h4>Bí quyết chữa cận thị nhẹ bằng phương pháp tự nhiên tại nhà hiệu quả</h4>
                      <div class="info">
                        <p>
                          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9925 0.5C3.8525 0.5 0.5 3.86 0.5 8C0.5 12.14 3.8525 15.5 7.9925 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 7.9925 0.5ZM8 14C4.685 14 2 11.315 2 8C2 4.685 4.685 2 8 2C11.315 2 14 4.685 14 8C14 11.315 11.315 14 8 14ZM7.25 4.25H8.375V8.1875L11.75 10.19L11.1875 11.1125L7.25 8.75V4.25Z" fill="#ABABAB"></path>
                          </svg>6p đọc
                        </p>
                        <p>
                          <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.833008 7C2.27467 3.34167 5.83301 0.75 9.99967 0.75C14.1663 0.75 17.7247 3.34167 19.1663 7C17.7247 10.6583 14.1663 13.25 9.99967 13.25C5.83301 13.25 2.27467 10.6583 0.833008 7ZM17.3497 7C15.9747 4.19167 13.158 2.41667 9.99967 2.41667C6.84134 2.41667 4.02467 4.19167 2.64967 7C4.02467 9.80833 6.83301 11.5833 9.99967 11.5833C13.1663 11.5833 15.9747 9.80833 17.3497 7ZM9.99967 4.91667C11.1497 4.91667 12.083 5.85 12.083 7C12.083 8.15 11.1497 9.08333 9.99967 9.08333C8.84967 9.08333 7.91634 8.15 7.91634 7C7.91634 5.85 8.84967 4.91667 9.99967 4.91667ZM6.24967 7C6.24967 4.93333 7.93301 3.25 9.99967 3.25C12.0663 3.25 13.7497 4.93333 13.7497 7C13.7497 9.06667 12.0663 10.75 9.99967 10.75C7.93301 10.75 6.24967 9.06667 6.24967 7Z" fill="#ABABAB"></path>
                          </svg>1100
                        </p>
                      </div>
                    </div></a></div>
                <div class="m-news_item"><a href="#">
                    <div class="m-news_img">
                      <picture>
                        <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" alt="Kính Áp Tròng" loading="lazy" width="137" height="96">
                      </picture>
                    </div>
                    <div class="content">
                      <h4>Bí quyết chữa cận thị nhẹ bằng phương pháp tự nhiên tại nhà hiệu quả</h4>
                      <div class="info">
                        <p>
                          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9925 0.5C3.8525 0.5 0.5 3.86 0.5 8C0.5 12.14 3.8525 15.5 7.9925 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 7.9925 0.5ZM8 14C4.685 14 2 11.315 2 8C2 4.685 4.685 2 8 2C11.315 2 14 4.685 14 8C14 11.315 11.315 14 8 14ZM7.25 4.25H8.375V8.1875L11.75 10.19L11.1875 11.1125L7.25 8.75V4.25Z" fill="#ABABAB"></path>
                          </svg>6p đọc
                        </p>
                        <p>
                          <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.833008 7C2.27467 3.34167 5.83301 0.75 9.99967 0.75C14.1663 0.75 17.7247 3.34167 19.1663 7C17.7247 10.6583 14.1663 13.25 9.99967 13.25C5.83301 13.25 2.27467 10.6583 0.833008 7ZM17.3497 7C15.9747 4.19167 13.158 2.41667 9.99967 2.41667C6.84134 2.41667 4.02467 4.19167 2.64967 7C4.02467 9.80833 6.83301 11.5833 9.99967 11.5833C13.1663 11.5833 15.9747 9.80833 17.3497 7ZM9.99967 4.91667C11.1497 4.91667 12.083 5.85 12.083 7C12.083 8.15 11.1497 9.08333 9.99967 9.08333C8.84967 9.08333 7.91634 8.15 7.91634 7C7.91634 5.85 8.84967 4.91667 9.99967 4.91667ZM6.24967 7C6.24967 4.93333 7.93301 3.25 9.99967 3.25C12.0663 3.25 13.7497 4.93333 13.7497 7C13.7497 9.06667 12.0663 10.75 9.99967 10.75C7.93301 10.75 6.24967 9.06667 6.24967 7Z" fill="#ABABAB"></path>
                          </svg>1100
                        </p>
                      </div>
                    </div></a></div>
                <div class="m-news_item"><a href="#">
                    <div class="m-news_img">
                      <picture>
                        <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" alt="Kính Áp Tròng" loading="lazy" width="137" height="96">
                      </picture>
                    </div>
                    <div class="content">
                      <h4>Bí quyết chữa cận thị nhẹ bằng phương pháp tự nhiên tại nhà hiệu quả</h4>
                      <div class="info">
                        <p>
                          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9925 0.5C3.8525 0.5 0.5 3.86 0.5 8C0.5 12.14 3.8525 15.5 7.9925 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 7.9925 0.5ZM8 14C4.685 14 2 11.315 2 8C2 4.685 4.685 2 8 2C11.315 2 14 4.685 14 8C14 11.315 11.315 14 8 14ZM7.25 4.25H8.375V8.1875L11.75 10.19L11.1875 11.1125L7.25 8.75V4.25Z" fill="#ABABAB"></path>
                          </svg>6p đọc
                        </p>
                        <p>
                          <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.833008 7C2.27467 3.34167 5.83301 0.75 9.99967 0.75C14.1663 0.75 17.7247 3.34167 19.1663 7C17.7247 10.6583 14.1663 13.25 9.99967 13.25C5.83301 13.25 2.27467 10.6583 0.833008 7ZM17.3497 7C15.9747 4.19167 13.158 2.41667 9.99967 2.41667C6.84134 2.41667 4.02467 4.19167 2.64967 7C4.02467 9.80833 6.83301 11.5833 9.99967 11.5833C13.1663 11.5833 15.9747 9.80833 17.3497 7ZM9.99967 4.91667C11.1497 4.91667 12.083 5.85 12.083 7C12.083 8.15 11.1497 9.08333 9.99967 9.08333C8.84967 9.08333 7.91634 8.15 7.91634 7C7.91634 5.85 8.84967 4.91667 9.99967 4.91667ZM6.24967 7C6.24967 4.93333 7.93301 3.25 9.99967 3.25C12.0663 3.25 13.7497 4.93333 13.7497 7C13.7497 9.06667 12.0663 10.75 9.99967 10.75C7.93301 10.75 6.24967 9.06667 6.24967 7Z" fill="#ABABAB"></path>
                          </svg>1100
                        </p>
                      </div>
                    </div></a></div>
                <div class="m-news_item"><a href="#">
                    <div class="m-news_img">
                      <picture>
                        <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" alt="Kính Áp Tròng" loading="lazy" width="137" height="96">
                      </picture>
                    </div>
                    <div class="content">
                      <h4>Bí quyết chữa cận thị nhẹ bằng phương pháp tự nhiên tại nhà hiệu quả</h4>
                      <div class="info">
                        <p>
                          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9925 0.5C3.8525 0.5 0.5 3.86 0.5 8C0.5 12.14 3.8525 15.5 7.9925 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 7.9925 0.5ZM8 14C4.685 14 2 11.315 2 8C2 4.685 4.685 2 8 2C11.315 2 14 4.685 14 8C14 11.315 11.315 14 8 14ZM7.25 4.25H8.375V8.1875L11.75 10.19L11.1875 11.1125L7.25 8.75V4.25Z" fill="#ABABAB"></path>
                          </svg>6p đọc
                        </p>
                        <p>
                          <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.833008 7C2.27467 3.34167 5.83301 0.75 9.99967 0.75C14.1663 0.75 17.7247 3.34167 19.1663 7C17.7247 10.6583 14.1663 13.25 9.99967 13.25C5.83301 13.25 2.27467 10.6583 0.833008 7ZM17.3497 7C15.9747 4.19167 13.158 2.41667 9.99967 2.41667C6.84134 2.41667 4.02467 4.19167 2.64967 7C4.02467 9.80833 6.83301 11.5833 9.99967 11.5833C13.1663 11.5833 15.9747 9.80833 17.3497 7ZM9.99967 4.91667C11.1497 4.91667 12.083 5.85 12.083 7C12.083 8.15 11.1497 9.08333 9.99967 9.08333C8.84967 9.08333 7.91634 8.15 7.91634 7C7.91634 5.85 8.84967 4.91667 9.99967 4.91667ZM6.24967 7C6.24967 4.93333 7.93301 3.25 9.99967 3.25C12.0663 3.25 13.7497 4.93333 13.7497 7C13.7497 9.06667 12.0663 10.75 9.99967 10.75C7.93301 10.75 6.24967 9.06667 6.24967 7Z" fill="#ABABAB"></path>
                          </svg>1100
                        </p>
                      </div>
                    </div></a></div>
                <div class="m-news_item"><a href="#">
                    <div class="m-news_img">
                      <picture>
                        <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" alt="Kính Áp Tròng" loading="lazy" width="137" height="96">
                      </picture>
                    </div>
                    <div class="content">
                      <h4>Bí quyết chữa cận thị nhẹ bằng phương pháp tự nhiên tại nhà hiệu quả</h4>
                      <div class="info">
                        <p>
                          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9925 0.5C3.8525 0.5 0.5 3.86 0.5 8C0.5 12.14 3.8525 15.5 7.9925 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 7.9925 0.5ZM8 14C4.685 14 2 11.315 2 8C2 4.685 4.685 2 8 2C11.315 2 14 4.685 14 8C14 11.315 11.315 14 8 14ZM7.25 4.25H8.375V8.1875L11.75 10.19L11.1875 11.1125L7.25 8.75V4.25Z" fill="#ABABAB"></path>
                          </svg>6p đọc
                        </p>
                        <p>
                          <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.833008 7C2.27467 3.34167 5.83301 0.75 9.99967 0.75C14.1663 0.75 17.7247 3.34167 19.1663 7C17.7247 10.6583 14.1663 13.25 9.99967 13.25C5.83301 13.25 2.27467 10.6583 0.833008 7ZM17.3497 7C15.9747 4.19167 13.158 2.41667 9.99967 2.41667C6.84134 2.41667 4.02467 4.19167 2.64967 7C4.02467 9.80833 6.83301 11.5833 9.99967 11.5833C13.1663 11.5833 15.9747 9.80833 17.3497 7ZM9.99967 4.91667C11.1497 4.91667 12.083 5.85 12.083 7C12.083 8.15 11.1497 9.08333 9.99967 9.08333C8.84967 9.08333 7.91634 8.15 7.91634 7C7.91634 5.85 8.84967 4.91667 9.99967 4.91667ZM6.24967 7C6.24967 4.93333 7.93301 3.25 9.99967 3.25C12.0663 3.25 13.7497 4.93333 13.7497 7C13.7497 9.06667 12.0663 10.75 9.99967 10.75C7.93301 10.75 6.24967 9.06667 6.24967 7Z" fill="#ABABAB"></path>
                          </svg>1100
                        </p>
                      </div>
                    </div></a></div>
                <div class="m-news_item"><a href="#">
                    <div class="m-news_img">
                      <picture>
                        <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item_news.jpg" alt="Kính Áp Tròng" loading="lazy" width="137" height="96">
                      </picture>
                    </div>
                    <div class="content">
                      <h4>Bí quyết chữa cận thị nhẹ bằng phương pháp tự nhiên tại nhà hiệu quả</h4>
                      <div class="info">
                        <p>
                          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9925 0.5C3.8525 0.5 0.5 3.86 0.5 8C0.5 12.14 3.8525 15.5 7.9925 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 7.9925 0.5ZM8 14C4.685 14 2 11.315 2 8C2 4.685 4.685 2 8 2C11.315 2 14 4.685 14 8C14 11.315 11.315 14 8 14ZM7.25 4.25H8.375V8.1875L11.75 10.19L11.1875 11.1125L7.25 8.75V4.25Z" fill="#ABABAB"></path>
                          </svg>6p đọc
                        </p>
                        <p>
                          <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.833008 7C2.27467 3.34167 5.83301 0.75 9.99967 0.75C14.1663 0.75 17.7247 3.34167 19.1663 7C17.7247 10.6583 14.1663 13.25 9.99967 13.25C5.83301 13.25 2.27467 10.6583 0.833008 7ZM17.3497 7C15.9747 4.19167 13.158 2.41667 9.99967 2.41667C6.84134 2.41667 4.02467 4.19167 2.64967 7C4.02467 9.80833 6.83301 11.5833 9.99967 11.5833C13.1663 11.5833 15.9747 9.80833 17.3497 7ZM9.99967 4.91667C11.1497 4.91667 12.083 5.85 12.083 7C12.083 8.15 11.1497 9.08333 9.99967 9.08333C8.84967 9.08333 7.91634 8.15 7.91634 7C7.91634 5.85 8.84967 4.91667 9.99967 4.91667ZM6.24967 7C6.24967 4.93333 7.93301 3.25 9.99967 3.25C12.0663 3.25 13.7497 4.93333 13.7497 7C13.7497 9.06667 12.0663 10.75 9.99967 10.75C7.93301 10.75 6.24967 9.06667 6.24967 7Z" fill="#ABABAB"></path>
                          </svg>1100
                        </p>
                      </div>
                    </div></a></div>
              </div>
            </div>
          </div>
        </div>
      </main>
<?php
//do_action( 'storefront_sidebar' );
get_footer();
