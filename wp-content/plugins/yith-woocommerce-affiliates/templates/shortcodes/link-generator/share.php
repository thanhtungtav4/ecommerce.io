<?php
/**
 * Share template
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $share_title             string
 * @var $share_link_title        string
 * @var $share_link_url          string
 * @var $share_summary           string
 * @var $share_twitter_summary   string
 * @var $share_image_url         string
 * @var $share_facebook_enabled  bool
 * @var $share_twitter_enabled   bool
 * @var $share_pinterest_enabled bool
 * @var $share_email_enabled     bool
 * @var $share_whatsapp_enabled  bool
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( empty( $share_summary ) ) {
	// translators: 1. Blog name. 2. Share link url.
	$share_summary = sprintf( _x( 'My Referral URL on %1$s - %2$s', '[FRONTEND] Share message', 'yith-woocommerce-affiliates' ), get_bloginfo( 'name' ), rawurlencode( $share_link_url ) );
}

?>
	<div class="yith-wcaf-share">
		<h4 class="yith-wcaf-share-title"><?php echo esc_html( $share_title ); ?></h4>
		<ul>

			<?php if ( $share_facebook_enabled ) : ?>
				<li style="list-style-type: none; display: inline-block;">
					<a
						target="_blank"
						class="icon-yith-facebook-official"
						href="http://www.facebook.com/sharer.php?u=<?php echo rawurlencode( $share_link_url ); ?>&p[title]=<?php echo esc_attr( $share_link_title ); ?>&p[summary]=<?php echo esc_attr( $share_summary ); ?>"
						title="<?php echo esc_attr_x( 'Facebook', '[FRONTEND] Share button title', 'yith-woocommerce-affiliates' ); ?>"
					></a>
				</li>
			<?php endif; ?>

			<?php if ( $share_twitter_enabled ) : ?>
				<li style="list-style-type: none; display: inline-block;">
					<a
						target="_blank"
						class="icon-yith-twitter"
						href="https://twitter.com/share?url=<?php echo rawurlencode( $share_link_url ); ?>&amp;text=<?php echo esc_attr( $share_twitter_summary ); ?>"
						title="<?php echo esc_attr_x( 'Twitter', '[FRONTEND] Share button title', 'yith-woocommerce-affiliates' ); ?>"
					></a>
				</li>
			<?php endif; ?>

			<?php if ( $share_pinterest_enabled ) : ?>
				<li style="list-style-type: none; display: inline-block;">
					<a
						target="_blank"
						class="icon-yith-pinterest-squared"
						href="http://pinterest.com/pin/create/button/?url=<?php echo rawurlencode( $share_link_url ); ?>&amp;description=<?php echo esc_attr( $share_summary ); ?>&amp;media=<?php echo esc_attr( $share_image_url ); ?>"
						title="<?php echo esc_attr_x( 'Pinterest', '[FRONTEND] Share button title', 'yith-woocommerce-affiliates' ); ?>"
						onclick="window.open( this.href ); return false;"
					></a>
				</li>
			<?php endif; ?>

			<?php
			if ( $share_email_enabled ) :
				/**
				 * APPLY_FILTERS: yith_wcaf_email_share_subject
				 *
				 * Filters the subject of the email to share the referral URL.
				 *
				 * @param string $share_link_title Email subject.
				 */

				/**
				 * APPLY_FILTERS: yith_wcaf_email_share_body
				 *
				 * Filters the body of the email to share the referral URL.
				 *
				 * @param string $share_link_url Share URL.
				 * @param string $share_summary  Share URL.
				 */
				?>
				<li style="list-style-type: none; display: inline-block;">
					<a
						class="icon-yith-mail-alt"
						href="mailto:?subject=<?php echo rawurlencode( apply_filters( 'yith_wcaf_email_share_subject', $share_link_title ) ); ?>&amp;body=<?php echo esc_attr( apply_filters( 'yith_wcaf_email_share_body', rawurlencode( $share_link_url ), $share_summary ) ); ?>&amp;title=<?php echo esc_attr( $share_link_title ); ?>"
						title="<?php echo esc_attr_x( 'Email', '[FRONTEND] Share button title', 'yith-woocommerce-affiliates' ); ?>"
					></a>
				</li>
			<?php endif; ?>

			<?php if ( $share_whatsapp_enabled && wp_is_mobile() ) : ?>
				<li style="list-style-type: none; display: inline-block;">
					<a
						target="_blank"
						class="icon-yith-whatsapp"
						href="whatsapp://send?text=<?php echo esc_attr( $share_summary ); ?>"
						data-action="share/whatsapp/share"
						title="<?php echo esc_attr_x( 'WhatsApp', '[FRONTEND] Share button title', 'yith-woocommerce-affiliates' ); ?>"
					></a>
				</li>

			<?php endif; ?>
			<?php if ( $share_whatsapp_enabled && ! wp_is_mobile() ) : ?>
				<li style="list-style-type: none; display: inline-block;">
					<a
						target="_blank"
						class="icon-yith-whatsapp"
						href="https://web.whatsapp.com/send?text=<?php echo esc_attr( $share_summary ); ?>"
						data-action="share/whatsapp/share"
						title="<?php echo esc_attr_x( 'WhatsApp Web', '[FRONTEND] Share button title', 'yith-woocommerce-affiliates' ); ?>"
					></a>
				</li>
			<?php endif; ?>

		</ul>
	</div>

<?php
/**
 * DO_ACTION: yith_wcaf_after_share_buttons
 *
 * Allows to render some content after the buttons to share the affiliate's referral URL in the Affiliate Dashboard.
 *
 * @param string $share_link_url   Referral URL to share.
 * @param string $share_title      Title to share referral URL.
 * @param string $share_link_title Title in the referral URL.
 */
do_action( 'yith_wcaf_after_share_buttons', $share_link_url, $share_title, $share_link_title );
?>
