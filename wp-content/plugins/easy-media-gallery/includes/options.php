<?php

/*------------------------------------------------------------------------------------*/
/*  Easy Media Gallery
/*  Option Control Panel
/*  require_once settings.php
/*------------------------------------------------------------------------------------*/

// VARIABLES
$plugname = "Easy Media Gallery";
$theshort = "easymedia";

// Set the Options Array
$theopt = array (
 
array( "name" => $plugname." Options",
	"type" => "title"),
 
array( "name" => "General",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Columns",
	"desc" => "Select default Column for each media block, you can also set this manually when adding shortcode.<br><br><a target='_blank' href='http://ghozylab.com/order'>Upgrade</a> to PRO and you can choose up to 8 columns.",
	"id" => $theshort."_columns",
	"type" => "select",
	"options" => array( "1", "2", "3" ),
	"std" => "3"),	
	
array( "name" => "Alignment",
	"desc" => "Select thumbnails alignment. Default: Center<br><br><a target='_blank' href='http://ghozylab.com/order'>Upgrade</a> to PRO and you can choose center, left or right alignment.",
	"id" => $theshort."_alignstyle",
	"type" => "select",
	"options" => array( "none", "Center" ),
	"std" => "Center"),		
	
array( "name" => "Full-size image limit",
	"desc" => "Set the limit for image width on full-size, image height will adjust automatically. Default: 940px.",
	"id" => $theshort."_img_size_limit",
	"type" => "slider",
	"usestep" => "0",	
	"max" => "2560",
	"pixopr" => "px",	
	"std" => "940"),	
	
array( "name" => "Video Size",
	"desc" => "Adjust the video size. Default size for all video : width 700px,  height 400px.",
	"id" => $theshort."_vid_size",
	"type" => "size",
	'std' => array( 'width' => '700', 'height' => '400' ),
	"pixopr" => "px"),
	
array( "name" => "Video Auto Play",
	"desc" => "Use this to enable/disable video auto play. This option only work on Youtube, Vimeo, Google Video and Veoh.",
	"id" => $theshort."_disen_autoplv",
	"type" => "checkbox",
	"std" => "1"),		
		
array( "name" => "Audio Auto Play",
	"desc" => "Use this to enable/disable audio auto play. This option only work for media MP3.",
	"id" => $theshort."_disen_autopl",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Audio Loop",
	"desc" => "Use this to enable/disable audio loop. This option only work for media MP3.",
	"id" => $theshort."_disen_audio_loop",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Audio Volume",
	"desc" => "Set the default volume for audio media.",
	"id" => $theshort."_audio_vol",
	"type" => "slider",
	"usestep" => "0",	
	"max" => "100",
	"pixopr" => "",	
	"std" => "75"),	
	
array( "type" => "close"),
array( "name" => "Style Options",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Media Box Style",
	"desc" => "Select media box style. Default: Light<br><br><a target='_blank' href='http://ghozylab.com/order'>Upgrade</a> to PRO and get more styles.",
	"id" => $theshort."_box_style",
	"type" => "select",
	"options" => array( "Light" ),
	"std" => "1"),	

array( "name" => "Cursor",
	"desc" => "Move the mouse pointer on top the media to see the effect. Default: Pointer",
	"id" => $theshort."_cur_style",
	"type" => "select",
	"options" => array( "Pointer", "Crosshair", "Move", "Default" ),
	"std" => "3"),
	
array( "name" => "Thumbnail Size",
	"desc" => "Allow for editing thumbnail sizes. Default sizes width 180px, height : 180px.<br><br><a target='_blank' href='http://ghozylab.com/order'>Upgrade</a> to PRO so you can set this manually when adding shortcode.",
	"id" => $theshort."_frm_size",
	"type" => "size",
	'std' => array( 'width' => '180', 'height' => '180' ),
	"pixopr" => "px"),		
	
array( "name" => "Thumbnail Border Color",
	"desc" => "Please define your custom Border Color. Default color is white (#FFF)",
	"id" => $theshort."_frm_col",
	"type" => "color",
	"std" => "#FFFFFF"),	
	
array( "name" => "Thumbnail Title Color",
	"desc" => "Please define your Title Color. Default color is dark grey",
	"id" => $theshort."_ttl_col",
	"type" => "color",
	"std" => "#C7C7C7"),	
	
array( "name" => "Thumbnail Border Radius",
	"desc" => "Set the border radius for the image box. Default : 3px",
	"id" => $theshort."_brdr_rds",
	"type" => "slider",
	"usestep" => "0",	
	"max" => "100",
	"pixopr" => "px",		
	"std" => "3"),		
	
array( "name" => "Thumbnail Hover Color",
	"desc" => "Please define your Thumbnail Hover Color. Default color is dark (#000000). NOTE : This function may not work on IE browser.",
	"id" => $theshort."_thumb_col",
	"type" => "color",
	"std" => "#000000"),	
	
array( "name" => "Thumbnail Hover Opacity",
	"desc" => "Opacity of the Thumbnail that appears on media mouseover. Default : 40%",
	"id" => $theshort."_hover_opcty",
	"type" => "slider",
	"max" => "100",
	"step" => "10",
	"usestep" => "1",
	"pixopr" => "%",		
	"std" => "40"),			
	
array( "name" => "Pattern Overlay",
	"desc" => "Please define pattern for box overlay.<br><br><a target='_blank' href='http://ghozylab.com/order'>Upgrade</a> to PRO and you can choose up to 15 patterns.",
	"id" => $theshort."_style_pattern",
	"type" => "pattern",
	"std" => "pattern-01.png"),	
	
array( "name" => "Thumbnail Border",
	"desc" => "Enable or disable border. You also can hide the border by set the value to 0.",
	"id" => $theshort."_disen_bor",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Hover Style",
	"desc" => "Enable or disable image hover effect.",
	"id" => $theshort."_disen_hovstyle",
	"type" => "checkbox",
	"std" => "1"),
	
array( "type" => "close"),
array( "name" => "Miscellaneous",
	"type" => "section"),
array( "type" => "open"),
	
array( "name" => "Enable Plugin",
	"desc" => "Enable or temporarily disable this plugin.",
	"id" => $theshort."_disen_plug",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Keep data when uninstall/update",
	"desc" => "Enable this option to keep all plugin data and settings before you uninstall for update this plugin.",
	"id" => $theshort."_disen_databk",
	"type" => "checkbox",
	"std" => "1"),		
	
array( "name" => "Admin Notification",
	"desc" => "Enable/Disable admin notifications.",
	"id" => $theshort."_disen_admnotify",
	"type" => "checkbox",
	"std" => "1"),		
	
array( "name" => "Plugin Core Compatibility Mode",
	"desc" => "Could solve issues on old plugin core versions, Use it ONLY IF you notice some issues. Default: core-1.4.5-min",
	"id" => $theshort."_plugin_core",
	"type" => "select",
	"options" => array( "core-1.4.5-min", "core-1.4.5-full-compat-yc", "core-1.2.5-core-yc" ),
	"std" => "core-1.4.5-min"),		
	
array( "type" => "close")
	
);


