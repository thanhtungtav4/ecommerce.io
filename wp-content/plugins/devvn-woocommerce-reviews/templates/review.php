<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $devvn_review_settings;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container devvn_review_box">
		<div class="comment-text">
            <div class="devvn_review_top">
                <?php
                /**
                 * The woocommerce_review_meta hook.
                 *
                 * @hooked woocommerce_review_display_meta - 10
                 * @hooked WC_Structured_Data::generate_review_data() - 20
                 */
                do_action( 'woocommerce_review_meta', $comment );
                ?>
            </div>
            <div class="devvn_review_mid">
                <?php
                do_action( 'woocommerce_review_before_comment_text', $comment );
                /**
                 * The woocommerce_review_before_comment_meta hook.
                 *
                 * @hooked woocommerce_review_display_rating - 10
                 */
                do_action( 'woocommerce_review_before_comment_meta', $comment );
                /**
                 * The woocommerce_review_comment_text hook
                 *
                 * @hooked woocommerce_review_display_comment_text - 10
                 */
                do_action( 'woocommerce_review_comment_text', $comment );
                do_action( 'woocommerce_review_after_comment_text', $comment );
                ?>
            </div>
            <div class="devvn_review_bottom">
                <?php
                $depth = 1;
                comment_reply_link(
                    array_merge(
                        $args,
                        array(
                            //'add_below' => $add_below,
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '<div class="reply">',
                            'after'     => '</div>',
                            'reply_text'    =>  'Thảo luận'
                        )
                    )
                );
                ?>
                <?php do_action('devvn_reviews_action', $comment);?>
                <?php if($devvn_review_settings['show_date'] == "1"):?>
                <span> • </span>
                <time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></time>
                <?php endif;?>
            </div>

		</div>
	</div>