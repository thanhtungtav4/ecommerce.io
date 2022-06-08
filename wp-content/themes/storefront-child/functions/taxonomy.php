<?php
 function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Thương Hiệu.
	 */

	$labels = [
		"name" => __( "Thương Hiệu", "custom-post-type-ui" ),
		"singular_name" => __( "Thương Hiệu", "custom-post-type-ui" ),
	];


	$args = [
		"label" => __( "Thương Hiệu", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'thuong-hieu', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "thuong-hieu",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy( "thuong-hieu", [ "product" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );