<?php
/**
 * Order Referral MetaBox
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Views
 * @version 1.0.0
 */

/**
 * Template variables:
 *
 * @var $username          string
 * @var $user_email        string
 * @var $order             WC_Order
 * @var $commissions_table YITH_WCAF_Commissions_Admin_Table
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! empty( $referral ) ) :
	$total = $commissions_table->has_items() ? $commissions_table->items->get_total_amount() : 0;
	?>
	<div class="referral-user">
		<div class="referral-avatar">
			<?php echo get_avatar( $referral, 64 ); ?>
		</div>
		<div class="referral-info">
			<h3><a href="<?php echo esc_url( get_edit_user_link( $referral ) ); ?>"><?php echo esc_html( $username ); ?></a></h3>
			<a href="mailto:<?php echo esc_attr( $user_email ); ?>">
				<?php echo esc_html( $user_email ); ?>
			</a>
		</div>
	</div>

	<?php if ( $commissions_table->has_items() ) : ?>
	<div class="referral-commissions">
		<?php $commissions_table->display(); ?>
		<table class="commissions-totals">
			<tfoot class="totals">
			<tr>
				<td class="label" colspan="3"><?php echo esc_html_x( 'Order Total:', '[ADMIN] Order commissions metabox', 'yith-woocommerce-affiliates' ); ?></td>
				<td class="total"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
			</tr>
			<tr>
				<td class="label" colspan="3">
					<?php
					printf(
						'%s <span class="tips" data-tip="%s">[?]</span>:',
						esc_html_x( 'Commissions', '[ADMIN] Order commissions metabox', 'yith-woocommerce-affiliates' ),
						esc_html_x( 'This is the total of commissions credited to referral', '[ADMIN] Order commissions metabox', 'yith-woocommerce-affiliates' )
					);
					?>
				</td>
				<td class="total"><?php echo wp_kses_post( wc_price( $total ) ); ?></td>
			</tr>
			<tr>
				<td class="label" colspan="3"><?php echo esc_html_x( 'Store earnings:', '[ADMIN] Order commissions metabox', 'yith-woocommerce-affiliates' ); ?></td>
				<td class="total"><?php echo wp_kses_post( wc_price( $order->get_total() - $total ) ); ?></td>
			</tr>

			<?php
			/**
			 * DO_ACTION: yith_wcaf_referral_totals_table
			 *
			 * Allows to render some content after the referrals commissions table.
			 *
			 * @param WC_Order $order Order object.
			 */
			do_action( 'yith_wcaf_referral_totals_table', $order );
			?>
			</tfoot>
		</table>
	</div>
	<?php endif; ?>
<?php endif; ?>
