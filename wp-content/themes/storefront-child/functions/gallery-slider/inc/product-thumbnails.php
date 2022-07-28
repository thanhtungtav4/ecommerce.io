<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;
$version = '3.0';

if( version_compare( $woocommerce->version, $version, ">=" ) ) {
	$attachment_ids = $product->get_gallery_image_ids();
	$wooLatest = true;
}else{
	$attachment_ids = $product->get_gallery_attachment_ids();
	$wooLatest = false;
}

if ( has_post_thumbnail() ) {
	$thumbanil_id   = array(get_post_thumbnail_id());
	$attachment_ids = array_merge($thumbanil_id,$attachment_ids);
}

if ( $attachment_ids )
{
	//vertical-thumb-right
	?>

	<div id="wpgis-gallery" class="slider wpgis-slider-nav"><?php

		foreach ( $attachment_ids as $attachment_id )
		{
			$props = wc_get_product_attachment_props( $attachment_id, $post );

			if($wooLatest){
				$thumbnails_catlog = '';
			}else{
				$thumbnails_catlog = '';
			}

			if ( ! $props['url'] ) {
				continue;
			}

			echo apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					'<li title="%s"><img src="%s">
					</li>',
					esc_attr( $props['caption'] ),
					wp_get_attachment_image_url( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'thumbnail' ), 0, $thumbnails_catlog )
				),
				$attachment_id,
				$post->ID
			);
		}

	?></div>
	<?php
}