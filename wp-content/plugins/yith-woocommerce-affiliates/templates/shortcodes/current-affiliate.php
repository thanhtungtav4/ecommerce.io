<?php
/**
 * Current Affiliate
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Templates
 * @version 1.0.5
 */

/**
 * Template variables:
 *
 * @var $affiliate            YITH_WCAF_Affiliate
 * @var $user                 WP_User
 * @var $show_gravatar        bool
 * @var $show_real_name       bool
 * @var $show_email           bool
 * @var $no_affiliate_message string
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="yith-wcaf yith-wcaf-current-affiliate woocommerce <?php echo 'yes' === $show_gravatar ? 'with-gravatar' : ''; ?>">

	<?php if ( ! $affiliate ) : ?>

		<p class="no-affiliate-message no-referral-message">
			<?php echo esc_html( $no_affiliate_message ); ?>
		</p>

	<?php else : ?>

		<div class="referral-user <?php echo 'yes' === $show_gravatar ? 'with-avatar' : 'without-avatar'; ?>">

			<?php if ( 'yes' === $show_gravatar ) : ?>
				<div class="affiliate-gravatar referral-avatar">
					<?php echo get_avatar( $user->ID, 64 ); ?>
				</div>
			<?php endif; ?>

			<div class="affiliate-info referral-info">

				<div class="affiliate-name">
					<b><?php echo esc_html( $user->nickname ); ?></b>
					<?php if ( 'yes' === $show_real_name ) : ?>
						<span class="affiliate-real-name">
							<?php echo esc_html( $affiliate->get_formatted_name() ); ?>
						</span>
					<?php endif; ?>
				</div>

				<?php if ( 'yes' === $show_email ) : ?>
					<div class="affiliate-email">
						<a href="mailto:<?php echo esc_attr( $user->user_email ); ?>"><?php echo esc_html( $user->user_email ); ?></a>
					</div>
				<?php endif; ?>

			</div>

		</div>

	<?php endif; ?>

</div>
