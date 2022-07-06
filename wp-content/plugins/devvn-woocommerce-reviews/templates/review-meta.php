<?php
/**
 * The template to display the reviewers meta data (name, verified owner, review date)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review-meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

global $devvn_review_settings;
$label_review = $devvn_review_settings['label_review'];

if ( '0' === $comment->comment_approved ) { ?>

	<p class="meta">
        <strong class="woocommerce-review__author"><?php comment_author(); ?> </strong>
		<em class="woocommerce-review__awaiting-approval">
			<?php esc_html_e( 'Your review is awaiting approval', 'woocommerce' ); ?>
		</em>
	</p>

<?php } else { ?>

	<p class="meta">
		<strong class="woocommerce-review__author"><?php comment_author(); ?> </strong>
		<?php
		if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
		    if($label_review){
                echo '<em class="woocommerce-review__verified verified">' . $label_review . '</em> ';
            }else {
                echo '<em class="woocommerce-review__verified verified">' . sprintf(esc_attr__('Đã mua tại %s', 'devvn'), $_SERVER['SERVER_NAME']) . '</em> ';
            }
		}
		$user_roles = array();
        $user_id = $comment->user_id;
        if($user_id) {
            $user = get_userdata($user_id);
            $user_roles = $user->roles;
            $qtv = devv_check_reviews_admin($user_roles);
            if ( $qtv && $comment->comment_parent != 0) {?>
            <span class="review_qtv"><?php _e('Quản trị viên','devvn-reviews')?></span>
            <?php }
        }
		?>
	</p>

<?php
}
