<?php
/**
 * Affiliate Dashboard Summary - Commissions
 *
 * @author YITH
 * @package YITH\Affiliates\Templates
 * @version 2.0.0
 */

/**
 * Template variables:
 *
 * @var $affiliate                YITH_WCAF_Affiliate
 * @var $show_commissions_summary bool
 * @var $number_of_commissions    int
 * @var $show_clicks_summary      bool
 * @var $number_of_clicks         int
 * @var $show_referral_stats      bool
 * @var $clicks                   YITH_WCAF_Clicks_Collection
 * @var $commissions              YITH_WCAF_Commissions_Collection
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly
?>

<!--COMMISSION SUMMARY-->

<?php if ( $show_commissions_summary ) : ?>
	<div class="dashboard-title">
		<h3><?php echo esc_html_x( 'Recent Commissions', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?></h3>

		<?php if ( $commissions->has_next_page() ) : ?>
			<span class="view-all">
				( <a href="<?php echo esc_url( YITH_WCAF_Dashboard()->get_dashboard_url( 'commissions' ) ); ?>"><?php echo esc_html_x( 'View all', '[FRONTEND] Affiliate dashboard', 'yith-woocommerce-affiliates' ); ?></a> )
			</span>
		<?php endif; ?>
	</div>

	<?php
	$table = new YITH_WCAF_Dashboard_Table(
		$commissions,
		array(
			'columns'      => array(
				'created_at' => esc_html_x( 'Date', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
				'product'    => esc_html_x( 'Product', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
				'amount'     => esc_html_x( 'Amount', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
				'status'     => '',
			),
			'items'        => 'commissions',
			'endpoint'     => 'commissions',
			'singular'     => _x( 'commission', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'plural'       => _x( 'commissions', '[FRONTEND] Dashboard table', 'yith-woocommerce-affiliates' ),
			'disable_sort' => true,
		)
	);

	$table->render();
	?>
<?php endif; ?>
