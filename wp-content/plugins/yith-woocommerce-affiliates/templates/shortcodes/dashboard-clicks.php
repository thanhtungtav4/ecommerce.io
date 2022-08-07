<?php
/**
 * Affiliate Dashboard - Clicks
 *
 * @author YITH
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Template variables:
 *
 * @var $section      string
 * @var $atts         array
 * @var $clicks       YITH_WCAF_Abstract_Objects_Collection
 * @var $pagination   string|bool
 * @var $per_page     int
 * @var $count        int
 * @var $current_page int
 */
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
do_action( 'yith_wcaf_before_dashboard_section', 'clicks', $atts );
?>

<?php
$table = new YITH_WCAF_Dashboard_Table(
	$clicks,
	array(
		'columns'      => array(
			'click_date'  => esc_html_x( 'Date', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'link'        => esc_html_x( 'Link', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'origin_base' => esc_html_x( 'Origin', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'status'      => '',
		),
		'filters'      => array(
			'status',
			'interval',
		),
		'items'        => 'clicks',
		'endpoint'     => 'clicks',
		'singular'     => _x( 'visit', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
		'plural'       => _x( 'visits', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
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
do_action( 'yith_wcaf_after_dashboard_section', 'clicks', $atts );
