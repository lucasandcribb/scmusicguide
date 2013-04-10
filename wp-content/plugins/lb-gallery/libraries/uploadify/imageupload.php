<?php
global $wpdb;

if ($_FILES['images']['size'] > 0) {
	$element = $_REQUEST['element_name'] ? $_REQUEST['element_name'] : 'images';
	$gid		= $_REQUEST['gid'];
	$json         = array();
	$json['mode'] = "ajax";
	$file        = $_FILES[$element]['name'];
	$name        = (substr($file, 0, strrpos($file, '.')));
	$ext         = strtolower(substr($file, strrpos($file, '.') + 1, strlen($file)));
	$srcFile     = $_FILES[$element]['tmp_name'];
	$name = preg_replace("/\s+|\(|\)/", "_", $name);
	$filename   = $name . '.' . $ext;
	
	
	$path = LBGAL_GALLERY_DIR."/{$gid}";//.$_REQUEST['gid'];
				
	$gallery = $wpdb->get_row("SELECT * FROM {$wpdb->lbgal_gallery} WHERE id={$gid}");
	
	$params = json_decode($gallery->params);
	
	// create path to store images
	if(!is_dir($path))
		if(!mkdir($path)){}
	
	$thumbPath = $path."/thumbs";
	if(!is_dir($thumbPath))
		if(!mkdir($thumbPath)){}
					
	$targetFile = $path."/" . $filename;

	if(file_exists($targetFile)){
		$name = LBGalleryHelper::getFileName($path, $name);
		$targetFile = $path."/" . $name.".".$ext;
		$filename   = $name . '.' . $ext;
	}
	if (($ext != "jpg") && ($ext != "jpeg") && ($ext != "png") && ($ext != "gif")) {
		$json['error'][] = $file . " is not support image file";
	} else {
		if (move_uploaded_file($srcFile, $targetFile)) {			
			$userID = $_POST['user_id'];
			$thumbname = image_resize($targetFile, ($params->thumb_width > 0 ? $params->thumb_width : 100), ($params->thumb_height > 0 ? $params->thumb_height : 100), true, null, $thumbPath);
			if($thumbname) $thumbname = basename($thumbname);
			$maxOrder = $wpdb->get_var("SELECT max(ordering) FROM {$wpdb->lbgal_image} WHERE gid='{$gid}'");
			$maxOrder++;
			$data = array(
				'title' 		=> $name,
				'description' 	=> $name,
				'created'		=> time(),
				'filename'		=> LBGAL_GALLERY_URL."/{$gid}/".$filename,
				'gid'			=> $gid,
				'type'			=> 'image',
				'storage'		=> 'local',
				'provider'		=> '',
				'thumbname'		=> '',
				'ordering'		=> $wpdb->get_var("SELECT max(ordering)+1 FROM {$wpdb->lbgal_image}"),
				'author'		=> $userID
			);
			ob_start();
			print_r($data);
			echo $user->ID;
			$html = ob_get_clean();
			file_put_contents(LBGAL_DIR.'/test.txt', $html);
			LBGalleryTable::store($wpdb->lbgal_image, $data);			
		} else {
			$json['error'][] = "error(s) occured while uploading " . $file;
		}
	}
	echo json_encode($json);
	die();
}