/*------------------------------------------------------------------------------------*/
/*  RESTORE DEFAULT SETTINGS
/*------------------------------------------------------------------------------------*/

function easymedia_restore_to_default($cmd) {
	
	if ( $cmd == 'reset' ) {
		
		delete_option( 'easy_media_opt' );
		
				$arr = array(
				$theshort.'_deff_init' => '1',
				$theshort.'_box_style' => 'Light',				
				$theshort.'_frm_col' => '#FFFFFF',
				$theshort.'_ttl_col' => '#C7C7C7',
				$theshort.'_shdw_col' => '#4A4A4A',
				$theshort.'_thumb_col' => '#000000',
				$theshort.'_overlay_col' => '#F7F0D7',
				$theshort.'_overlay_opcty' => '80',	
				$theshort.'_thumb_border_opcty' => '100',							
				$theshort.'_icon_col' => '#474747',				
				$theshort.'_hover_style' => 'Dark',
				$theshort.'_hover_opcty' => '40',
				$theshort.'_img_size_limit' => '940',
				$theshort.'_columns' => '3',
				$theshort.'_margin_box' => '12',
				$theshort.'_audio_vol' => '75',
				$theshort.'_disen_audio_loop' => '1',				
				$theshort.'_frm_border' => '5',
				$theshort.'_plugin_core' => 'core-1.4.5-min',
				$theshort.'_cur_style' => 'Pointer',
				$theshort.'_alignstyle' => 'Center',
				$theshort.'_style_pattern' => 'pattern-01.png',
				$theshort.'_disen_ticon' => '1',
				$theshort.'_disen_icocol' => '1',	
				$theshort.'_disen_style_man' => '1',					
				$theshort.'_brdr_rds' => '3',
				$theshort.'_disen_bor' => '1',
				$theshort.'_disen_upchk' => '0',				
				$theshort.'_disen_sdw' => '1',
				$theshort.'_disen_databk' => '1',				
				$theshort.'_disen_autopl' => '1',
				$theshort.'_disen_autoplv' => '1',								
				$theshort.'_disen_hovstyle' => '1',
				$theshort.'_disen_admnotify' => '1',				
				$theshort.'_disen_plug' => '1',
				$theshort.'_frm_size' => array('width' => '180','height' => '180',),
				$theshort.'_vid_size' => array('width' => '700','height' => '400',)											
				);
				update_option('easy_media_opt', $arr);
				return;
	}
}



