<?php
/*
Plugin Name: Facebook Gallery
Plugin URI: http://www.builtapp.com
Description: Wordpress plugin for incorporating galleries on facebook
Author: Builtapp
Version: 1.0.1
Author URI: http://builtapp.com
*/

add_action('wp_head', 'load_fb_styles');  
add_shortcode('fb_gallery', 'fb_custom_js');

function fb_custom_js($profile) {
	extract(shortcode_atts(array(
        'profile' => 'profile'
    ), $profile));
	
	
	
    echo "
	<div id='fb-album'></div>
	<script src='".plugins_url( "/js/jquery.lightbox-0.5.pack.js" , __FILE__ )."'></script>
	<script src='http://connect.facebook.net/en_US/all.js'></script>
	<script src='".plugins_url( "/js/jquery.fb-album.js" , __FILE__ )."'></script>
	
	<script>
			jQuery('#fb-album').fbalbum({
				pageId: '".$profile."',
				//exclude:['352683711441378','196199743756443','190809797628771'],
				lb:{fixedNavigation:false,
	      						imageBtnPrev:'images/lightbox-btn-prev.gif',
	      						imageBtnNext:'images/lightbox-btn-next.gif',
	      						imageBlank:'images/lightbox-blank.gif',
	      						imageLoading:'images/lightbox-ico-loading.gif',
	      						imageBtnClose:'images/lightbox-btn-close.gif'
	      					}
			});
        
            </script>";
	
}


if (!function_exists('load_fb_styles')) {  
    function load_fb_styles() {
		wp_register_style( 'light', plugins_url('/css/jquery.lightbox-0.5.css', __FILE__) );
		wp_register_style('album', plugins_url( '/css/jquery.fb-album.css', __FILE__ ));
        wp_enqueue_style( 'light' );
        wp_enqueue_style( 'album' );
        }  
    
}  

?>