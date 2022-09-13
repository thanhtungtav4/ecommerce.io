<?php 
add_filter( 'woocommerce_product_data_tabs', 'devvn_warranty_product_tab', 10, 1 );
function devvn_warranty_product_tab( $default_tabs ) {
    $default_tabs['custom_tab'] = array(
        'label'   =>  __( 'Bảo hành', 'domain' ),
        'target'  =>  'devvn_warranty_product_tab',
        'priority' => 30,
        'class'   => array()
    );
    return $default_tabs;
}
/**
* Display the custom text field
* @since 1.0.0
*/
function devvn_woo_nhanh_create_custom_field() {
    
    $args = array(
        array(
        'id' => 'importPrice',
        'label' => __( 'Giá nhập', 'devvn' ),
        'class' => 'devvn-custom-field',
        'type' => 'number',
        ),
        array(
        'id' => 'wholesalePrice',
        'label' => __( 'Giá buôn', 'devvn' ),
        'class' => 'devvn-custom-field',
        'type' => 'number',
        'type' => 'number',
        ),
        array(
        'id' => 'barcode',
        'label' => __( 'Barcode', 'devvn' ),
        'class' => 'devvn-custom-field',
        'type' => 'number',
        ),
        array(
            'id' => 'status',
            'label' => __( 'Trạng thái', 'devvn' ),
            'class' => 'devvn-custom-field',
            'desc_tip' => true,
        ),
    );
    foreach ($args as $arg) {
        woocommerce_wp_text_input( $arg );
    }
    
}
add_action( 'woocommerce_product_options_general_product_data', 'devvn_woo_nhanh_create_custom_field' );
function devvn_woo_nhanh_create_custom_field_warranty() {
    ?>
    <div id="devvn_warranty_product_tab" class="panel woocommerce_options_panel hidden">
    <?php
    $args = array(
        array(
            'id' => 'product_warranty',
            'label' => __( 'Thời hạn bảo hành', 'devvn' ),
            'class' => 'devvn-custom-field',
            'desc_tip' => true,
            'description' => __( 'Thời hạn bảo hành của sản phẩm. VD: 24 tháng', 'devvn' ),
        ),
        
    );
    foreach ($args as $arg) {
        woocommerce_wp_text_input( $arg );
    }
    ?>
    </div>
    <?php
}
add_action( 'woocommerce_product_data_panels', 'devvn_woo_nhanh_create_custom_field_warranty' );

function devvn_woo_nhanh_create_custom_stories() {
    $nhanh = new NhanhAPI;
    $stories = $nhanh->get_stories();
    if ($stories['status'] == 'ok') {
        $stories = $stories['data'];
        foreach ($stories as $key => $story) {
            $args = array(
            'id' => sanitize_title($key),
            'label' => __( $story->name, 'devvn' ),
            'class' => 'devvn-custom-field',
            'type' => 'number',
            );
            woocommerce_wp_text_input( $args );
        }
    }else{
        echo "Lỗi không thể lấy danh sách kho hàng từ Nhanh.vn";
    }
}
add_action( 'woocommerce_product_options_inventory_product_data', 'devvn_woo_nhanh_create_custom_stories' );


/**
* Save the custom field
* @since 1.0.0
*/
function devvn_woo_nhanh_save_custom_field( $post_id ) {
    $product = wc_get_product( $post_id );
    $importPrice = isset( $_POST['importPrice'] ) ? $_POST['importPrice'] : '';
    $product->update_meta_data( 'importPrice', sanitize_text_field( $importPrice ) );
    $wholesalePrice = isset( $_POST['wholesalePrice'] ) ? $_POST['wholesalePrice'] : '';
    $product->update_meta_data( 'wholesalePrice', sanitize_text_field( $wholesalePrice ) );
    $barcode = isset( $_POST['barcode'] ) ? $_POST['barcode'] : '';
    $product->update_meta_data( 'barcode', sanitize_text_field( $barcode ) );
    $product_warranty = isset( $_POST['product_warranty'] ) ? $_POST['product_warranty'] : '';
    $product->update_meta_data( 'product_warranty', sanitize_text_field( $product_warranty ) );
    $status = isset( $_POST['status'] ) ? $_POST['status'] : '';
    $product->update_meta_data( 'status', sanitize_text_field( $status ) );
    $product->save();
}
add_action( 'woocommerce_process_product_meta', 'devvn_woo_nhanh_save_custom_field' );

//Product Cat Create page
function devvn_taxonomy_add_new_meta_field() {
    ?>
        
    <div class="form-field">
        <label for="devvn_nhanh_id"><?php _e('Nhanh ID', 'devvn'); ?></label>
        <input type="text" name="devvn_nhanh_id" id="devvn_nhanh_id">
    </div>
    <div class="form-field">
        <label for="devvn_nhanh_code"><?php _e('Mã danh mục', 'devvn'); ?></label>
        <input type="text" name="devvn_nhanh_code" id="devvn_nhanh_code">
    </div>
    <?php
}

