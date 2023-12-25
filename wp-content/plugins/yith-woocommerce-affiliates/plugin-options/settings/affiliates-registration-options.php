<?php
/**
 * Registration options
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * APPLY_FILTERS: yith_wcaf_affiliates_registration_settings
 *
 * Filters the options available in the Affiliates Registration subtab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_affiliates_registration_settings',
	array(
		'settings-affiliates-registration' => array(

			'referral-registration-fields'            => array(
				'title' => _x(
					'Registration form',
					'[ADMIN] Affiliate registration settings page',
					'yith-woocommerce-affiliates'
				),
				'type'  => 'title',
				'id'    => 'yith_wcaf_referral_registration_fields',
				'desc'  => _x(
					'To show this form in a custom page, use the Gutenberg block "YITH Affiliates registration form" or copy and paste the shortcode <b>[yith_wcaf_registration_form]</b>',
					'[ADMIN] Affiliate registration settings page',
					'yith-woocommerce-affiliates'
				),
			),

			'referral-registration-fields-table'      => array(
				'type'      => 'yith-field',
				'yith-type' => 'custom',
				'action'    => 'yith_wcaf_print_profile_fields_list_tab',
				'class'     => '',
			),

			'referral-registration-use-wc-form'       => array(
				'title'     => _x( 'Add the registration form fields to the default WooCommerce registration form', '[ADMIN] Affiliate registration settings page', 'yith-woocommerce-affiliates' ),
				'type'      => 'yith-field',
				'yith-type' => 'onoff',
				'desc'      => _x(
					'Enable to add the registration form fields to WooCommerce default registration form.<br>
					You can enable this option if you want all users that create a profile on your site using the default WooCommerce registration form to also be registered as affiliates.',
					'[ADMIN] Affiliate registration settings page',
					'yith-woocommerce-affiliates'
				),
				'id'        => 'yith_wcaf_referral_registration_use_wc_form',
			),

			'referral-registration-fields-end'        => array(
				'type' => 'sectionend',
				'id'   => 'yith_wcaf_referral_registration_fields',
			),


			'referral-registration-extra-options'     => array(
				'title' => _x( 'Registration Options', '[ADMIN] Affiliate registration settings page', 'yith-woocommerce-affiliates' ),
				'type'  => 'title',
				'id'    => 'yith_wcaf_referral_registration_extra',
			),

			'referral-registration-process-orphan-commissions' => array(
				'title'     => _x( 'Associate old commissions to new users with the same token', '[ADMIN] Affiliate registration settings page', 'yith-woocommerce-affiliates' ),
				'type'      => 'yith-field',
				'yith-type' => 'onoff',
				'desc'      => _x( 'If enabled, when a new affiliate is registered the system will check if there\'s any preexisting commission for that default token.<br/>If there is, it will be assigned to the user automatically.', '[ADMIN] Affiliate registration settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_referral_registration_process_orphan_commissions',
				'default'   => 'no',
			),

			'referral-registration-extra-options-end' => array(
				'type' => 'sectionend',
				'id'   => 'yith_wcaf_referral_registration_extra',
			),

		),
	)
);
