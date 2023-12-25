<?php
/**
 * Add new affiliate modal
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Views
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<script type="text/template" id="tmpl-yith-wcaf-add-affiliate-modal-title">
	<ul class="tab-anchors">
		<li>
			<a href="#" class="tab-anchor" data-tab="add_affiliate">
				<?php echo esc_attr_x( 'Add affiliate', '[ADMIN] Tab title in Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
			</a>
		</li>
		<li>
			<a href="#" class="tab-anchor" data-tab="create_affiliate">
				<?php echo esc_attr_x( 'Create affiliate', '[ADMIN] Tab title in Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
			</a>
		</li>
	</ul>
</script>

<script type="text/template" id="tmpl-yith-wcaf-add-affiliate-modal">
	<div id="add_affiliate_modal">
		<form method="post" action="<?php echo esc_url( YITH_WCAF_Admin_Actions::get_action_url( 'create_affiliate' ) ); ?>">
			<div class="tabs">
				<div id="add_affiliate" class="tab">
					<div class="form-row form-row-wide required">
						<label for="customer" class="screen-reader-text">
							<?php echo esc_html_x( 'Search user', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
						</label>
						<select class="wc-customer-search" name="customer" id="customer" data-placeholder="<?php echo esc_attr_x( 'Search user', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>" style="width: 100%" ></select>
					</div>
					<div class="form-row form-row-wide submit">
						<button class="submit button-primary">
							<?php echo esc_html_x( 'Add as affiliate', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
						</button>
					</div>
				</div>
				<div id="create_affiliate" class="tab">
					<?php if ( ! current_user_can( 'create_users' ) ) : ?>
						<p>
							<?php echo esc_html_x( 'Sorry, you\'re not allowed to create users', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
						</p>
					<?php else : ?>
						<div class="form-row form-row-wide required">
							<label for="username">
								<?php echo esc_html_x( 'Username', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
							</label>
							<input type="text" name="user_login" id="username"/>
						</div>
						<div class="form-row form-row-wide required" data-pattern="(.+)@(.+)\.(.+)">
							<label for="email">
								<?php echo esc_html_x( 'Email', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
							</label>
							<input type="email" name="email" id="email"/>
						</div>
						<div class="form-row form-row-wide required">
							<label for="role">
								<?php echo esc_html_x( 'Role', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
							</label>
							<select name="role" id="role" class="wc-enhanced-select" style="width: 100%;">
								<?php wp_dropdown_roles( get_option( 'default_role' ) ); ?>
							</select>
						</div>
						<div class="form-row form-row-wide required">
							<label for="password">
								<?php echo esc_html_x( 'Password', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
							</label>
							<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php echo esc_html_x( 'Set new password', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?></button>
							<span class="wp-pwd">
								<?php $initial_password = wp_generate_password( 24 ); ?>
								<span class="password-input-wrapper">
									<input type="password" name="pass1" id="password" autocomplete="off" data-reveal="1" value="<?php echo esc_attr( $initial_password ); ?>" aria-describedby="pass-strength-result" />
								</span>
								<button type="button" class="button button-secondary wp-toggle-pw wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php echo esc_attr_x( 'Hide password', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>">
									<span class="dashicons dashicons-hidden" aria-hidden="true"></span>
									<span class="text"><?php echo esc_html_x( 'Hide', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?></span>
								</button>
								<button type="button" class="button button-secondary wp-toggle-pw wp-show-pw hide-if-no-js" data-toggle="0" aria-label="<?php echo esc_attr_x( 'Show password', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>">
									<span class="dashicons dashicons-visibility" aria-hidden="true"></span>
									<span class="text"><?php echo esc_html_x( 'Show', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?></span>
								</button>
								<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php echo esc_attr_x( 'Cancel password change', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>">
									<span class="dashicons dashicons-no" aria-hidden="true"></span>
									<span class="text"><?php echo esc_html_x( 'Cancel', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?></span>
								</button>
								<input type="hidden" name="use_custom_password" id="use_custom_password" value="0"/>
							</span>
						</div>
						<div class="form-row form-row-wide">
							<label for="send_user_notification" class="inline">
								<input type="checkbox" name="send_user_notification" id="send_user_notification" value="yes"/>
								<?php echo esc_html_x( 'Send email to the user about this account', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
							</label>
						</div>
						<div class="form-row form-row-wide submit">
							<button class="submit button-primary">
								<?php echo esc_html_x( 'Add new user as affiliate', '[ADMIN] Add Affiliate modal', 'yith-woocommerce-affiliates' ); ?>
							</button>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<input type="hidden" id="mode" name="mode" value="add_affiliate"/>
		</form>
	</div>
</script>
