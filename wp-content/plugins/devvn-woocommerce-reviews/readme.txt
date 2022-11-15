/*
* Plugin DevVN Woocommerce Reviews
* Author: https://levantoan.com
*/

add_filter('wc_get_template', 'custom_wc_get_template', 20, 2);
function custom_wc_get_template($template, $template_name){
    global $devvn_review_settings;
    if($template_name == 'loop/rating.php' && $devvn_review_settings['loop_rating']){
        $template = get_stylesheet_directory() . '/devvn-reviews/loop-rating.php';
    }
    return $template;
}

add_filter('wp_is_comment_flood', '__return_false', 20);

//Xóa sub menu khỏi menu trong admin
function remove_reviews_admin_menu() {
    remove_submenu_page( 'woocommerce', 'devvn-woocommerce-reviews' );
}
add_action( 'admin_menu', 'remove_reviews_admin_menu', 999 );


add_filter('devvn_reviews_file_extensions', 'custom_devvn_reviews_file_extensions');
function custom_devvn_reviews_file_extensions($ext){
    $ext[] = 'webp';
    return $ext;
}
add_filter('devvn_reviews_image_mime_types', 'custom_devvn_reviews_image_mime_types');
function custom_devvn_reviews_image_mime_types($mime_types){
    $mime_types[] = 'image/webp';
    return $mime_types;
}

== Những thay đổi ==

= V1.4.1 - 04.11.2022 =

* Fix select2 với woo và wp cũ

= V1.4.0 - 03.11.2022 =

* Fix lỗi tương thích với WordPress 6.1 và Woo 7.x.x
* Thêm lựa chọn sản phẩm cụ thể để đánh giá tự động
* Thêm lựa chọn sản phẩm chưa có đánh giá để đánh giá tự động
* Thêm filter devvn_auto_reviews_args để custom các thông số trước khi chạy đánh giá sản phẩm tự động

= V1.3.9 - 22.08.2022 =

* Sửa lỗi không hiện SĐT trong câu hỏi/đáp của sản phẩm
* add hook

<?php do_action('devvn_before_review_comment', $product);?>
<?php do_action('devvn_mid_review_comment', $product);?>
<?php do_action('devvn_after_review_comment', $product);?>

để chèn thêm dữ liệu mong muốn vào form reviews

/*kadence Theme*/
.woocommerce #reviews #comments {
    width: 100%;
    padding: 0;
}
div#reviews.woocommerce-Reviews {
    border-bottom: 0;
}
.star_box {
    background: #fff;
}
#review_form .comment-form-rating label, .woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating label {
    font-size: 14px;
}
#review_form .comment-form-rating p.stars a:before, .woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars a:before {
    content: "\e901" !important;
}
.comment-form ::placeholder {
    opacity: 1 !important
}
/*kadence Theme*/

= V1.3.8 - 25.07.2022 =

* Fix lazyload ảnh avatar khi bật chức năng lazyload của Flatsome

= V1.3.7.1 - 15.07.2022 =

* Fix nhanh css lỗi bị ẩn chức năng thẻ đánh giá nhanh với bản Woo mới

= V1.3.7 - 14.07.2022 =

* Tương thích với Woo 6.7.x
* Thêm phân trang reviews bằng ajax
* Thêm rel=nofollow vào link phân trang reviews
* Thêm chức năng "hiển thị thông tin sản phẩm" bên ngoài danh sách đánh giá ở Shortcode [devvn_list_reviews]
* Fix một số lỗi nhỏ

= V1.3.6.1 - 25.06.2022 =

* Fix nhanh chức năng đánh giá nhanh khi chưa nhập các thẻ đánh giá trong setting

= V1.3.6 - 24.06.2022 =

* Fix lỗi icon loading khi đăng reviews không quay
* Thêm tuỳ chọn cho phép chọn "Danh mục sản phẩm" cụ thể khi "Tự động đánh giá"
* Thêm "Thẻ đánh giá nhanh" trong reviews. Cho phép khách chọn trong lúc đánh giá mà không cần nhập nội dung
* Fix lỗi mất active license ở 1 số hosting

= V1.3.5 - 12.02.2022 =

* Fix lỗi up ảnh đánh giá trong admin với 1 số theme
* Thêm hook flatsome_before_comments để tương thích với theme flatsome
* Thêm filter devvn_reviews_upload_dir để custom lại thư mục upload ảnh. apply_filters('devvn_reviews_upload_dir', $upload, $old_dir);

