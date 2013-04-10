<?php
class LBGalleryControllerGallery extends LBGalleryController{
	function __construct(){
		parent::__construct();
	}
	function display(){
		$view = $this->getView();
		$view->display();
	}
	function edit(){
		$view = $this->getView();
		$view->edit();
	}
	function save(){
		$gid = $this->store();
		wp_redirect('admin.php?page=lb-gallery');
	}
	function apply(){
		$gid = $this->store();
		wp_redirect('admin.php?page=lb-gallery&task=edit&gid='.$gid);
	}
	function save_new(){
		$gid = $this->store();
		wp_redirect('admin.php?page=lb-gallery&task=edit&gid=0');
	}
	function save_upload(){
		$gid = $this->store();
		wp_redirect('admin.php?page=lb-gallery/image&gid='.$gid);
	}
	function store(){
		global $wpdb;
		$gallery = $_POST['gallery'];
		
		/*$query = "
			SELECT `settings`
			FROM {$wpdb->lbgal_category}
			WHERE `id` = '".$gallery['cid']."'
		";
		$gallery['settings'] = $wpdb->get_var($query);
		*/
		$gallery['ordering'] = $wpdb->get_var("SELECT max(ordering)+1 as ordering FROM {$wpdb->lbgal_gallery}");
		$gallery['created'] = time();
		$user = wp_get_current_user();
		$gallery['author'] = $user->ID;
		return LBGalleryTable::store($wpdb->lbgal_gallery, $gallery);
	}
	function cancel(){
		wp_redirect('admin.php?page=lb-gallery');
	}
	function active(){
		global $wpdb;
		$id = $_REQUEST['gid'];	
		settype($id, 'array');	
		$wpdb->query("UPDATE {$wpdb->lbgal_gallery} SET published=1 WHERE id IN(".(implode(',', $id)).")");
		$gid = $_REQUEST['gid'];
		
		LBGalleryCore::redirect('admin.php?page=lb-gallery');		
	}
	function deactive(){
		global $wpdb;
		$id = $_REQUEST['gid'];		
		settype($id, 'array');
		$wpdb->query("UPDATE {$wpdb->lbgal_gallery} SET published=0 WHERE id IN(".(implode(',', $id)).")");
		$gid = $_REQUEST['gid'];
		LBGalleryCore::redirect('admin.php?page=lb-gallery');
	}
	function remove(){
		global $wpdb;
		$id = $_REQUEST['gid'];	
		settype($id, 'array');	
		$wpdb->query("DELETE FROM {$wpdb->lbgal_gallery} WHERE id IN(".(implode(',', $id)).")");
		LBGalleryCore::redirect('admin.php?page=lb-gallery');
	}
}