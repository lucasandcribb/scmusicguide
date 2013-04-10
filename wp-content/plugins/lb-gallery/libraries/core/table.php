<?php
class LBGalleryTable extends LBGalleryObject{
	function store($table, $data){
		global $wpdb;	
	
		$data = LBGalleryUtil::toObject($data);
	
		$query = "
			SELECT id
			FROM {$table}
			WHERE id = '".$data->id."'
		";
		$id = $wpdb->get_var($query);
		
		$query = "
			SHOW COLUMNS FROM {$table}
		";
		$result = $wpdb->get_results($query);
		$insertQuery = "";
		$updateQuery = array();
		
		$insertFields = array();
		$insertValues = array();
		
		for($i = 0, $n = count($result); $i < $n; $i++){
			$field = $result[$i]->Field;
			if(isset($data->$field) && $field != 'id'){
				$insertFields[] = '`'.$field.'`';
				
				if(is_array($data->$field))
					$val = json_encode($data->$field);
				else $val = $data->$field;
				$insertValues[] = addslashes($val);
				
				$updateQuery[] = '`'.$field."`='". addslashes($val)."'";
			}
		}
		if($id)
			$query = "UPDATE {$table} SET ".implode(",", $updateQuery) . " WHERE id = '".$id."'";
		else
			$query = "INSERT INTO {$table}(".implode(",", $insertFields).") VALUES('".implode("','", $insertValues)."')";
		$wpdb->query($query);
		return $id ? $id : $wpdb->insert_id;
	}
}