= V1.3.4 - 13.12.2021 =

* Cho phép nhập số reviews trong 1 khoảng cho trước khi đánh giá / 1 sản phẩm
* Cho phép nhập ngày trong khoảng cho trước của reviews. nếu ngày đó lớn hơn ngày hiện tại thì comment sẽ ở trạng thái chờ chấp nhận và hệ thống sẽ tự động đăng reviews trong tương lai

= V1.3.3 - 12.12.2021 =

* Thêm chức năng tự động review tất cả sản phẩm. Lấy ngẫu nhiên tên, nội dung reviews theo nội dung cho trước

= V1.3.2 - 03.11.2021 =

* Tối ưu schema. Nếu sử dụng "Rank math" hoặc "yoast seo: Woocommerce" addon thì không cần bật chức năng này
* Tối ưu chức năng cho hiện ngôi sao khi chưa có đánh giá nào trong chi tiết sản phẩm

= V1.3.1.1 - 13.10.2021 =

* Fix nhanh lỗi hiển thị ở V1.3.1

= V1.3.1 - 12.10.2021 =

* Thêm điều kiện kiểm tra ảnh có tồn tại hay không mới hiển thị comment trong danh sách ảnh feedback từ khách hàng
* Fix lỗi hiển thị hình ảnh của sản phẩm khác khi ấn xem thêm hình ảnh từ khách hàng
* Hiển thị đánh giá và số đã bán kể cả khi không có đánh giá

= V1.3.0.1 - 06.10.2021 =

* fix nhanh lỗi js với 1 số theme trong bản 1.3.0

= V1.3.0 - 06.10.2021 =

* Thêm option hiển thị đánh giá sao ra ngoài trang danh mục khi không có đánh giá
* Hiển thị danh sách "hình ảnh từ khách hàng" bên dưới khung đánh giá
* Thêm số điện thoại vào nội dung email thông báo có đánh giá mới
* Tối ưu hóa bản dịch tiếng Việt
* Thêm 2 action vào trước form reviews before_devvn_reviews_title và sau form reviews after_devvn_reviews_form

= V1.2.9 - 13.09.2021 =

* Thêm reset số lượng đã bán của tất cả sản phẩm về 0
* Tối ưu lại chức năng fake số lượng đã bán khi chạy với nhiều sản phẩm

= V1.2.8 - 29.08.2021 =

* Fix schema với Rank Math
* Sửa bản dịch tiếng Việt

= V1.2.7 - 28.08.2021 =

* fix 1 số css và js với 1 số theme
* Fix lỗi cảnh báo với roles tại review-meta.php
* Sửa lỗi hiển thị tên trong popup
* Thêm tab Schema Product. Mục đích để fix lỗi thiếu 1 số trường trong schema
* Thêm chức năng "hiển thị số đánh giá" bên ngoài trang sản phẩm bên cạnh các ngôi sao

/*YOOTheme*/
.devvn_prod_cmt, .devvn_prod_cmt *, #reviews, #reviews * {
    box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
}
div#reviews .woocommerce-Reviews-title:before {
    display: none;
}
.devvn-star:before {
    font-family: WooCommerce;
    content: "\e020";
    color: #ffad4f;
}
#review_form .comment-form-rating p.stars a:before, .woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars a:before {
    font-family: WooCommerce;
}
.form_row_reviews>p {
    margin: 0;
}
textarea#devvn_cmt_content {
    border: 1px solid #c1bfbf;
    width: 100%;
}
#reviews .star-average .star-rating {
    margin-right: 10px;
}
#reviews .commentlist .comment_container {
    padding: 0;
}
.devvn_review_mid .star-rating {
    float: none !important;
}
/*#YOOTheme*/

= V1.2.6 - 08.08.2021 =

* Thêm: Mặc định bỏ load js ngoài trang chủ hoặc có thể dùng filter devvn_script_include_from_front_page để custom
* Thêm filter 'devvn_reviews_allow_image_sizes' để custom thêm/bớt các ảnh sẽ được sinh ra khi thêm reviews kèm hình ảnh. Mặc định có thumbnail và shop_single
* Thêm shortcode để hiển thị reviews ở bất kỳ chỗ nào bạn muốn theo dạng mansony. Có thể tùy biến hiện toàn bộ reviews hoặc của 1 sản phẩm nào đó
* Cho phép sửa hình ảnh review trong admin
* Cho phép update số lượt thích review, comment trong admin
* Tối ưu lại chức năng update
* Fix 1 số lỗi nhỏ

