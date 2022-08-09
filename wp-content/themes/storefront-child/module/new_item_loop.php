<li>
    <a href="<?php echo get_permalink(get_the_ID()); ?>">
        <div class="m-new__img">
        <picture>
        <img class="lazyload" src="<?php !empty($image) ? print $image : print PlaceholderNews; ?>" data-src="<?php !empty($image) ?  print $image : print PlaceholderNews; ?>" alt="<?php the_title() ?>" loading="lazy" width="437" height="278">
        </picture>
        </div>
        <div class="m-new__content">
        <h3 class="strong"><?php the_title() ?></h3>
        <p class="m-date">
            <i class="gg-calendar-dates"></i><?php echo get_the_date( 'l F j, Y' ); ?>
        </p>
        <p><?php the_excerpt() ?></p>
        </div>
    </a>
</li>