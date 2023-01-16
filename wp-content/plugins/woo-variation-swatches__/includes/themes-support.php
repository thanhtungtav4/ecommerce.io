<?php
defined( 'ABSPATH' ) or die( 'Keep Silent' );

// ==========================================================
// Flatsome Theme
// What we did is: Just add wvs_pro_ux_products_shortcode_class filter on wrapper class
// ==========================================================

function wvs_pro_ux_products( $atts, $content = null, $tag = '' ) {
	$sliderrandomid = rand();

	if ( ! is_array( $atts ) ) {
		$atts = array();
	}

	extract( shortcode_atts( array(
		'_id'                 => 'product-grid-' . rand(),
		'title'               => '',
		'ids'                 => '',
		'style'               => 'default',
		'class'               => '',
		'visibility'          => '',

		// Ooptions
		'back_image'          => true,

		// Layout
		'columns'             => '4',
		'columns__sm'         => '',
		'columns__md'         => '',
		'col_spacing'         => 'small',
		'type'                => 'slider', // slider, row, masonery, grid
		'width'               => '',
		'grid'                => '1',
		'grid_height'         => '600px',
		'grid_height__md'     => '500px',
		'grid_height__sm'     => '400px',
		'slider_nav_style'    => 'reveal',
		'slider_nav_position' => '',
		'slider_nav_color'    => '',
		'slider_bullets'      => 'false',
		'slider_arrows'       => 'true',
		'auto_slide'          => '',
		'infinitive'          => 'true',
		'depth'               => '',
		'depth_hover'         => '',
		'equalize_box'        => 'false',
		// posts
		'products'            => '8',
		'cat'                 => '',
		'excerpt'             => 'visible',
		'offset'              => '',
		'filter'              => '',
		// Posts Woo
		'orderby'             => '', // normal, sales, rand, date
		'order'               => '',
		'tags'                => '',
		'show'                => '', //featured, onsale
		'out_of_stock'        => '', // exclude.
		// Box styles
		'animate'             => '',
		'text_pos'            => 'bottom',
		'text_padding'        => '',
		'text_bg'             => '',
		'text_color'          => '',
		'text_hover'          => '',
		'text_align'          => 'center',
		'text_size'           => '',
		'image_size'          => '',
		'image_radius'        => '',
		'image_width'         => '',
		'image_height'        => '',
		'image_hover'         => '',
		'image_hover_alt'     => '',
		'image_overlay'       => '',
		'show_cat'            => 'true',
		'show_title'          => 'true',
		'show_rating'         => 'true',
		'show_price'          => 'true',
		'show_add_to_cart'    => 'true',
		'show_quick_view'     => 'true',

	), $atts ) );

	// Stop if visibility is hidden
	if ( $visibility == 'hidden' ) {
		return;
	}

	$items                             = flatsome_ux_product_box_items();
	$items['cat']['show']              = $show_cat;
	$items['title']['show']            = $show_title;
	$items['rating']['show']           = $show_rating;
	$items['price']['show']            = $show_price;
	$items['add_to_cart']['show']      = $show_add_to_cart;
	$items['add_to_cart_icon']['show'] = $show_add_to_cart;
	$items['quick_view']['show']       = $show_quick_view;
	$items                             = flatsome_box_item_toggle_start( $items );

	ob_start();

	// if no style is set
	if ( ! $style ) {
		$style = 'default';
	}

	$classes_box      = array( 'box' );
	$classes_image    = array();
	$classes_text     = array();
	$classes_repeater = array( $class );

	if ( $equalize_box === 'true' ) {
		$classes_repeater[] = 'equalize-box';
	}

	// Fix product on small screens
	if ( $style == 'overlay' || $style == 'shade' ) {
		if ( ! $columns__sm ) {
			$columns__sm = 1;
		}
	}

	if ( $tag == 'ux_bestseller_products' ) {
		if ( ! $orderby ) {
			$atts['orderby'] = 'sales';
		}
	} else if ( $tag == 'ux_featured_products' ) {
		$atts['show'] = 'featured';
	} else if ( $tag == 'ux_sale_products' ) {
		$atts['show'] = 'onsale';
	} else if ( $tag == 'products_pinterest_style' ) {
		$type            = 'masonry';
		$style           = 'overlay';
		$text_align      = 'center';
		$image_size      = 'medium';
		$text_pos        = 'middle';
		$text_hover      = 'hover-slide';
		$image_hover     = 'overlay-add';
		$class           = 'featured-product';
		$back_image      = false;
		$image_hover_alt = 'image-zoom-long';
	} else if ( $tag == 'product_lookbook' ) {
		$type             = 'slider';
		$style            = 'overlay';
		$col_spacing      = 'collapse';
		$text_align       = 'center';
		$image_size       = 'medium';
		$slider_nav_style = 'circle';
		$text_pos         = 'middle';
		$text_hover       = 'hover-slide';
		$image_hover      = 'overlay-add';
		$image_hover_alt  = 'zoom-long';
		$class            = 'featured-product';
		$back_image       = false;
	}

	// Fix grids
	if ( $type == 'grid' ) {
		if ( ! $text_pos ) {
			$text_pos = 'center';
		}
		if ( ! $text_color ) {
			$text_color = 'dark';
		}
		if ( $style !== 'shade' ) {
			$style = 'overlay';
		}
		$columns      = 0;
		$current_grid = 0;
		$grid         = flatsome_get_grid( $grid );
		$grid_total   = count( $grid );
		flatsome_get_grid_height( $grid_height, $_id );
	}

	// Fix image size
	if ( ! $image_size ) {
		$image_size = 'woocommerce_thumbnail';
	}

	// Add Animations
	if ( $animate ) {
		$animate = 'data-animate="' . $animate . '"';
	}


	// Set box style
	if ( $class ) {
		$classes_box[] = $class;
	}
	$classes_box[] = 'has-hover';
	if ( $style ) {
		$classes_box[] = 'box-' . $style;
	}
	if ( $style == 'overlay' ) {
		$classes_box[] = 'dark';
	}
	if ( $style == 'shade' ) {
		$classes_box[] = 'dark';
	}
	if ( $style == 'badge' ) {
		$classes_box[] = 'hover-dark';
	}
	if ( $text_pos ) {
		$classes_box[] = 'box-text-' . $text_pos;
	}
	if ( $style == 'overlay' && ! $image_overlay ) {
		$image_overlay = true;
	}

	if ( $image_hover ) {
		$classes_image[] = 'image-' . $image_hover;
	}
	if ( $image_hover_alt ) {
		$classes_image[] = 'image-' . $image_hover_alt;
	}
	if ( $image_height ) {
		$classes_image[] = 'image-cover';
	}

	// Text classes
	if ( $text_hover ) {
		$classes_text[] = 'show-on-hover hover-' . $text_hover;
	}
	if ( $text_align ) {
		$classes_text[] = 'text-' . $text_align;
	}
	if ( $text_size ) {
		$classes_text[] = 'is-' . $text_size;
	}
	if ( $text_color == 'dark' ) {
		$classes_text[] = 'dark';
	}

	$css_args_img = array(
		array( 'attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%' ),
		array( 'attribute' => 'width', 'value' => $image_width, 'unit' => '%' ),
	);

	$css_image_height = array(
		array( 'attribute' => 'padding-top', 'value' => $image_height ),
	);

	$css_args = array(
		array( 'attribute' => 'background-color', 'value' => $text_bg ),
		array( 'attribute' => 'padding', 'value' => $text_padding ),
	);

	// If default style
	if ( $style == 'default' ) {
		$depth       = get_theme_mod( 'category_shadow' );
		$depth_hover = get_theme_mod( 'category_shadow_hover' );
	}

	// Repeater styles
	$repater['id']                  = $_id;
	$repater['title']               = $title;
	$repater['tag']                 = $tag;
	$repater['class']               = implode( ' ', $classes_repeater );
	$repater['visibility']          = $visibility;
	$repater['type']                = $type;
	$repater['style']               = $style;
	$repater['slider_style']        = $slider_nav_style;
	$repater['slider_nav_color']    = $slider_nav_color;
	$repater['slider_nav_position'] = $slider_nav_position;
	$repater['slider_bullets']      = $slider_bullets;
	$repater['auto_slide']          = $auto_slide;
	$repater['row_spacing']         = $col_spacing;
	$repater['row_width']           = $width;
	$repater['columns']             = $columns;
	$repater['columns__md']         = $columns__md;
	$repater['columns__sm']         = $columns__sm;
	$repater['filter']              = $filter;
	$repater['depth']               = $depth;
	$repater['depth_hover']         = $depth_hover;

	get_flatsome_repeater_start( $repater );

	?>
	<?php

	if ( empty( $ids ) ) {

		// Get products
		$atts['products'] = $products;
		$atts['offset']   = $offset;
		$atts['cat']      = $cat;

		$products = ux_list_products( $atts );

	} else {
		// Get custom ids
		$ids = explode( ',', $ids );
		$ids = array_map( 'trim', $ids );

		$args = array(
			'post__in'            => $ids,
			'post_type'           => 'product',
			'numberposts'         => - 1,
			'posts_per_page'      => - 1,
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => true,
		);

		$products = new WP_Query( $args );
	}

	if ( $products->have_posts() ) : ?>

		<?php while ( $products->have_posts() ) : $products->the_post(); ?>

			<?php
			global $product;

			if ( $style == 'default' ) {
				wc_get_template_part( 'content', 'product' );
			} else { ?>
				<?php

				$classes_col = array( 'col' );

				$out_of_stock = ! $product->is_in_stock();
				if ( $out_of_stock ) {
					$classes[] = 'out-of-stock';
				}

				if ( $type == 'grid' ) {
					if ( $grid_total > $current_grid ) {
						$current_grid ++;
					}
					$current       = $current_grid - 1;
					$classes_col[] = 'grid-col';
					if ( $grid[ $current ]['height'] ) {
						$classes_col[] = 'grid-col-' . $grid[ $current ]['height'];
					}

					if ( $grid[ $current ]['span'] ) {
						$classes_col[] = 'large-' . $grid[ $current ]['span'];
					}
					if ( $grid[ $current ]['md'] ) {
						$classes_col[] = 'medium-' . $grid[ $current ]['md'];
					}
					// Set image size
					if ( $grid[ $current ]['size'] ) {
						$image_size = $grid[ $current ]['size'];
					}
				}
				?>

				<div class="<?php echo implode( ' ', $classes_col ); ?>" <?php echo $animate; ?>>
					<div class="col-inner">
						<?php woocommerce_show_product_loop_sale_flash(); ?>
						<div class="product-small <?php echo implode( ' ', apply_filters( 'wvs_pro_ux_products_shortcode_class', $classes_box, $product ) ); ?>">
							<div class="box-image" <?php echo get_shortcode_inline_css( $css_args_img ); ?>>
								<div class="<?php echo implode( ' ', $classes_image ); ?>" <?php echo get_shortcode_inline_css( $css_image_height ); ?>>
									<a href="<?php echo get_the_permalink(); ?>">
										<?php
										if ( $back_image ) {
											flatsome_woocommerce_get_alt_product_thumbnail( $image_size );
										}
										echo woocommerce_get_product_thumbnail( $image_size );
										?>
									</a>
									<?php if ( $image_overlay ) { ?>
									<div class="overlay fill" style="background-color: <?php echo $image_overlay; ?>"></div><?php } ?>
									<?php if ( $style == 'shade' ) { ?>
										<div class="shade"></div><?php } ?>
								</div>
								<div class="image-tools top right show-on-hover">
									<?php do_action( 'flatsome_product_box_tools_top' ); ?>
								</div>
								<?php if ( $style !== 'shade' && $style !== 'overlay' ) { ?>
									<div class="image-tools <?php echo flatsome_product_box_actions_class(); ?>">
										<?php do_action( 'flatsome_product_box_actions' ); ?>
									</div>
								<?php } ?>
								<?php if ( $out_of_stock ) { ?>
									<div class="out-of-stock-label"><?php _e( 'Out of stock', 'woocommerce' ); ?></div><?php } ?>
							</div>

							<div class="box-text <?php echo implode( ' ', $classes_text ); ?>" <?php echo get_shortcode_inline_css( $css_args ); ?>>
								<?php
								do_action( 'woocommerce_before_shop_loop_item_title' );

								echo '<div class="title-wrapper">';
								do_action( 'woocommerce_shop_loop_item_title' );
								echo '</div>';

								echo '<div class="price-wrapper">';
								do_action( 'woocommerce_after_shop_loop_item_title' );
								echo '</div>';

								if ( $style == 'shade' || $style == 'overlay' ) {
									echo '<div class="overlay-tools">';
									do_action( 'flatsome_product_box_actions' );
									echo '</div>';
								}

								do_action( 'flatsome_product_box_after' );

								?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php endwhile; // end of the loop. ?>
	<?php

	endif;
	wp_reset_query();

	get_flatsome_repeater_end( $repater );
	flatsome_box_item_toggle_end( $items );

	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function flatsome_woocommerce_shop_loop_button() {

	if ( get_theme_mod( 'add_to_cart_icon', flatsome_defaults( 'add_to_cart_icon' ) ) !== "button" ) {
		return;
	}

	global $product;

	$args = array();

	$defaults = array(
		'quantity'   => 1,
		'class'      => implode(
			' ', array_filter(
				array(
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
					esc_attr( 'button' ), // Button
					esc_attr( 'primary' ), // Button color
					'is-' . esc_attr( get_theme_mod( 'add_to_cart_style', 'outline' ) ), // Button style
					'mb-0',
					'is-' . esc_attr( 'small' ), // Button size
				)
			)
		),
		'attributes' => array(
			'data-product_id'  => $product->get_id(),
			'data-product_sku' => $product->get_sku(),
			'data-quantity'    => esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
			'rel'              => 'nofollow',
		),
	);

	$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

	echo apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf( '<div class="add-to-cart-button"><a href="%s" class="%s" %s>%s</a></div>', esc_url( $product->add_to_cart_url() ), esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ), isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '', esc_html( $product->add_to_cart_text() ) ), $product, $args );

}

