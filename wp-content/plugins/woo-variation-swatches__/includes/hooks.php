<?php

defined( 'ABSPATH' ) or die( 'Keep Silent' );

// add_filter( 'woocommerce_loop_add_to_cart_link', 'wvs_pro_loop_add_to_cart_link', 20, 2 );


add_filter( 'woocommerce_loop_add_to_cart_args', 'wvs_pro_loop_add_to_cart_args', 20, 2 );

add_action(
	'init', function () {

	$position = trim( woo_variation_swatches()->get_option( 'archive_swatches_position' ) );
	$priority = ( 'after' === $position ? 30 : 7 );
	add_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', $priority );

	// Some theme doesn't use "woocommerce_after_shop_loop_item" hook. They can use this for variation template
	// If you need changing position use this on woocommerce/content-product.php like:
	// do_action('wvs_pro_variation_show_archive_variation_before_cart_button');
	// do_action('wvs_pro_variation_show_archive_variation_after_cart_button');
	add_action( sprintf( 'wvs_pro_variation_show_archive_variation_%s_cart_button', $position ), 'wvs_pro_archive_variation_template' );

	// Short Code Added.
	add_shortcode( 'wvs_show_archive_variation', 'wvs_pro_archive_variation_template' );
}
);

// Some theme doesn't use "woocommerce_after_shop_loop_item" hook. They can use this for variation template
// If you need changing position use this on woocommerce/content-product.php like:
// do_action('wvs_pro_variation_show_archive_variation');
add_action( 'wvs_pro_variation_show_archive_variation', 'wvs_pro_archive_variation_template' );


// Divi builder load Fix
add_filter(
	'default_wvs_variation_attribute_options_html', function ( $default ) {
	if ( function_exists( 'et_builder_tb_enabled' ) && et_builder_tb_enabled() ) {
		return true;
	}

	return $default;
}
);

// add_filter( 'post_class', 'wvs_pro_product_loop_post_class', 25, 3 );
add_filter( 'woocommerce_post_class', 'wvs_pro_wc_product_loop_post_class', 25, 3 );

//  Add default image class on archive by Regular Expression
// add_filter( 'woocommerce_product_get_image', 'wvs_add_default_archive_image_class' );

// Add WooCommerce Default Image
add_filter( 'wp_get_attachment_image_attributes', 'wvs_add_default_attachment_image_class', 9 );

add_filter( 'woocommerce_get_script_data', 'wvs_pro_wc_get_script_data', 10, 2 );

add_action( 'wp_ajax_nopriv_wvs_add_variation_to_cart', 'wvs_pro_add_to_cart' );

add_action( 'wp_ajax_wvs_add_variation_to_cart', 'wvs_pro_add_to_cart' );

// New Implement
add_action( 'wc_ajax_get_variations', 'wvs_pro_get_available_variations' );

/*add_action( 'wp_ajax_nopriv_wvs_get_available_variations', 'wvs_pro_get_available_variations' );

add_action( 'wp_ajax_wvs_get_available_variations', 'wvs_pro_get_available_variations' );*/

add_filter( 'woocommerce_product_add_to_cart_url', 'wvs_simple_product_cart_url', 10, 2 );

add_filter( 'wvs_available_attributes_types', 'wvs_pro_radio_attribute_type' );

