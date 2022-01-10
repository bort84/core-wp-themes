<?php

/* Simple function (that should be built into WordPress!) that greatly simplifies the creation of custom taxonomies.
 * 
 * @param  string 		$tax  				(REQUIRED)  The slug of the new Taxonomy type.
 * @param  array/string  $posttypes 		(REQUIRED)  An array of post types to attach the Taxonomy to. 
 *											Also accepts one posttype as a string. 
 * @param  string 		$tax_name 			(REQUIRED)  Plural name of Taxonomy (e.g., Companies)
 * @param  string 		$tax_singular_name 	(Optional) 	Singular name of Taxonomy. Defaults to $tax_name. (e.g., Company)
 * @param  boolean 		$hierarchical 		(Optional) 	Should it have heiracthy like a Category (true), 
 *											or not like a Tag (false). Defaults to True. 	
 * @param  string 		$text_domain 		(Optional) 	Theme domain
 * @return void
 */

function ns_custom_taxonomy($tax, $posttypes, $tax_name, $tax_singular_name, $hierarchical=true, $text_domain='ns-core-theme') {

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( $tax_name, 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( $tax_singular_name, 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search '.$tax_name, 'textdomain' ),
		'all_items'         => __( 'All '.$tax_name, 'textdomain' ),
		'parent_item'       => __( 'Parent '.$tax_singular_name, 'textdomain' ),
		'parent_item_colon' => __( 'Parent '.$tax_singular_name.':', 'textdomain' ),
		'edit_item'         => __( 'Edit '.$tax_singular_name, 'textdomain' ),
		'update_item'       => __( 'Update '.$tax_singular_name, 'textdomain' ),
		'add_new_item'      => __( 'Add New '.$tax_singular_name, 'textdomain' ),
		'new_item_name'     => __( 'New '.$tax_singular_name.' Name', 'textdomain' ),
		'menu_name'         => __( $tax_singular_name, 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => $tax ),
	);

	register_taxonomy( $tax, $posttypes, $args );

}