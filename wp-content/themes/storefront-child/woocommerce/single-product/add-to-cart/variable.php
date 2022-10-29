<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<?php if(!wp_is_mobile()) : ?>
	<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
		<?php do_action( 'woocommerce_before_variations_form' ); ?>

		<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
		<?php else : ?>
			<table class="variations" cellspacing="0" role="presentation">
				<tbody style="display: flex;flex-direction: column;">
					<?php
						$i= 0;
						foreach ( $attributes as $attribute_name => $options ) :
					?>
						<?php
						if( $attribute_name == 'pa_mat-trai' ||
							$attribute_name == 'pa_mat-phai' ) : $i++;?>
									<?php if($i == 1) : ?>
										<tr class="view" onclick="toggleVariations()">
											<th class="is_toggle"><span><?php _e('Power', 'storefront') ?></span>
												<span class="js_up d-none">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.8285 14.8284L16.2427 13.4142L12.0001 9.17161L7.75745 13.4142L9.17166 14.8285L12.0001 12L14.8285 14.8284Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 19C1 21.2091 2.79086 23 5 23H19C21.2091 23 23 21.2091 23 19V5C23 2.79086 21.2091 1 19 1H5C2.79086 1 1 2.79086 1 5V19ZM5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21Z" fill="currentColor"/></svg>
												</span >
												<span class="js_down">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.75739 10.5858L9.1716 9.17154L12 12L14.8284 9.17157L16.2426 10.5858L12 14.8284L7.75739 10.5858Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 5C1 2.79086 2.79086 1 5 1H19C21.2091 1 23 2.79086 23 5V19C23 21.2091 21.2091 23 19 23H5C2.79086 23 1 21.2091 1 19V5ZM5 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3Z" fill="currentColor"/></svg>
												</span>
											</th>
										</tr>
									<?php endif;  ?>
									<tr class="fold js_hide">
										<th class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></th>
										<td class="value">
											<?php
												wc_dropdown_variation_attribute_options(
													array(
														'options'   => $options,
														'attribute' => $attribute_name,
														'product'   => $product,
													)
												);
												echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
											?>
										</td>
									</tr>
									<?php if($i++ > 1) : ?>
										<th class="label">
											<a data-fancybox href="<?php echo get_stylesheet_directory_uri() ?>/assets/images/huong-dan-chon-do-can-caras.jpg">Hướng dẫn tính độ cận – loạn</a> </th>
									<?php endif;  ?>

						<?php elseif($attribute_name == 'pa_mau-sac') : ?>
							<tr style="order: 3;">
								<th class="label <?php echo 'is_'.$attribute_name ?>">
									<?php _e("Contact lens' patterns", 'storefront')  ?>
								</th>
								<td class="value">
									<?php
										wc_dropdown_variation_attribute_options(
											array(
												'options'   => $options,
												'attribute' => $attribute_name,
												'product'   => $product,
											)
										);
										echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
									?>
								</td>
							</tr>
						<?php else : ?>
							<tr>
								<th class="label <?php echo 'is_'.$attribute_name ?>">
									<?php echo wc_attribute_label( $attribute_name );  ?>
								</th>
								<td class="value">
									<?php
										wc_dropdown_variation_attribute_options(
											array(
												'options'   => $options,
												'attribute' => $attribute_name,
												'product'   => $product,
											)
										);
										echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
									?>
								</td>
							</tr>
						<?php endif ; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php do_action( 'woocommerce_after_variations_table' ); ?>

			<div class="single_variation_wrap">
				<?php
					/**
					 * Hook: woocommerce_before_single_variation.
					 */
					do_action( 'woocommerce_before_single_variation' );

					/**
					 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
					 *
					 * @since 2.4.0
					 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
					 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
					 */
					do_action( 'woocommerce_single_variation' );

					/**
					 * Hook: woocommerce_after_single_variation.
					 */
					do_action( 'woocommerce_after_single_variation' );
				?>
			</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_variations_form' ); ?>
	</form>
<?php else : ?>
	<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
		<?php do_action( 'woocommerce_before_variations_form' ); ?>

		<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
		<?php else : ?>
			<table class="variations" cellspacing="0" role="presentation">
				<tbody>
					<?php foreach ( $attributes as $attribute_name => $options ) : ?>
						<?php if($attribute_name == 'pa_mau-sac') : ?>
							<tr>
								<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></th>
								<td class="value">
									<?php
										wc_dropdown_variation_attribute_options(
											array(
												'options'   => $options,
												'attribute' => $attribute_name,
												'product'   => $product,
											)
										);
										echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
									?>
								</td>
							</tr>
						<?php elseif($attribute_name == 'pa_mat-trai' || $attribute_name == 'pa_mat-phai') : ?>
							<tr>
								<?php if($attribute_name == 'pa_mat-trai') : ?>
											<td class="value">
												<?php
													wc_dropdown_variation_attribute_options(
														array(
															'options'   => $options,
															'attribute' => $attribute_name,
															'product'   => $product,
														)
													);
													echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
												?>
											</td>
									<?php endif;?>
									<?php if($attribute_name == 'pa_mat-phai') : ?>
											<td class="value">
												<?php
													wc_dropdown_variation_attribute_options(
														array(
															'options'   => $options,
															'attribute' => $attribute_name,
															'product'   => $product,
														)
													);
													echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
												?>
											</td>
									<?php endif;?>
							</tr>
						<?php else: ?>
							<tr>
								<th class="label <?php echo 'is_'.$attribute_name ?>">
									<?php echo wc_attribute_label( $attribute_name );  ?>
								</th>
								<td class="value">
									<?php
										wc_dropdown_variation_attribute_options(
											array(
												'options'   => $options,
												'attribute' => $attribute_name,
												'product'   => $product,
											)
										);
										echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
									?>
								</td>
							</tr>
						<?php endif;?>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php do_action( 'woocommerce_after_variations_table' ); ?>

			<div class="single_variation_wrap">
				<?php
					/**
					 * Hook: woocommerce_before_single_variation.
					 */
					do_action( 'woocommerce_before_single_variation' );

					/**
					 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
					 *
					 * @since 2.4.0
					 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
					 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
					 */
					do_action( 'woocommerce_single_variation' );

					/**
					 * Hook: woocommerce_after_single_variation.
					 */
					do_action( 'woocommerce_after_single_variation' );
				?>
			</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_variations_form' ); ?>
	</form>
<?php endif; ?>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
