<?php
/**
 * Commissions/Payments options
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * APPLY_FILTERS: yith_wcaf_commissions_payments_settings
 *
 * Filters the options available in the Commissions & Payments subtab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_commissions_payments_settings',
	array(
		'settings-commissions-payments' => array(

			'commission-options'             => array(
				'title' => _x( 'Commissions Options', '[ADMIN] Commissions/Payments settings page', 'yith-woocommerce-affiliates' ),
				'type'  => 'title',
				'desc'  => '',
				'id'    => 'yith_wcaf_commission_options',
			),

			'commission-general-rate'        => array(
				'title'             => _x( 'Default commission rate', '[ADMIN] Commissions/Payments settings page', 'yith-woocommerce-affiliates' ),
				'type'              => 'yith-field',
				'class'             => 'rate-field',
				'yith-type'         => 'number',
				'desc'              => _x( 'Enter the default commission rate for all affiliates.', '[ADMIN] Commissions/Payments settings page', 'yith-woocommerce-affiliates' ),
				'id'                => 'yith_wcaf_general_rate',
				'css'               => 'max-width: 50px;',
				'default'           => 0,
				'custom_attributes' => array(
					'min'          => 0,
					'max'          => apply_filters( 'yith_wcaf_max_rate_value', 100 ),
					'step'         => 'any',
					'data-postfix' => '%',
				),
			),

			'commission-avoid-auto-referral' => array(
				'title'     => _x( 'Prevent affiliates auto-commissions', '[ADMIN] Commissions/Payments settings page', 'yith-woocommerce-affiliates' ),
				'type'      => 'yith-field',
				'yith-type' => 'onoff',
				'desc'      => _x( 'Enable to prevent affiliates from getting commissions from their own purchases.', '[ADMIN] Commissions/Payments settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_commission_avoid_auto_referral',
				'default'   => 'yes',
			),

			'commission-exclude-tax'         => array(
				'title'     => _x( 'Exclude taxes from commissions', '[ADMIN] Commissions/Payments settings page', 'yith-woocommerce-affiliates' ),
				'type'      => 'yith-field',
				'yith-type' => 'onoff',
				'desc'      => _x( 'Enable to exclude taxes from referral commissions calculation.', '[ADMIN] Commissions/Payments settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_commission_exclude_tax',
				'default'   => 'yes',
			),

			'commission-exclude-discount'    => array(
				'title'     => _x( 'Exclude discounts from commissions', '[ADMIN] Commissions/Payments settings page', 'yith-woocommerce-affiliates' ),
				'type'      => 'yith-field',
				'yith-type' => 'onoff',
				'desc'      => _x( 'Enable to exclude discounts from referral commissions calculation.', '[ADMIN] Commissions/Payments settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_commission_exclude_discount',
				'default'   => 'yes',
			),

			'commission-options-end'         => array(
				'type' => 'sectionend',
				'id'   => 'yith_wcaf_commission_options',
			),

			'gateways-options'               => array(
				'title' => _x( 'Payment Gateways', '[ADMIN] Title for gateways table, in Commissions/Payments tab', 'yith-woocommerce-affiliates' ),
				'type'  => 'title',
				'desc'  => '',
				'id'    => 'yith_wcaf_gateways_options',
			),

			'gateways-table'                 => array(
				'name'      => _x( 'Payment Gateways', '[ADMIN] Title for gateways table, in Commissions/Payments tab', 'yith-woocommerce-affiliates' ),
				'type'      => 'yith-field',
				'yith-type' => 'custom',
				'action'    => 'yith_wcaf_render_gateways_list_table',
				'class'     => '',
			),

			'gateways-options-end'           => array(
				'type' => 'sectionend',
				'id'   => 'yith_wcaf_gateways_options',
			),
		),
	)
);
