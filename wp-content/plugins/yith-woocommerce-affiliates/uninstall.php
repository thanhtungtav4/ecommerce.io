<?php
/**
 * Uninstall plugin
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

// If uninstall not called from WordPress exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

if ( defined( 'YITH_WCAF_REMOVE_ALL_DATA' ) && true === YITH_WCAF_REMOVE_ALL_DATA && ! defined( 'YITH_WCAF_PREMIUM' ) ) {
	// remove role.
	$affiliate_role = YITH_WCAF_Affiliates()->get_role();
	$affiliates     = get_users( array( 'role' => $affiliate_role ) );

	if ( ! empty( $affiliates ) ) {
		foreach ( $affiliates as $affiliate ) {
			/**
			 * Each of affiliate users.
			 *
			 * @var $affiliate \WP_User
			 */
			$affiliate->remove_role( $affiliate_role );
		}
	}

	// delete pages created for this plugin.
	wp_delete_post( get_option( 'yith_wcaf_dashboard_page_id' ), true );

	// phpcs:disable WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL

	// remove plugins options.
	$sql = 'DELETE FROM `' . $wpdb->options . "` WHERE option_name LIKE 'yith_wcaf%'";
	$wpdb->query( $sql );

	// remove plugins post meta.
	$sql = 'DELETE FROM `' . $wpdb->postmeta . "` WHERE meta_key LIKE 'yith_wcaf%'";
	$wpdb->query( $sql );

	// remove plugins user meta.
	$sql = 'DELETE FROM `' . $wpdb->usermeta . "` WHERE meta_key LIKE 'yith_wcaf%'";
	$wpdb->query( $sql );

	// remove custom tables.
	$sql = 'DROP TABLE `' . $wpdb->yith_affiliates . '`';
	$wpdb->query( $sql );
	$sql = 'DROP TABLE `' . $wpdb->yith_commissions . '`';
	$wpdb->query( $sql );
	$sql = 'DROP TABLE `' . $wpdb->yith_commission_notes . '`';
	$wpdb->query( $sql );
	$sql = 'DROP TABLE `' . $wpdb->yith_clicks . '`';
	$wpdb->query( $sql );
	$sql = 'DROP TABLE `' . $wpdb->yith_payments . '`';
	$wpdb->query( $sql );
	$sql = 'DROP TABLE `' . $wpdb->yith_payment_commission . '`';
	$wpdb->query( $sql );
	$sql = 'DROP TABLE `' . $wpdb->yith_payment_notes . '`';
	$wpdb->query( $sql );
	$sql = 'DROP TABLE `' . $wpdb->yith_rate_rules . '`';
	$wpdb->query( $sql );
	$sql = 'DROP TABLE `' . $wpdb->yith_rate_rulemeta . '`';
	$wpdb->query( $sql );

	// phpcs:enable WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL
}
