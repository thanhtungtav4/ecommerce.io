<?php

defined( 'ABSPATH' ) or die( 'Keep Silent' );

if ( ! function_exists( 'wvs_pro_cache_variation_ajax' ) ):
	function wvs_pro_cache_variation_ajax( $headers ) {

		global $wp_query;
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		/*if ( ! empty( $_GET['wc-ajax'] ) ) {
			$wp_query->set( 'wc-ajax', sanitize_text_field( wp_unslash( $_GET['wc-ajax'] ) ) );
		}*/
		$action = $wp_query->get( 'wc-ajax' );
		$action = $action ? sanitize_text_field( $action ) : '';

		if ( in_array( $action, array( 'get_variations' ), true ) ) {
			$expires                  = gmdate( 'D, d M Y H:i:s T', current_time( 'timestamp' ) + DAY_IN_SECONDS );
			$cache_control            = sprintf( "public, max-age=%d", DAY_IN_SECONDS );
			$headers['Expires']       = $expires;
			$headers['Cache-Control'] = $cache_control;
			$headers['Pragma']        = 'cache'; //  backwards compatibility with HTTP/1.0 caches
		}

		return $headers;
	}
endif;

add_action( 'init', function () {
	add_filter( 'nocache_headers', 'wvs_pro_cache_variation_ajax' );
} );

// Ajax request of non ajax variation
if ( ! function_exists( 'wvs_pro_get_available_variations' ) ):
	function wvs_pro_get_available_variations() {

		ob_start();

		if ( empty( $_GET ) || empty( $_GET['product_id'] ) ) {
			wp_send_json( false );
		}

		$product_id     = absint( $_GET['product_id'] );
		$currency       = get_woocommerce_currency();
		$use_transient  = wc_string_to_bool( woo_variation_swatches()->get_option( 'use_transient' ) );
		$transient_name = sprintf( 'wvs_archive_available_variations_%s_%s', $product_id, $currency );
		$cache          = new Woo_Variation_Swatches_Cache( $transient_name, 'wvs_archive_template' );

		// Clear cache
		if ( isset( $_GET['wvs_clear_transient'] ) ) {
			$cache->delete_transient();
		}

		// Create cache
		if ( $use_transient && $transient_data = $cache->get_transient( $transient_name ) ) {

			if ( ! empty( $transient_data ) ) {
				wp_send_json( $transient_data );
			}
		}

		$variable_product = wc_get_product( $product_id );

		if ( ! $variable_product ) {
			wp_send_json( false );
		}

		$data = apply_filters( 'wvs_pro_get_available_variations', array_values( $variable_product->get_available_variations() ), $variable_product );
		// Set cache
		if ( $use_transient ) {
			$cache->set_transient( $data, DAY_IN_SECONDS );
		}

		wp_send_json( $data ? $data : false );
	}
endif;

// WPML
add_action( 'icl_make_duplicate', function ( $main_post_id, $lang, $post_array, $copied_post_id ) {

	$options = (array) get_post_meta( $main_post_id, '_wvs_product_attributes', true );
	$options = wvs_wpml_translate_options( $options );
	update_post_meta( $copied_post_id, '_wvs_product_attributes', $options );

}, 10, 4 );

// Get Pro Product Option
if ( ! function_exists( 'wvs_pro_get_product_option' ) ):
	function wvs_pro_get_product_option( $product_id, $option_name = false ) {

		$options = (array) get_post_meta( $product_id, '_wvs_product_attributes', true );
		$options = wvs_wpml_translate_options( $options, $product_id );

		if ( ! $option_name ) {
			return $options;
		}

		if ( isset( $options[ $option_name ] ) ) {
			return $options[ $option_name ];
		}

		return null;
	}
endif;

// WPML Translate Options
if ( ! function_exists( 'wvs_wpml_translate_options' ) ) {
	function wvs_wpml_translate_options( $value, $product_id ) {
		foreach ( (array) $value as $slug => $data ) {
			if ( isset( $value[ $slug ]['terms'] ) ) {
				$value[ $slug ]['terms'] = wvs_wpml_translate_terms( $slug, $data['terms'], $product_id );
			}
		}

		return $value;
	}
}

// WPML Translate Terms Data
if ( ! function_exists( 'wvs_wpml_translate_terms' ) ) {
	function wvs_wpml_translate_terms( $slug, $terms, $product_id ) {
		$out = array();

		/*$terms    = wc_get_product_terms( $product_id, $slug, array( 'fields' => 'all' ) );
		$term_ids = wp_list_pluck( $terms, 'term_id' );*/

		foreach ( (array) $terms as $term_id => $term ) {
			if ( ! empty( $term['image_id'] ) && $term['type'] == 'image' ) {
				$term['image_id'] = wvs_wpml_object_id( $term['image_id'], 'attachment' );
			}

			// $term_id         = apply_filters( 'wpml_object_id', $term_id, $slug, true );
			if ( term_exists( $term_id, $slug ) ) {
				$term_id = wvs_wpml_object_id( $term_id, $slug );
			}

			$out[ $term_id ] = $term;
		}

		return $out;
	}
}

// Radio Attribute Type
if ( ! function_exists( 'wvs_pro_radio_attribute_type' ) ) :
	function wvs_pro_radio_attribute_type( $types ) {
		$types['radio'] = array(
			'title'   => esc_html__( 'Radio', 'woo-variation-swatches-pro' ),
			'output'  => 'wvs_radio_variation_attribute_options',
			'preview' => 'wvs_radio_variation_attribute_preview'
		);

		return $types;
	}
endif;

// Add to cart ajax function
if ( ! function_exists( 'wvs_pro_add_to_cart' ) ):
	function wvs_pro_add_to_cart() {

		ob_start();

		$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$product           = wc_get_product( $product_id );
		$quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
		$product_status    = get_post_status( $product_id );
		$variation_id      = absint( $_POST['variation_id'] );
		$variation         = $_POST['variation'];

		// If Not a variation
		if ( 'variable' != $product->get_type() || empty( $variation_id ) ) {
			// If there was an error adding to the cart, redirect to the product page to show any errors
			$data = array(
				'error'       => true,
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
			);

			wp_send_json( $data );
		}

		if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) && 'publish' === $product_status ) {

			do_action( 'woocommerce_ajax_added_to_cart', $product_id );

			if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
				wc_add_to_cart_message( array( $product_id => $quantity ), true );
			}

			// Return fragments
			WC_AJAX::get_refreshed_fragments();

		} else {

			// If there was an error adding to the cart, redirect to the product page to show any errors
			$data = array(
				'error'       => true,
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
			);

			wp_send_json( $data );
		}
	}
