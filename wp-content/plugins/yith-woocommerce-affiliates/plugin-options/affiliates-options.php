<?php
/**
 * Affiliates options
 *
 * @author YITH
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

$list_options = include YITH_WCAF_DIR . 'plugin-options/affiliates/list-options.php';

return apply_filters(
	'yith_wcaf_affiliates_settings',
	array(
		'affiliates' => isset( $list_options['affiliates-list'] ) ? $list_options['affiliates-list'] : array(),
	)
);
