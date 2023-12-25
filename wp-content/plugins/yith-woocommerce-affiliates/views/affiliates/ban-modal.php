<?php
/**
 * Ban affiliate modal
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Views
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<script type="text/template" id="tmpl-yith-wcaf-ban-affiliate-modal">
	<div id="ban_affiliate_modal">
		<form>
			<div class="form-row">
				<# if ( 1 === data.affiliates.length ) { #>
				<?php
				echo wp_kses_post(
					sprintf(
						// translators: 1. Affiliate complete name.
						_x( 'You\'re about to ban <strong>%s</strong> from your affiliate program.', '[ADMIN] Ban affiliate modal', 'yith-woocommerce-affiliates' ),
						'{{data.affiliates[0].fullName}}'
					)
				);
				?>
				<# } else { #>
				<?php
				echo wp_kses_post(
					sprintf(
					// translators: 1. Number of affiliates that you're going to ban.
						_x( 'You\'re about to ban <strong>%s affiliates</strong> from your affiliate program.', '[ADMIN] Ban affiliate modal', 'yith-woocommerce-affiliates' ),
						'{{data.affiliates.length}}'
					)
				);
				?>
				<# } #>
			</div>
			<div class="form-row">
				<# if ( 1 === data.affiliates.length ) { #>
				<?php
					echo esc_html_x( 'Add an optional reason if you want to explain why he/she is being banned.', '[ADMIN] Ban affiliate modal', 'yith-woocommerce-affiliates' )
				?>
				<# } else { #>
				<?php
					echo esc_html_x( 'Add an optional reason if you want to explain why they\'re being banned.', '[ADMIN] Ban affiliate modal', 'yith-woocommerce-affiliates' )
				?>
				<# } #>
			</div>
			<div class="form-row form-row-wide">
				<label for="ban_message" class="screen-reader-text">
					<?php echo esc_html_x( 'Ban message', '[ADMIN] Ban Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
				</label>
				<textarea name="message" id="ban_message" rows="5"></textarea>
			</div>
			<div class="form-row form-row-wide submit">
				<button class="submit button-primary">
					<# if ( 1 === data.affiliates.length ) { #>
					<?php echo esc_html_x( 'Ban affiliate', '[ADMIN] Ban Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
					<# } else { #>
					<?php echo esc_html_x( 'Ban affiliates', '[ADMIN] Ban Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
					<# } #>
				</button>
			</div>
		</form>
	</div>
</script>
