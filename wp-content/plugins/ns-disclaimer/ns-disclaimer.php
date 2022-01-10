<?php
/*
Plugin Name: Disclaimer 
Version: 12.21.2017
Description: Add a disclaimer to WP sites users have to agree before being allowed to the site. */

/* 
Requires "Mobile_Detect.php". This should already be called 
from ns-functions, but let's be certain.  
*/

if (!class_exists('Mobile_Detect')) {
	include_once('Mobile_Detect.php');
}

//Add to body class; requires that body_class() is used in theme!
function ns_mobile_detect($classes) {

	// Mobile Detect
	$detect = new Mobile_Detect;
	$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'modal' : 'modal') : '');

    $classes[] = $deviceType;
    return $classes;
}

add_filter('body_class', 'ns_mobile_detect');


// define the main class
class nsDisclaimer {

	var $cookie = 'ns-disclaimer';

	function setupMenu () {
		// add menu page to Settings
		add_submenu_page('options-general.php', 'Disclaimer', 'Disclaimer', 'manage_options', 'ns-disclaimer', array($this, 'page'));
	}

	function setupAdminCss () {
		echo'<style type="text/css">#disclaimer_ifr { height: 250px!important; }</style>';
	}

	function page () {
		/* Default to page 'disclaimer' if it exists. */
    	$disclaimer_slug = get_page_by_path('disclaimer', OBJECT, 'page');
    	if ($disclaimer_slug != '')
			$disclaimer_ID = $disclaimer_slug->ID;
		else $disclaimer_ID = 0;

		// print_r('ns-disclaimer');
		//delete_option( 'ns-disclaimer' );

		$defaults = array(
			'enabled'	  => 0,
			'page_id'     => $disclaimer_ID,
			'show_title'  => true,
			'title'       => 'Disclaimer',
			'd'			  => 0,
			'h'			  => 0,
			'm'			  => 30,
			'disclaimer'  => 'You need to agree to the following rules in order to view this site.',
			'refuse'	  => 0,
			'interval'	  => 'session',
			'refuse_url'  => '/',
			'agree' 	  => 'Agree',
			'agreeDesc'   => 'I have read and agree to the terms of this website.',
			'disagree'    => 'Disagree',
			'disagreeDesc'=> 'I disagree with these terms, and will not gain access to the website.',
			'readFullDisclaimer'=> 0,
			'readFullDisclaimerAlert'=>	'Please read the full disclaimer first.'		
		);

		// get current data
		$data = get_option('ns-disclaimer', $defaults);

		// The secret sauce that makes these defaults actually work as defaults. Wasn't before...
		$data = wp_parse_args( $data, $defaults );
		
		// process form submission
		$errors = array();
		if ( !empty($_POST) && wp_verify_nonce($_POST['disclaimer_nonce'], 'disclaimer_nonce') ) {

			$data['enabled'] 			= isset($_POST['enabled']) ? 1 : 0;
			$data['page_id']    		= trim($_POST['page_id']);
			$data['show_title']			= isset($_POST['show_title']) ? 1 : 0;
			$data['title']      		= isset($_POST['title']) ? trim($_POST['title']) : $defaults['title'];
			$data['d']    				= trim($_POST['d']);
			$data['h']    				= trim($_POST['h']);
			$data['m']    				= trim($_POST['m']);
			$data['disclaimer'] 		= isset($_POST['disclaimer']) ? trim($_POST['disclaimer']) : $defaults['disclaimer'];
			$data['interval'] 			= trim($_POST['interval']);
			$data['refuse'] 			= isset($_POST['refuse']) ? 1 : 0;
			$data['refuse_url'] 		= trim($_POST['refuse_url']);
			$data['agree'] 				= trim($_POST['agree']);
			$data['agreeDesc'] 			= trim($_POST['agreeDesc']);
			$data['disagree'] 			= trim($_POST['disagree']);
			$data['disagreeDesc'] 		= trim($_POST['disagreeDesc']);
			$data['readFullDisclaimer'] = isset($_POST['readFullDisclaimer']) ? 1 : 0;
			$data['readFullDisclaimerAlert'] = trim($_POST['readFullDisclaimerAlert']);

			if (!get_magic_quotes_gpc()) {
				$data = stripslashes_deep($data);
			}
			if ($data['refuse'] && empty($data['refuse_url'])) {
				$errors[] = 'Please provide the URL to redirect user to if he/she refuses the disclaimer';
			}
			if (empty($data['agree'])) {
				$errors[] = 'Please enter the text for Agree button';
			}
			if ($data['refuse'] && empty($data['disagree'])) {
				$errors[] = 'Please enter the text for Disagree button';
			}
			if ( count($errors) <= 0 ) {
				update_option('ns-disclaimer', $data);
				$success = 'Disclaimer data was successfully saved!';
			}
		}
		?>
		
<div class="wrap">
	<h2>Edit Disclaimer</h2>

	<form method="post" action="" enctype="multipart/form-data">
		<?php if ( count($errors) > 0 ) : ?>
		<div class="message error"><?php echo wpautop(implode("\n", $errors)); ?></div>
		<?php endif; ?>
		<?php if ( isset($success) && !empty($success) ) : ?>
		<div class="message updated"><?php echo wpautop($success); ?></div>
		<?php endif; ?>
		
		<h3>Options</h3>
    
		<p><label><input type="checkbox" value="1" name="enabled" <?php echo $data['enabled'] ? ' checked="checked"' : ''; ?>/> Disclaimer enabled?</label></p>

		<h3>Disclaimer Content Page</h3>
     	<p><label><?php wp_dropdown_pages( array('selected' => $data['page_id']) ); ?></label></p>
   
    	<h3>How often should the disclaimer appear?</h3>

		<p>
			<label><input type="radio" value="session" name="interval" onclick="document.getElementById('time_wrapper').style.display = this.checked ? 'none' : 'block';" <?php echo ($data['interval']=='session') ? ' checked="checked"' : ''; ?>/> Once per browser session.</label>
		</p>

		<p>
			<label><input type="radio" value="time" name="interval" onclick="document.getElementById('time_wrapper').style.display = this.checked ? 'block' : 'none';" <?php echo ($data['interval']=='time' ) ? ' checked="checked"' : ''; ?>/> Based on time.</label>
		</p>		


    	<div id="time_wrapper" <?php echo ($data['interval']=='time' ) ? '' : ' style="display:none"'; ?>>
    	Every&hellip;
	    	<select name="d">
			    <?php for($i=0; $i<=365; $i++): ?>
			         <option value="<?php echo $i?>" <?php echo ($data['d'] == $i) ? ' selected' : ''; ?>><?php echo $i?></option>
			    <?php endfor; ?>
			</select>
			<span style="padding-right:6px">Day(s)</span>

			<select name="h">
			    <?php for($i=0; $i<=23; $i++): ?>
			         <option value="<?php echo $i?>" <?php echo ($data['h'] == $i) ? ' selected' : ''; ?>><?php echo $i?></option>
			    <?php endfor; ?>
			</select>
			<span style="padding-right:6px">Hour(s)</span>

			<select name="m">
			    <?php for($i=0; $i<=59; $i++): ?>
			         <option value="<?php echo $i?>" <?php echo ($data['m'] == $i) ? ' selected' : ''; ?>><?php echo $i?></option>
			    <?php endfor; ?>
			</select>
			<span>Minute(s)</span>
		</div>

		<br><br>
		<hr>

    	<p>
			<label><input type="checkbox" value="1" name="show_title" <?php echo $data['show_title'] ? ' checked="checked"' : ''; ?>/> Show title?</label>
		</p>
    
		<p>
			<label><input type="checkbox" value="1" name="refuse" onclick="document.getElementById('refuse_wrapper').style.display = this.checked ? 'block' : 'none';" <?php echo $data['refuse'] ? ' checked="checked"' : ''; ?>/> Allow user to refuse?</label>
		</p>
		

		
		<p>
			<label>Text for Agree Button:</label><br />
			<input type="text" size="20" name="agree" value="<?php echo esc_attr($data['agree']); ?>" />
			<input type="text" size="80" name="agreeDesc" value="<?php echo esc_attr($data['agreeDesc']); ?>" />
		</p>

		<p id="refuse_wrapper" style="display: <?php echo $data['refuse'] ? 'block' : 'none'; ?>">
			<label>Text for Disagree Button:</label><br />
			<input type="text" size="20" name="disagree" value="<?php echo esc_attr($data['disagree']); ?>" />
			<input type="text" size="80" name="disagreeDesc" value="<?php echo esc_attr($data['disagreeDesc']); ?>" />
			<br />
			<br />
			<label>Redirect to the following URL if user refuses:</label><br />
			<input type="text" size="104" name="refuse_url" value="<?php echo esc_attr($data['refuse_url']); ?>" />
		</p>					
		
		<hr>
    
		<p>
			<label><input type="checkbox" value="1" name="readFullDisclaimer" onclick="document.getElementById('read_full_disclaimer_wrapper').style.display = this.checked ? 'block' : 'none';" <?php echo $data['readFullDisclaimer'] ? ' checked="checked"' : ''; ?>/> Require user to read full disclaimer?</label>
		</p>
		

		<p id="read_full_disclaimer_wrapper" style="display: <?php echo $data['readFullDisclaimer'] ? 'block' : 'none'; ?>">
			<label>Text for "Read Full Disclaimer" alert:</label><br />
			<input type="text" size="104" name="readFullDisclaimerAlert" value="<?php echo esc_attr($data['readFullDisclaimerAlert']); ?>" />
		</p>


		<p>
			<input type="submit" class="button-primary" value="Save Disclaimer &raquo;" /> 
			<?php wp_nonce_field('disclaimer_nonce', 'disclaimer_nonce'); ?>
		</p>
	</form>	
</div>

		<?php
}

