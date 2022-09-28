<?php
/**
 * Affiliate Dashboard Commissions
 *
 * @author YITH
 * @package YITH\Affiliates\Templates
 * @version 1.0.5
 */

/**
 * Template variables:
 *
 * @var $section      string
 * @var $atts         array
 * @var $commissions  YITH_WCAF_Abstract_Objects_Collection
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
do_action( 'yith_wcaf_before_dashboard_section', 'commissions', $atts );
?>

<?php
$table = new YITH_WCAF_Dashboard_Table(
	$commissions,
	array(
		'columns'      => array(
			'id'         => esc_html_x( 'ID', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'created_at' => esc_html_x( 'Date', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'product'    => esc_html_x( 'Product', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'amount'     => esc_html_x( 'Amount', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'rate'       => esc_html_x( 'Rate', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'status'     => '',
		),
		'filters'      => array(
			'status',
			'product',
			'interval',
		),
		'items'        => 'commissions',
		'endpoint'     => 'commissions',
		'singular'     => _x( 'commission', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
		'plural'       => _x( 'commissions', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
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
do_action( 'yith_wcaf_after_dashboard_section', 'commissions', $atts );

