<?php
/**
*
* This file serves as a place to put awesome filters and functions that are of a "Set it and forget it"
* nature. That is, functions that once placed in here, will not need to be actively called or reference
* or thought about again.
*
* So if it's a function that you'll basically never need to reference again, but always want it to be
* running, than plop it in here!
*
* Also includes Mobile_Detect
*
*/



/* ===================================
    Initial Theme Setup

    @v3.0 Move from ns-functions.php
   =================================== */

add_action( 'after_setup_theme', 'ns_defaults', 11 );

function ns_defaults() {

    // remove junk from head
    // remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    // remove_action('wp_head', 'feed_links', 2);
    // remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    // remove_action('wp_head', 'feed_links_extra', 3);
    // remove_action('wp_head', 'start_post_rel_link', 10, 0);
    // remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    // remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    // remove_action('wp_head', 'feed_links_extra', 3);
    // remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

    // Remove Admin Bar
    add_filter( 'show_admin_bar', '__return_false' );

    add_filter('use_default_gallery_style', '__return_null');
}


/* ===================================
    Dev Server Detection
   =================================== */

if ((strpos($_SERVER['HTTP_HOST'],'test') !== false) || (strpos($_SERVER['HTTP_HOST'],'dev') !== false)) {
    define("DEV",true);
}
else define("DEV",false);

if ((strpos($_SERVER['HTTP_HOST'],'thstreet.nyc') !== false)) {
    define("STAGE",true);
}
else define("STAGE",false);



/* ===================================
    Debug - Turns of error reporting on staging and production
    TODO - Makes local errors blank, needs to be fixed
   =================================== */

// if (!is_admin() && DEV) {
//     error_reporting(E_ERROR | E_WARNING | E_PARSE);
//     ini_set('display_errors', '1');
// }
// else error_reporting(0);

/* ===================================
    Bypass to switch views
   =================================== */

function get_browser_mobile_classes() {
    $detect = new Mobile_Detect;

    global $deviceType;
    $browser = '';

    /* Super simple browser detection, add to body class */
    if(isset($_SERVER['HTTP_USER_AGENT'])){
        $agent = $_SERVER['HTTP_USER_AGENT'];
    }

    $os = '';
    if( $detect->isiOS() )
        $os = 'ios ';
    else if( $detect->isAndroidOS() )
        $os = 'android ';

    if(strlen(strstr($agent,"Chrome")) > 0 ){
        $browser = 'chrome ';
    }
    else if(strlen(strstr($agent,"Safari")) > 0 ){
        $browser = 'safari ';
    }


    return $os.$browser.$deviceType;
}

// Creating a custom hook for right after the open body tag
function ns_body_begin() {
    do_action('ns_body_begin');
}

// FIX URL TO REMOVE HOST
function ns_get_backend_url_option() {
    $backend_settings = get_fields('option');
    return rtrim($backend_settings['live_domain_url'], '/');
}

function ns_get_http_host() {
    return $_SERVER['HTTP_HOST'];
}

// Add Google Analytics to Header

if(class_exists('acf')) {
    add_action('wp_head', function() {
        $backend_settings = get_fields('option');
        $ga = $backend_settings['google_analytics'];

        $url = ns_get_backend_url_option();
        $http_host = ns_get_http_host();

        if (($ga != '') && ($url != '') && ($http_host != '')) :
            if (strpos(ns_strip_protocol($http_host),ns_strip_protocol($url)) !== false) : ?>

            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga; ?>"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', '<?php echo $ga; ?>');
            </script>


            <?php else: ?>
            <!-- ============================================================================
            The current Google Analytics ID is set to: <?php echo $ga; ?>
            The Google Analytics script is not here becuase the site is not yet live.
            Once the site is live on <?php echo $url; ?> then the Google Analytics
            script will show up here and be active.
            ============================================================================ -->
            <?php endif;
        endif;
    },0);


    // Add Google Tag Manager to Header

    add_action('wp_head', function() {
        $backend_settings = get_fields('option');
        $gtm = $backend_settings['google_tag_manager'];

        $url = ns_get_backend_url_option();
        $http_host = ns_get_http_host();

        if (($gtm != '') && ($url != '') && ($http_host != '')) :
            if (strpos(ns_strip_protocol($http_host),ns_strip_protocol($url)) !== false) : ?>

            <!-- Google Tag Manager -->
    		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    		})(window,document,'script','dataLayer','<?php echo $gtm; ?>');</script>
    		<!-- End Google Tag Manager -->

            <?php else: ?>
            <!-- ============================================================================
            The current Google Tag Manager ID is set to: <?php echo $gtm; ?>
            The Google Tag Manager script is not here becuase the site is not yet live.
            Once the site is live on <?php echo $url; ?> then the Google Tag Manager
            script will show up here and be active.
            ============================================================================ -->
            <?php endif;

        endif;
    },0);

    // Add Google Tag Manager to Body
    add_action('ns_body_begin', function() {
        $backend_settings = get_fields('option');
        $gtm = $backend_settings['google_tag_manager'];

        $url = ns_get_backend_url_option();
        $http_host = ns_get_http_host();

        if (($gtm != '') && ($url != '') && ($http_host != '')) :
            if (strpos(ns_strip_protocol($http_host),ns_strip_protocol($url)) !== false) : ?>
                <!-- Google Tag Manager (noscript) -->
                <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $gtm; ?>"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                <!-- End Google Tag Manager (noscript) -->
            <?php endif;
        endif;
    },0);


    add_action('wp_head', function() {
        $backend_settings = get_fields('option');
        $lead_forensics = $backend_settings['lead_forensics'];

        if ($lead_forensics != '')  :
            echo $lead_forensics;
        endif;
    },10);
}


