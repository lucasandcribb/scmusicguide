<?php
/*
Plugin Name: LBGallery for WordPress
Plugin URI: http://lessbugs.com
Description: Plugin to create multi galleries for WordPress
Author: tunnhn, lessbugs
Version: 1.1
Author URI: http://lessbugs.com
*/

$lbPlugin = array(
	'name' => 'lb-gallery',
	'path' => dirname(__FILE__)
);

$lbgallery_tpl = 'default';
$lbgallerySiteTemplte = null;
$lbgalleryAdminTemplate = null;
$lbgalleryView = null;

/**
*	Main class
*/
class LBGallery{
	function __construct(){
		global $lbgallerySiteTemplte, $lbgalleryAdminTemplate, $lbgalleryView;
		$this->defines();
		$this->requires();
		$this->defineTables();
		
		add_action('init', array($this, 'init'));
		add_action('wp_head', array($this, 'wp_header'));
		add_action( "admin_menu", array($this, 'admin_menu'));
		add_action( "admin_head", array($this, 'admin_head'));
		
		register_activation_hook(LBGAL_FILE, array($this, "on_active"));
		register_deactivation_hook(LBGAL_FILE, array($this, "on_deactive"));
		LBGalleryCore::addPlugin('lb-gallery', LBGAL_DIR);
		$this->addAjax();
		
		$lbgallerySiteTemplte = new LBGalleryTemplate(array(
			'side' 		=> 'site',
			'template' 	=> 'default',
			'plugin' 	=> 'lb-gallery'
		));
		$lbgalleryAdminTemplate = new LBGalleryTemplate(array(
			'side' 		=> 'admin',
			'template' 	=> 'default',
			'plugin' 	=> 'lb-gallery'
		));

		$lbgalleryView = new LBGalleryShortcode();
		// Shortcode
		add_shortcode('lbgallery', array($lbgalleryView, 'display'));
		
	}
	/**
	*	init
	*/
	function init(){	
		if($_REQUEST['upload-image-verify']){			
			require_once(LBGAL_LIBS.'/uploadify/'.$_REQUEST['media_type'].'.php');
		}
		if(!is_admin()){
			wp_deregister_script('jquery');
			wp_register_script('jquery', get_bloginfo('siteurl').'/wp-includes/js/jquery/jquery.js');
			wp_enqueue_script('jquery');
			
			
		}else{
			wp_enqueue_script('jquery-ui-sortable');
		}
	}
	/**
	*	auto add AJAX
	*/
	function addAjax(){
		$methods = get_class_methods($this);
		foreach($methods as $method){
			if(preg_match('!^ajax_!', $method)){
				foreach(array('', 'nopriv_') as $nopriv_){
					$name = str_replace('ajax_', '', $method);
					add_action('wp_ajax_'.$nopriv_.$name, array($this, 'ajax_'.$name));
				}
			}
		}
	}
	function ajax_lbgal_load_single_image(){
		global $lbgalleryView;
		$lbgalleryView->ajax_load_single_image();
	}
	function ajax_lbgal_rating(){
		global $lbgalleryView;
		$lbgalleryView->ajax_user_rate();
	}
	function ajax_lbgal_load_galleries(){
		global $lbgalleryView;
		$lbgalleryView->ajax_load_galleries();
	}
	function ajax_lbgal_load_images(){
		global $lbgalleryView;
		$lbgalleryView->ajax_load_images();
	}
	function ajax_lbgal_save_inline(){
		global $wpdb;
		if(!class_exists('LBGalleryVideo')){
			require_once(LBGAL_LIBS . '/video.php');
		}
		$video = new LBGalleryVideo();
		$id = null;
		$gid = $wpdb->get_var("SELECT gid FROM {$wpdb->lbgal_image} WHERE id = ". $_POST['id']);
		if($provider = $video->getProvider($_POST['filename'], 'video')){
			$videos = $provider->getItems();
			if($videos)
				foreach($videos as $video){					
					$data = array(
						'title' 		=> strlen($_POST['title']) ? $_POST['title'] : $video->title,
						'description' 	=> strlen($_POST['description']) ? $_POST['description'] : $video->description,
						'filename'		=> $video->link,						
						'type'			=> 'video',
						'storage'		=> 'remote',
						'provider'		=> $provider->getType(),
						'thumbname'		=> $_POST['thumbname'] ? $_POST['thumbname'] : $video->thumbnail,
						'linkto'		=> $_POST['linkto'],
						'id'			=> $_POST['id']
					);
					$id = LBGalleryTable::store($wpdb->lbgal_image, $data);
				}
		}else{
			$data = $_POST;
			$id = LBGalleryTable::store($wpdb->lbgal_image, $data);
		}			
		$item = LBGalleryHelper::getImage($id);
		echo json_encode($item);
		die();
	}
	
