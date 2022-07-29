<?php
/**
 * @package WordPress
 * @subpackage Theme_Compat
 * @deprecated 3.0.0
 *
 * This file is here for backward compatibility with old themes and will be removed in a future version
 */

// Do not delete these lines.
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}

if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.' ); ?></p>
	<?php
	return;
}
?>

<!-- You can start editing here. -->
<?php do_action('before_devvn_post_comment');?>
<?php do_action('flatsome_before_comments'); ?>
<div id="comments">
<div id="reviews" class="devvn-comments-area">
    <div id="comments-title">
        <span><?php
        printf(
	        _n( __('Question and answer (%1$s comment)', 'devvn-reviews'), __('Question and answer (%1$s comments)','devvn-reviews'), get_comments_number() ),
	        number_format_i18n( get_comments_number() )
        );
        ?></span>
    </div>

    <?php
    $commenter     = wp_get_current_commenter();
    $user          = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    $args = array();
    if ( ! isset( $args['format'] ) ) {
	    $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
    }

    $req      = get_option( 'require_name_email' );
    $html_req = ( $req ? " required='required'" : '' );
    $html5    = 'html5' === $args['format'];
    $req_phone = apply_filters('devvn_post_comment_phone_req', true);
    $html_req_phone = ( $req_phone ? " required='required'" : '' );

    $args = array(
	    'fields' => array(
            //'open_wrap' => '<div class="devvn_row_post_comment">',
		    'author' => sprintf(
			    '<p class="comment-form-author">%s</p>',
			    sprintf(
				    '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245"%s placeholder="%s"/>',
				    esc_attr( $commenter['comment_author'] ),
				    ' required="required"',
                    __('Your Name','devvn-reviews') . '*'
			    )
		    ),
		    'email'  => sprintf(
			    '<p class="comment-form-email">%s</p>',
			    sprintf(
				    '<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s placeholder="%s"/>',
				    ( $html5 ? 'type="email"' : 'type="text"' ),
				    esc_attr( $commenter['comment_author_email'] ),
				    $html_req,
				    __('Your Email','devvn-reviews') . ( $req ? ' *' : '' )
			    )
		    ),
		    /*'phone'    => sprintf(
			    '<p class="comment-form-phone">%s</p>',
			    sprintf(
				    '<input id="phone" type="text" name="phone" %s value="%s" size="30" maxlength="11" placeholder="%s" />',
				    $html_req_phone,
				    isset($commenter['comment_author_phone']) ? esc_attr( $commenter['comment_author_phone']) : '',
				    __('Your Phone','devvn-reviews') . ( $req_phone ? ' *' : '' )
			    )
		    ),*/
            //'close_wrap' => '</div>',
            'cookies' => has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ? '<input name="wp-comment-cookies-consent" type="hidden" value="yes"/>' : ''
	    ),
        'title_reply' => '',
	    'comment_field'        => sprintf(
		    '<p class="comment-form-comment">%s</p><div class="devvn_row_post_comment">',
		    '<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="'.__('Type your comment here','devvn-reviews').'"></textarea>'
	    ),
        'comment_notes_before'  => '',
		'submit_field'         => '<p class="form-submit">%1$s %2$s</p></div>',
	    'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
	    'title_reply_after'   => '</span>',
	    'logged_in_as'        => '',
	    'cancel_reply_link'        => 'x',
    );
    $reviews_setting = devvn_reviews()->get_options();
    $enable_postcmt_phone = $reviews_setting['enable_postcmt_phone'];
    if($enable_postcmt_phone == 1){
        $args['fields']['phone'] = sprintf(
            '<p class="comment-form-phone">%s</p>',
            sprintf(
                '<input id="phone" type="text" name="phone" %s value="%s" size="30" maxlength="11" placeholder="%s" />',
                $html_req_phone,
                isset($commenter['comment_author_phone']) ? esc_attr( $commenter['comment_author_phone']) : '',
                __('Your Phone','devvn-reviews') . ( $req_phone ? ' *' : '' )
            )
        );
    }
    comment_form(apply_filters('devvn_post_comment_form', $args));
    ?>

    <?php if ( have_comments() ) : ?>

        <ol class="commentlist">
        <?php
        wp_list_comments(array(
            'walker' => new DevVN_Walker_Post_Comment(),
            'avatar_size' => apply_filters('devvn_post_comment_avatar_size', 30),
        ));
        ?>
        </ol>

	    <?php
	    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            add_filter('paginate_links_output','devvn_woocommerce_paginate_links_output', 10, 2);
		    echo '<nav class="woocommerce-pagination">';
		    paginate_comments_links(
			    apply_filters(
				    'devvn_post_comment_pagination_args',
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
    <?php else : // This is displayed if there are no comments so far. ?>

        <?php if ( comments_open() ) : ?>
            <!-- If comments are open, but there are no comments. -->

        <?php else : // Comments are closed. ?>
            <!-- If comments are closed. -->
            <p class="nocomments"><?php _e( 'Comments are closed.' ); ?></p>

        <?php endif; ?>
    <?php endif; ?>

</div>
</div>
<?php do_action('after_devvn_post_comment');?>