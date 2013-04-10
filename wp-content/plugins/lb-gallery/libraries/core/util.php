<?php
class LBGalleryUtil{
	function canToObject($array){
		$toObject = true;
		foreach ($array as $name => $value) {
			$name = strtolower(trim($name));			 
			if(is_numeric($name)){
				$toObject = false;
				break;
			}
		}
		return $toObject;
	}
	function toObject($array){
		if(!is_array($array)) {
			return $array;
		}
		
		$object = new stdClass();
		if (is_array($array) && count($array) > 0) {
			if(LBGalleryUtil::canToObject($array)){
				foreach ($array as $name=>$value) {
					$name = strtolower(trim($name));			 
					if (!empty($name)) {
						$object->$name = LBGalleryUtil::toObject($value);
					}
				}
				return $object; 
			}else{
				return $array;
			}
		}
		else {
			return FALSE;
		}
	}
	function toArray($object){
		if(!is_object($object) && !is_array($object))
			return $object;
		
		$array=array();
		foreach($object as $member=>$data){
			$array[$member]=LBGalleryUtil::toArray($data);
		}
		return $array;
	}
}