function flatsome_product_box_actions_add_to_cart() {

	// Check if active
	if ( get_theme_mod( 'add_to_cart_icon', flatsome_defaults( 'add_to_cart_icon' ) ) !== "show" ) {
		return;
	}

	global $product;

	$args = array();

	$defaults = array(
		'quantity'   => 1,
		'class'      => implode(
			' ', array_filter(
				array(
					'add-to-cart-grid',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				)
			)
		),
		'attributes' => array(
			'data-product_id'  => $product->get_id(),
			'data-product_sku' => $product->get_sku(),
			'data-quantity'    => esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
			'rel'              => 'nofollow',
		),
	);

	$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

	echo apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf( '<a href="%s" class="%s" %s style="width:0"><div class="cart-icon tooltip absolute is-small" title="%s"><strong>+</strong></div></a>', esc_url( $product->add_to_cart_url() ), esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ), isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '', esc_html( $product->add_to_cart_text() ) ), $product, $args );

}

add_filter(
	'wvs_pro_ux_products_shortcode_class', function ( $classes, $product ) {


	if ( $product->is_type( 'variable' ) ) {
		$classes[] = 'wvs-pro-product';
		$classes[] = sprintf( 'wvs-pro-%s-cart-button', woo_variation_swatches()->get_option( 'archive_swatches_position' ) );
	}

	return $classes;
}, 10, 2
);

