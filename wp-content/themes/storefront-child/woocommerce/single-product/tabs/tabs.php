<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>
		<div class="c-tab">
			<div class="c-tab_top">
				<button class="button tablinks active" onclick="openTab(event, 'description')">MÔ TẢ</button>
				<button class="button tablinks" onclick="openTab(event, 'parameter')">THÔNG SỐ</button>
				<button class="button tablinks" onclick="openTab(event, 'insurane')">BẢO HÀNH</button>
				<button class="button tablinks" onclick="openTab(event, 'reviews')">REVIEW (24)</button>
			</div>
		<div class="c-tab_content">
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="c-tab_item" id="<?php echo esc_attr( $key ); ?>" style="<?php echo $key == 'description' ? 'display: block' : 'display: none' ?>;">
				<?php
					if ( isset( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
			</div>
			<?php endforeach; ?>
			<div class="c-tab_item" id="parameter">
				<table>
					<tbody>
						<tr>
						<td>Dãy độ</td>
						<td>0 – 10 độ</td>
						</tr>
						<tr>
						<td>GDia</td>
						<td>13.7 mm</td>
						</tr>
						<tr>
						<td>Độ cong của lens (B.C)</td>
						<td>8.7</td>
						</tr>
						<tr>
						<td>Hàm lượng nước</td>
						<td>33%</td>
						</tr>
						<tr>
						<td>Hạn sử dụng</td>
						<td>3 Tháng</td>
						</tr>
						<tr>
						<td>Size</td>
						<td>Medium</td>
						</tr>
						<tr>
						<td>Style</td>
						<td>Nhẹ nhàng, tự nhiên</td>
						</tr>
						<tr>
						<td>Recommend từ Caras Lens</td>
						<td>Tone mắt đen</td>
						</tr>
						<tr>
						<td>Công nghệ của Lens</td>
						<td>
							<ul>
							<li>RealcoT: Tăng cường lớp màng bóng giúp tạo chiều sâu, đôi mắt trở nên long lanh hơn.</li>
							<li>Anti UV: Ngăn chặn tia cực tím từ ánh nắng Mặt Trời cũng như từ máy tính, thiết bị điện tử.</li>
							<li>Nano Oxy-Hydrogen: Tăng cường độ ẩm và thẩm thấu khí, mang lại sự khỏe khoắn và thoải mái khi dùng.</li>
							<li>Nano AntiX: Các phân tử nano kháng khuẩn, lớp bảo vệ mắt trước môi trường bụi bẩn.</li>
							<li>Etafilcon A: Giúp tăng cường thị lực để mang lại ánh nhìn trong sáng và tinh khôi .</li>
							</ul>
						</td>
						</tr>
						<tr>
						<td>Packed</td>
						<td>1 Cặp lens (2 lens trái phải)</td>
						</tr>
						<tr>
						<td>Thương hiệu</td>
						<td>Caras Lens</td>
						</tr>
						<tr>
						<td colspan="2">
							<picture>
							<!--(srcset=path+"assets/images/byt.webp" type="image/webp")-->
							<img class="lazyload styleimg01" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ft2.png" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ft2.png" alt="byt" loading="lazy" width="260" height="90">
							</picture>
							<picture>
							<source srcset="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chong-hang-gia.webp" type="image/webp">
							<img class="lazyload styleimg02" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chong-hang-gia.png" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chong-hang-gia.png" alt="chong hang gia" loading="lazy" width="90" height="90">
							</picture>
							<picture>
							<!--source(srcset=path+"assets/images/bsi.webp" type="image/webp")-->
							<img class="lazyload styleimg03" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/bsi02.png" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/bsi02.png" alt="bsi" loading="lazy" width="160" height="90">
							</picture>
						</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="c-tab_item" id="insurane">
				<h2>CHÍNH SÁCH BẢO HÀNH</h2>
				<p>Cảm ơn Quý khách đã tin dùng và chọn mua sản phẩm của chúng tôi. Vì lý do nào đó Quý khách không hài lòng với sản phẩm đã chọn mua, hãy liên hệ ngay với chúng tôi khi có bất kỳ thắc mắc cần giải đáp, tư vấn khi cần bảo hành, sửa, đổi sản phẩm.</p>
				<h2>1. Hình thức bảo hành:</h2>
				<p>Bảo hành bằng thông tin lưu trữ khách hàng cung cấp cho CARAS (Bao gồm: Tên + Số điện thoại)</p>
				<h2>1. Hình thức bảo hành:</h2>
				<ul>
					<li>Sản phẩm còn thời hạn bảo hành và trùng khớp với thông tin mua hàng.
Sản phẩm bị lỗi cấu tạo (không phải do tác động của người dùng*).
Cơ địa khách hàng không phù hợp với kính áp tròng.
Tất cả lỗi do lens lỗi: lens cộm, lens đeo bị mờ, lens sử dụng bị nóng, rát, sử dụng không đúng đồng tử mắt, lens rút nước.</li>
				</ul>
			
			</div>
		</div>
	</div>
	<?php do_action( 'woocommerce_product_after_tabs' ); ?>

<?php endif; ?>


