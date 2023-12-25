<?php
/**
 * Dashboard tab
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * APPLY_FILTERS: yith_wcaf_dashboard_settings
 *
 * Filters the options available in the Dashboard tab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_dashboard_settings',
	array(
		'dashboard' => array(
			'dashboard_tab' => array(
				'type'   => 'custom_tab',
				'action' => 'yith_wcaf_dashboard',
			),
		),
	)
);
