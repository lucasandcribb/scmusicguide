<?php


/**
* Get a Easy Media Gallery specific option
*
* @param string $name The option name
* @return object|bool Option value on success, false if no value exists
*/
 
 
/*-------------------------------------------------------------------------------*/
/*   ADMIN Register JS & CSS
/*-------------------------------------------------------------------------------*/
function easymedia_reg_script() {
	// CSS ( settings.php, tinymce-dlg.php, metaboxes.php )
	wp_register_style( 'easymedia-cpstyles', plugins_url( 'css/funcstyle.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION, 'all');
	wp_register_style( 'easymedia-colorpickercss', plugins_url( 'css/colorpicker.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'easymedia-sldr', plugins_url( 'css/slider.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'easymedia-ibutton', plugins_url( 'css/ibutton.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );	
	wp_register_style( 'easymedia-tinymce', plugins_url( 'css/tinymce.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'jquery-ui-themes-redmond', plugins_url( 'css/jquery/jquery-ui/themes/smoothness/jquery-ui-1.10.0.custom.min.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'easymedia-tinymce', plugins_url( 'css/tinymce.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );	
	wp_register_style( 'jquery-multiselect-css', plugins_url( 'css/jquery/multiselect/jquery.multiselect.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'easymedia-comparison-css', plugins_url( 'css/compare.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'jquery-messi-css', plugins_url( 'css/messi.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	
	// JS ( settings.php ) 
	wp_register_script( 'easymedia-jquery-easing', plugins_url( 'js/jquery/jquery.easing.1.3.js' , dirname(__FILE__) ) );	
	wp_register_script( 'easymedia-colorpicker', plugins_url( 'js/colorpicker/colorpicker.js' , dirname(__FILE__) ) );	
	wp_register_script( 'colorpicker-eye', plugins_url( 'js/colorpicker/eye.js' , dirname(__FILE__) ) );
	wp_register_script( 'colorpicker-utils', plugins_url( 'js/colorpicker/utils.js' , dirname(__FILE__) ) );
	
	// JS ( tinymce-dlg.php, settings.php ) 
	wp_register_script( 'jquery-multi-sel', plugins_url( 'js/jquery/multiselect/jquery.multiselect.js' , dirname(__FILE__) ) );
	
	// JS ( metaboxes.php, ) 
	wp_register_script( 'easymedia-comparison-js', plugins_url( 'js/func/compare.js' , dirname(__FILE__) ) );
	wp_register_script( 'jquery-messi-js', plugins_url( 'js/jquery/jquery.messi.min.js' , dirname(__FILE__) ) );
		
}
add_action( 'admin_init', 'easymedia_reg_script' );

/* These files build out the plugin specific options and associated functions. */
require_once (EASYMEDG_PLUGIN_DIR . 'includes/options.php'); 

/*-------------------------------------------------------------------------------*/
/*   Load Control Panel
/*-------------------------------------------------------------------------------*/
include_once( EASYMEDG_PLUGIN_DIR . 'includes/settings.php' );

/*-------------------------------------------------------------------------------*/
/*   Load Front End Script
/*-------------------------------------------------------------------------------*/
if ( easy_get_option( 'easymedia_disen_plug' ) == '1' ) {	
include_once( EASYMEDG_PLUGIN_DIR . 'includes/frontend.php' );
}
/*-------------------------------------------------------------------------------*/
/*  Add Metabox & Shortcode
/*-------------------------------------------------------------------------------*/
include_once( EASYMEDG_PLUGIN_DIR . 'includes/metaboxes.php' ); 
include_once( EASYMEDG_PLUGIN_DIR . 'includes/shortcode.php' ); 
include_once( EASYMEDG_PLUGIN_DIR . 'includes/tinymce-dlg.php' ); 
include_once( EASYMEDG_PLUGIN_DIR . 'includes/taxonomy.php' );


/*
|--------------------------------------------------------------------------
| AJAX LIST MEDIA (TINYMCE)
|--------------------------------------------------------------------------
*/
function emg_load_media_list() {
	
	if ( !isset( $_POST['taxo'] ) ) {
		echo '<p>Ajax request failed, please refresh your browser window.</p>';
		die;
		}
		else {
			global $post;
			$taxoterm = $_POST['taxo'];
			
			
$args = array(
'tax_query' => array(
    array(
        'taxonomy' => 'emediagallery',
        'field' => 'id'
        //'terms' => $taxoterm
    )
)
);

query_posts( $args );			
			
if ( have_posts() ) :
	while ( have_posts() ) :
			$show_media .= '
			<input name="'.$post->ID.'" id="'.$post->ID.'" type="text" value="'.get_post_meta( $id, 'easmedia_metabox_title', true ).'" />';

	echo $show_media;
	die();
	
	endwhile;	
else:
  echo 'Sorry, no media matched your criteria.';		
  die();	
endif;
wp_reset_query();			
			
	}
}
add_action( 'wp_ajax_emg_load_media_list', 'emg_load_media_list' );

/*
|--------------------------------------------------------------------------
| AJAX DELETE MEDIA IMAGE
|--------------------------------------------------------------------------
*/
function easmedia_img_media_remv() {
	
	if ( !isset( $_POST['pstid'] ) || !isset( $_POST['type'] ) ) {
		echo '0';
		die;
		}
		
		else {
			if ( !current_user_can( 'edit_theme_options' ) )
			die('-1');
			
			if ( $_POST['type'] == 'image' ){
				$data = $_POST['pstid'];
				update_post_meta($data, 'easmedia_metabox_img', '');
				echo '1';
				die;
				}
	
	elseif ( $_POST['type'] == 'audio' ){
		$data = $_POST['pstid'];
				update_post_meta($data, 'easmedia_metabox_media_audio', '');
				echo '1';
	    die;
		}
	}
}
add_action( 'wp_ajax_easmedia_img_media_remv', 'easmedia_img_media_remv' );

/*
|--------------------------------------------------------------------------
| Easymedia Get Control Panel Options
|--------------------------------------------------------------------------
*/
function easy_get_option( $name ){
    $easymedia_values = get_option( 'easy_media_opt' );
    if ( is_array( $easymedia_values ) && array_key_exists( $name, $easymedia_values ) ) return $easymedia_values[$name];
    return false;
}

/*
|--------------------------------------------------------------------------
| Easymedia Custom Category Box (Metabox)
|--------------------------------------------------------------------------
*/
function easymediagallery_categories_meta_box( $post, $box ) {
	$defaults = array('taxonomy' => 'emediagallery');
	if ( !isset( $box['args'] ) || !is_array( $box['args'] ) )
		$args = array();
	else
		$args = $box['args'];
	extract( wp_parse_args($args, $defaults), EXTR_SKIP );
	$tax = get_taxonomy( $taxonomy );

	?>
	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
		<ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
			<li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
			<li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop"><?php _e( 'Most Used' ); ?></a></li>
		</ul>

		<div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
			<ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
				<?php $popular_ids = wp_popular_terms_checklist($taxonomy); ?>
			</ul>
		</div>

		<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
			<?php
            $name = ( $taxonomy == 'emediagallery' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
            echo "<input type='hidden' name='{$name}[]' value='0' />"; // Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.
            ?>
			<ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:<?php echo $taxonomy?>" class="categorychecklist form-no-clear">
				<?php wp_terms_checklist($post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids ) ) ?>
			</ul>
		</div>
	<?php if ( current_user_can($tax->cap->edit_terms) ) : ?>
			<div id="<?php echo $taxonomy; ?>-adder" class="wp-hidden-children">
				<h4>
					<a id="<?php echo $taxonomy; ?>-add-toggle" href="#<?php echo $taxonomy; ?>-add" class="hide-if-no-js">
						<?php
							/* translators: %s: add new taxonomy label */
							printf( __( '+ %s' ), $tax->labels->add_new_item );
						?>
					</a>
				</h4>
				<p id="<?php echo $taxonomy; ?>-add" class="category-add wp-hidden-child">
					<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>"><?php echo $tax->labels->add_new_item; ?></label>
					<input type="text" name="new<?php echo $taxonomy; ?>" id="new<?php echo $taxonomy; ?>" class="form-required form-input-tip" value="<?php echo esc_attr( $tax->labels->new_item_name ); ?>" aria-required="true"/>
					<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>_parent">
						<?php echo $tax->labels->parent_item_colon; ?>
					</label>
					<?php wp_dropdown_categories( array( 'taxonomy' => $taxonomy, 'hide_empty' => 0, 'name' => 'new'.$taxonomy.'_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => '&mdash; ' . $tax->labels->parent_item . ' &mdash;' ) ); ?>
					<input type="button" id="<?php echo $taxonomy; ?>-add-submit" data-wp-lists="add:<?php echo $taxonomy ?>checklist:<?php echo $taxonomy ?>-add" class="button category-add-submit" value="<?php echo esc_attr( $tax->labels->add_new_item ); ?>" />
					<?php wp_nonce_field( 'add-'.$taxonomy, '_ajax_nonce-add-'.$taxonomy, false ); ?>
					<span id="<?php echo $taxonomy; ?>-ajax-response"></span>
				</p>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/*-------------------------------------------------------------------------------*/
/* Add Post Thumbnails and Custom Thumbnails size
/*-------------------------------------------------------------------------------*/
function easmedia_add_thumbnail_support() {
	if ( !current_theme_supports( 'post-thumbnails' ))  {
add_theme_support( 'post-thumbnails', array( 'easymediagallery' ) );
add_image_size( 'emg-admin-thumb', 70, 70, true ); // Used in the easymedia edit page
	}
}
add_action('init', 'easmedia_add_thumbnail_support');

/*-------------------------------------------------------------------------------*/
/* Add credits in admin page
/*-------------------------------------------------------------------------------*/
function easymediagallery_add_footer_credits( $text ) {
	$t = '';
	if ( get_post_type() === 'easymediagallery' ) {
		$t .= "<div id=\"credits\" style=\"line-height: 22px;\">";
		$t .= "<p>Easy Media Gallery plugin Lite is created by <a href=\"http://www.ghozylab.com/\" target=\"_blank\">GhozyLab, Inc</a>.</p>";
		$t .= "<p>If you have some support issue, don't hesitate to <a href=\"http://www.ghozylab.com/contactus\" target=\"_blank\">write here</a>. The GhozyLab team will be happy to support you on any issue.</p>";
		$t .= "</div>";
	}else{
		$t = $text;
	}

	return $t;
}
add_filter( 'admin_footer_text', 'easymediagallery_add_footer_credits' );

/*-------------------------------------------------------------------------------*/
/*  Get the patterns list 
/*-------------------------------------------------------------------------------*/
function easmedia_patterns_ls() {
	$patterns = array();
	$patterns_list = scandir( EMG_DIR."/css/images/patterns" );
	
	foreach( $patterns_list as $pattern_name ) {
		if ( $pattern_name != '.' && $pattern_name != '..' ) {
			$patterns[] = $pattern_name;
		}
	}
	return $patterns;	
}

/*-------------------------------------------------------------------------------*/
/*  HEX to RGB
/*-------------------------------------------------------------------------------*/
function easymedia_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return implode(",", $rgb); // returns an array with the rgb values
}

/*-------------------------------------------------------------------------------*/
/*  Shortcode Handler
/*-------------------------------------------------------------------------------*/
function easymedia_sc_handler( $scdata, $scl ) {
	
	switch ( $scl ) {
		
		case '0':
			if ( $scdata != '' && $scdata <= 3 ) {
				$finaldata = $scdata;
				} else {
					$finaldata = easy_get_option( 'easymedia_columns' );
					}
		break;

		case '1':
			if ( ( $scdata != '' && $scdata == 'center' ) || ( $scdata != '' && $scdata == 'none' ) ) {
				$finaldata = $scdata;
				} else {
					$finaldata = strtolower( easy_get_option( 'easymedia_alignstyle' ) );
					}			
		break;	
	
		default:
			break;	
	}
	
return $finaldata;

}

/*-------------------------------------------------------------------------------*/
/*  Get attachment image id 
/*-------------------------------------------------------------------------------*/
function get_attachment_id_from_src ($link) {
    global $wpdb;
        $link = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $link);
        return $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE guid='$link'");
}

/*-------------------------------------------------------------------------------*/
/*  Image Resize ( Aspect Ratio )
/*-------------------------------------------------------------------------------*/
function easymedia_imgresize($img, $limit, $isres, $imw, $imh) {
	
	if ( strpos( $img, $_SERVER['HTTP_HOST'] ) === FALSE ) {
		$img= "http://".$_SERVER['HTTP_HOST'].$img;
		}
		else {
			$img= $img;
			}
	
	if ( $img == '' ) {
		$img = plugins_url( 'images/no-image-available.jpg' , dirname(__FILE__) ) ;
	}
		else {
			$img = $img;
		}	
	
	if ( $isres == 'on' ) {
		if ( $imw > $limit ) {
			$tempimgratio = $imh / $imw;
			$fih = (int)($tempimgratio * $limit); // final image height
			$fiw = $limit; // fixed image width
			//$allimgdata = array( EMG_THUMB_FILE . "?src=" . $img . "&h=" . $fih . "&w=" . $fiw . "&zc=1&q=100", $fiw, $fih );
			$allimgdata = array( easymedia_resizer( $img, $imw, $imh, $fiw, $fih, true ), $fiw, $fih );
			}
		else {
			$allimgdata = array( $img, $imw, $imh );
			}		
		}
	else { $allimgdata = array( $img, $imw, $imh );	
	}
return implode(",", $allimgdata);
}

/*-------------------------------------------------------------------------------*/
/*  Image Resize ( Aspect Ratio ) AJAX
/*-------------------------------------------------------------------------------*/
function easymedia_imgresize_ajax() {
	if ( !isset( $_POST['imgurl'] ) || !isset( $_POST['limiter'] ) || $_POST['imgurl'] == '' || $_POST['limiter'] == '' ) {
		echo '<p>Ajax request failed, please refresh your browser window.</p>';
		die;
		}
		else {
			
		$imgurl = $_POST['imgurl'];
		$limiter = $_POST['limiter'];
		$attid = wp_get_attachment_image_src( get_attachment_id_from_src( $imgurl ), 'full' );
	
		if ( strpos( $imgurl, $_SERVER['HTTP_HOST'] ) === FALSE ) {
			$imgurl = "http://".$_SERVER['HTTP_HOST'].$imgurl;
			}
			else {
				$imgurl = $imgurl;
				}
				
				$tmpimgratio = $attid[2] / $attid[1]; //get image aspec ratio

		if ( $attid[1] > $limiter ) {
			$tmph = (int)($tmpimgratio * $limiter); // final image height
			$tmpw = $limiter; // fixed image width
			//$finimgurl = EMG_THUMB_FILE . "?src=" . $imgurl . "&h=" . $tmph . "&w=" . $tmpw . "&zc=1&q=100";
			$finimgurl = easymedia_resizer( $imgurl, $attid[1], $attid[2], $tmpw, $tmph, true );
			$allimgdata = array( $finimgurl, $tmpw, $tmph );
			echo implode(",", $allimgdata);
			die;
			}
		else {
			$finimgurl = $imgurl;
			$allimgdata = array( $finimgurl, $attid[1], $attid[2] );
			echo implode(",", $allimgdata);
			die;
			}		
		}
}
add_action( 'wp_ajax_easymedia_imgresize_ajax', 'easymedia_imgresize_ajax' );

/*-------------------------------------------------------------------------------*/
/*  Get Plugin Version (@return string Plugin version)
/*-------------------------------------------------------------------------------*/
function easymedia_get_plugin_version() {
    $plugin_data = get_plugin_data( EMG_DIR . '/easy-media-gallery.php' );
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}

/*-------------------------------------------------------------------------------*/
/*  Random String
/*-------------------------------------------------------------------------------*/
function RandomString($length) {
        $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
        $original_string = implode('', $original_string);
        return substr(str_shuffle($original_string), 0, $length);
    }
	
/*-------------------------------------------------------------------------------*/
/*  Enable Sorting of the Media 
/*-------------------------------------------------------------------------------*/
function easmedia_create_easymedia_sort_page() {
    $easmedia_sort_page = add_submenu_page('edit.php?post_type=easymediagallery', 'Sorter', __('Sorter', 'easmedia'), 'edit_posts', 'easymedia-order', 'easmedia_easymedia_sort');
    
    add_action('admin_print_styles-' . $easmedia_sort_page, 'easmedia_print_sort_styles');
    add_action('admin_print_scripts-' . $easmedia_sort_page, 'easmedia_print_sort_scripts');
}
add_action( 'admin_menu', 'easmedia_create_easymedia_sort_page' );


function easmedia_easymedia_sort() {
    $easymedias = new WP_Query('post_type=easymediagallery&posts_per_page=-1&orderby=menu_order&order=ASC'); 
	if (  $easymedias->have_posts() ) :
	?>
    <div class="wrap">
        <div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>
        <h2><?php _e('Sorter', 'easmedia'); ?></h2>
        <p><?php _e('Simply drag the Media up or down and they will be saved in that order. Media at the top will appear first.', 'easmedia'); ?></p>

		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e( 'Sort Media', 'easmedia' ); ?>:</h3>


        <ul id="easymedia_list" style="padding-left:10px !important;">
            <?php while( $easymedias->have_posts() ) : $easymedias->the_post(); ?>        
                    <li id="<?php the_id(); ?>" class="menu-item">
                        <dl class="menu-item-bar">
                            <dt class="menu-item-handle">
                                <img style="float:left; vertical-align:middle;padding-top: 4px; margin-right:10px;" src="<?php echo plugins_url( 'images/sort.png' , dirname(__FILE__) ) ?>" height="28px;" width="28px;"/><span class="item-title"><?php the_title(); ?></span>
                            </dt>
                        </dl>
                        <ul class="menu-item-transport"></ul>
                    </li>
            <?php endwhile; ?>

				<?php else: ?>
<div class="wrap">
<div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>  
<h2><?php _e('Sorter', 'easmedia'); ?></h2> 
		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e( 'Sort Media', 'easmedia' ); ?>:</h3>             
<p style="padding:10px;"><?php printf( __('No items found, why not %screate one%s?	', 'easmedia'), '<a href="post-new.php?post_type=easymediagallery">', '</a>'); ?> </p></div></div></div>				
<?php endif; ?>            
            
            <?php wp_reset_postdata(); ?>
        </ul>
    </div><div style="padding-left:33px; margin-bottom:30px"><img src="<?php echo plugins_url( 'images/dragdrop.png' , dirname(__FILE__) ) ?>" height="23px;" width="161px;"/></div>
  </div>
 </div>  
	<?php 
}

/*-------------------------------------------------------------------------------*/
/*  RENAME POST BUTTON
/*-------------------------------------------------------------------------------*/
add_filter( 'gettext', 'change_publish_button', 10, 2 );
function change_publish_button( $translation, $text ) {
if ( 'easymediagallery' == get_post_type())
if ( $text == 'Publish' ) {
    return 'Save Media'; }
else if ( $text == 'Update' ) {
    return 'Update Media'; }	

return $translation;
}

/*-------------------------------------------------------------------------------*/
/*   Load Dasboard News
/*-------------------------------------------------------------------------------*/
function emg_register_dashboard_widgets() {
	if ( current_user_can( apply_filters( 'emg_dashboard_stats_cap', 'edit_pages' ) ) ) {
		wp_add_dashboard_widget( 'emg_dashboard_stat', __('Easy Media Gallery (Lite)', 'easmedia'), 'emg_dashboard_widget' );
	}
}
add_action('wp_dashboard_setup', 'emg_register_dashboard_widgets' );

function emg_dashboard_widget() {
?>
    <div class="emg_dashboard_widget">
<p class="sub">If you ever have any questions at all, please post them on our <a target="_blank" href="http://ghozylab.com/contactus/">Submit Support Request</a> form. Our dedicated support team will gladly assist you with your inquiries directly via the ticket or email. Lastly, if you really love Easy Media Gallery, please recommend our plugin to your friends.</p>	
<div style="position:relative;">
<ul class='easymedia-social' id='easymedia-cssanime'>
<li class='easymedia-facebook'>
<a onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=Check out the Best Wordpress Portfolio and Gallery plugin&amp;p[summary]=Easy Media Gallery for WordPress that is powerful and so easy to create portfolio or media gallery&amp;p[url]=http://ghozylab.com/&amp;p[images][0]=<?php echo plugins_url( 'images/easymediabox.png' , dirname(__FILE__) ) ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)" title="Share"><strong>Facebook</strong></a>
</li>
<li class='easymedia-twitter'>
<a onclick="window.open('https://twitter.com/share?text=Check out the Best Wordpress Portfolio and Gallery Plugin &url=http://ghozylab.com/', 'sharer', 'toolbar=0,status=0,width=548,height=325');" title="Twitter" class="circle"><strong>Twitter</strong></a>
</li>
</li>
<li class='easymedia-googleplus'>
<a onclick="window.open('https://plus.google.com/share?url=http://ghozylab.com/','','width=415,height=450');"><strong>Google+</strong></a>
</li>
</li>
<li class='easymedia-pinterest'>
<a onclick="window.open('http://pinterest.com/pin/create/button/?url=http://ghozylab.com/;media=<?php echo plugins_url( 'images/easymediabox.png' , dirname(__FILE__) ) ?>;description=Easy Media Gallery for WordPress that is powerful and so easy to create portfolio or media gallery','','width=600,height=300');"><strong>Pinterest</strong></a>
</li>
</ul>
</div></div>

    <?php
}

/*-------------------------------------------------------------------------------*/
/*   Admin Notifications
/*-------------------------------------------------------------------------------*/

if ( easy_get_option( 'easymedia_disen_admnotify' ) == '1' ) {
function emg_upgradepro_message() {
	
	global $pagenow;
	if ( $pagenow == 'plugin-install.php' || $pagenow == 'plugins.php' || 'easymediagallery' == get_post_type() ||  $pagenow == 'upload.php' || $pagenow == 'media-new.php' ) {	
	
	
            $message = '<div id="emg-discount-upgrade-notice">';
			$message .= '<p><strong>Upgrade to Easy Media Gallery Pro Version - </strong> <a style="color:#fff !important;" target="_blank" href="http://ghozylab.com/order" class="tsc_buttons2 red">UPGRADE NOW &nbsp;for only $18</a> <strong>or you can </strong>  <a style="color:#fff !important;" href="edit.php?post_type=easymediagallery&page=comparison" class="tsc_buttons2 red">Learn More</a>';
            $message .= '</p></div>';
            echo $message;
	}
}
add_action( 'admin_notices', 'emg_upgradepro_message' );
}

/*-------------------------------------------------------------------------------*/
/*   Metabox Donation
/*-------------------------------------------------------------------------------*/
function easmedia_donate_metabox() {
$emgdonate = '<p>';
$emgdonate .= '<span style="color:#666666;margin-left:2px; font-size:12px;">If you love Easy Media Gallery, any donation would be appreciated! It helps to continue the development and support of the plugin.</span><br /><br />
<a id="easymediadonatebtn" class="thickbox"><img style="cursor:pointer;" src="'.plugins_url( 'images/btn_donate_LG.gif' , dirname(__FILE__) ).'" width="92" height="26" alt="Donate Us" ></a>';
$emgdonate .= '</p>';
echo $emgdonate;
}

add_filter('admin_footer','easmedia_donate_metabox_form');
function easmedia_donate_metabox_form(){
$emgdonatefrm = '<div id="easymedia_donate" style="display:none">';	
$emgdonatefrm .= '<p style="padding:1px;"><span style="color:#666666;margin-left:2px; font-size:12px;">If you love Easy Media Gallery, any donation would be appreciated! It helps to continue the development and support of the plugin.</span></p><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="BDUYH4QK698CY">
<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>';
$emgdonatefrm .= '</div>';
echo $emgdonatefrm;
}

/*-------------------------------------------------------------------------------*/
/*   Comparison Page
/*-------------------------------------------------------------------------------*/
function easmedia_create_docs_page() {
    $easmedia_docs_page = add_submenu_page('edit.php?post_type=easymediagallery', 'Documentation', __('Documentation', 'easmedia'), 'edit_posts', 'docs', 'easmedia_easymedia_docs');
}
add_action( 'admin_menu', 'easmedia_create_docs_page' );


function easmedia_easymedia_docs() {
	?>
    <div class="wrap">
        <div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>
        <h2><?php _e('Documentation', 'easmedia'); ?></h2>
        <p><?php _e('This plugin comes with instructional training videos that walk you through every aspect of setting up your new media gallery. We recommend following these videos to setup your media gallery. This user manual is only intended to be a reference guide.', 'easmedia'); ?></p>

		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e( 'Basic Functions', 'easmedia' ); ?></h3>
        <div id="easymedia_docs1" style="padding-left:10px !important;">
        <ul style="list-style: square; position:relative; margin-left:15px; margin-bottom:25px">
        <li><a href="http://www.youtube.com/watch?v=dXFBNY5t6E8" target="_blank" >How to Create Single Image Media</a></li>
        <li><a href="http://www.youtube.com/watch?v=htxwZw_aPF0" target="_blank" >How to Create Video Media Types</a></li>  
        <li><a href="http://www.youtube.com/watch?v=Bsn-CB5Hpbw" target="_blank" >How to Create Audio (mp3) Media Types</a></li>
        <li><a href="http://www.youtube.com/watch?v=Z2qwXz7GIRw" target="_blank" >How to Publish Easy Media Gallery</a></li>                  
        <li><a href="http://www.youtube.com/watch?v=2T73wvt_wOA" target="_blank" >How to Change Media Border Size and Color</a></li>
        <li><a href="http://www.youtube.com/watch?v=56f_C7OXiAE" target="_blank" >How to Change Media Columns</a></li>                 
        <li><a href="http://www.youtube.com/watch?v=skCMKvVLD5o" target="_blank" >How to Set Order of Image (Pro version)</a></li>
        <li><a href="http://www.youtube.com/watch?v=Oee2cpKT-kE" target="_blank" >How to Create Audio Soundcloud  (Pro version)</a></li>
        <li><a href="http://www.youtube.com/watch?v=SYH8Yl2SQd4" target="_blank" >How to Create Audio Reverbnation (Pro version)</a></li>    
        <li><a href="http://www.youtube.com/watch?v=PEgfleRf6hg" target="_blank" >How to Create Google Maps (Pro version)</a></li>               
        <li><a href="http://www.youtube.com/watch?v=9cuYyBMKx2k" target="_blank" >How to Insert Image into Media Description  (Pro version)</a></li>        
                          
        </ul>
    </div>
    </div>     
 		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e( 'Troubleshooting ', 'easmedia' ); ?></h3>
        <div id="easymedia_docs2" style="padding-left:10px !important;">
        <ul style="list-style: square; position:relative; margin-left:15px;">
        <li><a href="http://wordpress.org/extend/plugins/easy-media-gallery/faq/" target="_blank" >Images not showing up</a></li>        
        <li><a href="http://www.youtube.com/watch?v=lYDJ8fM18pc" target="_blank" >How to change cache folder permission from cPanel</a></li>
        <li><a href="http://www.youtube.com/watch?v=S_Az2Zg5OLc" target="_blank" >How to change cache folder permission from FileZilla</a></li>
        <li><a href="http://wordpress.org/extend/plugins/easy-media-gallery/faq/" target="_blank" >FAQ (Wordpress.org)</a></li>       
        </ul>
    </div>
    </div>    

  </div>
 </div>  
	<?php 
}



/*-------------------------------------------------------------------------------*/
/*   Comparison Page
/*-------------------------------------------------------------------------------*/
function easmedia_create_comparison_page() {
    $easmedia_comparison_page = add_submenu_page('edit.php?post_type=easymediagallery', 'Comparison', __('Get More Features', 'easmedia'), 'edit_posts', 'comparison', 'easymedia_comparison');
}
add_action( 'admin_menu', 'easmedia_create_comparison_page' );

function easmedia_put_compare_style() {
	if ( is_admin() && isset( $_GET['page'] ) && $_GET['page'] == 'comparison' ){
		wp_enqueue_style( 'easymedia-comparison-css' );	
		wp_enqueue_script( 'easymedia-comparison-js' );
		}
}
add_action( 'admin_enqueue_scripts', 'easmedia_put_compare_style' );

/*-------------------------------------------------------------------------------*/
/*   Generate Comparison Page
/*-------------------------------------------------------------------------------*/
function easymedia_comparison() {
?>

<!-- DC Pricing Tables:3 Start -->

    <div class="wrap">
        <div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>
        <h2><?php _e('Comparison', 'easmedia'); ?></h2>
  <div class="tsc_pricingtable03 tsc_pt3_style1" style="margin-bottom:110px; height:990px;">
    <div class="caption_column">
      <ul>
        <li class="header_row_1 align_center radius5_topleft"></li>
        <li class="header_row_2">
          <h2 class="caption">Easy Media Gallery</h2>
        </li>
        
        <li class="row_style_4"><span>Single Image</span></li>
        <li class="row_style_2"><span>Video Media</span></li>
        <li class="row_style_4"><span>Audio Media</span></li>
        <li class="row_style_2"><span>Image Gallery</span></li>
        <li class="row_style_4"><span>Link Media</span></li>
        <li class="row_style_2"><span>Google Maps</span></li>
        <li class="row_style_4"><span>Custom CSS</span></li>
        <li class="row_style_2"><span>Custom Columns</span></li>
        <li class="row_style_4"><span>Custom Content</span></li>
        <li class="row_style_2"><span>Custom Media Alignment</span></li>
        <li class="row_style_4"><span>Custom Thumbnail Size</span></li>
        <li class="row_style_2"><span>Image &amp; Video Custom Size</span></li>
        <li class="row_style_4"><span>Unlimited colors and layout</span></li>
        <li class="row_style_2"><span>Place media wherever you want</span></li>
        <li class="row_style_4"><span>Media Style</span><a target="_blank" href="http://ghozylab.com/" style="text-decoration:underline !important;"> Click for Sample</a></li>
        <li class="row_style_2"><span>Pattern Overlay</span></li>
        <li class="row_style_4"><span>Powerfull Control Panel </span> <a href="<?php echo plugins_url( 'images/pro-version-control-panel.png' , dirname(__FILE__) ) ?>   " style="text-decoration:underline !important;">Click for Screenshot</a></li>
        <li class="row_style_2"><span>Advanced Shortcode </span><a  class="thickbox" href="<?php echo plugins_url( 'images/pro-version-shortcode-manager.png' , dirname(__FILE__) ) ?>" style="text-decoration:underline !important;">Click for Screenshot</a></li>
        <li class="row_style_4"><span>Facebook, Twitter &amp; Pinterest Button</span></li>
        <li class="row_style_2"><span>WP Multisite</span></li>
        <li class="row_style_4"><span>Direct Support</span></li>
        <li class="row_style_2"><span>Update</span></li>
        <li class="footer_row"></li>
      </ul>
    </div>
    <div class="column_1">
      <ul>
        <li class="header_row_1 align_center">
          <h2 class="col1">Lite Version</h2>
        </li>
        <li class="header_row_2 align_center">
          <h1 class="col1">$<span>0</span></h1>
        </li>
        <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>  
        <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>        
        <li class="row_style_1 align_center"><span>max 3 columns</span></li>
        <li class="row_style_3 align_center"><span>title &amp; subtitle ONLY</span></li>
        <li class="row_style_1 align_center"><span>center</span></li>
        <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_3 align_center"><span>light</span></li>
        <li class="row_style_1 align_center"><span>3 patterns</span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
         
        <li class="footer_row"></li>
      </ul>
    </div>
    <div class="column_2">
      <ul>
        <li class="header_row_1 align_center">
          <h2 class="col2">Pro Version</h2>
        </li>
        <li class="header_row_2 align_center">
          <h1 class="col2">$<span>18</span></h1>
        </li>
        
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>        
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span>up to 8 columns</span></li>
        <li class="row_style_4 align_center"><span>title, subtitle &amp; unlimited content</span></li>
        <li class="row_style_2 align_center"><span>left, right, center</span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span>light, dark &amp; transparent</span></li>
        <li class="row_style_2 align_center"><span>15 patterns</span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span>1 year</span></li>
        <li class="footer_row"><a target="_blank" href="http://ghozylab.com/order" class="tsc_buttons2 red">Upgrade Now</a></li>
      </ul>
    </div></div>
  </div>
<!-- DC Pricing Tables:3 End -->
<div class="tsc_clear"></div> <!-- line break/clear line -->


<?php


}


?>