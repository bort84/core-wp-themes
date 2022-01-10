<?php
/**
 * Plugin Name: Rocket Maintenance Mode & Coming Soon Page Builder
* Plugin URI: https://wordpress.org/plugins/rocket-maintenance-mode/
* Description: Add a responsive maintenance mode or coming soon page to your site that lets visitors know your site is down or under construction.
* Author: wpexpertsio
* Author URI: http://www.wpexperts.io/
* Version: 4.2
* 
* Copyright 2015 - 2019  WebFactory Ltd  (email: support@wpexperts.io)
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 2, as
* published by the Free Software Foundation.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// this is an include only WP file
if (!defined('ABSPATH')) {
  die;
}


define( 'WPMMP_PLUGIN_FILE', __FILE__ );

require plugin_dir_path( __FILE__ ) . 'config.php';
require WPMMP_PLUGIN_INCLUDE_DIRECTORY . 'functions.php';

define( 'WPMMP_PRO_VERSION_ENABLED', true );

add_option( 'wpmmp_install_version', WPMMP_PLUGIN_VERSION );

load_wpmmp();

require WPMMP_PLUGIN_INCLUDE_DIRECTORY . 'rocket_freemius.php';