endif;

// Loop cart arguments
if ( ! function_exists( 'wvs_pro_loop_add_to_cart_args' ) ):
	function wvs_pro_loop_add_to_cart_args( $args, $product ) {

		// return $args;

		if ( $product->is_type( 'variable' ) ) {

			if ( ! woo_variation_swatches()->get_option( 'show_on_archive' ) ) {
				return $args;
			}

			// $get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

			$enable_catalog_mode = wc_string_to_bool( woo_variation_swatches()->get_option( 'enable_catalog_mode' ) );

			if ( ! isset( $args['class'] ) ) {
				$args['class'] = '';
			}
			if ( ! $enable_catalog_mode ) {
				$args['class'] .= ' wvs_add_to_cart_button';
			}

			// Based On WooCommerce Settings

			if ( ! isset( $args['attributes'] ) ) {
				$args['attributes'] = array();
			}

			// Borrow some methods from simple product
			$classname         = WC_Product_Factory::get_classname_from_product_type( 'simple' );
			$as_single_product = new $classname( $product->get_id() );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['data-add-to-cart-aria-label']    = wp_strip_all_tags( $as_single_product->add_to_cart_description() );
				$args['attributes']['data-select-options-aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
			}

			$args['attributes']['data-add-to-cart']    = wc_esc_json( wp_kses_post( apply_filters( 'woo_variation_swatches_archive_add_to_cart_text', apply_filters( 'woo_variation_swatches_archive_add_to_cart_button_text', apply_filters( 'add_to_cart_text', $as_single_product->add_to_cart_text() ), $product ), $product, $as_single_product ) ) );
			$args['attributes']['data-select-options'] = wc_esc_json( wp_kses_post( apply_filters( 'woo_variation_swatches_archive_add_to_cart_select_options', apply_filters( 'woo_variation_swatches_archive_add_to_cart_button_text', apply_filters( 'variable_add_to_cart_text', $product->add_to_cart_text() ), $product ), $product, $as_single_product ) ) );

			if ( 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) && ! $enable_catalog_mode ) {
				$args['class'] .= ' wvs_ajax_add_to_cart';
			} else {
				$args['attributes']['data-product_permalink'] = $product->add_to_cart_url();
				// $args[ 'attributes' ][ 'data-add_to_cart_url' ]   = $product->is_purchasable() && $product->is_in_stock() ? remove_query_arg( 'added-to-cart', add_query_arg( 'add-to-cart', $product->get_id() ) ) : get_permalink( $product->get_id() );
				$args['attributes']['data-add_to_cart_url'] = $product->is_purchasable() && $product->is_in_stock() ? wvs_pro_get_current_url() : esc_url( $product->get_permalink() );
			}

			// variation_id
			$args['attributes']['data-variation_id'] = "";
			$args['attributes']['data-variation']    = "";

			/*$args['variations'] = array(
				'available_variations' => $get_variations ? array_values( $product->get_available_variations() ) : false,
				'attributes'           => $product->get_variation_attributes(),
				'selected_attributes'  => $product->get_default_attributes(),
			);*/
		}

		return $args;
	}
endif;

// Add to cart link
if ( ! function_exists( 'wvs_pro_loop_add_to_cart_link' ) ):
	function wvs_pro_loop_add_to_cart_link( $link, $product ) {
		echo $link;

		if ( apply_filters( 'wvs_pro_use_add_to_cart_link_archive_template', true, $product ) ) {
			wvs_pro_archive_variation_template();
		}
	}
endif;

// Add to cart options
if ( ! function_exists( 'wvs_pro_loop_add_to_cart_options' ) ):
	function wvs_pro_loop_add_to_cart_options( $args = array() ) {
		global $product;

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode(
					' ', array_filter(
						array(
							'button',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => wp_strip_all_tags( $product->add_to_cart_description() ),
					'rel'              => 'nofollow',
				),
			);

			return apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );
		}

		return false;
	}
endif;

// Archive Variation Template
if ( ! function_exists( 'wvs_pro_archive_variation_template' ) ):
	function wvs_pro_archive_variation_template( $args = array() ) {
		global $product;

		if ( ! $product ) {
			return;
		}

		if ( ! woo_variation_swatches()->get_option( 'show_on_archive' ) ) {
			return;
		}

		// echo $product->get_type();

		// $product->is_type( 'variable' ) == variable | variation
		do_action( 'before_wvs_pro_archive_variation_template_load', $product );

		// For variable product
		if ( $product->is_type( 'variable' ) && apply_filters( 'wvs_pro_show_archive_variation_template', true, $product ) ) {

			// for variable product
			$available_variations = $product->get_available_variations();

			if ( empty( $available_variations ) && false !== $available_variations ) {
				return;
			}


			$attributes = $product->get_variation_attributes();

			$get_variations       = count( $product->get_children() ) <= apply_filters( 'woo_variation_swatches_archive_ajax_variation_threshold', 30, $product );
			$available_variations = $get_variations ? $product->get_available_variations() : false;

			// $options = wvs_pro_loop_add_to_cart_options( $args );

			// Enqueue variation scripts.
			wp_enqueue_script( 'wc-add-to-cart-variation' );

			wc_get_template( 'wvs-archive-variable.php', compact( 'product', 'attributes', 'available_variations' ), '', trailingslashit( woo_variation_swatches_pro()->template_path() ) );
		}


		// For single variation product
		if ( $product->is_type( 'variation' ) && apply_filters( 'wvs_pro_show_archive_variation_template', true, $product ) ) {

			// for variable product


			$attributes            = $product->get_variation_attributes();
			$data_store            = WC_Data_Store::load( 'product' );
			$variable_product      = new WC_Product_Variable( $product->get_parent_id() );
			$selected_variation_id = $data_store->find_matching_product_variation( $variable_product, $attributes );
			// $attributes   = $product->get_variation_attributes( true );


			$available_variations = $variable_product->get_available_variations();
			$selected_variation   = $variable_product->get_available_variation( $selected_variation_id );
			// $available_variations = $variable_product->get_available_variation( $selected_variation_id );


			if ( empty( $available_variations ) && false !== $available_variations ) {
				return;
			}


			// $options = wvs_pro_loop_add_to_cart_options( $args );

			// Enqueue variation scripts.
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			wc_get_template( 'wvs-archive-variation.php', compact( 'product', 'variable_product', 'attributes', 'available_variations', 'selected_variation' ), '', trailingslashit( woo_variation_swatches_pro()->template_path() ) );

		}


		do_action( 'after_wvs_pro_archive_variation_template_load', $product );
	}