= V1.2.5 - 27.05.2021 =

* Add: Thêm js hỗ trợ chức năng trả lời comment ở 1 số theme chưa hỗ trợ
* Fix: Sửa 1 số lỗi js và css trên mobile
* Fix: Sửa lại điều kiện để active license khi không sử dụng woocommerce

= V1.2.4 - 22.03.2021 =

* Add: Thêm chức năng ẩn/hiện avatar trong phần hỏi đáp
* Fix: Sửa lỗi không hiển thị comment mà admin trả lời trong quản trị đối với mục hỏi đáp
* Fix: 1 số lỗi nhỏ

= V1.2.3 - 02.02.2021 =

* Thêm điều kiện để không bắt buộc sđt theo format Vietnam

= V1.2.2 - 13.12.2020 =

* Fix: Sửa lỗi thêm sđt vào post comment
* Add: Thêm style cho review
* Fix: WordPress 5.6 và Woocommerce 4.8.x

= V1.2.1 - 09.10.2020 =

* Custom giao diện phần bình luận trong post và page. Hoặc muốn custom post type nào khác thì dùng code sau
    add_filter('devvn_post_comment_template', 'custom_devvn_post_comment_template');
    function custom_devvn_post_comment_template($cpt){
        $cpt[] = 'your_post_type';//Thêm hoặc thay bằng cpt của bạn
        return $cpt;
    }
* Sửa số điện thoại của comment trong admin
* Fix lại check license để phù hợp với 1 số trường hợp đặc biệt. Và không xóa key khi hết thời gian license
* Có thể copy file single-product-reviews.php sang theme để có thể tùy biến theo ý. Đường dẫn file ở theme như sau wp-content/themes/{YOUR-THEME}/devvn-reviews/single-product-reviews.php
* Thay đổi tiêu đề phần đánh giá từ h2 sang div

/*Css for oceanwp theme*/
body .star-average .woocommerce-product-rating .star-rating {
    float: none !important;
    margin: 0 10px 0 0 !important;
}
.woocommerce #reviews #comments ol.commentlist li .comment_container {
    padding-left: 0;
    border-bottom: 0;
    margin-bottom: 0;
    min-height: auto;
}
body .devvn_review_mid .star-rating {
    float: none !important;
    display: inline-block !important;
}
.woocommerce #review_form input#wp-comment-cookies-consent {
    min-height: auto !important;
    height: auto !important;
    float: left !important;
    line-height: 1 !important;
    margin: 0 5px 0 0 !important;
    position: relative;
    top: 6px;
}
#review_form .comment-form-rating p.stars a:before, .woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars a:before {
    content: '\53' !important;
    color: #fe9727 !important;
}
/*#Css for oceanwp theme*/


/*Css for shopinia theme*/
div#reviews.woocommerce-Reviews, div#reviews.woocommerce-Reviews *,
.devvn_prod_cmt, .devvn_prod_cmt * {
    box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
}
.woocommerce .devvn_review_mid .star-rating span:before,
.woocommerce-page .devvn_review_mid .star-rating span:before,
.wpb_wl_summary .devvn_review_mid .star-rating span:before{
	font-size: 11px;
}
.summary.entry-summary .woocommerce-product-rating {
    display: block;
    float: none;
}
.summary.entry-summary .woocommerce-product-rating .star-rating {
    float: none;
    position: relative;
    top: -3px;
}
div#reviews.woocommerce-Reviews, .devvn_prod_cmt {
    max-width: 100%;
}
div#reviews div#comments {
    border-bottom: 0!important;
    height: auto;
    overflow: unset;
    margin: 0 !important;
    width: 100% !important;
    float: none !important;
}

body .star-average .woocommerce-product-rating .star-rating span::before {
    font-size: 22px;
}
body.woocommerce #reviews .star-rating {
    height: 22px;
    margin: 0;
}
form#commentform input, form#commentform textarea,
.devvn_cmt_form input, .devvn_cmt_form textarea {
    font-family: 'Roboto', sans-serif;
}
form#commentform input, form#commentform textarea {
    margin-bottom: 5px;
}
.form_row_reviews > p {
    margin-bottom: 0 !important;
}
/*#Css for shopinia theme*/

