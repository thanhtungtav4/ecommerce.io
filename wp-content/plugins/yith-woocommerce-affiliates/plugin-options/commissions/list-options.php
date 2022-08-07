<?php
/**
 * Commissions list options
 *
 * @author  YITH
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * APPLY_FILTERS: yith_wcaf_commissions_list_settings
 *
 * Filters the options available in the Commissions List subtab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_commissions_list_settings',
	array(
		'commissions-list' => array(
			'commissions_section_start' => array(
				'type' => 'title',
				'desc' => '',
				'id'   => 'yith_wcaf_commissions_settings',
			),
			'commissions_table'         => array(
				'name'                 => __( 'Commissions', 'yith-woocommerce-affiliates' ),
				'type'                 => 'yith-field',
				'yith-type'            => 'list-table',
				'class'                => '',
				'list_table_class'     => 'YITH_WCAF_Commissions_Admin_Table',
				'list_table_class_dir' => YITH_WCAF_INC . 'admin/admin-tables/class-yith-wcaf-commissions-table.php',
				'id'                   => 'commissions',
			),
			'commissions_section_end'   => array(
				'type' => 'sectionend',
				'id'   => 'yith_wcaf_commissions_settings',
			),
		),
	)
);