//Product Cat Edit page
function devvn_taxonomy_edit_meta_field($term) {

    //getting term ID
    $term_id = $term->term_id;

    // retrieve the existing value(s) for this meta field.
    $devvn_nhanh_id = get_term_meta($term_id, 'devvn_nhanh_id', true);
    $devvn_nhanh_code = get_term_meta($term_id, 'devvn_nhanh_code', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="devvn_nhanh_id"><?php _e('Nhanh ID', 'devvn'); ?></label></th>
        <td>
            <input type="text" name="devvn_nhanh_id" id="devvn_nhanh_id" value="<?php echo esc_attr($devvn_nhanh_id) ? esc_attr($devvn_nhanh_id) : ''; ?>">
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="devvn_nhanh_code"><?php _e('Mã danh mục', 'devvn'); ?></label></th>
        <td>
            <input type="text" name="devvn_nhanh_code" id="devvn_nhanh_code" value="<?php echo esc_attr($devvn_nhanh_code) ? esc_attr($devvn_nhanh_code) : ''; ?>">
        </td>
    </tr>
    <?php
}

add_action('product_cat_add_form_fields', 'devvn_taxonomy_add_new_meta_field', 10, 1);
add_action('product_cat_edit_form_fields', 'devvn_taxonomy_edit_meta_field', 10, 1);

// Save extra taxonomy fields callback function.
function devvn_save_taxonomy_custom_meta($term_id) {
    $devvn_nhanh_id = filter_input(INPUT_POST, 'devvn_nhanh_id');
    $devvn_nhanh_code = filter_input(INPUT_POST, 'devvn_nhanh_code');
    update_term_meta($term_id, 'devvn_nhanh_id', $devvn_nhanh_id);
    update_term_meta($term_id, 'devvn_nhanh_code', $devvn_nhanh_code);
}

add_action('edited_product_cat', 'devvn_save_taxonomy_custom_meta', 10, 1);
add_action('create_product_cat', 'devvn_save_taxonomy_custom_meta', 10, 1);

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'devvn_override_checkout_fields' );

// Our hooked in function – $fields is passed via the filter!
function devvn_override_checkout_fields( $fields ) {
     $fields['billing']['billing_district'] = array(
        'label'     => __('Quận', 'woocommerce'),
        'placeholder'   => _x('Quận', 'placeholder', 'woocommerce'),
        'priority'  => 50,
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => true
     );
     return $fields;
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'devvn_custom_checkout_field_display_admin_order_meta', 10, 1 );
function devvn_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Quận').':</strong> ' . get_post_meta( $order->get_id(), '_billing_district', true ) . '</p>';
}

/**
 * Send order to Nhanh.vn
 */