add_filter(
	'wvs_product_taxonomy_meta_fields', function ( $old_fields ) {

	$fields = array(
		array(
			'label'   => esc_html__( 'Show Tooltip', 'woo-variation-swatches-pro' ),
			// <label>
			'desc'    => esc_html__( 'Individually show or hide tooltip.', 'woo-variation-swatches-pro' ),
			// description
			'id'      => 'show_tooltip',
			// name of field
			'type'    => 'select',
			'options' => array(
				'text'  => esc_html__( 'Text', 'woo-variation-swatches-pro' ),
				'image' => esc_html__( 'Image', 'woo-variation-swatches-pro' ),
				'no'    => esc_html__( 'No', 'woo-variation-swatches-pro' ),
			)
		),
		array(
			'label'      => esc_html__( 'Tooltip text', 'woo-variation-swatches-pro' ),
			// <label>
			'desc'       => esc_html__( 'Tooltip text. Default tooltip text will be term name.', 'woo-variation-swatches-pro' ),
			// description
			'id'         => 'tooltip_text',
			// name of field
			'type'       => 'text',
			'dependency' => array(
				array( '#show_tooltip' => array( 'type' => 'equal', 'value' => 'text' ) )
			)
		),
		array(
			'label'      => esc_html__( 'Tooltip image', 'woo-variation-swatches-pro' ),
			// <label>
			'desc'       => esc_html__( 'Tooltip image. Default tooltip text will be term name.', 'woo-variation-swatches-pro' ),
			// description
			'id'         => 'tooltip_image',
			// name of field
			'type'       => 'image',
			'dependency' => array(
				array( '#show_tooltip' => array( 'type' => 'equal', 'value' => 'image' ) )
			)
		)
	);

	$specific_fields = array(
		'image' => array(
			'label'   => esc_html__( 'Image Size', 'woo-variation-swatches-pro' ),
			// <label>
			'desc'    => esc_html__( 'Choose Image size, ( this will override global settings )', 'woo-variation-swatches-pro' ),
			// description
			'id'      => 'image_size',
			// name of field
			'type'    => 'select',
			'options' => array_reduce(
				get_intermediate_image_sizes(), function ( $carry, $item ) {
				$carry[ $item ] = ucwords( str_ireplace( array( '-', '_' ), ' ', $item ) );

				return $carry;
			}, array()
			)
		),
		'color' => array(
			'label'   => esc_html__( 'Is Dual Color', 'woo-variation-swatches-pro' ), // <label>
			'desc'    => esc_html__( 'Make dual color', 'woo-variation-swatches-pro' ), // description
			'id'      => 'is_dual_color', // name of field
			'type'    => 'select',
			'options' => array(
				'no'  => esc_html__( 'No', 'woo-variation-swatches-pro' ),
				'yes' => esc_html__( 'Yes', 'woo-variation-swatches-pro' ),
			)
		)
	);

	$specific_fields_2 = array(
		'color' => array(
			'label'      => esc_html__( 'Secondary Color', 'woo-variation-swatches-pro' ), // <label>
			'desc'       => esc_html__( 'Add another color', 'woo-variation-swatches-pro' ), // description
			'id'         => 'secondary_color', // name of field
			'type'       => 'color',
			'dependency' => array(
				array( '#is_dual_color' => array( 'type' => 'equal', 'value' => 'yes' ) )
			)
		)
	);

	$attributes_types = array_keys( wvs_available_attributes_types() );

	foreach ( $attributes_types as $key ) {

		if ( ! isset( $old_fields[ $key ] ) ) {
			$old_fields[ $key ] = array();
		}

		// @TODO: WIll fix and make single specific fields
		foreach ( $specific_fields as $specific_key => $specific_field ) {
			if ( $specific_key === $key ) {
				array_push( $old_fields[ $specific_key ], $specific_field );
			}
		}

		foreach ( $specific_fields_2 as $specific_key_2 => $specific_field_2 ) {
			if ( $specific_key_2 === $key ) {
				array_push( $old_fields[ $specific_key_2 ], $specific_field_2 );
			}
		}


		foreach ( $fields as $field ) {
			array_push( $old_fields[ $key ], $field );
		}
	}

	return $old_fields;
}
);


add_action( 'before_wvs_settings', function () {
	add_filter( 'wvs_reserved_fields', function () {
		return array( 'license_key' );
	} );
} );