	/**
	*/
	function ajax_update_order(){
		global $wpdb;
		$ids = explode(",", $_REQUEST['ids']);
		$orderings = explode(",", $_REQUEST['orderings']);
		
		if($ids)
			$table = $_POST['list'] == 'gallery' ? $wpdb->lbgal_gallery : $wpdb->lbgal_image;
			foreach($ids as $k => $id){
				$query = "
					UPDATE {$table}
					SET ordering = {$orderings[$k]}
					WHERE id = {$id}
				";
				$wpdb->query($query);			
			}
		die();
	}
	/**
	*/
	function defineTables(){
		global $wpdb;
		$wpdb->lbgal_gallery 	= $wpdb->prefix . 'lbgal_gallery';
		$wpdb->lbgal_category 	= $wpdb->prefix . 'lbgal_category';
		$wpdb->lbgal_image 		= $wpdb->prefix . 'lbgal_image';
		$wpdb->lbgal_setting 	= $wpdb->prefix . 'lbgal_settings';
		$wpdb->lbgal_rating 	= $wpdb->prefix . 'lbgal_rating';
	}
	/**
	* shortcode
	*/
	function shortcode($atts){
		lbgallery_shortcode($atts);
	}
	
	/**
	* defines constants
	*/
	function defines(){
		define("LBGAL_FILE", __FILE__);
		define("LBGAL_DIR", dirname(__FILE__));
		define('LBGAL_FOLDER', plugin_basename(LBGAL_DIR));
		define('LBGAL_URL', get_bloginfo("siteurl")."/wp-content/plugins/".LBGAL_FOLDER);
		define('LBGAL_CSS', LBGAL_URL.'/assets/css');
		define('LBGAL_JS', LBGAL_URL.'/assets/js');	
		define('LBGAL_IMAGES', LBGAL_URL.'/assets/images');	
		define('LBGAL_UPLOADS_URL', LBGAL_URL.'/uploads');	
		define('LBGAL_LIBS_URL', LBGAL_URL .'/libraries');
		define('LBGAL_UPLOADS_DIR', LBGAL_DIR.'/uploads');	
		define('LBGAL_LIBS', LBGAL_DIR .'/libraries');
		define('LBGAL_BLOCKS', LBGAL_DIR . '/admin/blocks');
		define('LBGAL_FILE_NOT_EXISTS', 1);
		define('LBGAL_EXTENSION_NOT_ALLOW', 2);
		define('LBGAL_ERROR_UPLOAD', 3);
		define('LBGAL_UPLOAD_SUCCESS', 4);
		define('LBGAL_INC', LBGAL_DIR . '/includes'); 
		define('LBGAL_TMP_DIR', LBGAL_DIR . '/files/tmp');
		define('LBGAL_GALLERY_DIR', LBGAL_DIR . '/files/gallery');
		define('LBGAL_GALLERY_URL', LBGAL_URL . '/files/gallery');
	}
	
	/**
	* require files
	*/
	function requires(){
		require_once(LBGAL_LIBS . '/core/loader.php');
		require_once(LBGAL_DIR . '/helper.php');
		require_once(LBGAL_INC . '/shortcode.php');
		require_once(LBGAL_INC . '/widget.php');		
	}
	
	/**
	*	add assets into header
	*/
	function wp_header(){
		global $lbgallery_tpl;
		wp_register_style('lbgallery_prettyPhoto', LBGAL_URL . '/libraries/prettyPhoto_3.1.4/css/prettyPhoto.css');
		wp_register_style('lbgallery_lbtooltip', LBGAL_URL . '/libraries/lbtooltip/lbtooltip.css');
	
		wp_print_styles(array(
			'lbgallery_style',
			'lbgallery_prettyPhoto',
			'lbgallery_lbtooltip'
		));
		
		// script
		wp_register_script('lbgallery_animate_color', 'http://www.bitstorm.org/jquery/color-animation/jquery.animate-colors-min.js', array('jquery'));
		wp_register_script('lbgallery_script', LBGAL_JS . '/lbgallery.js', array('jquery'));		
		wp_register_script('lbgallery_prettyPhoto', LBGAL_URL . '/libraries/prettyPhoto_3.1.4/js/jquery.prettyPhoto.js');
		wp_register_script('lbgallery_lbtooltip', LBGAL_URL . '/libraries/lbtooltip/lbtooltip.js');
		wp_register_script('lbgallery_base64', LBGAL_JS . '/base64.js');
		wp_print_scripts(array(
			'lbgallery_animate_color',
			'lbgallery_script',
			'lbgallery_prettyPhoto',
			'lbgallery_mousewheel',			
			'lbgallery_lbtooltip',
			'lbgallery_base64'
		));
		
		$settings= LBGalleryHelper::getSettings('GLOBAL_SETTINGS');
		$stars = LBGalleryHelper::getSettings('RATING_STAR_SETTINGS');
		$key = $settings->star_style;
		$starStyle = $stars->$key;
		ob_start();
		?>
        <style>
		.background-rating {
			background-image: url(<?php echo LBGAL_IMAGES.'/'.$starStyle->src_off;?>);
		}
		.lbgal-rating-form .lbgal-rating-stars .current-rating{
			height:16px;
			background-image:url(<?php echo LBGAL_IMAGES.'/'.$starStyle->src_on;?>);
		}
		
		</style>
        <script type="text/javascript">				
		LBGallerySettings = {
			pluginbase: '<?php echo LBGAL_URL;?>',
			rootsite: '<?php echo get_bloginfo('siteurl');?>',
			ajax: '<?php echo get_bloginfo('siteurl');?>/wp-admin/admin-ajax.php'
		}		
		</script>
        <?php
		$script = ob_get_clean();
		echo $script;
	}
	
