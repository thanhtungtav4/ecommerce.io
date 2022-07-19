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
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<button class="button tablinks <?php echo $key == 'description' ? ' active' : '' ?>" onclick="openTab(event, '<?php echo esc_attr( $key ); ?>')"><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></button>
			<?php endforeach; ?>
		</div>
		<div class="c-tab_content">
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="c-tab_item" id="<?php echo esc_attr( $key ); ?>" style="<?php echo esc_attr( $key );  echo $key == 'description' ? 'display: block' : 'display: none' ?>;">
				<?php
					if ( isset( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php do_action( 'woocommerce_product_after_tabs' ); ?>

<?php endif; ?>


