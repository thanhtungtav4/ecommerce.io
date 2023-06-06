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
														<img width="326" height="149" loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_clear.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_clear.jpg" alt="best_437x200_clear">
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
														<img width="326" height="149" loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_lavier.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_lavier.jpg" alt="best_437x200_lavier">
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
														<img width="326" height="149" loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_ombre.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/best_437x200_ombre.jpg" alt="best_437x200_ombre">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="/contact-lens/"><?php _e('Lens', 'storefront') ?></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-5">
                    <dl>
                        <dt><?php _e('FOR INDIVIDUAL NEEDS', 'storefront') ?></dt>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/contact-lens-for-men/' : print get_site_url().'/lens-nu/');   ?>"><?php _e('Lens Women', 'storefront') ?></a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/contact-lenses-for-women/' : print get_site_url().'/lens-nam/');   ?>"><?php _e('Lens Men', 'storefront') ?></a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/contact-lenses-for-casual-occasions/' : print get_site_url().'/lens-deo-di-hoc-va-di-lam/'); ?>"><?php _e('Lens is light', 'storefront') ?></a></dd>
                        <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/contact-lenses-for-special-occasion/' : print get_site_url().'/lens-deo-chup-anh-va-du-tiec/'); ?>"><?php _e('Lens west morning', 'storefront') ?></a></dd>
                      </dl>
                      <div class="gr-menu">
                        <dl>
                          <dt><?php _e('Eye Refraction', 'storefront') ?></dt>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-can-thi/'); ?>"><?php _e('Myopia contact lenses', 'storefront') ?></a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-loan-thi/'); ?>"><?php _e('Astigmatism contact lenses', 'storefront') ?></a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-can-loan/'); ?>"><?php _e('Myopia, hyperopia lens', 'storefront') ?></a></dd>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-vien-thi/'); ?>"><?php _e('Eyepiece', 'storefront') ?></a></dd>
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
                          <dd class="pc-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-3-thang/'); ?>">3 <?php _e('month', 'storefront') ?></a></dd>
                          <dd class="pc-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-1-ngay/'); ?>">1 <?php _e('day', 'storefront') ?></a></dd>
                          <dd class="sp-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-3-thang/'); ?>"><img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_3month.png" alt="3 tháng"></a></dd>
                          <dd class="sp-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-1-ngay/'); ?>"><img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_1month.png" alt="1 ngày"></a></dd>
                          <dt>Size</dt>
                          <dd class="pc-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-13-6mm-13-8mm/'); ?>"><?php _e('Spontaneous', 'storefront') ?> - 13.8mm</a></dd>
                          <dd class="pc-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-14mm/'); ?>"><?php _e('Light stretch', 'storefront') ?> - 14.0 mm</a></dd>
                          <dd class="sp-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-13-6mm-13-8mm/'); ?>"><img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_13mm.png" alt="<?php _e('Spontaneous', 'storefront') ?> - 13.8mm"><?php _e('Spontaneous', 'storefront') ?></a></dd>
                          <dd class="sp-only"><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-14mm/'); ?>"><img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ico_14mm.png" alt="<?php _e('Light stretch', 'storefront') ?> - 14.0 mm"><?php _e('Light stretch', 'storefront') ?></a></dd>
                        </dl>
                        <dl class="color">
                          <dt><?php _e('BY COLOR', 'storefront') ?></dt>
                          <dd><a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-mau-nau/'); ?>"><?php _e('Brown', 'storefront') ?></a></dd>
                          <dd><a class="is-gray" href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/lens-mau-xam/'); ?>"><?php _e('Gray', 'storefront') ?></a></dd>
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
                <a href="<?php if(ICL_LANGUAGE_CODE == 'en' ? print get_site_url().'/' .ICL_LANGUAGE_CODE. '/' : print get_site_url().'/phu-kien-lens/'); ?>"><?php _e('Accessories', 'storefront') ?></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
											<dt>
                        <dd>
													<a href="/nuoc-ngam-kinh-ap-trong/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_ngam.webp" type="image/webp">
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_ngam.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_ngam.png" alt="accessory_dd_ngam" width="326" height="149">
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
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_nho.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_nho.png" alt="accessory_dd_nho" width="326" height="149">
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
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_vitamin.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/accessory_dd_vitamin.jpg" alt="accessory_dd_vitamin" width="326" height="149">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="https://dixon.vn/"><?php _e('Glass Dixon', 'storefront') ?></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3 flexcenter">
                      <dl>
												<dd>
													<a href="https://dixon.vn/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bannerkg_dx2.webp" type="image/webp">
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bannerkg_dx2.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bannerkg_dx2.jpg" alt="bannerkg_dx2" width="326" height="149">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                      <dl>
                        <dd>
													<a href="https://dixon.vn/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bannerkg_km1.webp" type="image/webp">
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bannerkg_km1.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bannerkg_km1.jpg" alt="bannerkg" width="326" height="149">
													</picture>
													</a>
												</dd>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="#"><?php _e('Service', 'storefront') ?></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
                        <dt>Showroom</dt>
                        <dd>
													<a href="https://caraslens.com/showroom/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_showroom.webp" type="image/webp">
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_showroom.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_showroom.jpg" alt="dv_showroom" width="326" height="149">
													</picture>
													</a>
												</dd>
                      </dl>
                      <dl>
                        <dt><?php _e('Free eye test', 'storefront') ?>
												<dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_do_mat.webp" type="image/webp">
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_do_mat.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_do_mat.jpg" alt="dv_do_mat" width="326" height="149">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                      <dl>
                        <dt><?php _e('Online consultation', 'storefront') ?>
												<dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_tu_van_online.webp" type="image/webp">
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_tu_van_online.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dv_tu_van_online.jpg" alt="dv_tu_van_online" width="326" height="149">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="http://caraslens.com/sales-promotion/"><?php _e('Promotion', 'storefront') ?></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3 flexcenter flex-wrap">
                      <dl>
												<dd>
													<a href="http://caraslens.com/sales-promotion/">
													<picture>
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/menu-ctkm-10.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/menu-ctkm-10.jpg" alt="menu-ctkm-10" width="326" height="149">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                      <dl>
                        <dd>
													<a href="http://caraslens.com/sales-promotion/">
													<picture>
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/menu-ctkm-10-5.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/menu-ctkm-10-5.jpg" alt="menu-ctkm-10-5" width="326" height="149">
													</picture>
													</a>
												</dd>
                      </dl>
                      <dl>
                        <dd>
													<a href="http://caraslens.com/sales-promotion/">
													<picture>
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/menu-ctkm-combo-lens.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/menu-ctkm-combo-lens.jpg" alt="menu-ctkm-10-5" width="326" height="149">
													</picture>
													</a>
												</dd>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href=""><?php _e('Information', 'storefront') ?></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
                        <dt><?php _e('About CARAS', 'storefront') ?></dt>
                        <dd>
													<a href="/gioi-thieu/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_gioi_thieu_caras.webp" type="image/webp">
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_gioi_thieu_caras.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_gioi_thieu_caras.jpg" alt="thong_tin_gioi_thieu_caras" width="326" height="149">
													</picture>
													</a>
												</dd>
                      </dl>
                      <dl>
                        <dt><?php _e('User manual', 'storefront') ?>
												<dd>
													<a href="/cach-deo-lens/">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_hdsd.webp" type="image/webp">
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_hdsd.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thongtin_hdsd.jpg" alt="thongtin_hdsd" width="326" height="149">
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
														<img loading="lazy" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thong_tin_blog.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/thong_tin_blog.jpg" alt="thong_tin_blog" width="326" height="149">
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
                  <a class="" href="<?php echo apply_filters( 'wpml_permalink', home_url('/'). 'cart', apply_filters( 'wpml_current_language', NULL ) );  ?>"><strong>
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
                <svg width="30" height="30" viewBox="0 0 49 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M24.2 48.4C37.5653 48.4 48.4 37.5653 48.4 24.2C48.4 10.8347 37.5653 0 24.2 0C10.8347 0 0 10.8347 0 24.2C0 37.5653 10.8347 48.4 24.2 48.4Z" fill="#7F7F7F"></path>
                  <path d="M39.34 21.52C39.24 22.11 39.18 22.71 39.05 23.29C38.01 27.97 34.08 31.61 29.34 32.27C23.43 33.09 17.91 29.42 16.38 23.65C14.88 18.01 17.92 12.01 23.35 9.88C24.41 9.46 25.51 9.19 26.64 9.1C26.71 9.1 26.79 9.07 26.86 9.05C27.41 9.05 27.97 9.05 28.52 9.05C28.88 9.1 29.25 9.15 29.61 9.21C34.24 9.97 38.02 13.54 39.04 18.12C39.17 18.69 39.24 19.28 39.33 19.86V21.52H39.34ZM27.86 28.37C32.17 28.23 35.47 24.72 35.33 20.41C35.2 16.22 31.63 12.93 27.37 13.06C23.25 13.19 19.89 16.77 20.02 20.89C20.16 25.15 23.68 28.51 27.86 28.37Z" fill="white"></path>
                  <path d="M16.85 27.36C17.93 29.08 19.3 30.45 21 31.51C20.94 31.58 20.89 31.64 20.84 31.69C18.93 33.6 17.03 35.51 15.12 37.41C13.76 38.76 11.66 38.6 10.58 37.09C9.78 35.96 9.85 34.41 10.83 33.41C12.43 31.76 14.07 30.15 15.7 28.53C16.08 28.15 16.45 27.77 16.86 27.36H16.85Z" fill="white"></path>
                </svg>
                </a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <form action="/" method="get">
                      <input type="text" name="s" value="<?php the_search_query(); ?>"  id="search"  placeholder="<?php _e('Search', 'storefront') ?>"><i class="gg-search"></i>
                      <input type="hidden" name="post_type" value="product" />
                    </form>
                  </div>
                </div>
              </li>
              <li class="cart c-menu_dropdown" id="ico_cart"><a class="icon_inner" href="#">
                <svg width="37" height="30" viewBox="0 0 57 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M39.7008 0C41.2408 0.16 42.5908 0.280001 43.9308 0.460001C47.3808 0.920001 49.6308 2.9 50.5708 6.19C51.3908 9.08 52.0208 12.04 52.5908 14.99C53.7808 21.12 54.9408 27.25 55.9808 33.4C56.3908 35.79 56.6608 38.25 56.6408 40.67C56.6008 45.08 54.2808 47.63 49.9208 48.46C46.8708 49.04 43.7808 49.06 40.6908 49.06C31.5708 49.06 22.4408 49.06 13.3208 49.03C10.6208 49.02 7.91083 48.9 5.30083 48.07C2.11083 47.05 0.280826 44.7 0.0508262 41.36C-0.149174 38.49 0.270824 35.67 0.790824 32.87C2.20082 25.23 3.64083 17.59 5.10083 9.96C5.34083 8.7 5.71083 7.45 6.10083 6.22C7.23083 2.59 9.77083 0.7 13.5208 0.34C14.6108 0.24 15.7108 0.15 16.8708 0.0500002H21.5908C26.1108 0.0400002 30.6208 0.04 35.2608 0.04L39.7208 0.0100002L39.7008 0Z" fill="#7F7F7F"></path>
                  <path d="M28.3208 32.56C21.1308 32.56 15.2808 25.37 15.2808 16.53C15.2808 15.15 16.4008 14.03 17.7808 14.03C19.1608 14.03 20.2808 15.15 20.2808 16.53C20.2808 22.61 23.8908 27.56 28.3208 27.56C32.7508 27.56 36.3608 22.61 36.3608 16.53C36.3608 15.15 37.4808 14.03 38.8608 14.03C40.2408 14.03 41.3608 15.15 41.3608 16.53C41.3608 25.37 35.5108 32.56 28.3208 32.56Z" fill="white"></path>
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
                <div class="c-menu_sub" id="mini-cart-content">
                  <div class="c-menu_subinner">
                    <div  class="cart_inner widget_shopping_cart_content">
                      <?php woocommerce_mini_cart(); ?>
                    </div>
                  </div>
                </div>
              </li>
              <li class="user c-menu_dropdown">
                <a class="icon_inner" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                  <svg width="30" height="30" viewBox="0 0 49 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24.2 0C10.84 0 0 10.83 0 24.2C0 37.57 10.83 48.4 24.2 48.4C37.57 48.4 48.4 37.57 48.4 24.2C48.4 10.83 37.57 0 24.2 0ZM24.2 43.4C17.22 43.4 11.11 39.64 7.75 34.05C10.45 29.68 14.5 26.79 19.92 25.39C14.84 22.35 14.68 15.88 17.86 12.38C21.03 8.89 26.37 8.56 29.89 11.74C31.58 13.26 32.54 15.18 32.66 17.46C32.84 20.9 31.34 23.49 28.47 25.38C33.9 26.8 37.95 29.69 40.65 34.05C37.29 39.64 31.18 43.4 24.2 43.4Z" fill="#7F7F7F"></path>
                  </svg>
                </a>
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
                    <svg width="32" height="29" viewBox="0 0 52 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M43.87 0H7.45001C3.33549 0 0 3.33548 0 7.45V41.26C0 45.3745 3.33549 48.71 7.45001 48.71H43.87C47.9845 48.71 51.32 45.3745 51.32 41.26V7.45C51.32 3.33548 47.9845 0 43.87 0Z" fill="#7F7F7F"/>
                      <path d="M16.02 30.55C15.49 30.55 15.06 30.44 14.74 30.22C14.41 30 14.14 29.64 13.92 29.16L8.86998 18.02C8.64998 17.53 8.57999 17.1 8.65999 16.71C8.73999 16.32 8.93998 16.02 9.23998 15.8C9.54998 15.58 9.93 15.48 10.39 15.48C10.96 15.48 11.39 15.6 11.67 15.86C11.96 16.11 12.2 16.48 12.41 16.97L16.67 26.81H15.5L19.75 16.94C19.96 16.45 20.21 16.09 20.5 15.84C20.79 15.6 21.2 15.48 21.73 15.48C22.16 15.48 22.52 15.59 22.81 15.8C23.1 16.02 23.29 16.32 23.36 16.71C23.44 17.1 23.36 17.54 23.14 18.02L18.07 29.16C17.86 29.65 17.6 30 17.28 30.22C16.96 30.44 16.54 30.55 16.01 30.55H16.02Z" fill="white"/>
                      <path d="M26.99 30.55C26.38 30.55 25.91 30.38 25.57 30.04C25.24 29.7 25.07 29.22 25.07 28.59V17.43C25.07 16.79 25.24 16.3 25.57 15.97C25.9 15.64 26.38 15.47 26.99 15.47C27.6 15.47 28.09 15.64 28.42 15.97C28.75 16.3 28.91 16.79 28.91 17.43V28.59C28.91 29.22 28.75 29.7 28.43 30.04C28.11 30.38 27.63 30.55 26.99 30.55Z" fill="white"/>
                      <path d="M33.58 30.37C32.93 30.37 32.43 30.2 32.09 29.86C31.75 29.52 31.58 29.03 31.58 28.39V17.65C31.58 17.01 31.75 16.52 32.09 16.18C32.43 15.84 32.93 15.67 33.58 15.67H40.65C41.15 15.67 41.53 15.79 41.78 16.05C42.03 16.3 42.16 16.66 42.16 17.13C42.16 17.6 42.04 17.99 41.78 18.25C41.53 18.51 41.16 18.64 40.65 18.64H35.25V21.43H40.19C40.68 21.43 41.05 21.55 41.31 21.81C41.57 22.06 41.7 22.43 41.7 22.92C41.7 23.41 41.57 23.78 41.31 24.03C41.05 24.28 40.68 24.41 40.19 24.41H35.25V27.43H40.65C41.15 27.43 41.53 27.56 41.78 27.82C42.03 28.08 42.16 28.44 42.16 28.92C42.16 29.4 42.04 29.77 41.78 30.03C41.53 30.28 41.16 30.41 40.65 30.41H33.58V30.37Z" fill="white"/>
                    </svg>
                  <?php elseif(apply_filters('wpml_current_language', null) == 'en') : ?>
                    <svg width="32" height="29" viewBox="0 0 52 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M43.87 0H7.45C3.33548 0 0 3.33548 0 7.45V41.26C0 45.3745 3.33548 48.71 7.45 48.71H43.87C47.9845 48.71 51.32 45.3745 51.32 41.26V7.45C51.32 3.33548 47.9845 0 43.87 0Z" fill="#7F7F7F"/>
                      <path d="M8.71999 29.78C8.12999 29.78 7.68 29.63 7.37 29.32C7.06 29.01 6.90999 28.57 6.90999 27.99V18.29C6.90999 17.71 7.06 17.27 7.37 16.96C7.68 16.65 8.12999 16.5 8.71999 16.5H15.11C15.56 16.5 15.9 16.61 16.13 16.84C16.36 17.07 16.47 17.39 16.47 17.82C16.47 18.25 16.36 18.6 16.13 18.83C15.9 19.06 15.56 19.18 15.11 19.18H10.23V21.7H14.69C15.13 21.7 15.46 21.81 15.7 22.04C15.93 22.27 16.05 22.6 16.05 23.04C16.05 23.48 15.93 23.81 15.7 24.04C15.47 24.27 15.13 24.38 14.69 24.38H10.23V27.11H15.11C15.56 27.11 15.9 27.23 16.13 27.46C16.36 27.69 16.47 28.02 16.47 28.45C16.47 28.88 16.36 29.22 16.13 29.45C15.9 29.68 15.56 29.79 15.11 29.79H8.71999V29.78Z" fill="white"/>
                      <path d="M20.1 29.95C19.57 29.95 19.17 29.81 18.89 29.54C18.61 29.26 18.47 28.86 18.47 28.32V18.05C18.47 17.5 18.61 17.07 18.89 16.78C19.17 16.49 19.53 16.34 19.98 16.34C20.38 16.34 20.69 16.42 20.92 16.57C21.15 16.72 21.4 16.97 21.67 17.32L27.64 24.78H27.11V17.96C27.11 17.43 27.24 17.03 27.52 16.75C27.79 16.47 28.19 16.34 28.72 16.34C29.25 16.34 29.65 16.48 29.92 16.75C30.19 17.03 30.33 17.43 30.33 17.96V28.4C30.33 28.88 30.2 29.26 29.95 29.54C29.7 29.82 29.36 29.96 28.93 29.96C28.5 29.96 28.17 29.88 27.92 29.72C27.67 29.56 27.41 29.32 27.14 28.98L21.17 21.5H21.7V28.32C21.7 28.86 21.56 29.27 21.29 29.54C21.02 29.82 20.62 29.95 20.09 29.95H20.1Z" fill="white"/>
                      <path d="M39.54 29.99C38.02 29.99 36.73 29.71 35.67 29.14C34.61 28.58 33.8 27.78 33.25 26.77C32.7 25.76 32.42 24.57 32.42 23.21C32.42 22.15 32.59 21.2 32.92 20.36C33.25 19.51 33.73 18.78 34.36 18.17C34.99 17.56 35.76 17.1 36.67 16.78C37.58 16.46 38.61 16.3 39.77 16.3C40.4 16.3 41.04 16.36 41.69 16.48C42.34 16.6 42.98 16.82 43.61 17.15C43.94 17.3 44.16 17.51 44.28 17.78C44.4 18.05 44.44 18.33 44.39 18.63C44.35 18.93 44.24 19.19 44.07 19.44C43.9 19.68 43.67 19.85 43.38 19.93C43.09 20.01 42.76 19.97 42.4 19.81C42.02 19.63 41.61 19.5 41.18 19.41C40.75 19.32 40.28 19.27 39.79 19.27C38.95 19.27 38.25 19.42 37.69 19.72C37.13 20.02 36.71 20.47 36.44 21.06C36.16 21.65 36.02 22.37 36.02 23.23C36.02 24.51 36.33 25.48 36.96 26.13C37.59 26.78 38.52 27.11 39.75 27.11C40.13 27.11 40.54 27.07 40.98 27C41.43 26.92 41.87 26.82 42.33 26.68L41.69 27.98V24.76H40.37C39.94 24.76 39.61 24.65 39.38 24.44C39.15 24.23 39.03 23.92 39.03 23.54C39.03 23.16 39.15 22.85 39.38 22.64C39.61 22.43 39.94 22.33 40.37 22.33H43.16C43.6 22.33 43.94 22.45 44.17 22.68C44.4 22.91 44.52 23.25 44.52 23.69V27.85C44.52 28.23 44.44 28.55 44.28 28.81C44.12 29.07 43.88 29.26 43.54 29.38C42.95 29.58 42.31 29.74 41.62 29.85C40.93 29.96 40.24 30.02 39.55 30.02L39.54 29.99Z" fill="white"/>
                    </svg>
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