endif;

// Product loop post class
if ( ! function_exists( 'wvs_pro_product_loop_post_class' ) ):
	function wvs_pro_product_loop_post_class( $classes, $class, $product_id ) {

		if ( apply_filters( 'disable_wvs_pro_post_class', false, $product_id ) ) {
			return $classes;
		}

		if ( 'product' === get_post_type( $product_id ) ) {
			$product = wc_get_product( $product_id );
			if ( $product->is_type( 'variable' ) ) {
				$classes[] = 'wvs-pro-product';
				$classes[] = sprintf( 'wvs-pro-%s-cart-button', woo_variation_swatches()->get_option( 'archive_swatches_position' ) );
			}
		}

		return array_unique( $classes );
	}
endif;

if ( ! function_exists( 'wvs_pro_wc_product_loop_post_class' ) ):
	function wvs_pro_wc_product_loop_post_class( $classes, $product ) {

		if ( apply_filters( 'disable_wvs_pro_post_class', false, $product ) ) {
			return $classes;
		}

		if ( $product->is_type( 'variable' ) ) {
			$classes[] = 'wvs-pro-product';
			$classes[] = sprintf( 'wvs-pro-%s-cart-button', woo_variation_swatches()->get_option( 'archive_swatches_position' ) );
		}

		return array_unique( $classes );
	}
endif;

// Change script data
if ( ! function_exists( 'wvs_pro_wc_get_script_data' ) ):
	function wvs_pro_wc_get_script_data( $params, $handle ) {
		if ( 'wc-add-to-cart-variation' === $handle ) {
			$params = array_merge(
				$params, array(
					'ajax_url'                => WC()->ajax_url(),
					'i18n_view_cart'          => apply_filters( 'wvs_pro_view_cart_text', esc_attr__( 'View cart', 'woocommerce' ) ),
					'i18n_add_to_cart'        => apply_filters( 'wvs_pro_add_to_cart_text', esc_attr__( 'Add to cart', 'woocommerce' ) ),
					'i18n_select_options'     => apply_filters( 'wvs_pro_select_options_text', esc_attr__( 'Select options', 'woocommerce' ) ),
					'cart_url'                => apply_filters( 'woocommerce_add_to_cart_redirect', wc_get_cart_url(), null ),
					'is_cart'                 => is_cart(),
					'cart_redirect_after_add' => get_option( 'woocommerce_cart_redirect_after_add' ),
					'enable_ajax_add_to_cart' => get_option( 'woocommerce_enable_ajax_add_to_cart' )
				)
			);

			wc_get_template( 'wvs-variation-template.php', array(), '', trailingslashit( woo_variation_swatches_pro()->template_path() ) );
		}

		return $params;
	}
endif;

// Get Current URL
if ( ! function_exists( 'wvs_pro_get_current_url' ) ):
	function wvs_pro_get_current_url( $args = array() ) {
		global $wp;

		return esc_url( trailingslashit( home_url( add_query_arg( $args, $wp->request ) ) ) );
	}
endif;

// Simple Product Add To Cart URL Fix
if ( ! function_exists( 'wvs_simple_product_cart_url' ) ):
	function wvs_simple_product_cart_url( $url, $product ) {

		if ( 'simple' === $product->get_type() ) {
			$url = $product->is_purchasable() && $product->is_in_stock() ? remove_query_arg( 'added-to-cart', add_query_arg( 'add-to-cart', $product->get_id(), wvs_pro_get_current_url() ) ) : get_permalink( $product->get_id() );
		}

		return $url;
	}
endif;

// Attribute select-box
if ( ! function_exists( 'wvs_pro_variation_attribute_options' ) ):
	function wvs_pro_variation_attribute_options( $args = array(), $hide_select = true ) {

		$args = wp_parse_args(
			$args, array(
				'options'          => false,
				'attribute'        => false,
				'product'          => false,
				'selected'         => false,
				'name'             => '',
				'id'               => '',
				'class'            => '',
				'type'             => '',
				'show_option_none' => esc_html__( 'Choose an option', 'woo-variation-swatches-pro' )
			)
		);

		$type                  = $args['type'];
		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : wc_variation_attribute_name( $attribute );
		$id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class                 = $args['class'];
		$show_option_none      = $args['show_option_none'] ? true : false;
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : esc_html__( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		if ( $product && $hide_select ) {
			echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' wvs-saved-attrs hide woo-variation-raw-select woo-variation-raw-type-' . esc_attr( $type ) . '" style="display:none" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
		} else {
			echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' wvs-saved-attrs" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
		}

		if ( $args['show_option_none'] ) {
			echo '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
		}

		if ( ! empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options, true ) ) {
						echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) . '</option>';
					}
				}
			} else {
				foreach ( $options as $option ) {
					// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
					$selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
					echo '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) ) . '</option>';
				}
			}
		}

		echo '</select>';
	}
endif;


if ( ! function_exists( 'wvs_archive_swatches_has_more' ) ):
	function wvs_archive_swatches_has_more( $count ) {

		$limit        = absint( woo_variation_swatches()->get_option( 'catalog_mode_display_limit' ) );
		$catalog_mode = (bool) woo_variation_swatches()->get_option( 'enable_catalog_mode' );

		if ( empty( $limit ) || empty( $catalog_mode ) ) {
			return false;
		}

		return $limit <= $count;
	}
endif;


if ( ! function_exists( 'wvs_archive_swatches_more' ) ):
	function wvs_archive_swatches_more( $product_id, $total_items ) {

		$limit      = absint( woo_variation_swatches()->get_option( 'catalog_mode_display_limit' ) );
		$rest_items = absint( $total_items ) - $limit;
		$more_text  = sprintf( esc_html__( '+%s More', 'woo-variation-swatches-pro' ), number_format_i18n( $rest_items ) );

		$data = '<li class="woo-variation-swatches-variable-item-more">';
		$data .= sprintf( '<a style="font-size: small" href="%s">%s</a>', esc_url( get_permalink( $product_id ) ), $more_text );
		$data .= '</li>';

		return $data;
	}
