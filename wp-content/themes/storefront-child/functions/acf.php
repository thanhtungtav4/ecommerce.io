<?php
if( function_exists('acf_add_local_field_group') ):

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {
			// Add parent.
			$option_page = acf_add_options_page(array(
				'page_title'    => __('Theme General Settings'),
				'menu_title'    => __('Theme Settings'),
				'menu_slug'     => 'theme-general-settings',
				'capability'    => 'edit_posts',
				'redirect'      => false
		));
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Settings Product Detail',
			'menu_title'	=> 'Settings Product Detail',
			'parent_slug'	=> 'settubg-product-detail',
		));
		}

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
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'new_lines' => '',
			),
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
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-general-settings',
				),
			),
		),
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
		),
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
					'value' => 'post',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'send-trackbacks',
		),
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
				),
				'post_type' => array(
					0 => 'post',
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
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'send-trackbacks',
		),
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
		'hide_on_screen' => array(
			0 => 'send-trackbacks',
		),
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));

endif;