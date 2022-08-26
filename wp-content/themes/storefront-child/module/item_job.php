<li>
    <a href>
      <div class="m-new__img">
        <?php
          $image = get_the_post_thumbnail_url( $query->post->ID, array(437, 278));
        ?>
        <picture><img class="lazyload" src="<?php !empty($image) ? print $image : print PlaceholderNews ?>" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" alt="item new" loading="lazy" width="437" height="278"></picture>
      </div>
    <div class="m-new__content">
      <h3 class="strong"><?php echo $query->post->post_title ?></h3>
      <div class="m-tag">
        <span>Hồ Chí Minh</span>
        <span>Full-time</span>
        <span>Hồ Chí Minh</span>
      </div>
      <p class="price">6.000.000 - 8.000.000 VND</p>
      <p class="info local"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/pin.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/pin.svg" alt="Local" loading="lazy" width="12" height="16">Nguyễn Đình Chiểu, Quận 3, TP. Hồ Chí Minh</p>
      <p class="info time"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/time.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/time.svg" alt="Time" loading="lazy" width="16" height="16">14:00 - 22:00</p>
      <p class="info user"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.svg" alt="Local" loading="lazy" width="16" height="18">Nữ | 5 người</p>
      <p class="info date">Cập nhật: <?php echo get_the_date( 'dS M Y', $query->post->ID) ?></p>
    </div>
  </a>
</li>