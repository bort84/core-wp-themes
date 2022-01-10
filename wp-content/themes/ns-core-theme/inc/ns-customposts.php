<?php

/* Simple function (that should be built into WordPress!) that greatly simplifies the creation of custom taxonomies.
 * 
 * @param  string			$post_type						(REQUIRED)  The slug of the new Post type.
 * @param  string 		$post_name 						(REQUIRED)  Plural name of Post (e.g., Books)
 * @param  string 		$post_singular_name 	(Optional) 	Singular name of Taxonomy. Defaults to $tax_name. (e.g., Book)
 * @param  boolean 		$is_public 						(Optional) 	Set whether users will be able to see the post
 * @param  array 			$extras 							(Optional) 	Additional settings to overwrite defaults
 * 
 * @return void
 */

function ns_custom_posts($post_type, $post_name, $post_singular_name, $is_public=false, $extras=[], $text_domain='') {
	$labels = array(
		'name'                  => _x( $post_name, 'Post type general name', $text_domain ),
		'singular_name'         => _x( $post_singular_name, 'Post type singular name', $text_domain ),
		'menu_name'             => _x( $post_name, 'Admin Menu text', $text_domain ),
		'name_admin_bar'        => _x( $post_singular_name, 'Add New on Toolbar', $text_domain ),
		'add_new'               => __( 'Add New', $text_domain ),
		'add_new_item'          => __( 'Add New '.$post_singular_name, $text_domain ),
		'new_item'              => __( 'New '.$post_singular_name, $text_domain ),
		'edit_item'             => __( 'Edit '.$post_singular_name, $text_domain ),
		'view_item'             => __( 'View '.$post_singular_name, $text_domain ),
		'all_items'             => __( 'All '.$post_name, $text_domain ),
		'search_items'          => __( 'Search '.$post_name, $text_domain ),
		'parent_item_colon'     => __( 'Parent '.$post_name.':', $text_domain ),
		'not_found'             => __( 'No '.$post_name.' found.', $text_domain ),
		'not_found_in_trash'    => __( 'No '.$post_name.' found in Trash.', $text_domain )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => $post_type ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	);

	$args = array_merge($args, $extras);

	if(!$is_public) {
		$args = array_merge($args, array(
			'public' 				=> false,
			'has_archive' 	=> false,
			'rewrite' 			=> false
		));
	}

	register_post_type( $post_type, $args );
}