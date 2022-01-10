<?php
/**
 * Library of functions useful for WordPress builds,
 * collected around the internet and/or heavily edited
 * for NS use.
 *
 * If you find yourself writing a function that would be
 * useful for a future build, add it here, but make sure it's
 * reusable and generic enough!
 *
 * ...and make sure you document it well!
 *
 * @package    NS-Base-Theme
 *
 *
 * Code to review: Line 1214
 */

/* ===================================
	Useful default functions
   =================================== */

/* Based off the above ns_the_categories, and this:
https://codex.wordpress.org/Function_Reference/get_the_terms

Note: If $link is set to 'false', then $sep should be an html tag minus the brackets,
e.g., span, div or li, etc. Otherwise $sep should be a non-html tag such as , - etc. */
function ns_get_the_terms($ID=null, $term='category', $before=null, $sep=', ', $after=null, $link=true){

	$output = '';

	if (empty($ID))
		$ID = get_the_ID();

	$termsArr = get_the_terms( $ID, $term );

	if ($termsArr != '') {
		foreach ($termsArr as $termsObj) {

			if ($link) {
				$output[] = '<a href="'.get_term_link($termsObj).'" title="' . esc_attr( sprintf( "View all posts in %s", $termsObj->name ) ).'" class="category-'.$termsObj->slug.'">'.$termsObj->name.'</a>';
			} else {
				$output[] = '<'.$sep.' class="category-'.$termsObj->slug.'">'.$termsObj->name.'</'.$sep.'>';
			}
		}

		if (!empty($output)) {
			if (!$link)
				$sep = '';
			$output = $before.implode($sep, $output).$after;
		}
	}

	return $output;
}


/* http://www.phpro.org/examples/Convert-Numbers-To-Roman-Numerals.html */
/**
 *
 * @create a roman numeral from a number
 *
 * @param int $num
 *
 * @return string
 *
 */
function romanNumerals($num) {
    $n = intval($num);
    $res = '';

    /*** roman_numerals array  ***/
    $roman_numerals = array(
                'M'  => 1000,
                'CM' => 900,
                'D'  => 500,
                'CD' => 400,
                'C'  => 100,
                'XC' => 90,
                'L'  => 50,
                'XL' => 40,
                'X'  => 10,
                'IX' => 9,
                'V'  => 5,
                'IV' => 4,
                'I'  => 1);

    foreach ($roman_numerals as $roman => $number)
    {
        /*** divide to get  matches ***/
        $matches = intval($n / $number);

        /*** assign the roman char * $matches ***/
        $res .= str_repeat($roman, $matches);

        /*** substract from the number ***/
        $n = $n % $number;
    }

    /*** return the res ***/
    return $res;
}


/* Simple debug function that prints out
the given array in a human readable form */
function print_arr($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}


/*

Simple function for outputting an Industry-Standard copyright,
in the following format:

© 2010 - 2015 Company Name

$founded - Required. Simply enter the year the site was founded (ie, today's year) in 4 digits.

$use_blog_name - Optional. Defaults to true, accepts a string.
TRUE: It will output whatever the result of bloginfo('name') is set to.
FALSE: Outputs nothing.
If set to a string, outputs that string.

$all_rights_reserved - Options. Defaults to true.
TRUE: Outputs ". All rights reserved."
FALSE: Outputs nothing.
 */

function ns_get_copyright($year_founded, $company_name, $additional_text, $year_format) {
	if ($year_format == 'roman'){
		$year = romanNumerals(date("Y"));
		if ($year_founded != ''){
			$year_founded = romanNumerals($year_founded);
		}
	} else {
		$year = date("Y");
	}

	if ($year_founded != $year && $year_founded != ''){
		$year = $year_founded.' &ndash; '.$year;
	} else {
		$year = $year;
	}

	if ($company_name != '')
		$company_name = $company_name;
	else $company_name = get_bloginfo('name');

	if ($additional_text)
		$additional_text = $additional_text;


	$copyright = '<p class="copyright">&copy; '.$year.' '.$company_name.$additional_text.'</p>';

	return $copyright;
}


/* Just making a bit easier to print out arrays to the error log */
function ns_error($foo) {
	error_log( print_r( $foo, true ));
}


/* Simply returns true if said post exists, given the $ID;
Works on all post types
https://tommcfarlin.com/wordpress-post-exists-by-id/ */
function ns_post_exists( $ID ) {
	return is_string( get_post_status( $ID ) );
}

/* Check if its the blog page */
function ns_is_blog() {
	return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

/* For Review
======================================= */

/* Super simple function to strip ONLY the protocol. */
function ns_strip_protocol($url) {
	$arr = parse_url($url);
	$host= $arr['host'];
	$url = $arr['path'];
	if (!empty($arr['query']))
		$url .= "?".$arr['query'];
	if (!empty($arr['fragment']))
		$url .= "#".$arr['fragment'];
	return $host.$url;
}

/* http://us2.php.net/parse_url
Super simple function to strip off the domain and protocol off URL, making it relative
*/
function ns_strip_domain($url) {
	$arr = parse_url($url);
	$url = $arr[path];
	if (!empty($arr[query]))
		$url .= "?".$arr[query];
	if (!empty($arr[fragment]))
		$url .= "#".$arr[fragment];
	return $url;
}

// http://stackoverflow.com/questions/2762061/how-to-add-http-if-its-not-exists-in-the-url
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}