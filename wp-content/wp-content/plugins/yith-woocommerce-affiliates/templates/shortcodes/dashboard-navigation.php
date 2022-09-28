<?php
/**
 * Affiliate Dashboard - Navigation
 *
 * @author YITH
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $show_dashboard_links string
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php
if ( ! yith_plugin_fw_is_true( $show_dashboard_links ) ) {
	return;
}

$current_endpoint = YITH_WCAF_Dashboard::get_current_dashboard_endpoint();
?>

<ul class="yith-wcaf-dashboard-navigation">
	<?php foreach ( YITH_WCAF_Dashboard()->get_dashboard_navigation_menu() as $endpoint => $endpoint_options ) : ?>
		<li class="yith-wcaf-dashboard-navigation-item <?php echo esc_attr( $endpoint ); ?> <?php echo $endpoint_options['active'] ? 'is-active' : ''; ?>">
			<a href="<?php echo esc_attr( $endpoint_options['url'] ); ?>">
				<?php echo esc_html( $endpoint_options['label'] ); ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
