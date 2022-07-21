<?php
/**
 * Affiliate Dashboard - Settings
 *
 * @author  YITH
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $section      string
 * @var $atts         array
 * @var $affiliate    YITH_WCAF_Affiliate
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php do_action( 'yith_wcaf_before_dashboard_section', 'settings', $atts ); ?>

<form method="post">

	<div class="settings-box single-column">

		<?php do_action( 'yith_wcaf_settings_form_start', $atts ); ?>

		<?php if ( apply_filters( 'yith_wcaf_payment_email_required', true ) ) : ?>
			<div class="settings-box">
				<h3><?php echo esc_html_x( 'Payment info', '[FRONTEND] Dashboard Settings', 'yith-woocommerce-affiliates' ); ?></h3>

				<p class="form form-row">
					<label for="payment_email">
						<?php echo esc_html( apply_filters( 'yith_wcaf_payment_email_dashboard_settings', _x( 'Payment email', '[FRONTEND] Dashboard Settings', 'yith-woocommerce-affiliates' ) ) ); ?>
					</label>
					<input type="email" name="payment_email" id="payment_email" value="<?php echo esc_attr( $affiliate->get_payment_email() ); ?>"/>
					<small><?php echo esc_html_x( '(Email address where you want to receive PayPal payments for commissions)', '[FRONTEND] Dashboard Settings', 'yith-woocommerce-affiliates' ); ?></small>
				</p>
			</div>
		<?php endif; ?>

		<?php do_action( 'yith_wcaf_settings_form_after_payment_email' ); ?>

		<?php do_action( 'yith_wcaf_settings_form_before_additional_info' ); ?>

		<?php do_action( 'yith_wcaf_settings_form_after_additional_info' ); ?>

		<?php do_action( 'yith_wcaf_settings_form' ); ?>

	</div>

	<?php wp_nonce_field( 'yith-wcaf-save-affiliate-settings', 'save_affiliate_settings' ); ?>

	<input type="submit" name="settings_submit" value="<?php echo esc_attr_x( 'Save info', '[FRONTEND] Dashboard Settings', 'yith-woocommerce-affiliates' ); ?>"/>

</form>

<?php
do_action( 'yith_wcaf_after_dashboard_section', 'settings', $atts );
