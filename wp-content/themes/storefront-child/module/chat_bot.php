<div class="m-chat" onclick="toggleChat()">
	<picture>
		<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chatbot.webp" type="image/webp" />
		<img
			class="lazyload"
			src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chatbot.png"
			data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chatbot.png"
			alt="chatbot"
			loading="lazy"
			width="70"
			height="70"
		/>
	</picture>
</div>
<div class="m-chat_inner">
	<form class="js-chatbot" id="regForm">
		<div class="overlay-welcome">
			<p>XIN CHÀO</p>
		</div>
		<div class="tab tab-wellcome" id="tab-welcome" style="display: block;">
			<div class="m-chat_top">
				<p>HỖ TRỢ CHỌN LENS</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">
					Chúng tôi có thể<br />
					giúp gì cho bạn ?
				</p>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" loading="lazy" />
				<div class="radiobtn">
					<input id="demand1" type="radio" name="demand" data-value="#tab-tu-van" value="tu_van" checked />
					<label for="demand1">Tư vấn</label>
				</div>
				<div class="radiobtn">
					<input id="demand2" type="radio" name="demand" data-value="#san-pham" value="mua_hang" />
					<label for="demand2">Mua hàng</label>
				</div>
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
		<div class="tab tab-tu_van" id="tab-tu-van">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>HỖ TRỢ CHỌN LENS</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">Tư vấn hỗ trợ khách hàng</p>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" loading="lazy" />
				<div class="radiobtn">
					<input id="advise1" type="radio" name="tu_van_kinh" data-value="#tab-kinh_ap_trong" value="kinh_ap_trong" checked />
					<label for="advise1">Tư vấn về kính áp tròng</label>
				</div>
				<div class="radiobtn">
					<input id="advise2" type="radio" data-value="#tab-tu-van-khac" name="tu_van_kinh" value="tu_van_khac" />
					<label for="advise2">Tư vấn khác</label>
				</div>
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
		<div class="tab tab-tu_van" id="tab-tu-van-khac">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>HỖ TRỢ CHỌN LENS</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">HỖ TRỢ QUA FACEBOOK</p>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook-messenger-2881.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook-messenger-2881.svg" loading="lazy" />
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="https://www.messenger.com/t/Carasyvn/" target="_blank">Chat với chúng tôi</a></div>
		</div>
		<div class="tab tab-tu_van_khac" id="tab-tu_van_khac">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>Hỗ trợ qua Facebook</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">Tư vấn hỗ trợ khách hàng</p>
				<a href="https://www.facebook.com/" taget="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="150px" height="150px" viewbox="0 0 150 150" version="1.1">
						<defs>
							<radialgradient id="radial0" gradientunits="userSpaceOnUse" cx="0.19247" cy="0.99465" fx="0.19247" fy="0.99465" r="1.0896" gradienttransform="matrix(117.1875,0,0,116.785156,16.40625,17.871094)">
								<stop offset="0" style="stop-color:rgb(0%,60%,100%);stop-opacity:1;"></stop>
								<stop offset="0.60975" style="stop-color:rgb(62.745098%,20%,100%);stop-opacity:1;"></stop>
								<stop offset="0.93482" style="stop-color:rgb(100%,32.156863%,50.196078%);stop-opacity:1;"></stop>
								<stop offset="1" style="stop-color:rgb(100%,43.921569%,38.039216%);stop-opacity:1;"></stop>
							</radialgradient>
						</defs>
						<g id="surface1">
							<path
								style=" stroke:none;fill-rule:evenodd;fill:url(#radial0);"
								d="M 75 17.871094 C 41.992188 17.871094 16.40625 42.050781 16.40625 74.707031 C 16.40625 91.789062 23.40625 106.550781 34.808594 116.746094 C 35.765625 117.601562 36.34375 118.800781 36.382812 120.085938 L 36.699219 130.507812 C 36.804688 133.835938 40.238281 135.996094 43.28125 134.65625 L 54.910156 129.519531 C 55.894531 129.085938 57 129.003906 58.039062 129.289062 C 63.382812 130.761719 69.070312 131.542969 75 131.542969 C 108.007812 131.542969 133.59375 107.363281 133.59375 74.707031 C 133.59375 42.050781 108.007812 17.871094 75 17.871094 Z M 75 17.871094 "
							></path>
							<path
								style=" stroke:none;fill-rule:evenodd;fill:rgb(100%,100%,100%);fill-opacity:1;"
								d="M 39.816406 91.328125 L 57.027344 64.019531 C 59.765625 59.675781 65.628906 58.59375 69.734375 61.675781 L 83.425781 71.945312 C 84.679688 72.886719 86.410156 72.878906 87.660156 71.929688 L 106.148438 57.898438 C 108.617188 56.027344 111.835938 58.980469 110.1875 61.601562 L 92.972656 88.910156 C 90.234375 93.253906 84.371094 94.335938 80.265625 91.253906 L 66.574219 80.984375 C 65.320312 80.042969 63.589844 80.050781 62.339844 81 L 43.851562 95.03125 C 41.382812 96.902344 38.164062 93.949219 39.816406 91.328125 Z M 39.816406 91.328125 "
							></path>
						</g>
					</svg>
				</a>
			</div>
		</div>
		<div class="tab tab-mua_hang" id="tab-mua_hang">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>HỖ TRỢ CHỌN KÍNH</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<ul class="m-chat_product">
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
    <div class="tab tab-can_thi" id="khong_can">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>HỖ TRỢ CHỌN KÍNH</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<ul class="m-chat_product">
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href> <h3 class="strong">XANIA BROWN</h3></a>
								<p>400.000VND</p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
		<div class="tab tab-kinh_ap_trong" id="tab-kinh_ap_trong">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>LENS KÍNH ÁP TRÒNG</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">Bạn có tật khúc xạ mắt không ?</p>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" loading="lazy" />
				<div class="radiobtn">
					<input id="select_option_lens1" type="radio" data-value="#can-va-loan" name="select_option_lens" value="can_kem_loan_thi" checked />
					<label for="select_option_lens1">Cận thị kèm Loạn thị</label>
				</div>
				<div class="radiobtn">
					<input id="select_option_lens2" type="radio" data-value="#can-thi" name="select_option_lens" value="can_thi" />
					<label for="select_option_lens2">Cận thị</label>
				</div>
				<div class="radiobtn">
					<input id="select_option_lens3" type="radio" data-value="#khong_can" name="select_option_lens" value="khong_can" />
					<label for="select_option_lens3">Không cận</label>
				</div>
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
		<div class="tab tab-can_thi" id="can-thi">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>LENS KÍNH ÁP TRÒNG</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">Bạn cận bao nhiêu độ?</p>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/glass_frame.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/glass_frame.png" loading="lazy" />
				<div class="radiobtn is-hidden">
					<input type="radio" data-value="#tab-size" checked />
				</div>
				<div class="tab_inner_content">
					<p class="small-title">Độ cận của mắt</p>
					<div class="gr-input">
						<div class="gr-input-item">
							<label for="mat_trai">Mắt trái:</label>
							<input name="mat-trai" type="text" value="1.0" />
						</div>
						<div class="gr-input-item">
							<label for="mat_phai">Mắt Phải:</label>
							<input name="mat-phai" type="text" value="1.0" />
						</div>
					</div>
				</div>
        <a data-fancybox="" href="<?php echo get_stylesheet_directory_uri() ?>/assets/images/huong-dan-chon-do-can-caras.jpg">Bảng tư vấn giảm độ cận </a>
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
		<div class="tab tab-can_thi" id="can-va-loan">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>LENS KÍNH ÁP TRÒNG</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">Bạn cận bao nhiêu độ?</p>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/glass_frame.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/glass_frame.png" loading="lazy" />
				<div class="radiobtn is-hidden">
					<input type="radio" data-value="#tab-size" checked />
				</div>
				<div class="tab_inner_content">
					<p class="small-title">Độ cận của mắt</p>
					<div class="gr-input">
						<div class="gr-input-item">
							<label for="mat_trai">Mắt trái:</label>
							<input name="mat-trai" type="text" value="1.0" />
						</div>
						<div class="gr-input-item">
							<label for="mat_phai">Mắt Phải:</label>
							<input name="mat-phai" type="text" value="1.0" />
						</div>
					</div>
				</div>
				<div class="tab_inner_content">
					<p class="small-title">Độ loạn của mắt</p>
					<div class="gr-input">
						<div class="gr-input-item">
							<label for="mat_trai_loan">Mắt trái:</label>
							<input name="mat_trai_loan" type="text" value="1.0" />
						</div>
						<div class="gr-input-item">
							<label for="mat_phai_loan">Mắt Phải:</label>
							<input name="mat_phai_loan" type="text" value="1.0" />
						</div>
					</div>
				</div>
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
		<div class="tab tab-giam-do-can" id="tab-giam-do-can">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>Giảm Độ Cận</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">Bạn có tật khúc xạ mắt không ?</p>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" loading="lazy" />
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
		<div class="tab tab-size" id="tab-size">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>LENS KÍNH ÁP TRÒNG</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">3. Bạn thích tròng lens size như thế nào?</p>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/eye_img.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/eye_img.png" loading="lazy" />
				<div class="radiobtn">
					<input id="size" type="radio" data-value="#daily-use" oninput="this.className = ''" name="size" value="Không cận" checked />
					<label for="size">Size S (Không giãn)</label>
				</div>
				<div class="radiobtn">
					<input id="size2" type="radio" data-value="#daily-use" oninput="this.className = ''" name="size" value="Cận và loạn thị" />
					<label for="size2">Size M (Giãn nhẹ)</label>
				</div>
				<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
			</div>
		</div>
		<div class="tab" id="daily-use">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>LENS KÍNH ÁP TRÒNG</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">4. Bạn sử dụng lens trong dịp nào?</p>
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_3.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_3.svg" loading="lazy" />
				<div class="radiobtn">
					<input id="forday" type="radio" data-value="#san-pham" oninput="this.className = ''" name="forday" value="Không cận" checked />
					<label for="forday">Hàng ngày, đi làm, đi học</label>
				</div>
				<div class="radiobtn">
					<input id="forday2" type="radio" data-value="#san-pham" oninput="this.className = ''" name="forday" value="Cận và loạn thị" />
					<label for="forday2">Đi chơi, bar, pub</label>
				</div>
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
		<div class="tab" id="san-pham">
			<div class="m-chat_top">
				<a id="prevBtn" href="javascript:;" data-back="#">
					<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white" />
					</svg>
				</a>
				<p>LENS KÍNH ÁP TRÒNG</p>
				<div class="close" onclick="toggleChat()">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z"
							fill="white"
						/>
					</svg>
				</div>
			</div>
			<div class="tab_inner">
				<p class="tab_ttl center">CARAS gửi bạn một số mẫu phù hợp với yêu cầu của bạn nhé</p>
				<ul class="sample-product">
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href>
									<h3><strong>XANIA BROWN</strong></h3>
								</a>
								<p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href>
							<div class="m-product__img"></div>
							<picture>
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.avif" type="image/avif" />
								<source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.webp" type="image/webp" />
								<img
									class="lazyload"
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/product_item.jpg"
									alt="Logo"
									loading="lazy"
									width="323"
									height="323"
								/>
							</picture>
						</a>
						<div class="m-product__content">
							<div class="m-product__content-top">
								<a href>
									<h3><strong>XANIA BROWN</strong></h3>
								</a>
								<p class="m-discount"><span>400.000VND</span><span>1350.5000VND</span></p>
							</div>
							<div class="m-product__content-bottom">
								<p>8h/ngày | 3 tháng</p>
								<div class="btn_area">
									<a class="btn_area__add" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/note_add.svg"
											alt="Logo"
											loading="lazy"
											width="16"
											height="20"
										/>
									</a>
									<a class="btn_area__del" href="#">
										<img
											class="lazyload"
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/addcart.svg"
											alt="Logo"
											loading="lazy"
											width="22"
											height="22"
										/>
									</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="m-chat_bottom"><a class="btn-next" href="javascript:;">TIẾP TỤC</a></div>
		</div>
	</form>
</div>
