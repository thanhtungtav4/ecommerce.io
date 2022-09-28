<?php
/**
 * Affiliates list options
 *
 * @author YITH
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * APPLY_FILTERS: yith_wcaf_affiliates_list_settings
 *
 * Filters the options available in the Affiliates List subtab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_affiliates_list_settings',
	array(
		'affiliates-list' => array(
			'affiliates_section_start' => array(
				'type' => 'title',
				'desc' => '',
				'id'   => 'yith_wcaf_affiliates_settings',
			),
			'affiliates_table'         => array(
				'name'                 => _x( 'Affiliates', '[ADMIN] Title for affiliates table, in affiliates tab', 'yith-woocommerce-affiliates' ),
				'type'                 => 'yith-field',
				'yith-type'            => 'list-table',
				'class'                => '',
				'list_table_class'     => 'YITH_WCAF_Affiliates_Admin_Table',
				'list_table_class_dir' => YITH_WCAF_INC . 'admin/admin-tables/class-yith-wcaf-affiliates-table.php',
				'id'                   => 'affiliates',
				'add_new_button'       => _x( 'Add affiliate', '[ADMIN] Add new affiliate button, in affiliates tab', 'yith-woocommerce-affiliates' ),
				'add_new_url'          => '#',
			),
			'affiliates_section_end'   => array(
				'type' => 'sectionend',
				'id'   => 'yith_wcaf_affiliates_settings',
			),
		),
	)
);
