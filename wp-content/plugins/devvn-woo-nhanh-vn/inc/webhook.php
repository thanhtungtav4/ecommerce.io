<?php
/**
 * ListenInventory
 */
add_action('rest_api_init', function () {
    register_rest_route( 'devvn', '/nhanh/inventory',array(
        'methods'  => 'POST',
        'callback' => 'devvn_nhanh_webhook_inventory',
        'permission_callback' => '__return_true'
    ));
});
function devvn_nhanh_webhook_inventory($request_data) {
    $parameters = $request_data->get_params();
    $data = $parameters['data'];
    // error_log(print_r('webhoook: inventory',true));
    // error_log(print_r($data,true));
    // $data = '{"30928312":{"id":"","idNhanh":"30928312","typeId":"1","codeNhanh":"","remain":19,"shipping":0,"damaged":0,"holding":0,"available":20,"warranty":0,"warrantyHolding":0,"depots":{"55608":{"remain":0,"shipping":0,"damaged":0,"holding":0,"warranty":0,"warrantyHolding":0,"available":0},"13757":{"remain":5,"shipping":0,"damaged":0,"holding":0,"warranty":0,"warrantyHolding":0,"available":5},"13755":{"remain":5,"shipping":0,"damaged":0,"holding":0,"warranty":0,"warrantyHolding":0,"available":5},"13758":{"remain":4,"shipping":0,"damaged":0,"holding":0,"warranty":0,"warrantyHolding":0,"available":10},"13756":{"remain":5,"shipping":0,"damaged":0,"holding":0,"warranty":0,"warrantyHolding":0,"available":10}}}}';
    $data = json_decode($data);
    $data = devvn_object_to_array($data);
    if ($data) {
        foreach ($data as $key => $value) {
            devvn_update_inventory($value);
        }
    }
}
/**
 * ListenProductAdd
 */
add_action('rest_api_init', function () {
    register_rest_route( 'devvn', '/nhanh/productadd',array(
        'methods'  => 'POST',
        'callback' => 'devvn_nhanh_webhook_productadd',
        'permission_callback' => '__return_true'
    ));
});
function devvn_nhanh_webhook_productadd($request_data) {
    $parameters = $request_data->get_params();
    $data = $parameters['data'];
    error_log(print_r('webhoook: productadd',true));
    error_log(print_r($data,true));
    // $data = '{"30928312":{"idNhanh":"30928312","parentId":"","merchantCategoryId":null,"merchantProductId":null,"categoryId":null,"brandId":null,"code":"test","name":"G2. TDC ST ives Mo Acne Control xanh duong 170g ( tuyp)","importPrice":"72000","price":"129000","wholesalePrice":"77000","vat":null,"image":"","images":[],"status":"Inactive","commodityStatus ":"New","commoditySource":"Company","previewLink":"\/p30928312\/g2.-tdc-st-ives-mo-acne-control-xanh-duong-170g-tuyp","advantages":null,"description":null,"content":null,"shippingWeight":"192","width":null,"length":null,"height":null,"createdDateTime":"2021-04-17 14:20:13","inventory":{"remain":19,"shipping":0,"damaged":0,"holding":0,"available":19,"depots":{"55608":{"remain":0,"shipping":0,"damaged":0,"holding":0,"available":0},"13757":{"remain":5,"shipping":0,"damaged":0,"holding":0,"available":5},"13755":{"remain":5,"shipping":0,"damaged":0,"holding":0,"available":5},"13758":{"remain":4,"shipping":0,"damaged":0,"holding":0,"available":4},"13756":{"remain":5,"shipping":0,"damaged":0,"holding":0,"available":5}}},"promotionValue":null,"promotionContent":""}}';
    $data = json_decode($data);
    $data = devvn_object_to_array($data);
    if ($data) {
        foreach ($data as $key => $value) {
            devvn_add_product($value, false);
        }
    }
    // return $parameters;
}
/**
 * ListenOrderStatus
 */
add_action('rest_api_init', function () {
    register_rest_route( 'devvn', '/nhanh/orderstatus',array(
        'methods'  => 'POST',
        'callback' => 'devvn_nhanh_webhook_orderstatus',
        'permission_callback' => '__return_true'
    ));
});
function devvn_nhanh_webhook_orderstatus($request_data) {
    $parameters = $request_data->get_params();
    $data = $parameters['data'];
    error_log(print_r('webhoook: orderstatus',true));
    error_log(print_r($data,true));
    // $data = '{"94609721":{"id":"9888","idNhanh":"94609721","carrierId":null,"carrierCode":null,"sendCarrierDateTime":" ","carrierServiceId":null,"type":"Shipping","totalProductMoney":279000,"discount":0,"paymentForSender":279000,"moneyDeposit":0,"moneyTransfer":0,"customerShipFee":0,"shipFee":0,"declaredFee":0,"overWeightShipFee":0,"codFee":0,"returnFee":0,"weight":"40","carrierWeight":"40","status":"CustomerConfirming","reason":"","productList":[{"id":null,"idNhanh":"4653356","price":"279000","quantity":"1","status":"CustomerConfirming"}]}}';
    $data = json_decode($data);
    $data = devvn_object_to_array($data);
    if ($data) {
        foreach ($data as $key => $value) {
            devvn_update_order_status($value);
        }
    }
}