add_action(
	'init', function () {

	if ( class_exists( 'Flatsome_Default' ) ) {

		// remove_filter( 'woocommerce_loop_add_to_cart_link', 'wvs_pro_loop_add_to_cart_link', 20 );
		// add_filter( 'wvs_pro_show_archive_variation_template', '__return_false' );
		// add_action( 'flatsome_product_box_after', 'wvs_pro_archive_variation_template', 110 );


		if ( get_theme_mod( 'add_to_cart_icon', flatsome_defaults( 'add_to_cart_icon' ) ) === "show" ) {
			add_filter( 'wvs_pro_select_options_text', '__return_empty_string' );
			add_filter( 'wvs_pro_add_to_cart_text', '__return_empty_string' );
		}

		remove_shortcode( "ux_bestseller_products" );
		remove_shortcode( "ux_featured_products" );
		remove_shortcode( "ux_sale_products" );
		remove_shortcode( "ux_latest_products" );
		remove_shortcode( "ux_custom_products" );
		remove_shortcode( "product_lookbook" );
		remove_shortcode( "products_pinterest_style" );
		remove_shortcode( "ux_products" );


		add_shortcode( "ux_bestseller_products", "wvs_pro_ux_products" );
		add_shortcode( "ux_featured_products", "wvs_pro_ux_products" );
		add_shortcode( "ux_sale_products", "wvs_pro_ux_products" );
		add_shortcode( "ux_latest_products", "wvs_pro_ux_products" );
		add_shortcode( "ux_custom_products", "wvs_pro_ux_products" );
		add_shortcode( "product_lookbook", "wvs_pro_ux_products" );
		add_shortcode( "products_pinterest_style", "wvs_pro_ux_products" );
		add_shortcode( "ux_products", "wvs_pro_ux_products" );


		if ( has_action( 'flatsome_product_box_after' ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );
		}

		$position = ( 'after' === woo_variation_swatches()->get_option( 'archive_swatches_position' ) ? 100 : 90 );
		add_action( 'flatsome_product_box_after', 'wvs_pro_archive_variation_template', $position );
	}
}
);


