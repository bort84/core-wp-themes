<?php

require 'pro-themes.php';

function load_wpmmp() {

	load_wpmmp_classes();

	//Plugin loaded
	do_action( 'wpmmp_loaded' );

}

function wpmmp_get_plugin_version() {
  $plugin_data = get_file_data(WPMMP_PLUGIN_FILE, array('version' => 'Version'), 'plugin');

  return $plugin_data['version'];
} // get_plugin_version

function wpmmp_generate_web_link($placement = '', $page = '/', $params = array(), $anchor = '') {
  $base_url = 'https://comingsoonwp.com';

  if ('/' != $page) {
    $page = '/' . trim($page, '/') . '/';
  }
  if ($page == '//') {
    $page = '/';
  }

  $parts = array_merge(array('utm_source' => 'rocket-free', 'utm_medium' => 'plugin', 'utm_content' => $placement, 'utm_campaign' => 'rocket-free-v' . wpmmp_get_plugin_version()), $params);

  if (!empty($anchor)) {
    $anchor = '#' . trim($anchor, '#');
  }

  $out = $base_url . $page . '?' . http_build_query($parts, '', '&amp;') . $anchor;

  return $out;
} // generate_web_link


  // helper function for adding plugins to fav list
  function wpmmp_featured_plugins_tab($args) {
    add_filter('plugins_api_result', 'wpmmp_plugins_api_result', 10, 3);

    return $args;
  } // featured_plugins_tab


  // add single plugin to list of favs
  function wpmmp_add_plugin_favs($plugin_slug, $res) {
    if (!empty($res->plugins) && is_array($res->plugins)) {
      foreach ($res->plugins as $plugin) {
        if (is_object($plugin) && $plugin->slug == $plugin_slug) {
          return $res;
        }
      } // foreach
    }

    if ($plugin_info = get_transient('wf-plugin-info-' . $plugin_slug)) {
      array_unshift($res->plugins, $plugin_info);
    } else {
      $plugin_info = plugins_api('plugin_information', array(
        'slug'   => $plugin_slug,
        'is_ssl' => is_ssl(),
        'fields' => array(
            'banners'           => true,
            'reviews'           => true,
            'downloaded'        => true,
            'active_installs'   => true,
            'icons'             => true,
            'short_description' => true,
        )
      ));
      if (!is_wp_error($plugin_info)) {
        $res->plugins[] = $plugin_info;
        set_transient('wf-plugin-info-' . $plugin_slug, $plugin_info, DAY_IN_SECONDS * 7);
      }
    }

    return $res;
  } // add_plugin_favs


  // add our plugins to recommended list
  function wpmmp_plugins_api_result($res, $action, $args) {
    remove_filter('plugins_api_result', 'wpmmp_plugins_api_result', 10, 3);

    $res = wpmmp_add_plugin_favs('wp-reset', $res);

    return $res;
  } // plugins_api_result



function wpmmp_empty_cache() {
  if (function_exists('w3tc_pgcache_flush')) {
    w3tc_pgcache_flush();
  }
  if (function_exists('wp_cache_clear_cache')) {
    wp_cache_clear_cache();
  }
  if (class_exists('Endurance_Page_Cache')) {
    $epc = new Endurance_Page_Cache;
    $epc->purge_all();
  }
  if (class_exists('SG_CachePress_Supercacher') && method_exists('SG_CachePress_Supercacher', 'purge_cache')) {
    SG_CachePress_Supercacher::purge_cache(true);
  }
  if (class_exists('SiteGround_Optimizer\Supercacher\Supercacher')) {
    SiteGround_Optimizer\Supercacher\Supercacher::purge_cache();
  }
  if (isset($GLOBALS['wp_fastest_cache']) && method_exists($GLOBALS['wp_fastest_cache'], 'deleteCache')) {
    $GLOBALS['wp_fastest_cache']->deleteCache(true);
  }
  if (is_callable(array('Swift_Performance_Cache', 'clear_all_cache'))) {
    Swift_Performance_Cache::clear_all_cache();
  }
}

function wpmmp_when_plugins_loaded() {

    delete_transient('_nx_meta_activation_notice');
    
    //Register and init the default theme
	new Wpmmp_Default_Theme();

	new Wpmmp_Alissa_Theme();

	new Wpmmp_Cs_Simple_Theme();

	new Wpmmp_Minimal_Theme();

	new Wpmmp_Mmone_Theme();

	new Wpmmp_Launch_Theme();

}


function load_wpmmp_classes() {

	wpmmp_include( 'classes/class-wpmmp-settings.php' );
	wpmmp_include( 'classes/class-wpmmp-theme-handler.php' );
	wpmmp_include( 'classes/class-wpmmp-default-theme.php' );
	wpmmp_include( 'classes/class-wpmmp-alissa-theme.php' );
	wpmmp_include( 'classes/class-wpmmp-cs-simple-theme.php' );
	wpmmp_include( 'classes/class-wpmmp-minimal-theme.php' );
	wpmmp_include( 'classes/class-wpmmp-mmone-theme.php' );
	wpmmp_include( 'classes/class-wpmmp-launch-theme.php' );

	new Wpmmp_Settings();

  add_action( 'plugins_loaded', 'wpmmp_when_plugins_loaded' );
  add_filter('install_plugins_table_api_args_featured', 'wpmmp_featured_plugins_tab');

}

