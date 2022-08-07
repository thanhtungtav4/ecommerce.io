<?php
/**
 * Affiliate Dashboard - Payments
 *
 * @author YITH
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $section      string
 * @var $atts         array
 * @var $payments     YITH_WCAF_Abstract_Objects_Collection
 * @var $pagination   string|bool
 * @var $per_page     int
 * @var $count        int
 * @var $current_page int
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php
/**
 * DO_ACTION: yith_wcaf_before_dashboard_section
 *
 * Allows to render some content before the section in the Affiliate Dashboard.
 *
 * @param string $section Section.
 * @param array  $atts    Array with section attributes.
 */
do_action( 'yith_wcaf_before_dashboard_section', 'payments', $atts );
?>

<?php
$table = new YITH_WCAF_Dashboard_Table(
	$payments,
	array(
		'columns'      => array_merge(
			array(
				'created_at'   => esc_html_x( 'Requested on', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
				'amount'       => esc_html_x( 'Amount', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
				'completed_at' => esc_html_x( 'Paid on', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			),
			function_exists( 'YITH_WCAF_Invoices' ) && YITH_WCAF_Invoices()->are_invoices_required() ? array(
				'invoice' => esc_html_x( 'Invoice', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			) : array(),
			array(
				'status' => '',
			)
		),
		'filters'      => array(
			'status',
			'interval',
		),
		'items'        => 'payments',
		'endpoint'     => 'payments',
		'singular'     => _x( 'payment', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
		'plural'       => _x( 'payments', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
		'pagination'   => yith_plugin_fw_is_true( $pagination ),
		'per_page'     => $per_page,
		'count'        => $count,
		'current_page' => $current_page,
	)
);

$table->render();
?>

<?php
/**
 * DO_ACTION: yith_wcaf_after_dashboard_section
 *
 * Allows to render some content after the section in the Affiliate Dashboard.
 *
 * @param string $section Section.
 * @param array  $atts    Array with section attributes.
 */
do_action( 'yith_wcaf_after_dashboard_section', 'payments', $atts );