/*------------------------------------------------------------------------------------*/
/*  1ST CONFIGURATION
/*------------------------------------------------------------------------------------*/

function easymedia_1st_config() {

				$thshort = "easymedia";
				
				$arr = array(
				$thshort.'_deff_init' => '1',
				$thshort.'_frm_col' => '#FFFFFF',
				$thshort.'_ttl_col' => '#C7C7C7',
				$thshort.'_shdw_col' => '#4A4A4A',
				$thshort.'_icon_col' => '#474747',
				$thshort.'_box_style' => 'Light',
				$thshort.'_overlay_col' => '#F7F0D7',
				$thshort.'_thumb_col' => '#000000',
				$thshort.'_hover_style' => 'Dark',
				$thshort.'_plugin_core' => 'core-1.4.5-min',			
				$thshort.'_hover_opcty' => '40',
				$thshort.'_overlay_opcty' => '80',	
				$thshort.'_thumb_border_opcty' => '100',				
				$thshort.'_img_size_limit' => '940',
				$thshort.'_columns' => '3',
				$thshort.'_margin_box' => '12',
				$thshort.'_audio_vol' => '75',
				$thshort.'_disen_audio_loop' => '1',								
				$thshort.'_frm_border' => '5',
				$thshort.'_cur_style' => 'Pointer',
				$thshort.'_alignstyle' => 'Center',
				$thshort.'_brdr_rds' => '3',
				$thshort.'_disen_bor' => '1',
				$thshort.'_disen_sdw' => '1',
				$thshort.'_style_pattern' => 'pattern-01.png',
				$thshort.'_disen_ticon' => '1',
				$thshort.'_disen_icocol' => '1',
				$thshort.'_disen_databk' => '1',				
				$thshort.'_disen_style_man' => '1',				
				$thshort.'_disen_upchk' => '0',				
				$thshort.'_disen_hovstyle' => '1',
				$thshort.'_disen_plug' => '1',
				$thshort.'_disen_autopl' => '1',
				$thshort.'_disen_autoplv' => '1',	
				$thshort.'_disen_admnotify' => '1',											
				$thshort.'_frm_size' => array( 'width' => '180','height' => '180', ),
				$thshort.'_vid_size' => array( 'width' => '700','height' => '400', ));
				
				update_option( 'easy_media_opt', $arr, '', 'yes' );
				return;
}


?>