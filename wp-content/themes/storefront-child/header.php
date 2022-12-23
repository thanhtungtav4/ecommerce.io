<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <link id="favicon" rel="icon" type="image/svg+xml" href="<?php echo get_stylesheet_directory_uri() ?>/assets/images/favicon.png">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/style.css">
	<link rel="preload" as="style" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
	</noscript>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="container">
      <header class="c-header">
        <?php if(!wp_is_mobile()) : ?>
        <div class="c-header_top">
          <div class="l-container">
            <p>Freeship nội thành cho đơn&nbsp;<span>từ 250.000đ</span> – Tỉnh&nbsp;<span>từ 400.000đ</span></p>
          </div>
        </div>
        <?php endif; ?>
        <div class="c-header_bottom">
          <div class="l-container c-header_inner">
            <div class="c-header_logo"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE : print get_site_url().'/');   ?>">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo.webp" type="image/webp">
									<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo.png" alt="caras logo">
                </picture>
							</a>
						</div>
            <ul class="c-header_menu">
              <li class="c-menu c-menu_dropdown">
                <a href="https://caraslens.com/best-seller-contact-lenses/">Best Seller</a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
                        <dt>
                        <dd>
													<a href="https://caraslens.com/lens-trong-suot/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_clear.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_clear.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_clear.jpg" alt="best_437x200_clear">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                      <dl>
											<dt>
                        <dd>
													<a href="https://caraslens.com/lavier/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_lavier.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_lavier.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_lavier.jpg" alt="best_437x200_lavier">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                      <dl>
											<dt>
                        <dd>
													<a href="https://caraslens.com/amber/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_ombre.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_ombre.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_ombre.jpg" alt="best_437x200_ombre">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="/contact-lens/">Kính Áp Tròng</a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-5">
                    <dl>
                        <dt><?php _e('FOR INDIVIDUAL NEEDS', 'storefront') ?></dt>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/contact-lens-for-men/' : print get_site_url().'/lens-nu/');   ?>"><?php _e('Lens Women', 'storefront') ?></a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/contact-lenses-for-women/' : print get_site_url().'/lens-nam/');   ?>"><?php _e('Lens Men', 'storefront') ?></a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/contact-lenses-for-casual-occasions/' : print get_site_url().'/lens-deo-di-hoc-va-di-lam/'); ?>">Lens sáng nhẹ</a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/contact-lenses-for-special-occasion/' : print get_site_url().'/lens-deo-chup-anh-va-du-tiec/'); ?>">Lens sáng tây</a></dd>
                      </dl>
                      <div class="gr-menu">
                        <dl>
                          <dt><?php _e('Eye Refraction', 'storefront') ?></dt>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-can-thi/'); ?>">Lens cận</a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-loan-thi/'); ?>">Lens loạn</a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-can-loan/'); ?>">Lens cận loạn</a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-vien-thi/'); ?>">Lens viễn</a></dd>
                        </dl>
                        <dl class="sp-only time-use">
                          <dt><?php _e('BY FREQUENCY', 'storefront') ?></dt>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-8-tieng/'); ?>">8h</a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-10-tieng/'); ?>">10h</a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-12-tieng/'); ?>">12h</a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-14-tieng/'); ?>">14h</a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-24-tieng/'); ?>">24h</a></dd>
                        </dl>
                      </div>
                      <div class="gr-menu">
                        <dl class="types">
                          <dt><?php _e('Glass Type', 'storefront') ?></dt>
                          <dd class="pc-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-3-thang/'); ?>">3 tháng</a></dd>
                          <dd class="pc-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-1-ngay/'); ?>">1 ngày</a></dd>
                          <dd class="sp-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-3-thang/'); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_3month.png" alt="3 tháng"></a></dd>
                          <dd class="sp-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-1-ngay/'); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_1month.png" alt="1 ngày"></a></dd>
                          <dt>Size</dt>
                          <dd class="pc-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-13-6mm-13-8mm/'); ?>">Tự nhiên - 13.8mm</a></dd>
                          <dd class="pc-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-14mm/'); ?>">Giãn nhẹ - 14.0 mm</a></dd>
                          <dd class="sp-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-13-6mm-13-8mm/'); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_13mm.png" alt="Tự nhiên - 13.8mm">Tự nhiên</a></dd>
                          <dd class="sp-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-14mm/'); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_14mm.png" alt="Giãn nhẹ - 14.0 mm">Giãn nhẹ</a></dd>
                        </dl>
                        <dl class="color">
                          <dt><?php _e('BY COLOR', 'storefront') ?></dt>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-mau-nau/'); ?>">Nâu</a></dd>
                          <dd><a class="is-gray" href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-mau-xam/'); ?>">Xám</a></dd>
                          <dd><a class="is-choco" href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-mau-choco/'); ?>">Choco</a></dd>
                          <dd><a class="is-clear" href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-trong-suot/'); ?>">Clear</a></dd>
                        </dl>
                      </div>
                      <dl class="pc-only">
                      <dt><?php _e('BY FREQUENCY', 'storefront') ?></dt>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-8-tieng/'); ?>">8h</a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-10-tieng/'); ?>">10h</a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-12-tieng/'); ?>">12h</a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-14-tieng/'); ?>">14h</a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/deo-24-tieng/'); ?>">24h</a></dd>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown">
                <a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/phu-kien-lens/'); ?>">Phụ Kiện</a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
											<dt>
                        <dd>
													<a href="/nuoc-ngam-kinh-ap-trong/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_ngam.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_ngam.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_ngam.png" alt="accessory_dd_ngam">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                      <dl>
											<dt>
                        <dd>
													<a href="/thuoc-nho-mat-lens/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_nho.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_nho.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_nho.png" alt="accessory_dd_nho">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                      <dl>
											<dt>
                        <dd>
													<a href="/dd-vitamin/">
                          <picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_vitamin.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_vitamin.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_vitamin.jpg" alt="accessory_dd_vitamin">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="#">Dịch Vụ</a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
                        <dt>Showroom</dt>
                        <dd>
													<a href="https://caraslens.com/lien-he/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_showroom.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_showroom.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_showroom.jpg" alt="dv_showroom">
													</picture>
													</a>
												</dd>
                      </dl>
                      <dl>
                        <dt>Đo mắt miễn phí
												<dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_do_mat.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_do_mat.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_do_mat.jpg" alt="dv_do_mat">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                      <dl>
                        <dt>Tư vấn online
												<dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_tu_van_online.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_tu_van_online.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_tu_van_online.jpg" alt="dv_tu_van_online">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="">Thông Tin</a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
                        <dt>Giới thiệu CARAS</dt>
                        <dd>
													<a href="/gioi-thieu/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_gioi_thieu_caras.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_gioi_thieu_caras.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_gioi_thieu_caras.jpg" alt="thong_tin_gioi_thieu_caras">
													</picture>
													</a>
												</dd>
                      </dl>
                      <dl>
                        <dt>Hướng Dẫn Sử Dụng
												<dd>
													<a href="/cach-deo-lens/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_hdsd.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_hdsd.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_hdsd.jpg" alt="thongtin_hdsd">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                      <dl>
                        <dt>Blog
												<dd>
													<a href="/blog">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thong_tin_blog.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thong_tin_blog.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thong_tin_blog.jpg" alt="thong_tin_blog">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <?php if(is_user_logged_in() && wp_is_mobile()) : ?>
                <li class="c-menu"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><strong><?php echo wp_get_current_user()->user_login; ?></strong></a></li>
                <li  class="c-menu"><a href="http://"><strong><?php _e('Tracking order', 'storefront') ?></strong></a></li>
                <li  class="c-menu"><a href="<?php echo wc_logout_url() ?>"><strong><?php _e('Logout', 'storefront') ?></strong></a></li>
                <?php elseif(!is_user_logged_in()  && wp_is_mobile()) :?>
                <li  class="c-menu"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><strong><?php _e('Login', 'storefront') ?></strong></a></li>
                <li  class="c-menu"><a href="<?php echo apply_filters( 'wpml_permalink', home_url('/'). 'dang-ky', apply_filters( 'wpml_current_language', NULL ) );  ?>"><strong><?php _e('Create an account', 'storefront') ?></strong></a></li>
              <?php endif ;?>
              <?php if(wp_is_mobile()) : ?>
                <li  class="cart c-menu">
                  <a class="" href="<?php echo apply_filters( 'wpml_permalink', home_url('/'). 'gio-hang', apply_filters( 'wpml_current_language', NULL ) );  ?>"><strong>
                    <?php _e('Cart', 'storefront') ?></strong>
                    <?php
                      if (function_exists( 'WC' ) ) {
                        if(WC()->cart->cart_contents_count >= 1){
                          echo '<span class="m-cart_num" id="m-cart_num">';
                          echo (WC()->cart->cart_contents_count);
                          echo '</span>';
                        }
                      }
                      ?>
                  </a>
                </li>
              <?php endif ;?>
            </ul>
            <ul class="c-header_icon">
              <li class="navbar only-sp" onclick="toggleMenu()">
                <svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 3V0H27.5V3H0.5ZM0.5 10.5H27.5V7.5H0.5V10.5ZM0.5 18H27.5V15H0.5V18Z" fill="#737373" ></path>
                </svg>
              </li>
              <li class="logo only-sp">
                  <a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE : print get_site_url().'/');   ?>">
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.webp" type="image/webp">
                    <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.png" alt="caras logo" loading="lazy" width="110" height="45">
                  </a>
              </li>
              <li class="search c-menu_dropdown"><a class="icon_inner" href="#">
                  <svg width="30" height="30" viewBox="0 0 36 36" fill="#737373" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#737373" fill-rule="evenodd" clip-rule="evenodd" d="M22.4475 21.3826H23.6325L31.1175 28.8826L28.8825 31.1176L21.3825 23.6326V22.4476L20.9775 22.0276C19.2675 23.4976 17.0475 24.3826 14.6325 24.3826C9.24751 24.3826 4.88251 20.0176 4.88251 14.6326C4.88251 9.24757 9.24751 4.88257 14.6325 4.88257C20.0175 4.88257 24.3825 9.24757 24.3825 14.6326C24.3825 17.0476 23.4975 19.2676 22.0275 20.9776L22.4475 21.3826ZM7.88251 14.6326C7.88251 18.3676 10.8975 21.3826 14.6325 21.3826C18.3675 21.3826 21.3825 18.3676 21.3825 14.6326C21.3825 10.8976 18.3675 7.88257 14.6325 7.88257C10.8975 7.88257 7.88251 10.8976 7.88251 14.6326Z"></path>
                  </svg></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <form action="/" method="get">
                      <input type="text" name="s" value="<?php the_search_query(); ?>"  id="search"  placeholder="<?php _e('Search', 'storefront') ?>"><i class="gg-search"></i>
                      <input type="hidden" name="post_type" value="product" />
                    </form>
                  </div>
                </div>
              </li>
              <li class="cart c-menu_dropdown" id="xyz"><a class="icon_inner" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 35 35" version="1.1">
                  <g id="surface1">
                  <path style="stroke:none;fill-rule:nonzero;fill: #737373;fill-opacity:1;" d="M 34.402344 28.285156 L 30.769531 5.410156 C 30.449219 3.378906 28.71875 1.902344 26.664062 1.902344 L 8.335938 1.902344 C 6.28125 1.902344 4.550781 3.378906 4.230469 5.410156 L 0.597656 28.285156 C 0.40625 29.488281 0.753906 30.710938 1.542969 31.636719 C 2.335938 32.566406 3.488281 33.097656 4.707031 33.097656 L 30.292969 33.097656 C 31.511719 33.097656 32.664062 32.566406 33.457031 31.636719 C 34.246094 30.710938 34.59375 29.488281 34.402344 28.285156 Z M 30.960938 29.507812 C 30.863281 29.621094 30.644531 29.816406 30.292969 29.816406 L 4.707031 29.816406 C 4.355469 29.816406 4.136719 29.621094 4.039062 29.507812 C 3.941406 29.390625 3.785156 29.148438 3.839844 28.800781 L 7.46875 5.925781 C 7.539062 5.496094 7.902344 5.183594 8.335938 5.183594 L 26.664062 5.183594 C 27.097656 5.183594 27.460938 5.496094 27.53125 5.925781 L 31.160156 28.796875 C 31.214844 29.148438 31.058594 29.390625 30.960938 29.507812 Z M 30.960938 29.507812 "/>
                  <path style="stroke:none;fill-rule:nonzero;fill: #737373;fill-opacity:1;" d="M 23.269531 7.019531 C 22.363281 7.019531 21.628906 7.753906 21.628906 8.660156 L 21.628906 13.214844 C 21.628906 15.492188 19.777344 17.34375 17.5 17.34375 C 15.222656 17.34375 13.371094 15.492188 13.371094 13.214844 L 13.371094 8.660156 C 13.371094 7.753906 12.636719 7.019531 11.730469 7.019531 C 10.824219 7.019531 10.089844 7.753906 10.089844 8.660156 L 10.089844 13.214844 C 10.089844 17.300781 13.414062 20.625 17.5 20.625 C 21.585938 20.625 24.910156 17.300781 24.910156 13.214844 L 24.910156 8.660156 C 24.910156 7.753906 24.175781 7.019531 23.269531 7.019531 Z M 23.269531 7.019531 "/>
                  </g>
                </svg>
                    <?php
                    if (function_exists( 'WC' ) ) {
                      if(WC()->cart->cart_contents_count >= 1){
                        echo '<span class="m-cart_num" id="m-cart_num">';
                        echo (WC()->cart->cart_contents_count);
                        echo '</span>';
                      }
                    }
                    ?>
                  </a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div  class="cart_inner widget_shopping_cart_content">
                      <?php woocommerce_mini_cart(); ?>
                    </div>
                  </div>
                </div>
              </li>
              <li class="user c-menu_dropdown"><a class="icon_inner" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                  <svg width="38" height="38" viewBox="0 0 38 38" fill="#737373" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#737373" fill-rule="evenodd" clip-rule="evenodd" d="M19 6.33325C15.5008 6.33325 12.6666 9.16742 12.6666 12.6666C12.6666 16.1658 15.5008 18.9999 19 18.9999C22.4991 18.9999 25.3333 16.1658 25.3333 12.6666C25.3333 9.16742 22.4991 6.33325 19 6.33325ZM22.1666 12.6666C22.1666 10.9249 20.7416 9.49992 19 9.49992C17.2583 9.49992 15.8333 10.9249 15.8333 12.6666C15.8333 14.4083 17.2583 15.8333 19 15.8333C20.7416 15.8333 22.1666 14.4083 22.1666 12.6666ZM28.5 26.9166C28.1833 25.7924 23.275 23.7499 19 23.7499C14.725 23.7499 9.81665 25.7924 9.49998 26.9324V28.4999H28.5V26.9166ZM6.33331 26.9166C6.33331 22.7049 14.7725 20.5833 19 20.5833C23.2275 20.5833 31.6666 22.7049 31.6666 26.9166V31.6666H6.33331V26.9166Z"></path>
                  </svg></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <ol>
                      <?php if(is_user_logged_in()) : ?>
                          <li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><strong><?php echo wp_get_current_user()->user_login; ?></strong></a></li>
                          <li><a href="http://"><strong><?php _e('Tracking order', 'storefront') ?></strong></a></li>
                          <li><a href="<?php echo wc_logout_url() ?>"><strong><?php _e('Logout', 'storefront') ?></strong></a></li>
                          <?php elseif(!is_user_logged_in()) :?>
                          <li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><strong><?php _e('Login', 'storefront') ?></strong></a></li>
                          <li><a href="<?php echo apply_filters( 'wpml_permalink', home_url('/'). 'dang-ky', apply_filters( 'wpml_current_language', NULL ) );  ?>"><strong><?php _e('Create an account', 'storefront') ?></strong></a></li>
                        <?php endif ;?>
                    </ol>
                  </div>
                </div>
              </li>
              <li class="lang c-menu_dropdown">
                <a class="icon_inner" href="#">
                  <?php if(apply_filters('wpml_current_language', null) == 'vi') : ?>
                    <span class="lang_text">VN</span>
                  <?php elseif(apply_filters('wpml_current_language', null) == 'en') : ?>
                    <span class="lang_text">EN</span>
                  <?php endif; ?>
                </a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <ol>
                      <li><strong><?php _e('Change Language', 'storefront') ?></strong></li>
                      <?php do_action('wpml_add_language_selector'); ?>
                      <li><strong><?php _e('Change Price', 'storefront') ?></strong></li>
                      <?php echo do_action('wcml_currency_switcher', array(
                              'format' => '%name%',
                              'switcher_style' => 'wcml-horizontal-list'
                            )); ?>
                    </ol>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </header>
      <?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action( 'storefront_before_content' );
	?>