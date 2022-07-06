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

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h2 class="woocommerce-Reviews-title">
			<?php
			$count = $product->get_review_count();
			if ( $count && wc_review_ratings_enabled() ) {
				/* translators: 1: reviews count 2: product name */
				$reviews_title = sprintf( esc_html( _n( '%1$s đánh giá cho %2$s', '%1$s đánh giá cho %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
				echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
			} else {
                echo sprintf(esc_html( 'Đánh giá %s', 'woocommerce' ), get_the_title());
			}
			?>
		</h2>

        <div class="star_box">
            <div class="star_box_left">
                <div class="star-average">
                    <?php
                    if ( wc_review_ratings_enabled() ) {


                        $rating_count = $product->get_rating_count();
                        $review_count = $product->get_review_count();
                        $average = $product->get_average_rating();

                        if ($rating_count > 0) : ?>

                            <div class="woocommerce-product-rating">
                                <span class="star_average"><?php echo $average;?></span>
                                <?php echo wc_get_rating_html($average, $rating_count); // WPCS: XSS ok. ?>
                                <?php if (comments_open()) : ?>
                                    <a href="#reviews" class="woocommerce-review-link" rel="nofollow"><?php printf(_n('%s customer review', '%s customer reviews', $review_count, 'woocommerce'), '<span class="count">' . esc_html($review_count) . '</span>'); ?></a>
                                <?php endif ?>
                            </div>

                        <?php endif;
                    }
                    ?>
                </div>
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
                        <span class="devvn_stars_value"><?php printf(_n('%s', '%s', $i, 'devvn'), $i); ?><i class="devvn-star"></i></span>
                        <span class="devvn_rating_bar">
                            <span style="background-color: #eee" class="devvn_scala_rating">
                                <span class="devvn_perc_rating" style="width: <?php echo $perc; ?>%; background-color: #f5a623"></span>
                            </span>
                        </span>
                        <span class="devvn_num_reviews"><b><?php echo $perc;?>%</b> | <?php echo $review_stats[$i]; ?> đánh giá</span>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
            <div class="star_box_right">
                <a href="javascript:void(0)" title="Đánh giá ngay" class="btn-reviews-now">Đánh giá ngay</a>
            </div>
            <?php endif;?>
        </div>

        <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
            <div id="review_form_wrapper" class="mfp-hide">
                <div id="review_form">
                    <?php
                    $commenter = wp_get_current_commenter();

                    $comment_form = array(
                        /* translators: %s is product title */
                        'title_reply'         => sprintf( __( 'Đánh giá %s', 'devvn' ), get_the_title()),
                        /* translators: %s is product title */
                        'title_reply_to'      => __( 'Leave a Reply to %s', 'woocommerce' ),
                        'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
                        'title_reply_after'   => '</span>',
                        'comment_notes_before' => '',
                        'comment_notes_after' => '',
                        'fields'              => array(
                            'author' => '<div class="form_row_reviews"><p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required placeholder="Họ tên (Bắt buộc)"/></p>',
                            'email'  => '<p class="comment-form-email"><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" placeholder="Email (Không bắt buộc)"/></p></div>',
                        ),
                        'label_submit'        => __( 'Gửi đánh giá ngay', 'devvn' ),
                        'logged_in_as'        => '',
                        'comment_field'       => '',
                        'cancel_reply_link'    => __( 'Hủy', 'devvn-reviews' ),
                    );

                    $account_page_url = wc_get_page_permalink( 'myaccount' );
                    if ( $account_page_url ) {
                        /* translators: %s opening and closing link tags respectively */
                        $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
                    }
                    if(!$devvn_review_settings['disable_upload']) {
                        $attach = '<span class="btn-attach devvn_insert_attach">Gửi ảnh chụp thực tế</span>';
                        //$attach .= '<input type="file" name="files" id="files" accept="image/jpeg, image/png, image/gif, image/x-png">';

                        $list_attach = '<div class="list_attach">';
                        $list_attach .= '<ul class="devvn_attach_view"></ul><span class="devvn_insert_attach"><i class="devvn-plus">+</i></span>';
                        $list_attach .= '</div>';
                    }else{
                        $attach = $list_attach = '';
                    }

                    $comment_form['comment_field'] .= '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" minlength="10" required placeholder="Mời bạn chia sẻ thêm một số cảm nhận..."></textarea></div>';
                    $comment_form['comment_field'] .= '<div class="wrap-attaddsend"><div class="review-attach">'.$attach.'</div><span id="countContent">0 ký tự (tối thiểu 10)</span></div>';
                    $comment_form['comment_field'] .= $list_attach;

                    if ( wc_review_ratings_enabled() ) {
                        $comment_form['comment_field'] .= '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Bạn cảm thấy sản phẩm như thế nào?(chọn sao nhé):', 'devvn' ) . '</label><select name="rating" id="rating" required>
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
                        printf(__('<div class="note_review"><u>Lưu ý:</u> Để đánh giá được duyệt, quý khách vui lòng tham khảo %s</div>','devvn'), '<a href="'.get_permalink($page_quy_dinh_danh_gia).'" title="" target="_blank">'.get_the_title($page_quy_dinh_danh_gia).'</a>');
                    }
                    ?>
                </div>
                <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path></svg></button>
            </div>
        <?php else : ?>
            <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
        <?php endif; ?>

	</div>

	<div class="clear"></div>
</div>