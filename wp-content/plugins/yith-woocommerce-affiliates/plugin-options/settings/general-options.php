<?php
/**
 * General options
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * APPLY_FILTERS: yith_wcaf_general_settings
 *
 * Filters the options available in the General Options subtab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_general_settings',
	array(
		'settings-general' => array_merge(
			array(
				'general-options'      => array(
					'title' => _x( 'General', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'type'  => 'title',
					'desc'  => '',
					'id'    => 'yith_wcaf_general_options',
				),

				'general-referral-var' => array(
					'title'     => _x( 'Query var name', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'type'      => 'yith-field',
					'yith-type' => 'text',
					'desc'      => _x( 'Enter the name of the query var used to store referral tokens in URL', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'id'        => 'yith_wcaf_referral_var_name',
					'css'       => 'min-width: 300px;',
					'default'   => 'ref',
					'desc_tip'  => true,
					'required'  => true,
				),

				'general-options-end'  => array(
					'type' => 'sectionend',
					'id'   => 'yith_wcaf_cookie_options',
				),
			),
			array(
				'cookie-options'                => array(
					'title' => _x( 'Cookie Options', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'type'  => 'title',
					'desc'  => '',
					'id'    => 'yith_wcaf_cookie_options',
				),

				'cookie-referral-name'          => array(
					'title'     => _x( 'Referral cookie name', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'type'      => 'yith-field',
					'yith-type' => 'text',
					'desc'      => _x( 'Enter a name to identify the cookie that will store referral tokens.<br/>This name should be as unique as possible to avoid collision with other plugins.<br/><b>Warning:</b> if you change this setting, all cookies created previously will no longer be valid.', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'id'        => 'yith_wcaf_referral_cookie_name',
					'default'   => 'yith_wcaf_referral_token',
					'required'  => true,
				),

				'cookie-referral-expire-needed' => array(
					'title'     => _x( 'Set an expiration for referral cookies', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'type'      => 'yith-field',
					'yith-type' => 'onoff',
					'desc'      => _x( 'Enable if you want referral cookies to expire after a specific time frame.', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'id'        => 'yith_wcaf_referral_make_cookie_expire',
					'default'   => 'yes',
				),

				'cookie-referral-expiration'    => array(
					'title'             => _x( 'Referral cookies expire after', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'type'              => 'yith-field',
					'yith-type'         => 'custom',
					'action'            => 'yith_wcaf_print_admin_duration_field',
					'id'                => 'yith_wcaf_referral_cookie_expire',
					'default'           => DAY_IN_SECONDS,
					'custom_attributes' => array(
						'min'  => 1,
						'step' => 1,
					),
					'deps'              => array(
						'id'    => 'yith_wcaf_referral_make_cookie_expire',
						'value' => 'yes',
					),
				),

				'cookie-set-via-ajax'           => array(
					'title'     => _x( 'Set cookies via AJAX', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'type'      => 'yith-field',
					'yith-type' => 'onoff',
					'desc'      => _x( 'Enable to execute an AJAX call to set up an affiliate cookie whenever the system finds a referral token in the URL', '[ADMIN] General settings page', 'yith-woocommerce-affiliates' ),
					'id'        => 'yith_wcaf_referral_cookie_ajax_set',
					'default'   => 'no',
				),

				'cookie-options-end'            => array(
					'type' => 'sectionend',
					'id'   => 'yith_wcaf_cookie_options',
				),
			)
		),
	)
);