endif;

// Default WooCommerce Image Class .wp-post-image
function wvs_add_default_archive_image_class( $image ) {
	$pattern  = '@class=["|\']([^"\']+)["|\']@i';
	$is_match = (bool) preg_match( $pattern, $image, $matches );

	if ( $is_match && isset( $matches[1] ) && $matches[1] ) {
		$class   = trim( $matches[1] );
		$classes = (array) explode( ' ', $class );
		array_push( $classes, 'wp-post-image' );
		$classes = implode( ' ', array_unique( $classes ) );

		$image = str_ireplace( $class, $classes, $image );
	}

	return $image;
}

function wvs_add_default_attachment_image_class( $attr ) {
	if ( ! is_admin() ) {

		$classes = (array) explode( ' ', $attr['class'] );

		array_push( $classes, 'wvs-attachment-image' );

		$attr['class'] = implode( ' ', array_unique( $classes ) );
	}


	return $attr;
}

// Function override
/*if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	function woocommerce_get_product_thumbnail( $size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0 ) {
		global $product;

		$image_size  = apply_filters( 'single_product_archive_thumbnail_size', $size );
		$image_class = "attachment-$image_size size-$image_size wp-post-image";

		return $product ? $product->get_image( $image_size, array( 'class' => $image_class ) ) : '';
	}
}*/

