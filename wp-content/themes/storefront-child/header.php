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
	<title>Top</title>
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
        <div class="c-header_top">
          <div class="l-container">
            <p>Freeship nội thành cho đơn&nbsp;<span>từ 250.000đ</span> – Tỉnh&nbsp;<span>từ 400.000đ</span></p>
          </div>
        </div>
        <div class="c-header_bottom">
          <div class="l-container c-header_inner">
            <div class="c-header_logo"><a href="/">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logo.webp" type="image/webp">
									<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logo.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logo.png" alt="logo">
                </picture>
							</a>
						</div>
            <ul class="c-header_menu">
              <li class="c-menu c-menu_dropdown"><a href="#">Best Seller</a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
                        <dt>
                        <dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                      <dl>
											<dt>
                        <dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                      <dl>
											<dt>
                        <dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="#">Kính Áp Tròng</a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-5">
                      <dl>
                        <dt>Theo nhu cầu</dt>
                        <dd><a href="#">Lens nữ</a></dd>
                        <dd><a href="#">Lens nam</a></dd>
                        <dd><a href="#">Lens Tự Nhiên - Đi học đi làm</a></dd>
                        <dd><a href="#">Lens Sáng Màu - Đi chơi chụp hình</a></dd>
                        <dd><a href="#">Lens Sáng Tây</a></dd>
                      </dl>
                      <dl>
                        <dt>Khúc Xạ Mắt</dt>
                        <dd><a href="#">Lens cận</a></dd>
                        <dd><a href="#">Lens loạn</a></dd>
                        <dd><a href="#">Lens cận loạn</a></dd>
                        <dd><a href="#">Lens viễn</a></dd>
                      </dl>
                      <dl>
                        <dt>Loại Kính</dt>
                        <dd><a href="#">3 tháng</a></dd>
                        <dd><a href="#">1 ngày</a></dd>
                        <dd></dd>
                        <dt>Size</dt>
                        <dd><a href="#">Tự nhiên - 13.8mm</a></dd>
                        <dd><a href="#">Giãn nhẹ - 14.0 mm</a></dd>
                      </dl>
                      <dl>
                        <dt>Màu sắc</dt>
                        <dd><a href="#">Nâu</a></dd>
                        <dd><a href="#">Xám</a></dd>
                        <dd><a href="#">Choco</a></dd>
                        <dd><a href="#">Không màu</a></dd>
                      </dl>
                      <dl>
                        <dt>Thời gian đeo</dt>
                        <dd><a href="#">8h</a></dd>
                        <dd><a href="#">10h</a></dd>
                        <dd><a href="#">12h</a></dd>
                        <dd><a href="#">14h</a></dd>
                        <dd><a href="#">24h</a></dd>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="#">Phụ Kiện</a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
											<dt>
                        <dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                      <dl>
											<dt>
                        <dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                      <dl>
											<dt>
                        <dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
												</dt>
                      </dl>
                      <dl>
											<dt>
                        <dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
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
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
                      </dl>
                      <dl>
                        <dt>Đo mắt miễn phí
												<dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                      <dl>
                        <dt>Tư ván online
												<dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
              <li class="c-menu c-menu_dropdown"><a href="#">Thông Tin</a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <div class="l-container col-3">
                      <dl>
                        <dt>Giới thiệu CARAS</dt>
                        <dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
                      </dl>
                      <dl>
                        <dt>Hướng Dẫn Sử Dụng
												<dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                      <dl>
                        <dt>Blog
												<dd>
													<a href="#">
													<picture>
														<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.webp" type="image/webp">
														<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/img_menu.png" alt="menu">
													</picture>
													</a>
												</dd>
                        </dt>
                      </dl>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
            <ul class="c-header_icon">
              <li class="navbar only-sp" onclick="toggleMenu()">
                <svg width="28" height="18" viewBox="0 0 28 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 3V0H27.5V3H0.5ZM0.5 10.5H27.5V7.5H0.5V10.5ZM0.5 18H27.5V15H0.5V18Z" fill="#2B2929"></path>
                </svg>
              </li>
              <li class="cart c-menu_dropdown"><a class="icon_inner" href="#">
                  <svg width="35" height="36" viewBox="0 0 35 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M26.6821 17.9563C26.1863 18.8605 25.2238 19.4584 24.13 19.4584H13.2654L11.6613 22.3751H29.1613V25.2917H11.6613C9.44459 25.2917 8.04459 22.9147 9.10917 20.9605L11.0779 17.4022L5.82792 6.33341H2.91125V3.41675H7.68001L9.05084 6.33341H30.6342C31.7425 6.33341 32.4425 7.52925 31.9029 8.49175L26.6821 17.9563ZM28.155 9.25008H10.4363L13.8925 16.5417H24.13L28.155 9.25008ZM11.6613 26.7501C10.0571 26.7501 8.75917 28.0626 8.75917 29.6667C8.75917 31.2709 10.0571 32.5834 11.6613 32.5834C13.2654 32.5834 14.5779 31.2709 14.5779 29.6667C14.5779 28.0626 13.2654 26.7501 11.6613 26.7501ZM23.3425 29.6667C23.3425 28.0626 24.6404 26.7501 26.2446 26.7501C27.8488 26.7501 29.1613 28.0626 29.1613 29.6667C29.1613 31.2709 27.8488 32.5834 26.2446 32.5834C24.6404 32.5834 23.3425 31.2709 23.3425 29.6667Z"></path>
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
              <li class="search c-menu_dropdown"><a class="icon_inner" href="#">
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.4475 21.3826H23.6325L31.1175 28.8826L28.8825 31.1176L21.3825 23.6326V22.4476L20.9775 22.0276C19.2675 23.4976 17.0475 24.3826 14.6325 24.3826C9.24751 24.3826 4.88251 20.0176 4.88251 14.6326C4.88251 9.24757 9.24751 4.88257 14.6325 4.88257C20.0175 4.88257 24.3825 9.24757 24.3825 14.6326C24.3825 17.0476 23.4975 19.2676 22.0275 20.9776L22.4475 21.3826ZM7.88251 14.6326C7.88251 18.3676 10.8975 21.3826 14.6325 21.3826C18.3675 21.3826 21.3825 18.3676 21.3825 14.6326C21.3825 10.8976 18.3675 7.88257 14.6325 7.88257C10.8975 7.88257 7.88251 10.8976 7.88251 14.6326Z"></path>
                  </svg></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <form action="/" method="get">
                      <input type="text" name="s" value="<?php the_search_query(); ?>"  id="search"  placeholder="<?php _e('Search', 'storefront') ?>"><i class="gg-search"></i>
                    </form>
                  </div>
                </div>
              </li>
              <li class="user c-menu_dropdown"><a class="icon_inner" href="#">
                  <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19 6.33325C15.5008 6.33325 12.6666 9.16742 12.6666 12.6666C12.6666 16.1658 15.5008 18.9999 19 18.9999C22.4991 18.9999 25.3333 16.1658 25.3333 12.6666C25.3333 9.16742 22.4991 6.33325 19 6.33325ZM22.1666 12.6666C22.1666 10.9249 20.7416 9.49992 19 9.49992C17.2583 9.49992 15.8333 10.9249 15.8333 12.6666C15.8333 14.4083 17.2583 15.8333 19 15.8333C20.7416 15.8333 22.1666 14.4083 22.1666 12.6666ZM28.5 26.9166C28.1833 25.7924 23.275 23.7499 19 23.7499C14.725 23.7499 9.81665 25.7924 9.49998 26.9324V28.4999H28.5V26.9166ZM6.33331 26.9166C6.33331 22.7049 14.7725 20.5833 19 20.5833C23.2275 20.5833 31.6666 22.7049 31.6666 26.9166V31.6666H6.33331V26.9166Z"></path>
                  </svg></a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <ol>
                      <li><a href="http://"><strong><?php _e('Login', 'storefront') ?></strong></a></li>
                      <li><a href="http://"><strong><?php _e('Create an account', 'storefront') ?></strong></a></li>
                      <li><a href="http://"><strong><?php _e('Tracking order', 'storefront') ?></strong></a></li>
                    </ol>
                  </div>
                </div>
              </li>
              <li class="lang c-menu_dropdown">
                <a class="icon_inner" href="#">
                  <?php if(apply_filters('wpml_current_language', null) == 'vi') : ?>
                  <svg width="29" height="30" viewBox="0 0 29 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect y="0.5" width="29" height="29" rx="14.5" fill="#EA403F"></rect>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 18.4463L10.0916 21.746L11.7182 16.3241L7.36708 12.9415L12.7807 12.8903L14.5 7.5L16.2193 12.8903L21.6329 12.9415L17.2818 16.3241L18.9084 21.746L14.5 18.4463Z" fill="#FFFE4E"></path>
                  </svg>
                  <?php elseif(apply_filters('wpml_current_language', null) == 'en') : ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" xmlns:v="https://vecta.io/nano"><path d="M30 15c0 8.285-6.715 15-15 15S0 23.285 0 15 6.715 0 15 0s15 6.715 15 15zm0 0" fill="rgb(94.117647%,94.117647%,94.117647%)"/><g fill="rgb(0%,32.156863%,70.588235%)"><path d="M3.102 5.867a14.99 14.99 0 0 0-2.586 5.219H8.32zm26.382 5.219a14.99 14.99 0 0 0-2.586-5.219l-5.219 5.219zM.516 18.914a14.99 14.99 0 0 0 2.586 5.219l5.219-5.219zM24.133 3.102A14.99 14.99 0 0 0 18.914.516V8.32zM5.867 26.898a14.99 14.99 0 0 0 5.219 2.586V21.68zm0 0"/><path d="M11.086.516a14.99 14.99 0 0 0-5.219 2.586l5.219 5.219zm7.828 28.968a14.99 14.99 0 0 0 5.219-2.586l-5.219-5.219zm2.766-10.57l5.219 5.219a14.99 14.99 0 0 0 2.586-5.219zm0 0"/></g><g fill="rgb(84.705882%,0%,15.294118%)"><path d="M29.871 13.043H16.957V.129A14.7 14.7 0 0 0 15 0a14.7 14.7 0 0 0-1.957.129v12.914H.129A14.7 14.7 0 0 0 0 15a14.7 14.7 0 0 0 .129 1.957h12.914v12.914A14.7 14.7 0 0 0 15 30a14.7 14.7 0 0 0 1.957-.129V16.957h12.914A14.7 14.7 0 0 0 30 15a14.7 14.7 0 0 0-.129-1.957zm-10.957 5.871l6.691 6.691.883-.961-5.73-5.73zm-7.828 0l-6.691 6.691.961.883 5.73-5.73zm0-7.828L4.395 4.395l-.883.961 5.73 5.73zm0 0"/><path d="M18.914 11.086l6.691-6.691-.961-.883-5.73 5.73zm0 0"/></g></svg>
                  <?php endif; ?>
                </a>
                <div class="c-menu_sub">
                  <div class="c-menu_subinner">
                    <ol>
                      <li><strong><?php _e('Change Language', 'storefront') ?></strong></li>
                      <?php do_action('wpml_add_language_selector'); ?>
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