// ==========================================================
// OceanWP Theme
// ==========================================================

if ( ! function_exists( 'wvs_oceanwp_theme_support' ) ):
	function wvs_oceanwp_theme_support() {
		if ( class_exists( 'OCEANWP_Theme_Class' ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );

			$position = trim( woo_variation_swatches()->get_option( 'archive_swatches_position' ) );

			add_action( sprintf( 'ocean_%s_archive_product_add_to_cart', $position ), 'wvs_pro_archive_variation_template' );

			/*add_filter( 'wp_get_attachment_image_attributes', function ( $attr ) {
				$attr[ 'class' ] .= ' wp-post-image';

				return $attr;
			} );*/
		}
	}
endif;

add_action( 'init', 'wvs_oceanwp_theme_support' );
add_filter(
	'woo_variation_swatches_archive_image_selector', function ( $default ) {

	if ( class_exists( 'OCEANWP_Theme_Class' ) ) {
		return '.woo-entry-image-main';
	}

	return $default;
}
);


// ==========================================================
// Shopkeeper Theme
// ==========================================================

if ( ! function_exists( 'wvs_shopkeeper_theme_support' ) ):
	function wvs_shopkeeper_theme_support() {
		if ( defined( 'GETBOWTIED_WOOCOMMERCE_IS_ACTIVE' ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );
		}
	}
