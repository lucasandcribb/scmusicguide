<?php
class LBGalleryControllerReset extends LBGalleryController{
	function empty_data(){
		global $wpdb;
		$tables = LBGalleryHelper::getTables();
		if($tables){
			foreach($tables as $table){
				$query = "
					DELETE FROM {$table->name}
				";
				$wpdb->query($query);
			}
		}
		LBGalleryCore::redirect('admin.php?page=lb-gallery/reset');
	}
	function remove(){
		global $wpdb;
		$tables = LBGalleryHelper::getTables();
		if($tables){
			foreach($tables as $table){
				$query = "
					DROP TABLE IF EXISTS {$table->name}
				";
				$wpdb->query($query);
			}
		}
		LBGalleryCore::redirect('admin.php?page=lb-gallery/reset');
	}
}