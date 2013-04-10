<?php
function current_plugin(){
	global $lbPlugin;
	echo '<pre>';print_r($lbPlugin);echo '</pre>';
}
class LBGalleryCore extends LBGalleryObject{
	static $_plugins = array();
	function addPlugin($name, $path){
		self::$_plugins[$name] = $path;
	}
	function getAdminTemplatePath($pluginName = null){
		global $lbPlugin;
		if(!$pluginName) $pluginName = $_REQUEST['page'];
		return self::$_plugins[$pluginName] . DS . 'admin' . DS . 'templates';
	}
	function getTemplatePath($pluginName = null, $side = null){
		if(!$pluginName) $pluginName = $_REQUEST['page'];
		return self::$_plugins[$pluginName] . DS . (!$side ? (is_admin() ? 'admin' : 'site') : $side) . DS . 'templates';
	}
	function getPluginPath($name = null){
		$pages = LBGalleryRequest::getPages();
		return self::$_plugins[$pages[0]];
	}
	function redirect($url){
		if(headers_sent()){
			echo '<script type="text/javascript">location.href=\''.$url.'\'</script>';
		}else{
			wp_redirect($url);
		}
	}
}