<?php
/**
 * General settings
 *
 * @author  YITH <plugins@yithemes.com>
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
						'description' => _x( 'Plugin Configuration Options.', '[ADMIN] General options tab description', 'yith-woocommerce-affiliates' ),
					),
					'settings-affiliates-registration' => array(
						'title' => _x( 'Affiliates Registration', '[ADMIN] Affiliate tab title', 'yith-woocommerce-affiliates' ),
						'description' => _x( 'Manage options for registering new affiliates in your shop.', '[ADMIN] Affiliate registration tab description', 'yith-woocommerce-affiliates' ),
					),
					'settings-affiliates-dashboard'    => array(
						'title' => _x( 'Affiliate Dashboard', '[ADMIN] Affiliate tab title', 'yith-woocommerce-affiliates' ),
						'description' => _x( 'Customize the dashboard with which your affiliates monitor clicks and commissions.', '[ADMIN] Affiliate dashboard tab description', 'yith-woocommerce-affiliates' ),
					),
					'settings-commissions-payments'    => array(
						'title' => _x( 'Commissions & Payments', '[ADMIN] Affiliate tab title', 'yith-woocommerce-affiliates' ),
						'description' => _x( 'Configure commission management and payment.', '[ADMIN] Commissions & Payments tab description', 'yith-woocommerce-affiliates' ),
					),
				),
			),
		),
	)
);
