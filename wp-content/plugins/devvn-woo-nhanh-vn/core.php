<?php
/**
 * Plugin Name: DEVVN WooCommerce Nhanh.vn  
 * Plugin URI: https://www.facebook.com/hoangcoder/
 * Description: This plugin can help sync products, order,.. from Nhanh.vn
 * Version: 1.0
 * Author: Hoang Tran
 * Author URI: https://www.facebook.com/hoangcoder
 * Text Domain: devvn
 * Requires at least: 5.7
 * Requires PHP: 7.3
 *
 */
include_once('inc/NhanhAPI.php');
include_once('inc/functions.php');
include_once('inc/woocommerce-hook.php');
include_once('inc/webhook.php');
class WC_Settings_Nhanh_API {
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
    }

    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_nhanh_api'] = __( 'Nhanh.vn', 'devvn' );
        return $settings_tabs;
    }
}
WC_Settings_Nhanh_API::init();

add_action( 'woocommerce_settings_tabs_settings_tab_nhanh_api', 'nhanh_api_settings_tab' );
function nhanh_api_settings_tab() {
    woocommerce_admin_fields( devvn_nhanh_get_settings() );
}

function devvn_nhanh_get_settings() {
    $settings = array(
        'section_title' => array(
            'name'     => __( 'Cài đặt Nhanh API', 'devvn' ),
            'type'     => 'title',
            'desc'     => '',
            'id'       => 'wc_settings_tab_demo_section_title'
        ),
        'apiUsername' => array(
            'name' => __( 'apiUsername', 'devvn' ),
            'type' => 'text',
            'id'   => 'wc_settings_apiUsername'
        ),
        'secretKey' => array(
            'name' => __( 'secretKey', 'devvn' ),
            'type' => 'text',
            'id'   => 'wc_settings_secretKey'
        ),
        'ListenInventory' => array(
            'name'    => __( 'ListenInventory', 'devvn' ),
            'type'    => 'text',
            'id'      => 'wc_settings_ListenInventory',
            // 'class'   => 'disable',
            'default' => get_bloginfo('url').'/wp-json/devvn/nhanh/inventory/'
        ),
        'ListenProductAdd' => array(
            'name'    => __( 'ListenProductAdd', 'devvn' ),
            'type'    => 'text',
            'id'      => 'wc_settings_ListenProductAdd',
            // 'class'   => 'disable',
            'default' => get_bloginfo('url').'/wp-json/devvn/nhanh/productadd/'
        ),
        'ListenOrderStatus' => array(
            'name'    => __( 'ListenOrderStatus', 'devvn' ),
            'type'    => 'text',
            'id'      => 'wc_settings_ListenOrderStatus',
            // 'class'   => 'disable',
            'default' => get_bloginfo('url').'/wp-json/devvn/nhanh/orderstatus/'
        ),
        'section_end' => array(
             'type' => 'sectionend',
             'id' => 'wc_settings_tab_demo_section_end'
        )
    );
    return apply_filters( 'wc_settings_tab_demo_settings', $settings );
}

add_action( 'woocommerce_update_options_settings_tab_nhanh_api', 'devvn_nhanh_update_settings' );
function devvn_nhanh_update_settings() {
    $nhanh = new NhanhAPI;
    $webhook_urls['ListenInventory']   = $_POST['wc_settings_ListenInventory'];
    $webhook_urls['ListenProductAdd']  = $_POST['wc_settings_ListenProductAdd'];
    $webhook_urls['ListenOrderStatus'] = $_POST['wc_settings_ListenOrderStatus'];
    $nhanh->set_webhooks($webhook_urls);
    woocommerce_update_options( devvn_nhanh_get_settings() );
}
function devvn_enqueue_admin_script( $hook ) {
    wp_enqueue_style('devvn-css', plugins_url('style.css',__FILE__ ));
    wp_enqueue_script( 'devvn-script', plugin_dir_url( __FILE__ ) . 'script.js', array(), '1.0' );
    wp_localize_script( 'devvn-script', 'devvn',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'admin_enqueue_scripts', 'devvn_enqueue_admin_script' );
function devvn_sync_product() {
    add_submenu_page( 'edit.php?post_type=product', 'Đồng bộ sản phẩm', 'Đồng bộ sản phẩm', 'edit_posts', 'devvn-woo-nhanh', 'devvn_nhanh_submenu_page_callback' ); 
}
function devvn_nhanh_submenu_page_callback() {
    if (isset($_GET['view']) && $_GET['view'] == 'log') {
        echo '<h3>DEVVN - Log</h3>';
    }else{
        echo '<h3>DEVVN - Đồng bộ sản phẩm</h3>';
    }
    ?>
    <!-- <div class="">
    <a class="button" href="<?php echo bloginfo('url') ?>/wp-admin/admin.php?page=devvn-woo-nhanh">Đồng bộ sản phẩm</a> <a class="button" href="<?php echo bloginfo('url') ?>/wp-admin/admin.php?page=devvn-woo-nhanh&view=log">Log</a>
    </div> -->
    <div class="sync-button">
        <button class="button button-primary button-large" action="nhanh-woo">Đồng bộ tất cả sản phẩm từ Nhanh.vn</button>
    </div>
    <div class="sync-response">
        <div class="pages">Trang <span class="current-page"></span>/<span class="total-page"></span></div>
        <div class="products">Sản phẩm <span class="current-product"></span>/<span class="total-products"></span></div>
        <div class="import-processing"><div class="import-done"></div></div>
        <div class="import-log"></div>
    </div>
    <?php
}
add_action('admin_menu', 'devvn_sync_product',99);