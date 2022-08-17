<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="l-container">
	<div class="woocommerce-order">

		<?php
		if ( $order ) :

			do_action( 'woocommerce_before_thankyou', $order->get_id() );
			?>

			<?php if ( $order->has_status( 'failed' ) ) : ?>

				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
					<?php endif; ?>
				</p>

			<?php else : ?>

				<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
					<svg width="166" height="168" viewBox="0 0 166 168" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_950_12301)">
						<path d="M55.368 144.91C49.0066 144.91 43.8379 150.085 43.8379 156.455C43.8379 162.825 49.0066 168 55.368 168C61.7295 168 66.8981 162.825 66.8981 156.455C66.5005 150.085 61.3319 144.91 55.368 144.91ZM113.019 144.91C106.657 144.91 101.488 150.085 101.488 156.455C101.488 162.825 106.657 168 113.019 168C119.38 168 124.549 162.825 124.549 156.455C124.151 150.085 118.982 144.91 113.019 144.91Z" fill="#EB6A6A"/>
						<path d="M54.1747 111.071H126.536C130.114 111.071 133.295 108.682 134.488 105.1L145.223 59.3176C143.235 59.7157 140.849 60.1138 138.861 60.1138C126.536 60.1138 115.801 53.346 110.235 43.7915H37.8735L34.6928 30.654C33.5 25.4787 29.1265 21.8958 23.9578 21.8958H7.65663C3.68072 21.8958 0.5 25.0806 0.5 28.6635C0.5 32.6446 3.68072 35.8294 7.65663 35.8294H21.5723L40.259 108.284L32.7048 125.403C31.9096 127.393 31.9096 130.18 33.5 132.171C34.6928 134.161 37.0783 135.355 39.4639 135.355H126.934C130.91 135.355 134.09 132.171 134.09 128.19C134.09 124.209 130.91 121.024 126.934 121.024H49.8012L54.1747 111.071C54.1747 111.469 54.1747 111.469 54.1747 111.071ZM108.645 67.2796C108.645 64.4929 111.03 62.1043 113.813 62.1043C116.596 62.1043 118.982 64.4929 118.982 67.2796V87.583C118.982 90.3697 116.596 92.7583 113.813 92.7583C111.03 92.7583 108.645 90.3697 108.645 87.583V67.2796ZM84.7892 67.2796C84.7892 64.4929 87.1747 62.1043 89.9578 62.1043C92.741 62.1043 95.1265 64.4929 95.1265 67.2796V87.583C95.1265 90.3697 92.741 92.7583 89.9578 92.7583C87.1747 92.7583 84.7892 90.3697 84.7892 87.583V67.2796ZM60.9337 67.2796C60.9337 64.4929 63.3193 62.1043 66.1024 62.1043C68.8855 62.1043 71.2711 64.4929 71.2711 67.2796V87.583C71.2711 90.3697 68.8855 92.7583 66.1024 92.7583C63.3193 92.7583 60.9337 90.3697 60.9337 87.583V67.2796Z" fill="#EB6A6A"/>
						<path d="M138.464 0C123.355 0 111.428 11.9431 111.428 27.0711C111.428 33.4408 113.416 39.0142 116.994 43.3934C121.765 49.763 129.717 53.7441 138.464 53.7441C141.247 53.7441 144.03 53.346 146.416 52.5498C157.548 48.9668 165.5 39.0142 165.5 26.673C165.5 11.9431 153.175 0 138.464 0ZM155.163 21.0995L135.283 41.0047C134.886 41.4028 134.09 41.8009 133.295 41.8009C132.5 41.8009 131.705 41.4028 131.307 41.0047L121.367 31.0521C120.175 29.8578 120.175 27.8673 121.367 26.673C122.56 25.4787 124.548 25.4787 125.741 26.673L133.295 34.237L146.813 20.7014L151.187 16.3223C152.38 15.128 154.367 15.128 155.56 16.3223C156.355 17.9147 156.355 19.9052 155.163 21.0995Z" fill="#EB6A6A"/>
						</g>
						<defs>
						<clipPath id="clip0_950_12301">
						<rect width="165" height="168" fill="white" transform="translate(0.5)"/>
						</clipPath>
						</defs>
					</svg>
					</br>
					<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<p class="woocommerce_thankyou_noti">
					"Cảm ơn bạn đã mua hàng tại <strong>caraslens.com!</strong> CARAS sẽ gọi điện xác nhận đơn hàng của bạn trước khi giao trong thời gian sớm nhất. Vui lòng đợi CARAS một chút nhé!
						</br>
						</br>
					Nếu bạn có thắc mắc, xin vui lòng liên hệ với CARAS qua <strong>Hotline: 1900 63 63 04</strong> hoặc <strong> Email: cskhcaras@caraslens.com</strong> để được hỗ trợ nhanh chóng."
					</p>
					<p class="woocommerce_thankyou_code">
							Mã đơn hàng của bạn:<strong>&nbsp;&nbsp;<?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</p>
					<div class="woocommerce_thankyou_reg">
						<div class="woocommerce_thankyou_reg_inner">
							<p>Đăng kí tài khoản CARASLENS để theo dõi đơn hàng dễ dàng hơn</p>
							<p><smail>Đăng kí tài khoản bằng email: <?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></smail></p>
						</div>
						<a href="#">Đăng kí tài khoản</a>
					</div>
				<!-- <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

					<li class="woocommerce-order-overview__order order">
						<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>

					<li class="woocommerce-order-overview__date date">
						<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
						<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>

					<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
						<li class="woocommerce-order-overview__email email">
							<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
							<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
						</li>
					<?php endif; ?>

					<li class="woocommerce-order-overview__total total">
						<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>

					<?php if ( $order->get_payment_method_title() ) : ?>
						<li class="woocommerce-order-overview__payment-method method">
							<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
							<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
						</li>
					<?php endif; ?>

				</ul> -->

			<?php endif; ?>
				<div class="woocommerce_thankyou_detail">
						<div class="woocommerce_thankyou_detail_inner">
							<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
						</div>
					</div>
			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>


		<?php else : ?>

			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

		<?php endif; ?>
			<a class="go-home"href=""  >TRANG CHỦ </a>
	</div>
</div>