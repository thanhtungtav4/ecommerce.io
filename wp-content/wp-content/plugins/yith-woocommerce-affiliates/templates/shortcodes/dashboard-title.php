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
	<h3>
		<?php
		/**
		 * APPLY_FILTERS: yith_wcaf_dashboard_title
		 *
		 * Filters the section title in the Affiliate Dashboard.
		 *
		 * @param string $title   Title.
		 * @param string $section Section.
		 * @param array  $atts    Array with section attributes.
		 */
		echo esc_html( apply_filters( 'yith_wcaf_dashboard_title', $title, $section, $atts ) );
		?>
	</h3>
</div>