add_action('woocommerce_thankyou', 'devvn_send_order_to_nhanh', 10, 1);
function devvn_send_order_to_nhanh( $order_id ) {
    if ( ! $order_id )
        return;
    // Allow code execution only once 
    if( ! get_post_meta( $order_id, 'devvn_send_order_action_done', true ) ) {
        // Get an instance of the WC_Order object
        $order = wc_get_order( $order_id );
        // Get the order key
        $order_key = $order->get_order_key();

        // Get the order number
        $order_key = $order->get_order_number();

        if($order->is_paid())
            $paid = __('yes');
        else
            $paid = __('no');

        // Get and Loop Over Order Items
        $product_list = [];
        foreach ( $order->get_items() as $item_id => $product_item ) {
            $product         = $product_item->get_product();
            $product_weight  = $product->get_weight();        
            $quantity        = $product_item->get_quantity();
            $total_qty      += $quantity;
            $total_weight   += floatval( $product_weight * $quantity );
            $product_list[] = array(
                "id" => $product->get_id(),
                "idNhanh" => $product->get_sku(), // use idNhanh if product is synchronized from Nhanh.vn
                "quantity" => $quantity,
                "code" => "",
                "name" => $product_item->get_name(),
                "importPrice" => get_post_meta($product->get_id(), 'importPrice', true),
                "price" => $product_item->get_total(),
                "description" => ''
            );
        }
        $data = array(
            "id" => $order_id,
            "trafficSource" => 'Website API',
            "depotId" => null,
            "status" => "New", // New | Confirmed
            "moneyTransfer" => null,
            "paymentMethod" => $order->get_payment_method(),
            "paymentGateway" => $order->get_payment_method_title(),
            "paymentCode" => $order->get_transaction_id(),
            // "carrierId" => 2, // carrierId get from get/shippingFee.php
            // "carrierServiceId" => 27, // carrierServiceId get from get/shippingFee.php
            // "codFee" => 15000,
            // "shipFeeBy" => "Sender", // Receiver
            // "shipFee" => 21000,
            // "customerShipFee" => 38000,
            // "deliveryDate" => date('Y-m-d'),
            "description" => $order->get_customer_note(),
            "autoSend" => 0,
            "fromName" => $order->get_billing_first_name(),
            "fromEmail" => $order->get_billing_last_name(),
            "fromAddress" => $order->get_billing_address_1(),
            "fromMobile" => $order->get_billing_phone(),
            "fromCityName" => $order->get_billing_city(),
            "fromDistrictName" => get_post_meta( $order->get_id(), '_billing_district', true ),
            "weight" => $total_weight, // in gram
            "width" => null,
            "height" => null,
            "length" => null,
            "createdDateTime" => $order->get_date_created()->date("Y-m-d h:m:s"),
            "customerName" => $order->get_billing_first_name().' '.$order->get_billing_last_name(),
            "customerMobile" => $order->get_billing_phone(),
            "customerEmail" => $order->get_billing_email(),
            "customerCityName" => $order->get_billing_city(),
            "customerDistrictName" => get_post_meta( $order->get_id(), '_billing_district', true ),
            "customerAddress" => $order->get_billing_address_1(),
            // "moneyTransfer" => 12000000,
            "productList" => $product_list
        );
        $nhanh = new NhanhAPI();
        $response = $nhanh->send_order($data);
        if ($response["status"] == 'ok') {
            // array(2) {
            // ["status"]=>
            // string(2) "ok"
            // ["data"]=>
            // object(stdClass)#12708 (3) {
            //     ["9888"]=>
            //     string(8) "94609721"
            //     ["shipFee"]=>
            //     string(0) ""
            //     ["codFee"]=>
            //     string(0) ""
            // }
            // }
            $order->update_meta_data( 'devvn_nhanh_id', $response["data"]->$order_id );
        }
        // if ($response->code) {
        //     echo "<h1>Success!</h1>";
        //     if(isset($response->messages)) {
        //         foreach ($response->messages as $message) {
        //             echo "<p>$message</p>";
        //         }
        //     }
        // } else {
        //     echo "<h1>Failed!</h1>";
        //     echo '<pre>';
        //     var_dump($response);
        //     echo '</pre>';
        //     foreach ($response->messages as $message) {
        //         echo "<p>$message</p>";
        //     }
        // }
        $order->update_status( 'New', '', true );
        $order->update_meta_data( 'devvn_send_order_action_done', true );
        $order->save();
    }
}

/**
 * Custom order status
 */
$status = array(
    "new" => "Đơn mới",
    "confirming" => "Đang xác nhận",
    "customerconfirming" => "Chờ khách xác nhận",
    "confirmed" => "Đã xác nhận",
    "packing" => "Đang đóng gói",
    "packed" => "Đã đóng gói",
    "changedepot" => "Đổi kho xuất hàng",
    "pickup" => "Chờ thu gom",
    "Shipping" => "Đang giao hàng",
    "success" => "Thành công",
    "failed" => "Thất bại",
    "canceled" => "Khách hủy",
    "aborted" => "Hệ thống hủy",
    "carriercanceled" => "Hãng vận chuyển hủy đơn",
    "soldOut" => "Hết hàng",
    "returning" => "Đang chuyển hoàn",
    "returned" => "Đã chuyển hoàn"
);

add_action( 'init', 'devvn_register_my_new_order_statuses' );
function devvn_register_my_new_order_statuses() {
    global $status;
    if ($status) {
        foreach ($status as $status_en => $status_vi) {
            register_post_status( "wc-".$status_en, array(
                'label'                     => _x( $status_vi, 'Order status', 'woocommerce' ),
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( $status_vi.' <span class="count">(%s)</span>', $status_vi.'<span class="count">(%s)</span>', 'woocommerce' )
            ) );
        }
    }
    
}

add_filter( 'wc_order_statuses', 'devvn_new_wc_order_statuses' );
// Register in wc_order_statuses.
function devvn_new_wc_order_statuses( $order_statuses ) {
    global $status;
    // $order_statuses = [];
    if ($status) {
        foreach ($status as $status_en => $status_vi) {
            $order_statuses['wc-'.$status_en] = _x( $status_vi, 'Order status', 'woocommerce' );
        }
    }
    return $order_statuses;
}

/**
 * Show inventory store
 */
add_action('woocommerce_single_product_summary', 'devvn_nhanh_show_store_inventory', 40);
function devvn_nhanh_show_store_inventory(){
    global $product;
    if($product->get_stock_quantity()>0) {
        $stories = get_option('devvn_stories');
        ?>
        <?php if($stories): ?>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center active">
                Cửa hàng đang sẵn hàng
            </li>
            <?php foreach($stories as $key => $story): ?>
            <?php $available = get_post_meta($product->get_id(), $key, true); ?>
            <?php if($available): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo $story["name"];?>
                <span class="badge badge-primary badge-pill"><?php echo $available ?></span>
            </li>
            <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php
    }
}