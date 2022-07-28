<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;
$version = '3.0';
?>
<div class="images">
	<?php
		if ( has_post_thumbnail() )
		{
			if( version_compare( $woocommerce->version, $version, ">=" ) ) {
				$attachment_ids = $product->get_gallery_image_ids();
			}else{
				$attachment_ids = $product->get_gallery_attachment_ids();
			}

			$attachment_count = count( $attachment_ids);

			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$image_link       = wp_get_attachment_url( get_post_thumbnail_id() );
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );

			$fullimage        = get_the_post_thumbnail( $post->ID, 'full', array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );

			// wpgis FOR SLIDER vertical-img-right
			$html  = '<div class="slider wpgis-slider-for">';

			$html .= sprintf(
						'<div class="zoom">%s%s<a href="%s" class="wpgis-popup fa fa-expand" data-fancybox="product-gallery"></a></div>',
						$fullimage,
						$image,
						$image_link
					);

			foreach( $attachment_ids as $attachment_id ) {
			   $imgfull_src = wp_get_attachment_image_src( $attachment_id,'full');
			   $image_src   = wp_get_attachment_image_src( $attachment_id,'shop_single');
			   $html .= '<div class="zoom"><img src="'.$imgfull_src[0].'" /><img src="'.$image_src[0].'" /><a href="'.$imgfull_src[0].'" class="wpgis-popup fa fa-expand" data-fancybox="product-gallery"></a></div>';
			}

			$html .= '</div>';

			echo apply_filters(
				'woocommerce_single_product_image_html',
				$html,
				$post->ID
			);
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
		}

		do_action( 'woocommerce_product_thumbnails' );
	?>
</div>