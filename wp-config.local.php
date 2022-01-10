<?php
/**
 * Production environment config settings
 *
 * Enter any WordPress config settings that are specific to this environment
 * in this file.
 *
 * @package    Studio 24 WordPress Multi-Environment Config
 * @version    1.0
 * @author     Studio 24 Ltd  <info@studio24.net>
 */


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

$SERVER = $_SERVER['HTTP_HOST'];

switch ($SERVER) {
	case 'ns.proxy-theme.test:2326':
		define('DB_NAME', 'ns_proxy_theme');
		define( 'UPLOADS', ''.'wp-content/uploads/proxy' );
		break;
	case 'ns.skeleton-theme.test:2326':
		define('DB_NAME', 'ns_skeleton_theme');
		define( 'UPLOADS', ''.'wp-content/uploads/skeleton' );
		break;
	default:
		define('DB_NAME', 'ns_core_theme');
		define( 'UPLOADS', ''.'wp-content/uploads/core' );
		break;
}

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

define('WP_SITEURL', 'http://' . $SERVER);
define('WP_HOME',    'http://' . $SERVER);

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);