/* Allow filtering by PDF in media manager
http://wp.tutsplus.com/articles/tips-articles/quick-tip-add-extra-media-type-filters-to-the-wordpress-media-manager/ */

function modify_post_mime_types( $post_mime_types ) {

    // select the mime type, here: 'application/pdf'
    // then we define an array with the label values
    $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );

    // then we return the $post_mime_types variable
    return $post_mime_types;
}

// Add Filter Hook
add_filter( 'post_mime_types', 'modify_post_mime_types' );

/* Remove SVG Security Restriction
http://wordpress.org/support/topic/svg-upload-not-allowed */
add_filter('upload_mimes', 'custom_upload_mimes');

function custom_upload_mimes ( $existing_mimes=array() ) {

    // add the file extension to the array
    // $existing_mimes['svg'] = 'mime/type';
    $existing_mimes['vcf'] = 'text/x-vcard';

    // call the modified list of extensions
    return $existing_mimes;
}


/* http://wordpress.stackexchange.com/questions/188635/view-wordpress-page-template-usage-or-unused
Adds a count (1) next the template dropdown, to easily see which templates are being used already
and which are not. */
add_filter( 'theme_page_templates', function( $page_templates, $obj, $post )
{
    // Only use on local dev builds.
    if (!DEV)
        return $page_templates;

    // Restrict to the post.php loading
    if( ! did_action( 'load-post.php' ) )
        return $page_templates;

    foreach( (array) $page_templates as $key => $template )
    {
        $posts = get_posts(
            array(
                'post_type'      => 'any',
                'post_status'    => 'any',
                'posts_per_page' => 10,
                'fields'         => 'ids',
                'meta_query'     => array(
                    array(
                        'key'       => '_wp_page_template',
                        'value'     => $key,
                        'compare'   => '=',
                    )
                )
            )
        );

        $count = count( $posts );

        // Add the count to the template name in the dropdown. Use 10+ for >= 10
        $page_templates[$key] = sprintf(
            '%s (%s)',
            $template,
             $count >= 10 ? '10+' : $count
        );
    }
    return $page_templates;
}, 10, 3 );



/* http://wpsites.net/wordpress-tips/5-ways-to-redirect-attachment-pages-to-the-parent-post-url/ */
if (KILL_ATTACHMENT_PAGE)
    add_action( 'template_redirect', 'ns_attachment_redirect' );
    function ns_attachment_redirect() {
        global $post;

        if ( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent != 0) ) :
            // If attached, redirect to the post it's attached to
            wp_redirect( get_permalink( $post->post_parent ), 301 );
            exit();
            wp_reset_postdata();
        elseif ( is_attachment() & is_single() ) :
            // If not attached, redirect to the home
            wp_redirect( '/', 301 );
        endif;
    }



/* Fixes bug in 4.7.2 that breaks mime types. Was supposed to be fixed
in 4.7.3 ...but that doesn't seem to be th case, so this has been added
to ns-core for the moment. */
if (DISABLE_REAL_MIME_CHECK)
    add_filter( 'wp_check_filetype_and_ext', 'ns_disable_real_mime_check', 10, 4 );
    function ns_disable_real_mime_check( $data, $file, $filename, $mimes ) {
        $wp_filetype = wp_check_filetype( $filename, $mimes );

        $ext = $wp_filetype['ext'];
        $type = $wp_filetype['type'];
        $proper_filename = $data['proper_filename'];

        return compact( 'ext', 'type', 'proper_filename' );
    }


/*
WordPress append page slug to body class
http://stv.whtly.com/2011/02/19/wordpress-append-page-slug-to-body-class/
*/

function add_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {

    	/* If there's a template named template-article.php, then wordpress will add the class
    	as page-template-template-article-php. Let's change that to just template-article */
    	foreach ($classes as &$class) {
    		$class = str_replace('page-template-','',$class);
    		$class = str_replace('-php','',$class);
    	}
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter( 'body_class', 'add_body_class' );


/*
Add Featured Thumbnails to Admin Post Columns
http://wpsnipp.com/index.php/functions-php/add-featured-thumbnail-to-admin-post-columns
*/
add_filter('manage_posts_columns', 'ns_posts_columns', 5);
add_action('manage_posts_custom_column', 'ns_posts_custom_columns', 5, 2);
function ns_posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Thumbs');
    return $defaults;
}
function ns_posts_custom_columns($column_name, $id){
        if($column_name === 'riv_post_thumbs'){
        echo the_post_thumbnail( 'thumbnail' );
    }
}

// Edit dns prefetch for old Google Font call
add_filter( 'wp_resource_hints', function( $urls ) {
    foreach ($urls as $key => $url) {
				// Remove existing prefect for google fonts
				if( 'fonts.googleapis.com' === $url ) { unset( $urls[ $key ] ); }
    }
    return $urls;
} );

// Add new preconnect code for Google Fonts
function ns_gfont_preconnect ($urls, $relation_type) {
	if ( 'preconnect' === $relation_type) {
		$urls[] = 'https://fonts.gstatic.com';
	}
	return $urls;
}
add_filter ( 'wp_resource_hints', 'ns_gfont_preconnect', 10, 2);