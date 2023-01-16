<?php

defined( 'ABSPATH' ) or die( 'Keep Silent' );

if ( ! class_exists( 'Woo_Variation_Swatches_Pro_Product_Meta' ) ):

	class Woo_Variation_Swatches_Pro_Product_Meta {

		public function __construct() {

			add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_tab' ) );
			add_filter( 'woocommerce_product_data_panels', array( $this, 'add_tab_panel' ) );
			add_action( 'wp_ajax_wvs_pro_load_product_attributes', array( $this, 'load_product_attributes' ) );
			add_action( 'wp_ajax_wvs_pro_save_product_attributes', array(
				$this,
				'prepare_for_save_ajax_product_attributes'
			) );

			// On Main Save / Update Button
			/*add_action( 'woocommerce_process_product_meta_variable', array(
				$this,
				'prepare_for_save_product_attributes'
			) );*/

			add_action( 'wp_ajax_wvs_pro_reset_product_attributes', array( $this, 'reset_ajax_product_attributes' ) );

		}

		public function get_img_src( $thumbnail_id = false ) {
			if ( ! empty( $thumbnail_id ) ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = woo_variation_swatches()->images_uri( 'placeholder.png' );
			}

			return $image;
		}

		public function add_tab( $tabs ) {
			$tabs['woo-variation-swatches-pro'] = array(
				'label'    => __( 'Swatches Settings', 'woo-variation-swatches-pro' ),
				'target'   => 'wvs-pro-product-variable-swatches-options',
				'class'    => array( 'show_if_variable', 'variations_tab', 'pro-active' ),
				'priority' => 65,
			);

			return $tabs;
		}

		public function add_tab_panel() {
			global $post, $thepostid, $product_object;
			?>
			<div id="wvs-pro-product-variable-swatches-options" class="panel wc-metaboxes-wrapper hidden">
				<?php
				$this->panel_contents( $product_object );
				?>
			</div>
			<?php
		}

		public function panel_contents( $product_object ) {

			// global $post, $thepostid, $product_object;
			// Product attributes - taxonomies and custom, ordered, with visibility and variation attributes set
			$attributes = $product_object->get_attributes();
			//$variation_attributes   = array_filter( $product_object->get_attributes(), array( __CLASS__, 'filter_variation_attributes' ) );

			$product_id = $product_object->get_id();
			// $saved_product_attributes = (array) get_post_meta( $product_id, '_wvs_product_attributes', true );
			$saved_product_attributes = (array) wvs_pro_get_product_option( $product_id );

			$wvs_pro_attributes           = array();
			$attribute_types              = wc_get_attribute_types();
			$attribute_types['custom']    = esc_html__( 'Custom', 'woo-variation-swatches-pro' );
			$attribute_types_configurable = wc_get_attribute_types();
			unset( $attribute_types_configurable['select'], $attribute_types_configurable['radio'] );

			// Setup
			foreach ( $attributes as $attribute ) {

				// Class WC_Product_Attribute
				$use_for_variation = $attribute->get_variation();
				$attribute_name    = $attribute->get_name();
				$attribute_key     = sanitize_title( $attribute->get_name() );
				$options           = $attribute->get_options();

				if ( ! $use_for_variation ) {
					continue;
				}

				if ( $attribute->is_taxonomy() && $attribute_taxonomy = $attribute->get_taxonomy_object() ) {

					$options = ! empty( $options ) ? $options : array();

					/*
					[attribute_id] => 14
					[attribute_name] => color
					[attribute_label] => Color
					[attribute_type] => color
					*/

					$wvs_pro_attributes[ $attribute_name ]['taxonomy_exists'] = true;
					$wvs_pro_attributes[ $attribute_name ]['taxonomy']        = (array) $attribute_taxonomy;
					$wvs_pro_attributes[ $attribute_name ]['terms']           = array();

					$terms = array();

					$args = array(
						'orderby'    => 'name',
						'hide_empty' => 0,
					);

					$all_terms = get_terms( $attribute->get_taxonomy(), apply_filters( 'woocommerce_product_attribute_terms', $args ) );
					if ( $all_terms ) {
						foreach ( $all_terms as $term ) {
							if ( in_array( $term->term_id, $options, true ) ) {
								$terms[ esc_attr( $term->term_id ) ] = esc_html( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term, $attribute_name, $product_object ) );
							}
						}
						$wvs_pro_attributes[ $attribute_name ]['terms'] = $terms;
					}
				} else {
					// TextAria custom attribute which added by Red | Blur | Green
					$attribute_name     = $attribute->get_name();
					$attribute_key      = sanitize_title( $attribute->get_name() );
					$attribute_name_old = strtolower( sanitize_title( $attribute_name ) );
					$options            = $attribute->get_options();
					$options            = ! empty( $options ) ? $options : array();
					$terms              = array_reduce( $options, function ( $opt, $option ) use ( $attribute_name, $product_object ) {
						// $opt[ esc_attr( $option ) ] = $option;
						$opt[ esc_attr( $option ) ] = esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute_name, $product_object ) );

						return $opt;
					}, array() );


					/*
					[attribute_id] => 14
					[attribute_name] => color
					[attribute_label] => Color
					[attribute_type] => color
					*/

					$wvs_pro_attributes[ $attribute_name ]['taxonomy_exists'] = false;
					$wvs_pro_attributes[ $attribute_name ]['taxonomy']        = array(
						'attribute_id'    => $attribute_key,
						'attribute_type'  => 'select',
						// 'attribute_name'  => strtolower( sanitize_title( $attribute_name ) ),
						'attribute_name'  => trim( $attribute_name ),
						'attribute_label' => $attribute->get_name()
					);
					$wvs_pro_attributes[ $attribute_name ]['terms']           = $terms;


					// Backward Compatibility for 1.0.2
					if ( isset( $saved_product_attributes[ $attribute_name_old ] ) ) {
						$saved_product_attributes[ $attribute_name ] = $saved_product_attributes[ $attribute_name_old ];
						unset( $saved_product_attributes[ $attribute_name_old ] );
					}
					// Backward Compatibility for 1.1.14 for serializeJSON colon issue
					/*if ( isset( $saved_product_attributes[ $attribute_name ] ) ) {
						$saved_product_attributes[ $attribute_key ] = $saved_product_attributes[ $attribute_name ];
						unset( $saved_product_attributes[ $attribute_name ] );
					}*/
					//
				}
			}
			?>
			<div class="wvs-pro-product-variable-swatches-options wc-metaboxes">

				<?php
				if ( ! empty( $wvs_pro_attributes ) ) {
					?>
					<div id="wvs-pro-product-variable-swatches-options-notice" class="inline woocommerce-message"></div>
					<div class="product-settings">
						<?php if ( woo_variation_swatches()->get_option( 'enable_catalog_mode' ) ): ?>
							<table cellpadding="0" cellspacing="0">
								<tbody>
								<tr>
									<td><?php esc_html_e( 'Catalog mode attribute', 'woo-variation-swatches-pro' ) ?></td>
									<td>
										<select name="_wvs_pro_swatch_option[catalog_attribute]">
											<?php
											$selected_catalog_attribute = isset( $saved_product_attributes['catalog_attribute'] ) ? trim( $saved_product_attributes['catalog_attribute'] ) : '';
											?>
											<option <?php selected( $selected_catalog_attribute, '' ) ?> value=""><?php esc_html_e( 'Global', 'woo-variation-swatches-pro' ) ?></option>

											<?php foreach ( $wvs_pro_attributes as $attribute_key => $wvs_pro_attribute ): ?>
												<option <?php selected( $selected_catalog_attribute, $attribute_key ) ?> value="<?php echo $attribute_key ?>"><?php echo $wvs_pro_attribute['taxonomy']['attribute_label'] . '( ' . $wvs_pro_attribute['taxonomy']['attribute_name'] . ' )' ?></option>
											<?php endforeach; ?>
										</select>
									</td>
								</tr>
								</tbody>
							</table>
						<?php endif; ?>

						<?php if ( woo_variation_swatches()->get_option( 'enable_single_variation_preview' ) ): ?>
							<table cellpadding="0" cellspacing="0">
								<tbody>
								<tr>
									<td><?php esc_html_e( 'Single variation preview attribute', 'woo-variation-swatches-pro' ) ?></td>
									<td>
										<select name="_wvs_pro_swatch_option[single_variation_preview_attribute]">

											<?php
											$single_variation_preview_attribute = isset( $saved_product_attributes['single_variation_preview_attribute'] ) ? trim( $saved_product_attributes['single_variation_preview_attribute'] ) : '';
											?>
											<option <?php selected( $single_variation_preview_attribute, '' ) ?> value=""><?php esc_html_e( 'Global', 'woo-variation-swatches-pro' ) ?></option>

											<?php foreach ( $wvs_pro_attributes as $attribute_key => $wvs_pro_attribute ): ?>
												<option <?php selected( $single_variation_preview_attribute, $attribute_key ) ?> value="<?php echo $attribute_key ?>"><?php echo $wvs_pro_attribute['taxonomy']['attribute_label'] . '( ' . $wvs_pro_attribute['taxonomy']['attribute_name'] . ' )' ?></option>
											<?php endforeach; ?>


										</select>
									</td>
								</tr>
								</tbody>
							</table>
						<?php endif; ?>

						<?php if ( woo_variation_swatches()->get_option( 'default_to_button' ) ): ?>
							<table cellpadding="0" cellspacing="0">
								<tbody>
								<tr>
									<td>
										<?php esc_html_e( 'Default Dropdowns to Button Type', 'woo-variation-swatches-pro' ) ?>
									</td>
									<td>
										<?php
										$selected_default_to_button = isset( $saved_product_attributes['default_to_button'] ) ? $saved_product_attributes['default_to_button'] : 'yes';
										?>
										<select name="_wvs_pro_swatch_option[default_to_button]">
											<option <?php selected( $selected_default_to_button, 'yes' ) ?> value="yes"><?php esc_html_e( 'Yes', 'woo-variation-swatches-pro' ) ?></option>
											<option <?php selected( $selected_default_to_button, 'no' ) ?> value="no"><?php esc_html_e( 'No', 'woo-variation-swatches-pro' ) ?></option>
										</select>
									</td>
								</tr>
								</tbody>
							</table>
						<?php endif; ?>

						<?php if ( woo_variation_swatches()->get_option( 'default_to_image' ) ): ?>
							<table cellpadding="0" cellspacing="0">
								<tbody>
								<tr>
									<td>
										<?php esc_html_e( 'Default Dropdowns to Image Type', 'woo-variation-swatches-pro' ) ?>
									</td>
									<td>
										<?php
										$selected_default_to_image = isset( $saved_product_attributes['default_to_image'] ) ? $saved_product_attributes['default_to_image'] : 'yes';
										?>
										<select name="_wvs_pro_swatch_option[default_to_image]">
											<option <?php selected( $selected_default_to_image, 'yes' ) ?> value="yes"><?php esc_html_e( 'Yes', 'woo-variation-swatches-pro' ) ?></option>
											<option <?php selected( $selected_default_to_image, 'no' ) ?> value="no"><?php esc_html_e( 'No', 'woo-variation-swatches-pro' ) ?></option>
										</select>
										<span class="description"><?php esc_html_e( 'if variation has an image', 'woo-variation-swatches-pro' ) ?></span>
									</td>
								</tr>
								</tbody>
							</table>

							<?php if ( ! empty( $wvs_pro_attributes ) ): ?>
								<table cellpadding="0" cellspacing="0">
									<tbody>
									<tr>
										<td>
											<?php esc_html_e( 'Default Image Type Attribute', 'woo-variation-swatches-pro' ) ?>
										</td>
										<td>
											<?php
											$selected_default_image_type_attribute = isset( $saved_product_attributes['default_image_type_attribute'] ) ? $saved_product_attributes['default_image_type_attribute'] : '';
											?>
											<select name="_wvs_pro_swatch_option[default_image_type_attribute]">
												<option <?php selected( $selected_default_to_image, '' ) ?> value=""><?php esc_html_e( 'Default', 'woo-variation-swatches-pro' ) ?></option>
												<?php foreach ( $wvs_pro_attributes as $attribute_key => $wvs_pro_attribute ): ?>
													<option <?php selected( $selected_default_image_type_attribute, $attribute_key ) ?> value="<?php echo $attribute_key ?>"><?php echo $wvs_pro_attribute['taxonomy']['attribute_label'] . '( ' . $wvs_pro_attribute['taxonomy']['attribute_name'] . ' )' ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									</tbody>
								</table>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<?php
					include 'html-product-attribute.php';
					?>
					<div class="toolbar">
						<button type="button" class="button wvs_pro_save_product_attributes button-primary"><?php esc_html_e( 'Save swatches settings', 'woo-variation-swatches-pro' ) ?></button>
						<button type="button" class="button wvs_pro_reset_product_attributes button"><?php esc_html_e( 'Reset to default', 'woo-variation-swatches-pro' ) ?></button>
					</div>
					<?php
				} else {
					?>
					<div class="inline notice woocommerce-message">
						<p><?php echo wp_kses_post( __( 'Before you can add a variation you need to add some variation attributes on the <strong>Attributes</strong> tab.', 'woocommerce' ) ); ?></p>
						<p>
							<a class="button-primary" href="<?php echo esc_url( apply_filters( 'woocommerce_docs_url', 'https://docs.woocommerce.com/document/variable-product/', 'product-variations' ) ); ?>" target="_blank"><?php esc_html_e( 'Learn more', 'woocommerce' ); ?></a>
						</p>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}

		public function load_product_attributes() {
			if ( ! wp_verify_nonce( $_POST['nonce'] ) ) {
				wp_send_json_error( esc_html__( 'Wrong Nonce', 'woo-variation-swatches-pro' ) );
			}

			$product_id = absint( $_POST['post_id'] );

			$product_object = wc_get_product( $product_id );

			ob_start();
			$this->panel_contents( $product_object );
			$data = ob_get_clean();

			wp_send_json_success( $data );
		}

		public function prepare_for_save_ajax_product_attributes() {
			if ( ! wp_verify_nonce( $_POST['nonce'] ) ) {
				wp_send_json_error( esc_html__( 'Wrong Nonce', 'woo-variation-swatches-pro' ) );
			}

			if ( ! current_user_can( 'edit_products' ) ) {
				wp_die( - 1 );
			}

			//$data = $this->array_map_recursive( 'sanitize_text_field', $_POST['data'] );
			$data = map_deep( $_POST['data'], 'sanitize_text_field' );

			// parse_str( wp_unslash( $_POST['data'] ), $data );
			$product_id = absint( $_POST['post_id'] );
			// $data       = $data['_wvs_pro_swatch_option'];

			$this->save_product_attributes( $product_id, $data );
			do_action( 'wvs_pro_save_product_attributes', $product_id, $data );
			wp_send_json_success( array(
				'class'   => 'updated',
				'message' => '<p>' . esc_html__( 'Settings saved', 'woo-variation-swatches-pro' ) . '</p>'
			) );
		}

		public function reset_ajax_product_attributes() {
			if ( ! wp_verify_nonce( $_POST['nonce'] ) ) {
				wp_send_json_error( esc_html__( 'Wrong Nonce', 'woo-variation-swatches-pro' ) );
			}

			if ( ! current_user_can( 'edit_products' ) ) {
				wp_die( - 1 );
			}

			$product_id = absint( $_POST['post_id'] );

			delete_post_meta( $product_id, '_wvs_product_attributes' );
			do_action( 'wvs_pro_reset_product_attributes', $product_id );
			wp_send_json_success( true );
		}

		// On main save button
		public function prepare_for_save_product_attributes( $product_id ) {
			if ( isset( $_POST['_wvs_pro_swatch_option'] ) ) {
				$data = $_POST['_wvs_pro_swatch_option'];
				$data = $this->array_map_recursive( 'sanitize_text_field', $data );
				$this->save_product_attributes( $product_id, $data );
			}
		}

		public function array_map_recursive( $callback, $array ) {
			$output = array();
			foreach ( $array as $key => $value ) {
				if ( is_array( $value ) ) {
					$output[ $key ] = $this->array_map_recursive( $callback, $value );
				} else {
					$output[ $key ] = $callback( $value );
				}
			}

			return $output;
		}

		public function save_product_attributes( $product_id, $data ) {
			// $data = $this->array_map_recursive( 'sanitize_text_field', $data );
			update_post_meta( $product_id, '_wvs_product_attributes', $data );
		}
	}

	new Woo_Variation_Swatches_Pro_Product_Meta();
endif;