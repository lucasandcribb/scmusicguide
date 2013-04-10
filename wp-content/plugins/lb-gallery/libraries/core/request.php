<?php
class LBGalleryRequest{
	static $key;
	function setKey($key){
		if (!session_id())
			session_start();
		if(!isset($_SESSION[$key]))
			$_SESSION[$key] = '';
		self::$key = $key;
	}
	function parseQuery(){
		
	}
	function getPages(){
		$page = $_GET['page'];
		$parts = split('/', $page);
		$pages = array();
		for($i = 0, $n = count($parts); $i < $n; $i++){
			if($part = trim($parts[$i])) $pages[] = $part;
		}
		return $pages;
	}
	function getUserStateFromRequest($key, $request, $default, $type = null){
		$old_state = LBGalleryRequest::getUserState( $key );
		$cur_state = (!is_null($old_state)) ? $old_state : $default;
		$new_state = LBGalleryRequest::getRequest($request, null);
	
		// Save the new value only if it was set in this request
		if ($new_state !== null) {
			LBGalleryRequest::setUserState($key, $new_state);
		} else {
			$new_state = $cur_state;
		}
	
		return $new_state;
	}
	
	function getUserState($key, $default = null){
		$states = json_decode($_SESSION[self::$key]);
		return $states->$key ? $states->$key : $default;
	}
	
	function setUserState($key, $value){
		$states = json_decode($_SESSION[self::$key]);
		if(!states) $states = new stdClass();
		$states->$key = $value;
		$_SESSION[self::$key] = json_encode($states);
	}
	
	function getRequest($key, $default = ""){
		return $_REQUEST[$key] ? $_REQUEST[$key] : $default;
	}
}