	/**
	*	add assets into header
	*/
	function admin_head(){
		wp_register_style("lbgallery_uploadify", LBGAL_LIBS_URL."/uploadify/css/uploadify.css");
		wp_register_style('lbgallery_style', LBGAL_CSS.'/admin.lbgallery.css');
		wp_register_style('lbev_colorpicker', LBGAL_LIBS_URL .'/colorpicker/css/colorpicker.css');
		
		wp_print_styles(array(
			'lbgallery_style',
			'lbgallery_uploadify',
			'lbgallery_style',
			'lbev_colorpicker'
		));
		
		// script
		wp_register_script('global_script', LBGAL_JS . '/admin.script.js', array('jquery', 'jquery-ui-sortable'));
		wp_register_script("lbgallery_swfobject", LBGAL_LIBS_URL."/uploadify/js/swfobject.js");
		wp_register_script("lbgallery_uploadify", LBGAL_LIBS_URL."/uploadify/js/jquery.uploadify.v2.1.0.min.js");
		wp_register_script('lbgallery_base64', LBGAL_JS . '/base64.js');
		wp_register_script('lbevents-jquery-colorpicker',  LBGAL_LIBS_URL.'/colorpicker/js/colorpicker.js' );
		
		wp_print_scripts(array(
			'global_script',
			'lbgallery_swfobject',
			'lbgallery_uploadify',
			'lbgallery_base64',
			'lbevents-jquery-colorpicker'	
		));
		?>
		<style>
		.lbgal-move-handle span {
			position: relative;
			width: 24px;
			height: 24px;
		}
		</style>
        <script type="text/javascript">
		var LBGallerySettings = {
			pluginbase: '<?php echo LBGAL_URL;?>',
			rootsite: '<?php echo get_bloginfo('siteurl');?>',
			maxUploadSize: <?php echo (int) (str_replace("M"," ",ini_get('upload_max_filesize'))*1024*1024); ?>,
			ajax: '<?php echo get_bloginfo('siteurl');?>/wp-admin/admin-ajax.php'
		};
		</script>
        <?php				
	}
	
	/*
		add menu to admin page
	*/
	function admin_menu(){
		add_menu_page( 
			'LB Gallery', // page title
			'LB Gallery', // menu title
			'lbgallery', // cap
			LBGAL_FOLDER, // slug
			array (&$this, 'display') // function
		);		
		
		add_submenu_page( 
			LBGAL_FOLDER , // parent slug
			'Manage Gallery', // page title 
			'Manage Gallery', // menu title
			'lbgallery', // cap
			LBGAL_FOLDER, // slug
			array (&$this, 'display') // function
		);
		
		add_submenu_page( 
			LBGAL_FOLDER , // parent slug
			'Manage Category', // page title 
			'Manage Category', // menu title
			'lbgallery', // cap
			LBGAL_FOLDER . '/category', // slug
			array (&$this, 'display') // function
		);
		
		add_submenu_page( 
			LBGAL_FOLDER , // parent slug
			'Manage Images', // page title 
			'Manage Images', // menu title
			'lbgallery', // cap
			LBGAL_FOLDER . '/image', // slug
			array (&$this, 'display') // function
		);
		
		add_submenu_page( 
			LBGAL_FOLDER , // parent slug
			'Settings', // page title 
			'Settings', // menu title
			'lbgallery', // cap
			LBGAL_FOLDER . '/setting', // slug
			array (&$this, 'display') // function
		);
		
		add_submenu_page( 
			LBGAL_FOLDER , // parent slug
			'Reset/Uninstall', // page title 
			'Reset/Uninstall', // menu title
			'lbgallery', // cap
			LBGAL_FOLDER . '/reset', // slug
			array (&$this, 'display') // function
		);
	}
	/**
	*	do menu command
	*/
	function display(){		
		$pages = LBGalleryRequest::getPages();		
		if(!isset($pages[1])) $pages[1] = 'gallery';
		$controller = LBGAL_DIR.'/admin/controllers/'.$pages[1].'.php';
		
		
		
		if(file_exists($controller)){
			require_once($controller);
			$className = 'LBGalleryController'.ucfirst($pages[1]);
			if(class_exists($className)){
				new $className();				
			}else{
				_e('Class '.$className.' does not exists');
			}
		}else echo _('File is not exists');		
	}
	function on_active(){
		$role = get_role('administrator');
		if(!$role->has_cap('lbgallery')) {
			$role->add_cap('lbgallery');
		}
		require_once(LBGAL_DIR."/install.php");		
	}
	function on_deactive(){
		global $wpdb;
		
		$role = get_role('administrator');
		if($role->has_cap('lbgallery')) {
			$role->remove_cap('lbgallery');
		}
	}
}

// start
new LBGallery();