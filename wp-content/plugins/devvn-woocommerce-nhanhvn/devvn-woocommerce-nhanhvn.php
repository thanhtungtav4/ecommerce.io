<?php
/*
* Plugin Name: DevVN - Woocommerce vs Nhanh.vn
* Version: 1.1.6
* Requires PHP: 7.2
* Description: Tính phí vận chuyển, đăng đơn, đồng bộ tồn kho giữa Nhanh.vn vs Woocommerce
* Author: Lê Văn Toản
* Author URI: https://levantoan.com
* Plugin URI: https://levantoan.com/san-pham/plugin-ket-noi-nhanh-vn-vs-woocommerce/
* Text Domain: devvn-woocommerce-nhanhvn
* Domain Path: /languages
* WC requires at least: 3.5.4
* WC tested up to: 8.4.0
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !defined( 'DEVVN_NHANHVN_VERSION_NUM' ) )
    define( 'DEVVN_NHANHVN_VERSION_NUM', '1.1.6' );
if ( !defined( 'DEVVN_NHANHVN_URL' ) )
    define( 'DEVVN_NHANHVN_URL', plugin_dir_url( __FILE__ ) );
if ( !defined( 'DEVVN_NHANHVN_BASENAME' ) )
    define( 'DEVVN_NHANHVN_BASENAME', plugin_basename( __FILE__ ) );
if ( !defined( 'DEVVN_NHANHVN_PLUGIN_DIR' ) )
    define( 'DEVVN_NHANHVN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if ( !defined( 'DEVVN_NHANHVN_TEXTDOMAIN' ) )
    define( 'DEVVN_NHANHVN_TEXTDOMAIN', 'devvn-woocommerce-nhanhvn' );

if(extension_loaded('ionCube Loader')) {
    if(file_exists(plugin_dir_path(__FILE__) . 'license.php')){
        include_once plugin_dir_path(__FILE__) . 'license.php';
    }
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

add_filter('pre_data_shipping_fee','nhanhvn_change_name_city');
add_filter('pre_data_create_order','nhanhvn_change_name_city');
function nhanhvn_change_name_city($data){
    if(isset($data['customerCityName']) && $data['customerCityName']){
        $data['customerCityName'] = nhanhvn_str_replace($data['customerCityName']);
    }
    if(isset($data['customerDistrictName']) && $data['customerDistrictName']){
        $data['customerDistrictName'] = nhanhvn_str_replace($data['customerDistrictName']);
    }
    if(isset($data['customerWardLocationName']) && $data['customerWardLocationName']){
        $data['customerWardLocationName'] = nhanhvn_str_replace($data['customerWardLocationName']);
    }
    if(isset($data['fromCityName']) && $data['fromCityName']){
        $data['fromCityName'] = nhanhvn_str_replace($data['fromCityName']);
    }
    if(isset($data['fromDistrictName']) && $data['fromDistrictName']){
        $data['fromDistrictName'] = nhanhvn_str_replace($data['fromDistrictName']);
    }
    if(isset($data['toCityName']) && $data['toCityName']){
        $data['toCityName'] = nhanhvn_str_replace($data['toCityName']);
    }
    if(isset($data['toDistrictName']) && $data['toDistrictName']){
        $data['toDistrictName'] = nhanhvn_str_replace($data['toDistrictName']);
    }
    return $data;
}

function nhanhvn_str_replace($str){
    $str = str_replace('Đắk Nông','Đắc Nông', $str);
    $str = str_replace('Đắk Lắk','Đắc Lắc', $str);
    $str = str_replace('Huyện Phú Quí','Huyện đảo Phú Quý', $str);
    $str = str_replace("Huyện Cư M'gar",'Huyện Cư Mgar', $str);
    $str = str_replace("Huyện M'Đrắk","Huyện M'Đrăk", $str);
    $str = str_replace('Huyện Đắk Mil','Huyện Đăk Mil', $str);
    $str = str_replace("Huyện Đắk R'Lấp","Huyện Đăk R'Lấp", $str);
    $str = str_replace("Huyện Đắk Song","Huyện Đăk Song", $str);
    $str = str_replace("Huyện Đắk Tô","Huyện Đăk Tô", $str);
    $str = str_replace("Quận Bình Thuỷ","Quận Bình Thủy", $str);
    return apply_filters('devvn_nhanh_str_replace', $str);
}