<?php
/**
 * Affiliate Dashboard Summary
 *
 * @author YITH <plugins@yithemes.com>
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

	<?php
	/**
	 * DO_ACTION: yith_wcaf_before_dashboard_summary
	 *
	 * Allows to render some content before the summary in the Affiliate Dashboard.
	 *
	 * @param array $atts Array with section attributes.
	 */
	do_action( 'yith_wcaf_before_dashboard_summary', $atts );
	?>
	<?php
	/**
	 * DO_ACTION: yith_wcaf_before_dashboard_section
	 *
	 * Allows to render some content before the section in the Affiliate Dashboard.
	 *
	 * @param string $section Section.
	 * @param array  $atts    Array with section attributes.
	 */
	do_action( 'yith_wcaf_before_dashboard_section', 'summary', $atts );
	?>

	<?php
	/**
	 * DO_ACTION: yith_wcaf_dashboard_summary
	 *
	 * Allows to output summary content in the Affiliate Dashboard.
	 *
	 * @param array $atts Array with section attributes.
	 */
	do_action( 'yith_wcaf_dashboard_summary', $atts );
	?>

	<?php
	/**
	 * DO_ACTION: yith_wcaf_after_dashboard_section
	 *
	 * Allows to render some content after the section in the Affiliate Dashboard.
	 *
	 * @param string $section Section.
	 * @param array  $atts    Array with section attributes.
	 */
	do_action( 'yith_wcaf_after_dashboard_section', 'summary', $atts );
	?>
	<?php
	/**
	 * DO_ACTION: yith_wcaf_after_dashboard_summary
	 *
	 * Allows to render some content after the summary in the Affiliate Dashboard.
	 *
	 * @param array $atts Array with section attributes.
	 */
	do_action( 'yith_wcaf_after_dashboard_summary', $atts );
	?>

</div>
