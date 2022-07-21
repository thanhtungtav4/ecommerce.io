<?php
/**
 * Affiliate Title
 *
 * @author YITH
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $section string
 * @var $atts    array
 * @var $title   string
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="dashboard-title">
	<h3><?php echo esc_html( apply_filters( 'yith_wcaf_dashboard_title', $title, $section, $atts ) ); ?></h3>
</div>
