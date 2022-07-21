<?php
/**
 * Dashboard tab
 *
 * @author YITH
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

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
