<?php
/**
 * Affiliate Dashboard
 *
 * @author YITH
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $section string
 * @var $atts    array
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php
$section = $section ?? 'summary';
$atts    = $atts ?? array();
?>

<div class="yith-wcaf yith-wcaf-dashboard woocommerce">
	<?php do_action( 'yith_wcaf_before_dashboard', $section, $atts ); ?>

	<div class="yith-wcaf-section yith-wcaf-dashboard-<?php echo esc_attr( $section ); ?>">
		<?php do_action( 'yith_wcaf_dashboard_content', $section, $atts ); ?>
	</div>

	<?php do_action( 'yith_wcaf_after_dashboard', $section, $atts ); ?>
</div>
