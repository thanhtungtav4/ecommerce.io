<?php
function view_woocommerce_products($products){
    $list_products = explode(",", $products['ids']);
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'post__in' => $list_products, 
    );
    $loop = new WP_Query( $args );
    $the_query = new WP_Query($args);
    if($the_query->have_posts()):
    echo '<div class="m-product m-product_shortcode"><ul class="m-product_list w-100">';
    while ( $the_query->have_posts() ) : $the_query->the_post();
    $image = get_the_post_thumbnail_url(get_the_ID(), array(350, 222), array( 'class' => 'lazyload' ));
    ?>
    <?php 
    require( get_stylesheet_directory() . '/module/product_item_loop.php' ); 
    ?>
    <?php
    endwhile;
    echo '</ul></div>';
    endif;
    // Reset Post Data
    wp_reset_postdata();
}
add_shortcode('view-woocommerce-products', 'view_woocommerce_products');