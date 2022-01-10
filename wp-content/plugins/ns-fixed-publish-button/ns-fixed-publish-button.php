<?php 

/*
   Plugin Name: NS Fixed Publish Button
   Description: A plugin to allow the publish button to fix / scroll with you down the page.
   Version: 1.0.0
   Author: Northstreet Creative
   Author URI: http://northstreetcreative.com
   License: GPL2
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); 

/* Plugin Scripts */ 
add_action( 'admin_enqueue_scripts', 'plugin_scripts' );	
		
function plugin_scripts() {

	wp_enqueue_script('plugin-js', plugin_dir_url( __FILE__ ) . '/plugin.js', array( 'jquery' ), true);

	wp_enqueue_style('plugin-css', plugin_dir_url( __FILE__ ) . '/plugin.css');					
} 

// add_action('admin_menu', 'plugin_menu');

// function plugin_menu() {
// 	add_menu_page('Publish Button Settings', 'Publish Button Settings', 'administrator', 'publish-button-settings', 'publish_button_settings_page', 'dashicons-admin-generic');
// }

// add_action( 'admin_init', 'plugin_settings' );

// function plugin_settings() {
// 	register_setting( 'publish-button-settings-group', 'activate' );
// }

/* function publish_button_settings_page() { ?>
	<?php $post_types = get_post_types('', 'object', '');  ?>
  	<div class="wrap">
		<h2>Activate Fixed Publish Button</h2>
		<br/>
		<form method="post" action="options.php">
		    <?php settings_fields( 'publish-button-settings-group' ); ?>
		    <?php do_settings_sections( 'publish-button-settings-group' ); ?>
		    <?php foreach ($post_types as $post_type) {

		    	// Get post type names
		    	$post_type_name = $post_type->name;

		    	// Get an array of options from the database.
				$options = get_option( 'activate' );

				// Get the value of this option.
				$checked = $options[$post_type_name];

				// The value to compare with (the value of the checkbox below).
				$current = $post_type_name;

				// True by default, just here to make things clear.
				$echo = false;

			   	if ($post_type_name != 'attachment' && $post_type_name != 'revision' && $post_type_name != 'nav_menu_item' && $post_type_name != 'custom_css' && $post_type_name != 'customize_changeset' && $post_type_name != 'acf-fields') {
			   		echo '<div><input type="checkbox" name="activate['.$post_type_name.']" value="'.$post_type_name.'" '.checked( $checked, $current, $echo ).' /> <label>'.$post_type->label.'</label></div>';
			   	}

			   	if ($checked === $post_type_name) { echo $post_type_name; }
		    } ?>
		    <?php submit_button(); ?>
		</form>
	</div>
<?php } 

add_action( 'load-page.php', 'ns_post_meta_boxes_setup' );
add_action( 'load-page-new.php', 'ns_post_meta_boxes_setup' );
add_action( 'load-post.php', 'ns_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'ns_post_meta_boxes_setup' );

// Meta box setup function.
function ns_post_meta_boxes_setup() {

	// Add meta boxes on the 'add_meta_boxes' hook.
	add_action( 'add_meta_boxes', 'ns_add_post_meta_boxes' );
}

// Create one or more meta boxes to be displayed on the post editor screen.
function ns_add_post_meta_boxes() {

	add_meta_box(
		'ns-post-class',            // Unique ID
		'Post Class',   	        // Title
		'ns_post_class_meta_box',   // Callback function
		array('post', 'page'),      // Admin page (or post type)
		'side',                     // Context
		'high'                      // Priority
	);
}

// Display the post meta box.
function ns_post_class_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'ns_post_class_nonce' ); ?>

	<p>
	<label for="ns-post-class"><?php _e( "Add a custom CSS class, which will be applied to WordPress' post class.", 'example' ); ?></label>
	<br />
	<input class="widefat" type="text" name="ns-post-class" id="ns-post-class" value="<?php echo esc_attr( get_post_meta( $object->ID, 'ns_post_class', true ) ); ?>" size="30" />
	</p>
<?php } */ ?>