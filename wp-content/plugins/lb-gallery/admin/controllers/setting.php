<?php
class LBGalleryControllerSetting extends LBGalleryController{
	function edit(){
		$this->display();
	}
	function save(){
		global $wpdb;
		$tabname = $_POST['tabname'];
		$cid = $_POST['cid'];
		switch($tabname){
			case 'general':
				break;
			case 'category':
				$settings = $_POST['settings']['category'];		
				/*$id = $wpdb->get_var("SELECT id FROM {$wpdb->lbgal_setting} WHERE `key`='CATEGORY_VIEW_SETTINGS'");
				$data = array(
					'id'	=> $id,
					'key' 	=> 'CATEGORY_VIEW_SETTINGS',
					'value' => json_encode($settings)
				);*/
				$data = array(
					'id' => $cid,
					'settings' => json_encode($settings)
				);

				LBGalleryTable::store($wpdb->lbgal_category, $data);
				break;
			case 'gallery':
				$settings = $_POST['settings']['gallery'];	
				
				if($cid == -1){	
					$id = $wpdb->get_var("SELECT id FROM {$wpdb->lbgal_setting} WHERE `key`='GALLERY_VIEW_SETTINGS'");
					$data = array(
						'id'	=> $id,
						'key' 	=> 'GALLERY_VIEW_SETTINGS',
						'value' => json_encode($settings)
					);
					LBGalleryTable::store($wpdb->lbgal_setting, $data);
				}else{
					$data = array(
						'id'	=> $cid,
						'gallery_settings' 	=> json_encode($settings)
					);
					LBGalleryTable::store($wpdb->lbgal_category, $data);
				}
				
				break;
			case 'global':
			default:
				$settings = $_POST['settings']['global'];	
				$id = $wpdb->get_var("SELECT id FROM {$wpdb->lbgal_setting} WHERE `key`='GLOBAL_SETTINGS'");
				$data = array(
					'id'	=> $id,
					'key' 	=> 'GLOBAL_SETTINGS',
					'value' => json_encode($settings)
				);
				LBGalleryTable::store($wpdb->lbgal_setting, $data);
				
				break;
		}
		LBGalleryCore::redirect('admin.php?page=lb-gallery/setting&tabname='.$tabname.(isset($cid) ? '&cid='.$cid : ''));
		
	}
	function upload(){
		global $wpdb;
		$media_type = $_POST['media_type'];
		switch($media_type){
			case 'image':
				$data = array(
					'title' 		=> $_POST['image_title'],
					'description' 	=> $_POST['image_description'],
					'created'		=> date('Y-m-d h:i:s'),
					'filename'		=> $_POST['image_url'],
					'gid'			=> $_POST['gid'],
					'type'			=> 'image',
					'storage'		=> 'remote',
					'ordering'		=> $wpdb->get_var("SELECT max(ordering)+1 FROM {$wpdb->lbgal_image}")
				);
				LBGalleryTable::store($wpdb->lbgal_image, $data);
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
						$data = array(
							'title' 		=> $video->title,
							'description' 	=> $video->description,
							'created'		=> date('Y-m-d h:i:s'),
							'filename'		=> $video->link,
							'gid'			=> $_POST['gid'],
							'type'			=> 'video',
							'storage'		=> 'remote',
							'provider'		=> $provider->getType(),
							'thumbname'		=> $video->thumbnail,
							'ordering'		=> $wpdb->get_var("SELECT max(ordering)+1 FROM {$wpdb->lbgal_image}")
						);
						LBGalleryTable::store($wpdb->lbgal_image, $data);
					}
				print_r($videos[0]);
				break;
			case '':
			default:
				file_put_contents(LBGAL_DIR.'/test.txt', date('d.m.Y h:i:s').'/hahaha');
				LBGalleryCore::redirect('http://localhost/wordpress/3.3.1/wp-admin/admin.php?page=lb-gallery/image&gid=1');
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
}