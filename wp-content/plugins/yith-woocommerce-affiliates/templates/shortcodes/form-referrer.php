<?php
/**
 * Referral Form
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Templates
 * @version 1.0.6
 */

/**
 * Template variables:
 *
 * @var $affiliate_token string
 * @var $editable        bool
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="yith-wcaf yith-wcaf-set-referrer woocommerce">
	<div class="set-referrer-wrapper">
		<?php
		/**
		 * APPLY_FILTERS: yith_wcaf_set_referrer_message
		 *
		 * Filters the message shown in the section to enter the affiliate's code.
		 *
		 * @param string $message Message.
		 */
		$info_message = apply_filters( 'yith_wcaf_set_referrer_message', _x( 'Did anyone suggest our site to you?', '[FRONTEND] Set referrer shortcode', 'yith-woocommerce-affiliates' ) . ' <a href="#" class="show-referrer-form">' . _x( 'Click here to enter his/her affiliate code', '[FRONTEND] Set referrer shortcode', 'yith-woocommerce-affiliates' ) . '</a>' );

		/**
		 * APPLY_FILTERS: yith_wcaf_show_referral_field
		 *
		 * Filters whether to show the section to enter the referral token in the checkout.
		 *
		 * @param bool $show_referral_field Whether to show the referral field or not.
		 */
		if ( apply_filters( 'yith_wcaf_show_referral_field', true ) ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_show_message_wc_print_notice
			 *
			 * Filters whether to show the message as a notice.
			 *
			 * @param bool $show_message_as_notice Whether to show the message as a notice or not.
			 */
			if ( apply_filters( 'yith_wcaf_show_message_wc_print_notice', true ) && function_exists( 'wc_print_notice' ) ) {
				wc_print_notice( $info_message, 'notice' );
			} else {
				echo wp_kses_post( $info_message );
			}
		}

		?>

		<form class="referrer-form" method="post" style="display:none">

			<p class="form-row form-row-first">
				<input type="text" name="referrer_code" class="input-text" placeholder="<?php echo esc_attr_x( 'Affiliate code', '[FRONTEND] Set referrer shortcode', 'yith-woocommerce-affiliates' ); ?>" value="<?php echo esc_attr( $affiliate_token ); ?>" <?php echo ! $editable ? 'readonly="readonly"' : ''; ?> />
			</p>

			<p class="form-row form-row-last">
				<input type="submit" class="button" name="set_referrer" value="<?php echo esc_attr_x( 'Set affiliate', '[FRONTEND] Set referrer shortcode', 'yith-woocommerce-affiliates' ); ?>" <?php echo ! $editable ? 'disabled="disabled"' : ''; ?> />
			</p>

			<div class="clear"></div>

		</form>
	</div>
</div>