endif;

add_action( 'init', 'wvs_shopkeeper_theme_support' );


// ==========================================================
// Adiva Theme
// ==========================================================

if ( ! function_exists( 'wvs_adiva_theme_support' ) ):
	function wvs_adiva_theme_support() {
		if ( function_exists( 'adiva_setup' ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );


			add_action( 'woocommerce_after_shop_loop_item_title', 'wvs_pro_archive_variation_template' );

			add_filter(
				'woo_variation_swatches_archive_add_to_cart_button_text', function ( $text ) {
				return '<span class="tooltip">' . $text . '</span>';
			}
			);

		}
	}
endif;

add_action( 'init', 'wvs_adiva_theme_support' );


// ==========================================================
// ShopIsle Theme
// ==========================================================

if ( ! function_exists( 'wvs_shopisle_theme_support' ) ):
	function wvs_shopisle_theme_support() {
		wp_dequeue_script( 'shop-isle-navigation' );
	}
endif;

add_action( 'wp_enqueue_scripts', 'wvs_shopisle_theme_support', 20 );


// ==========================================================
// Ecome Theme
// ==========================================================

if ( ! function_exists( 'wvs_ecome_theme_support' ) ):
	function wvs_ecome_theme_support() {

		if ( class_exists( 'Ecome_Functions' ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'ecome_action_attributes', 20 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'wvs_pro_archive_variation_template', 30 );
		}
	}