	function header ($header) {

		// load data
		$data = get_option('ns-disclaimer', array('enabled' => 0));

		global $post;
		$current_slug=$post->post_name;

		// Don't want to show the Disclaimer if we're on the "access denied" page. 
		if ( (str_replace("/", "", $data['refuse_url'])) == $current_slug )
			return;
		
		// check if disclaimer is active
		if ($data['enabled'] == 0) {
			return;
		}
    		
		// check if user has already agreed
		if (isset($_COOKIE['ns-disclaimer']) && $_COOKIE['ns-disclaimer'] == 1) {
			return;
		}

	    // Load a page!
		$page = get_page($data['page_id']);
		$data['disclaimer'] = $page->post_content;
			if ($data['title'] == '') {
			$data['title'] = $page->post_title;
		}
	    
	    // remove title
	    if (!$data['show_title']) {
	      $data['title'] = '';
	    }
		
		// add disclaimer code
		echo '<script type="text/javascript">'."\r\n";
		// Make mobile browsers responsive, but only for disclaimer
		echo 'jQuery("head").prepend("<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\" />");'."\r\n";
		// Remove all content on mobile to avoid FOUC
		echo 'jQuery("html").addClass("disclaimer-on");'."\r\n"; 
		echo 'var nsDisclaimer = {'."\r\n";
		echo '  text:"'.$this->esc(apply_filters('the_content', $data['disclaimer'])).'",'."\r\n";
		echo '  title:"'.$this->esc($data['title']).'",'."\r\n";
		echo '  redir:'.((int)$data['refuse']).','."\r\n";
		echo '  url:"'.$this->esc($data['refuse_url']).'",'."\r\n";
		echo '  agree:"'.$this->esc($data['agree']).'",'."\r\n";
		echo '  agreeDesc:"'.$this->esc($data['agreeDesc']).'",'."\r\n";
		echo '  disagree:"'.$this->esc($data['disagree']).'",'."\r\n";		
		echo '  disagreeDesc:"'.$this->esc($data['disagreeDesc']).'",'."\r\n";
		echo '  readFullDisclaimer:'.((int)$data['readFullDisclaimer']).','."\r\n";
		echo '  readFullDisclaimerAlert:"'.$this->esc($data['readFullDisclaimerAlert']).'",'."\r\n";
		echo '  interval:"'.$this->esc($data['interval']).'",'."\r\n";
		echo '  d:"'.$this->esc($data['d']).'",'."\r\n";
		echo '  h:"'.$this->esc($data['h']).'",'."\r\n";
		echo '  m:"'.$this->esc($data['m']).'",'."\r\n";
		echo '  cookie:"'.esc_js($this->cookie).'"};'."\r\n";
		echo '</script>';
	}

