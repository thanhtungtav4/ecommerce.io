<?php
/**
 * Affiliate Dashboard Summary - Stats
 *
 * @author YITH
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $affiliate                YITH_WCAF_Affiliate
 * @var $show_commissions_summary bool
 * @var $number_of_commissions    int
 * @var $show_clicks_summary      bool
 * @var $number_of_clicks         int
 * @var $show_referral_stats      bool
 * @var $clicks                   YITH_WCAF_Clicks_Collection
 * @var $commissions              YITH_WCAF_Commissions_Collection
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<!--AFFILIATE STATS-->

<div class="affiliate-stats">
	<div class="stat-box">
		<div class="stat-item large">
				<span class="stat-label">
					<?php echo esc_html_x( 'Total earnings', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?>
				</span>
			<span class="stat-value">
					<?php echo wp_kses_post( wc_price( $affiliate->get_earnings() ) ); ?>
				</span>
		</div>
		<div class="stat-item">
				<span class="stat-label">
					<?php echo esc_html_x( 'Total paid', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?>
				</span>
			<span class="stat-value">
					<?php echo wp_kses_post( wc_price( $affiliate->get_paid() ) ); ?>
				</span>
		</div>
		<div class="stat-item">
				<span class="stat-label">
					<?php echo esc_html_x( 'Total refunded', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?>
				</span>
			<span class="stat-value">
					<?php echo wp_kses_post( wc_price( $affiliate->get_refunds() ) ); ?>
				</span>
		</div>
		<div class="stat-item">
				<span class="stat-label">
					<?php echo esc_html_x( 'Balance', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?>
				</span>
			<span class="stat-value">
					<?php echo wp_kses_post( wc_price( $affiliate->get_balance() ) ); ?>
				</span>
		</div>
	</div>

	<div class="stat-box">
		<div class="stat-item large">
				<span class="stat-label">
					<?php echo esc_html_x( 'Commission rate', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?>
				</span>
			<span class="stat-value">
					<?php echo esc_html( yith_wcaf_get_formatted_rate( $affiliate ) ); ?>
				</span>
		</div>
		<div class="stat-item large">
				<span class="stat-label">
					<?php echo esc_html_x( 'Conversion rate', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?>
				</span>
			<span class="stat-value">
					<?php echo esc_html( yith_wcaf_rate_format( $affiliate->get_conversion_rate() ) ); ?>
				</span>
		</div>
	</div>

	<?php if ( $show_clicks_summary ) : ?>
		<div class="stat-box">
			<div class="stat-item large">
					<span class="stat-label">
						<?php echo esc_html_x( 'Visits', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?>
					</span>
				<span class="stat-value">
						<?php echo esc_html( yith_wcaf_number_format( $affiliate->get_clicks_count() ) ); ?>
					</span>
			</div>
			<div class="stat-item large">
					<span class="stat-label">
						<?php echo esc_html_x( 'Visits today', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?>
					</span>
				<span class="stat-value">
						<?php echo esc_html( yith_wcaf_number_format( $affiliate->count_clicks( array( 'interval' => array( 'start_date' => gmdate( 'Y-m-d 00:00:00' ) ) ) ) ) ); ?>
					</span>
			</div>
		</div>
	<?php endif; ?>
</div>
