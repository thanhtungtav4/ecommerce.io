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
    <ul class="m-item w-100">
      <?php
        if(get_field('list_product_suggest')){
          $args = array(
            'post_type'   => 'product',
            'post_status' => 'publish',
            'post__in' => get_field('list_product_suggest'),
          );
        }
        else{

        }

      ?>
      <li>
        <a href>
          <div class="m-product__img"></div>
          <picture>
            <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif">
            <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp">
            <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
          </picture>
        </a>
        <div class="m-product__content">
          <div class="m-product__content-top">
            <a href>
              <h3 class="strong">XANIA BROWN</h3>
            </a>
            <p>400.000VND</p>
          </div>
          <div class="m-product__content-bottom">
            <p>8h/ngày | 3 tháng</p>
            <div class="btn_area">
              <a class="btn_area__add" href="#">
                <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20">
              </a>
              <a class="btn_area__del" href="#">
                <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22">
              </a>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>