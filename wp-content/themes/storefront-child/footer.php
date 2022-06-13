<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>
	<?php do_action( 'storefront_before_footer' ); ?>
	<footer class="c-footer">
        <div class="l-container c-footer_top">
          <dl>
            <dd class="c-footer_logo"><a href="#">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logo-footer.webp" type="image/webp"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logo-footer.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logo-footer.png" alt="Logo" loading="lazy" width="161" height="124">
                </picture></a>
              <dd class="c-footer_copy">© Copyright 2022 CARAS LENS. All rights reserved.</dd>
            </dd>
            <dt class="c-footer_fw">THEO DÕI TẠI
              <dl class="c-footer_social c-footer_certificates">
                <dd><img class="lazyload" loading="lazy" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook.png" width="39" height="39"></dd>
                <dd><img class="lazyload" loading="lazy" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/insta.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/insta.png" width="39" height="39"></dd>
                <dd><img class="lazyload" loading="lazy" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtube.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtube.png" width="39" height="39"></dd>
              </dl>
            </dt>
          </dl>
          <dl>
            <dt>CÔNG TY TNHH CARAS LENS</dt>
            <dd><strong>GĐKKD:&nbsp;</strong>0314882698 do Sở Kế hoạch và Đầu tư TP.HCM cấp ngày 07/02/2018.</dd>
            <dd><strong>Email:&nbsp;</strong><a href="mailto:support@caraslens.vn">support@caraslens.vn</a></dd>
            <dd><strong>Giấy phép nhập khẩu chính ngạch số 17830NK/BYT-TB-CT của Bộ Y tế</strong></dd>
            <dd><strong>Giấy phép nhập khẩu Kính áp tròng/ Trang thiết bị y tế:</strong>20210259-ADJVINA/170000008/PCBPL-BYT</dd>
            <dd><strong>Hotline:&nbsp;</strong><a href="tel:1900636304">1900 63 63 04</a></dd>
          </dl>
          <dl>
            <dt>HỖ TRỢ KHÁCH HÀNG
              <dl>
                <dd><a href="#">Chính sách bảo hành</a></dd>
                <dd><a href="#">Chính sách đổi trả</a></dd>
                <dd><a href="#">Chính sách giao nhận</a></dd>
                <dd><a href="#">Hướng dẫn mua hàng</a></dd>
                <dd><a href="#">Hỏi Đáp</a></dd>
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
            <dt>CHƯƠNG TRÌNH CARAS AFFILIATE
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
    </div>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/jquery.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/common.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
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
        $('.m-product__slick').not('.slick-initialized').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: true,
          lazyLoad: 'ondemand',
        });
        $('.m-product__prev').click(function(e){
          $('.m-product__slick').slick('slickPrev');
        } );

        $('.m-product__next').click(function(e){
          $('.m-product__slick').slick('slickNext');
        } );
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
      });
    </script>
		<?php wp_footer(); ?>
  </body>
</html>