// Function override
function wvs_variable_item( $type, $options, $args, $saved_attribute = array() ) {

	$product              = $args['product'];
	$attribute            = $args['attribute'];
	$data                 = '';
	$is_archive           = ( isset( $args['is_archive'] ) && $args['is_archive'] );
	$show_archive_tooltip = (bool) woo_variation_swatches()->get_option( 'show_tooltip_on_archive' );
	$linkable_attribute   = ( (bool) woo_variation_swatches()->get_option( 'linkable_attribute' ) && ( woo_variation_swatches()->get_option( 'trigger_catalog_mode' ) == 'hover' ) );

	$product_url    = $product->get_permalink();
	$attribute_name = wc_variation_attribute_name( $attribute );

	if ( ! empty( $options ) ) {
		$name          = uniqid( wc_variation_attribute_name( $attribute ) );
		$display_count = 0;

		if ( $product && taxonomy_exists( $attribute ) ) {

			$terms       = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );
			$total_terms = count( $terms );
			foreach ( $terms as $term ) {
				if ( in_array( $term->slug, $options, true ) ) {

					$term_id = $term->term_id;
					// $term_id = apply_filters( 'wpml_object_id', $term->term_id, $term->slug, TRUE  );

					$type = isset( $saved_attribute['terms'][ $term_id ]['type'] ) ? $saved_attribute['terms'][ $term_id ]['type'] : $type;

					$is_selected             = ( sanitize_title( $args['selected'] ) == $term->slug );
					$selected_class          = $is_selected ? 'selected' : '';
					$screen_reader_html_attr = $is_selected ? ' aria-checked="true"' : ' aria-checked="false"';
					$data_url                = '';
					if ( $linkable_attribute && $is_archive ) {
						$url      = esc_url( add_query_arg( $attribute_name, $term->slug, $product_url ) );
						$data_url = sprintf( ' data-url="%s"', $url );
					}

					// Tooltip
					// from attributes
					$default_tooltip_type = get_term_meta( $term_id, 'show_tooltip', true );
					$default_tooltip_type = empty( $default_tooltip_type ) ? 'text' : $default_tooltip_type;

					// from product attribute
					$default_tooltip_type = ( isset( $saved_attribute['show_tooltip'] ) && ! empty( $saved_attribute['show_tooltip'] ) ) ? $saved_attribute['show_tooltip'] : $default_tooltip_type;

					// from attribute
					$default_tooltip_text = trim( get_term_meta( $term_id, 'tooltip_text', true ) );
					// from attribute fallback
					$default_tooltip_text = empty( $default_tooltip_text ) ? trim( apply_filters( 'wvs_variable_item_tooltip', $term->name, $term, $args ) ) : $default_tooltip_text;

					// from attribute
					$default_tooltip_image = trim( get_term_meta( $term_id, 'tooltip_image', true ) );


					// from product attribute item
					$tooltip_type  = ( isset( $saved_attribute['terms'][ $term_id ] ) && ! empty( $saved_attribute['terms'][ $term_id ]['tooltip_type'] ) ) ? trim( $saved_attribute['terms'][ $term_id ]['tooltip_type'] ) : $default_tooltip_type;
					$tooltip_text  = ( isset( $saved_attribute['terms'][ $term_id ] ) && ! empty( $saved_attribute['terms'][ $term_id ]['tooltip_text'] ) ) ? trim( $saved_attribute['terms'][ $term_id ]['tooltip_text'] ) : $default_tooltip_text;
					$tooltip_image = ( isset( $saved_attribute['terms'][ $term_id ] ) && ! empty( $saved_attribute['terms'][ $term_id ]['tooltip_image'] ) ) ? trim( $saved_attribute['terms'][ $term_id ]['tooltip_image'] ) : $default_tooltip_image;

					// from product attribute item

					if ( isset( $saved_attribute['terms'][ $term_id ] ) && empty( $saved_attribute['terms'][ $term_id ]['tooltip_type'] ) ) {
						$tooltip_type = $default_tooltip_type;
						$tooltip_text = $default_tooltip_text;
					}

					$show_tooltip = ! empty( $tooltip_type ) || $tooltip_type !== 'no';

					if ( $is_archive ) {
						$show_tooltip = $show_archive_tooltip;
					}

					$tooltip_html_attr = '';
					$tooltip_html_attr .= ( $show_tooltip && $tooltip_text && $tooltip_type == 'text' ) ? sprintf( ' data-wvstooltip="%s"', esc_attr( $tooltip_text ) ) : '';

					$tooltip_image_width = absint( woo_variation_swatches()->get_option( 'tooltip_image_width' ) );

					$tooltip_image_size = apply_filters( 'wvs_tooltip_image_size', array(
						$tooltip_image_width,
						$tooltip_image_width
					) );
					// $tooltip_image_width = apply_filters( 'wvs_tooltip_image_width', sprintf( '%dpx', $tooltip_image_width ) );

					$tooltip_html_image = ( $show_tooltip && $tooltip_type == 'image' && $tooltip_image ) ? wp_get_attachment_image_src( $tooltip_image, $tooltip_image_size ) : false;

					if ( wp_is_mobile() ) {
						$tooltip_html_attr .= ( $show_tooltip ) ? ' tabindex="2"' : '';
					}

					// More...
					if ( $is_archive && wvs_archive_swatches_has_more( $display_count ) ) {
						$data .= wvs_archive_swatches_more( $product->get_id(), $total_terms );
						break;
					}

					if ( ! empty( $tooltip_html_image ) ):
						// $tooltip_html_attr .= sprintf( ' style="--tooltip-background: url(\'%s\'); --tooltip-width: %spx; --tooltip-height: %spx;"', $tooltip_html_image[ 0 ], $tooltip_html_image[ 1 ], $tooltip_html_image[ 2 ] );
						$tooltip_html_attr .= sprintf( ' style="--tooltip-background: url(\'%s\'); --tooltip-width: %spx; --tooltip-height: %spx;"', $tooltip_html_image[0], $tooltip_image_width, $tooltip_image_width );
						$selected_class    .= ' wvs-has-image-tooltip';
					endif;


					$data .= sprintf( '<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" data-title="%5$s" title="%5$s" data-value="%3$s" role="radio" tabindex="0"><div class="variable-item-contents">', $data_url . $screen_reader_html_attr . $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ) );

					/*if ( ! empty( $tooltip_html_image ) ):
						$data .= '<span style="width: ' . $tooltip_image_width . '" class="image-tooltip-wrapper"><img alt="' . $term->name . '" src="' . $tooltip_html_image[ 0 ] . '" width="' . $tooltip_html_image[ 1 ] . '" height="' . $tooltip_html_image[ 2 ] . '" /></span>';
						// $data .= '<span style="width: ' . $tooltip_image_width . '" class="image-tooltip-wrapper">' . $tooltip_html_image . '</span>';
					endif;*/

					switch ( $type ):
						case 'color':
							$global_color           = sanitize_hex_color( get_term_meta( $term->term_id, 'product_attribute_color', true ) );
							$global_is_dual         = (bool) ( get_term_meta( $term->term_id, 'is_dual_color', true ) === 'yes' );
							$global_secondary_color = sanitize_hex_color( get_term_meta( $term->term_id, 'secondary_color', true ) );

							$color           = ( isset( $saved_attribute['terms'][ $term_id ] ) && ! empty( $saved_attribute['terms'][ $term_id ]['color'] ) ) ? $saved_attribute['terms'][ $term_id ]['color'] : $global_color;
							$is_dual         = ( isset( $saved_attribute['terms'][ $term_id ] ) && isset( $saved_attribute['terms'][ $term_id ]['is_dual_color'] ) && ! empty( $saved_attribute['terms'][ $term_id ]['is_dual_color'] ) ) ? ( $saved_attribute['terms'][ $term_id ]['is_dual_color'] === 'yes' ) : $global_is_dual;
							$secondary_color = ( isset( $saved_attribute['terms'][ $term_id ] ) && ! empty( $saved_attribute['terms'][ $term_id ]['secondary_color'] ) ) ? $saved_attribute['terms'][ $term_id ]['secondary_color'] : $global_secondary_color;


							if ( $is_dual ) {
								$data .= sprintf( '<span class="variable-item-span variable-item-span-%1$s variable-item-span-dual-color" style="background: linear-gradient(-45deg, %2$s 0%%, %2$s 50%%, %3$s 50%%, %3$s 100%%);"></span>', esc_attr( $type ), esc_attr( $secondary_color ), esc_attr( $color ) );
							} else {
								$data .= sprintf( '<span class="variable-item-span variable-item-span-%s" style="background-color:%s;"></span>', esc_attr( $type ), esc_attr( $color ) );
							}

							break;

						case 'image':

							$global_attachment_id = apply_filters( 'wvs_product_global_attribute_image_id', absint( get_term_meta( $term->term_id, 'product_attribute_image', true ) ), $term, $args );

							$attachment_id = ( isset( $saved_attribute['terms'][ $term_id ] ) && ! empty( $saved_attribute['terms'][ $term_id ]['image_id'] ) ) ? $saved_attribute['terms'][ $term_id ]['image_id'] : $global_attachment_id;

							$global_image_size = woo_variation_swatches()->get_option( 'attribute_image_size' );

							$image_size = ( isset( $saved_attribute['image_size'] ) && ! empty( $saved_attribute['image_size'] ) ) ? $saved_attribute['image_size'] : $global_image_size;

							$image_html = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wvs_product_attribute_image_size', $image_size, $attribute, $product ) );

							$data .= sprintf( '<img class="variable-item-image" aria-hidden="true" alt="%s" src="%s" width="%d" height="%d" />', esc_attr( $term->name ), esc_url( $image_html[0] ), $image_html[1], $image_html[2] );

							break;

						case 'button':
							$data .= sprintf( '<span class="variable-item-span variable-item-span-%s">%s</span>', esc_attr( $type ), esc_html( $term->name ) );
							break;

						case 'radio':
							$id   = uniqid( $term->slug );
							$data .= sprintf( '<input name="%1$s" id="%2$s" class="wvs-radio-variable-item" %3$s  type="radio" value="%4$s" data-value="%4$s" /><label for="%2$s">%5$s</label>', $name, $id, checked( sanitize_title( $args['selected'] ), $term->slug, false ), esc_attr( $term->slug ), esc_html( $term->name ) );
							break;

						default:
							$data .= apply_filters( 'wvs_variable_default_item_content', '', $term, $args );
							break;
					endswitch;

					if ( (bool) woo_variation_swatches()->get_option( 'show_variation_stock_info' ) ) {
						$data .= '<span class="wvs-stock-left-info" data-wvs-stock-info=""></span>';
					}

					$data .= '</div></li>';

					$display_count ++;
				}
			}
		} else {
			// Custom Attributes

			$terms = ! empty( $saved_attribute['terms'] ) ? (array) $saved_attribute['terms'] : array();
			// $total_terms = count( $terms );
			$total_terms = count( $options );
			// foreach ( $terms as $term_id => $term )

			foreach ( $options as $option ) {

				$term_id = trim( $option );
				$term    = $terms[ $option ];

				$type = isset( $term['type'] ) ? $term['type'] : $saved_attribute['type'];

				$is_selected             = ( sanitize_title( $args['selected'] ) == $term_id );
				$selected_class          = $is_selected ? 'selected' : '';
				$screen_reader_html_attr = $is_selected ? ' aria-checked="true"' : ' aria-checked="false"';
				$data_url                = '';
				if ( $linkable_attribute && $is_archive ) {
					$url      = esc_url( add_query_arg( $attribute_name, $term_id, $product_url ) );
					$data_url = sprintf( ' data-url="%s"', $url );
				}
				// Tooltip

				$default_tooltip_type = ( isset( $saved_attribute['show_tooltip'] ) && ! empty( $saved_attribute['show_tooltip'] ) ) ? $saved_attribute['show_tooltip'] : 'text';
				$default_tooltip_text = trim( apply_filters( 'wvs_color_variable_item_tooltip', $term_id, $term, $args ) );

				// from product attribute item
				$tooltip_type = ( isset( $term['tooltip_type'] ) && ! empty( $term['tooltip_type'] ) ) ? trim( $term['tooltip_type'] ) : $default_tooltip_type;
				$tooltip_text = ( isset( $term['tooltip_text'] ) && ! empty( $term['tooltip_text'] ) ) ? trim( $term['tooltip_text'] ) : $default_tooltip_text;

				if ( isset( $term['tooltip_type'] ) && empty( $term['tooltip_type'] ) ) {
					$tooltip_type = $default_tooltip_type;
					$tooltip_text = $default_tooltip_text;
				}

				$tooltip_image = ( isset( $term['tooltip_image'] ) && ! empty( $term['tooltip_image'] ) ) ? trim( $term['tooltip_image'] ) : false;

				$show_tooltip = ! empty( $tooltip_type ) || $tooltip_type !== 'no';

				if ( $is_archive ) {
					$show_tooltip = $show_archive_tooltip;
				}

				$tooltip_html_attr = '';
				$tooltip_html_attr .= ( $show_tooltip && $tooltip_text && $tooltip_type == 'text' ) ? sprintf( ' data-wvstooltip="%s"', esc_attr( $tooltip_text ) ) : '';

				$tooltip_image_width = absint( woo_variation_swatches()->get_option( 'tooltip_image_width' ) );

				$tooltip_image_size = apply_filters( 'wvs_tooltip_image_size', array(
					$tooltip_image_width,
					$tooltip_image_width
				) );
				// $tooltip_image_width = apply_filters( 'wvs_tooltip_image_width', sprintf( '%dpx', $tooltip_image_width ) );

				//$tooltip_html_image = ( $show_tooltip && $tooltip_type == 'image' && $tooltip_image ) ? wp_get_attachment_image_url( $tooltip_image, $tooltip_image_size ) : false;
				$tooltip_html_image = ( $show_tooltip && $tooltip_type == 'image' && $tooltip_image ) ? wp_get_attachment_image_src( $tooltip_image, $tooltip_image_size ) : false;

				if ( wp_is_mobile() ) {
					$tooltip_html_attr .= ( $show_tooltip ) ? ' tabindex="2"' : '';
				}


				// More...
				if ( $is_archive && wvs_archive_swatches_has_more( $display_count ) ) {
					$data .= wvs_archive_swatches_more( $product->get_id(), $total_terms );
					break;
				}

				if ( ! empty( $tooltip_html_image ) ):
					// $tooltip_html_attr .= sprintf( ' style="--tooltip-background: url(\'%s\'); --tooltip-width: %spx; --tooltip-height: %spx;"', $tooltip_html_image[ 0 ], $tooltip_html_image[ 1 ], $tooltip_html_image[ 2 ] );
					$tooltip_html_attr .= sprintf( ' style="--tooltip-background: url(\'%s\'); --tooltip-width: %spx; --tooltip-height: %spx;"', $tooltip_html_image[0], $tooltip_image_width, $tooltip_image_width );
					$selected_class    .= ' wvs-has-image-tooltip';
				endif;

				$data .= sprintf( '<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" data-title="%5$s" title="%5$s" data-value="%5$s"  role="radio" tabindex="0"><div class="variable-item-contents">', $data_url . $screen_reader_html_attr . $tooltip_html_attr, esc_attr( $type ), sanitize_title( $term_id ), esc_attr( $selected_class ), esc_html( $term_id ) );

				/*if ( ! empty( $tooltip_html_image ) ):
					$data .= '<span style="width: ' . $tooltip_image_width . '" class="image-tooltip-wrapper"><img alt="' . $term_id . '" src="' . $tooltip_html_image[ 0 ] . '" width="' . $tooltip_html_image[ 1 ] . '" height="' . $tooltip_html_image[ 2 ] . '" /></span>';
					// $data .= '<span style="width: ' . $tooltip_image_width . '" class="image-tooltip-wrapper">' . $tooltip_html_image . '</span>';
				endif;*/

				switch ( $type ):
					case 'color':

						$color           = $term['color'];
						$is_dual         = $term['is_dual_color'];
						$secondary_color = $term['secondary_color'];

						if ( $is_dual ) {
							$data .= sprintf( '<span class="variable-item-span variable-item-span-color variable-item-span-dual-color" style="background: linear-gradient(-45deg, %1$s 0%%, %1$s 50%%, %2$s 50%%, %2$s 100%%);"></span>', esc_attr( $secondary_color ), esc_attr( $color ) );
						} else {
							$data .= sprintf( '<span class="variable-item-span variable-item-span-color" style="background-color:%s;"></span>', esc_attr( $color ) );
						}
						break;

					case 'image':

						$attachment_id = $term['image_id'];

						$global_image_size = woo_variation_swatches()->get_option( 'attribute_image_size' );

						$image_size = ( isset( $saved_attribute['image_size'] ) && ! empty( $saved_attribute['image_size'] ) ) ? $saved_attribute['image_size'] : $global_image_size;

						$image_html = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wvs_product_attribute_image_size', $image_size, $attribute, $product ) );

						$data .= sprintf( '<img class="variable-item-image" aria-hidden="true" alt="%s" src="%s" width="%d" height="%d" />', esc_attr( $term_id ), esc_url( $image_html[0] ), $image_html[1], $image_html[2] );

						break;

					case 'button':
						$data .= sprintf( '<span class="variable-item-span variable-item-span-button">%s</span>', esc_html( $term_id ) );
						break;

					case 'radio':
						$id   = uniqid( sanitize_title( $term_id ) );
						$data .= sprintf( '<input name="%1$s" id="%2$s" class="wvs-radio-variable-item" %3$s type="radio" value="%4$s" data-value="%4$s" /><label for="%2$s">%5$s</label>', $name, $id, checked( sanitize_title( $args['selected'] ), $term_id, true ), esc_attr( $term_id ), esc_html( $term_id ) );
						break;

					default:
						$data .= apply_filters( 'wvs_variable_default_item_content', '', $term_id, $args );
						break;
				endswitch;

				if ( (bool) woo_variation_swatches()->get_option( 'show_variation_stock_info' ) ) {
					$data .= '<span class="wvs-stock-left-info" data-wvs-stock-info=""></span>';
				}

				$data .= '</div></li>';

				$display_count ++;
			}
		}
	}

	return apply_filters( 'wvs_variable_item', $data, $type, $options, $args, $saved_attribute );
}