add_action(
	'after_wvs_settings', function () {

	woo_variation_swatches()->add_setting(
		'style', esc_html__( 'Style', 'woo-variation-swatches-pro' ), array(
		// Tooltip
		array(
			'title'  => esc_html__( 'Tooltip Styling', 'woo-variation-swatches-pro' ),
			'desc'   => esc_html__( 'Change tooltip styles', 'woo-variation-swatches-pro' ),
			'fields' => apply_filters(
				'wvs_pro_tooltip_style_setting_fields', array(
					array(
						'id'                          => 'tooltip_background_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Tooltip background', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Tooltip background color', 'woo-variation-swatches-pro' ),
						'default'                     => 'rgba(51, 51, 51, 0.9)',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'id'                          => 'tooltip_text_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Tooltip text color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Tooltip text color', 'woo-variation-swatches-pro' ),
						'default'                     => '#ffffff',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'id'      => 'tooltip_image_width',
						'type'    => 'number',
						'title'   => esc_html__( 'Tooltip image width', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Tooltip image width', 'woo-variation-swatches-pro' ),
						'default' => '100',
						'suffix'  => 'px',
					),
				)
			)
		),

		// Item
		array(
			'title'  => esc_html__( 'Item Styling', 'woo-variation-swatches-pro' ),
			'desc'   => esc_html__( 'Change item display style', 'woo-variation-swatches-pro' ),
			'fields' => apply_filters(
				'wvs_pro_item_style_setting_fields', array(
					array(
						'id'                          => 'border_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Item border color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Swatches item border color. Default is: rgba(0, 0, 0, 0.3)', 'woo-variation-swatches-pro' ),
						'default'                     => 'rgba(0, 0, 0, 0.3)',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'id'      => 'border_size',
						'type'    => 'number',
						'title'   => esc_html__( 'Item border size', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Swatches item border size. Default is: 1', 'woo-variation-swatches-pro' ),
						'default' => 1,
						'min'     => 1,
						'max'     => 5,
						'size'    => 'tiny',
						'suffix'  => esc_html__( 'px', 'woo-variation-swatches-pro' )
					),
					array(
						'id'                          => 'text_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Item text color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Swatches item text color. Default is: #000000', 'woo-variation-swatches-pro' ),
						'default'                     => '#000000',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'id'                          => 'background_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Item background color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Swatches item background color. Default is: #FFFFFF', 'woo-variation-swatches-pro' ),
						'default'                     => '#FFFFFF',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
				)
			)
		),

		// Item Hover
		array(
			'title'  => esc_html__( 'Item Hover Styling', 'woo-variation-swatches-pro' ),
			'desc'   => esc_html__( 'Change item hover display style', 'woo-variation-swatches-pro' ),
			'fields' => apply_filters(
				'wvs_pro_item_hover_style_setting_fields', array(
					array(
						'id'                          => 'hover_border_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Item hover border color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Swatches item hover border color. Default is: #000000', 'woo-variation-swatches-pro' ),
						'default'                     => '#000000',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'id'      => 'hover_border_size',
						'type'    => 'number',
						'title'   => esc_html__( 'Item hover border size', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Swatches item hover border size. Default is: 3', 'woo-variation-swatches-pro' ),
						'default' => 3,
						'min'     => 1,
						'max'     => 5,
						'size'    => 'tiny',
						'suffix'  => esc_html__( 'px', 'woo-variation-swatches-pro' )
					),
					array(
						'id'                          => 'hover_text_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Item hover text color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Swatches item hover text color. Default is: #000000', 'woo-variation-swatches-pro' ),
						'default'                     => '#000000',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'id'                          => 'hover_background_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Item hover background color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Swatches item hover background color. Default is: #FFFFFF', 'woo-variation-swatches-pro' ),
						'default'                     => '#FFFFFF',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
				)
			)
		),

		// Item selected
		array(
			'title'  => esc_html__( 'Item Selected Styling', 'woo-variation-swatches-pro' ),
			'desc'   => esc_html__( 'Change selected item display style', 'woo-variation-swatches-pro' ),
			'fields' => apply_filters(
				'wvs_pro_item_selected_style_setting_fields', array(
					array(
						'id'                          => 'selected_border_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Selected item border color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Swatches selected item border color. Default is: #000000', 'woo-variation-swatches-pro' ),
						'default'                     => '#000000',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'id'      => 'selected_border_size',
						'type'    => 'number',
						'title'   => esc_html__( 'Selected item border size', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Swatches selected item border size. Default is: 2', 'woo-variation-swatches-pro' ),
						'default' => 2,
						'min'     => 1,
						'max'     => 5,
						'size'    => 'tiny',
						'suffix'  => esc_html__( 'px', 'woo-variation-swatches-pro' )
					),

					array(
						'id'                          => 'selected_text_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Selected item text color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Swatches item selected text color. Default is: #000000', 'woo-variation-swatches-pro' ),
						'default'                     => '#000000',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
					array(
						'id'                          => 'selected_background_color',
						'type'                        => 'color',
						'title'                       => esc_html__( 'Selected item  background color', 'woo-variation-swatches-pro' ),
						'desc'                        => esc_html__( 'Swatches item selected background color. Default is: #FFFFFF', 'woo-variation-swatches-pro' ),
						'default'                     => '#FFFFFF',
						'alpha'                       => true,
						'customize_control_class'     => 'WVS_Customize_Alpha_Color_Control',
						'customize_sanitize_callback' => 'sanitize_text_field',
					),
				)
			)
		)

	), apply_filters( 'wvs_pro_style_setting_default_active', false )
	);

	woo_variation_swatches()->add_setting(
		'archive', esc_html__( 'Archive / Shop', 'woo-variation-swatches-pro' ), array(
		array(
			'title'  => esc_html__( 'Visual Section', 'woo-variation-swatches-pro' ),
			'desc'   => esc_html__( 'Advanced change some visual styles on shop / archive page', 'woo-variation-swatches-pro' ),
			'fields' => apply_filters(
				'wvs_pro_archive_setting_fields', array(
					array(
						'id'      => 'show_on_archive',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Enable Swatches', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Show swatches on archive / shop page.', 'woo-variation-swatches-pro' ),
						'default' => true
					),

					array(
						'id'      => 'archive_product_wrapper',
						'type'    => 'text',
						'title'   => esc_html__( 'Product wrapper', 'woo-variation-swatches-pro' ),
						'desc'    => sprintf( __( 'Archive product wrapper selector, You can also use multiple selectors separated by comma (,). Default: %s.', 'woo-variation-swatches-pro' ), '<code>.wvs-pro-product</code>' ),
						'default' => '.wvs-pro-product'
					),

					array(
						'id'      => 'archive_image_selector',
						'type'    => 'text',
						'title'   => esc_html__( 'Image selector', 'woo-variation-swatches-pro' ),
						'desc'    => sprintf( __( 'Archive product image selector to show variation image. You can also use multiple selectors separated by comma (,). Default: %s.', 'woo-variation-swatches-pro' ), '<code>.wvs-attachment-image</code>' ),
						'default' => '.wvs-attachment-image'
					),

					array(
						'id'      => 'archive_add_to_cart_button_selector',
						'type'    => 'text',
						'title'   => esc_html__( 'Add to cart button selector', 'woo-variation-swatches-pro' ),
						'desc'    => sprintf( __( 'Archive add to cart button selector. Leave blank for default. Default should be: %s', 'woo-variation-swatches-pro' ), '<code>.wvs_add_to_cart_button</code>' ),
						'default' => ''
					),

					array(
						'id'      => 'archive_swatches_position',
						'type'    => 'radio',
						'title'   => esc_html__( 'Display position', 'woo-variation-swatches-pro' ),
						'desc'    => sprintf( __( 'Show archive swatches position. <br> <span style="color: red">Note: Some theme remove default woocommerce hooks that why it\'s may not work each theme. For theme compatibility <a target="_blank" href="%s">please open a ticket</a>.</span>', 'woo-variation-swatches-pro' ), 'https://getwooplugins.com/tickets/' ),
						'default' => 'after',
						'options' => array(
							'before' => esc_html__( 'Before add to cart button', 'woo-variation-swatches-pro' ),
							'after'  => esc_html__( 'After add to cart button', 'woo-variation-swatches-pro' )
						)
					),
					array(
						'id'      => 'archive_align',
						'type'    => 'select',
						'size'    => 'tiny',
						'title'   => esc_html__( 'Swatches align', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Swatches align on archive page', 'woo-variation-swatches-pro' ),
						'default' => 'left',
						'options' => array(
							'left'   => esc_html__( 'Left', 'woo-variation-swatches-pro' ),
							'center' => esc_html__( 'Center', 'woo-variation-swatches-pro' ),
							'right'  => esc_html__( 'Right', 'woo-variation-swatches-pro' )
						)
					),

					array(
						'id'      => 'ajax_load_archive_variation',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Load variation by ajax', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Load archive page variation by ajax.', 'woo-variation-swatches-pro' ),
						'default' => false,
						'is_new'  => true
					),

					array(
						'id'      => 'show_tooltip_on_archive',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Enable tooltip', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Show tooltip on archive / shop page.', 'woo-variation-swatches-pro' ),
						'default' => true
					),
					array(
						'id'      => 'show_clear_on_archive',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Show clear link', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Show clear link on archive / shop page.', 'woo-variation-swatches-pro' ),
						'default' => true
					),

					array(
						'id'      => 'show_swatches_on_filter_widget',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Show on filter widget', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Show variation swatches on filter widget.', 'woo-variation-swatches-pro' ),
						'default' => true,
						'is_new'  => true
					),

					array(
						'id'      => 'archive_width',
						'type'    => 'number',
						'title'   => esc_html__( 'Item width', 'woo-variation-swatches-pro' ),
						'desc'    => __( 'Variation item width on archive page', 'woo-variation-swatches-pro' ),
						'default' => 30,
						'min'     => 10,
						'max'     => 200,
						'suffix'  => 'px'
					),
					array(
						'id'      => 'archive_height',
						'type'    => 'number',
						'title'   => esc_html__( 'Item height', 'woo-variation-swatches-pro' ),
						'desc'    => __( 'Variation item height on archive page', 'woo-variation-swatches-pro' ),
						'default' => 30,
						'min'     => 10,
						'max'     => 200,
						'suffix'  => 'px'
					),
					array(
						'id'      => 'archive_font_size',
						'type'    => 'number',
						'title'   => esc_html__( 'Item Font Size', 'woo-variation-swatches-pro' ),
						'desc'    => __( 'Archive product variation item font size', 'woo-variation-swatches-pro' ),
						'default' => 16,
						'min'     => 8,
						'max'     => 24,
						'suffix'  => 'px'
					)
				)
			)
		)
	), apply_filters( 'wvs_pro_archive_setting_default_active', false )
	);

	woo_variation_swatches()->add_setting(
		'special', esc_html__( 'Special Attributes', 'woo-variation-swatches-pro' ), array(

		array(
			'title'  => esc_html__( 'Single Variation Image Preview', 'woo-variation-swatches-pro' ),
			'desc'   => esc_html__( 'Switch variation image when single attribute selected on product page.', 'woo-variation-swatches-pro' ),
			'fields' => apply_filters(
				'wvs_pro_single_variation_image_setting_fields', array(
					array(
						'id'      => 'enable_single_variation_preview',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Variation Image Preview', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Show single attribute variation image based on specific attribute select on product page.', 'woo-variation-swatches-pro' ),
						'default' => false
					),

					array(
						'id'      => 'single_variation_preview_attribute',
						'type'    => 'select',
						'size'    => 'tiny',
						'title'   => esc_html__( 'Choose Attribute', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Choose an attribute to show variation image', 'woo-variation-swatches-pro' ),
						'default' => '',
						'options' => wvs_pro_get_attribute_taxonomies_option(),
						'require' => array( 'enable_single_variation_preview' => array( 'type' => '!empty' ) )
					),

					array(
						'id'      => 'single_variation_preview_js_event',
						'type'    => 'select',
						'size'    => 'tiny',
						'title'   => esc_html__( 'Fire JS Event', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Fire Variation JS event on variation preview. Default is: "When Variation Shown"', 'woo-variation-swatches-pro' ),
						'default' => 'show_variation',
						'is_new'  => true,
						'options' => array(
							'show_variation'  => esc_html__( 'When Variation Shown', 'woo-variation-swatches-pro' ),
							'found_variation' => esc_html__( 'When Variation Found', 'woo-variation-swatches-pro' )
						),
						'require' => array( 'enable_single_variation_preview' => array( 'type' => '!empty' ) )
					),

					/*array(
						'id'      => 'using_custom_gallery_script',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Using custom gallery', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Theme using custom gallery script.', 'woo-variation-swatches-pro' ),
						'default' => false
					),*/

					array(
						'id'      => 'enable_single_variation_preview_archive',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Preview on Shop Page', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Enable single attribute variation image based on specific attribute select on shop / archive page also.', 'woo-variation-swatches-pro' ),
						'default' => false,
						'require' => array( 'enable_single_variation_preview' => array( 'type' => '!empty' ) )
					),
				)
			)
		),

		array(
			'title'  => esc_html__( 'Catalog mode', 'woo-variation-swatches-pro' ),
			'desc'   => esc_html__( 'Show single attribute as catalog mode on shop / archive pages', 'woo-variation-swatches-pro' ),
			'fields' => apply_filters(
				'wvs_pro_large_catalog_setting_fields', array(
					array(
						'id'      => 'enable_catalog_mode',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Show Single Attribute', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Show Single Attribute taxonomies on archive page', 'woo-variation-swatches-pro' ),
						'default' => false
					),

					array(
						'id'      => 'catalog_mode_attribute',
						'type'    => 'select',
						'size'    => 'tiny',
						'title'   => esc_html__( 'Choose Attribute', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Choose an attribute to show on catalog mode', 'woo-variation-swatches-pro' ),
						'default' => '',
						'options' => wvs_pro_get_attribute_taxonomies_option(),
						'require' => array( 'enable_catalog_mode' => array( 'type' => '!empty' ) )
					),
					array(
						'id'      => 'trigger_catalog_mode',
						'type'    => 'select',
						'size'    => 'tiny',
						'title'   => esc_html__( 'Catalog Mode Display Event', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Show catalog mode image display event.', 'woo-variation-swatches-pro' ),
						'default' => 'click',
						'options' => array(
							'click' => esc_html__( 'on Click', 'woo-variation-swatches-pro' ),
							'hover' => esc_html__( 'on Hover', 'woo-variation-swatches-pro' ),
						),
						'require' => array( 'enable_catalog_mode' => array( 'type' => '!empty' ) )
					),

					array(
						'id'      => 'linkable_attribute',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Linkable Attribute', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Keep attribute variation selected on product page after clicking from catalog page', 'woo-variation-swatches-pro' ),
						'default' => false,
						'is_new'  => true,
						'require' => array(
							'trigger_catalog_mode' => array( 'type' => 'equal', 'value' => 'hover' ),
							//'enable_catalog_mode'  => array( 'type' => '!empty' ),
						)
					),

					array(
						'id'      => 'catalog_mode_display_limit',
						'type'    => 'number',
						'size'    => 'tiny',
						'title'   => esc_html__( 'Attribute display limit', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Catalog mode attribute display limit. Default is 0. Means no limit.', 'woo-variation-swatches-pro' ),
						'default' => '0',
						'require' => array( 'enable_catalog_mode' => array( 'type' => '!empty' ) )
					),
				)
			)
		),
		array(
			'title'  => esc_html__( 'Large Size Attribute Section', 'woo-variation-swatches-pro' ),
			'desc'   => esc_html__( 'Make a attribute taxonomies size large on single product', 'woo-variation-swatches-pro' ),
			'fields' => apply_filters(
				'wvs_pro_large_size_setting_fields', array(
					array(
						'id'      => 'enable_large_size',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Show Attribute In Large', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Show Attribute taxonomies in large size', 'woo-variation-swatches-pro' ),
						'default' => false
					),

					array(
						'id'      => 'large_size_attribute',
						'type'    => 'select',
						'size'    => 'tiny',
						'title'   => esc_html__( 'Choose Attribute', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Choose an attribute to make it large', 'woo-variation-swatches-pro' ),
						'default' => '',
						'options' => wvs_pro_get_attribute_taxonomies_option(),
						'require' => array( 'enable_large_size' => array( 'type' => '!empty' ) )
					),

					array(
						'id'      => 'large_size_width',
						'type'    => 'number',
						'title'   => esc_html__( 'Width', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Large variation item width', 'woo-variation-swatches-pro' ),
						'default' => 40,
						'min'     => 10,
						'max'     => 200,
						'suffix'  => 'px',
						'require' => array( 'enable_large_size' => array( 'type' => '!empty' ) )
					),

					array(
						'id'      => 'large_size_height',
						'type'    => 'number',
						'title'   => esc_html__( 'Height', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Large variation item height', 'woo-variation-swatches-pro' ),
						'default' => 40,
						'min'     => 10,
						'max'     => 200,
						'suffix'  => 'px',
						'require' => array( 'enable_large_size' => array( 'type' => '!empty' ) )
					),

					array(
						'id'      => 'large_size_font_size',
						'type'    => 'number',
						'title'   => esc_html__( 'Font Size', 'woo-variation-swatches-pro' ),
						'desc'    => esc_html__( 'Large variation font size', 'woo-variation-swatches-pro' ),
						'default' => 16,
						'min'     => 8,
						'max'     => 24,
						'suffix'  => 'px',
						'require' => array( 'enable_large_size' => array( 'type' => '!empty' ) )
					)
				)
			)
		)
	), apply_filters( 'wvs_pro_special_setting_default_active', false )
	);

	woo_variation_swatches()->add_setting(
		'license', esc_html__( 'License Key', 'woo-variation-swatches-pro' ), array(
		array(
			'title'            => esc_html__( 'License Section', 'woo-variation-swatches-pro' ),
			'desc'             => esc_html__( 'Product license key', 'woo-variation-swatches-pro' ),
			'customize_hidden' => true,
			'fields'           => array(
				array(
					'id'      => 'license_key',
					'type'    => 'text',
					'title'   => esc_html__( 'License Key', 'woo-variation-swatches-pro' ),
					'desc'    => sprintf( __( 'Please add product license key and add your domain(s) on <a target="_blank" href="%s">GetWooPlugins.com -> My Downloads</a> to get automatic update.', 'woo-variation-swatches-pro' ), 'https://getwooplugins.com/my-account/downloads/' ),
					'default' => '',
				),
			)
		)
	), false
	);

}
);

add_filter(
	'wvs_simple_setting_fields', function ( $fields ) {

	$fields[] = array(
		'id'      => 'default_to_image',
		'type'    => 'checkbox',
		'title'   => esc_html__( 'Auto Dropdowns to Image', 'woo-variation-swatches-pro' ),
		'desc'    => esc_html__( 'Convert default dropdowns to image type if variation has an image.', 'woo-variation-swatches-pro' ),
		'default' => true
	);
	$fields[] = array(
		'id'      => 'default_image_type_attribute',
		'type'    => 'select',
		'title'   => esc_html__( 'Default Image Type Attribute', 'woo-variation-swatches-pro' ),
		'options' => array(
			'__first' => esc_html__( 'First attribute', 'woo-variation-swatches-pro' ),
			'__max'   => esc_html__( 'Maximum attribute', 'woo-variation-swatches-pro' ),
			'__min'   => esc_html__( 'Minimum attribute', 'woo-variation-swatches-pro' )
		),
		'default' => '__first'
	);

	return $fields;
}
);

add_filter(
	'wvs_advanced_setting_fields', function ( $fields ) {
	// unset( $fields[ 'advanced-pro' ] );

	$field = array(
		array(
			'id'      => 'disable_threshold',
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Disable ajax threshold', 'woo-variation-swatches-pro' ),
			'desc'    => esc_html__( 'Disable ajax variation threshold to make all variation work like non ajax style.', 'woo-variation-swatches-pro' ),
			'default' => false
		),
		array(
			'id'      => 'hide_out_of_stock_variation',
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Disable Out of stock', 'woo-variation-swatches-pro' ),
			'desc'    => esc_html__( 'Disable out of stock attribute variations', 'woo-variation-swatches-pro' ),
			'default' => true
		),

		array(
			'id'      => 'clickable_out_of_stock_variation',
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Clickable Out Of Stock', 'woo-variation-swatches-pro' ),
			'desc'    => esc_html__( 'Crossed or blur swatch items but Clickable Out Of Stock attribute variations', 'woo-variation-swatches-pro' ),
			'default' => false,
			'is_new'  => true,
			'require' => array( 'hide_out_of_stock_variation' => array( 'type' => 'empty' ) )
		),

		array(
			'id'      => 'enable_linkable_variation_url',
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Generate variation url', 'woo-variation-swatches-pro' ),
			'desc'    => esc_html__( 'Generate sharable url based on selected variation attributes.', 'woo-variation-swatches-pro' ),
			'default' => false
		),

		// EDIT ID to show_variation_stock_info
		array(
			'id'      => 'show_variation_stock_info',
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Variation stock info', 'woo-variation-swatches-pro' ),
			'desc'    => esc_html__( 'Show variation product stock info', 'woo-variation-swatches-pro' ),
			'default' => false,
			'is_new'  => true,
		),

		array(
			'id'      => 'stock_label_display_threshold',
			'type'    => 'number',
			'title'   => esc_html__( 'Minimum stock threshold', 'woo-variation-swatches-pro' ),
			'desc'    => esc_html__( 'When stock reaches this amount stock label will be shown.', 'woo-variation-swatches-pro' ),
			'default' => 5,
			'min'     => 1,
			'max'     => 99,
			'is_new'  => true,
			'require' => array( 'show_variation_stock_info' => array( 'type' => '!empty' ) )
		),
	);

	array_splice( $fields, 2, 0, $field );

	return $fields;
}
);

add_filter(
	'wvs_no_individual_settings', function ( $default, $args, $is_default_to_image, $is_default_to_button ) {

	$product = $args['product'];

	$attribute        = $args['attribute'];
	$saved_attributes = wvs_pro_get_product_option( $product->get_id() );
	$id               = sanitize_title( $attribute );

	if ( empty( $saved_attributes ) ) {
		return true;
	} else {

		if ( isset( $saved_attributes[ $id ] ) ) {
			$saved_attribute = $saved_attributes[ $id ];

			$is_default_to_image_button = ( $is_default_to_image || $is_default_to_button );

			if ( $saved_attribute['type'] === 'select' && $is_default_to_image_button ) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
}, 10, 4
);

add_filter(
	'wvs_variation_attribute_options_html', function ( $data, $args, $is_default_to_image, $is_default_to_button ) {

	$product   = $args['product'];
	$options   = $args['options'];
	$attribute = $args['attribute'];

	// $saved_attributes = get_post_meta( $product->get_id(), '_wvs_product_attributes', true );
	$saved_attributes = wvs_pro_get_product_option( $product->get_id() );
	$saved_attributes = array_filter( $saved_attributes );

	//$id = sanitize_title( $attribute );
	$old_id = strtolower( sanitize_title( $attribute ) );
	$id     = $attribute;


	// Backward Compatibility for 1.0.2
	if ( isset( $saved_attributes[ $old_id ] ) && $id !== $old_id ) {
		$saved_attributes[ $id ] = $saved_attributes[ $old_id ];
		unset( $saved_attributes[ $old_id ] );
	}
	// Backward Compatibility for 1.1.14 for serializeJSON colon issue
	/*if ( isset( $saved_attributes[ $attribute ] ) && sanitize_title( $attribute ) !== $attribute ) {
		$saved_attributes[ sanitize_title( $attribute ) ] = $saved_attributes[ $attribute ];
		unset( $saved_attributes[ $attribute ] );
	}*/

	if ( empty( $saved_attributes ) ) {
		return $data;
	} else {

		if ( isset( $saved_attributes[ $id ] ) ) {
			$saved_attribute = $saved_attributes[ $id ];

			$is_default_to_image_button = ( $is_default_to_image || $is_default_to_button );

			if ( $saved_attribute['type'] === 'select' && $is_default_to_image_button ) {
				return $data;
			}

			ob_start();

			$args['type'] = isset( $args['type'] ) ? $args['type'] : $saved_attribute['type'];

			wvs_pro_variation_attribute_options( $args, $saved_attribute['type'] !== 'select' );

			if ( $saved_attribute['type'] !== 'select' ) {

				$content = wvs_variable_item( $saved_attribute['type'], $options, $args, $saved_attribute );

				echo wvs_variable_items_wrapper( $content, $saved_attribute['type'], $args, $saved_attribute );
			}

			return ob_get_clean();

		} else {
			return $data;
		}
	}
}, 10, 4
);

add_filter(
	'wvs_is_default_to_image', function ( $current, $args ) {
	$product          = $args['product'];
	$saved_attributes = wvs_pro_get_product_option( $product->get_id() );

	if ( $current && isset( $saved_attributes['default_to_image'] ) ) {
		return wc_string_to_bool( $saved_attributes['default_to_image'] );
	}

	return $current;

}, 10, 2
);

add_filter(
	'wvs_default_image_type_attribute', function ( $max_attribute_key, $args ) {
	$product          = $args['product'];
	$saved_attributes = wvs_pro_get_product_option( $product->get_id() );

	return ( isset( $saved_attributes['default_image_type_attribute'] ) && ! empty( $saved_attributes['default_image_type_attribute'] ) ) ? $saved_attributes['default_image_type_attribute'] : $max_attribute_key;

}, 10, 2
);

add_filter(
	'wvs_is_default_to_button', function ( $current, $args ) {
	$product          = $args['product'];
	$saved_attributes = wvs_pro_get_product_option( $product->get_id() );

	if ( $current && isset( $saved_attributes['default_to_button'] ) ) {
		return wc_string_to_bool( $saved_attributes['default_to_button'] );
	}

	return $current;

}, 10, 2
);

add_filter(
	'wvs_variable_items_wrapper_class', function ( $classes, $type, $args, $saved_attribute ) {

	$class = array();
	if ( $saved_attribute ) {
		$type = $saved_attribute['type'];

		//$show_tooltip = $saved_attribute[ 'tooltip' ] === 'yes';
		$style = $saved_attribute['style'];

		$classes[] = "{$type}-variable-wrapper";

		$classes[] = $style;
	}

	$is_archive = ( isset( $args['is_archive'] ) && $args['is_archive'] );

	if ( woo_variation_swatches()->get_option( 'enable_large_size' ) && ! $is_archive ) {
		$attribute_name = woo_variation_swatches()->get_option( 'large_size_attribute' );
		// $attribute_type = wvs_pro_attribute_taxonomy_type_by_name( $attribute_name );
		// or $attribute_type === $type
		if ( $attribute_name === $args['attribute'] ) {
			$classes[] = 'wvs-large-variable-wrapper';
		}
	}

	if ( $is_archive ) {
		$classes[] = 'wvs-archive-variable-wrapper';
	}


	if ( woo_variation_swatches()->get_option( 'enable_catalog_mode' ) && $is_archive ) {
		$attribute_name = woo_variation_swatches()->get_option( 'catalog_mode_attribute' );
		// $product_settings = (array) get_post_meta( $args[ 'product' ]->get_id(), '_wvs_product_attributes', true );
		$product_settings = (array) wvs_pro_get_product_option( $args['product']->get_id() );

		if ( isset( $product_settings['catalog_attribute'] ) && ! empty( $product_settings['catalog_attribute'] ) ) {
			$attribute_name = trim( $product_settings['catalog_attribute'] );
		}

		// $attribute_type = wvs_pro_attribute_taxonomy_type_by_name( $attribute_name );
		// or $attribute_type === $type

		if ( wc_variation_attribute_name( $attribute_name ) === wc_variation_attribute_name( $args['attribute'] ) ) {
			$classes[] = 'wvs-catalog-variable-wrapper';
		}
	}


	return array_unique( array_values( $classes ) );
}, 10, 4
);

// Extra Variation Data
add_filter(
	'woocommerce_available_variation', function ( $variation, $productObject, $variationObject ) {

	$thumbnail_size = apply_filters( 'woocommerce_thumbnail_size', 'woocommerce_thumbnail' );

	if ( isset( $variation['image']['thumb_src'] ) && ! empty( $variation['image']['thumb_src'] ) ) {
		$variation['image']['thumb_srcset'] = wp_get_attachment_image_srcset( $variationObject->get_image_id(), $thumbnail_size );
		$variation['image']['thumb_sizes']  = wp_get_attachment_image_sizes( $variationObject->get_image_id(), $thumbnail_size );
	}

	if ( (bool) woo_variation_swatches()->get_option( 'show_variation_stock_info' ) ) {

		$variation['wvs_stock_left'] = '';

		if ( $variationObject->managing_stock() ) {
			$stock_amount                = $variationObject->get_stock_quantity();
			$variation['wvs_stock_left'] = sprintf( esc_html__( '%s left', 'woo-variation-swatches-pro' ), $stock_amount );
		}
	}

	/*if ( woo_variation_swatches()->get_option( 'hide_out_of_stock_variation' ) ) {
		return $variationObject->is_in_stock() ? $variation : false;
	}*/

	return $variation;
}, 100, 3
);

add_filter(
	'woo_variation_swatches_js_options', function ( $options ) {
	global $post;

	$options['archive_image_selector'] = trim( woo_variation_swatches()->get_option( 'archive_image_selector' ) );

	//$options['archive_add_to_cart_select_options'] = apply_filters( 'woo_variation_swatches_archive_add_to_cart_select_options', '' );
	//$options['archive_add_to_cart_text']           = apply_filters( 'woo_variation_swatches_archive_add_to_cart_text', '' );

	$options['archive_product_wrapper'] = apply_filters( 'woo_variation_swatches_archive_product_wrapper', trim( woo_variation_swatches()->get_option( 'archive_product_wrapper' ) ) );

	// jQuery Like CSS Selector
	$options['archive_cart_button_selector'] = apply_filters( 'woo_variation_swatches_archive_add_to_cart_button_selector', trim( woo_variation_swatches()->get_option( 'archive_add_to_cart_button_selector' ) ) );

	// Based On WooCommerce Settings
	$options['is_archive_ajax_add_to_cart'] = ( 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) );

	$options['clickable_out_of_stock'] = ! wc_string_to_bool( woo_variation_swatches()->get_option( 'hide_out_of_stock_variation' ) ) && wc_string_to_bool( woo_variation_swatches()->get_option( 'clickable_out_of_stock_variation' ) );

	$enable_catalog_mode = (bool) woo_variation_swatches()->get_option( 'enable_catalog_mode' );

	$options['enable_catalog_mode'] = $enable_catalog_mode;
	$options['linkable_attribute']  = false;

	if ( $enable_catalog_mode ) {
		$options['catalog_mode_event']     = woo_variation_swatches()->get_option( 'trigger_catalog_mode' );
		$options['linkable_attribute']     = ( (bool) woo_variation_swatches()->get_option( 'linkable_attribute' ) && ( woo_variation_swatches()->get_option( 'trigger_catalog_mode' ) == 'hover' ) );
		$options['catalog_mode_attribute'] = wc_variation_attribute_name( woo_variation_swatches()->get_option( 'catalog_mode_attribute' ) );
	}

	$options['enable_single_variation_preview'] = (bool) woo_variation_swatches()->get_option( 'enable_single_variation_preview' );

	$options['enable_single_variation_preview_archive'] = (bool) woo_variation_swatches()->get_option( 'enable_single_variation_preview_archive' );

	$options['single_variation_preview_attribute'] = trim( woo_variation_swatches()->get_option( 'single_variation_preview_attribute' ) );
	$options['single_variation_preview_js_event']  = trim( woo_variation_swatches()->get_option( 'single_variation_preview_js_event' ) );

	// $options[ 'using_custom_gallery_script' ] = (bool) woo_variation_swatches()->get_option( 'using_custom_gallery_script' );

	$options['archive_image_selector'] = apply_filters( 'woo_variation_swatches_archive_image_selector', trim( woo_variation_swatches()->get_option( 'archive_image_selector' ) ) );

	$options['enable_linkable_variation_url'] = (bool) woo_variation_swatches()->get_option( 'enable_linkable_variation_url' );
	$options['show_variation_stock_info']     = (bool) woo_variation_swatches()->get_option( 'show_variation_stock_info' );
	$options['stock_label_display_threshold'] = absint( woo_variation_swatches()->get_option( 'stock_label_display_threshold' ) );

	$options['wc_bundles_enabled'] = class_exists( 'WC_Bundles' );

	if ( is_product() ) {
		$product_id = $post->ID;
		if ( trim( wvs_pro_get_product_option( $product_id, 'single_variation_preview_attribute' ) ) ) {
			$options['single_variation_preview_attribute'] = trim( wvs_pro_get_product_option( $product_id, 'single_variation_preview_attribute' ) );
		}
		$options['product_permalink'] = trim( get_permalink() );
	}

	// Convert unicode char to css selector
	$options['single_variation_preview_attribute'] = str_ireplace( '%', '\\%', sanitize_title( $options['single_variation_preview_attribute'] ) );

	return $options;
}
);

/*add_filter( 'woo_variation_swatches_script_dependency', function ( $scripts ) {

	array_push( $scripts, 'woo-variation-swatches-pro' );

	return $scripts;
} );*/

// Hide Out Of stock
add_filter(
	'woocommerce_variation_is_active', function ( $active, $variation ) {

	$hide_out_of_stock = wc_string_to_bool( woo_variation_swatches()->get_option( 'hide_out_of_stock_variation' ) );
	if ( ! $variation->is_in_stock() && $hide_out_of_stock ) {
		return false;
	}


	return $active;
}, 10, 2
);
	