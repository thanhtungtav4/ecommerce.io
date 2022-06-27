<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	//do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		//do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
//	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>
<div class="l-container">
          <ul class="c-breadcrumb">
            <li><a href="#">Home</a></li>
            <li> <a href="#">Sản phẩm   </a></li>
            <li> <a href="#">Kính áp tròng nữ</a></li>
            <li>Russian Smoky Brown</li>
          </ul>
          <?php require_once( get_stylesheet_directory() . '/module/list_promotion.php' ); ?>
          <div class="c-tab">
            <div class="c-tab_top">
              <button class="button tablinks active" onclick="openTab(event, 'description')">Mô tả</button>
              <button class="button tablinks" onclick="openTab(event, 'parameter')">THÔNG SỐ</button>
              <button class="button tablinks" onclick="openTab(event, 'insurane')">BẢO HÀNH</button>
              <button class="button tablinks" onclick="openTab(event, 'review')">REVIEW (24)</button>
            </div>
            <div class="c-tab_content">
              <div class="c-tab_item" id="description" style="display: block;">
                <h2>Lavier Choco – Bí mật của đôi mắt nâu trầm ấm</h2>
                <p>𝑳𝑨𝑽𝑰𝑬𝑹 𝑪𝑯𝑶𝑪𝑶 (𝑺𝟎𝟕𝑪), “món trang sức” dành cho đôi mắt với màu nâu gỗ trầm ấm và vô cùng tự nhiên, trong trẻo. Sự hòa quyện nhẹ nhàng với để không che lấp đi đôi mắt vốn đã tuyệt vời của nàng.</p><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/image_2.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/image_2.jpg" alt="Logo" loading="lazy" width="1200" height="800">
                <p>Đặc biệt, Lens Choco là dòng kính cao cấp với chất liệu mềm và ẩm gấp hai lần. Do đó Lavier Choco là loại kính áp tròng nữ dành cho  nàng có cơ địa mắt khô và yếu. Nàng cũng có thể đeo lens để đi học, đi làm với tần suất sử dụng lên đến 14h/ngày.</p>
                <p>Hiểu được nhu cầu sử dụng thường xuyên của tín đồ đeo lens, Caras đã có cải tiến dòng lens Caras với thời gian sử dụng được cải tiến từ 12h nâng lên 14h/ ngày. Bạn có thể yên tâm gạt đi nỗi lo khô cộm mắt sau khi sử dụng cả ngày dài rồi nhé!</p>
              </div>
              <div class="c-tab_item" id="parameter" style="display: none;">
                <table>
                  <tbody>
                    <tr></tr>
                    <td><span>D&atilde;y &dstrok;&#x1ED9;</span></td>
                    <td><span>0 &ndash; 10 &dstrok;&#x1ED9;</span></td>
                    <tr></tr>
                    <td><span>GDia</span></td>
                    <td><span>13.6 mm</span></td>
                    <tr></tr>
                    <td><span>&Dstrok;&#x1ED9; cong c&#x1EE7;a lens (B.C)</span></td>
                    <td>8.7</td>
                    <tr></tr>
                    <td><span>H&agrave;m l&#x1B0;&#x1EE3;ng n&#x1B0;&#x1EDB;c</span></td>
                    <td>33%</td>
                    <tr></tr>
                    <td><span>H&#x1EA1;n s&#x1EED; d&#x1EE5;ng</span></td>
                    <td><span>3 Th&aacute;ng</span></td>
                    <tr></tr>
                    <td><span>Size&nbsp;</span></td>
                    <td><span>Medium</span></td>
                    <tr></tr>
                    <td><span>Style</span></td>
                    <td><span>Nh&#x1EB9; nh&agrave;ng, t&#x1EF1; nhi&ecirc;n</span></td>
                    <tr></tr>
                    <td><span>Recommend t&#x1EEB; Caras Lens</span></td>
                    <td><span>Tone m&#x1EAF;t &dstrok;en&nbsp;</span></td>
                    <tr></tr>
                    <td><span>C&ocirc;ng ngh&#x1EC7; c&#x1EE7;a Lens</span></td>
                    <td>
                      <ul></ul>
                      <li><span></span>RealcoT: T&abreve;ng c&#x1B0;&#x1EDD;ng l&#x1EDB;p m&agrave;ng b&oacute;ng gi&uacute;p t&#x1EA1;o chi&#x1EC1;u s&acirc;u, &dstrok;&ocirc;i m&#x1EAF;t tr&#x1EDF; n&ecirc;n long lanh h&#x1A1;n.</li>
                      <li><span></span>Anti UV: Ng&abreve;n ch&#x1EB7;n tia c&#x1EF1;c t&iacute;m t&#x1EEB; &aacute;nh n&#x1EAF;ng M&#x1EB7;t Tr&#x1EDD;i c&utilde;ng nh&#x1B0; t&#x1EEB; m&aacute;y t&iacute;nh, thi&#x1EBF;t b&#x1ECB; &dstrok;i&#x1EC7;n t&#x1EED;.</li>
                      <li><span></span>Nano Oxy-Hydrogen: T&abreve;ng c&#x1B0;&#x1EDD;ng &dstrok;&#x1ED9; &#x1EA9;m v&agrave; th&#x1EA9;m th&#x1EA5;u kh&iacute;, mang l&#x1EA1;i s&#x1EF1; kh&#x1ECF;e kho&#x1EAF;n v&agrave; tho&#x1EA3;i m&aacute;i khi d&ugrave;ng.</li>
                      <li><span></span>Nano AntiX: C&aacute;c ph&acirc;n t&#x1EED; nano kh&aacute;ng khu&#x1EA9;n, l&#x1EDB;p b&#x1EA3;o v&#x1EC7; m&#x1EAF;t tr&#x1B0;&#x1EDB;c m&ocirc;i tr&#x1B0;&#x1EDD;ng b&#x1EE5;i b&#x1EA9;n.</li>
                      <li><span></span>Etafilcon A: Gi&uacute;p t&abreve;ng c&#x1B0;&#x1EDD;ng th&#x1ECB; l&#x1EF1;c &dstrok;&#x1EC3; mang l&#x1EA1;i &aacute;nh nh&igrave;n trong s&aacute;ng v&agrave; tinh kh&ocirc;i .</li>
                    </td>
                    <tr></tr>
                    <td><span>Packed</span></td>
                    <td><span>1 C&#x1EB7;p lens (2 lens tr&aacute;i ph&#x1EA3;i)</span></td>
                    <tr></tr>
                    <td><span>Th&#x1B0;&#x1A1;ng hi&#x1EC7;u&nbsp;</span></td>
                    <td><span>Caras Lens</span></td>
                    <tr></tr>
                    <td colspan="2"><img class="alignnone size-full wp-image-8086 lazyloaded" alt="" width="260" height="90" data-src="https://caraslens.com/wp-content/uploads/2020/04/ft2.png" src="https://caraslens.com/wp-content/uploads/2020/04/ft2.png" loading="lazy"><img class="alignnone size-full wp-image-5917 lazyloaded" alt="" width="97" height="103" data-src="https://caraslens.com/wp-content/uploads/2020/03/logo.png" src="https://caraslens.com/wp-content/uploads/2020/03/logo.png" loading="lazy"></td>
                  </tbody>
                </table>
              </div>
              <div class="c-tab_item" id="insurane" style="display: none;">
                <h3>GIỎ HÀNG</h3>
              </div>
              <div class="c-tab_item" id="review" style="display: none;">
                <h3>GIỎ HÀNG</h3>
              </div>
            </div>
          </div>
          <div class="m-product">
            <div class="m-product_top">
              <h4>KÍNH Y TẾ CHUYÊN DỤNG</h4>
              <div class="m-product__nav">
                <button class="m-product__prev">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M28.835 14.8699L27.065 13.0999L17.165 22.9999L27.065 32.8999L28.835 31.1299L20.705 22.9999L28.835 14.8699H28.835Z"></path>
                  </svg>
                </button>
                <button class="m-product__next">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="23" cy="23" r="22" stroke-width="2"></circle>
                    <path d="M18.165 31.1301L19.935 32.9001L29.835 23.0001L19.935 13.1001L18.165 14.8701L26.295 23.0001L18.165 31.1301V31.1301Z" fill="#2B2929"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="m-product__inner w-100">
              <ul class="m-product__slick m-product__slick02 w-100">
                <li>
                  <ul>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
                <li>
                  <ul>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3 class="strong">XANIA BROWN</h3></a>
                          <p>400.000VND</p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                    <li><a href>
                        <div class="m-product__img"></div>
                        <picture>
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.avif" type="image/avif">
                          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/product_item.jpg" alt="Logo" loading="lazy" width="323" height="323">
                        </picture></a>
                      <div class="m-product__content">
                        <div class="m-product__content-top"><a href>
                            <h3><strong>XANIA BROWN</strong></h3></a>
                          <p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
                        </div>
                        <div class="m-product__content-bottom">
                          <p>8h/ngày | 3 tháng</p>
                          <div class="btn_area"><a class="btn_area__add" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/note_add.svg" alt="Logo" loading="lazy" width="16" height="20"></a><a class="btn_area__del" href="#"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/addcart.svg" alt="Logo" loading="lazy" width="22" height="22"></a></div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          <div class="c-info">
            <div class="list">
              <h4>KÍNH Y TẾ CHUYÊN DỤNG</h4>
              <ul>
                <li> <a href="#">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/info.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/info.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/info.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/info.jpg" alt="info" loading="lazy" width="667" height="132">
                    </picture></a></li>
                <li> <a href="#">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/info02.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/info02.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/info02.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/info02.jpg" alt="info" loading="lazy" width="667" height="132">
                    </picture></a></li>
                <li> <a href="#">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/info03.avif" type="image/avif">
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/info03.webp" type="image/webp">
                    </picture><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/info03.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/info03.jpg" alt="info" loading="lazy" width="667" height="132"></a></li>
              </ul>
            </div>
            <div class="video">
              <h4>KÍNH Y TẾ CHUYÊN DỤNG</h4><a href="#">
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/youtubeItem.avif" type="image/avif">
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/images/youtubeItem.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/images/youtubeItem.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/images/youtubeItem.jpg" alt="info" loading="lazy" width="664" height="421">
                </picture></a>
            </div>
          </div>
        </div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