// Function override
function wvs_default_variable_item( $type, $options, $args, $saved_attribute = array() ) {

	$product   = $args['product'];
	$attribute = $args['attribute'];
	$assigned  = $args['assigned'];

	$is_archive           = ( isset( $args['is_archive'] ) && $args['is_archive'] );
	$show_archive_tooltip = (bool) woo_variation_swatches()->get_option( 'show_tooltip_on_archive' );

	$linkable_attribute = ( (bool) woo_variation_swatches()->get_option( 'linkable_attribute' ) && ( woo_variation_swatches()->get_option( 'trigger_catalog_mode' ) == 'hover' ) );

	$product_url    = $product->get_permalink();
	$attribute_name = wc_variation_attribute_name( $attribute );

	$data = '';

	if ( isset( $args['fallback_type'] ) && $args['fallback_type'] === 'select' ) {
		//	return '';
	}

	if ( ! empty( $options ) ) {
		if ( $product && taxonomy_exists( $attribute ) ) {
			$terms         = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );
			$name          = uniqid( wc_variation_attribute_name( $attribute ) );
			$display_count = 0;
			$total_terms   = count( $terms );
			foreach ( $terms as $term ) {
				if ( in_array( $term->slug, $options ) ) {

					$is_selected = ( sanitize_title( $args['selected'] ) == $term->slug );

					$selected_class = $is_selected ? 'selected' : '';
					$tooltip        = trim( apply_filters( 'wvs_variable_item_tooltip', $term->name, $term, $args ) );

					$screen_reader_html_attr = $is_selected ? ' aria-checked="true"' : ' aria-checked="false"';
					$data_url                = '';
					if ( $linkable_attribute && $is_archive ) {
						$url      = esc_url( add_query_arg( $attribute_name, $term->slug, $product_url ) );
						$data_url = sprintf( ' data-url="%s"', $url );
					}

					if ( $is_archive && ! $show_archive_tooltip ) {
						$tooltip = false;
					}

					$tooltip_html_attr = ! empty( $tooltip ) ? sprintf( ' data-wvstooltip="%s"', esc_attr( $tooltip ) ) : '';

					if ( wp_is_mobile() ) {
						$tooltip_html_attr .= ! empty( $tooltip ) ? ' tabindex="2"' : '';
					}

					$type = isset( $assigned[ $term->slug ] ) ? $assigned[ $term->slug ]['type'] : $type;

					if ( ! isset( $assigned[ $term->slug ] ) || empty( $assigned[ $term->slug ]['image_id'] ) ) {
						$type = 'button';
					}

					// More...
					if ( $is_archive && wvs_archive_swatches_has_more( $display_count ) ) {
						$data .= wvs_archive_swatches_more( $product->get_id(), $total_terms );
						break;
					}


					$data .= sprintf( '<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" data-title="%5$s" title="%5$s" data-value="%3$s"  role="radio" tabindex="0"><div class="variable-item-contents">', $data_url . $screen_reader_html_attr . $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ) );

					switch ( $type ):

						case 'image':
							$attachment_id = $assigned[ $term->slug ]['image_id'];
							$image_size    = woo_variation_swatches()->get_option( 'attribute_image_size' );
							$image         = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wvs_product_attribute_image_size', $image_size, $attribute, $product ) );

							$data .= sprintf( '<img class="variable-item-image" aria-hidden="true" alt="%s" src="%s" width="%d" height="%d" />', esc_attr( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ), esc_url( $image[0] ), $image[1], $image[2] );
							// $data .= $image_html;
							break;


						case 'button':
							$data .= sprintf( '<span class="variable-item-span variable-item-span-%s">%s</span>', esc_attr( $type ), esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) );
							break;

						default:
							$data .= apply_filters( 'wvs_variable_default_item_content', '', $term, $args, $saved_attribute );
							break;
					endswitch;


					if ( (bool) woo_variation_swatches()->get_option( 'show_variation_stock_info' ) ) {
						$data .= '<span class="wvs-stock-left-info" data-wvs-stock-info=""></span>';
					}

					$data .= '</div></li>';
					$display_count ++;
				}
			}
		} else {

			$display_count = 0;
			$total_terms   = count( $options );
			foreach ( $options as $option ) {
				// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.

				$option = esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) );

				$is_selected             = ( sanitize_title( $option ) == sanitize_title( $args['selected'] ) );
				$selected_class          = $is_selected ? 'selected' : '';
				$screen_reader_html_attr = $is_selected ? ' aria-checked="true"' : ' aria-checked="false"';

				$data_url = '';
				if ( $linkable_attribute && $is_archive ) {
					$url      = esc_url( add_query_arg( $attribute_name, sanitize_title( $option ), $product_url ) );
					$data_url = sprintf( ' data-url="%s"', $url );
				}

				$tooltip = trim( apply_filters( 'wvs_variable_item_tooltip', esc_attr( $option ), $options, $args ) );

				if ( $is_archive && ! $show_archive_tooltip ) {
					$tooltip = false;
				}

				$tooltip_html_attr = ! empty( $tooltip ) ? sprintf( ' data-wvstooltip="%s"', esc_attr( $tooltip ) ) : '';

				if ( wp_is_mobile() ) {
					$tooltip_html_attr .= ! empty( $tooltip ) ? ' tabindex="2"' : '';
				}

				$type = isset( $assigned[ $option ] ) ? $assigned[ $option ]['type'] : $type;

				if ( ! isset( $assigned[ $option ] ) || empty( $assigned[ $option ]['image_id'] ) ) {
					$type = 'button';
				}

				// More...
				if ( $is_archive && wvs_archive_swatches_has_more( $display_count ) ) {
					$data .= wvs_archive_swatches_more( $product->get_id(), $total_terms );
					break;
				}

				$data .= sprintf( '<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" data-title="%5$s" title="%5$s" data-value="%3$s" role="radio" tabindex="0"><div class="variable-item-contents">', $data_url . $screen_reader_html_attr . $tooltip_html_attr, esc_attr( $type ), esc_attr( $option ), esc_attr( $selected_class ), esc_html( $option ) );

				switch ( $type ):

					case 'image':
						$attachment_id = $assigned[ $option ]['image_id'];
						$image_size    = woo_variation_swatches()->get_option( 'attribute_image_size' );
						$image         = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wvs_product_attribute_image_size', $image_size, $attribute, $product ) );

						$data .= sprintf( '<img class="variable-item-image" aria-hidden="true" alt="%s" src="%s" width="%d" height="%d" />', esc_attr( $option ), esc_url( $image[0] ), esc_attr( $image[1] ), esc_attr( $image[2] ) );
						// $data .= $image_html;
						break;


					case 'button':
						$data .= sprintf( '<span class="variable-item-span variable-item-span-%s">%s</span>', esc_attr( $type ), esc_html( $option ) );
						break;

					default:
						$data .= apply_filters( 'wvs_variable_default_item_content', '', $option, $args, array() );
						break;
				endswitch;

				if ( (bool) woo_variation_swatches()->get_option( 'show_variation_stock_info' ) ) {
					$data .= '<span class="wvs-stock-left-info" data-wvs-stock-info=""></span>';
				}

				$data .= '</div></li>';
				$display_count ++;

			}
		}
	}

	return apply_filters( 'wvs_default_variable_item', $data, $type, $options, $args, array() );
}

