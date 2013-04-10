<?php
$root = dirname(dirname(dirname(LBGAL_DIR)));
//require_once($root.'/wp-load.php');
$user = wp_get_current_user();
require_once($root.'/wp-admin/includes/admin.php');
global $wpdb;
if ($_FILES['images']['size'] > 0) {
	$json         = array();
	$json['mode'] = "ajax";	
	$json['error'] = array();
	$fileName =  $_FILES['images']['name'];

	if(!$fileName) return;
	$sourcePath = $_FILES['images']['tmp_name'];
	$uploadPath = LBGAL_TMP_DIR;
	
	$ext = array_pop(explode(".", $fileName));

	$allows= array("zip");
	
	if(!in_array($ext, $allows)){ die();}
	
	if(move_uploaded_file($sourcePath, $uploadPath."/".$fileName)){

		WP_Filesystem();
		$basename = basename($fileName, '.zip');
		//rmdirr($uploadPath."/".$basename);
		$result = unzip_file($uploadPath."/".$fileName, $uploadPath."/".$basename);
		if($files = list_files($uploadPath."/".$basename)){
			
			$gid = $_REQUEST['gid'];
			$gpath = LBGAL_GALLERY_DIR."/{$gid}";	
			$gallery = $wpdb->get_row("SELECT * FROM {$wpdb->lbgal_gallery} WHERE id={$gid}");			
			$params = json_decode($gallery->params);
			
			if(!is_dir($gpath))
				if(!mkdir($gpath)){}
			
			$thumbPath = $gpath."/thumbs";
			if(!is_dir($thumbPath))
				if(!mkdir($thumbPath)){}
			$image_allow = array("jpg", "jpeg", "png", "gif", "bmp");
			$userID = $_POST['user_id'];
			foreach($files as $file){
				$file = str_replace("\\", "/", $file);
				$name = (substr($file, strrpos($file, '/')+1));
				$name = substr($name, 0, strrpos($name, '.'));
				$ext  = strtolower(substr($file, strrpos($file, '.') + 1, strlen($file)));
				$name = preg_replace("/\s+|\(|\)/", "_", $name);
				$targetFile = $gpath."/" . $name . '.' . $ext;

				if(file_exists($targetFile)){
					$name = LBGalleryHelper::getFileName($path, $name);
					$targetFile = $path."/" . $name.".".$ext;	
					$filename   = $name . '.' . $ext;			
				}
				
				
				if (!in_array($ext, $image_allow)) {
					$json['error'][] = $file . " is not support image file";
				} else {
					echo $file; echo ",", $targetFile,"\n";
					if(@copy($file, $targetFile)){
						$data = array(
							'title' 		=> $name,
							'description' 	=> $name,
							'created'		=> time(),
							'filename'		=> LBGAL_GALLERY_URL."/{$gid}/".$name.'.'.$ext,
							'gid'			=> $gid,
							'type'			=> 'image',
							'storage'		=> 'local',
							'provider'		=> '',
							'thumbname'		=> '',
							'ordering'		=> $wpdb->get_var("SELECT max(ordering)+1 FROM {$wpdb->lbgal_image}"),
							'author'		=> $userID
						);
						LBGalleryTable::store($wpdb->lbgal_image, $data);
						$json['sql']=$sql;
					}
				}
			}
		}	
	}		
}
die();
?>