<li>
    <a href="<?php echo get_permalink(get_the_ID()); ?>">
        <div class="m-product__img"></div>
        <picture>
        <img class="lazyload" src="<?php !empty($image) ? print $image : print Placeholder; ?>" data-src="<?php !empty($image) ?  print $image : print Placeholder; ?>" alt="<?php the_title() ?>" loading="lazy" width="323" height="323">
        </picture>
    </a>
    <div class="m-product__content">
        <div class="m-product__content-top">
        <a href="<?php echo get_permalink(get_the_ID()); ?>">
            <h3 class="strong"><?php the_title() ?></h3></a>
        <p>
            <?php echo wc_get_product( get_the_ID() )->get_price_html(); ?></p>
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
                if( has_term( '8h', 'product_cat', $product->get_id() ) ) {
                echo('8h/ngày');
                }
                if( has_term( '10h', 'product_cat', $product->get_id() ) ) {
                echo('10h/ngày');
                }
                if( has_term( '12h', 'product_cat', $product->get_id() ) ) {
                echo('12h/ngày');
                }
                if( has_term( '14h', 'product_cat', $product->get_id() ) ) {
                echo('14h/ngày');
                }
                if( has_term( '24h', 'product_cat', $product->get_id() ) ) {
                echo('24h/ngày');
                }
            ?>
            <span>
                <?php
                if( has_term( 'lens-3-thang', 'product_cat', $product->get_id() ) ) {
                echo('| 3 tháng');
                }
                ?>
                <?php
                if( has_term( 'lens-1-ngay', 'product_cat', $product->get_id() ) ) {
                echo('| Lens 1 ngày');
                }
                ?>
            </span>
            </span>
        </p>
        <div class="btn_area">
            <a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg" alt="thêm vào mục yêu thích" loading="lazy" width="16" height="20"></a>
            <?php woocommerce_template_loop_add_to_cart();?>
            </div>
        </div>
    </div>
</li>