<?php
/**
 * Plugin Name: FeedMeNow Widget
 * Plugin URI: http://creativedesignsolutionsnyc.com/feed-me-now/
 * Description: A widget for multiple RSS filtered news feeds.
 * Version: 1.0
 * Author: Steve Attwell
 * Author URI: http://creativedesignsolutionsnyc.com
 * License: GPLv2
 */

/*  Copyright 2012  Steve Attwell  (email : steveattwellemail@yahoo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/**
 * Add function to widgets_init that'll load our widget.
 * @since 1.1
 The first thing we have to do is load our widget when necessary. WordPress provides the
 widgets_init action hook that will allow us to do this. In WordPress 2.8, this action hook
 is fired right after the default WordPress widgets have been registered.
 */
add_action( 'widgets_init', 'feedmenow_load_widgets' );
/**
 * Register our widget.
 * 'Feedmenow_Widget' is the widget class used below.
 *
 * @since 1.1
 */
function feedmenow_load_widgets() {
 register_widget( 'Feedmenow_Widget' );

}
/**
 * feedmenow Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 In the past, creating widgets in WordPress was some ugly mish-mash of functions
 that was incomprehensible. In 2.8, we simply have to extend the preexisting WP_Widget class.
 So, the first step is creating a new class with a unique name.
 */
