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

function cptui_register_my_cpts() {

	/**
	 * Post Type: Tuyển Dụng.
	 */

	$labels = [
		"name" => __( "Tuyển Dụng", "storefront" ),
		"singular_name" => __( "Tuyển Dụng", "storefront" ),
	];

	$args = [
		"label" => __( "Tuyển Dụng", "storefront" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "tuyen_dung", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-pressthis",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "revisions", "author", "page-attributes", "post-formats" ],
		"taxonomies" => [ "location", "linh_vuc" ],
		"show_in_graphql" => false,
	];

	register_post_type( "tuyen_dung", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );

function cptui_register_my_taxesjob() {

	/**
	 * Taxonomy: Địa Điểm.
	 */

	$labels = [
		"name" => __( "Địa Điểm", "storefront" ),
		"singular_name" => __( "Địa Điểm", "storefront" ),
		"menu_name" => __( "Địa Điểm", "storefront" ),
		"all_items" => __( "All Địa Điểm", "storefront" ),
		"edit_item" => __( "Edit location", "storefront" ),
		"view_item" => __( "View location", "storefront" ),
		"update_item" => __( "Update location name", "storefront" ),
		"add_new_item" => __( "Add new location", "storefront" ),
		"new_item_name" => __( "New location name", "storefront" ),
		"parent_item" => __( "Parent location", "storefront" ),
		"parent_item_colon" => __( "Parent location:", "storefront" ),
		"search_items" => __( "Search Địa Điểm", "storefront" ),
		"popular_items" => __( "Popular Địa Điểm", "storefront" ),
		"separate_items_with_commas" => __( "Separate Địa Điểm with commas", "storefront" ),
		"add_or_remove_items" => __( "Add or remove Địa Điểm", "storefront" ),
		"choose_from_most_used" => __( "Choose from the most used Địa Điểm", "storefront" ),
		"not_found" => __( "No Địa Điểm found", "storefront" ),
		"no_terms" => __( "No Địa Điểm", "storefront" ),
		"items_list_navigation" => __( "Địa Điểm list navigation", "storefront" ),
		"items_list" => __( "Địa Điểm list", "storefront" ),
		"back_to_items" => __( "Back to Địa Điểm", "storefront" ),
		"name_field_description" => __( "The name is how it appears on your site.", "storefront" ),
		"parent_field_description" => __( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "storefront" ),
		"slug_field_description" => __( "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "storefront" ),
		"desc_field_description" => __( "The description is not prominent by default; however, some themes may show it.", "storefront" ),
	];

	
	$args = [
		"label" => __( "Địa Điểm", "storefront" ),
		"labels" => $labels,
		"public" => false,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'location', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "location",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "location", [ "tuyen_dung" ], $args );

	/**
	 * Taxonomy: Lĩnh Vực.
	 */

	$labels = [
		"name" => __( "Lĩnh Vực", "storefront" ),
		"singular_name" => __( "Lĩnh Vực", "storefront" ),
	];

	
	$args = [
		"label" => __( "Lĩnh Vực", "storefront" ),
		"labels" => $labels,
		"public" => false,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'linh_vuc', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "linh_vuc",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "linh_vuc", [ "tuyen_dung" ], $args );
}
add_action( 'init', 'cptui_register_my_taxesjob' );
