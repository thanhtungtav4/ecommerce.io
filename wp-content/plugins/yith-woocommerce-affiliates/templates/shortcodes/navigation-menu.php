<?php
/**
 * Affiliate Dashboard Menu
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH WooCommerce Affiliates
 * @version 1.0.5
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php if ( $show_right_column ) : ?>
	<div class="right-column <?php echo ( ! $show_left_column ) ? 'full-width' : ''; ?>">
		<div class="yith-wcaf-navigation-menu">
		<?php if ( $show_dashboard_links ) : ?>
			<div class="dashboard-title">
				<h2><?php esc_html_e( 'Menu', 'yith-woocommerce-affiliates' ); ?></h2>
			</div>
			<ul class="dashboard-links">
				<?php
				/**
				 * DO_ACTION: yith_wcaf_before_dashboard_links
				 *
				 * Allows to render some content before the links in the Affiliate Dashboard.
				 *
				 * @param array $dashboard_links Affiliate dashboard links.
				 */
				do_action( 'yith_wcaf_before_dashboard_links', $dashboard_links );
				?>

				<?php if ( ! empty( $dashboard_links ) ) : ?>
					<?php foreach ( $dashboard_links as $item ) : ?>
						<li class="<?php echo $item['active'] ? 'active' : ''; ?>">
							<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php
				/**
				 * DO_ACTION: yith_wcaf_after_dashboard_links
				 *
				 * Allows to render some content after the links in the Affiliate Dashboard.
				 *
				 * @param array $dashboard_links Affiliate dashboard links.
				 */
				do_action( 'yith_wcaf_after_dashboard_links', $dashboard_links );
				?>
			</ul>
		<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
