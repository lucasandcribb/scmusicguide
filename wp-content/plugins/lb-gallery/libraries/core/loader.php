<?php
// check if core is loaded
if(!defined('LBCORE_LOADED')){
	define('LBCORE_LOADED', 1);
	define('LBCORE_PATH', dirname(__FILE__));
	define('DS', '/');
	$libraryPath = dirname(__FILE__);
	$DS			= '/';	
	require_once($libraryPath . DS . 'object.php');	
	require_once($libraryPath . DS . 'core.php');	
	require_once($libraryPath . DS . 'controller.php');
	require_once($libraryPath . DS . 'view.php');
	require_once($libraryPath . DS . 'template.php');	
	require_once($libraryPath . DS . 'helper.php');	
	require_once($libraryPath . DS . 'table.php');	
	require_once($libraryPath . DS . 'util.php');	
	require_once($libraryPath . DS . 'request.php');	
	
	add_action('admin_head', 'lbcore_admin_head');
	function lbcore_admin_head(){
		$path = str_replace(array("\\", "loader.php"), array('\/', 'js/lb.js'), end(explode('wp-content', __FILE__)));
		wp_register_script('lbcore_js', '/wp-content' . $path);//get_option('siteurl') . 'lb.js');
		wp_print_scripts(array(
			'lbcore_js'
		));
	}
}