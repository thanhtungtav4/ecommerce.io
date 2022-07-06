<?php
/*
* Plugin Name: DevVN Woocommerce Reviews
* Version: 1.2.6
* Description: Thay đổi giao diện phần đánh giá và thêm phần thảo luận cho chi tiết sản phẩm trong Woocommerce
* Author: Lê Văn Toản
* Author URI: https://levantoan.com/
* Plugin URI: https://levantoan.com/san-pham/devvn-woocommerce-reviews/
* Text Domain: devvn-reviews
* Domain Path: /languages
* WC requires at least: 3.5.4
* WC tested up to: 3.7.1
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !class_exists( 'DevVN_Reviews_Class' ) ) {
    class DevVN_Reviews_Class
    {

        protected static $instance;
        public $_version = '1.2.6';

        public $_optionName = 'devvn_reviews_options';
        public $_optionGroup = 'devvn_reviews-options-group';
        public $_defaultOptions = array(
            'img_size'  =>  '512000', //kb
            'disable_upload'  =>  '0',
            'number_img_upload'  =>  3,
            'cmt_length'  =>  '10',
            'review_position'  =>  '',
            'review_position_action'  =>  '',
            'review_priority'   =>  99,
            'recaptcha' =>  '',
            'license_key'   =>  '121212121212121212',

            'show_date' =>  '1',
            'show_tcmt' =>  '1',

            'show_like' =>  '2',
            'label_review'  =>  '1'
        );

        public static function init(){
            is_null(self::$instance) AND self::$instance = new self;
            return self::$instance;
        }

        public function __construct(){
            $this->define_constants();
            global $devvn_review_settings;
            $devvn_review_settings  = $this->get_options();

            add_filter( 'plugin_action_links_' . DEVVN_REVIEWS_BASENAME, array( $this, 'add_action_links' ), 10, 2 );
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
            add_action( 'admin_init', array( $this, 'register_mysettings') );

            add_filter( 'comments_template', array($this, 'devvn_comments_template_loader'), 99);
            add_action('comment_post', array($this, 'count_agian_review_count'), 10, 3);
            add_action( 'preprocess_comment', array($this, 'devvn_update_comment_type'), 1 );

            add_filter( 'comments_template_query_args' , array($this, 'devvn_comments_template_query_args'), 10);
            add_action('delete_comment_meta', array($this, 'devvn_delete_img_after_delete_cmt'), 10, 4);

            add_action( 'comment_post', array($this, 'save_comment_meta_data') );

            add_filter( 'comment_text', array($this, 'modify_comment'), 20, 2);
            add_action('wp_update_comment_count', array($this, 'devvn_clear_transients_count_review'), 20);

            add_filter('comment_post_redirect',  array($this, 'devvn_comment_post_redirect'), 10, 2);
            add_action('woocommerce_review_after_comment_text',  array($this, 'devvn_attach_view'));

            add_filter( 'woocommerce_product_tabs', array($this, 'woo_remove_product_tabs'), 98 );

            if($devvn_review_settings['review_position']){
                if($devvn_review_settings['review_position'] == 'custom' && $devvn_review_settings['review_position_action']) {
                    add_action($devvn_review_settings['review_position_action'], 'comments_template', $devvn_review_settings['review_priority']);
                }elseif($devvn_review_settings['review_position'] != 'custom') {
                    add_action($devvn_review_settings['review_position'], 'comments_template', $devvn_review_settings['review_priority']);
                }
            }

            //Comment
            if($devvn_review_settings['show_tcmt'] == 1):
                add_action( 'wp_ajax_devvn_cmt_submit',  array($this, 'devvn_cmt_submit_func') );
                add_action( 'wp_ajax_nopriv_devvn_cmt_submit',  array($this, 'devvn_cmt_submit_func') );

                add_action('comment_post', array($this, 'devvn_delete_transient_tcomment') );
                add_action('wp_set_comment_status', array($this, 'devvn_delete_transient_tcomment') );

                add_action( 'wp_ajax_devvn_cmt_search', array($this, 'devvn_cmt_search_func') );
                add_action( 'wp_ajax_nopriv_devvn_cmt_search', array($this, 'devvn_cmt_search_func') );
            endif;

            add_action( 'wp_enqueue_scripts', array($this, 'devvn_cmt_enqueue_style') );

            add_action( 'admin_notices', array($this, 'admin_notices') );
            if( is_admin() ) {
                add_action('in_plugin_update_message-' . DEVVN_REVIEWS_BASENAME, array($this,'devvn_modify_plugin_update_message'), 10, 2 );
            }

            add_filter('body_class', array($this, 'body_classs') );

            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
            add_action( 'wp_ajax_devvn_reviews_sync_cmt', array($this, 'devvn_reviews_sync_cmt_func') );
            add_action( 'wp_ajax_fake_reviews_bought', array($this, 'fake_reviews_bought_func') );
            add_action( 'wp_ajax_admin_fake_label', array($this, 'admin_fake_label_func') );

            self::create_files();

            //1.0.8
            add_filter('woocommerce_comment_pagination_args', array($this, 'devvn_woocommerce_comment_pagination_args') );

            //1.09
            add_action('devvn_reviews_action', array($this, 'get_like_review'));
            add_action( 'wp_ajax_devvn_like_cmt',  array($this, 'devvn_like_cmt_func') );
            add_action( 'wp_ajax_nopriv_devvn_like_cmt',  array($this, 'devvn_like_cmt_func') );

        }

        function body_classs($classes){
            if(function_exists('flatsome_setup')) {
                return array_merge($classes, array('theme-flatsome'));
            }
            return $classes;
        }

        function get_options(){
            return wp_parse_args(get_option($this->_optionName),$this->_defaultOptions);
        }

        function admin_menu()
        {
            add_submenu_page(
                'woocommerce',
                __('DevVN Reviews','devvn-reviews'),
                __('DevVN Reviews','devvn-reviews'),
                'manage_woocommerce',
                'devvn-woocommerce-reviews',
                array(
                    $this,
                    'devvn_reviews_setting'
                )
            );
        }

        function register_mysettings()
        {
            register_setting($this->_optionGroup, $this->_optionName);
        }

        public function define_constants() {
            if ( !defined( 'DEVVN_REVIEWS_VERSION_NUM' ) )
                define( 'DEVVN_REVIEWS_VERSION_NUM', $this->_version );
            if ( !defined( 'DEVVN_REVIEWS_URL' ) )
                define( 'DEVVN_REVIEWS_URL', plugin_dir_url( __FILE__ ) );
            if ( !defined( 'DEVVN_REVIEWS_BASENAME' ) )
                define( 'DEVVN_REVIEWS_BASENAME', plugin_basename( __FILE__ ) );
            if ( !defined( 'DEVVN_REVIEWS_PLUGIN_DIR' ) )
                define( 'DEVVN_REVIEWS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        }

        function devvn_reviews_setting()
        {
            global $devvn_review_settings;
            ?>
            <div class="wrap devvn_reviews_wrap">
                <h1><?php _e('Cài đặt bình luận và đánh giá cho Woocommerce', 'devvn-reviews');?></h1>
                <p><span style="color: red;">Chú ý:</span> Đọc thêm về phần chú ý cài đặt để plugin hoạt động chính xác hơn. <a href="https://levantoan.com/san-pham/devvn-woocommerce-reviews/#chu-y" rel="nofollow" target="_blank">Đọc tại đây</a> </p>
                <form method="post" action="options.php" novalidate="novalidate">
                    <?php
                    settings_fields($this->_optionGroup);
                    wp_nonce_field('admin_devvn_reviews_nonce_action','admin_devvn_reviews_nonce');
                    ?>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><label for="img_size"><?php _e('Hình ảnh','devvn-reviews');?></label></th>
                                <td>
                                    <p><label><input type="checkbox" name="<?php echo $this->_optionName?>[disable_upload]" value="1" id="disable_upload" <?php checked( $devvn_review_settings['disable_upload'], 1, true);?>> Không cho upload ảnh khi đánh giá</label></p>
                                    <p><input type="number" value="<?php echo $devvn_review_settings['img_size'];?>" id="img_size" name="<?php echo $this->_optionName?>[img_size]"> byte<br>
                                        <small>Dung lượng của hình ảnh được phép up lên. Đơn vị byte. Mặc định là 512000byte ~ 500kb (1kb ~ 1024byte)</small></p>
                                    Cho phép <input type="number" min="1" value="<?php echo $devvn_review_settings['number_img_upload'];?>" id="number_img_upload" name="<?php echo $this->_optionName?>[number_img_upload]"> hình ảnh được phép tải lên.
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="cmt_length"><?php _e('Độ dài nội dung tối thiểu','devvn-reviews');?></label></th>
                                <td>
                                    <input type="number" value="<?php echo $devvn_review_settings['cmt_length'];?>" id="cmt_length" name="<?php echo $this->_optionName?>[cmt_length]"> ký tự<br>
                                    <small>Số ký tự tối thiểu trong nội dung. Không tính dấu cách. Mặc định 10 ký tự</small>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="review_position"><?php _e('Vị trí hiển thị','devvn-reviews');?></label></th>
                                <td>
                                    <?php
                                    $hook = apply_filters('devvn_reviews_position', array(
                                        'woocommerce_after_single_product_summary',
                                        'woocommerce_after_single_product'
                                    ));
                                    ?>
                                    <select name="<?php echo $this->_optionName?>[review_position]" id="review_position_select">
                                        <option value="">Mặc định</option>
                                        <?php foreach ($hook as $key):?>
                                        <option value="<?php echo $key;?>" <?php selected($devvn_review_settings['review_position'], $key, true);?>><?php echo $key;?></option>
                                        <?php endforeach;?>
                                        <option value="custom" <?php selected($devvn_review_settings['review_position'], 'custom', true);?>>Tùy chỉnh</option>
                                    </select>
                                    <span class="review_position_action <?php echo ($devvn_review_settings['review_position'] == 'custom') ? 'active' : '';?>">Tên action <input type="text" name="<?php echo $this->_optionName?>[review_position_action]" value="<?php echo $devvn_review_settings['review_position_action'];?>" style="width: 200px" id="review_position_action"></span>
                                    Vị trí ưu tiên <input type="number" style="width: 50px" value="<?php echo $devvn_review_settings['review_priority'];?>" id="review_priority" name="<?php echo $this->_optionName?>[review_priority]"><br>
                                    <small>- Nếu không chọn vị trí hook để hiển thị reviews thì plugin sẽ hiển thị tại vị trí mặc định của theme quy định.<br>
                                    - Nếu chọn vị trí plugin sẽ loại bỏ tab review trong Woocommerce Tab mặc định. Sau đó hiển thị review tại hook bạn chọn<br>
                                    - Nếu chọn "tùy chỉnh" plugin sẽ loại bỏ tab review trong Woocommerce Tab mặc định. và nếu bạn nhập vào ô "Tên action" thì sẽ tự hiển thị trong action bạn nhập. Nếu bạn không nhập thì hãy đặt comments_template() vào chỗ muốn hiển thị reviews.<br>
                                    - Thứ tự ưu tiên hiển thị. Số càng to thì càng đứng sau. Mặc định 99</small>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="label_review"><?php _e('Tùy chỉnh label','devvn-reviews');?></label></th>
                                <td>
                                    <input type="text" value="<?php echo $devvn_review_settings['label_review'];?>" id="label_review" name="<?php echo $this->_optionName?>[label_review]"> <br/>
                                    <small>Nếu bỏ trống thì các review đã mua hàng sẽ hiện <strong style="color: green;">"Đã mua hàng tại <?php echo $_SERVER['SERVER_NAME'];?>"</strong></small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h2><?php _e('Tùy chỉnh','devvn-reviews');?></h2>
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th scope="row"><label for="show_date"><?php _e('Ẩn/Hiện ngày đánh giá','devvn-reviews');?></label></th>
                            <td>
                                <label style="margin-right: 10px;"><input type="radio" name="<?php echo $this->_optionName?>[show_date]" value="1" <?php checked($devvn_review_settings['show_date'], 1, true);?>> Hiện</label>
                                <label><input type="radio" name="<?php echo $this->_optionName?>[show_date]" value="2" <?php checked($devvn_review_settings['show_date'], 2, true);?>> Ẩn</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="show_tcmt"><?php _e('Ẩn/Hiện bình luận','devvn-reviews');?></label></th>
                            <td>
                                <label style="margin-right: 10px;"><input type="radio" name="<?php echo $this->_optionName?>[show_tcmt]" value="1" <?php checked($devvn_review_settings['show_tcmt'], 1, true);?>> Hiện</label>
                                <label><input type="radio" name="<?php echo $this->_optionName?>[show_tcmt]" value="2" <?php checked($devvn_review_settings['show_tcmt'], 2, true);?>> Ẩn</label>
                                <br><small>Mặc định có 2 phần đánh giá và bình luận. Chức năng ẩn này sẽ ẩn đi phần bình luận</small>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="show_like"><?php _e('Ẩn/Hiện nút thích','devvn-reviews');?></label></th>
                            <td>
                                <label style="margin-right: 10px;"><input type="radio" name="<?php echo $this->_optionName?>[show_like]" value="1" <?php checked($devvn_review_settings['show_like'], 1, true);?>> Hiện</label>
                                <label><input type="radio" name="<?php echo $this->_optionName?>[show_like]" value="2" <?php checked($devvn_review_settings['show_like'], 2, true);?>> Ẩn</label>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h2><?php _e('Công cụ','devvn-reviews');?></h2>
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th scope="row"><label for="sync_reviews"><?php _e('Đồng bộ đánh giá','devvn-reviews');?></label></th>
                            <td>
                                <button type="button" class="button sync_old_reviews">Đồng bộ bình luận cũ</button><span class="mess"></span><br>
                                <small>Chỉ sử dụng chức năng này khi trước đây admin có trả lời reviews của khách</small>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="fake_bought"><?php _e('Fake label khách đã mua hàng','devvn-reviews');?></label></th>
                            <td>
                                <button type="button" class="button fake_reviews_bought">Fake ngay</button><span class="mess"></span><br>
                                <small>Chức năng này giúp bạn fake tất cả các review cấp 1 có nhãn <strong style="color: green;">"đã mua hàng tại <?php echo $_SERVER['SERVER_NAME'];?>"</strong>. <br>
                                    <strong>Chú ý:</strong> Nếu website của bạn có người dùng đánh giá thật thì không nên dùng nha</small>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h2><?php _e('License','devvn-reviews');?></h2>
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th scope="row"><label for="license_key"><?php _e('License key','devvn-reviews');?></label></th>
                            <td>
                                <input type="text" id="license_key" value="<?php echo esc_attr($devvn_review_settings['license_key']);?>" name="<?php echo $this->_optionName . '[license_key]'?>">
                                <?php if(!$devvn_review_settings['license_key']):?><br><small><?php echo sprintf( __('Nếu bạn đã mua plugin và chưa nhận được license. Hãy gửi email + domain qua <a href="%s" target="_blank">facebook</a> để nhận license', 'devvn-reviews'), 'https://m.me/levantoan.wp');?></small><?php endif;?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?php do_settings_fields($this->_optionGroup, 'default'); ?>
                    <?php do_settings_sections($this->_optionGroup, 'default'); ?>
                    <?php submit_button(); ?>
                </form>
            </div>
            <p>Plugin được phát triển bởi <a href="https://levantoan.com" rel="nofollow" target="_blank">Lê Văn Toản</a></p>
            <?php
        }

        public function add_action_links($links, $file)
        {
            if (strpos($file, 'devvn-woocommerce-reviews.php') !== false) {
                $settings_link = '<a href="' . admin_url('admin.php?page=devvn-woocommerce-reviews') . '" title="' . __('Cài đặt', 'devvn-reviews') . '">' . __('Cài đặt', 'devvn-reviews') . '</a>';
                array_unshift($links, $settings_link);
            }
            return $links;
        }

        function devvn_comments_template_loader($template){
            if ( get_post_type() !== 'product' ) {
                return $template;
            }

            $check_dirs = array(
                trailingslashit( plugin_dir_path( __FILE__ ) ) . 'templates/',
            );

            foreach ( $check_dirs as $dir ) {
                if ( file_exists( trailingslashit( $dir ) . 'single-product-reviews.php' ) ) {
                    return trailingslashit( $dir ) . 'single-product-reviews.php';
                }
            }
        }

        function devvn_get_product_reviews_by_rating($product_id, $rating = 0){
            if ( false === ( $comments = get_transient( 'devvn_add_cmt_count_review_' . $product_id . $rating ) ) ) {
                $args = array(
                    'post_id' => $product_id,
                    'type' => 'review',
                    'status' => 'approve',
                    'parent'    =>  0

                );
                if($rating > 0){
                    $args ['meta_query'] = array(
                        array(
                            'key' => 'rating',
                            'value' => $rating
                        )
                    );
                }
                $comment_query = new WP_Comment_Query;
                $comments = $comment_query->query( $args );
                set_transient( 'devvn_add_cmt_count_review_' . $product_id . $rating, $comments );
            }
            return $comments;
        }

        function count_agian_review_count($comment_ID, $comment_approved, $commentdata){
            global $devvn_review_settings;
            $post_id = $commentdata['comment_post_ID'];
            if ( 'product' === get_post_type( $post_id ) ) {
                $product = wc_get_product( $post_id );
                $product->set_rating_counts( $this->devvn_get_rating_counts_for_product( $product ) );
                $product->set_average_rating( $this->devvn_get_average_rating_for_product( $product ) );
                $product->set_review_count( $this->devvn_get_review_count_for_product( $product ) );
                $product->save();

                //Save attach
                if(isset($_FILES['attach']) && !$devvn_review_settings['disable_upload']) {
                    $attachment_img = array();
                    $devvn_files = $_FILES['attach'];
                    $stt = 1;
                    foreach ($devvn_files['tmp_name'] as $key => $tmp_name) {
                        if ($devvn_files['size'][$key] > 0 && $devvn_files['error'][$key] == 0 && $stt <= $devvn_review_settings['number_img_upload']) {
                            $file = array(
                                'name' => $devvn_files['name'][$key],
                                'type' => $devvn_files['type'][$key],
                                'tmp_name' => $devvn_files['tmp_name'][$key],
                                'error' => $devvn_files['error'][$key],
                                'size' => $devvn_files['size'][$key]
                            );
                            $_FILES = array("cmt_file_upload" => $file);
                            add_filter( 'upload_dir', array($this, 'set_upload_dir') );
                            add_filter('intermediate_image_sizes_advanced', array($this, 'remove_default_image_sizes') );
                            foreach ($_FILES as $fileHandler => $array) {
                                $attachId = $this->devvn_cmt_insertAttachment($fileHandler, $post_id);
                            }
                            remove_filter( 'upload_dir',  array($this, 'set_upload_dir') );
                            remove_filter('intermediate_image_sizes_advanced', array($this, 'remove_default_image_sizes') );
                            if (is_numeric($attachId)) $attachment_img[] = $attachId;
                            $stt++;
                        }
                    }
                    unset($_FILES);
                    if ($attachment_img) {
                        add_comment_meta($comment_ID, 'attachment_img', $attachment_img);
                    }
                }
            }
        }

        function devvn_cmt_insertAttachment($fileHandler, $postId){
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
            return media_handle_upload($fileHandler, $postId);
        }

        function devvn_update_comment_type($comment_data){

            global $devvn_review_settings;

            if ( isset( $_POST['comment_post_ID'], $comment_data['comment_type'] ) &&
                'product' === get_post_type( absint( $_POST['comment_post_ID'] ) ) &&
                isset( $_POST['comment_parent']) && $_POST['comment_parent'] != 0
            ) {
                //$comment_data['comment_type'] = '';
                $_POST['rating'] = 0;
            }

            if(!is_admin() && !is_user_logged_in() && isset( $_POST['comment_post_ID'], $comment_data['comment_type'] ) && 'product' === get_post_type( absint( $_POST['comment_post_ID'] ) )) {
                // if (!isset($_POST['phone']))
                //     wp_die(__('Lỗi: Số điện thoại là bắt buộc'));

                // $phone = $_POST['phone'];
                // if (!(preg_match('/^0([0-9]{9,10})+$/D', $phone))) {
                //     wp_die(__('Lỗi: Số điện thoại không đúng định dạng'));
                // }
                if ($comment_data['comment_author'] == '')
                    wp_die('Lỗi: Xin hãy nhập tên của bạn');
            }

            //since 1.0.3
            if(is_admin() && isset( $_POST['comment_post_ID'], $comment_data['comment_type'] ) && 'product' === get_post_type( absint( $_POST['comment_post_ID'] ) )){
                if(isset($comment_data['comment_parent']) && $comment_data['comment_parent']) {
                    $comment = get_comment($comment_data['comment_parent']);
                    if ('review' == $comment->comment_type) {
                        $comment_data['comment_type'] = 'review';
                    }
                    if ('tcomment' == $comment->comment_type) {
                        $comment_data['comment_type'] = 'tcomment';
                    }
                }
            }

            $minimalCommentLength = $devvn_review_settings['cmt_length'];

            if ( strlen( trim( remove_accents($comment_data['comment_content']) ) ) < $minimalCommentLength && $comment_data['comment_type'] == 'review'){
                wp_die( 'Nội dung đánh giá phải tối thiểu ' . $minimalCommentLength . ' ký tự.' );
            }

            //check file
            if(isset($_FILES['attach']) && !$devvn_review_settings['disable_upload']){
                foreach($_FILES['attach']['tmp_name'] as $key=>$tmp_name) {
                    if($_FILES['attach']['size'][$key] > 0 && $_FILES['attach']['error'][$key] == 0) {

                        $fileInfo = pathinfo($_FILES['attach']['name'][$key]);
                        $fileExtension = strtolower($fileInfo['extension']);

                        if(function_exists('finfo_file')){
                            $fileType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['attach']['tmp_name'][$key]);
                        } elseif(function_exists('mime_content_type')) {
                            $fileType = mime_content_type($_FILES['attach']['tmp_name'][$key]);
                        } else {
                            $fileType = $_FILES['attach']['type'][$key];
                        }

                        if ( !in_array($fileType, $this->devvn_getImageMimeTypes()) || !in_array($fileExtension, $this->devvn_getAllowedFileExtensions()) ) {
                            wp_die(sprintf(__('<strong>Lỗi:</strong> Ảnh không đúng định dạng','devvn-reviews')));
                        }
                        if ( $_FILES['attach']['size'][$key] > $devvn_review_settings['img_size'] ) {
                            wp_die(sprintf(__('<strong>Lỗi:</strong> Ảnh quá to. Chỉ cho phép tải ảnh < ' . $this->formatSizeUnits($devvn_review_settings['img_size']),'devvn-reviews')));
                        }
                    } elseif($_FILES['attach']['error'][$key] == 1) {
                        wp_die(__('<strong>ERROR:</strong> The uploaded file exceeds the upload_max_filesize directive in php.ini.','devvn-reviews'));
                    } elseif($_FILES['attach']['error'][$key] == 2) {
                        wp_die(__('<strong>ERROR:</strong> The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.','devvn-reviews'));
                    } elseif($_FILES['attach']['error'][$key] == 3) {
                        wp_die(__('<strong>ERROR:</strong> The uploaded file was only partially uploaded. Please try again later.','devvn-reviews'));
                    } elseif($_FILES['attach']['error'][$key] == 6) {
                        wp_die(__('<strong>ERROR:</strong> Missing a temporary folder.','devvn-reviews'));
                    } elseif($_FILES['attach']['error'][$key] == 7) {
                        wp_die(__('<strong>ERROR:</strong> Failed to write file to disk.','devvn-reviews'));
                    } elseif($_FILES['attach']['error'][$key] == 7) {
                        wp_die(__('<strong>ERROR:</strong> A PHP extension stopped the file upload.','devvn-reviews'));
                    }

                }
            }

            return $comment_data;
        }

        function formatSizeUnits($bytes)
        {
            if ($bytes >= 1073741824){
                $bytes = number_format($bytes / 1073741824, 0) . ' GB';
            }elseif ($bytes >= 1048576){
                $bytes = number_format($bytes / 1048576, 0) . ' MB';
            }elseif ($bytes >= 1024){
                $bytes = number_format($bytes / 1024, 0) . ' KB';
            }elseif ($bytes > 1){
                $bytes = $bytes . ' bytes';
            }elseif ($bytes == 1){
                $bytes = $bytes . ' byte';
            }else{
                $bytes = '0 bytes';
            }
            return $bytes;
        }

        function devvn_getImageMimeTypes(){
            return apply_filters('devvn_reviews_image_mime_types', array(
                'image/jpeg',
                'image/jpg',
                'image/jp_',
                'application/jpg',
                'application/x-jpg',
                'image/pjpeg',
                'image/pipeg',
                'image/vnd.swiftview-jpeg',
                'image/x-xbitmap',
                'image/gif',
                'image/x-xbitmap',
                'image/gi_',
                'image/png',
                'application/png',
                'application/x-png'
            ));
        }

        function devvn_getAllowedFileExtensions(){
            return apply_filters('devvn_reviews_file_extensions', array('jpg', 'gif', 'png', 'jpeg'));
        }

        function devvn_comments_template_query_args($comment_args){
            if('product' === get_post_type( absint( $comment_args['post_id'] ))){
                $comment_args['order'] = 'DESC';
                $comment_args['type'] = 'review';
            }
            return $comment_args;
        }

        function devvn_delete_img_after_delete_cmt($meta_id, $object_id, $meta_key, $meta_value){
            if($meta_key == 'attachment_img' && $meta_value){
                if(is_array($meta_value)){
                    foreach ($meta_value as $item){
                        wp_delete_attachment($item, true);
                    }
                }
            }
        }

        function save_comment_meta_data( $comment_id ) {
            if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') ) {
                $phone = wp_filter_nohtml_kses($_POST['phone']);
                $comment = get_comment($comment_id);
                if ('review' == $comment->comment_type) {
                    add_comment_meta($comment_id, 'phone', $phone);
                }
            }
        }

        function modify_comment( $text, $comment ){
            $commentphone = get_comment_meta( get_comment_ID(), 'phone', true );
            if($commentphone  && is_admin() ) {
                $commentphone = '<br/>SĐT: <strong>' . esc_attr( $commentphone ) . '</strong>';
                $text = $text . $commentphone;
            }
            $attachment_img = get_comment_meta(get_comment_ID(), 'attachment_img', true);
            if($attachment_img  && is_admin() ) {
                $img_text = '';
                foreach ($attachment_img as $img){
                    $img_text .= '<a class="review_img" href="'.get_edit_post_link($img).'" title="" target="_blank">'  . wp_get_attachment_image($img,'thumbnail') . '</a>';
                }
                $text = $text . '<br/>' . $img_text;
            }

            //1.0.8 - fake label each cmt
            $is_woo = false;
            $is_parent = $comment->comment_parent;
            $comment_type = $comment->comment_type;
            $comment_post_ID = $comment->comment_post_ID;

            if(get_post_type($comment_post_ID) == 'product') $is_woo = true;
            $verified = get_comment_meta( $comment->comment_ID, 'verified', 1 );

            if(is_admin() && $is_woo && !$is_parent && $comment_type == 'review') {
                $nonce = wp_create_nonce('admin_fake_label');
                if(!$verified) {
                    $text = $text . '<br>' . '<a href="javascript:void(0)" class="admin_fake_label" data-id="' . $comment->comment_ID . '" data-nonce="'.$nonce.'">' . __('Fake đã mua hàng', 'devvn-reviews') . '</a>';
                }else{
                    $text = $text . '<br>' . __('Đã mua hàng', 'devvn-reviews');
                }
            }

            return $text;
        }

        function devvn_clear_transients_count_review($post_id){
            if ( 'product' === get_post_type( $post_id ) ) {
                $product = wc_get_product( $post_id );
                $product->set_rating_counts( $this->devvn_get_rating_counts_for_product( $product ) );
                $product->set_average_rating( $this->devvn_get_average_rating_for_product( $product ) );
                $product->set_review_count( $this->devvn_get_review_count_for_product( $product ) );
                $product->save();
            }
        }

        function devvn_get_rating_counts_for_product( &$product ) {
            global $wpdb;
            $counts     = array();
            $raw_counts = $wpdb->get_results(
                $wpdb->prepare(
                    "
			SELECT meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_type = 'review'
			AND comment_approved = '1'
			AND meta_value > 0
			GROUP BY meta_value
				",
                    $product->get_id()
                )
            );

            foreach ( $raw_counts as $count ) {
                $counts[ $count->meta_value ] = absint( $count->meta_value_count ); // WPCS: slow query ok.
            }

            return $counts;
        }

        function devvn_get_average_rating_for_product( &$product ) {
            global $wpdb;

            $count = $product->get_rating_count();

            if ( $count ) {
                $ratings = $wpdb->get_var(
                    $wpdb->prepare(
                        "
				SELECT SUM(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
			    AND comment_type = 'review'
				AND comment_approved = '1'
				AND meta_value > 0
					",
                        $product->get_id()
                    )
                );
                $average = number_format( $ratings / $count, 2, '.', '' );
            } else {
                $average = 0;
            }

            return $average;
        }

        function devvn_get_review_count_for_product( &$product ) {
            global $wpdb;

            $count = $wpdb->get_var(
                $wpdb->prepare(
                    "
			SELECT COUNT(*) FROM $wpdb->comments
			WHERE comment_parent = 0
			AND comment_post_ID = %d
			AND comment_type = 'review'
			AND comment_approved = '1'
				",
                    $product->get_id()
                )
            );

            return $count;
        }

        function devvn_comment_post_redirect($location, $comment){
            $location = get_permalink($comment->comment_post_ID) . '#reviews';
            return $location;
        }

        function devvn_attach_view($comment){
            $attachment_img = get_comment_meta($comment->comment_ID, 'attachment_img', true);
            if($attachment_img && is_array($attachment_img)){
                ?>
                <ul class="cmt_attachment_img">
                    <?php foreach ($attachment_img as $item):?>
                        <li><a href="<?php echo wp_get_attachment_image_url($item, 'full');?>"><?php echo wp_get_attachment_image($item, 'woocommerce_gallery_thumbnail')?></a></li>
                    <?php endforeach;?>
                </ul>
                <?php
            }
        }

        function devvn_cmt_submit_func() {

            if(!isset($_POST['cmt_data'])) wp_send_json_error('Lỗi dữ liệu');

            parse_str($_POST['cmt_data'], $cmt_data);

            $devvn_cmt_name = isset($cmt_data['devvn_cmt_name']) ? wc_clean($cmt_data['devvn_cmt_name']) : '';

            if(!$devvn_cmt_name) $devvn_cmt_name = isset($cmt_data['devvn_cmt_replyname']) ? wc_clean($cmt_data['devvn_cmt_replyname']) : '';

            $content = isset($_POST['content']) ? sanitize_textarea_field($_POST['content']) : '';
            $gender = isset($_POST['gender']) ? wc_clean($_POST['gender']) : '';
            $name = isset($_POST['name']) ? wc_clean($_POST['name']) : '';
            $email = (isset($_POST['email']) && $_POST['email']) ? sanitize_email($_POST['email']) : '';
            $cmt_parent_id = (isset($cmt_data['cmt_parent_id']) && $cmt_data['cmt_parent_id']) ? intval($cmt_data['cmt_parent_id']) : 0;
            $post_ID = (isset($cmt_data['post_ID'])) ? intval($cmt_data['post_ID']) : '';
            if ($email) if (!is_email($email)) wp_send_json_error('Lỗi định dạng email');
            if(!is_user_logged_in()) {
                if (!in_array($gender, array('male', 'female'))) wp_send_json_error('Lỗi giới tính');
                if ( $devvn_cmt_name != $name) wp_send_json_error('Lỗi đầu vào');
            }

            $products = wc_get_product($post_ID);

            if(!$products || is_wp_error($products)) wp_send_json_error('Sản phẩm không tồn tại');

            $current_user = wp_get_current_user();

            $commentdata = array(
                'comment_post_ID' => $products->get_id(),
                'comment_content' => $content,
                'comment_type' => 'tcomment',
                'comment_parent' => $cmt_parent_id,
                'user_id' => $current_user->ID
            );

            if(!$current_user->ID){
                $commentdata['comment_author'] = $name;
                $commentdata['comment_author_email'] = $email;
                $commentdata['comment_author_url'] = '';
            }else{
                $commentdata['comment_author'] = $current_user->display_name;
                $commentdata['comment_author_email'] = $current_user->user_email;
                $commentdata['comment_author_url'] = '';
            }

            $comment_id = wp_new_comment( $commentdata );
            if($comment_id){
                add_comment_meta( $comment_id, 'gender', $gender );
                if('approved' == wp_get_comment_status($comment_id)){
                    $devvn_cmt = $this->query_all_tcomment($products);
                    $output = array(
                        'result' => true,
                        'messages' => 'Bình luận thành công!',
                    );
                    if(count($devvn_cmt) > 1) {
                        $devvn_cmt_count = $this->get_tcomment_count($devvn_cmt);
                        $devvn_cmt_list_box = $this->get_list_tcomment($devvn_cmt, $products);
                        $output['fragments'] = array(
                            '.devvn_cmt_count' => $devvn_cmt_count,
                            '.devvn_cmt_list_box' => $devvn_cmt_list_box,
                        );
                    }else{
                        $output['fragments'] = array(
                            '.devvn_cmt_list' => $this->devvn_list_all_tcomment($products),
                        );
                    }
                    wp_send_json_success($output);
                }else {
                    $output = array(
                        'result'    =>  false,
                        'messages'  =>  'Đã gửi bình luận thành công. Đang chờ xét duyệt!',
                    );
                    wp_send_json_success($output);
                }
            }else{
                wp_send_json_error('Lỗi khi thêm bình luận');
            }
            die();
        }

        function devvn_delete_transient_tcomment($comment_id) {
            $comment = get_comment($comment_id);
            if(in_array($comment->comment_type, array('tcomment', 'review')) ) {
                global $wpdb;
                $menus = $wpdb->get_col('SELECT option_name FROM ' . $wpdb->prefix . 'options WHERE option_name LIKE "_transient_devvn_add_cmt_%" ');
                foreach ($menus as $menu) {
                    $key = str_replace('_transient_', '', $menu);
                    delete_transient($key);
                }
                wp_cache_flush();
            }
        }

        function devvn_first_letter($string){
            $words = preg_split("/[\s,_-]+/", remove_accents($string));
            $words = array_slice($words, -2);
            $acronym = '';
            foreach ($words as $w) {
                $acronym .= strtoupper($w[0]);
            }
            return $acronym;
        }

        function query_all_tcomment($product){
            if(false === ( $devvn_cmt = get_transient( 'devvn_add_cmt_list_tcomment_p' . $product->get_id() ) )) {
                $args = array(
                    'type' => 'tcomment',
                    'status' => 'approve',
                    'post_id'   =>  $product->get_id(),
                    'parent'    =>  0
                );
                $comment_query = new WP_Comment_Query;
                $devvn_cmt = $comment_query->query($args);
                if($devvn_cmt) {
                    set_transient('devvn_add_cmt_list_tcomment_p' . $product->get_id(), $devvn_cmt);
                }
            }
            return $devvn_cmt;
        }

        function get_tcomment_count($devvn_cmt){
            $total_comment = count($devvn_cmt);
            return $total_comment .' Bình luận';
        }

        function get_list_tcomment($devvn_cmt, $product){
            global $devvn_review_settings;
            ob_start();
            ?>
            <ul>
                <?php
                foreach ($devvn_cmt as $cmt):
                    $comment_ID = isset($cmt->comment_ID) ? $cmt->comment_ID : '';
                    $comment_author = isset($cmt->comment_author) ? $cmt->comment_author : '';
                    $comment_content = isset($cmt->comment_content) ? wpautop($cmt->comment_content) : '';
                    $comment_date = isset($cmt->comment_date) ? $cmt->comment_date : '';
                    $user_id = isset($cmt->user_id ) ? $cmt->user_id  : '';
                    ?>
                    <li>
                        <div class="devvn_cmt_box">

                            <span><?php echo $this->devvn_first_letter($comment_author);?></span>
                            <strong><?php echo $comment_author;?></strong>
                            <div class="devvn_cmt_box_content"><?php echo $comment_content;?></div>
                            <div class="devvn_cmt_tool">
                                <span><a href="javascript:void(0)" class="devvn_cmt_reply" data-cmtid="<?php echo $comment_ID;?>" data-authorname="<?php echo esc_attr($comment_author);?>">Trả lời</a></span>
                                <?php do_action('devvn_reviews_action', $cmt);?>
                                <?php if($devvn_review_settings['show_date'] == "1"):?>
                                <span> • </span>
                                <span><?php echo human_time_diff(strtotime($comment_date), current_time( 'timestamp' )) . ' trước'; //echo date_i18n('d/m/Y', strtotime($comment_date));?></span>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php
                        if(false === ( $devvn_cmt_child = get_transient( 'devvn_add_cmt_listchild_tcomment_' . $comment_ID ) )) {
                            $args = array(
                                'type' => 'tcomment',
                                'status' => 'approve',
                                'post_id'   =>  $product->get_id(),
                                'parent'    =>  $comment_ID,
                                'order' =>  'ASC',
                                //'number'    =>  20
                            );
                            $comment_query = new WP_Comment_Query;
                            $devvn_cmt_child = $comment_query->query($args);
                            if($devvn_cmt_child) {
                                set_transient('devvn_add_cmt_listchild_tcomment_' . $comment_ID, $devvn_cmt_child);
                            }
                        }
                        if($devvn_cmt_child):
                            ?>
                            <ul class="devvn_cmt_child">
                                <?php
                                $parent_cmt_ID = $comment_ID;
                                foreach ($devvn_cmt_child as $cmt):
                                    $comment_ID = isset($cmt->comment_ID) ? $cmt->comment_ID : '';
                                    $comment_author = isset($cmt->comment_author) ? $cmt->comment_author : '';
                                    $comment_content = isset($cmt->comment_content) ? wpautop($cmt->comment_content) : '';
                                    $comment_date = isset($cmt->comment_date) ? $cmt->comment_date : '';
                                    $user_id = isset($cmt->user_id ) ? $cmt->user_id  : '';
                                    $user_roles = array();
                                    if($user_id) {
                                        $user = get_userdata($user_id);
                                        $user_roles = $user->roles;
                                    }
                                    $qtv = devv_check_reviews_admin($user_roles);
                                    ?>
                                    <li>
                                        <div class="devvn_cmt_box">
                                            <span><?php echo $this->devvn_first_letter($comment_author);?></span>
                                            <strong><?php echo $comment_author;?></strong>
                                            <?php if ( $qtv && $user_roles) {?>
                                                <b class="qtv">Quản trị viên</b>
                                            <?php }?>
                                            <div class="devvn_cmt_box_content"><?php echo $comment_content;?></div>
                                            <div class="devvn_cmt_tool">
                                                <span><a href="javascript:void(0)" class="devvn_cmt_reply" data-cmtid="<?php echo $parent_cmt_ID;?>" data-authorname="<?php echo esc_attr($comment_author);?>">Trả lời</a></span>
                                                <?php do_action('devvn_reviews_action', $cmt);?>
                                                <?php if($devvn_review_settings['show_date'] == "1"):?>
                                                <span> • </span>
                                                <span><?php echo human_time_diff(strtotime($comment_date), current_time( 'timestamp' )) . ' trước';//echo date_i18n('d/m/Y', strtotime($comment_date));?></span>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        <?php endif;?>
                    </li>
                <?php endforeach;?>
            </ul>
            <?php
            return ob_get_clean();
        }

        function devvn_list_all_tcomment($product){
            ob_start();
            $devvn_cmt = $this->query_all_tcomment($product);
            $total_comment = count($devvn_cmt);
            if($devvn_cmt):?>
                <div class="devvn_cmt_list_header">
                    <div class="devvn_cmt_lheader_left">
                        <span class="devvn_cmt_count"><?php echo $this->get_tcomment_count($devvn_cmt);?></span>
                    </div>
                    <div class="devvn_cmt_lheader_right">
                        <div class="devvn_cmt_search_box">
                            <form action="" method="post" id="devvn_cmt_search_form">
                                <input type="text" name="devvn_cmt_search" id="devvn_cmt_search" placeholder="Tìm theo nội dung"/>
                                <input type="hidden" value="<?php echo $product->get_id();?>" name="post_ID">
                                <button type="submit devvn-icon-search"><?php _e('Tìm kiếm','devvn-reviews');?></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="devvn_cmt_list_box">
                    <?php echo $this->get_list_tcomment($devvn_cmt, $product);?>
                </div>
                <script type="text/template" id="tmpl-reply-devvn-cmt">
                    <form action="" method="post" id="devvn_cmt_reply">
                        <div class="devvn_cmt_input">
                            <textarea placeholder="" name="devvn_cmt_replycontent" id="devvn_cmt_replycontent" minlength="20">{{{ data.authorname }}}</textarea>
                        </div>
                        <div class="devvn_cmt_form_bottom">
                            <?php if(!is_user_logged_in()) {?>
                                <div class="devvn_cmt_radio">
                                    <label>
                                        <input name="devvn_cmt_replygender" type="radio" value="male" checked/>
                                        <span>Anh</span>
                                    </label>
                                    <label>
                                        <input name="devvn_cmt_replygender" type="radio" value="female"/>
                                        <span>Chị</span>
                                    </label>
                                </div>
                                <div class="devvn_cmt_input">
                                    <input name="devvn_cmt_replyname" type="text" id="devvn_cmt_replyname" placeholder="Họ tên (bắt buộc)"/>
                                </div>
                                <div class="devvn_cmt_input">
                                    <input name="devvn_cmt_replyemail" type="text" id="devvn_cmt_replyemail" placeholder="Email"/>
                                </div>
                            <?php }?>
                            <div class="devvn_cmt_submit">
                                <button type="submit" id="devvn_cmt_replysubmit">Gửi</button>
                                <input type="hidden" value="<?php echo $product->get_id();?>" name="post_ID">
                                <input type="hidden" value="{{{ data.parent_id }}}" name="cmt_parent_id">
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="devvn_cancel_cmt">×</a>
                    </form>
                </script>
            <?php else:?>
                <p>Chưa có bình luận nào</p>
            <?php endif;?>
            <?php
            return ob_get_clean();
        }


        function devvn_cmt_search_func(){

            parse_str($_POST['formData'], $formData);

            $devvn_cmt_search = isset($formData['devvn_cmt_search']) ? wc_clean($formData['devvn_cmt_search']) : '';
            $post_ID = isset($formData['post_ID']) ? intval($formData['post_ID']) : '';

            $search = isset($_POST['search']) ? wc_clean($_POST['search']) : '';

            if($devvn_cmt_search != $search) wp_send_json_error('Lỗi dữ liệu!');

            if('product' != get_post_type($post_ID)) wp_send_json_error('Lỗi dữ liệu!');

            $products = wc_get_product($post_ID);

            $args = array(
                'type' => 'tcomment',
                'status' => 'approve',
                'parent'    =>  0,
                'post_id'   =>  $products->get_id(),
                'search'    =>  $search
            );
            $comment_query = new WP_Comment_Query;
            $devvn_cmt = $comment_query->query($args);

            if($devvn_cmt){
                $devvn_cmt_count = $this->get_tcomment_count($devvn_cmt);
                $devvn_cmt_list_box = $this->get_list_tcomment($devvn_cmt, $products);
                $output = array(
                    'result'    =>  true,
                    'messages'  =>  'Bình luận thành công!',
                    'fragments' =>  array(
                        '.devvn_cmt_count' => $devvn_cmt_count,
                        '.devvn_cmt_list_box' => $devvn_cmt_list_box,
                    )
                );
                wp_send_json_success($output);
            }else{
                $output = array(
                    'result' => true,
                    'messages'  =>  'Không có bình luận nào!',
                    'fragments' =>  array(
                        '.devvn_cmt_count' => $this->get_tcomment_count($devvn_cmt),
                        '.devvn_cmt_list_box' => '',
                    )
                );
                wp_send_json_success($output);
            }
            die();
        }

        function devvn_cmt_enqueue_style() {
            global $devvn_review_settings;
            if(is_singular('product')) {
                wp_enqueue_style('magnific-popup', plugin_dir_url(__FILE__). 'library/magnific-popup/magnific-popup.css', array(), $this->_version, 'all');
                wp_enqueue_style('devvn-reviews-style', plugin_dir_url(__FILE__). 'css/devvn-woocommerce-reviews.css', array(), $this->_version, 'all');

                wp_enqueue_script('jquery.validate', plugin_dir_url(__FILE__). 'library/jquery.validate.min.js', array('jquery'), $this->_version, true);
                wp_enqueue_script('magnific-popup', plugin_dir_url(__FILE__). 'library/magnific-popup/magnific-popup.js', array('jquery'), $this->_version, true);
                wp_enqueue_script('devvn-reviews-script', plugin_dir_url(__FILE__). 'js/devvn-woocommerce-reviews.js', array('jquery', 'magnific-popup', 'jquery.validate', 'wp-util'), $this->_version, true);
                $array = array(
                    'ajax_url'  => admin_url('admin-ajax.php'),
                    'img_size'  =>  $devvn_review_settings['img_size'],
                    'img_size_text'  =>  $this->formatSizeUnits($devvn_review_settings['img_size']),
                    'cmt_length'  =>  $devvn_review_settings['cmt_length'],
                    'number_img_upload'  =>  $devvn_review_settings['number_img_upload'],
                );
                wp_localize_script('devvn-reviews-script', 'devvn_reviews', $array);
            }
        }

        function woo_remove_product_tabs($tabs){
            global $devvn_review_settings;
            if($devvn_review_settings['review_position']){
                unset( $tabs['reviews'] );
            }
            return $tabs;
        }

        function admin_notices(){
            global $devvn_review_settings;
            $class = 'notice notice-error';
            $license_key = $devvn_review_settings['license_key'];
            if(!$license_key) {
                printf('<div class="%1$s"><p><strong>Plugin DevVN Woocommerce Reviews:</strong> Hãy điền <strong>License Key</strong> để tự động cập nhật khi có phiên bản mới. <a href="%2$s">Thêm tại đây</a></p></div>', esc_attr($class), esc_url(admin_url('admin.php?page=devvn-woocommerce-reviews')));
            }
        }

        function devvn_modify_plugin_update_message( $plugin_data, $response ) {
            global $devvn_review_settings;
            $license_key = sanitize_text_field($devvn_review_settings['license_key']);
            if( $license_key && isset($plugin_data['package']) && $plugin_data['package']) return;
            $PluginURI = isset($plugin_data['PluginURI']) ? $plugin_data['PluginURI'] : '';
            echo '<br />' . sprintf( __('<strong>Mua bản quyền để được tự động update. <a href="%s" target="_blank">Xem thêm thông tin mua bản quyền</a></strong> hoặc liên hệ mua trực tiếp qua <a href="%s" target="_blank">facebook</a>', 'devvn-quickbuy'), $PluginURI, 'https://m.me/levantoan.wp');
        }

        public function admin_enqueue_scripts()
        {
            $current_screen = get_current_screen();
            if (isset($current_screen->base) && in_array($current_screen->base, array('edit-comments', 'woocommerce_page_devvn-woocommerce-reviews'))) {
                wp_enqueue_style('devvn-reviews-styles', plugins_url('/css/admin-devvn-woocommerce-reviews.css', __FILE__), array(), $this->_version, 'all');
                wp_enqueue_script('devvn-reviews', plugins_url('/js/admin-devvn-woocommerce-reviews.js', __FILE__), array('jquery'), $this->_version, true);
                $array = array(
                    'ajax_url'  => admin_url('admin-ajax.php'),
                    'text_loading'  =>  __('Đang thực hiện...', 'devvn-reviews'),
                    'text_done'  =>  __('Đã xong', 'devvn-reviews'),
                    'text_error'  =>  __('Có lỗi xảy ra. Fake lại ngay', 'devvn-reviews'),
                );
                wp_localize_script('devvn-reviews', 'devvn_reviews', $array);
            }
        }
        function devvn_reviews_sync_cmt_func(){
            if ( !wp_verify_nonce( $_REQUEST['nonce'], "admin_devvn_reviews_nonce_action")) {
                wp_send_json_error('Lỗi kiểm tra mã bảo mật');
            }
            $comments = get_comments();
            $count = $count_error = 0;
            foreach($comments as $comment) :
                $post_id = $comment->comment_post_ID;
                $comment_type = $comment->comment_type ;
                if('product' == get_post_type($post_id) && $comment_type == ''){
                    $new_comment = array();
                    $new_comment['comment_ID'] = $comment->comment_ID;
                    $new_comment['comment_type'] = 'review';
                    $new_cmt = wp_update_comment( $new_comment );
                    if($new_cmt) {
                        $count++;
                    }else{
                        $count_error++;
                    }
                }
            endforeach;
            wp_send_json_success(sprintf(__('Đã sync %1$d đánh giá. Có %2$d lỗi.', 'devvn-reviews'), $count, $count_error));
            die();
        }

        function fake_reviews_bought_func(){
            if ( !wp_verify_nonce( $_REQUEST['nonce'], "admin_devvn_reviews_nonce_action")) {
                wp_send_json_error('Lỗi kiểm tra mã bảo mật');
            }
            $comments = get_comments();
            $count = $count_error = 0;
            foreach($comments as $comment) :
                $post_id = $comment->comment_post_ID;
                $comment_type = $comment->comment_type;
                $comment_parent = $comment->comment_parent;
                if('product' == get_post_type($post_id) && $comment_type == 'review' && $comment_parent == 0){
                    $new_cmt = update_comment_meta( $comment->comment_ID, 'verified', 1 );
                    if($new_cmt) {
                        $count++;
                    }else{
                        $count_error++;
                    }
                }
            endforeach;
            wp_send_json_success(sprintf(__('Đã fake %1$d đánh giá.', 'devvn-reviews'), $count, $count_error));
            die();
        }

        function admin_fake_label_func(){
            if ( !wp_verify_nonce( $_REQUEST['nonce'], "admin_fake_label")) {
                wp_send_json_error('Lỗi kiểm tra mã bảo mật');
            }
            $id = (isset($_POST['id']) && $_POST['id']) ? intval($_POST['id']) : '';
            if($id) {
                $comment = get_comment($id);
                if($comment && !is_wp_error($comment)) {
                    $post_id = $comment->comment_post_ID;
                    $comment_type = $comment->comment_type;
                    $comment_parent = $comment->comment_parent;
                    if ('product' == get_post_type($post_id) && $comment_type == 'review' && $comment_parent == 0) {
                        update_comment_meta($comment->comment_ID, 'verified', 1);
                    }
                    wp_send_json_success();
                }
            }
            wp_send_json_error();
            die();
        }

        function set_upload_dir( $upload ) {
            $upload['subdir'] = '/woocommerce-reviews';
            $upload['path'] = $upload['basedir'] . $upload['subdir'];
            $upload['url']  = $upload['baseurl'] . $upload['subdir'];
            return $upload;
        }

        function remove_default_image_sizes( $sizes) {

            $review_size = array();
            if(isset($sizes['thumbnail'])) $review_size['thumbnail'] = $sizes['thumbnail'];

            return $review_size;
        }

        private static function create_files() {
            $upload_dir      = wp_upload_dir();

            $files = array(
                array(
                    'base'    => $upload_dir['basedir'] . '/woocommerce-reviews',
                    'file'    => 'index.html',
                    'content' => '',
                ),
                array(
                    'base'    => $upload_dir['basedir'] . '/woocommerce-reviews',
                    'file'    => 'index.html',
                    'content' => '',
                ),
            );

            foreach ( $files as $file ) {
                if ( wp_mkdir_p( $file['base'] ) && ! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) ) {
                    $file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'w' );
                    if ( $file_handle ) {
                        fwrite( $file_handle, $file['content'] );
                        fclose( $file_handle );
                    }
                }
            }
        }

        function devvn_woocommerce_comment_pagination_args($args){
            if(is_singular('product')) {
                $args['add_fragment'] = '#reviews';
            }
            return $args;
        }

        function get_like_review($comment){
            global $devvn_review_settings;
            if($devvn_review_settings['show_like'] == '2') return false;
            $like_count = get_comment_meta($comment->comment_ID, 'devvn_like_cmt', true);
            ?>
            <span> • </span>
            <a href="javascript:void(0)" class="cmtlike" data-like="<?php echo $like_count;?>" data-id="<?php echo $comment->comment_ID;?>" title=""><span class="cmt_count"><?php echo ($like_count) ? $like_count : '';?></span> <?php _e('thích', 'devvn-reviews');?></a>
            <?php
        }
        function devvn_like_cmt_func(){
            global $devvn_review_settings;
            $id = isset($_POST['id']) ? intval($_POST['id']) : '';
            if(!$id || !get_comment($id) || $devvn_review_settings['show_like'] == '2') wp_send_json_error();
            $like_count = intval(get_comment_meta($id, 'devvn_like_cmt', true));
            update_comment_meta($id, 'devvn_like_cmt', $like_count + 1);
            wp_send_json_success();
            die();
        }

    }
}
function devvn_reviews(){
    return DevVN_Reviews_Class::init();
}
devvn_reviews();

if(!function_exists('woocommerce_comments')) {
    function woocommerce_comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment; // WPCS: override ok.
        include trailingslashit(plugin_dir_path(__FILE__)) . 'templates/review.php';
    }
}
if(!function_exists('woocommerce_review_display_meta')) {
    function woocommerce_review_display_meta()
    {
        include trailingslashit(plugin_dir_path(__FILE__)) . 'templates/review-meta.php';
    }
}
if(!function_exists('devv_check_reviews_admin')) {
    function devv_check_reviews_admin($roles)
    {
        $qtv = false;
        $allow_roles = apply_filters('roles_reviews_admin', array('administrator', 'shop_manager', 'author'));
        if($roles && is_array($roles)){
            foreach ($roles as $role){
                if(in_array($role, $allow_roles)){
                    $qtv = true;
                    continue;
                }
            }
        }
        return $qtv;
    }
}