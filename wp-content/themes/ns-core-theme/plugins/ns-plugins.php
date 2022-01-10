<?php
/**
 * For some sites, certain defualt plugins are always required
 * and easier to just roll into the theme.
 *
 * By default, these are all loaded, but you can turn them off
 * by editing the options in functions.php
 *
 */


/* http://alexking.org/blog/2012/07/09/include-plugin-in-wordpress-theme
Let's automatically load up the required plugins */

add_action('after_setup_theme', 'ns_load_plugins');

// This function loads the plugin.
function ns_load_plugins() {
	/* Disable ALL comments Plugin */
	if (!class_exists('Disable_Comments') && (DISABLE_COMMENTS)) {
		// load Social if not already loaded
		include_once(TEMPLATEPATH.'/plugins/disable-comments/disable-comments.php');
	}

	/* Allow uploads of SVG files */
	if (!class_exists('SVGSupport')) {

		include_once(TEMPLATEPATH.'/plugins/enable-svg-uploads/index.php');
	}
}