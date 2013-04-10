<?php
class LBGalleryViewSetting extends LBGalleryView{
	function __construct(){
			
	}
	function display(){
		global $wpdb, $lbgalleryAdminTemplate;
		$tpl = $lbgalleryAdminTemplate;
		$tabName = $_REQUEST['tabname'] ? $_REQUEST['tabname'] : 'global';
		$cid = $_REQUEST['cid'];
		if(!$cid){
			$query = "
				SELECT min(id) FROM {$wpdb->lbgal_category}
			";
			$cid = $wpdb->get_var($query);
		}
		switch($tabName){
			case 'general':
				break;
			case 'category':				
				$query = "
					SELECT *
					FROM {$wpdb->lbgal_category}
				";
				
				$lists['gallery'] = '<select name="cid" id="filters_gid" onchange="this.form.submit();">';
				if($categories = $wpdb->get_results($query)){
					foreach($categories as $category){
						$query = "
							SELECT *
							FROM {$wpdb->lbgal_gallery}
							WHERE cid={$category->id}
						";
						$galleries = $wpdb->get_results($query);
						$n = count($galleries);
						$lists['gallery'] .= '<option value="'.$category->id.'" class="lbgal-catname-option"'.($category->id==$cid ? ' selected="selected"' : '').'>'.($category->name?$category->name:'[No Title]').' (' .$n.' galleries)</option>';						
					}
				}
				$lists['gallery'] .= '</select>';
				$settings = LBGalleryHelper::getCategorySettings($cid);
				/*$query = "
						SELECT `settings` FROM {$wpdb->lbgal_category} WHERE `id` = '$cid'
					";
				if($settings = $wpdb->get_var($query)){
					
					$settings = json_decode($settings);
				}else{						
					$query = "
						SELECT `value` FROM {$wpdb->lbgal_setting} WHERE `key` = 'CATEGORY_VIEW_SETTINGS'
					";
					$settings = json_decode($wpdb->get_var($query));
				}*/
				break;
			case 'gallery':
				
				$query = "
					SELECT *
					FROM {$wpdb->lbgal_category}
				";
				
				$lists['gallery'] = '<select name="cid" id="filters_gid" onchange="this.form.submit();">';
				//$lists['gallery'] .= '<option value="-1">'.__('GLOBAL SETTINGS', 'lb-gallery').'</option>';
				if($categories = $wpdb->get_results($query)){
					foreach($categories as $category){
						$query = "
							SELECT *
							FROM {$wpdb->lbgal_gallery}
							WHERE cid={$category->id}
						";
						$galleries = $wpdb->get_results($query);
						$n = count($galleries);
						$lists['gallery'] .= '<option value="'.$category->id.'" class="lbgal-catname-option"'.($category->id==$cid ? ' selected="selected"' : '').'>'.($category->name?$category->name:'[No Title]').' (' .$n.' galleries)</option>';
						if($n){
							foreach($galleries as $gal){
								$lists['gallery'] .= '<option value="'.$gal->id.'"'.($gal->id==$gid ? ' selected="selected"' : '').' disabled="disabled">&nbsp;&nbsp;&nbsp;&nbsp;'.($gal->title?$gal->title:'[No Title]').'</option>';
							}
						}
						//$lists['gallery'] .= '</optgroup>';
					}
				}
				$lists['gallery'] .= '</select>';
				/*$query = "
					SELECT `value` FROM {$wpdb->lbgal_setting} WHERE `key` = 'GALLERY_VIEW_SETTINGS'
				";
				$defaultSettings = json_decode($wpdb->get_var($query));
				
				if($cid == -1){
					$settings = $defaultSettings;
				}else{				
					$defaultSettings = LBGalleryUtil::toArray($defaultSettings);
					$query = "
						SELECT `gallery_settings` FROM {$wpdb->lbgal_category} WHERE `id` = '$cid'
					";
					$settings = json_decode($wpdb->get_var($query));
					if(!is_object($settings))
						$settings = array();
					else
						$settings = LBGalleryUtil::toArray($settings);
					$settings = $settings + $defaultSettings;
					$settings = LBGalleryUtil::toObject($settings);
				}*/
				$settings = LBGalleryHelper::getGallerySettingsByCat($cid);
				//$settings->_thumbnail->border_spacing_topbottom=100;
				//echo '<pre>';print_r($settings);echo '</pre>';
				break;
			case 'global':
			default:		
				$allSettings = LBGalleryHelper::getAllSettings();		
				$settings = $allSettings['global'];
				break;
		}				
		$tpl->set('lists', $lists);
		$tpl->assignRef('settings', $settings);
		$tpl->assignRef('tabName', $tabName);		
		echo $tpl->fetch('setting.index');
	}	
}