<?php 
  $taxonomy_terms_tag = wp_get_post_terms($query->post->ID, 'tag_job',  array("fields" => "names"));
  $price = get_field('price_ranger', $query->post->ID);
  $location = get_field('location', $query->post->ID);
  $time = get_field('time', $query->post->ID);
  $number = get_field('number_job', $query->post->ID);
?>
<li>
    <a href="<?php echo get_permalink($query->post->ID)?>">
      <div class="m-new__img">
        <?php
          $image = get_the_post_thumbnail_url( $query->post->ID, array(437, 278));
        ?>
        <picture><img class="lazyload" src="<?php !empty($image) ? print $image : print PlaceholderNews ?>" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/item-new.jpg" alt="item new" loading="lazy" width="437" height="278"></picture>
      </div>
    <div class="m-new__content">
      <h3 class="strong"><?php echo $query->post->post_title ?></h3>
      <div class="m-tag">
        <?php if($taxonomy_terms_tag) : ?>
          <?php foreach($taxonomy_terms_tag as $key => $item): ?>
            <span><?php echo $item ?></span>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <?php if($price) : ?>
        <p class="price"><?php echo $price ?></p>
      <?php endif; ?>
      <?php if($location) : ?>
        <p class="info local"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/pin.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/pin.svg" alt="Local" loading="lazy" width="12" height="16"><?php echo $location ?></p>
      <?php endif; ?>
      <?php if($time) : ?>
        <p class="info time"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/time.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/time.svg" alt="Time" loading="lazy" width="16" height="16"><?php echo $time ?></p>
      <?php endif; ?>
      <?php if($number) : ?>
        <p class="info user"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user.svg" alt="Local" loading="lazy" width="16" height="18"><?php echo $number ?></p>
      <?php endif; ?>
      <p class="info date">Cập nhật: <?php echo get_the_date( 'dS M Y', $query->post->ID) ?></p>
    </div>
  </a>
</li>