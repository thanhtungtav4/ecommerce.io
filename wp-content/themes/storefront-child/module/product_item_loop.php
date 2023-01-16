<li>
    <a href="<?php echo get_permalink(get_the_ID()); ?>">
        <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
    </a>
    <div class="m-product__content">
        <div class="m-product__content-top">
            <div class="inner"><a href="<?php echo get_permalink(get_the_ID()); ?>">
                <h3 class="strong"><?php the_title() ?></h3></a>
            <ul class="color">
                <?php if(get_field('select_color', get_the_ID())) : ?>
                    <?php foreach(get_field('select_color', get_the_ID()) as $color) : ?>
                        <li><span class="is-<?php echo $color ?>"></span></li>
                    <?php endforeach;?>
                <?php endif ;?>
            </ul>
            </div>
            <a class="favorite-btn" href="#">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/heart.png" alt="favorite" loading="lazy" width="16px" height="16px">
            </a>
        </div>
        <div class="m-product__content-bottom">
            <p>
                <span  class="time">
                    <?php
                        echo get_field('time_deo', get_the_ID() )
                    ?>
                </span>
                <br>
                <span>
                    <?php echo wc_get_product( get_the_ID() )->get_price_html(); ?>
                </span>
            </p>
            <div class="btn_area">
                <a class="btn_area__add" onclick="quickview('<?php echo get_the_ID() ?>')">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_eye.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_eye.svg" alt="quick view" loading="lazy" width="16" height="20">
                </a>
                <?php woocommerce_template_loop_add_to_cart();?>
            </div>
            <?php do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
        </div>
    </div>
</li>
