<?php

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ZAzRe-}~%qa<{vD)Ui)a;f2`~o(G/& [/YMLg{L4J-?Bid24|K=rx%9(Sr*jGR(w');
define('SECURE_AUTH_KEY',  '.XtF^NzV(x-!+zhMo5c:*Ot5=nqH)L#&`RNz6Wh{,8OoF<E}loE$s5-D|d[>+ga!');
define('LOGGED_IN_KEY',    ':q>|W>3?%T%aZ}QwTnG*rrrKwVv0wM>l]qO+x-gqlv)=u9_xp7hH!g*&M-$xTc8$');
define('NONCE_KEY',        'Og2(UDeIGCq?+16):.hd6hxxPmd2OWNxc,fx,fnI?EP2H8SO1qR:})Jmt@9p|mGp');
define('AUTH_SALT',        'SD<O3E7EtU+]ocjROO}Y.5o%6Km+i~n$8a@Qhg TD=B4],NjEkOB`$OahOC27R|:');
define('SECURE_AUTH_SALT', 'P%xClw-zwg|a9h+>`)XUh|5?:4M5!Flzq)5]i^]:AqoDy_rDq+Gf`ezg`!^#Gh4c');
define('LOGGED_IN_SALT',   'dFL3wzE!Bney__pLT3`{H-SGy|{?J=BHn+?D;?~wlQXwk;)kA-0aRn-kzm[-ijXu');
define('NONCE_SALT',       '@qh{zb;< gv3DNWP}P>CH|y;:6j-RI`TrL|d}v?Tzt apWVE6rejR3KMG9$A?[o>');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * Increase memory limit. 
 */
define('WP_MEMORY_LIMIT', '64M');