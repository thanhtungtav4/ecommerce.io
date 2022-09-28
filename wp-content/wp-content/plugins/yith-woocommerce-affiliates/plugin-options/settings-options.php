<?php
/**
 * General settings
 *
 * @author  YITH
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * APPLY_FILTERS: yith_wcaf_settings
 *
 * Filters the options available in the General Options tab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_settings',
	array(
		'settings' => array(
			'settings_options' => array(
				'type'     => 'multi_tab',
				'sub-tabs' => array(
					'settings-general'                 => array(
						'title' => _x( 'General Options', '[ADMIN] Affiliate tab title', 'yith-woocommerce-affiliates' ),
					),
					'settings-affiliates-registration' => array(
						'title' => _x( 'Affiliates Registration', '[ADMIN] Affiliate tab title', 'yith-woocommerce-affiliates' ),
					),
					'settings-affiliates-dashboard'    => array(
						'title' => _x( 'Affiliate Dashboard', '[ADMIN] Affiliate tab title', 'yith-woocommerce-affiliates' ),
					),
					'settings-commissions-payments'    => array(
						'title' => _x( 'Commissions & Payments', '[ADMIN] Affiliate tab title', 'yith-woocommerce-affiliates' ),
					),
				),
			),
		),
	)
);
