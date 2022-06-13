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
          <div class="m-product">
            <div class="m-product_top">
              <h4>BEST SELLER - BÁN CHẠY NHẤT</h4>
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
              <div class="m-product__gallery">       <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="Logo" loading="lazy" width="666" height="912">
                  </picture></a></div>
              <ul class="m-product__slick">
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
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
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
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
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
          <div class="m-product">
            <div class="m-product_top">
              <h4>BEST SELLER - BÁN CHẠY NHẤT</h4>
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
              <div class="m-product__gallery">       <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="Logo" loading="lazy" width="666" height="912">
                  </picture></a></div>
              <ul class="m-product__slick">
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
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
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
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
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
          <div class="m-product">
            <div class="m-product_top">
              <h4>BEST SELLER - BÁN CHẠY NHẤT</h4>
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
              <div class="m-product__gallery">       <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="Logo" loading="lazy" width="666" height="912">
                  </picture></a></div>
              <ul class="m-product__slick">
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
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
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
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
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
          <div class="m-product">
            <div class="m-product_top">
              <h4>BEST SELLER - BÁN CHẠY NHẤT</h4>
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
              <div class="m-product__gallery">       <a href="#">
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.avif" type="image/avif">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/m-product__gallery.jpg" alt="Logo" loading="lazy" width="666" height="912">
                  </picture></a></div>
              <ul class="m-product__slick">
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
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
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
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
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
                <h5 class="ttl">PHƯƠNG CHÂM BÁN HÀNG</h5>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" alt="service01" loading="lazy" width="323" height="520">
                </picture>
              </div>
              <div class="c-shopservice__item">
                <h5 class="ttl">PHƯƠNG CHÂM BÁN HÀNG</h5>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/service01.jpg" alt="service01" loading="lazy" width="323" height="520">
                </picture>
              </div>
              <div class="c-shopservice__item">
                <h5 class="ttl">PHƯƠNG CHÂM BÁN HÀNG</h5>
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
