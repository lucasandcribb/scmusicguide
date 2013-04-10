<?php
class LBGalleryTemplate extends LBGalleryObject{
	var $_vars;
	var $side 		= 'admin';
	var $template 	= 'default';
	var $plugin 	= '';
	function __construct($options = array()){
		$this->template = $tpl;
		if(count($options))
			foreach($options as $key => $value) $this->$key = $value;
		add_action('wp_head', array($this, 'addHeader'));
		//if($file) $this->file = $file;
	}
	function addHeader(){
		wp_register_style($this->template . '-style', get_bloginfo('siteurl') . '/wp-content/plugins/' . $this->plugin . '/' . $this->side . '/templates/' . $this->template . '/style.css');
		
		wp_print_styles(array(
			$this->template . '-style'
		));
		
		wp_register_script($this->template . '-script', get_bloginfo('siteurl') . '/wp-content/plugins/' . $this->plugin . '/' . $this->side . '/templates/' . $this->template . '/script.js');
		
		wp_print_scripts(array(
			$this->template . '-script'
		));
		
	}
	function set($name, $value){
		$this->_vars[$name] = $value;
	}
	function fetch($file, $pluginName = null, $tpl = 'default', $side = 'admin'){
		if($file) $this->file = $file;
		if($this->_vars){
			extract($this->_vars, EXTR_REFS);
		}
		$pages = LBGalleryRequest::getPages();
		if(!$pluginName) $pluginName = $pages[0];
		//$side = !$side ? (is_admin() ? 'admin' : 'site') : $side;
	
		$tplPath = ($this->side == 'admin' ? LBGalleryCore::getAdminTemplatePath($this->plugin) : LBGalleryCore::getTemplatePath($this->plugin, 'site')) . DS . $this->template . DS .$this->file . '.php';
		if(!file_exists($tplPath)){
			echo ('Template file does not exists!');
			return;
		}
		ob_start();                  // Start output buffering
	    require($tplPath);                // Include the file
	    $contents = ob_get_contents(); // Get the contents of the buffer
	    ob_end_clean();                // End buffering and discard
		return $contents;
	}
	function assignRef($name, $value){
		$this->$name = $value;
	}
}