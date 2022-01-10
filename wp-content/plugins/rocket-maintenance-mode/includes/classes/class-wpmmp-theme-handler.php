<?php

class Wpmmp_Theme_Handler {

	protected $name;

	protected $description;

	protected $id;

	protected $path;

	protected $template_name;

	protected $settings_page;

	protected $settings_page_title;

	protected $settings_page_slug;

	protected $use_styles;

	function __construct() {

		$this->_filters();

		$this->hooks();

		$this->filters();

		$this->init();

	}

	function init() {


	}

	function hooks() {

	}

	function filters() {


	}

	private function _filters() {

		add_filter( 'wpmmp_themes', array( $this, 'register_theme' ) );

		if ( $this->is_activated() && $this->check_rules() ){
            
            $this->theme_change();
        }

	}

	public function name( $name = '' ) {

		if (  empty( $name ) )
			return $this->name;

		$this->name = $name;

	}

	public function description( $description = '' ) {

		if (  empty( $description ) )
			return $this->description;

		$this->description = $description;

	}

	public function id( $id = '' ) {

		if (  empty( $id ) )
			return $this->id;

		$this->id = $id;

	}

	function register_theme( $themes ) {

		if ( isset( $themes[$this->id] ) )
			return $themes;

		$themes[$this->id] = $this;

		return $themes;

	}

	public function is_activated( $theme_id = '' ) {

		if ( empty( $id ) )
			$id = $this->id();

		$theme = wpmmp_get_active_theme();


		if ( $id === 'default' ) {

			if ( strpos( $theme, 'default' ) !== false )
				return true;

		}

		return $theme == $id;

	}

	public function check_rules( $theme_id = '' ) {

        $request_uri = rtrim(strtolower(@parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)),'/');
        $request_uri = '/'.substr($request_uri, strrpos($request_uri, '/') + 1);
        if($request_uri != '/wp-login.php'){
            $request_uri .= $request_uri.'/';
        }

        // some URLs have to be accessible at all times
        if ($request_uri == '/wp-admin/' ||
            $request_uri == '/feed/' ||
            $request_uri == '/feed/rss/' ||
            $request_uri == '/feed/rss2/' ||
            $request_uri == '/feed/rdf/' ||
            $request_uri == '/feed/atom/' ||
            $request_uri == '/admin/' ||
            $request_uri == '/wp-login.php') {
            return;
        }


		if ( empty( $id ) )
			$id = $this->id();

		if ( isset( $_GET['wpmmp-mode'] ) ) {
			if ( $_GET['wpmmp-mode'] === 'enabled' ) {

				if ( wp_verify_nonce( $_GET['nonce'], 'wpmmp-preview-nonce' ) ) {

					if ( ! defined( 'WPMMP_DEBUG_MODE' ) )
						define( 'WPMMP_DEBUG_MODE', TRUE );

					return	apply_filters( 'wpmmp_check_rules', TRUE, 'preview' );
				}



			}
		}



		$status = get_option( 'mmp_on_off' );

		if ( $status !== '1' )
			return apply_filters( 'wpmmp_check_rules', FALSE, 'disabled' );