endif;

add_action( 'init', 'wvs_ecome_theme_support', 20 );

// ==========================================================
// WOODMART Theme
// ==========================================================

if ( ! function_exists( 'wvs_woodmart_theme_support' ) ):
	function wvs_woodmart_theme_support() {

		if ( class_exists( 'WOODMART_Theme' ) ) {

			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );

			add_filter(
				'woo_variation_swatches_archive_add_to_cart_button_text', function ( $text ) {
				return '<span>' . $text . '</span>';
			}
			);
		}
	}
endif;

add_action( 'init', 'wvs_woodmart_theme_support', 20 );

function woodmart_swatches_list() {
	ob_start();
	wvs_pro_archive_variation_template();

	return ob_get_clean();
}

// ==========================================================
// Atelier Theme
// ==========================================================

if ( ! function_exists( 'wvs_atelier_theme_support' ) ):
	function wvs_atelier_theme_support() {

		if ( function_exists( 'sf_atelier_setup' ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'wvs_pro_archive_variation_template', 50 );

			add_filter(
				'woo_variation_swatches_archive_add_to_cart_select_options', function ( $text ) {
				return '<i class="sf-icon-variable-options"></i><span>' . $text . '</span>';
			}
			);

			add_filter(
				'woo_variation_swatches_archive_add_to_cart_text', function ( $text ) {
				return apply_filters( 'add_to_cart_icon', '<i class="sf-icon-add-to-cart"></i>' ) . '<span>' . $text . '</span>';
			}
			);

		}
	}
endif;

add_action( 'init', 'wvs_atelier_theme_support', 20 );


// ==========================================================
// Salient Theme Material Style
// ==========================================================

if ( ! function_exists( 'wvs_salient_theme_support' ) ):
	function wvs_salient_theme_support() {
		if ( function_exists( 'get_nectar_theme_options' ) ):


			$options       = get_nectar_theme_options();
			$product_style = ( ! empty( $options['product_style'] ) ) ? $options['product_style'] : 'classic';

			if ( 'material' === $product_style ) {
				remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
				remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );

				add_action( 'woocommerce_after_shop_loop_item_title', 'wvs_pro_archive_variation_template' );


				add_filter(
					'woo_variation_swatches_archive_add_to_cart_button_text', function ( $text ) {
					return '<span class="text">' . esc_html( $text ) . '</span>';
				}
				);
			}

			if ( 'minimal' === $product_style ) {
				add_filter(
					'woo_variation_swatches_archive_add_to_cart_button_text', function ( $text ) {
					return '<i class="normal icon-salient-cart"></i><span>' . esc_html( $text ) . '</span>';
				}
				);
			}

		endif;
	}
endif;

add_action( 'init', 'wvs_salient_theme_support', 20 );


// ==========================================================
// Woodstock Theme
// ==========================================================

if ( ! function_exists( 'wvs_woodstock_theme_support' ) ):
	function wvs_woodstock_theme_support() {
		if ( function_exists( 'woodstock_setup' ) ) {
			add_filter(
				'woo_variation_swatches_archive_product_wrapper', function () {
				return '.product-item';
			}
			);

			add_filter(
				'woo_variation_swatches_archive_add_to_cart_text', function () {
				return '<span class="button-loader"></span>' . __( 'Add to cart', 'woocommerce' );
			}
			);
		}
	}