/*Css for freshio theme*/
body .star-average .woocommerce-product-rating {
    align-items: center;
}
#reviews .commentlist li .comment_container .comment-text {
    width: unset;
    float: none;
}
.devvn-star:before,
#review_form .comment-form-rating p.stars a:before{
    font-family: 'star' !important;
    content: '\53\00a0';
}
#commentform {
    display: block;
    margin: 0;
}
#commentform p {
    padding: 0;
    padding-right: 10px;
}
/*#Css for freshio theme*/

/*Css for rehub theme*/
.devvn-star:before {
    content: "";
    font-style: normal;
    font-family: 'Font Awesome\ 5 Pro';
    font-weight: 900;
}
.comment-form-rating p.stars > span {
    display: block !important;
    background: none;
    height: inherit;
    float: none;
}
.comment-form-rating p.stars > span a {
    padding: 0;
    background: none !important;
}
#review_form .comment-form-rating p.stars a:before, .woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars a:before {
    content: "";
    font-style: normal;
    font-family: 'Font Awesome\ 5 Pro';
    font-weight: 900;
}

/*#Css for rehub theme*/

/*Css for woodmart theme*/
.woocommerce-Reviews #comments, .woocommerce-Reviews #review_form_wrapper {
    flex: 0 1 100%;
    max-width: 100%;
}
body .star-average .woocommerce-product-rating .star-rating {
    font-size: 14px;
}
.devvn-star:before,
#review_form .comment-form-rating p.stars a:before, .woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars a:before {
    content: "\f148";
    font-family: "woodmart-font";
}
body.woocommerce #reviews #comments ol.commentlist li .comment-text {
    display: block;
}
body.woocommerce #reviews .star-rating {
    font-size: 14px;
    margin: 0 6px 4px 0;
}
body.woocommerce #reviews #comments ol.commentlist ul.children {
    border: 0;
}
.form-style-rounded .devvn_cmt_input textarea {
    border-radius: 0;
}
.wrap-attaddsend {
    width: 100%;
}
.woocommerce #review_form #respond textarea, .woocommerce #reviews #comments ol.commentlist #respond textarea {
    border-radius: 0;
	min-height: auto;
}
div#comments {
    padding-left: 0 !important;
    padding-right: 0 !important;
}
div#respond input#wp-comment-cookies-consent {
    display: inline-block;
    width: auto !important;
}
.devvn_cmt_input textarea {
    min-height: auto;
}
/*#Css for woodmart theme*/

/*Css for moz theme*/
.woocommerce .star-rating span{
    font-family: star;
}
.woocommerce .woocommerce-product-rating .star-rating {
    margin-top: 0 !important;
}
.star-average {
    margin-bottom: 10px;
}
.woocommerce #reviews #comments ol.commentlist {
    padding: 0;
}
.woocommerce .woocommerce-product-rating {
    line-height: 1;
}
/*#Css for moz theme*/

= V1.2.0 - 08.06.2020 =

* Thêm filter "devvn_id_faq" để custom ID mục hỏi đáp. mặc định là hoi-dap
* Thêm filter "devvn_headings_faq" để custom headings tag của tiêu đề hỏi đáp. mặc định là strong
* Xóa transient khi có hỏi đáp mới

= V1.1.8 - 09.05.2020 =

* Loại bỏ label đã mua hàng trong reviews của admin

= V1.1.7 - 03.05.2020 =

* Thêm ẩn SĐT trên phần reivews
* Fix Hiển thị trường nhập số lượng đã bán ở sản phẩm biến thể
* Thêm chức năng Fake số lượng đã bán theo số reviews hoặc theo khoảng nào đó cho toàn bộ sản phẩm
* Fix FAQPage Schema khi chưa có câu trả lời nào

/*Css for basel theme*/
body.woocommerce #reviews .star-rating {
    font-size: 12px !important;
}
.devvn-star::before,
#review_form .comment-form-rating p.stars a:before, .woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars a:before {
    content: "\f905";
    font-family: basel-font;
}
.commentlist .comment_container, .commentlist .review_comment_container {
    padding: 0;
}
body.woocommerce #reviews #comments ol.commentlist ul.children {
    margin: 0;
}
body.woocommerce #reviews #comments ol.commentlist ul.children li {
    border-top: 0;
}
.commentlist .comment_container, .commentlist .review_comment_container {
    min-height: inherit;
}
.commentlist .comment-text .star-rating {
    float: left;
    margin-bottom: 0;
}
body.woocommerce #reviews #comments ol.commentlist #respond {
    margin: 0;
    background: #fff;
    padding: 10px;
}
.single-product-content #comments {
    width: 100%;
    padding: 20px 0;
}
/*#Css for basel theme*/

