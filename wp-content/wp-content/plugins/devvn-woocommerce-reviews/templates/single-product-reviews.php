<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product, $devvn_review_settings;

if ( ! comments_open() ) {
	return;
}

$name_email_required = (bool) get_option( 'require_name_email', 1 );
$hidden_phone_reviews = isset($devvn_review_settings['hidden_phone_reviews']) ? intval($devvn_review_settings['hidden_phone_reviews']) : 2;
?>
<?php do_action('devvn_before_review_comment', $product);?>
<div id="reviews" class="style-v2 woocommerce-Reviews <?php echo (isset($devvn_review_settings['show_avatar_review']) && $devvn_review_settings['show_avatar_review'] == 1) ? 'show_avatar' : 'no_avatar';?> <?php echo $devvn_review_settings['rv_style'];?>">
	<div id="comments">
        <?php do_shortcode('before_devvn_reviews_title');?>
		<div class="woocommerce-Reviews-title">
			<?php
			$count = $product->get_review_count();
			if ( $count && wc_review_ratings_enabled() ) {
				/* translators: 1: reviews count 2: product name */
				$reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'devvn-reviews' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
				echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
			} else {
                echo sprintf(esc_html( __('Review %s', 'devvn-reviews') ), get_the_title());
			}
			?>
		</div>

        <div class="star_box">
            <div class="star-average">
                <?php
                if ( wc_review_ratings_enabled() ) {
                    $rating_count = $product->get_rating_count();
                    $review_count = $product->get_review_count();
                    $average = $product->get_average_rating();
                    ?>
                    <div class="woocommerce-product-rating">
                        <?php if($average):?>
                        <span class="star_average"><?php echo $average;?> <i class="devvn-star"></i></span>
                        <strong><?php _e('Average rating', 'devvn-reviews')?></strong>
                        <?php else:?>
                        <strong><?php _e('No reviews', 'devvn-reviews')?></strong>
                        <?php endif;?>
                        <?php do_action('devvn_after_rating_form')?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="star_box_left">
                <div class="reviews_bar">
                    <?php
                    $review_stats = array(
                        '1'     => count( devvn_reviews()->devvn_get_product_reviews_by_rating( $product->get_id(), 1 ) ),
                        '2'     => count( devvn_reviews()->devvn_get_product_reviews_by_rating( $product->get_id(), 2 ) ),
                        '3'     => count( devvn_reviews()->devvn_get_product_reviews_by_rating( $product->get_id(), 3 ) ),
                        '4'     => count( devvn_reviews()->devvn_get_product_reviews_by_rating( $product->get_id(), 4 ) ),
                        '5'     => count( devvn_reviews()->devvn_get_product_reviews_by_rating( $product->get_id(), 5 ) ),
                        'total' => count( devvn_reviews()->devvn_get_product_reviews_by_rating( $product->get_id() ) ),
                    );
                    for ($i = 5; $i >= 1; $i--) :
                    $perc = ($review_stats['total'] == '0') ? 0 : floor($review_stats[$i] / $review_stats['total'] * 100);
                    ?>
                    <div class="devvn_review_row">
                        <span class="devvn_stars_value"><?php printf(_n('%s', '%s', $i, 'devvn-reviews'), number_format_i18n($i)); ?><i class="devvn-star"></i></span>
                        <span class="devvn_rating_bar">
                            <span style="background-color: #eee" class="devvn_scala_rating">
                                <span class="devvn_perc_rating" style="width: <?php echo $perc; ?>%; background-color: #f5a623"></span>
                            </span>
                        </span>
                        <span class="devvn_num_reviews"><b><?php echo $perc;?>%</b> | <?php ($review_stats[$i] == 0) ? _e('0 review','devvn-reviews') : printf( _n( '%s review', '%s reviews', $review_stats[$i], 'devvn-reviews' ), esc_html( $review_stats[$i] ) )?></span>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
            <div class="star_box_right">
                <a href="javascript:void(0)" title="<?php _e('Write a review','devvn-reviews')?>" class="btn-reviews-now"><?php _e('Write a review','devvn-reviews')?></a>
            </div>
            <?php endif;?>
        </div>

        <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
            <div id="review_form_wrapper" class="mfp-hide">
                <div id="review_form">
                    <?php
                    $commenter = wp_get_current_commenter();
                    $required = $name_email_required ? 'required' : '';
                    $comment_form = array(
                        /* translators: %s is product title */
                        'title_reply'         => sprintf( __( 'Review %s', 'devvn-reviews' ), get_the_title()),
                        /* translators: %s is product title */
                        'title_reply_to'      => __( 'Leave a Reply to %s', 'devvn-reviews' ),
                        'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
                        'title_reply_after'   => '</span>',
                        'comment_notes_before' => '',
                        'comment_notes_after' => '',
                        'fields'              => array(
                            'author' => '<div class="form_row_reviews"><p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required placeholder="'.__('Your name (Required)','devvn-reviews').'"/></p>',
                            'phone' => '<p class="comment-form-phone"><input id="phone" name="phone" type="text" size="30" required placeholder="'.__('Your phone (Required)','devvn-reviews').'"/></p>',
                            'email'  => '<p class="comment-form-email"><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" placeholder="'.__('Email','devvn-reviews').' '.($required ? __('(Required)','devvn-reviews') : '').'" '.$required.'/></p></div>',
                        ),
                        'label_submit'        => __( 'Submit a review', 'devvn-reviews' ),
                        'logged_in_as'        => '',
                        'comment_field'       => '',
                        'cancel_reply_link'    => __( 'Cancel', 'devvn-reviews' ),
                    );

                    if($hidden_phone_reviews == 1 && isset($comment_form['fields']['phone'])){
                        unset($comment_form['fields']['phone']);
                    }

                    $account_page_url = wc_get_page_permalink( 'myaccount' );
                    if ( $account_page_url ) {
                        /* translators: %s opening and closing link tags respectively */
                        $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
                    }
                    if(!$devvn_review_settings['disable_upload']) {
                        $attach = '<span class="btn-attach devvn_insert_attach">'.__('Choose a image','devvn-reviews').'</span>';
                        //$attach .= '<input type="file" name="files" id="files" accept="image/jpeg, image/png, image/gif, image/x-png">';

                        $list_attach = '<div class="list_attach">';
                        $list_attach .= '<ul class="devvn_attach_view"></ul><span class="devvn_insert_attach"><i class="devvn-plus">+</i></span>';
                        $list_attach .= '</div>';
                    }else{
                        $attach = $list_attach = '';
                    }

                    ob_start();
                    do_action('devvn_reviews_before_comment_field', $comment_form, $commenter, $product);
                    $comment_form['comment_field'] .= ob_get_clean();

                    $comment_form['comment_field'] .= '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" minlength="10" required placeholder="'.__('Please share some comments...','devvn-reviews').'"></textarea></div>';
                    $comment_form['comment_field'] .= '<div class="wrap-attaddsend"><div class="review-attach">'.$attach.'</div><span id="countContent">'.sprintf(__('0 character ( Minimum of %d)','devvn-reviews'), $devvn_review_settings['cmt_length']).'</span></div>';
                    $comment_form['comment_field'] .= $list_attach;

                    if ( wc_review_ratings_enabled() ) {
                        $comment_form['comment_field'] .= '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'How do you feel about the product? ( Select star)', 'devvn-reviews' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
					</select></div>';
                    }

                    comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

                    $page_quy_dinh_danh_gia = get_option( 'woocommerce_terms_page_id' );
                    if(!$page_quy_dinh_danh_gia && class_exists('acf')){
                        $page_quy_dinh_danh_gia = get_field('page_quy_dinh_danh_gia', 'option');
                        if($page_quy_dinh_danh_gia) {
                            $page_quy_dinh_danh_gia = $page_quy_dinh_danh_gia->ID;
                        }
                    }
                    if($page_quy_dinh_danh_gia){
                        printf(__('<div class="note_review"><u>Note:</u> for review to be approved, please refer to %s</div>','devvn-reviews'), '<a href="'.get_permalink($page_quy_dinh_danh_gia).'" title="" target="_blank">'.get_the_title($page_quy_dinh_danh_gia).'</a>');
                    }

                    do_action('devvn_after_form_reviews');
                    ?>
                </div>
                <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path></svg></button>
            </div>
        <?php else : ?>
            <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
        <?php endif; ?>

        <?php
        if($devvn_review_settings['show_img_reviews']):?>
            <?php echo do_shortcode('[devvn_list_reviews post_id="'.$product->get_id().'" view_style="2"]');?>
        <?php endif;?>

		<?php if ( have_comments() ) : ?>
			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments', 'type'=>'review' ) ) ); ?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                add_filter('paginate_links_output','devvn_woocommerce_paginate_links_output', 10, 2);
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
                remove_filter('paginate_links_output','devvn_woocommerce_paginate_links_output', 10);
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
		<?php endif; ?>
	</div>
    <?php do_shortcode('after_devvn_reviews_form');?>
	<div class="clear"></div>
</div>
<?php do_action('devvn_mid_review_comment', $product);?>
<?php if($devvn_review_settings['show_tcmt'] == 1):?>
<div class="devvn_prod_cmt <?php echo apply_filters('devvn_class_faq', '');?>" id="<?php echo apply_filters('devvn_id_faq', 'hoi-dap');?>">
    <<?php echo apply_filters('devvn_headings_faq', 'strong');?>><?php _e('Question and Answer','devvn-reviews');?></<?php echo apply_filters('devvn_headings_faq', 'strong');?>>
    <div class="devvn_cmt_form">
        <form action="" method="post" id="devvn_cmt">
        <div class="devvn_cmt_input">
            <textarea placeholder="<?php _e('Type your comments...','devvn-reviews');?>" name="devvn_cmt_content" id="devvn_cmt_content" minlength="20"></textarea>
        </div>
        <div class="devvn_cmt_form_bottom <?php echo (!is_user_logged_in()) ? '' : 'no-infor';?>">
            <?php if(!is_user_logged_in()):?>
            <div class="devvn_cmt_radio">
                <label>
                    <input name="devvn_cmt_gender" type="radio" value="male" checked/>
                    <span><?php _e('Male','devvn-reviews');?></span>
                </label>
                <label>
                    <input name="devvn_cmt_gender" type="radio" value="female"/>
                    <span><?php _e('Female','devvn-reviews');?></span>
                </label>
            </div>
            <div class="devvn_cmt_input">
                <input name="devvn_cmt_name" type="text" id="devvn_cmt_name" placeholder="<?php _e('Your name (Required)','devvn-reviews');?>"/>
            </div>
            <?php if($devvn_review_settings['tcmt_phone'] == 1):?>
            <div class="devvn_cmt_input">
                <input name="devvn_cmt_phone" type="text" id="devvn_cmt_phone" required placeholder="<?php _e('Your phone (Required)','devvn-reviews');?>"/>
            </div>
            <?php endif;?>
            <?php if($devvn_review_settings['active_field_email'] == 1):?>
            <div class="devvn_cmt_input">
                <input name="devvn_cmt_email" type="text" id="devvn_cmt_email" <?php echo $name_email_required ? 'required' : '';?> placeholder="<?php _e('Email','devvn-reviews');?> <?php echo $name_email_required ? __('(Required)','devvn-reviews') : '';?>"/>
            </div>
            <?php endif;?>
            <?php endif; //user login?>
            <div class="devvn_cmt_submit">
                <button type="submit" id="devvn_cmt_submit"><?php _e('Post comment','devvn-reviews');?></button>
                <input type="hidden" value="<?php echo $product->get_id();?>" name="post_id">
                <input type="hidden" value="" name="cmt_parent_id">
            </div>
        </div>
            <?php do_action('devvn_after_form_comment');?>
        </form>
    </div>
    <div class="devvn_cmt_list">
        <?php echo devvn_reviews()->devvn_list_all_tcomment($product);?>
    </div>
</div>
<?php endif;?>
<?php do_action('devvn_after_review_comment', $product);?>
