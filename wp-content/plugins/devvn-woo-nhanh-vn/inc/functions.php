<?php
if (!function_exists('get_products')) {
    function get_products(){
        $page = $_POST['page'];
        $nhanh = new NhanhAPI();
        $data = $nhanh->get_products($page);
        echo json_encode($data);
        wp_die();
    }
    add_action('wp_ajax_get_products', 'get_products');
    add_action('wp_ajax_nopriv_get_products', 'get_products');
}

if(!function_exists('devvn_update_inventory')){
    function devvn_update_inventory($data){
        $product_id = devvn_get_product_by_sku($data['idNhanh']);
        if ($product_id) {
            $product_id = $product_id->get_id();
            $product = wc_get_product($product_id);
            $product->set_stock_quantity($data['available']);
            $product->set_backorders('yes'); // 'yes', 'no' or 'notify'
            $stories = $data['depots'];
            if ($stories) {
                foreach ($stories as $key => $story) {
                    // error_log(print_r("Updated product inventory ID:$key - ".$product_id,true));
                    update_post_meta($product_id, $key, $story['available']);
                }
            }
            $product->save();
        }
    }
}

if(!function_exists('devvn_update_order_status')){
    function devvn_update_order_status($data){
        $order_id = devvn_get_oder_id($data['idNhanh']);
        if ($order_id) {
            // error_log(print_r("order_id: ".$order_id,true));
            $order = wc_get_order( $order_id );
            $order->update_status( strtolower($data['status']), 'Update from Nhanh API', true );
            $order->save();
        }
    }
}

if(!function_exists('devvn_add_product')){
    function devvn_add_product($data, $ajax = true){
        if ($ajax == true) {
            $data = $_POST['data'];
        }
        $data = (OBJECT)$data;
        $product_id = devvn_get_product_by_sku(@$data->idNhanh);
        if ($product_id) {
            $status = "<span class='update'>[devvn_status]</span> ";
            $product_id = $product_id->get_id();
            $product = wc_get_product($product_id);
        }else{
            $status = "<span class='added'>[devvn_status]</span> ";
            $product = new WC_Product();
        }
        ($data->otherName) ? $productName = $data->otherName : $productName = $data->name;
        $product->set_name($productName);
        $product->update_meta_data( 'status', sanitize_text_field(@$data->status) );
        $set_status = 'publish';
        $nhanh = new NhanhAPI;
        update_option('devvn_stories', devvn_object_to_array($nhanh->get_stories()['data']));
        if (@$data->status == "Inactive") {
            $set_status = "trash";
        }else{
            $product->set_description(@$data->content);
            $product->set_short_description(@$data->description);
            $product->set_price(@$data->price); // set product price
            $product->set_regular_price(@$data->price); // set product regular price
            $product->set_manage_stock(true); // true or false
            $product->set_stock_quantity(@$data->inventory['available']);
            $product->set_weight(@$data->shippingWeight);
            $product->set_width(@$data->width);
            $product->set_length(@$data->length);
            $product->set_height(@$data->height);
            $product->set_stock_status('instock'); // in stock or out of stock value
            $product->set_backorders('yes'); // 'yes', 'no' or 'notify'
            $stories = @$data->inventory['depots'];
            if ($stories) {
                foreach ($stories as $key => $story) {
                    $product->update_meta_data( $key, $story['available'] );
                }
            }
            $product->update_meta_data( 'importPrice', sanitize_text_field(@$data->importPrice) );
            $product->update_meta_data( 'wholesalePrice', sanitize_text_field(@$data->wholesalePrice) );
            $product->update_meta_data( 'barcode', sanitize_text_field(@$data->barcode) );
            $product->update_meta_data( 'product_warranty', sanitize_text_field(@$data->warranty) );
            if (@$data->categoryId) {
                $categories = $nhanh->get_categories();
                if ($categories['data']) {
                    foreach ($categories['data'] as $category) {
                        $exist_id = devvn_get_term_id($category->id);
                        if ($exist_id) {
                            $product_wp_cat_id = $exist_id;
                        }else{
                            $cid = wp_insert_term(
                                $category->name, // the term 
                                'product_cat' // the taxonomy
                            );
                            $product_wp_cat_id = $cid['term_id'];
                        }
                        update_term_meta($product_wp_cat_id,'devvn_nhanh_id',$category->id);
                        update_term_meta($product_wp_cat_id,'devvn_nhanh_code',$category->code);
                        if ($category->id === @$data->categoryId) {
                            break;
                        }else{
                            if (@$category->childs) {
                                devvn_create_sub_category($category->childs, @$data->categoryId, $category->id);
                            }
                        }
                    }
                }
                $product_cate_id = devvn_get_term_id(@$data->categoryId);
                $product->set_category_ids(array($product_cate_id));
            }
            $attach_media = array();
            if (@$data->image) {
                $productImagesIDs = array(); // define an array to store the media ids.
                $images = [
                    @$data->image
                ]; // images url array of product
                if (@$data->images) {
                    foreach (@$data->images as $image_item) {
                        $images[] = $image_item;
                    }
                }
                // if ($product_id) {
                //     // error_log(print_r("product_id: ".$product_id,true));
                //     // error_log(print_r("product ID: ".$product->get_id(),true));
                //     // devvn_delete_old_image($product_id);
                // }
                
                foreach($images as $image){
                    $mediaID = devvn_uploadMedia($image); // calling the devvn_uploadMedia function and passing image url to get the uploaded media id
                    if($mediaID) $productImagesIDs[] = $mediaID; // storing media ids in a array.
                    if($mediaID) $attach_media[] = $mediaID; // storing media ids in a array.
                }
                if($productImagesIDs){
                    $product->set_image_id($productImagesIDs[0]); // set the first image as primary image of the product
                    if(count($productImagesIDs) > 1){
                        unset($productImagesIDs[0]);
                        $product->set_gallery_image_ids($productImagesIDs);
                    }
                }
            }
        }
        $product->set_sku(@$data->idNhanh);
        $product->set_status($set_status);
        $product_id = $product->save();
        if (!empty($attach_media)) {
            devvn_attach_media($product_id, $attach_media);
        }
        

        $status .= @$data->name.' - Trạng thái: '.@$data->status.'<br>';
        $status = str_replace('devvn_status',$set_status,$status);
        if ($set_status == 'publish') {
            $status = str_replace("class='update'","class='added'",$status);
        }elseif ($set_status == 'trash') {
            $status = str_replace("class='added'","class='update'",$status);
        }
        if ($ajax == true) {
            echo json_encode($status);
            wp_die();
        }
        // error_log(print_r($status,true));
    }
    add_action('wp_ajax_devvn_add_product', 'devvn_add_product');
    add_action('wp_ajax_nopriv_devvn_add_product', 'devvn_add_product');
}

