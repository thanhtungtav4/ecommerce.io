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
 * APPLY_FILTERS: yith_wcaf_affiliates_dashboard_settings
 *
 * Filters the options available in the Affiliate Dashboard subtab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_affiliates_dashboard_settings',
	array(
		'settings-affiliates-dashboard' => array(

			'affiliate-dashboard-options'           => array(
				'title' => _x( 'Affiliate Dashboard', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'type'  => 'title',
				'id'    => 'yith_wcaf_dashboard',
				'desc'  => '',
			),

			'affiliate-dashboard-location'          => array(
				'title'     => _x( 'Where to show the Affiliate Dashboard', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'desc'      => _x( 'Choose whether to show the Affiliate Dashboard inside a custom page, or inside My Account page.', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'type'      => 'yith-field',
				'yith-type' => 'radio',
				'id'        => 'yith_wcaf_dashboard_location',
				'default'   => 'page',
				'options'   => array(
					'page'       => _x( 'In a specific page using the shortcode', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
					'my-account' => _x( 'In a specific endpoint inside My Account page', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				),
			),

			'affiliate-dashboard-page'              => array(
				'title'     => _x( 'Choose the Affiliate Dashboard page', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'desc'      => _x( 'Use this shortcode <b>[yith_wcaf_affiliate_dashboard]</b> in the page you want to use as dashboard.', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'type'      => 'yith-field',
				'yith-type' => 'ajax-posts',
				'id'        => 'yith_wcaf_dashboard_page_id',
				'data'      => array(
					'placeholder' => _x( 'Search Page', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
					'post_type'   => 'page',
				),
				'deps'      => array(
					'id'    => 'yith_wcaf_dashboard_location',
					'value' => 'page',
				),
			),

			'referral-registration-show-login-form' => array(
				'title'     => _x( 'To guest users in the Affiliate Dashboard show:', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'type'      => 'yith-field',
				'yith-type' => 'radio',
				'desc'      => _x( 'Choose what to show to guest users when they try to access the Affiliate Dashboard.', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_referral_registration_show_login_form',
				'default'   => 'no',
				'options'   => array(
					'no'  => _x( 'The affiliate registration form only', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
					'yes' => _x( 'The affiliate registration form + the login form', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				),
				'deps'      => array(
					'id'    => 'yith_wcaf_dashboard_location',
					'value' => 'page',
				),
			),

			'affiliate-dashboard-share'             => array(
				'name'      => _x( 'Show social share', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'desc'      => _x( 'Enable to show social share of referral URL in Affiliate Dashboard > Link generator section.', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_share',
				'default'   => 'yes',
				'type'      => 'yith-field',
				'yith-type' => 'onoff',
			),

			'affiliate-dashboard-share-on-socials'  => array(
				'name'      => _x( 'Allow affiliates to share on:', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'desc'      => _x( 'Choose which social media share button to enable in the Link generator section.', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_share_socials',
				'type'      => 'yith-field',
				'yith-type' => 'checkbox-array',
				'options'   => array(
					'facebook'  => _x( 'Facebook', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
					'twitter'   => _x( 'Twitter', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
					'pinterest' => _x( 'Pinterest', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
					'whatsapp'  => _x( 'Whatsapp', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
					'email'     => _x( 'Email', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				),
				'default'   => array( 'facebook', 'twitter', 'pinterest', 'whatsapp', 'email' ),
				'deps'      => array(
					'id'    => 'yith_wcaf_share',
					'value' => 'yes',
				),
			),

			'affiliate-dashboard-share-title'       => array(
				'name'      => _x( 'Social title', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'desc'      => _x( 'Enter the title to use in Twitter and Pinterest sharing.', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_socials_title',
				'type'      => 'yith-field',
				'yith-type' => 'text',
				'css'       => 'min-width:300px;',
				// translators: 1. Blog name.
				'default'   => sprintf( _x( 'My Referral URL on %s', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ), get_bloginfo( 'name' ) ),
				'deps'      => array(
					'id'    => 'yith_wcaf_share',
					'value' => 'yes',
				),
			),

			'affiliate-dashboard-share-text'        => array(
				'name'      => _x( 'Social text', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'desc'      => _x( 'Enter the text to use in Twitter, WhatsApp, and Pinterest sharing. Use <b>%referral_url%</b> where you want to show the URL of your affiliate.', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_socials_text',
				'css'       => 'width:100%; height: 75px;',
				'default'   => '%referral_url%',
				'type'      => 'yith-field',
				'yith-type' => 'textarea',
				'deps'      => array(
					'id'    => 'yith_wcaf_share',
					'value' => 'yes',
				),
			),

			'affiliate-dashboard-share-image'       => array(
				'name'      => _x( 'Pinterest image URL', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'desc'      => _x( 'Enter the URL of the image to use in Pinterest sharing.', '[ADMIN] Affiliate dashboard settings page', 'yith-woocommerce-affiliates' ),
				'id'        => 'yith_wcaf_socials_image_url',
				'default'   => '',
				'type'      => 'yith-field',
				'yith-type' => 'text',
				'css'       => 'min-width:300px;',
				'deps'      => array(
					'id'    => 'yith_wcaf_share',
					'value' => 'yes',
				),
			),

			'affiliate-dashboard-options-end'       => array(
				'type' => 'sectionend',
				'id'   => 'yith_wcaf_dashboard',
			),

		),
	)
);
