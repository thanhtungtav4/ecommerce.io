<?php
/**
 * Affiliate Registration Form
 *
 * @author  YITH
 * @package YITH\Affiliates\Templates
 * @version 1.0.5
 */

/**
 * Template variables:
 *
 * @var $show_login_form string
 * @var $login_title     string
 * @var $register_title  string
 * @var $posted          array
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="yith-wcaf yith-wcaf-registration-form woocommerce">
	<?php
	if ( function_exists( 'wc_print_notices' ) ) {
		wc_print_notices();
	}
	?>

	<?php if ( ! is_user_logged_in() ) : ?>

		<?php
		/**
		 * APPLY_FILTERS: yith_wcaf_show_login_section
		 *
		 * Filters whether to show the section to login as an affiliate.
		 *
		 * @param bool $show_login_section Whether to show login section or not.
		 */
		?>
		<div class="forms-container <?php echo apply_filters( 'yith_wcaf_show_login_section', 'yes' === $show_login_form ) ? 'u-columns col2-set' : ''; ?>">

			<?php if ( apply_filters( 'yith_wcaf_show_login_section', 'yes' === $show_login_form ) ) : ?>
				<div class="u-column1 col-1">

					<?php if ( ! empty( $login_title ) ) : ?>
						<h2 class="login-title">
							<?php echo esc_html( $login_title ); ?>
						</h2>
					<?php endif; ?>

					<div class="login-form">
						<form class="woocomerce-form woocommerce-form-login login" method="post">

							<?php do_action( 'woocommerce_login_form_start' ); ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="username">
									<?php echo esc_html_x( 'Username or email address', '[FRONTEND] Affiliate login form', 'yith-woocommerce-affiliates' ); ?>
									<span class="required">*</span>
								</label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php echo ! empty( $posted['username'] ) ? esc_attr( $posted['username'] ) : ''; ?>" />
							</p>
							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="password">
									<?php echo esc_html_x( 'Password', '[FRONTEND] Affiliate login form', 'yith-woocommerce-affiliates' ); ?>
									<span class="required">*</span>
								</label>
								<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
							</p>

							<?php do_action( 'woocommerce_login_form' ); ?>

							<p class="form-row">
								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
								<input type="submit" class="woocommerce-Button button" name="login" value="<?php echo esc_attr_x( 'Login', '[FRONTEND] Affiliate login form', 'yith-woocommerce-affiliates' ); ?>"/>
								<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
									<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"/>
									<span><?php echo esc_html_x( 'Remember me', '[FRONTEND] Affiliate login form', 'yith-woocommerce-affiliates' ); ?></span>
								</label>
							</p>

							<p class="woocommerce-LostPassword lost_password">
								<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
									<?php echo esc_html_x( 'Lost your password?', '[FRONTEND] Affiliate login form', 'yith-woocommerce-affiliates' ); ?>
								</a>
							</p>

							<?php do_action( 'woocommerce_login_form_end' ); ?>

						</form>
					</div>

				</div>
			<?php endif; ?>

			<?php if ( apply_filters( 'yith_wcaf_show_login_section', 'yes' === $show_login_form ) ) : ?>
				<div class="u-column2 col-2">
			<?php endif; ?>

			<?php
			/**
			 * APPLY_FILTERS: yith_wcaf_show_register_section
			 *
			 * Filters whether to show the section to register as an affiliate.
			 *
			 * @param bool $show_register_section Whether to show register section or not.
			 */
			if ( apply_filters( 'yith_wcaf_show_register_section', true ) ) :
				?>

				<?php if ( ! empty( $register_title ) ) : ?>
					<h2 class="register-title">
						<?php echo esc_html( $register_title ); ?>
					</h2>
				<?php endif; ?>

				<div class="register-form">
					<form method="post" class="register">

						<?php do_action( 'woocommerce_register_form_start' ); ?>
						<?php
						/**
						 * DO_ACTION: yith_wcaf_register_form_start
						 *
						 * Allows to render some content at the beginning of the registration form for the affiliates.
						 */
						do_action( 'yith_wcaf_register_form_start' );
						?>
						<?php
						/**
						 * DO_ACTION: yith_wcaf_register_form
						 *
						 * Allows to render some content in the registration form for the affiliates.
						 */
						do_action( 'yith_wcaf_register_form' );
						?>
						<?php do_action( 'woocommerce_register_form' ); ?>

						<p class="form-row">
							<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
							<?php wp_nonce_field( 'yith-wcaf-register-affiliate', 'register_affiliate', false ); ?>

							<input type="submit" class="button" name="register" value="<?php echo esc_attr_x( 'Register', '[FRONTEND] Affiliate registration form', 'yith-woocommerce-affiliates' ); ?>"/>
						</p>

						<?php do_action( 'woocommerce_register_form_end' ); ?>

					</form>
				</div>

			<?php endif; ?>

			<?php if ( apply_filters( 'yith_wcaf_show_login_section', 'yes' === $show_login_form ) ) : ?>
				</div>
			<?php endif; ?>

		</div>

	<?php elseif ( ! YITH_WCAF_Affiliates()->is_user_affiliate() ) : ?>

		<div class="become-an-affiliate-form">
			<p>
				<?php
				/**
				 * APPLY_FILTERS: yith_wcaf_registration_form_become_affiliate_text
				 *
				 * Filters the text displayed in the form to become an affilliate.
				 *
				 * @param string $text Text.
				 */
				echo wp_kses_post( apply_filters( 'yith_wcaf_registration_form_become_affiliate_text', _x( 'You\'re just one step away from becoming an affiliate!', '[FRONTEND] Become an affiliate form', 'yith-woocommerce-affiliates' ) ) );
				?>
			</p>
			<form method="post" class="become-an-affiliate">
				<?php
				/**
				 * DO_ACTION: yith_wcaf_become_an_affiliate_form
				 *
				 * Allows to render some content in the form to "Become an affiliate".
				 */
				do_action( 'yith_wcaf_become_an_affiliate_form' );
				?>

				<p class="form-row">
					<?php wp_nonce_field( 'yith-wcaf-become-an-affiliate', 'become_an_affiliate', true ); ?>

					<?php
					/**
					 * APPLY_FILTERS: yith_wcaf_become_affiliate_button_text
					 *
					 * Filters the text of the button to become an affiliate.
					 *
					 * @param string $text Text.
					 */
					$become_an_affiliate_text = apply_filters( 'yith_wcaf_become_affiliate_button_text', _x( 'Become an affiliate', '[FRONTEND] Become an affiliate form', 'yith-woocommerce-affiliates' ) );
					?>
					<button class="btn button"><?php echo esc_html( $become_an_affiliate_text ); ?></button>
				</p>
			</form>
		</div>

	<?php elseif ( YITH_WCAF_Affiliates()->is_user_enabled_affiliate() ) : ?>

		<div class="already-an-affiliate-wrapper">
			<h3 class="thank-you">
				<?php echo esc_html_x( 'Thank you!', '[FRONTEND] Affiliate dashboard message', 'yith-woocommerce-affiliates' ); ?>
			</h3>
			<p class="already-an-affiliate">
				<?php
				/**
				 * APPLY_FILTERS: yith_wcaf_registration_form_already_affiliate_text
				 *
				 * Filters the text displayed when the user is an affiliate.
				 *
				 * @param string $text Text.
				 */
				echo wp_kses_post( apply_filters( 'yith_wcaf_registration_form_already_affiliate_text', _x( 'You have joined our affiliate program!<br/>In your dashboard, you will find your referral URL and detailed information to check commissions, visits, earnings, and payments.', '[FRONTEND] Affiliate dashboard message', 'yith-woocommerce-affiliates' ) ) );
				?>
			</p>

			<a href="<?php echo esc_url( YITH_WCAF_Dashboard()->get_dashboard_url() ); ?>" class="button go-to-dashboard">
				<?php echo esc_html_x( 'Go to your dashboard', '[FRONTEND] Affiliate dashboard message', 'yith-woocommerce-affiliates' ); ?>
			</a>
		</div>

	<?php elseif ( YITH_WCAF_Affiliates()->is_user_pending_affiliate() ) : ?>

		<div class="pending-request-wrapper">
			<h3 class="thank-you">
				<?php echo esc_html_x( 'Thank you!', '[FRONTEND] Affiliate dashboard message', 'yith-woocommerce-affiliates' ); ?>
			</h3>
			<p class="pending-request">
				<?php
				/**
				 * APPLY_FILTERS: yith_wcaf_registration_form_affiliate_pending_text
				 *
				 * Filters the text when the user is pending to be approved as an affiliate.
				 *
				 * @param string $text Text.
				 */
				echo wp_kses_post( apply_filters( 'yith_wcaf_registration_form_affiliate_pending_text', _x( 'Your request has been registered and it is awaiting the administrators\' approval!<br/>You will get an email soon.', '[FRONTEND] Affiliate dashboard message', 'yith-woocommerce-affiliates' ) ) );
				?>
			</p>
		</div>

	<?php elseif ( YITH_WCAF_Affiliates()->is_user_rejected_affiliate() ) : ?>

		<div class="rejected-request-wrapper">
			<h3 class="we-are-sorry">
				<?php echo esc_html_x( 'We\'re sorry!', '[FRONTEND] Affiliate dashboard message', 'yith-woocommerce-affiliates' ); ?>
			</h3>
			<p class="rejected-request">
				<?php
				$reject_message = YITH_WCAF_Affiliates()->get_user_reject_message();

				if ( ! $reject_message ) {
					$reject_message = _x( 'We regretfully inform you that we can\'t accept your request as it doesn\'t fulfill our requirements.', '[FRONTEND] Affiliate dashboard message', 'yith-woocommerce-affiliates' );
				}

				/**
				 * APPLY_FILTERS: yith_wcaf_registration_form_rejected_affiliate_text
				 *
				 * Filters the message when the user has been rejected as an affiliate.
				 *
				 * @param string $reject_message Reject message.
				 */
				echo wp_kses_post( apply_filters( 'yith_wcaf_registration_form_rejected_affiliate_text', $reject_message ) );
				?>
			</p>
		</div>

	<?php endif; ?>
</div>
