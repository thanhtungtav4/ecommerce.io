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
    <?php if(is_checkout() || is_front_page() || is_product() || is_page('tuyen-dung') || is_page('job') || is_page('gio-hang') || is_page('cart')) :  ?>
      <script>
        $(document).ready(function(){
          $('.slick-sure').not('.slick-initialized').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: false,
            arrows: false,
            //lazyLoad: 'ondemand',
            responsive: [
              {
                breakpoint: 992,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2,
                  arrows: true,
                }
              },
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  arrows: true,
                }
              }
            ]
          });
        });
      </script>
    <?php endif; ?>
    <?php if(is_page('showroom') || is_page('showroom-us')) :  ?>
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
                  slidesToScroll: 2,
                  arrows: true,
                }
              },
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  arrows: true,
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
    <?php if(is_single()) : ?>
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
    <?php endif; ?>
    <?php if(is_cart() || is_page('gio-hang') || is_checkout() || is_page('thanh-toan')) : ?>
    <script>
      $(document).ready(function(){
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
    <?php endif; ?>