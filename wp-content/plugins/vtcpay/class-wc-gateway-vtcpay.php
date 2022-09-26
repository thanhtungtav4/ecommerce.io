<?php
/*
 * Plugin Name: WooCommerce VTC Gateway
 * Plugin URI: https://vtcpay.vn/
 * Description: Add a payment method to WooCommerce using VTCPAY Gateway.
 * Author: toanld
 * Author URI: https://vtcpay.vn/
 * Version: 2.0
 * Text Domain: woocommerce-gateway-vtcpay
 * Copyright (c) 2018 VTCINTECOM
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

	//Create class after the plugins are loaded
	add_action('plugins_loaded', 'init_gateway_class');
    add_action( 'callback', 'thankyou_custom_payment_redirect');

	//Init payment gateway class
	function init_gateway_class()
	{


		class WC_Gateway_VTCPay extends WC_Payment_Gateway
		{
			var $notify_url;

			/**
			 * Constructor for the gateway.
			 *
			 * @access public
			 * @return \WC_Gateway_VTCPay
			 */
			public function __construct()
			{
				global $woocommerce;

				$this->id = 'vtcpay';
				$this->has_fields = false;
				$this->method_title = __('VTCPAY', 'woocommerce');
				$this->liveurl = 'https://vtcpay.vn/bank-gateway/checkout.html';
				$this->testurl = 'http://alpha1.vtcpay.vn/portalgateway/checkout.html';

				//load the setting
				$this->init_form_fields();
				$this->init_settings();

				//Define user set variables
				$this->title = $this->get_option('title');
				$this->description = $this->get_option('description');
				$this->receiver_acc = $this->get_option('receiver_acc');
				$this->merchant_id = $this->get_option('merchant_id');
				$this->secure_pass = $this->get_option('secure_pass');
				$this->testmode = $this->get_option('testmode');
				$this->Curency_id=$this->get_option('Curency_id');
				$this->language=$this->get_option('language');
		
		
				$this->form_submission_method = false;

				//Action
				add_action('valid-vtcpay-standard-ipn-request', array($this, 'successful_request'));
				add_action('woocommerce_receipt_vtcpay', array($this, 'receipt_page'));
				add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
				add_action('woocommerce_api_wc_gateway_vtcpay', array($this, 'callback'));
				if (!$this->is_valid_for_use()) $this->enabled = false;
				

			}
			function is_valid_for_use()
			{
				if (!in_array(get_woocommerce_currency(), apply_filters('woocommerce_vtcpay_supported_currencies', array('VND', 'VNĐ', 'USD'))))
					return false;
				return true;
			}

			public function admin_options()
			{
				?>
				<h3><?php _e('Thanh toán VTCPay', 'woocommerce'); ?></h3>
				<strong><?php _e('VTCPay giá trị thanh toán đích thực.', 'woocommerce'); ?></strong>
				<?php if ($this->is_valid_for_use()) : ?>

				<table class="form-table">
					<?php
					// Generate the HTML For the settings form.
					$this->generate_settings_html();
					?>
				</table><!--/.form-table-->

			<?php else : ?>
				<div class="inline error"><p>
						<strong><?php _e('Gateway Disabled', 'woocommerce'); ?></strong>: <?php _e('Phương thức thanh toán vtcpay không hỗ trợ loại tiền tệ trên gian hàng của bạn.', 'woocommerce'); ?>
					</p></div>
			<?php
			endif;
			}

			/**
			 * Initialise Gateway Settings Form Fields
			 *
			 * @access public
			 * @return void
			 */
			function init_form_fields()
			{

				$this->form_fields = array(
					'enabled' => array(
						'title' => __('Sử dụng phương thức', 'woocommerce'),
						'type' => 'checkbox',
						'label' => __('Đồng ý', 'woocommerce'),
						'default' => 'yes'
					),
					'title' => array(
						'title' => __('Tiêu đề', 'woocommerce'),
						'type' => 'text',
						'description' => __('Tiêu đề của phương thức thanh toán bạn muốn hiển thị cho người dùng.', 'woocommerce'),
						'default' => __('VTCPay', 'woocommerce'),
						'desc_tip' => true,
					),
					'description' => array(
						'title' => __('Mô tả phương thức thanh toán', 'woocommerce'),
						'type' => 'textarea',
						'description' => __('Mô tả của phương thức thanh toán bạn muốn hiển thị cho người dùng.', 'woocommerce'),
						'default' => __('Thanh toán với VTCPay. Đảm bảo an toàn tuyệt đối cho mọi giao dịch', 'woocommerce')
					),
					'language' => array(
						'title' => __('Ngôn ngữ (language) vi or en', 'woocommerce'),
						'type' => 'text',
						'description' => 'Ngôn ngữ (language)',
						'default' => 'vi',
						'desc_tip' => true,
					),
					'account_config' => array(
						'title' => __('Cấu hình tài khoản', 'woocommerce'),
						'type' => 'title',
						'description' => '',
					),
					'receiver_acc' => array(
						'title' => __('Số điện thoại đăng kí với VTC', 'woocommerce'),
						'type' => 'text',
						'description' => __('Số điện thoại đăng kí với VTC', 'woocommerce'),
						'default' => '',
						'desc_tip' => true,
						
					),
					'merchant_id' => array(
						'title' => __('website id', 'woocommerce'),
						'type' => 'text',
						'description' => __('“Mã website” được VTCPay cấp khi bạn đăng ký tích hợp website.', 'woocommerce'),
						'default' => '',
						'desc_tip' => true,
						
					),
					'secure_pass' => array(
						'title' => __('Mã bảo mật', 'woocommerce'),
						'type' => 'text',
						'description' => __('Mã bảo mật khi bạn đăng ký tích hợp website.', 'woocommerce'),
						'default' => '',
						'desc_tip' => true,
						
					),
					'testmode' => array(
						'title' => __('Testmode', 'woocommerce'),
						'type' => 'checkbox',
						'label' => __('Sử dụng VTCPay kiểm thử', 'woocommerce'),
						'default' => 'yes',
						'description' => 'VTCPay kiểm thử được sử đụng kiểm tra phương thức thanh toán.',
					),
				);

			}

			/**
			 * Process the payment and return the result
			 *
			 * @access public
			 * @param int $order_id
			 * @return array
			 */
			function process_payment($order_id)
			{
				$order = new WC_Order($order_id);
				if (!$this->form_submission_method) {
					$vtcpay_args = $this->get_vtcpay_args($order);
					if ($this->testmode == 'yes'):
						$vtcpay_server = $this->testurl; else :
						$vtcpay_server = $this->liveurl;
					endif;
					$vtcpay_url = $this->createRequestUrl($vtcpay_args, $vtcpay_server);
					return array(
						'result' => 'success',
						'redirect' => $vtcpay_url
					);
				} else {
					return array(
						'result' => 'success',
						'redirect' => add_query_arg('order', $order->id, add_query_arg('key', $order->order_key, get_permalink(woocommerce_get_page_id('pay'))))
					);
				}
			}


			function get_vtcpay_args($order)
			{
				global $woocommerce;
				$order_id = $order->id;
				$vtcpay_args = array(
					'website_id' => strval($this->merchant_id),
					'reference_number' => strval($order_id),
					'receiver_account' => strval($this->receiver_acc),
					'url_return' => strtolower(get_bloginfo('wpurl') . "/?wc-api=WC_Gateway_VTCPay"),
					'bill_to_phone' => strval($order->billing_phone),
					'payment_type' => '',
					'language' => strval($this->language),
				);

				$vtcpay_args['amount'] = $order->order_total;
				if(get_woocommerce_currency()==='VND'||get_woocommerce_currency()==='VNĐ')
				{
					$vtcpay_args['currency'] = 'VND';
				}
				else
				{
					$vtcpay_args['currency'] = 'USD';
				}
				

				return $vtcpay_args;
			}

			/**
			 * Điều hướng tác vụ xử lý cập nhật đơn hàng sau thanh toán hoặc nhận BPN từ VTCPay
			 */
			function callback()
			{
				$url=get_bloginfo('wpurl');
				if (isset($_GET['status']) && !empty($_GET['status'])) {
					
				$amount = @$_GET['amount'];
				$message = @$_GET['message'];
				$payment_type = @$_GET['payment_type'];
				$order_code = @$_GET['reference_number'];
				$status = @$_GET['status'];
				$trans_ref_no = @$_GET['trans_ref_no'];
				$website_id = @$_GET['website_id'];
				$sign = @$_GET['signature'];
				}
				else
				{
					$data=@$_POST['data'];
					$str_id = explode("|", $data);
					$amount = $str_id[0];
					$message = $str_id[1];
					$payment_type = $str_id[2];
					$order_code = $str_id[3];
					$status = $str_id[4];
					$trans_ref_no = $str_id[5];
					$website_id = $str_id[6];
					$sign = @$_POST['signature'];
				}
				
				
		$order = new WC_Order($order_code);
		$check = $this->verifyPaymentUrlLive($amount,$message,$payment_type,$order_code,$status,$trans_ref_no,$website_id,$sign);
		//var_dump($order);
        if($check=='false')
		{
		      $comment_status = 'Thực hiện thanh toán không thành công với đơn hàng'.$order_code.'Sai chữ kí' ;
              $comment_status=$comment_status.'<br/><a href = "'.$url.'">Quay lại</a>';
		}
		else
		{ 
              switch ($status) {
                case 0:
                    $comment_status = 'giao dịch ở trạng thái khởi tạo' . $order_code ;
                    $order->add_order_note(__($comment_status, 'woocommerce'));
                    $order_status='pending-payment';
                    $order->update_status($order_status, sprintf(__('Payment pending: %s', 'woocommerce'), $comment_status));
                    break;
                case 1:
                    $comment_status = ' Thực hiện thanh toán thành công với đơn hàng ' . $order_code . '. Giao dịch hoàn thành.';
                    $order_status='processing';
                    $order->update_status($order_status, sprintf(__('payment success: %s', 'woocommerce'), $comment_status));
                    break;
                case 7:
                    $comment_status = ' giao dịch review ' . $order_code . '. kiểm tra lại giao dịch.';
                    $order_status='on-hold';
                    $order->update_status($order_status, sprintf(__('on hold: %s', 'woocommerce'), $comment_status));
                    break;
                case -9: //Khách hàng tự hủy giao dịch
                    $comment_status = 'Bạn tự hủy giao dịch mã giao dịch:' . $order_code ;
                    $order_status='canceled';
                    $order->update_status($order_status, sprintf(__('canceled: %s', 'woocommerce'), $comment_status));
                    break;
                case -3: //Quản trị VTC hủy giao dịch
                case -1: //Giao dịch thất bại
                    $comment_status = 'Giao dịch thất bại' . $order_code ;
                    $order_status='canceled';
                    $order->update_status($order_status, sprintf(__('canceled: %s', 'woocommerce'), $comment_status));
                    break;
                case -4: //Thẻ/tài khoản không đủ điều kiện giao dịch (Đang bị khóa, chưa đăng ký thanh toán online …)
                    $comment_status = 'Thẻ/tài khoản không đủ điều kiện giao dịch (Đang bị khóa, chưa đăng ký thanh toán online …' ;
                    $order_status='canceled';
                    $order->update_status($order_status, sprintf(__('canceled: %s', 'woocommerce'), $comment_status));
                    break;
                case -5: //Số dư tài khoản khách hàng (Ví VTC Pay, tài khoản ngân hàng) không đủ để thực hiện giao dịch
                    $comment_status = 'Số dư không đủ để thực hiện giao dịch' ;
                    $order_status='canceled';
                    $order->update_status($order_status, sprintf(__('canceled: %s', 'woocommerce'), $comment_status));
                    break;
                case -6: //	Lỗi giao dịch tại VTC
                case -7: //Khách hàng nhập sai thông tin thanh toán ( Sai thông tin tài khoản hoặc sai OTP)
                    $comment_status = 'nhập sai thông tin thanh toán ( Sai thông tin tài khoản hoặc sai OTP)' ;
                    $order_status='canceled';
                    $order->update_status($order_status, sprintf(__('canceled: %s', 'woocommerce'), $comment_status));
                    break;
                case -8: //	Quá hạn mức giao dịch trong ngày
                    $comment_status = 'Quá hạn mức giao dịch trong ngày' ;
                    $order_status='canceled';
                    $order->update_status($order_status, sprintf(__('canceled: %s', 'woocommerce'), $comment_status));
                    break;
                case -22: //Số tiền thanh toán đơn hàng quá nhỏ
                     $comment_status = 'Số tiền thanh toán đơn hàng quá nhỏ' ;
                    $order_status='canceled';
                    $order->update_status($order_status, sprintf(__('canceled: %s', 'woocommerce'), $comment_status));
                    break;
                case -24: //Đơn vị tiền tệ thanh toán đơn hàng không hợp lệ
                case -25: //Tài khoản VTC Pay nhận tiền của Merchant không tồn tại.
                case -28: //Thiếu tham số bắt buộc phải có trong một đơn hàng thanh toán online
                case -29: //Tham số request không hợp lệ
                case -21: //Trùng mã giao dịch, Có thể do xử lý duplicate không tốt nên mạng chậm hoặc khách hàng nhấn F5 bị, hoặc cơ chế sinh mã GD của đối tác không tốt nên sinh bị trùng, đối tác cần kiểm tra lại để biết kết quả cuối cùng của giao dịch này
                case -23: //WebsiteID không tồn tại
                    $comment_status = ' Giao dịch lỗi ' . $order_code ;
                    $order_status='failed';
                    $order->update_status($order_status, sprintf(__('failed: %s', 'woocommerce'), $comment_status));
                    break;
                case -99: //WebsiteID không tồn tại
                    $comment_status = ' lỗi khác tạm giữ tiền ' . $order_code ;
                    $order_status='on-hold';
                    $order->update_status($order_status, sprintf(__('on-hold: %s', 'woocommerce'), $comment_status));
                    break;
                default:
                    //code to be executed if n is different from all labels;
                    $comment_status = ' lỗi khác tạm giữ tiền ' . $order_code ;
                    $order_status='on-hold';
                    $order->update_status($order_status, sprintf(__('on-hold: %s', 'woocommerce'), $comment_status));
                    break;
              }
         }               
        WC()->cart->empty_cart();
        //echo $comment_status;
        echo "<script>alert('".$comment_status."');</script>";
        $suburl='checkout/order-received/'.$order_code.'/?key='.$order->order_key.'';
        wp_redirect( $url."/".$suburl );
		exit();
	}
			
            
			function verifyPaymentUrlLive($amount,$message,$payment_type,$order_code,$status,$trans_ref_no,$website_id,$sign)
			{
				
				// My plaintext
				$secret_key = $this->secure_pass;
				$plaintext = $amount."|".$message."|".$payment_type."|".$order_code."|".$status."|".$trans_ref_no."|".$website_id ."|". $secret_key;
				//print $plaintext;
				// Mã hóa sign
				$verify_secure_code = '';
				$verify_secure_code = strtoupper(hash('sha256', $plaintext));;
				// Xác thực chữ ký của ch? web v?i ch? ký tr? v? t? VTC Pay
				if ($verify_secure_code === $sign) 		return strval($status);
				
				return false;
			}

			private function createRequestUrl($data, $vtcpay_server)
			{
				$params = $data;
				$security=$this->secure_pass;
				//$plaintext = $params['website_id'] . "-" . $params['payment_method'] . "-" . $params['order_code'] . "-" . $params['amount'] . "-" . $params['receiver_acc'] . "-" . "-".$security."-".$params['urlreturn'];
				
				$plaintext =$params['amount']."|".$params['bill_to_phone']."|".$params['currency']."|".$params['language']."|".$params['payment_type']."|". $params['receiver_account']."|".$params['reference_number']."|".$params['url_return']."|".$params['website_id']."|".$security;
				
				//echo $plaintext;
				
				$params['signature']=strtoupper(hash('sha256', $plaintext));
				
				$params['url_return']=urlencode($params['url_return']);
				
				$redirect_url = $vtcpay_server;
				if (strpos($redirect_url, '?') === false) {
					$redirect_url .= '?';
				} else if (substr($redirect_url, strlen($redirect_url) - 1, 1) != '?' && strpos($redirect_url, '&') === false) {
					$redirect_url .= '&';
				}
				
				$params['bill_to_phone']=urlencode($params['bill_to_phone']);
				// Tạo đoạn url chứa tham số
				$url_params = '';
				foreach ($params as $key => $value) {
					if ($url_params == '')
						$url_params .= $key . '=' . ($value);
					else
						$url_params .= '&' . $key . '=' . ($value);
				}
				return $redirect_url . $url_params;
				//return $plaintext;
			}

		}

		class WC_VTCPay extends WC_Gateway_VTCPay
		{
			public function __construct()
			{
				_deprecated_function('WC_VTCPay', '1.4', 'WC_Gateway_VTCPay');
				parent::__construct();
			}
		}

		//Defining class gateway
		function add_gateway_class( $methods ) {
			$methods[] = 'WC_Gateway_VTCPay';
			return $methods;
		}

		add_filter( 'woocommerce_payment_gateways', 'add_gateway_class' );
	}
}