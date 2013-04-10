<?php
class LBGalleryControllerCategory extends LBGalleryController{
	function edit(){
		$this->display();
	}
	function remove(){
		global $wpdb;
		$cid = $_POST['cid'];
		$query = "
			DELETE 
			FROM {$wpdb->lbgal_category}
			WHERE id IN(".implode(',', $cid).")
		";
		$wpdb->query($query);
		LBGalleryCore::redirect('admin.php?page=lb-gallery/category');
	}
	function save(){
		global $wpdb;
		$category = $_POST['category'];

		$settings = LBGalleryHelper::_defaultCategorySettings();
		$category['settings'] = json_encode($settings);
		

		$settings = LBGalleryHelper::_defaultGallerySettings();
		$category['gallery_settings'] = json_encode($settings);

		
		$category['created'] = date('Y-m-d h:i:s');
		LBGalleryTable::store($wpdb->lbgal_category, $category);
		LBGalleryCore::redirect('admin.php?page=lb-gallery/category');
	}
	function save_new(){
		global $wpdb;
		$category = $_POST['category'];
		unset($category['id']);
		$query = "
			SELECT `value`
			FROM {$wpdb->lbgal_setting}
			WHERE `key` = 'GALLERY_VIEW_SETTINGS'
		";
		$category['settings'] = $wpdb->get_var($query);
		$category['created'] = date('Y-m-d h:i:s');
		LBGalleryTable::store($wpdb->lbgal_category, $category);
		LBGalleryCore::redirect('admin.php?page=lb-gallery/category');
	}
	function cancel(){
		LBGalleryCore::redirect('admin.php?page=lb-gallery/category');
	}
}