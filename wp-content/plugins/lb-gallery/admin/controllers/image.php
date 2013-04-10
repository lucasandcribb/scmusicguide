<?php
class LBGalleryControllerImage extends LBGalleryController{
	function edit(){
		$this->display();
	}
	function save(){
		global $wpdb;
		$category = $_POST['category'];
		LBGalleryTable::store($wpdb->lbgal_category, $category);
		wp_redirect('admin.php?page=lb-gallery/category');
	}
	function saveall(){
		global $wpdb;
		$IDs = $_POST['iid'];
		$rowData = $_POST['rows'];
		settype($IDs, 'array');
		
		if($n = count($IDs)){
			$titles = array();
			$descriptions = array();
			$filenames = array();
			$thumbnails = array();
			foreach($IDs as $id){
				$titles[] = "WHEN $id THEN '".$rowData[$id]['title']."'";
				$descriptions[] = "WHEN $id THEN '".$rowData[$id]['description']."'";
				$filenames[] = "WHEN $id THEN '".$rowData[$id]['filename']."'";
				$thumbnails[] = "WHEN $id THEN '".$rowData[$id]['thumbname']."'";
			}
			$query = "
				UPDATE {$wpdb->lbgal_image}
				SET title = CASE id
					".implode("\n", $titles)."
				END,
				description = CASE id
					".implode("\n", $descriptions)."
				END,
				filename = CASE id
					".implode("\n", $filenames)."
				END,
				thumbname = CASE id
					".implode("\n", $thumbnails)."
				END
				WHERE id IN(".implode(',', $IDs).")
			";
			$wpdb->query($query);
		}
		LBGalleryCore::redirect('admin.php?page=lb-gallery/image&gid='.$_POST['gid']);
		//echo '<pre>';print_r($IDs);echo '</pre>';
		die();
	}
	function upload(){
		global $wpdb;
		$media_type = $_POST['media_type'];
		$user = wp_get_current_user();
		switch($media_type){
			case 'image':
				//if($filename = LBGalleryHelper::getRemoteImage($_POST['image_url'], LBGAL_GALLERY_DIR.'/'.$_POST['gid'])){
					$data = array(
						'title' 		=> $_POST['image_title'],
						'description' 	=> $_POST['image_description'],
						'filename'		=> $_POST['image_url'],//LBGAL_GALLERY_URL.'/'.$_POST['gid'].'/'.$filename['name'],
						'thumbname'		=> $_POST['thumb_url'],
						'gid'			=> $_POST['gid'],
						'type'			=> 'image',
						'storage'		=> 'remote',
						'ordering'		=> $wpdb->get_var("SELECT max(ordering)+1 FROM {$wpdb->lbgal_image}"),
						'created'		=> time(),
						'author'		=> $user->ID,
						'linkto'		=> $_POST['image_linkto']
					);
					
					LBGalleryTable::store($wpdb->lbgal_image, $data);
				//}
				break;
			case 'video':
				if(!class_exists('LBGalleryVideo')){
					require_once(LBGAL_LIBS . '/video.php');
				}
				$video = new LBGalleryVideo();
				$provider = $video->getProvider($_POST['video_url'], $_REQUEST['video_url_type']);
				$videos = $provider->getItems();
				
				if($videos)
					foreach($videos as $video){
						//$filename = LBGalleryHelper::getRemoteImage($_POST['video_thumb'] ? $_POST['video_thumb'] : $video->thumbnail, LBGAL_GALLERY_DIR.'/'.$_POST['gid']);
						$data = array(
							'title' 		=> $_POST['video_title'] ? $_POST['video_title'] : $video->title,
							'description' 	=> $_POST['video_description'] ? $_POST['video_description'] : $video->description,
							'filename'		=> $video->link,
							'gid'			=> $_POST['gid'],
							'type'			=> 'video',
							'storage'		=> 'remote',
							'provider'		=> $provider->getType(),
							'thumbname'		=> $_POST['video_thumb'] ? $_POST['video_thumb'] : $video->thumbnail,//LBGAL_GALLERY_URL.'/'.$_POST['gid'].'/'.$filename['name'],
							'ordering'		=> $wpdb->get_var("SELECT max(ordering)+1 FROM {$wpdb->lbgal_image}"),
							'created'		=> time(),
							'author'		=> $user->ID,
							'linkto'		=> $_POST['video_linkto']
						);
						LBGalleryTable::store($wpdb->lbgal_image, $data);
					}
				break;
			case '':
			default:
				break;
		}
		exit();
	}
	function active(){
		global $wpdb;
		$id = $_REQUEST['iid'];		
		$wpdb->query("UPDATE {$wpdb->lbgal_image} SET status=1 WHERE id IN(".(implode(',', $id)).")");
		$gid = $_REQUEST['gid'];
		
		LBGalleryCore::redirect('admin.php?page=lb-gallery/image'.($gid ? '&gid=' . $gid : ''));		
	}
	function deactive(){
		global $wpdb;
		$id = $_REQUEST['iid'];		
		$wpdb->query("UPDATE {$wpdb->lbgal_image} SET status=0 WHERE id IN(".(implode(',', $id)).")");
		$gid = $_REQUEST['gid'];
		LBGalleryCore::redirect('admin.php?page=lb-gallery/image'.($gid ? '&gid=' . $gid : ''));
	}
	function remove(){
		global $wpdb;
		$id = $_REQUEST['iid'];		
		$wpdb->query("DELETE FROM {$wpdb->lbgal_image} WHERE id IN(".(implode(',', $id)).")");
		$gid = $_REQUEST['gid'];
		LBGalleryCore::redirect('admin.php?page=lb-gallery/image'.($gid ? '&gid=' . $gid : ''));
	}
	function featured(){
		global $wpdb;
		$gid = $_REQUEST['gid'];
		$id = $_REQUEST['iid'][0];		
		$query = "UPDATE {$wpdb->lbgal_gallery} SET featured_image = '{$id}' WHERE id = {$gid}";
		$wpdb->query($query);
		LBGalleryCore::redirect('admin.php?page=lb-gallery/image'.($gid ? '&gid=' . $gid : ''));
	}
}