		return apply_filters( 'wpmmp_check_rules', TRUE, 'success' );

	}

	function theme_change() {

		if ( ! is_user_logged_in() ) {

            if(wpmmp_is_notificationx_really_setup_and_active()){
                ob_start();
                add_action('shutdown',array($this,'template_hook'), 0, 1);
            } else {
                add_action( 'template_redirect', array( $this, 'template_hook' ) );
            }

			return;
		}

		$allowed_roles = get_option( 'mmp_userroles' );

		if ( ! is_array( $allowed_roles ) )
			$allowed_roles = array('administrator');

		$current_user = wp_get_current_user();

		if ( array_intersect( $allowed_roles, $current_user->roles )
			&& ! defined( 'WPMMP_DEBUG_MODE' ) )
			return FALSE;


        if(wpmmp_is_notificationx_really_setup_and_active()){
            ob_start();
            add_action('shutdown',array($this,'template_hook'), 0, 1);
        } else {
            add_action( 'template_redirect', array( $this, 'template_hook' ) );	
        }
        
        

    }
    

	function theme_settings() {

		/* The message will be shown on the theme settings page if the theme do not support theme settings feature */

		_e( 'The current selected/activated theme do not have any settings or the theme might not have support for this feature.', 'wpmmp' );

	}

	function template_hook() {

		if ( get_option('mmp_feed_access') === '1' )
			$this->disable_feed();

		if ( file_exists( $this->path ) ) {

			if ( get_option('mmp_http_503') === '1' ) {

				header('HTTP/1.1 503 Service Temporarily Unavailable');
				header('Status: 503 Service Temporarily Unavailable');
				header('Retry-After: 3600');

			}

			$cd_date = '';

			$cd_hr_min = '';

			$dateTime = esc_attr(get_option('mmp_set_dateTime'));

			if ( $dateTime !== '' ) {

				$cd_date = $dateTime;

				$cd_date = str_replace( '-' , '/', $cd_date);

			}
            
                
            if(wpmmp_is_notificationx_really_setup_and_active()){
                libxml_use_internal_errors(true);
                $doc = new DOMDocument();
                $doc->loadHTML('<?xml encoding="UTF-8">' . ob_get_clean());
                $selector = new DOMXPath($doc);
                $notificationx_notification = get_option('mmp_notificationx_notification');
                if($notificationx_notification == 'all'){
                    $nx_query = 'nx-bar-';
                } else if($notificationx_notification>0){
                    $nx_query = 'nx-bar-'.$notificationx_notification;
                } else {
                    $nx_query = false;
                }
                
                if($nx_query !== false){
                    $nodes = $selector->query('//*[starts-with(@id, "'.$nx_query.'")]');
                    $nx_bar_html = array();
                    foreach($nodes as $node){
                        $nx_bar_html[] = $node->ownerDocument->saveHTML($node);
                    }
                }
            }

            include( $this->path );

            if(isset($nx_bar_html) && is_array($nx_bar_html) && count($nx_bar_html)>0){
                echo implode('',$nx_bar_html);
            }

			exit();

		}

	}

	function disable_feed() {

		add_action('do_feed', array( $this, 'disable_feed_message' ), 1);
		add_action('do_feed_rdf', array( $this, 'disable_feed_message' ), 1);
		add_action('do_feed_rss', array( $this, 'disable_feed_message' ), 1);
		add_action('do_feed_rss2', array( $this, 'disable_feed_message' ), 1);
		add_action('do_feed_atom', array( $this, 'disable_feed_message' ), 1);
		add_action('do_feed_rss2_comments', array( $this, 'disable_feed_message' ), 1);
		add_action('do_feed_atom_comments', array( $this, 'disable_feed_message' ), 1);

	}

	function disable_feed_message() {

		wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );

	}

	function _content( $content ) {

		if ( ! isset( $content_width ) )
			$content_width = 750;

		global $wp_embed;

		$content = $wp_embed->autoembed( $content );
    	$content = $wp_embed->run_shortcode( $content );
    	$content = do_shortcode( $content );
    	$content = wpautop( $content );

		return $content;
	}

	function add_settings_tab( $tabs ) {}

	function settings_get_tab( $tab ) {}

	function save_settings($tab){}
	function get_settings() { return array(); }

	function filter_settings( $settings ) {

		$settings[$this->id] = $this->get_settings();

		return $settings;

	}

	function add_styles() {

		include wpmmp_settings_part( 'add-styles' );

	}

	function hook_to_head() {

		include wpmmp_settings_part( 'add-hooktohead' );

	}

	function add_email_form($center=false) {

		include wpmmp_settings_part( 'add-email-form' );

	}

	function add_social_icons($center=false) {

		include wpmmp_settings_part( 'add-social-icons' );

	}

}
