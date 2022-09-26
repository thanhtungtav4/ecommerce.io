<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>
 <?php if(is_product_category() || is_search())  : ?>
  <div class="l-container mt-2">
    <?php require_once( get_stylesheet_directory() . '/module/footer_info.php' ); ?>
  </div>
<?php endif; ?>
	<footer class="c-footer">
        <div class="l-container c-footer_top">
          <dl>
            <dd class="c-footer_logo"><a href="#">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.webp" type="image/webp">
                  <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.png" alt="caras" loading="lazy" width="161" height="46">
                </picture></a>
              <dd class="c-footer_copy">© Copyright 2022 CARAS LENS. All rights reserved.</dd>
            </dd>
            <dt class="c-footer_fw"><?php _e('FOLLOW AT', 'storefront') ?>
              <dl class="c-footer_social c-footer_certificates">
                <dd><img class="lazyload" loading="lazy" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook.png" width="39" height="39"></dd>
                <dd><img class="lazyload" loading="lazy" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/insta.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/insta.png" width="39" height="39"></dd>
                <dd><img class="lazyload" loading="lazy" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtube.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtube.png" width="39" height="39"></dd>
              </dl>
            </dt>
          </dl>
          <dl>
            <dt><?php _e('CÔNG TY CỔ PHẦN THƯƠNG MẠI CALEN', 'storefront') ?></dt>
            <dd><strong><?php _e('Business registration certificate:', 'storefront') ?>&nbsp;</strong><?php _e('0317006667', 'storefront') ?></dd>
            <dd><strong>Email:&nbsp;</strong><a href="mailto:support@caraslens.vn">support@caraslens.vn</a></dd>
            <dd><strong><?php _e('Import license No. 17830NK/BYT-TB-CT granted by the Ministry of Health', 'storefront') ?></strong></dd>
            <dd><strong><?php _e('Giấy phép công bố & nhập khẩu chính ngạch số:', 'storefront') ?></strong>220002087/PCBB-HCM của Bộ Y tế</dd>
            <dd><strong>Hotline:&nbsp;</strong><a href="tel:1900636304">1900 63 63 04</a></dd>
          </dl>
          <dl>
            <dt><?php _e('CUSTOMER SUPPORT', 'storefront') ?>
              <dl>
                <dd><a href="#"><?php _e('Warranty Policy', 'storefront') ?></a></dd>
                <dd><a href="#"><?php _e('Return Policy', 'storefront') ?></a></dd>
                <dd><a href="#"><?php _e('Delivery policy', 'storefront') ?></a></dd>
                <dd><a href="#"><?php _e('Shopping guide', 'storefront') ?></a></dd>
                <dd><a href="#"><?php _e('FAQs', 'storefront') ?></a></dd>
                <dd><a href="/<?php echo apply_filters( 'wpml_get_translated_slug', 'lien-he', 'page' , 'ICL_LANGUAGE_CODE');?>"><?php _e('CONTACT US', 'storefront') ?></a></dd>
              </dl>
            </dt>
            <dt>MEDICAL CERTIFICATES
              <dl class="c-footer_social c-footer_certificates">
                <dd>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.png" alt="byt" loading="lazy" width="47" height="47">
                  </picture>
                </dd>
                <dd>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/fda.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/fda.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/fda.png" alt="fda" loading="lazy" width="56" height="22">
                  </picture>
                </dd>
                <dd>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/iso.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/iso.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/iso.png" alt="iso" loading="lazy" width="50" height="49">
                  </picture>
                </dd>
              </dl>
            </dt>
          </dl>
          <dl>
            <dt><?php _e('CARAS AFFILIATE PROGRAM', 'storefront') ?>
              <dl>
                <dd><a href="#">Affiliate program</a></dd>
              </dl>
            </dt>
            <dt>PAYMENT ACCEPT
              <dl class="c-footer_social c-footer_certificates">
                <dd>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/visa.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/visa.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/visa.png" alt="visa" loading="lazy" width="71" height="23">
                  </picture>
                </dd>
                <dd>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/jcb.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/jcb.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/jcb.png" alt="jcb" loading="lazy" width="45" height="32">
                  </picture>
                </dd>
                <dd>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mastercard.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mastercard.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mastercard.png" alt="mastercard" loading="lazy" width="56" height="33.5">
                  </picture>
                </dd>
              </dl>
            </dt>
          </dl>
        </div>
        <div class="l-container c-footer_bottom">
          <dl>
            <dd>
              <picture>
                <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bct.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bct.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bct.png" alt="Logo" loading="lazy" width="101" height="86">
              </picture>
            </dd>
          </dl>
          <dl>
            <dd>
              <picture>
                <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bsi.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bsi.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bsi.png" alt="Logo" loading="lazy" width="155" height="75.5">
              </picture>
            </dd>
          </dl>
          <dl>
            <dd>
              <picture>
                <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dmca.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dmca.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dmca.png" alt="Logo" loading="lazy" width="193" height="61">
              </picture>
            </dd>
          </dl>
          <dl>
            <dd>
              <picture>
                <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chong-hang-gia.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chong-hang-gia.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chong-hang-gia.png" alt="Logo" loading="lazy" width="124" height="123">
              </picture>
            </dd>
          </dl>
        </div>
      </footer>
      <?php require( get_stylesheet_directory() . '/module/chat_bot.php' ); ?>
    </div>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/common.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
      $(document).ready(function(){
        //in cart page
        $('.m-item').not('.slick-initialized').slick({
          infinite: true,
          slidesToShow: 4,
          slidesToScroll: 4,
          dots: false,
          arrows: false,
          lazyLoad: 'progressive',
          responsive: [
             {
              breakpoint: 992,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            }
          ]
        });
      });
    </script>
    <?php if(is_front_page()) :  ?>
      <script>
      $(document).ready(function(){
        $('.c-carousel_inner ').not('.slick-initialized').slick({
          slidesToShow: 1,
          infinite: true,
          dots: true,
          speed: 300,
          arrows: false,
          lazyLoad: 'ondemand',
        });
        $('.m-product__slick').not('.slick-initialized').slick({
          infinite: true,
          fade: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: true,
          lazyLoad: 'ondemand',
        });
        $('.m-product__prev001').click(function(e){
          $('.m-product__slick001').slick('slickPrev');
        } );

        $('.m-product__next001').click(function(e){
          $('.m-product__slick001').slick('slickNext');
        } );
        // in js for 01
        $('.m-product__prev002').click(function(e){
          $('.m-product__slick002').slick('slickPrev');
        } );

        $('.m-product__next002').click(function(e){
          $('.m-product__slick002').slick('slickNext');
        } );
        // in js for 02
        $('.m-product__prev003').click(function(e){
          $('.m-product__slick003').slick('slickPrev');
        } );

        $('.m-product__next003').click(function(e){
          $('.m-product__slick003').slick('slickNext');
        } );
        // in js for 03
        $('.m-product__prev004').click(function(e){
          $('.m-product__slick004').slick('slickPrev');
        } );

        $('.m-product__next004').click(function(e){
          $('.m-product__slick004').slick('slickNext');
        } );
        // in js for 04
        $('.m-product__prev005').click(function(e){
          $('.m-product__slick005').slick('slickPrev');
        } );

        $('.m-product__next005').click(function(e){
          $('.m-product__slick005').slick('slickNext');
        } );
        // in js for 05
        $('.m-product__prev006').click(function(e){
          $('.m-product__slick006').slick('slickPrev');
        } );

        $('.m-product__next006').click(function(e){
          $('.m-product__slick006').slick('slickNext');
        } );
        // in js for 06
        $('.m-product__slick02').not('.slick-initialized').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: false,
          lazyLoad: 'ondemand',
        });
        $('.m-new__prev').click(function(e){
          $('.m-new__slick').slick('slickPrev');
        } );
        $('.m-new__next').click(function(e){
          $('.m-new__slick').slick('slickNext');
        } );
        $('.m-new__slick').not('.slick-initialized').slick({
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 3,
          dots: false,
          arrows: false,
          lazyLoad: 'progressive',
          responsive: [
             {
              breakpoint: 992,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
        });
        $('.m-item__prev').click(function(e){
          $('.m-item').slick('slickPrev');
        } );
        $('.m-item__next').click(function(e){
          $('.m-item').slick('slickNext');
        } );
      });
      </script>
    <?php endif; ?>
    <?php if(is_product()) :  ?>
      <script>
        $(document).ready(function(){
          $('.m-product__prev').click(function(e){
          $('.m-product__inner ul').slick('slickPrev');
          } );
          $('.m-product__next').click(function(e){
            $('.m-product__inner ul').slick('slickNext');
          } );
          $('.m-product__inner ul').not('.slick-initialized').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: false,
            arrows: false,
            lazyLoad: 'progressive',
          });
        });
        function openTab(evt, TabName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("c-tab_item");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(TabName).style.display = "block";
          evt.currentTarget.className += " active";
        }
      </script>
    <?php endif; ?>
    <?php if(is_product_category()) :  ?>
      <script>
          function opent_filter(){
            document.getElementById("is_filter").classList.add("js_filter");
            document.body.classList.add('js_bg');
        }
          document.addEventListener("mouseup", function(event) {
            var obj = document.getElementById("is_filter");
            var js_filter = document.getElementsByClassName('js_filter');
            if(js_filter.length > 0){
              if (!obj.contains(event.target)) {
                document.getElementById("is_filter").classList.remove("js_filter");
                document.body.classList.remove('js_bg');
              }
            }
          });
      </script>
    <?php endif; ?>
    <?php if(is_checkout() || is_front_page() || is_page('tuyen-dung') || is_page('job')) :  ?>
      <script>
        $(document).ready(function(){
          $('.slick-sure').not('.slick-initialized').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: false,
            arrows: false,
            lazyLoad: 'ondemand',
            responsive: [
              {
                breakpoint: 992,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2
                }
              },
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
            ]
          });
        });
      </script>
    <?php endif; ?>
    <?php if(is_page('gioi-thieu') || is_page('about-us')) :  ?>
      <script>
        $(document).ready(function(){
          $(".caras-intro__review__list").slick({
            slidesToShow: 3,
            infinite: false,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: false,
            prevArrow: false,
            nextArrow: false,
            responsive: [{
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              },
            }, ],
          });
        });
      </script>
    <?php endif; ?>
    <?php if(is_page('lien-he') || is_page('contact')) :  ?>
      <script>
       $(document).ready(function(){
        $('.slick-sure').not('.slick-initialized').slick({
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          dots: false,
          arrows: false,
          lazyLoad: 'ondemand',
          responsive: [
             {
              breakpoint: 992,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
        });
      });
      </script>
    <?php endif; ?>
    <?php if(is_single()) ?>
    <script>
      $(document).ready(function(){
        $('.m-new__slick').not('.slick-initialized').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            dots: false,
            arrows: false,
            lazyLoad: 'progressive',
            responsive: [
                {
                breakpoint: 992,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 3
                }
              },
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
            ]
            });
            $('.m-item__prev').click(function(e){
              $('.m-new__slick').slick('slickPrev');
            } );
            $('.m-item__next').click(function(e){
              $('.m-new__slick').slick('slickNext');
        });
      });
    </script>
    <?php ?>
		<?php wp_footer(); ?>
  </body>
</html>
