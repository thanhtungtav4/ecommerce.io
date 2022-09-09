<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>
		<div class="c-tab">
			<div class="c-tab_top">
				<button class="button tablinks active" onclick="openTab(event, 'description')">MÔ TẢ</button>
				<button class="button tablinks" onclick="openTab(event, 'parameter')">THÔNG SỐ</button>
				<button class="button tablinks" onclick="openTab(event, 'insurane')">BẢO HÀNH</button>
				<button class="button tablinks" onclick="openTab(event, 'reviews')">REVIEW (24)</button>
			</div>
		<div class="c-tab_content">
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="c-tab_item" id="<?php echo esc_attr( $key ); ?>" style="<?php echo $key == 'description' ? 'display: block' : 'display: none' ?>;">
				<?php
					if ( isset( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
			</div>
			<?php endforeach; ?>
			<div class="c-tab_item" id="parameter" style="display: none;">
					<?php
						if(get_field('thong-so-san-pham')){
							the_field('thong-so-san-pham');
						}
						else{
							the_field('thong_so_san_pham_init', 'option');
						}
					?>
			</div>
			<div class="c-tab_item" id="insurane" style="display: none;">
				<?php the_field('bao_hanh', 'option') ?>
			</div>
		</div>
	</div>
	<?php do_action( 'woocommerce_product_after_tabs' ); ?>

<?php endif; ?>


