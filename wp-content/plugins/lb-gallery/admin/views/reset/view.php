<?php
class LBGalleryViewReset extends LBGalleryView{
	function __construct(){
	
	}
	function display(){
		global $wpdb, $lbgalleryAdminTemplate;
		$tpl = $lbgalleryAdminTemplate;
		$tables = LBGalleryHelper::getTables();
		
		$tpl->assignRef('tables', $tables);
		echo $tpl->fetch('reset.index');
	}
}