function wpmmp_include( $file_name, $require = true ) {

	if ( $require )
		require WPMMP_PLUGIN_INCLUDE_DIRECTORY . $file_name;
	else
		include WPMMP_PLUGIN_INCLUDE_DIRECTORY . $file_name;

}

function wpmmp_view_path( $view_name, $is_php = true ) {

	if ( strpos( $view_name, '.php' ) === FALSE && $is_php )
		return WPMMP_PLUGIN_VIEW_DIRECTORY . $view_name . '.php';

	return WPMMP_PLUGIN_VIEW_DIRECTORY . $view_name;

}

function wpmmp_settings_part( $view_name, $is_php = true ) {

	$path = wpmmp_view_path( 'admin-settings/' . $view_name, $is_php );

	if ( file_exists( $path ) )
		return $path;

	return $view_name;

}

function wpmmp_image_url( $image_name ) {

	return plugins_url( 'images/' . $image_name, WPMMP_PLUGIN_MAIN_FILE );

}

function wpmmp_css_url( $name ) {

	return plugins_url( 'css/' . $name, WPMMP_PLUGIN_MAIN_FILE );

}

function wpmmp_get_themes() {

	$themes = array();

	return apply_filters( 'wpmmp_themes' , $themes );

}

function wpmmp_get_settings() {

	return Wpmmp_Settings::get_settings();

}



function wpmmp_get_single_setting( $key ) {

	$settings = wpmmp_get_settings();

	if ( ! isset( $settings[$key] ) )
		return apply_filters( 'wpmmp_get_single_setting', NULL );

	return apply_filters( 'wpmmp_get_single_setting', $settings[$key] );

}

function wpmmp_get_active_theme() {

	$theme = get_option('mmp_themes');

  return 'default';
	//return apply_filters( 'wpmmp_get_active_theme', $theme );

}


// check if NotificationX plugin is active
function wpmmp_is_notificationx_really_setup_and_active() {
    if (!function_exists('is_plugin_active') || !function_exists('get_plugin_data')) {
     require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    if (is_plugin_active('notificationx/notificationx.php') && version_compare(NOTIFICATIONX_VERSION,'1.0.3','>=')) {
      return true;
    } else {
      return false;
    }
  } // is_notificationx_really_setup_and_active


add_action('admin_action_install_notificationx', 'wpmmp_install_notificationx');

// auto download / install / activate NX plugin
function wpmmp_install_notificationx() {
    if (false === current_user_can('administrator')) {
      wp_die('Sorry, you have to be an admin to run this action.');
    }

    $plugin_slug = 'notificationx/notificationx.php';
    $plugin_zip = 'https://downloads.wordpress.org/plugin/notificationx.latest-stable.zip';

    @include_once ABSPATH . 'wp-admin/includes/plugin.php';
    @include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    @include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    @include_once ABSPATH . 'wp-admin/includes/file.php';
    @include_once ABSPATH . 'wp-admin/includes/misc.php';
		echo '<style>
		body{
			font-family: sans-serif;
			font-size: 14px;
			line-height: 1.5;
			color: #444;
		}
		</style>';

    echo '<div style="margin: 20px; color:#444;">';
    echo 'If things are not done in a minute <a target="_parent" href="' . admin_url('plugin-install.php?s=notificationx&tab=search&type=term') .'">install the plugin manually via Plugins page</a><br><br>';
    echo 'Starting ...<br><br>';

		wp_cache_flush();
    $upgrader = new Plugin_Upgrader();
    echo 'Check if NotificationX is already installed ... <br />';
    if (wpmmp_is_plugin_installed($plugin_slug)) {
      echo 'NotificationX is already installed! <br /><br />Making sure it\'s the latest version.<br />';
      $upgrader->upgrade($plugin_slug);
      $installed = true;
    } else {
      echo 'Installing NotificationX.<br />';
      $installed = $upgrader->install($plugin_zip);
    }
    wp_cache_flush();

    if (!is_wp_error($installed) && $installed) {
      echo 'Activating NotificationX.<br />';
      $activate = activate_plugin($plugin_slug);

      if (is_null($activate)) {
        echo 'NotificationX Activated.<br />';

        echo '<script>setTimeout(function() { top.location = "admin.php?page=wpmmp-settings"; }, 1000);</script>';
        echo '<br>If you are not redirected in a few seconds - <a href="admin.php?page=wpmmp-settings" target="_parent">click here</a>.';
      }
    } else {
      echo 'Could not install NotificationX. You\'ll have to <a target="_parent" href="' . admin_url('plugin-install.php?s=notificationx&tab=search&type=term') .'">download and install manually</a>.';
    }

    echo '</div>';
  } // install_notificationx

  function wpmmp_is_plugin_installed($slug) {
		if (!function_exists('get_plugins')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$all_plugins = get_plugins();

		if (!empty($all_plugins[$slug])) {
			return true;
		} else {
			return false;
		}
  } // is_plugin_installed