<?php
/**
 * Affiliate Dashboard - Coupons
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $section      string
 * @var $atts         array
 * @var $coupons      YITH_WCAF_Abstract_Objects_Collection
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
do_action( 'yith_wcaf_before_dashboard_section', 'coupons', $atts );
?>

<?php
$table = new YITH_WCAF_Dashboard_Coupon_Table(
	$coupons,
	array(
		'columns'      => array(
			'code'    => esc_html_x( 'Code', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'type'    => esc_html_x( 'Type', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'amount'  => esc_html_x( 'Amount', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'expires' => esc_html_x( 'Expire', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'info'    => '',
		),
		'items'        => 'coupons',
		'endpoint'     => 'coupons',
		'singular'     => _x( 'coupon', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
		'plural'       => _x( 'coupons', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
		'pagination'   => yith_plugin_fw_is_true( $pagination ),
		'per_page'     => $per_page,
		'count'        => $count,
		'current_page' => $current_page,
		'disable_sort' => true,
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
do_action( 'yith_wcaf_after_dashboard_section', 'coupons', $atts );
