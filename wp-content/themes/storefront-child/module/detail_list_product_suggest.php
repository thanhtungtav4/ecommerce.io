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
          $args = array(
            'post_type'   => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 5,
          );
        }
        $the_query = new WP_Query($args);
        if($the_query->have_posts()):
        while ( $the_query->have_posts() ) : $the_query->the_post();
        $image = get_the_post_thumbnail_url(get_the_ID(), array(307, 307), array( 'class' => 'lazyload' ));
      ?>
        <?php require( get_stylesheet_directory() . '/module/product_item_loop.php' ); ?>
      <?php 
        endwhile;
        endif;
        // Reset Post Data
        wp_reset_postdata();
      ?> 
    </ul>
  </div>
</div>