class Feedmenow_Widget extends WP_Widget {
 /**
  * Widget setup.
  Then, we’ll want to add our first function. This function will be what makes our widget
  unique to WordPress, and it’ll allow us to set up the widget settings.
  */
 function Feedmenow_Widget() {
  /* Widget settings. */
  $widget_ops = array( 'classname' => 'feedmenow', 'description' => __('The feedmenow widget displays filtered RSS feeds', 'feedmenow') );
  /* Widget control settings. */
  $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'feedmenow-widget' );
  /* Create the widget. */
  $this->WP_Widget( 'feedmenow-widget', __('Feedmenow Widget', 'feedmenow'), $widget_ops, $control_ops );
 }
 /**
  * How to display the widget on the screen.
  */
 function widget( $args, $instance ) {
  extract( $args );
  /* Our variables from the widget settings. */
  $title = apply_filters('widget_title', $instance['title'] );
  $show_feed_image = isset( $instance['show_feed_image'] ) ? $instance['show_feed_image'] : false;
  $keywords  = $instance['keywords'];
  $rssfeeds  = $instance['rssfeeds'];
  $delimiter = $instance['delimiter'];
  $content   = $instance['content'];
  $numposts  =  $instance['numposts'];
  $nonews    =  $instance['nonews'];

  $search_title = isset( $instance['search_title'] ) ? $instance['search_title'] : false;
  $search_desc  = isset( $instance['search_desc'] ) ? $instance['search_desc'] : false;

  $feedArray =  @explode($delimiter,$rssfeeds);
  $a = new FeedMeNow();
  
  /* Before widget (defined by themes). */
  echo $before_widget;
  /* Display the widget title if one was input (before and after defined by themes). */
  if ( $title )
   echo $before_title . $title  . $after_title;

$a->rss_output($delimiter,$rssfeeds,1000000,$keywords,$show_feed_image,$title, $search_title, $search_desc,$numposts,$nonews);

  /* After widget (defined by themes). */
  echo $after_widget;
 }
 /**
  * Update the widget settings.
  */
 function update( $new_instance, $old_instance ) {
  $instance = $old_instance;
  /* Strip tags for title and name to remove HTML (important for text inputs). */
  $instance['title'] =  $new_instance['title'] ;
  /* No need to strip tags for show_feed_image. */
  $instance['show_feed_image'] = $new_instance['show_feed_image'];
  $instance['search_title'] = $new_instance['search_title'];
  $instance['search_desc'] = $new_instance['search_desc'];
  $instance['keywords'] = strip_tags( $new_instance['keywords']);
  $instance['rssfeeds'] = strip_tags( $new_instance['rssfeeds']);
  $instance['delimiter'] = strip_tags( $new_instance['delimiter']);
  $instance['numposts'] = strip_tags($new_instance['numposts']);
  $instance['nonews'] = $new_instance['nonews'];
  return $instance;
 }
 /**
  * Displays the widget settings controls on the widget panel.
  * Make use of the get_field_id() and get_field_name() function
  * when creating your form elements. This handles the confusing stuff.
  */
 function form( $instance ) {
  $showheader = "";
  if ( $instance['show_feed_image'] == "on")
   {
    $showheader = "checked";
   }

   $searchtitle = "";
  if ( $instance['search_title'] == "on")
   {
    $searchtitle = "checked";
   }

    $searchdesc = "";
  if ( $instance['search_desc'] == "on")
   {
    $searchdesc = "checked";
   }


  /* Set up some default widget settings. */
  $defaults = array( 'title' => __('feedmenow', 'feedmenow'), 'show_feed_image' => true, 'search_title' => true, 'search_desc' => true, 'delimiter' => '~', 
'numposts' => '10' , 
'keywords' => 'Bristol City,Robins,Ashton Gate,Steve Lansdown',
'rssfeeds'=> 'http://www.skysports.com/rss/0,20514,11688,00.xml~http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/rss.xml',
'nonews'=> 'No news articles found' );

  $instance  = wp_parse_args( (array) $instance, $defaults ); 


?>
  <!-- Widget Title: Text Input -->
  <p>
   <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
   <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
  </p>

  <!-- Show show feed Image Checkbox -->
  <p>
   <input class="checkbox" type="checkbox" <?php echo $showheader; ?> id="<?php echo $this->get_field_id( 'show_feed_image' ); ?>" name="<?php echo $this->get_field_name( 'show_feed_image' ); ?>" />
   <label for="<?php echo $this->get_field_id( 'show_feed_image' ); ?>"><?php _e('Display Feed Header Image? <i>(for the first feed only)</i>', 'feedmenow'); ?></label>
  </p>

 <!-- No News Message: Text Input -->
  <p>
   <label for="<?php echo $this->get_field_id( 'nonews' ); ?>"><?php _e('No news Message:', 'hybrid'); ?></label>
   <input id="<?php echo $this->get_field_id( 'nonews' ); ?>" name="<?php echo $this->get_field_name( 'nonews' ); ?>" value="<?php echo $instance['nonews']; ?>" style="width:100%;" />

  </p>

  <!-- Key Words: Text Area Input -->
  <p>
  <label for="<?php echo $this->get_field_id( 'keywords' ); ?>"><?php _e('Key Words:', 'feedmenow'); ?></label>
   <textarea name="<?php echo $this->get_field_name( 'keywords' ); ?>" style="width: 80%; height: 100px;" id="<?php echo $this->get_field_id( 'keywords' ); ?>"><?php echo $instance['keywords']; ?></textarea> 


  </p>
  <!-- RSS Feeds: Text Area Input -->
  <p>
 
<label for="<?php echo $this->get_field_id( 'rssfeeds' ); ?>"><?php _e('RSS XML Feeds:', 'feedmenow'); ?></label>

   <textarea id="<?php echo $this->get_field_id( 'rssfeeds' ); ?>"  name="<?php echo $this->get_field_name( 'rssfeeds' ); ?>" style="width: 80%; height: 100px;"  ><?php echo $instance['rssfeeds']; ?>
</textarea>

   </p>
  <!-- Feed Delimiter: Text Input -->
  <p>
   <label for="<?php echo $this->get_field_id( 'delimiter' ); ?>"><?php _e('Specify Feed Delimiter:', 'feedmenow'); ?></label>
   <input id="<?php echo $this->get_field_id( 'delimiter' ); ?>" name="<?php echo $this->get_field_name( 'delimiter' ); ?>" value="<?php echo $instance['delimiter']; ?>" maxlength=1 size=1 style="width:20%;" />
  </p>

<!-- Number of posts to display per feed: Text Input -->
<p>
  <label for=""
    <?php echo $this->get_field_id( 'numposts' ); ?>"><?php _e('Number of posts to display per feed (blank = 0):', 'feedmenow'); ?>
  
  </label>
  <input id="<?php echo $this->get_field_id( 'numposts' ); ?>" name="<?php echo $this->get_field_name( 'numposts' ); ?>" value="<?php echo $instance['numposts']; ?>" maxlength=2 size=2 style="width:20%;" />

</p>


 <?php
 }

}
if (!class_exists("FeedMeNow")) {
 class FeedMeNow
 {
  // property declaration
  public $var = 'a default value';
  function displayVar()
  {
   return  "Extending class\n";
  }

  // method declaration
 function rss_output($feeddelimiter,$feeds,$numberOfEntries,$filterStrs,$showHeader,$feedtitle, $searchtitle,  $searchdesc, $numposts,$nonews)
   #create html formatt rss output
   {

	 			if (!empty($feeds))
 			{
   $feedArray =  @explode($feeddelimiter, $feeds);
$history = '';

   $feedArray =  @explode($feeddelimiter, $feeds);
   if (!empty($feedArray))
   {

    $firstquarter = @explode("[,]", $filterStrs);
    $titleStr = '';
    $thereIsAnthing = 0;
    $stack = array("");

	include 'lastRSS.php';
    //instantiate an object of the lastRSS class
    $rss = new lastRSS();
	
    // Set cache dir and cache time limit (1200 seconds)
    // (dont forget to chmod cahce dir to 777 to allow writing)
 		$rss->cache_dir =  ''; // 'http://localhost.localdomain/wp3/wp-content/plugins/fmn/temp'; 
	$rss->cache_time = 4800; 

    $feedcounter = 0;
    
     foreach($feedArray as $url)
     {
     
     $feedcounter = 0;

      //get the rss feed website
      $WebName =substr($url,7);
      $slashfound = @explode("/",$WebName);
      $WebName =  $slashfound[0];
      $thereIsSomething = 0;

      // Try to load and parse RSS file
      if ($rsbbc = $rss->get($url))
       {
        $countbbc = 0;
        foreach($rsbbc['items'] as $item)
        {

         $IsFound = 0;


         $countbbc = $countbbc + 1;
         foreach($firstquarter as $key => $value)
         {

         $feedArrayStr =  @explode(',', $value);
         foreach($feedArrayStr as $searcforhstr)
          {

			if ($IsFound == 0)
				{

         			$header = $item['title'];
					preg_match_all('/<!\[cdata\[(.*?)\]\]>/is', $header, $matches);
					$header = str_replace($matches[0], $matches[1], $header);


					$curr_pos = 0;

					// First look in the title
					// If nothing is found then look in the description

					$haystacktitle = $item['title'];
					$lenStr = strlen($haystacktitle) ;

					if (($lenStr - 3) > 0)
					{
						$haystacktitle = substr($haystacktitle,9);
						$haystacktitle = substr($haystacktitle,0, $lenStr);
						$curr_pos = strpos($haystacktitle,$searcforhstr);
					}

					if ($curr_pos == 0)
					{
					$haystack = $item['description'];
					$curr_pos = strpos($haystack,$searcforhstr);
					}
					else
					{
						$haystack = $haystacktitle;
					}

					preg_match_all('/<!\[cdata\[(.*?)\]\]>/is', $haystack, $matches);
					$haystack = str_replace($matches[0], $matches[1], $haystack);


				if ($curr_pos === false) {

					} else {

				$IsFound = 1;

	      
				$feedcounter = $feedcounter + 1;

				 $thereIsSomething = $thereIsSomething + 1;
				 $thereIsAnthing = $thereIsAnthing + 1;
				 if ( /*$countbbc <= $numberOfEntries && $curr_pos >0 && */ $key ==0)
				  {
					  if ($thereIsAnthing  == 1)
				   {
					if ($showHeader == "on")
					{

					// Show website logo (if presented)
						if ($rsbbc[image_url] != '')
						{
								print_r("<a href=\"$rsbbc[image_link]\" TARGET='_blank' ><img src=\"$rsbbc[image_url]\" alt=\"$rsbbc[image_title]\" vspace=\"1\" border=\"0\" /></a></br>");


						}
						else
						{
								print_r("<a href=\"$link\" TARGET='_blank' ><b>".urlencode($WebName)."</b></a></br>");
               
						}
					}//	End Show website logo (if presented)

				   }
				
				   if (is_null(trim($haystack)))
				   {
				   }
				   else
				   {

					$new_string =preg_replace('/[^a-zA-Z0-9\s]/', '',$haystack );
					$key = 0;
					$key = array_search($haystack, $stack);
					if ($key == 0)
						{
							if (strlen($new_string) > 0)
							{

							$str = "<a href=\"$item[link]\" TARGET='_blank' >".trim($header)."</a>";

								if (strlen(preg_replace('/[^a-zA-Z0-9\s]/', '',$str )) > 0)
								{
                //This is where the rss is output
                
                if ($feedcounter > 0)
                {
									  if ($feedcounter <= $numposts)
                      {
                        printf($str);
                        printf('<br>');
                      }
                   }
                   else
                   {
                   printf($str);
                   printf('<br>');
                   }

                  
									array_push($stack, $haystack);
								}
							}
						}
				   }
				  }
				}
            }// End If $IsFound == 0

            	
          } // End foreach($feedArrayStr as $searcforhstr)
         } // End foreach($firstquarter as $key => $value)
        } // End foreach($rsbbc['items'] as $item)
      } // End Try to load and parse RSS file
      else
      {
		     // print_r("There are no RSS news items today</br>");
      } // End else


     } // End foreach($feedArray as $url)
     if ($thereIsAnthing < 1)
     {
 				print_r($nonews);
     }
    } // End if (!empty($feedArray))
}// End if !empty $feeds

  } // End rss_output


    } // End class FeedMeNow

} // End if (!class_exists("FeedMeNow"))

?>