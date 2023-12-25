<?php
/**
 * Reject affiliate modal
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Views
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $affiliate_identifier string
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<script type="text/template" id="tmpl-yith-wcaf-disable-affiliate-modal">
	<div id="disable_affiliate_modal">
		<form>
			<div class="form-row">
				<# if ( 1 === data.affiliates.length ) { #>
				<?php
				echo wp_kses_post(
					sprintf(
					// translators: 1. Affiliate complete name.
						_x( 'You\'re about to reject <strong>%s</strong> application for your affiliate program.', '[ADMIN] Reject affiliate modal', 'yith-woocommerce-affiliates' ),
						'{{data.affiliates[0].fullName}}'
					)
				);
				?>
				<# } else { #>
				<?php
				echo wp_kses_post(
					sprintf(
					// translators: 1. Number of affiliates that you're going to ban.
						_x( 'You\'re about to reject <strong>%s affiliates</strong> application for your affiliate program.', '[ADMIN] Reject affiliate modal', 'yith-woocommerce-affiliates' ),
						'{{data.affiliates.length}}'
					)
				);
				?>
				<# } #>
			</div>
			<div class="form-row">
				<# if ( 1 === data.affiliates.length ) { #>
				<?php
					echo esc_html_x( 'Add an optional reason if you want to explain why his/her application is being rejected.', '[ADMIN] Reject affiliate modal', 'yith-woocommerce-affiliates' )
				?>
				<# } else { #>
				<?php
					echo esc_html_x( 'Add an optional reason if you want to explain why their application is being rejected.', '[ADMIN] Reject affiliate modal', 'yith-woocommerce-affiliates' )
				?>
				<# } #>
			</div>
			<div class="form-row form-row-wide">
				<label for="disable_message" class="screen-reader-text">
					<?php echo esc_html_x( 'Reject message', '[ADMIN] Reject affiliate modal', 'yith-woocommerce-affiliates' ); ?>
				</label>
				<textarea name="message" id="disable_message" rows="5"></textarea>
			</div>
			<div class="form-row form-row-wide submit">
				<button class="submit button-primary">
					<# if ( 1 === data.affiliates.length ) { #>
					<?php echo esc_html_x( 'Reject affiliate', '[ADMIN] Reject affiliate modal', 'yith-woocommerce-affiliates' ); ?>
					<# } else { #>
					<?php echo esc_html_x( 'Reject affiliates', '[ADMIN] Reject affiliate modal', 'yith-woocommerce-affiliates' ); ?>
					<# } #>
				</button>
			</div>
		</form>
	</div>
</script>