	function esc ($str) {
		return str_replace(array('"', "'", "\r\n", "\n", "\r"), array('\\"', '\\\'', '\\n', '\\n', '\\n'), $str);
	}

}

// instantiate the object
$nsDisclaimer = new nsDisclaimer();

// add required files and hooks
if (is_admin()) {
	add_action('admin_menu', array($nsDisclaimer, 'setupMenu'));
  	add_action('admin_head', array($nsDisclaimer, 'setupAdminCss'));
}
else {
	add_action( 'wp_enqueue_scripts', function() {
		wp_enqueue_style('ns-disclaimer', verify_uri(plugins_url('ns-disclaimer.css', __FILE__)) );
		wp_enqueue_script('ns-disclaimer', verify_uri(plugins_url('ns-disclaimer.js', __FILE__)), array('jquery'));
	});
	add_action('wp_head', array($nsDisclaimer, 'header'));
}

/* Determine if this plugin is installed in the usual (proper) 
WordPress /wp-content/plugins directory, or if it's been 
embedded into the theme directory */

function verify_uri ($uri) {

	if ( strpos($uri, get_stylesheet_directory()) !== false ) {
		/* We're NOT in the standard WordPress directory, 
		so let's fix the path */
		$uri = str_replace('/wp-content/plugins'.ABSPATH, '/', $uri);
	}

	/* else: Do Nothing, the path should be correct */

	return $uri;
}