endif;

add_action( 'init', 'wvs_woodstock_theme_support', 20 );

function woodstock_loop_action_buttons() {
	?>

	<div class="prod-plugins">
		<ul>
			<?php


			echo '<li>' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</li>';

			echo '<li>' . do_shortcode( '[yith_compare_button]' ) . '</li>';

			?>
		</ul>
	</div>

	<?php do_action( 'wvs_pro_variation_show_archive_variation' ); ?>

	<?php
}


// ==========================================================
// UnCode Theme
// ==========================================================

if ( ! function_exists( 'wvs_uncode_theme_support' ) ):
	function wvs_uncode_theme_support() {
		if ( function_exists( 'uncode_setup' ) ) {
			//	add_action( 'woocommerce_after_shop_loop_item_title', 'wvs_pro_archive_variation_template', 20 );

			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'wvs_pro_archive_variation_template', 20 );

			add_filter(
				'woo_variation_swatches_archive_add_to_cart_button_selector', function () {
				return '.add_to_cart_button';
			}
			);
		}
	}
endif;

add_action( 'init', 'wvs_uncode_theme_support', 20 );

add_filter(
	'woo_variation_swatches_archive_image_selector', function ( $default ) {

	if ( function_exists( 'uncode_setup' ) ) {
		return '.pushed img';
	}

	return $default;
}
);


// ==========================================================
// Savoy Theme
// ==========================================================

if ( ! function_exists( 'wvs_savoy_theme_support' ) ):
	function wvs_savoy_theme_support() {
		if ( function_exists( 'nm_theme_support' ) ) {

			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );

		}
	}
endif;

add_action( 'init', 'wvs_savoy_theme_support', 20 );


// ==========================================================
// Claue Theme
// ==========================================================

if ( ! function_exists( 'wvs_jas_claue_theme_support' ) ):
	function wvs_jas_claue_theme_support() {
		if ( function_exists( 'jas_claue_setup' ) ) {

			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'wvs_pro_archive_variation_template', 30 );
		}
	}
endif;

add_action( 'init', 'wvs_jas_claue_theme_support', 20 );


// ==========================================================
// The7 Theme
// ==========================================================

if ( ! function_exists( 'wvs_the7_theme_support' ) ):
	function wvs_the7_theme_support() {

		if ( function_exists( 'presscore_setup' ) ) {

			add_filter(
				'woo_variation_swatches_archive_add_to_cart_button_text', function ( $text ) {
				$icon_class = of_get_option( 'woocommerce_add_to_cart_icon' );

				return sprintf( '<span class="filter-popup">%s</span><i class="popup-icon %s"></i>', $text, $icon_class );
			}
			);
		}
	}
endif;

add_action( 'init', 'wvs_the7_theme_support', 20 );


// ==========================================================
// martfury Theme
// ==========================================================

if ( ! function_exists( 'wvs_martfury_theme_support' ) ):
	function wvs_martfury_theme_support() {

		if ( function_exists( 'martfury_setup' ) ) {

			add_filter(
				'woo_variation_swatches_archive_add_to_cart_button_text', function ( $text ) {
				return sprintf( '<i class="p-icon icon-bag2" data-rel="tooltip" title="%1$s"></i><span class="add-to-cart-text">%1$s</span>', $text );
			}
			);
		}
	}
endif;

add_action( 'init', 'wvs_martfury_theme_support', 20 );


// ==========================================================
// Dfd Ronneby Theme
// ==========================================================

if ( ! function_exists( 'wvs_dfd_ronneby_theme_support' ) ):
	function wvs_dfd_ronneby_theme_support() {

		if ( class_exists( 'Dfd_Ronneby_Includes' ) ) {
			remove_filter( 'wp_get_attachment_image_attributes', 'wvs_add_default_attachment_image_class', 9 );
			// add_filter( 'woocommerce_product_get_image', 'wvs_add_default_archive_image_class' );
		}
	}
endif;

add_action( 'init', 'wvs_dfd_ronneby_theme_support', 20 );