= V1.1.6 - 19.04.2020 =

* Fix số điện thoại bị lỗi bắt buộc khi đã login
* Thay lại cách active license
* Thêm cấu trúc FAQPage cho phần hỏi đáp. (Option)

= V1.1.5 - 03.04.2020 =

* Thêm tùy chọn hiện ô nhập số điện thoại tại khung bình luận
* Thêm tùy chọn hiển thị số điện thoại bên cạnh tên khách hàng ở đánh giá và bình luận
* Thêm tùy chọn hiển/ẩn trường email ở khung bình luận

= V1.1.4 - 21.03.2020 =
- Fix chức năng update
- Tương thích với Woo 4.0.x
- Hiển thị thêm số lượng đã bán sản phẩm
- Có thể sử dụng shortcode [devvn_sold] để hiển thị chỗ bạn muốn. Giá trị id tùy chỉnh.

    /*Css for Captiva theme*/
    .woocommerce .container #reviews .star-rating, .woocommerce-page .container #reviews .star-rating {
        margin: 0;
    }
    i.devvn-star {
        background: url(https://tpevietnam.com/wp-content/themes/captiva/images/icons/star-on.png) repeat-x center left;
        height: 15px;
        font-size: 0;
        width: 15px;
        display: inline-block;
    }
    .devvn-star:before {
        display: none;
    }
    .woocommerce .container #reviews #comments ol.commentlist li, .woocommerce-page .container #reviews #comments ol.commentlist li, .content-area #comments ol.commentlist li, #comments ol.comment-list li {
        padding-left: 0 !important;
        padding-top: 0 !important;
        border-top: 0 !important;
    }
    body.woocommerce #reviews #comments ol.commentlist ul.children li {
        list-style: none;
    	padding-left: 10px !important;
    }
    body.woocommerce #reviews #comments ol.commentlist ul.children {
        margin: 0 !important;
        list-style: none !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    .woocommerce #review_form #respond p.form-submit input#submit, .woocommerce #reviews #comments ol.commentlist #respond p.form-submit input#submit {
        background-color: #03a0e2 !important;
        color: #fff !important;
    }
    #review_form #respond .comment-form-rating .stars a:before {
        display: none;
    }
    #review_form #respond .comment-form-rating .stars > span {
        background: none;
    }
    #review_form #respond .comment-form-rating .stars a {
        background: url(https://tpevietnam.com/wp-content/themes/captiva/images/icons/star-on.png) no-repeat center top;
    	height: 63px;
        padding-top: 20px;
        text-decoration: none;
    }

    .woocommerce p.stars.selected a:not(.active),#review_form .comment-form-rating p.stars.selected a,.woocommerce #reviews #comments ol.commentlist #respond p.stars.selected a:not(.active),.woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars.selected a {
        background: url(https://tpevietnam.com/wp-content/themes/captiva/images/icons/star-on.png) no-repeat center top !important;
    }

    #review_form .comment-form-rating p.stars.selected a.active~a,.woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars.selected a.active~a {
        background: url(https://tpevietnam.com/wp-content/themes/captiva/images/icons/star-off.png) no-repeat center top !important;
    }

    #review_form .comment-form-rating p.stars:hover a,.woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars:hover a {
        background: url(https://tpevietnam.com/wp-content/themes/captiva/images/icons/star-on.png) no-repeat center top !important;
    }

    #review_form .comment-form-rating p.stars a:hover~a,.woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars a:hover~a {
        background: url(https://tpevietnam.com/wp-content/themes/captiva/images/icons/star-off.png) no-repeat center top !important;
    }
    #review_form .comment-form-rating p.stars.selected a.active~a:hover,.woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars.selected a.active~a:hover {
        background: url(https://tpevietnam.com/wp-content/themes/captiva/images/icons/star-on.png) no-repeat center top !important;
    }
    /*#Css for Captiva theme*/

