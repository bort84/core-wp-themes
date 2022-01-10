<?php
/* =================================================================
	Global Settings
 ================================================================= */

/* Misc Settings
=================================== */

/* WordPress by default, creates attachment pages for all media attached
to posts. They tend to be pointless, and no one one knows why they exist.
(That's a FACT.) Often, attachment pages are neglected and unstyled, and
look ugly. These pages will now be turned off by default. To turn them
back on, for whatever dumb reason, change this value to false. */
define("KILL_ATTACHMENT_PAGE", true); //(true/false)


/* Fixes bug in 4.7.2 that breaks mime types. Was supposed to be fixed
in 4.7.3 ...but that doesn't seem to be the case, so this has been added
to ns-core for the moment. */
define("DISABLE_REAL_MIME_CHECK", true); //(true/false)


/* Embedded Theme Plugins
=================================== */

/* Disable ALL comments Plugin */
define("DISABLE_COMMENTS", true); //(true/false)

/* Allow Drag & Drop ordering of posts */
define("POST_ORDERING", true); //(true/false)

/* Disable Ability For "Anyone can register" On Settings General Page */
update_option('users_can_register',0);

/* Hide NS Core Theme in admin */
add_filter('wp_prepare_themes_for_js', function($themes) {
	unset($themes['ns-core-theme']);
	return $themes;
});



/* =================================================================
	Theme Supports
 ================================================================= */


add_theme_support('post-thumbnails');
add_theme_support( 'title-tag' );
add_theme_support( 'html5', array( 'gallery', 'caption' ) );



/* =================================================================
	Scripts & Styles
 ================================================================= */

add_action( 'wp_enqueue_scripts', function() {

	// Note: jQuery has been removed -- Let's rely on WordPress for that...

	// Mostly this script kills the "user can register" option
	wp_register_script('admin-js', '/wp-content/themes/ns-core-theme/js/admin-min.js', false, false, false);
	wp_enqueue_script('admin-js');
} );


/* =================================================================
	Required Files

	It's best to avoid editing these files directly! If you need
	to adjust something, do it in this functions.php file.
 ================================================================= */

/* Functions that require no configuration and are worth being in every WordPress theme. Also includes Mobile_Detect */
require_once('inc/ns-core.php');

// Useful WordPress specific Functions created by NS
require_once( 'inc/ns-functions.php' );

// Embedded theme functions
require_once( 'plugins/ns-plugins.php' );

// Custom Posts Setup
require_once( 'inc/ns-customposts.php' );

// Custom Taxonomy Setup
require_once( 'inc/ns-customtax.php' );

// Custom Gutenberg Script
require_once( 'inc/ns-gutenberg.php' );

// ACF Specific functions & template tags
if (class_exists('acf'))
	require_once( 'inc/ns-acf.php' );

// Gravity forms specific functions
if (class_exists('GFForms'))
	require_once( 'inc/ns-gravity.php' );



/* =============================== Important! =================================

This line must always be at the bottom of this file.
If you ever need to call a function that exists in the parent, from
the child theme, then you need to reference this action, ns_parent_loaded
so that you can ensure the child function loads after the parent has loaded!

=============================== Important! ================================= */
do_action('ns_core_theme_loaded');