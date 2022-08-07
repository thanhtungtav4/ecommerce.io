<?php
/**
 * Payments options
 *
 * @author  YITH
 * @package YITH\Affiliates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * APPLY_FILTERS: yith_wcaf_payments_settings
 *
 * Filters the options available in the Commissions Payments subtab.
 *
 * @param array $options Array with options
 *
 * @return array
 */
return apply_filters(
	'yith_wcaf_payments_settings',
	array(
		'commissions-payments' => array(
			'payments_section_start' => array(
				'type' => 'title',
				'desc' => '',
				'id'   => 'yith_wcaf_payments_settings',
			),
			'payments_table'         => array(
				'name'                 => __( 'Payments', 'yith-woocommerce-affiliates' ),
				'type'                 => 'yith-field',
				'yith-type'            => 'list-table',
				'class'                => '',
				'list_table_class'     => 'YITH_WCAF_Payments_Admin_Table',
				'list_table_class_dir' => YITH_WCAF_INC . 'admin/admin-tables/class-yith-wcaf-payments-table.php',
				'id'                   => 'payments',
			),
			'payments_section_end'   => array(
				'type' => 'sectionend',
				'id'   => 'yith_wcaf_payments_settings',
			),
		),
	)
);