= V1.1.3 - 15.02.2020 =
* Phân trang ở phần bình luận/hỏi - đáp
* Bắt buộc kích hoạt Extension ionCube Loader
* Bắt buộc version PHP >=7.2
* Gửi review bằng Ajax
* Thêm avatar trong reviews
* Thêm link edit comment ở mỗi comment
* Thêm shortcode [devvn_reviews] để hiển thị comments_template
* Fix js + css với theme porto
    /*Css for Porto theme*/
    div#reviews.woocommerce-Reviews, .devvn_prod_cmt {
        max-width: 100%;
    }
    .devvn-star:before {
        content: "";
        font-style: normal;
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
    }
    form#commentform {
        padding: 0;
        background: #fff;
    }
    #review_form .comment-form-rating p.stars a:before, .woocommerce #reviews #comments ol.commentlist #respond .comment-form-rating p.stars a:before {
        content: "";
    }
    .single-product .star_box .woocommerce-product-rating:after {
        display: none;
    }
    #reviews .commentlist li {
        padding-left: 0;
    }
    .commentlist li .comment-text {
        background: #fff;
    }
    #reviews .commentlist li .comment-text:before {
        display: none;
    }
    .commentlist li .comment-text p {
        font-size: 14px;
    }
    #reviews .commentlist li .star-rating {
        float: none;
    }
    /*#Css for Porto theme*/

= V1.1.2 - 02.12.2019 =

* Add: Thêm chức năng bật "cho phép đánh giá" cho toàn bộ sản phẩm
* Add: Thêm chức năng hỗ trợ lên lịch đăng review khi import bằng csv. Theo hướng dẫn này https://www.youtube.com/watch?v=85l4Juyeu_s
       Nghĩa là khi import mà ngày review lớn hơn ngày hiện tại thì review đó sẽ được lên lịch đăng mà không đăng ngay lúc import

= V1.1.1 - 19.11.2019 =
* Tắt transient cho bộ đếm số sao đánh giá
* Thêm language cho plugin. Mặc định là tiếng anh, đã có sẵn tiếng việt và .pot
* Sửa lỗi khi chọn nhiều ảnh quá dung lượng cho phép thì không hể up tiếp các ảnh sau

= V1.1.0 - 29.10.2019 =
* Fix: Sửa lỗi không up được ảnh khi sử dụng safari trên iphone
* Update: Thêm option số lượng hình ảnh được up lên khi đánh giá. Mặc định là 3 hình

= V1.0.9 - 04.10.2019 =

* Add: Thêm nút thích trong từng review và bình luận (Option)
* Update: Có thể sửa label "Đã mua hàng tại..."

= V1.0.8 - 26.09.2019 =

* Fix: Chuyển trang comment sẽ nhảy tới đúng mục comment trong trang hiện tại
* Add: Ẩn ngày đánh giá và bình luận (tùy chỉnh)
* Add: Thêm chức năng tắt bình luận. Chỉ để đánh giá sản phẩm
* Add: Thêm chức năng fake label đã mua hàng cho từng review trong admin

= V1.0.7 - 10.08.2019 =

* Fix: Đếm lại tổng số review. đã loại trừ các review của admin trả lời trong admin

= V1.0.6  - 05.08.2019 =
* New: Thêm công cụ fake label xác nhận đã mua hàng
* Update: Thêm hiển thị list hình ảnh trong admin để dễ quản lý
* Add: Thêm ô nhập tên action để tùy biến vị trí reviews
* Update: Thêm tính năng bỏ upload ảnh khi đánh giá
* Fix: 1 số lỗi nhỏ

= V1.0.5  - 04.08.2019 =
* New: Thay đổi folder upload hình ảnh thành wp-content/uploads/woocommerce-reviews
* New: Loại bỏ các size ảnh khác chỉ để lại thumbnail và full size khi upload ảnh trong comment. Sẽ tối ưu số ảnh và dụng lượng cho hosting của bạn
* Add: Thêm chức năng chuyển đổi từ review cũ của website để tương thích với plugin
* Add: Thêm label "Quản trị viên" cho phần reviews

= V1.0.4  - 03.08.2019 =
* Update: Thêm phần chú ý sau khi cài đặt. Bỏ bắt buộc email trong setting https://levantoan.com/san-pham/devvn-woocommerce-reviews/#chu-y
* Fix: Sửa một số cảnh báo nhỏ

= V1.0.3  - 02.08.2019 =
* Fix: Sủa lỗi trả lời nhanh trong admin không hiện ra bên ngoài

= V1.0.2  - 02.08.2019 =
* Update: Thêm ô nhập vị trí ưu tiên hiển thị
* Fix: 1 số lỗi css trên flatsome theme

= V1.0.1  - 02.08.2019 =
* Fix: Sửa lỗi thiếu thư viện js wp.template

= V1.0.0 - 01.08.2019 =
* Ra mắt plugin