<?php
/**
 * Affiliates options
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

$list_options = include YITH_WCAF_DIR . 'plugin-options/affiliates/list-options.php';

/**
 * APPLY_FILTERS: yith_wcaf_affiliates_settings
 *
 * Filters the options available in the Affiliates tab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_affiliates_settings',
	array(
		'affiliates' => isset( $list_options['affiliates-list'] ) ? $list_options['affiliates-list'] : array(),
	)
);
