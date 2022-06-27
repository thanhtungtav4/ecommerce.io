<?php
    defined( 'ABSPATH' ) or die( 'Keep Quit' );
?>

<h2><?php esc_html_e( 'Swatches Group', 'woo-variation-swatches' ); ?></h2>

<div class="woo-variation-swatches-group-section-wrapper">

    <div class="woocommerce-BlankState woocommerce-BlankState--swatches-group">
        <h2 class="woocommerce-BlankState-message">
            <?php esc_html_e( 'Show your swatches individually or in groups. Split variation swatches into group to make it much more user friendly.', 'woo-variation-swatches' ); ?>
        </h2>
        <a class="woocommerce-BlankState-cta button-primary button" target="_blank" href="<?php echo esc_url( woo_variation_swatches()->get_backend()->get_pro_link() ) ?>">
            <?php esc_html_e( 'Ok, I need this feature', 'woo-variation-swatches' ); ?>
        </a>
    </div>
</div>
