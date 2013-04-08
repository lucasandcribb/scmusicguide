<?php
/*
Plugin Name: Star Rating for Reviews
Plugin URI: http://www.channel-ai.com/blog/plugins/star-rating/
Description: Insert inline rating stars within your posts based on the score you assign, supports outputting list of reviews sorted by date, score or post title.
Version: 0.5
Author: Yaosan Yeo
Author URI: http://www.channel-ai.com/blog/
*/

/*  Copyright 2008  Yaosan Yeo  (email : eyn@channel-ai.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// configurable variables (global variables)

	$sr_limitstar = 0;				// globally limit max number of stars, put 0 if choose not to use
	$sr_defaultstar = 5;			// default max score when not explicitly expressed, e.g. [rating:3.5] is evaluated as 3.5/$sr_defaultstar
	$sr_prefix = "<strong>Rating:</strong> ";					// prefix text before inserting star graphics, can leave blank if desired
	$sr_allprefix = "<strong>Overall Rating:</strong> ";		// prefix used for overall rating
	$sr_suffix = "";				// to close tags or whatever you feel like doing
	$sr_ext = "png";				// file extension for star images
	$sr_usetext = 1;				// output plain text instead of star images in posts and feeds, options as below:
									// 0: images for posts and feeds;	1: images for posts, text for feeds;	2: text for all

	$sr_autometa = 0;				// option to insert meta key (custom field) automatically, put 1 to enable this feature
	$sr_metakey = 'rating';			// meta key for custom field, change this if there's conflict with other plugins
	
	$sr_mycss = 0;					// are you using MyCSS to set up custom style for this plugin? if yes, turn off the default CSS that comes with this plugin, which will disable all the default styling.
	$sr_cuttitle = 20;				// max amount of characters shown in post title when using sidebar functions, 0 to disable cut off

// end of configurable variables



// global variables for calculating cumulative average (do not touch)
	$sr_tscore = 0;
	$sr_counter = 0;




//////////////////////// DATABASE RELATED FUNCTIONS ////////////////////////


/////////// Functions that retrieves data ///////////


//
// sidebar functions
//

function sr_getreviews($limit=5, $orderby='date', $order='DESC', $usestar=5, $prefix='<li class="sr-item">', $suffix='</li>') {
	global $wpdb, $sr_metakey;

	if ( stristr($orderby, 'date') )
		$orderby = 'post_date';
	elseif ( stristr($orderby, 'title') )
		$orderby = 'post_title';
	else
		$orderby = 'meta_value+0';	// force sort by integer

	$order = ( stristr($order, 'DESC') ) ? 'DESC' : 'ASC';
	$limit = intval($limit);

	$sql = "SELECT id, post_title, meta_value";
	$sql .= " FROM  $wpdb->postmeta, $wpdb->posts";
	$sql .= " WHERE meta_key = '$sr_metakey'";
	$sql .= " AND post_id = id";
	$sql .= " AND post_status = 'publish'";
	$sql .= " ORDER BY $orderby $order";
	if ($limit)
		$sql .= " LIMIT $limit";

	$reviews = $wpdb->get_results($sql);
	
	// if no reviews can be found, output warning and exit
	if (empty($reviews)) {
		sr_warning();
	} else {
		foreach($reviews as $review) {
			$rating = $review->meta_value;
			$post_title = htmlspecialchars(stripslashes($review->post_title));
			$permalink = get_permalink($review->id);

			// output image tags for stars instead of percentage if requested
			if ($usestar) {
				$rating_output = sr_usestar($rating, $usestar);
			// output percentage
			} else {
				$rating_output = $rating . '%';
			}
			
			$output = sr_output($permalink, $post_title, $rating, $rating_output, $prefix, $suffix);

			echo $output;
		}
	}
}

// if ( $reviews = sr_getcat(single_cat_title("", false)) ) echo $reviews;
function sr_getcat($cat="", $limit=5, $orderby='date', $order='DESC', $usestar=5, $prefix='<li class="sr-item">', $suffix='</li>') {
	global $wpdb, $sr_metakey;

	if (!empty($cat))
		$cat = strtolower($cat);
	else {
		echo "<code>sr_getcat()</code> error: Category not defined!";
		return;
	}
	
	if ( stristr($orderby, 'date') )
		$orderby = 'post_date';
	elseif ( stristr($orderby, 'title') )
		$orderby = 'post_title';
	else
		$orderby = 'meta_value+0';	// force sort by integer

	$order = ( stristr($order, 'DESC') ) ? 'DESC' : 'ASC';
	$limit = intval($limit);

	$sql = "SELECT p.id, p.post_title, pm.meta_value";
	$sql .= " FROM  $wpdb->posts AS p";
	$sql .= " INNER JOIN $wpdb->postmeta AS pm ON (pm.meta_key = '$sr_metakey')";
	$sql .= " INNER JOIN $wpdb->term_relationships AS tr ON (p.id = tr.object_id)";
	$sql .= " INNER JOIN $wpdb->term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)";
	$sql .= " INNER JOIN $wpdb->terms AS t ON (tt.term_id = t.term_id)";
	$sql .= " WHERE t.slug = '$cat'";
	$sql .= " AND tt.taxonomy = 'category'";
	$sql .= " AND pm.post_id = p.id";
	$sql .= " AND p.post_status = 'publish'";
	$sql .= " ORDER BY $orderby $order";
	if ($limit)
		$sql .= " LIMIT $limit";

	$reviews = $wpdb->get_results($sql);
	
	// if no reviews can be found, output warning and exit
	if (empty($reviews)) {
		return "";
	} else {
		foreach($reviews as $review) {
			$rating = $review->meta_value;
			$post_title = htmlspecialchars(stripslashes($review->post_title));
			$permalink = get_permalink($review->id);

			// output image tags for stars instead of percentage if requested
			if ($usestar) {
				$rating_output = sr_usestar($rating, $usestar);
			// output percentage
			} else {
				$rating_output = $rating . '%';
			}
			
			$output = sr_output($permalink, $post_title, $rating, $rating_output, $prefix, $suffix);

			echo $output;
		}
	}
}

function sr_getrandom($limit=5, $usestar=5, $prefix='<li class="sr-item">', $suffix='</li>') {
	global $wpdb, $sr_metakey;
	
	$sql = "SELECT id, post_title, meta_value";
	$sql .= " FROM  $wpdb->postmeta, $wpdb->posts";
	$sql .= " WHERE meta_key = '$sr_metakey'";
	$sql .= " AND post_id = id";
	$sql .= " AND post_status = 'publish'";

	$reviews = $wpdb->get_results($sql);
	
	// if no reviews can be found, output warning and exit
	if (empty($reviews)) {
		sr_warning();
	} else {
		// randomize the returned 2D array
		$shuffles = array_rand($reviews, intval($limit));
		$review = array();

		foreach($shuffles as $shuffle) {
			$review = $reviews[$shuffle];

			$rating = $review->meta_value;
			$post_title = htmlspecialchars(stripslashes($review->post_title));
			$permalink = get_permalink($review->id);

			// output image tags for stars instead of percentage if requested
			if ($usestar) {
				$rating_output = sr_usestar($rating, $usestar);
			// output percentage
			} else {
				$rating_output = $rating . '%';
			}
			
			$output = sr_output($permalink, $post_title, $rating, $rating_output, $prefix, $suffix);

			echo $output;
		}
	}
}

function sr_listreviews($orderby='date', $order='DESC', $usestar=5, $date="M j, Y", $limit=0) {
	global $wpdb, $sr_metakey;

	if ( stristr($orderby, 'date') )
		$orderby = 'post_date';
	elseif ( stristr($orderby, 'title') )
		$orderby = 'post_title';
	else
		$orderby = 'meta_value+0';	// force sort by integer

	$order = ( stristr($order, 'DESC') ) ? 'DESC' : 'ASC';
	$limit = intval($limit);

	$sql = "SELECT id, post_title, post_date, meta_value";
	$sql .= " FROM  $wpdb->postmeta, $wpdb->posts";
	$sql .= " WHERE meta_key = '$sr_metakey'";
	$sql .= " AND post_id = id";
	$sql .= " AND post_status = 'publish'";
	$sql .= " ORDER BY $orderby $order";
	if ($limit)
		$sql .= " LIMIT $limit";

	$reviews = $wpdb->get_results($sql);
	
	// if no reviews can be found, output warning and exit
	if (empty($reviews)) {
		sr_warning();
	} else {
		$path = get_settings('siteurl') . '/wp-content/plugins/star-rating-for-reviews/jquery.tablesorter.js';
		print <<< THEAD
	<script type="text/javascript" src="$path"></script>
	<table id="sr-table">
	<thead>
	<tr>
		<th class="date">Date</th>
		<th>Title</th>
		<th>Rating</th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<td colspan="3">
			<span class="sr-tips">Tips: Shift+Click to sort multiple columns</span><span class="sr-plugin">Powered by <a href="http://www.channel-ai.com/blog/plugins/star-rating/" title="Star Rating for Reviews WordPress Plugin">Star Rating for Reviews</a></span>
		</td>
	</tr>
	</tfoot>
	<tbody>
THEAD;
		
		$counter = 0;
		
		foreach($reviews as $review) {
			$rating = $review->meta_value;
			$post_title = htmlspecialchars(stripslashes($review->post_title));
			$post_date = date( $date, strtotime($review->post_date) );
			$permalink = get_permalink($review->id);
			
			if ($counter % 2)
				$row = "odd";
			else
				$row = "even";
				
			$counter++;

			// output image tags for stars instead of percentage if requested
			if ($usestar) {
				$rating_output = sr_usestar($rating, $usestar);
			// output percentage
			} else {
				$rating_output = $rating . '%';
			}
			
			// hidden date in ISO format, used for sorting
			$post_date = '<span class="hidden">' . date( "Y-m-d", strtotime($review->post_date) ) . '</span> ' . $post_date;
			
			// hidden rating, used for sorting
			if ($usestar)
				$rating_output = '<span class="hidden">' . $rating . '</span> ' . $rating_output;
			
			print <<< TROW
	<tr class="$row">
		<td class="date">$post_date</td>
		<td><a href="$permalink" title="$post_title - $rating%">$post_title</a></td>
		<td>$rating_output</td>
	</tr>
TROW;
		}
		print <<< TFOOT
	</tbody>
	</table>
	
	<script type="text/javascript">
	jQuery(document).ready(function() 
	    { 
	        jQuery("#sr-table").tablesorter({widgets: ["zebra"]});
	    } 
	);
    </script>
TFOOT;
	}
}



//
// single post functions
//

function sr_getsingle($post_id, $usestar=0, $prefix='', $suffix='', $size=0) {
	$rating = sr_getrating($post_id);

	// jump out of function if no rating data can be found for this single post
	if (empty($rating))
		return 0;

	// output image tags for stars instead of percentage if requested
	if ($usestar) {
		$rating_output = sr_usestar($rating, $usestar, $size);
	// output percentage
	} else {
		$rating_output = $rating;
	}

	$output = $prefix . $rating_output . $suffix . "\n";

	echo $output;
}

function sr_getrating($post_id) {
	global $wpdb, $sr_metakey;

	$sql = "SELECT meta_value";
	$sql .= " FROM  $wpdb->postmeta";
	$sql .= " WHERE meta_key = '$sr_metakey'";
	$sql .= " AND post_id = '$post_id'";
	
	$rating = $wpdb->get_var($sql);
	
	return $rating;
}

//
// common functions
//

// generates the xhtml code for star rating images, e.g. <img src="" />

function sr_usestar($rating, $star_count, $big=0) {
	global $sr_ext;

	$star = $rating / 100 * $star_count;

	if ($big)
		$path = get_settings('siteurl') . '/wp-content/plugins/star-rating-for-reviews/images/';
	else
		$path = get_settings('siteurl') . '/wp-content/plugins/star-rating-for-reviews/images/tiny-';

	// check if half star occurs
	// e.g. [3.75 , 4.25) = 4 stars; [4.25 , 4.75) = 4.5 stars
	$star = round( $star * 2 );

	if ( $star % 2 ) {	// there is half star
		$halfstar = '<img src="' . $path . 'halfstar.' . $sr_ext . '" alt="&frac12;" />';
		$star = floor( $star / 2 );
		$blankstar = $star_count - $star - 1;
	} else 	{	// there is no half star
		$halfstar = "";
		$star = $star / 2;
		$blankstar = $star_count - $star;
	}

	// finally, generate html for rating stars
	$output = str_repeat ('<img src="' . $path . 'star.' . $sr_ext . '" alt="&#9733;" />', $star) . $halfstar . str_repeat('<img src="' . $path . 'blankstar.' . $sr_ext . '" alt="&#9734;" />', $blankstar);

	return $output;
}


// generates the final output

function sr_output($permalink, $post_title, $rating, $rating_output, $prefix, $suffix) {
	global $sr_cuttitle;
	
	$title = html_entity_decode($post_title);
	
	if ( $sr_cuttitle && (strlen($title) > $sr_cuttitle) ) {
		$short_title = substr($title, 0, $sr_cuttitle) . "...";
	} else {
		$short_title = $post_title;
	}
	
	$output = $prefix . '<span class="sr-review"><a href="' . $permalink . '" title="' . $post_title . " - " . $rating . '%">' . $short_title . '</a></span>';
	$output .= '<span class="sr-rating">' . $rating_output . '</span>&nbsp;';		// &nbsp; required or floating element takes up no space -> messed up layout
	$output .= $suffix . "\n";
	
	return $output;
}


// outputs warning when no rating data can be found

function sr_warning() {
	echo "<small>No entry found! Please make sure database writing has been enabled via plugin options and have at least one blog entry having its custom field properly set. See <a href='http://www.channel-ai.com/blog/plugins/star-rating/' title='Star Rating for Reviews Documentation'>documentation</a> for further info.</small>\n";
}


// include default plugin CSS in header

function sr_head() {
	global $sr_mycss;
	
	if ($sr_mycss)
		return 0;
	
	$path = get_settings('siteurl') . '/wp-content/plugins/star-rating-for-reviews/star-rating.css';
	print <<< CSS
	<link rel="stylesheet" type="text/css" href="$path" />
CSS;
}

// includes jQuery 1.2.1

function sr_js() {
	if ( function_exists('wp_enqueue_script') ) {
		wp_enqueue_script('jquery', get_settings('siteurl') . '/wp-content/plugins/star-rating-for-reviews/jquery.js');
	}
}


/////////// Functions that stores data ///////////


//
// post editing / meta values functions
//

function sr_addratings($post_id) {
	global $wpdb, $sr_tscore, $sr_counter, $sr_autometa, $sr_metakey;

	// jump out of function if auto meta is not enabled
	if (!$sr_autometa) {
		return $post_id;
	}

	$content = $wpdb->get_var("SELECT post_content
							FROM $wpdb->posts
							WHERE ID = '$post_id'");

	// parse post content for rating tags, and store rating information in global variables
	$content = preg_replace_callback( "/(?<!`)\[rating:(([^]]+))]/i", "sr_genratings", $content );

	// calculate overall ratings
	if ($sr_tscore > 0) {
		$rating = round( $sr_tscore / $sr_counter * 100 , 1 );	// in percentage
	}
	else {
		return $post_id;	// jump out of function if [rating:none] is found or no [rating:] tags at all
	}

	// read rating custom field from database
	$rating_meta = $wpdb->get_var("SELECT meta_value
							FROM $wpdb->postmeta
							WHERE post_id = '$post_id'
							AND meta_key = '$sr_metakey'");

	// if already exist, update the value with new ratings
	if (!empty($rating_meta)) {
		$results=  $wpdb->query("UPDATE $wpdb->postmeta
								SET meta_value = '$rating'
								WHERE post_id = '$post_id'
								AND meta_key = '$sr_metakey'");
	// if not exist, write rating custom field to database
	} else {
		$results = $wpdb->query("INSERT INTO $wpdb->postmeta (post_id,meta_key,meta_value)
								VALUES ('$post_id', '$sr_metakey', '$rating')");
	}

	return $post_id;
}

function sr_genratings($matches) {
	global $sr_defaultstar, $sr_tscore, $sr_counter;

	list($score, $maxscore) = explode("/", $matches[2]);

	if (!$maxscore) {
		$maxscore = $sr_defaultstar;
	}

	// if not overall rating, add to cumulative
	if ( !(strncasecmp(trim($score), "overall", 7) == 0) ) {
		$percent = $score / $maxscore;
		$sr_counter++;
		$sr_tscore += $percent;
	}

	// disable autometa if [rating:none] is found
	if ( strncasecmp(trim($score), "none", 4) == 0) {
		$sr_tscore = -99999;
	}

	return 0;
}

add_action('save_post', 'sr_addratings');
add_action('wp_head', 'sr_head');
add_action('wp_print_scripts', 'sr_js');



//////////////////////// CORE (PRESENTATION ONLY) FUNCTIONS ////////////////////////


function sr_addstar($content) {
	$content = preg_replace_callback( "/(?<!`)\[rating:(([^]]+))]/i","sr_genstar", $content );
	$content = preg_replace( "/`(\[rating:(?:[^]]+)])`?/i", "$1", $content );	//escape rating tags by using `[rating:]`

	return $content;
}

function sr_genstar($matches) {
	global $post, $sr_limitstar, $sr_defaultstar, $sr_prefix, $sr_allprefix, $sr_suffix, $sr_usetext, $sr_tscore, $sr_counter;

	list($score, $maxscore) = explode("/", $matches[2]);

	// check if we should get overall rating
	if ( strncasecmp(trim($score), "overall", 7) == 0 ) {
		// test if overall tag is found before any rating score is given (some people might want to display overall score before the <!--more-->)
		// uses rating data stored in database if found
		if ($sr_counter == 0) {
			$rating = (sr_getrating($post->ID)) ? sr_getrating($post->ID) : 0;
		} 
		// if previous rating score is found within the same post, calculate overall score
		else {
			$rating = $sr_tscore / $sr_counter;
		}

		if ($maxscore)
			$maxstar = $maxscore;
		else
			$maxstar = $sr_defaultstar;

		// clear cummulative variables for cases where multiple overall rating is required within single post
		$sr_tscore = 0;
		$sr_counter = 0;
		$prefix = $sr_allprefix;
	}

	// ignore the escaping rating tag that prevents autometa
	elseif ( strncasecmp(trim($score), "none", 4) == 0 ) {
		return "";
	}

	// if not overall, calculate rating based on score assigned
	else {
		if ($maxscore) {
			// limit max number of stars to 20
			$maxstar = ($maxscore <= 20) ? $maxscore : $sr_defaultstar;
		}
		else {
			$maxscore = $sr_defaultstar;
			$maxstar = $sr_defaultstar;
		}

		// check if we should limit the global max number of stars
		if ($sr_limitstar) {
			$maxstar = $sr_limitstar;
		}

		$rating = $score / $maxscore * 100;
		$sr_counter++;
		$sr_tscore += $rating;
		$prefix = $sr_prefix;
	}

	// graphical output i.e. with star images
	$output = $prefix . sr_usestar($rating, $maxstar, 1) . $sr_suffix;
	
	// text only output
	$stars = $rating / 100 * $maxstar;
	$output_text = $prefix . round($stars, 2) . " out of " . round($maxstar) . " stars" . $sr_suffix; 

	// select output based on options
	if ( $sr_usetext == 1 && is_feed() )
		return $output_text;
	elseif ( $sr_usetext == 2 )
		return $output_text;
	else
		return $output;
}

add_filter('the_content', 'sr_addstar');
add_filter('the_excerpt', 'sr_addstar');
?>
