<li>
    <a href="<?php echo get_permalink(get_the_ID()); ?>">
        <picture>
          <img class="lazyload" src="<?php !empty($image) ? print $image : print Placeholder; ?>" data-src="<?php !empty($image) ?  print $image : print Placeholder; ?>" alt="<?php the_title() ?>" loading="lazy" width="323" height="323">
        </picture>
    </a>
    <div class="m-product__content">
        <!-- <div class="m-product__content-top">
        <a href="<?php //echo get_permalink(get_the_ID()); ?>">
            <h3 class="strong"><?php //the_title() ?></h3></a>
        <p>
            <?php //echo wc_get_product( get_the_ID() )->get_price_html(); ?></p>
        </div> -->
        <div class="m-product__content-top">
            <div class="inner"><a href="<?php echo get_permalink(get_the_ID()); ?>">
                <h3 class="strong"><?php the_title() ?></h3></a>
            <ul class="color">
                <li><span class="is-brown"></span></li>
                <li><span class="is-gray"></span></li>
                <li><span class="is-choco"></span></li>
            </ul>
            </div><a class="favorite-btn" href="#" tabindex="0"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/heart.png" alt=""></a>
        </div>
        <div class="m-product__content-bottom">
        <p>
            <span>
            <?php
               echo get_field('product_attributes_color', get_the_ID() )
            ?>
            <span>
            <br>
            <span class="time">
            <?php
               echo get_field('time_deo', get_the_ID() )
            ?>
            </span>
        </p>
        <div class="btn_area">
            <a class="btn_area__add" href="#">
                <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_eye.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_eye.svg" alt="quick view" loading="lazy" width="16" height="20">
            </a>
            <?php woocommerce_template_loop_add_to_cart();?>
            </div>
        </div>
    </div>
</li>