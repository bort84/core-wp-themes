<?php
/**
 * Development environment config settings
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
define('DB_NAME', 'db_CLIENTNAME');

/** MySQL database username */
define('DB_USER', 'db_CLIENTNAME');

/** MySQL database password */
define('DB_PASSWORD', 'PASSWORD');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/* You may find this causes issues on your server,
and hardcoding in these values may be the better strategy. */
$SERVER = $_SERVER['HTTP_HOST'];
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