function devvn_get_product_by_sku($sku) {
    global $wpdb;
    $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );
    if ( $product_id ) return new WC_Product( $product_id );
    return null;
}
function devvn_get_oder_id($nhanhID) {
    global $wpdb;
    $order_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='devvn_nhanh_id' AND meta_value='%s' LIMIT 1", $nhanhID ) );
    if ( $order_id ) return $order_id;
    return null;
}

function devvn_get_term_id($nhanh_id){
    $args = array(
    'hide_empty' => false, // also retrieve terms which are not used yet
    'meta_query' => array(
        array(
        'key'       => 'devvn_nhanh_id',
        'value'     => $nhanh_id,
        'compare'   => '='
        )
    ),
    'taxonomy'  => 'product_cat',
    );
    $terms = get_terms( $args );
    if ($terms) {
        return $terms[0]->term_id;
    }
    return null;
}

function devvn_uploadMedia($image_url){
	require_once(ABSPATH.'wp-admin/includes/image.php');
	require_once(ABSPATH.'wp-admin/includes/file.php');
	require_once(ABSPATH.'wp-admin/includes/media.php');
	$media = media_sideload_image($image_url,0);
	$attachments = get_posts(array(
		'post_type' => 'attachment',
		'post_status' => null,
		'post_parent' => 0,
		'orderby' => 'post_date',
		'order' => 'DESC'
	));
    if ($attachments) {
        return $attachments[0]->ID;
    }
	return null;
}
if(!function_exists('devvn_attach_media')){
    function devvn_attach_media($post_id, $images){
        global $wpdb;
        if ($images) {
            foreach ($images as $image) {
                $sql = "UPDATE $wpdb->posts SET `post_parent` = '$post_id' WHERE $wpdb->posts.`ID` = $image";
                $wpdb->get_results($sql);
            }
        }
    }
}
if(!function_exists('devvn_delete_old_image')){
    function devvn_delete_old_image($post_id){
        if (is_int($post_id) || is_string($post_id)) {
            $args = array(
                'post_type'   => 'attachment',
                'numberposts' => -1,
                'post_status' => 'any',
                'post_parent' => $post_id,
                // 'exclude'     => get_post_thumbnail_id(),
            );
            
            $attachments = get_posts( $args );
            
            if ( $attachments ) {
                foreach ( $attachments as $attachment ) {
                    wp_delete_attachment($attachment->ID, true);
                }
            }
        }
    }
}

function devvn_object_to_array($obj) {
    if(is_object($obj)) $obj = (array) $obj;
    if(is_array($obj)) {
        $new = array();
        foreach($obj as $key => $val) {
            $new[$key] = devvn_object_to_array($val);
        }
    }
    else $new = $obj;
    return $new;       
}

if(!function_exists('devvn_create_sub_category')){
    function devvn_create_sub_category($categories, $product_category_id, $parent_category_id){
        if ($categories) {
            foreach ($categories as $category) {
                $parent_cate_id = devvn_get_term_id($parent_category_id);
                // error_log(print_r("parent_cate_id: ".$parent_cate_id,true));
                $exist_id = devvn_get_term_id($category->id);
                if ($exist_id) {
                    $product_wp_cat_id = $exist_id;
                }else{
                    $args = [
                        'parent' => ($parent_cate_id) ? $parent_cate_id : 0
                    ];
                    $cid = wp_insert_term(
                        $category->name, // the term 
                        'product_cat', // the taxonomy
                        $args
                    );
                    $product_wp_cat_id = $cid['term_id'];
                }
                update_term_meta($product_wp_cat_id,'devvn_nhanh_id', $category->id);
                update_term_meta($product_wp_cat_id,'devvn_nhanh_code', $category->code);
                if ($category->id == $product_category_id) {
                    return true;
                }else{
                    devvn_create_sub_category(@$category->childs,$product_category_id, $category->id);
                }
            }
        }
        return false;
    }
}