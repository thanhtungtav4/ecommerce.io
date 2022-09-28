<?php
/*
* Plugin Name: DevVN - Woocommerce vs Nhanh.vn
* Version: 1.0.2
* Requires PHP: 7.2
* Description: Tính phí vận chuyển, đăng đơn, đồng bộ tồn kho giữa Nhanh.vn vs Woocommerce
* Author: Lê Văn Toản
* Author URI: https://levantoan.com
* Plugin URI: https://levantoan.com/san-pham/plugin-ket-noi-nhanh-vn-vs-woocommerce/
* Text Domain: devvn-woocommerce-nhanhvn
* Domain Path: /languages
* WC requires at least: 3.5.4
* WC tested up to: 6.8.1
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !defined( 'DEVVN_NHANHVN_VERSION_NUM' ) )
    define( 'DEVVN_NHANHVN_VERSION_NUM', '1.0.2' );
if ( !defined( 'DEVVN_NHANHVN_URL' ) )
    define( 'DEVVN_NHANHVN_URL', plugin_dir_url( __FILE__ ) );
if ( !defined( 'DEVVN_NHANHVN_BASENAME' ) )
    define( 'DEVVN_NHANHVN_BASENAME', plugin_basename( __FILE__ ) );
if ( !defined( 'DEVVN_NHANHVN_PLUGIN_DIR' ) )
    define( 'DEVVN_NHANHVN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if ( !defined( 'DEVVN_NHANHVN_TEXTDOMAIN' ) )
    define( 'DEVVN_NHANHVN_TEXTDOMAIN', 'devvn-woocommerce-nhanhvn' );

if(extension_loaded('ionCube Loader')) {
    include 'includes/main.php';
}else{
    function devvn_nhanhvn_admin_notice__error() {
        $class = 'notice notice-alt notice-warning notice-error';
        $title = '<h2 class="notice-title">Chú ý!</h2>';
        $message = __( 'Để Plugin <strong>DevVN - Woocommerce vs Nhanh.vn</strong> hoạt động, bắt buộc cần kích hoạt <strong>php extension ionCube</strong>.', DEVVN_NHANHVN_TEXTDOMAIN );
        $btn = '<p><a href="https://levantoan.com/huong-dan-kich-hoat-extension-ioncube/" target="_blank" rel="nofollow" class="button-primary">Xem hướng dẫn tại đây</a></a></p>';

        printf( '<div class="%1$s">%2$s<p>%3$s</p>%4$s</div>', esc_attr( $class ), $title, $message, $btn );
    }
    add_action( 'admin_notices', 'devvn_nhanhvn_admin_notice__error' );
}