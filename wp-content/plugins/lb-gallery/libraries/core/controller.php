<?php 
class LBGalleryController extends LBGalleryObject{
	function __construct(){
		$this->prefix = $this->getPrefix();
		$task = $_REQUEST['task'];
		if(!$task) $task = 'display';
		if(method_exists($this, $task))
			call_user_method($task, $this);
	}
	function display(){
		$view = $this->getView();
		if($view) $view->display();
	}
	function getView($viewName = null){
		if(!$viewName){
			$viewName = $this->getName();
		}
		$side = is_admin() ? 'admin' : '';
		$pluginPath = LBGalleryCore::getPluginPath();
		$viewFile = $pluginPath . DS . $side . DS . 'views' . DS . strtolower($viewName) . DS . 'view.php';

		if(file_exists($viewFile)){
			require_once($viewFile);
			$viewClass = $this->getPrefix() . 'View' . $viewName;
			$view = new $viewClass();
			return $view;
		}else{
			echo 'View file does not exists';
		}
		return null;
	}
	function getName(){
		$name = get_class($this);
		return end(explode('Controller', $name));
	}
	function getPrefix(){
		$name = get_class($this);
		return end(array_slice(explode('Controller', $name), 0, 1));
	}
}