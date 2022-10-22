<?php
if (function_exists('acf_add_local_field_group')):

    // Check function exists.
    if (function_exists('acf_add_options_page'))
    {
        // Add parent.
        $option_page = acf_add_options_page(array(
            'page_title' => __('Theme General Settings') ,
            'menu_title' => __('Theme Settings') ,
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect' => false
        ));
        acf_add_options_sub_page(array(
            'page_title' => 'Settings Product Detail',
            'menu_title' => 'Settings Product Detail',
            'parent_slug' => 'theme-general-settings',
        ));
        acf_add_options_sub_page(array(
            'page_title' => 'Settings Home Page',
            'menu_title' => 'Settings Home Page',
            'parent_slug' => 'theme-general-settings',
        ));
        acf_add_options_sub_page(array(
            'page_title' => 'Settings Chatbot',
            'menu_title' => 'Settings Chatbot',
            'parent_slug' => 'theme-general-settings',
        ));
    }
    acf_add_local_field_group(array(
        'key' => 'group_63429592ab849',
        'title' => 'Sản Phẩm mua kèm',
        'fields' => array(
            array(
                'key' => 'field_634295a5efecc',
                'label' => 'list product together',
                'name' => 'list_product_together',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                    2 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_62a6ef8cb1bec',
        'title' => 'Insert Headers and Footers',
        'fields' => array(
            array(
                'key' => 'field_62a6f0317cd8d',
                'label' => 'Insert Headers',
                'name' => 'insert_headers',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ) ,
            array(
                'key' => 'field_62a6f0567cd8e',
                'label' => 'Insert Footers',
                'name' => 'insert_footers',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ) ,
        ) ,
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-general-settings',
                ) ,
            ) ,
        ) ,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'permalink',
            1 => 'the_content',
            2 => 'excerpt',
            3 => 'discussion',
            4 => 'comments',
            5 => 'revisions',
            6 => 'slug',
            7 => 'author',
            8 => 'format',
            9 => 'page_attributes',
            10 => 'featured_image',
            11 => 'categories',
            12 => 'tags',
            13 => 'send-trackbacks',
        ) ,
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_62a6f19c21d00',
        'title' => 'Insert Schemas',
        'fields' => array(
            array(
                'key' => 'field_62a6f1f867341',
                'label' => 'Insert Schema',
                'name' => 'insert_schema',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ) ,
        ) ,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ) ,
            ) ,
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ) ,
            ) ,
        ) ,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'send-trackbacks',
        ) ,
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_62aab5628ec8a',
        'title' => 'Post Suggest',
        'fields' => array(
            array(
                'key' => 'field_62aab562a9c3c',
                'label' => 'List Post Suggest',
                'name' => 'list_post_suggest',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'post_type' => array(
                    0 => 'post',
                ) ,
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                    2 => 'taxonomy',
                ) ,
                'elements' => array(
                    0 => 'featured_image',
                ) ,
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ) ,
        ) ,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ) ,
            ) ,
        ) ,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'send-trackbacks',
        ) ,
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_62aab345dbca7',
        'title' => 'Product Suggest',
        'fields' => array(
            array(
                'key' => 'field_62aab372741a1',
                'label' => 'List Product Suggest',
                'name' => 'list_product_suggest',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'post_type' => array(
                    0 => 'product',
                ) ,
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                    2 => 'taxonomy',
                ) ,
                'elements' => array(
                    0 => 'featured_image',
                ) ,
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ) ,
        ) ,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ) ,
            ) ,
        ) ,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'send-trackbacks',
        ) ,
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    acf_add_local_field_group(array(
        'key' => 'group_62f2935a489d0',
        'title' => 'Show Post in Homepage',
        'fields' => array(
            array(
                'key' => 'field_62f293839e5a0',
                'label' => 'List post show',
                'name' => 'list_news_show',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'post_type' => '',
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                    2 => 'taxonomy',
                ) ,
                'elements' => '',
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ) ,
        ) ,
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-settings-home-page',
                ) ,
            ) ,
        ) ,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_62f9ddc5ed83a',
        'title' => 'Thông số sản phẩm',
        'fields' => array(
            array(
                'key' => 'field_62f9dde56af6b',
                'label' => 'Thông số sản phẩm',
                'name' => 'thong-so-san-pham',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'default_value' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ) ,
        ) ,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ) ,
            ) ,
        ) ,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_62f9e07065ed0',
        'title' => 'Thông tin & Bảo hành',
        'fields' => array(
            array(
                'key' => 'field_62f9e094d38c3',
                'label' => 'Bảo Hành',
                'name' => 'bao_hanh',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'default_value' => '<p>Cảm ơn Quý khách đã tin dùng và chọn mua sản phẩm của chúng tôi. Vì lý do nào đó Quý khách không hài lòng với sản phẩm đã chọn mua, hãy liên hệ ngay với chúng tôi khi có bất kỳ thắc mắc cần giải đáp, tư vấn khi cần bảo hành, sửa, đổi sản phẩm.</p>
	<h2>
		<strong>1. Hình thức bảo hành:</strong>
	</h2>
	<p>Bảo hành bằng thông tin lưu trữ khách hàng cung cấp cho CARAS (Bao gồm: Tên + Số điện thoại)</p>
	<h2>
		<strong>2. Điều kiện bảo hành:</strong>
	</h2>
	<h3>
		<strong>2.1. Những trường hợp đủ điều kiện bảo hành</strong>
	</h3>
	<ul>
		<li aria-level="1">Sản phẩm còn thời hạn bảo hành và trùng khớp với thông tin mua hàng.</li>
		<li aria-level="1">Sản phẩm bị lỗi cấu tạo (không phải do tác động của người dùng*).</li>
		<li aria-level="1">Cơ địa khách hàng không phù hợp với kính áp tròng.</li>
		<li aria-level="1">Tất cả lỗi do lens lỗi: lens cộm, lens đeo bị mờ, lens sử dụng bị nóng, rát, sử dụng không đúng đồng tử mắt, lens rút nước.</li>
	</ul>
	<h3>
		<strong>2.2. Những trường hợp không đủ điều kiện bảo hành</strong>
	</h3>
	<ul>
		<li aria-level="1">Kính bị rách, xước do trong quá trình sử dụng.</li>
		<li aria-level="1">Khách hàng cho thông tin độ cận không chính xác.</li>
		<li aria-level="1">Kính hết hạn sử dụng.</li>
		<li aria-level="1">Kính quá thời hạn bảo hành.</li>
		<li aria-level="1">Khách vệ sinh lens không đúng theo hướng dẫn.</li>
		<li aria-level="1">Phụ kiện đi kèm hết hạn sử dụng hay không phù hợp cho kính gây cộm, đỏ rát.</li>
		<li aria-level="1">Kính dính dị vật do tác động bụi bẩn, mỹ phẩm, …</li>
	</ul>
	<h2>
		<strong>3. Thời hạn bảo hành</strong>
	</h2>
	<p>
		<i>[Thời hạn bảo hành được tính dựa vào ngày nhận hàng thành công]</i>
	</p>
	<h3>
		<strong>3.1. Trường hợp lens bị rách, xước</strong>
	</h3>
	<ul>
		<li aria-level="1">10 ngày: được đổi sang sản phẩm mới cùng loại lens.</li>
		<li aria-level="1">Từ 11 ngày – 20 ngày: hỗ trợ 80% chi phí mua lại lens mới.</li>
		<li aria-level="1">Từ 21 ngày – 30 ngày: hỗ trợ 65% chi phí mua lại lens mới.</li>
		<li aria-level="1">Từ 31 ngày – 45 ngày: hỗ trợ 50% chi phí mua lại lens mới.</li>
		<li aria-level="1">Từ 46 ngày – 60 ngày: hỗ trợ 30% chi phí mua lại lens mới.</li>
		<li aria-level="1">Từ 61 ngày – 75 ngày: hỗ trợ 15% chi phí mua lại lens mới.</li>
	</ul>
	<p>
		<strong>Lưu ý:</strong>
		<i>Chỉ áp dụng “1 lần” đối với khách hàng mua lens bị rách trong quá trình sử dụng và chưa hết thời hạn sử dụng của lens. Và mẫu được hỗ trợ bảo hành là mẫu đã mua trên hóa đơn. Về sản phẩm mua lại được hỗ trợ thời gian bảo hành tính theo thời gian của đơn hàng mua đầu tiên.</i>
	</p>
	<h3>
		<strong>3.2. Trường hợp đeo lens bị ngứa, đỏ, cộm, xốn, khô, các vấn đề liên quan đến mắt khi đeo lens</strong>
	</h3>
	<ul>
		<li aria-level="1">Ba (03) tháng đối với hóa đơn sản phẩm kính áp tròng bất kì kèm dung dịch ngâm và dung dịch nhỏ mắt dòng cao cấp.</li>
		<li aria-level="1">Một (01) tháng đối với hóa đơn sản phẩm kính áp tròng bất kì kèm dung dịch ngâm và dung dịch dòng nhỏ mắt phổ thông.</li>
		<li aria-level="1">Mười Lăm (15) ngày đối với hóa đơn sản phẩm kính áp tròng bất kì không kèm dung dịch ngâm và nhỏ mắt.</li>
	</ul>
	<h2>
		<strong>4. Dịch vụ khách hàng</strong>
	</h2>
	<h3>
		<strong>4.1. Những trường hợp hoàn tiền</strong>
	</h3>
	<p>Cơ địa không phù hợp để sử dụng lens CARAS, mắt khách hàng không phù hợp với các thành phần cấu tạo lens, size lens, phụ kiện ngâm – nhỏ mắt.</p>
	<h3>
		<strong>4.2. Những trường hợp đáp ứng nhu cầu, mong muốn của khách hàng</strong>
	</h3>
	<p>Khách hàng muốn đổi, trả sản phẩm sẽ được hỗ trợ trong 6 tháng tính từ ngày mua hàng. Với điều kiện sản phẩm còn nguyên vẹn, chưa qua sử dụng (nguyên tem, nguyên seal)</p>
	<p>Khách hàng mua hàng qua website/ hotline hoặc mua trực tiếp tại cửa hàng vui lòng nhắn tin vào Fanpage CARASvn với các nội dung: <strong>TÊN + SĐT + NGÀY MUA HÀNG</strong> để kích hoạt chế độ bảo hành. </p>
	<p>
		<strong>
			<img alt="" width="600" height="400" data-srcset="https://caraslens.com/wp-content/uploads/chinh-sach-giao-hang-600x400.jpg 600w, https://caraslens.com/wp-content/uploads/chinh-sach-giao-hang.jpg 1024w" data-src="https://caraslens.com/wp-content/uploads/chinh-sach-giao-hang-600x400.jpg" data-sizes="(max-width: 600px) 100vw, 600px" class="aligncenter size-medium wp-image-22080 lazyloaded" src="https://caraslens.com/wp-content/uploads/chinh-sach-giao-hang-600x400.jpg" loading="lazy" sizes="(max-width: 600px) 100vw, 600px" srcset="https://caraslens.com/wp-content/uploads/chinh-sach-giao-hang-600x400.jpg 600w, https://caraslens.com/wp-content/uploads/chinh-sach-giao-hang.jpg 1024w">
		</strong>
	</p>
	<p>
		<strong>Lưu ý:</strong>
	</p>
	<p>Chi phí vận chuyển khi đổi sản phẩm lỗi cho khách không thuộc TPHCM và Hà Nội hoàn toàn miễn phí.</p>
	<p>Quý khách ở TPHCM và Hà Nội vui lòng đến showroom để được hỗ trợ bảo hành và kiểm tra mắt nhằm đảm bảo quyền lợi tốt nhất.</p>
	<p>Sản phẩm lỗi chỉ được đổi mới bằng sản phẩm cùng loại quý khách đã mua (theo hóa đơn).</p>
	<p>Để tránh những trải nghiệm không như ý và đảm bảo quyền lợi, quý khách vui lòng kiểm tra kĩ sản phẩm trước khi thanh toán.</p>
	<p>
		<strong>* Sản phẩm đã chịu sự tác động của người dùng là như thế nào?</strong>
	</p>
	<p>Được sử dụng và vệ sinh không theo bảng hướng dẫn sử dụng kèm theo.</p>
	<p>Rách hoặc xước do tác động mạnh, dung dịch bảo quản hoặc nhỏ mắt hết hạn sử dụng, thông tin độ cận không chính xác, có chứa dị vật (bụi bẩn, lông mi, mảnh vụn và dầu từ mỹ phẩm…) trên bề mặt kính hoặc trong lòng khay đựng.</p>
	<p>
		<strong>** Thời hạn bảo hành kính tính từ ngày mua hàng và loại phụ kiện kèm theo trên cùng một hóa đơn</strong>
	</p>
	<p>Trường hợp quý khách mua số lượng kính nhiều hơn số lượng phụ kiện, thì thời hạn bảo hành của số lượng kính chênh lệch sẽ được tính là bảy (07) ngày.</p>
	<p>
		<strong>*** Riêng trường hợp kính gây khô mắt</strong>
	</p>
	<p>Thời hạn bảo hành sẽ phụ thuộc vào loại dung dịch nhỏ mắt kèm theo (tương tự cách tính thời hạn bảo hành theo dung dịch bảo quản)</p>',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ) ,
            array(
                'key' => 'field_62fa121e80f74',
                'label' => 'Thông số sản phẩm',
                'name' => 'thong_so_san_pham_init',
                'type' => 'textarea',
                'instructions' => 'Khi không điền ở trang chi tiết sp thì mặc định load dữ liệu thông số sp từ cài đặt này',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'default_value' => '<table>
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
						<img class="lazyload styleimg01" src="/wp-content/themes/storefront-child/assets/images/ft2.png" data-src="/wp-content/themes/storefront-child/assets/images/ft2.png" alt="byt" loading="lazy" width="260" height="90">
					</picture>
					<picture>
						<source srcset="/wp-content/themes/storefront-child/assets/images/chong-hang-gia.webp" type="image/webp">
						<img class="lazyload styleimg02" src="/wp-content/themes/storefront-child/assets/images/chong-hang-gia.png" data-src="/wp-content/themes/storefront-child/assets/images/chong-hang-gia.png" alt="chong hang gia" loading="lazy" width="90" height="90">
					</picture>
					<picture>
						<img class="lazyload styleimg03" src="/wp-content/themes/storefront-child/assets/images/bsi02.png" data-src="/wp-content/themes/storefront-child/assets/images/bsi02.png" alt="bsi" loading="lazy" width="160" height="90">
					</picture>
				</td>
			</tr>
		</tbody>
	</table>',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ) ,
        ) ,
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-settings-product-detail',
                ) ,
            ) ,
        ) ,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    acf_add_local_field_group(array(
        'key' => 'group_630e20de96454',
        'title' => 'Job field',
        'fields' => array(
            array(
                'key' => 'field_630e2110b3ac7',
                'label' => 'Location',
                'name' => 'location',
                'type' => 'text',
                'instructions' => 'Nhập vị trí địa lý',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'Nguyễn Đình Chiểu, Quận 3, TP. Hồ Chí Minh',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_630e2165b3ac8',
                'label' => 'Time',
                'name' => 'time',
                'type' => 'text',
                'instructions' => 'Nhập thời gian',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '14:00 - 22:00',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_630e218fb3ac9',
                'label' => 'Số lượng nhân sự',
                'name' => 'number_job',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'Nữ | 5 người',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_630e21c4b3aca',
                'label' => 'Mức Lương',
                'name' => 'price_ranger',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '6.000.000 - 8.000.000 VND',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'tuyen_dung',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    acf_add_local_field_group(array(
        'key' => 'group_63307668417b7',
        'title' => 'Time Read',
        'fields' => array(
            array(
                'key' => 'field_63307673aae3f',
                'label' => 'Thời Gian Đọc',
                'name' => 'time_read',
                'type' => 'number',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 10,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    acf_add_local_field_group(array(
        'key' => 'group_630af818b5465',
        'title' => 'Insert schema Product',
        'fields' => array(
          array(
            'key' => 'field_630af828d32a1',
            'label' => 'insert schema product',
            'name' => 'insert_schema_product',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'product',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
      ));
      acf_add_local_field_group(array(
        'key' => 'group_634e0b26a8ce1',
        'title' => 'Product info Manual',
        'fields' => array(
            array(
                'key' => 'field_634e0b5502c74',
                'label' => 'Select color',
                'name' => 'select_color',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'choco' => 'Choco',
                    'brown' => 'Brown',
                    'gray' => 'Gray',
                    'blue' => 'Blue',
                    'gold' => 'Gold',
                    'green' => 'Green',
                    'violet' => 'Ciolet',
                    'black' => 'Black',
                ),
                'default_value' => array(
                ),
                'allow_null' => 0,
                'multiple' => 1,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value',
                'placeholder' => '',
            ),
            array(
                'key' => 'field_634e0d5bf4bd0',
                'label' => 'Thời gian đeo',
                'name' => 'time_deo',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '24h| Lens 1 ngày',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_634e0d85f4bd1',
                'label' => 'Độ ẩm',
                'name' => 'do_am',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_634e0db2f4bd2',
                'label' => 'Loại giãn tròng',
                'name' => 'type_gian_trong',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'Giãn tròng',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_634e0e70812f0',
                'label' => 'Gdia',
                'name' => 'gdia',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '13.8mm',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_6343734ce4903',
        'title' => 'Chatbot',
        'fields' => array(
            array(
                'key' => 'field_6346fddbd40da',
                'label' => 'Xin Chào -> Mua Hàng -> Link Đặt Hàng',
                'name' => 'product_list_1',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_6346fe5459b17',
                'label' => 'Tư vấn về kính áp tròng 	 -> Không cận',
                'name' => 'product_list_2',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_63538a8aacec2',
                'label' => 'Cận thị kèm Loạn thị',
                'name' => 'product_list_3',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_6353688a4c3e2',
                'label' => 'Product 274',
                'name' => '274',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_635368d308f78',
                'label' => 'Product 275',
                'name' => '275',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_6353699483cca',
                'label' => 'Product 276',
                'name' => '276',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_635369ed2faf2',
                'label' => 'Product 284',
                'name' => '284',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_63536a10cf37a',
                'label' => 'Product 285',
                'name' => '285',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_63536a2bcf92e',
                'label' => 'Product 286',
                'name' => '286',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_63536a48049f8',
                'label' => 'Product 374',
                'name' => '374',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_63536a6829b47',
                'label' => 'Product 375',
                'name' => '375',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_63536a818028b',
                'label' => 'Product 376',
                'name' => '376',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_63536adbd747f',
                'label' => 'Product 384',
                'name' => '384',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_63536b200e0b9',
                'label' => 'Product 385',
                'name' => '385',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_63536b5d40980',
                'label' => 'Product 386',
                'name' => '386',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_635371e4bbd86',
                'label' => 'Product Default',
                'name' => 'product_default',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'product',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-settings-chatbot',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    

    endif;

