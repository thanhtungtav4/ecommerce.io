<?php
/**
 * Affiliate Dashboard Summary
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
 * @var $action_args              array
 * @var $atts                     array
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="yith-wcaf-dashboard-summary">

	<?php
	if ( function_exists( 'wc_print_notices' ) ) {
		wc_print_notices();
	}
	?>

	<?php do_action( 'yith_wcaf_before_dashboard_summary', $atts ); ?>
	<?php do_action( 'yith_wcaf_before_dashboard_section', 'summary', $atts ); ?>

	<?php do_action( 'yith_wcaf_dashboard_summary', $atts ); ?>

	<?php do_action( 'yith_wcaf_after_dashboard_section', 'summary', $atts ); ?>
	<?php do_action( 'yith_wcaf_after_dashboard_summary', $atts ); ?>

</div>
