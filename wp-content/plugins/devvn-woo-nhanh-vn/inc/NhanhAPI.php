<?php
class NhanhAPI{
    public function apiUsername() {
        return get_option('wc_settings_apiUsername',true);
    }
    public function secretKey() {
        return get_option('wc_settings_secretKey',true);
    }
    public function ListenInventory() {
        return get_option('wc_settings_ListenInventory',true);
    }
    public function ListenProductAdd() {
        return get_option('wc_settings_ListenProductAdd',true);
    }
    public function ListenOrderStatus() {
        return get_option('wc_settings_ListenOrderStatus',true);
    }
    public function request_curl($dataString, $endpoint, $storeId = null){
        $checksum = $this->checksum($dataString);
        $postArray = array(
            "version" => "1.0",
            "apiUsername" => $this->apiUsername(),
            "storeId" => $storeId,
            "data" => json_encode($dataString),
            "checksum" => $checksum,
        );

        $curl = curl_init("https://graph.nhanh.vn/".$endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $curlResult = curl_exec($curl);

        if(! curl_error($curl)) {
            // success
            $response = json_decode($curlResult);
        } else {
            // failed, cannot connect nhanh.vn
            $response = new stdClass();
            $response->code = 0;
            $response->messages = array(curl_error($curl));
        }
        curl_close($curl);
        if ($response->code == 1) {
            // send product successfully
            $data['status'] = 'ok';
            $data['data'] = @$response->data;
        } else {
            // failed, show error messages
            $data['status']  = 'error';
            $data['message'] = '';
            if(isset($response->messages) && is_array($response->messages)) {
                foreach($response->messages as $message) {
                    $data['message'] .= $message.'-';
                }
            }
        }
        return $data;
    }
    public function checksum($dataString){
        $secretKey = $this->secretKey();
        $dataString = json_encode($dataString);
        return md5(md5($secretKey . $dataString) . $dataString);
    }
    public function get_products($page = 1){
        // $dataString = ["page" => $page,"icpp" => 50,"name" => 8809297387427];
        $dataString = ["page" => $page,"icpp" => 50,"status" => "New"];
        return $this->request_curl($dataString, 'api/product/search');
    }
    public function get_stories(){
        return $this->request_curl('', 'api/store/depot');
    }
    public function get_categories(){
        return $this->request_curl('', 'api/product/category');
    }
    public function set_webhooks($urls){
        $dataString = [
            "uriListenProductAdd"   => $urls['ListenProductAdd'],
            "uriListenInventory"    => $urls['ListenInventory'],
            "uriListenOrderStatus"  => $urls['ListenOrderStatus']
        ];
        return $this->request_curl($dataString, 'api/store/configwebhooks');
    }
    public function send_order($data){
        return $this->request_curl($data, 'api/order/add');
    }
}
