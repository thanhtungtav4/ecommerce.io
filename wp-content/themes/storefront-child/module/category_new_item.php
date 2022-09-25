<div class="m-news_item">
  <a href="<?php echo get_permalink(get_the_ID()); ?>">
    <div class="m-news_img">
    <picture>
          <?php if( !empty(get_the_post_thumbnail()) ) : ?>
            <img class="lazyload" src="<?php the_post_thumbnail_url(array(377, 255), array( 'class' => 'lazyload' ));  ?>" data-src="<?php the_post_thumbnail_url(array(377, 255), array( 'class' => 'lazyload' ));  ?>" alt="<?php the_title() ?>" loading="lazy" width="377" height="255">
         <?php else : ?>
            <img class="lazyload" src="<?php print_r(PlaceholderNews) ?>" data-src="<?php print_r(PlaceholderNews)  ?>" alt="<?php the_title() ?>" loading="lazy" width="377" height="255">
        <?php endif; ?>   
    </picture>
    </div>
    <h4><?php the_title() ?></h4>
    <div class="info">
      <p>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9925 0.5C3.8525 0.5 0.5 3.86 0.5 8C0.5 12.14 3.8525 15.5 7.9925 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 7.9925 0.5ZM8 14C4.685 14 2 11.315 2 8C2 4.685 4.685 2 8 2C11.315 2 14 4.685 14 8C14 11.315 11.315 14 8 14ZM7.25 4.25H8.375V8.1875L11.75 10.19L11.1875 11.1125L7.25 8.75V4.25Z" fill="#ABABAB"></path>
        </svg><?php the_field('time_read') ?>p đọc
      </p>
      <p>
        <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M0.833008 7C2.27467 3.34167 5.83301 0.75 9.99967 0.75C14.1663 0.75 17.7247 3.34167 19.1663 7C17.7247 10.6583 14.1663 13.25 9.99967 13.25C5.83301 13.25 2.27467 10.6583 0.833008 7ZM17.3497 7C15.9747 4.19167 13.158 2.41667 9.99967 2.41667C6.84134 2.41667 4.02467 4.19167 2.64967 7C4.02467 9.80833 6.83301 11.5833 9.99967 11.5833C13.1663 11.5833 15.9747 9.80833 17.3497 7ZM9.99967 4.91667C11.1497 4.91667 12.083 5.85 12.083 7C12.083 8.15 11.1497 9.08333 9.99967 9.08333C8.84967 9.08333 7.91634 8.15 7.91634 7C7.91634 5.85 8.84967 4.91667 9.99967 4.91667ZM6.24967 7C6.24967 4.93333 7.93301 3.25 9.99967 3.25C12.0663 3.25 13.7497 4.93333 13.7497 7C13.7497 9.06667 12.0663 10.75 9.99967 10.75C7.93301 10.75 6.24967 9.06667 6.24967 7Z" fill="#ABABAB"></path>
        </svg>1100
      </p>
    </div>
    <p class="extra"><?php get_the_excerpt() ?></p>
  </a>
</div>