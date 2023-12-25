<?php
/*
* Plugin Name: DevVN - Woocommerce Reviews
* Version: 1.4.9
* Requires PHP: 7.2
* Description: Thay đổi giao diện phần đánh giá và thêm phần thảo luận cho chi tiết sản phẩm trong Woocommerce
* Author: Lê Văn Toản
* Author URI: https://levantoan.com/
* Plugin URI: https://levantoan.com/san-pham/devvn-woocommerce-reviews/
* Text Domain: devvn-reviews
* Domain Path: /languages
* WC requires at least: 3.5.4
* WC tested up to: 7.9.0
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !defined( 'DEVVN_REVIEWS_BASENAME' ) )
    define( 'DEVVN_REVIEWS_BASENAME', plugin_basename( __FILE__ ) );

if ( !defined( 'DEVVN_REVIEWS_VERSION_NUM' ) )
    define( 'DEVVN_REVIEWS_VERSION_NUM', '1.4.9' );

if(extension_loaded('ionCube Loader')) {
    $license_file = plugin_dir_path( __FILE__ ) . 'license.php';
    if(file_exists($license_file)){
        include $license_file;
    }
    include 'devvn-woocommerce-reviews-main.php';
}else{
    function devvn_review_admin_notice__error() {
        $class = 'notice notice-alt notice-warning notice-error';
        $title = '<h2 class="notice-title">Chú ý!</h2>';
        $message = __( 'Để Plugin <strong>DevVN Woocommerce Reviews</strong> hoạt động, bắt buộc cần kích hoạt <strong>php extension ionCube</strong>.', 'devvn-reviews' );
        $btn = '<p><a href="https://levantoan.com/huong-dan-kich-hoat-extension-ioncube/" target="_blank" rel="nofollow" class="button-primary">Xem hướng dẫn tại đây</a></a></p>';

        printf( '<div class="%1$s">%2$s<p>%3$s</p>%4$s</div>', esc_attr( $class ), $title, $message, $btn );
    }
    add_action( 'admin_notices', 'devvn_review_admin_notice__error' );
}