function wvs_color_variation_attribute_preview( $term_id, $attribute, $fields ) {

	$key            = $fields[0]['id'];
	$is_dual_key    = $fields[1]['id'];
	$dual_color_key = $fields[2]['id'];

	$value = sanitize_hex_color( get_term_meta( $term_id, $key, true ) );

	$is_dual = (bool) ( get_term_meta( $term_id, $is_dual_key, true ) === 'yes' );

	if ( $is_dual ) {
		$secondary_color = sanitize_hex_color( get_term_meta( $term_id, $dual_color_key, true ) );
		printf( '<div class="wvs-preview wvs-color-preview wvs-dual-color-preview" style="background: linear-gradient(-45deg, %1$s 0%%, %1$s 50%%, %2$s 50%%, %2$s 100%%);"></div>', esc_attr( $secondary_color ), esc_attr( $value ) );
	} else {
		printf( '<div class="wvs-preview wvs-color-preview" style="background-color:%s;"></div>', esc_attr( $value ) );
	}
}

//-------------------------------------------------------------------------------
// WooCommerce Core Function Override
//-------------------------------------------------------------------------------

if ( ! function_exists( 'woocommerce_variable_add_to_cart' ) ):
	function woocommerce_variable_add_to_cart() {
		global $product;
		// Enqueue variation scripts.
		wp_enqueue_script( 'wc-add-to-cart-variation' );

		$product_id   = $product->get_id();
		$attributes   = $product->get_variation_attributes();
		$selected_all = array();

		foreach ( $attributes as $attribute_name => $options ) {
			$selected_key                  = 'attribute_' . sanitize_title( $attribute_name );
			$selected                      = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( urldecode( $_REQUEST[ $selected_key ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
			$selected_all[ $selected_key ] = $selected;
		}

		$transient_key = md5( wp_json_encode( $selected_all ) );
		$currency      = get_woocommerce_currency();

		$transient_name = sprintf( 'wvs_template_%s%s_%s', $product_id, $transient_key, $currency );
		$cache          = new Woo_Variation_Swatches_Cache( $transient_name, 'wvs_template' );
		$use_transient  = (bool) woo_variation_swatches()->get_option( 'use_transient' );

		// Clear cache
		if ( isset( $_GET['wvs_clear_transient'] ) ) {
			$cache->delete_transient();
		}

		// Return cache
		if ( $use_transient ) {
			$transient_html = $cache->get_transient( $transient_name );
			if ( ! empty( $transient_html ) ) {
				echo $transient_html . '<!-- from woocommerce_variable_add_to_cart  -->';

				return;
			}
		}

		ob_start();

		// Get Available variations?
		$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

		$available_variations = $get_variations ? array_values( $product->get_available_variations() ) : false;

		$selected_attributes = $product->get_default_attributes();

		// Load the template.
		wc_get_template(
			'single-product/add-to-cart/variable.php', apply_filters(
				'wvs_woocommerce_variable_add_to_cart_template_args', array(
					'available_variations' => $available_variations,
					'attributes'           => $attributes,
					'selected_attributes'  => $selected_attributes,
				)
			)
		);

		$html = ob_get_clean();
		// Set cache
		if ( $use_transient ) {
			$cache->set_transient( $html, DAY_IN_SECONDS );
		}

		echo $html;
	}
endif;

//-------------------------------------------------------------------------------
// WooCommerce Get Attribute Taxonomies
//-------------------------------------------------------------------------------

if ( ! function_exists( 'wvs_pro_get_attribute_taxonomies_option' ) ):
	function wvs_pro_get_attribute_taxonomies_option( $empty = ' - Choose Attribute - ' ) {
		// attribute_name | attribute_id
		$lists = (array) wp_list_pluck( wc_get_attribute_taxonomies(), 'attribute_label', 'attribute_name' );

		$list = array();
		foreach ( $lists as $name => $label ) {
			$list[ wc_attribute_taxonomy_name( $name ) ] = $label . " ( {$name} )";
		}

		if ( $empty ) {
			$list = array( '' => $empty ) + $list;
		}

		return $list;
	}
endif;

if ( ! function_exists( 'wvs_pro_attribute_taxonomy_type_by_name' ) ):
	function wvs_pro_attribute_taxonomy_type_by_name( $name ) {
		$name       = str_replace( 'pa_', '', wc_sanitize_taxonomy_name( $name ) );
		$taxonomies = wp_list_pluck( wc_get_attribute_taxonomies(), 'attribute_type', 'attribute_name' );

		return isset( $taxonomies[ $name ] ) ? $taxonomies[ $name ] : false;
	}
endif;