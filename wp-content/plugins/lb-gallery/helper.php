<?php
/**
*	Herlper class
*/
class LBGalleryHelper{
	function _defaultGallerySettings(){
		$settings = array(
			'enable_rating' => 1,
			'enable_link'	=> 1,
   			'_thumbnail'	=> array(
        		'thumb_cols' => 3,
            	'thumb_rows' => 3,
            	'col_offset' => 30,
            	'row_offset' => 30,
				'thumb_height' => '65%',
				'blocks_text' => array(
					'title' => '{TITLE}',
					'description' => '{DESCRIPTION}',
					'author' => '<strong>Created By: </strong>{AUTHOR}',
					'date' => '<strong>Created Date: </strong>{DATE}',
					'link' => 'Read More',
					'rating' => '{RATING}',
				),	
				'thumb_opacity' => 0.7,
				'thumb_hover_opacity' => 1,
				'thumb_text_effect' => 'slide-up-in',
				'border_width' => 1,
				'border_style' => 'dotted',
				'border_color' => '#303030',
				'border_spacing_topbottom' => 5,
				'border_spacing_leftright' => 5,
				'background_color' => '#F6F6F6',
				'background_image' => '',
				'order_by' => 'ordering',
				'order_dir' => 'desc'
			)
		);
		return $settings;		
	}
	function _defaultCategorySettings(){
		$settings = array(
			'gallery_rating' => 1,
			'gallery_link' => 1,
			'thumb_cols' => 3,
			'thumb_rows' => 3,
			'col_offset' => 30,
			'row_offset' => 30,
			'thumb_height' => '65%',
			'blocks' => array(
				'top' => array(
					'title' => 'title'
				),		
				'bottom' => array(
					'num_of_photos' => 'num_of_photos'
				)		
			),		
			'blocks_text' => array(
				'title' => '{TITLE}',
				'description' => '{DESCRIPTION}',
				'author' => '<strong>Author: </strong>{AUTHOR}',
				'date' => '<strong>Created: </strong>{DATE}',
				'num_of_photo' => '{NUM_OF_PHOTO} photos',
				'link' => 'Read More',
				'rating' => '{RATING}',
			),		
			'thumb_opacity' => 0.7,
			'thumb_hover_opacity' => 1,
			'thumb_text_effect' => 'slide-up-in',
			'border_width' => 1,
			'border_style' => 'dashed',
			'border_color' => '#9E9E9E',
			'border_spacing_topbottom' => 0,
			'border_spacing_leftright' => 10,
			'background_color' => '#F5F5F5',
			'background_image' => ''
		);
		return $settings;
	}
	function getSettings($key = 'GALLERY_VIEW_SETTINGS', $type = 'object'){
		static $settings;
		if(!$settings) $settings = array();
		if(isset($settings[$key])) {
			if(isset($settings[$key][$type])) return $settings[$key][$type];
			else $settings[$key] = array();
		}
		global $wpdb;
		$query = "
			SELECT `value` FROM {$wpdb->lbgal_setting} WHERE `key` = '{$key}'
		";
		$_settings = $wpdb->get_var($query);
		$_settings = ($type == 'object' ? json_decode($_settings) : LBGalleryUtil::toArray(json_decode($_settings)));
		$settings[$key][$type] = $_settings;
		return $settings[$key][$type];
	}
	function getCategorySettings($cid, $extend = null, $type = 'object'){
		global $wpdb;
		static $settings;
		if(!$settings) $settings = array();
		if($settings[$cid]) return $settings[$cid];				
		$query = "
			SELECT settings 
			FROM {$wpdb->lbgal_category} c			
			WHERE c.id = {$cid}	
		";
		$var = $wpdb->get_var($query);
		if($var){
			$gallerySettings = LBGalleryUtil::toArray(json_decode($var));							
		}else $gallerySettings = null;
		
		$_defaultSettings = LBGalleryHelper::_defaultCategorySettings();
		
		if(!is_array($gallerySettings)){
			$gallerySettings = $_defaultSettings;
		}else{
			LBGalleryHelper::_merge($gallerySettings, $_defaultSettings);
		}
		//echo '<pre>';print_r($gallerySettings);echo '</pre>';
		$settings[$cid] = $type == 'object' ? LBGalleryUtil::toObject($gallerySettings) : LBGalleryHelper::toArray($gallerySettings);
		return $settings[$cid];
	}
	function _merge(&$array1, $array2){
		foreach($array2 as $k => $v){
			if(is_array($v)){				
				LBGalleryHelper::_merge($array1[$k], $v);
			}else{
				if(!isset($array1[$k])) $array1[$k] = $v;
			}
		}
	}
	function getGallerySettingsByCat($cid, $extend = null, $type = 'object'){
		global $wpdb;
		static $settings;
		if(!$settings) $settings = array();
		if($settings[$cid]) return $settings[$cid];				
		$query = "
			SELECT gallery_settings 
			FROM {$wpdb->lbgal_category} c			
			WHERE c.id = {$cid}	
		";
		$var = $wpdb->get_var($query);
		if($var){
			$gallerySettings = LBGalleryUtil::toArray(json_decode($var));							
		}else $gallerySettings = null;
		
		$_defaultSettings = LBGalleryHelper::_defaultGallerySettings();
		
		if(!is_array($gallerySettings)){
			$gallerySettings = $_defaultSettings;
		}else{
			/*foreach($_defaultSettings as $k => $v){
				if(!isset($gallerySettings[$k])) $gallerySettings[$k] = $v;
			}*/
			
			LBGalleryHelper::_merge($gallerySettings, $_defaultSettings);
		}
		///echo '<pre>';print_r($_defaultSettings);echo '</pre>';

		$settings[$cid] = $type == 'object' ? LBGalleryUtil::toObject($gallerySettings) : LBGalleryUtil::toArray($gallerySettings);
		return $settings[$cid];
	}
	function getGallerySettings($gid, $extend = null, $type = 'object'){
		global $wpdb;
		$defaults = LBGalleryHelper::getSettings('GALLERY_VIEW_SETTINGS', 'array');
		$query = "
			SELECT c.id 
			FROM {$wpdb->lbgal_category} c
			INNER JOIN {$wpdb->lbgal_gallery} g ON g.cid = c.id
			WHERE g.id = {$gid}	
		";
		$cid = $wpdb->get_var($query);
		return LBGalleryHelper::getGallerySettingsByCat($cid, $extend, $type);
	}
	function getAllSettings(){
		global $wpdb;
		static $allSettings;
		if($allSettings) return $allSettings;
		$keys = array(
			'category' => 'CATEGORY_VIEW_SETTINGS',
			'gallery' => 'GALLERY_VIEW_SETTINGS',
			'global' => 'GLOBAL_SETTINGS',
			'rating' => 'RATING_STAR_SETTINGS',
		);
		$settings = array();
		foreach($keys as $key => $value){
			$query = "
				SELECT `value` FROM {$wpdb->lbgal_setting} WHERE `key` = '{$value}'
			";
			$var = $wpdb->get_var($query);
			$settings[$key] = json_decode($var);
		}
		if(!isset($settings['global']->lightbox)){
			$lightbox = new stdClass();
			$lightbox->theme = 'pp_default';
			$lightbox->overlay_gallery = '1';
			$lightbox->thumb_width = '50';
			$lightbox->thumb_height = '35';
			$lightbox->social_tools = 1;
			
			$settings['global']->lightbox = $lightbox;
		}
		return $settings;
	}
	function getImagesByGallery($gallery_id = null, $settings = null){
		global $wpdb;
		$allSettings = LBGalleryHelper::getAllSettings();
		if(!$settings) $settings = LBGalleryHelper::getGallerySettings($gallery_id);
		$items_per_page = $settings->_thumbnail->thumb_rows * $settings->_thumbnail->thumb_cols;
		
		if(!$settings->_thumbnail->order_by) $settings->_thumbnail->order_by = 'ordering';
		if(!$settings->_thumbnail->order_dir) $settings->_thumbnail->order_dir = 'ASC';
		
		$order = " ORDER BY " . ($settings->_thumbnail->order_by == 'random' ? ' RAND() ' : ' i.'.$settings->_thumbnail->order_by . ' ' . $settings->_thumbnail->order_dir);
		
		$query = "
			SELECT 	i.*, if(r.rating_type != null, r.rating_type, 'image') as rating_type, 
					count(r.id) as votes, sum(r.rating_value)/count(r.id) as rating,
					u.".$allSettings['global']->author_field." as author_name
			FROM {$wpdb->lbgal_image} i			
			LEFT JOIN {$wpdb->lbgal_rating} r ON i.id = r.ref_id and r.rating_type='image'
			INNER JOIN {$wpdb->users} u ON u.ID=i.author
			INNER JOIN {$wpdb->lbgal_gallery} g ON i.gid = g.id
			WHERE i.status = 1 AND g.published = 1
			GROUP BY i.id
			HAVING 1
			".($gallery_id ? " AND gid={$gallery_id}" : "")."
			".$order;	
				
		/*$thumb_width = floor(($settings->gallery_width - ($settings->_thumbnail->thumb_cols - 1) * $settings->_thumbnail->col_offset)/$settings->_thumbnail->thumb_cols);		
		$settings->_thumbnail->thumb_width = $thumb_width;
				
		if(strpos($settings->_thumbnail->thumb_height, '%')!==false){
			$thumb_height = (floor($settings->_thumbnail->thumb_height) / 100)*$thumb_width;
		}else{
			$thumb_height = floor($settings->_thumbnail->thumb_height);
		}
		$settings->_thumbnail->thumb_height = $thumb_height;
			*/
		if($images = $wpdb->get_results($query)){
			foreach($images as $k => $img){
				$images[$k] = LBGalleryHelper::getImage($img, $settings);				
			}
		}
		return $images;
	}
	function getImage($item, $settings = null){
		if(is_numeric($item)){
			global $wpdb;
			$query = "
				SELECT 	i.*, if(r.rating_type != null, r.rating_type, 'image') as rating_type, 
						count(r.id) as votes, sum(r.rating_value)/count(r.id) as rating,
						u.user_nicename
				FROM {$wpdb->lbgal_image} i			
				LEFT JOIN {$wpdb->lbgal_rating} r ON i.id = r.ref_id and r.rating_type='image'
				INNER JOIN {$wpdb->users} u ON u.ID=i.author
				INNER JOIN {$wpdb->lbgal_gallery} g ON i.gid = g.id
				GROUP BY i.id
				HAVING id={$item}
			";		
			$item = $wpdb->get_row($query);
		}
		if(!$settings){
			$settings = LBGalleryHelper::getGallerySettings($item->gid);
			$thumb_width = floor(($settings->width - ($settings->_thumbnail->thumb_cols - 1) * $settings->_thumbnail->col_offset)/$settings->_thumbnail->thumb_cols);
					
			if(strpos($settings->_thumbnail->thumb_height, '%')!==false){
				$thumb_height = (floor($settings->_thumbnail->thumb_height) / 100)*$thumb_width;
			}else{
				$thumb_height = floor($settings->_thumbnail->thumb_height);
			}
			$settings->_thumbnail->thumb_width = $thumb_width;
			$settings->_thumbnail->thumb_height = $thumb_height;			
		}
		$settings->image_view = 'thumbnail';
		$tw = $settings->image_view == 'thumbnail' ? $settings->_thumbnail->thumb_width : $settings->_filmstrip->thumb_width;
		$th = $settings->image_view == 'thumbnail' ? $settings->_thumbnail->thumb_height : $settings->_filmstrip->thumb_height;
		
		if($item->type == 'image'){
			if(preg_match('!^https?:\/\/!', $item->filename)){
				$fullsrc = $item->filename;
			}else{
				$fullsrc = $item->storage == 'local' ? LBGAL_GALLERY_URL . '/' . $item->gid . '/' . $item->filename : $item->filename;
			}
			$thumbsrc = $item->thumbname ? $item->thumbname : $fullsrc;
			if(preg_match('!^https?:\/\/!', $thumbsrc)){
			}else{
				$thumbsrc = $item->storage == 'local' ? LBGAL_GALLERY_URL . '/' . $item->gid . '/thumbs/' . $thumbsrc : $item->thumbname;
			}
			$thumbsrc = LBGAL_URL . '/timthumb.php?src=' . base64_encode($thumbsrc) . '&w='.($tw).'&h='.($th);
			$item->fullsrc = $fullsrc;
			$item->thumbsrc = $thumbsrc;
		}else if($item->type == 'video'){
			$thumbsrc = LBGAL_URL . '/timthumb.php?src=' . base64_encode($item->thumbname) . '&w='.$tw.'&h='.$th;
			$item->thumbsrc = $thumbsrc;
			$item->fullsrc = $item->filename;
		}
		$item->rating = is_null($item->rating) ?  '0.0' : sprintf('%1.1f', $item->rating);
		return $item;
	}
	function getGallery($gid){
		global $wpdb;
		$query = "
			SELECT i.*, if(r.rating_type, r.rating_type, 'gallery') as rating_type, count(r.id) as votes, sum(r.rating_value)/count(r.id) as rating
			FROM {$wpdb->lbgal_gallery} i
			LEFT JOIN {$wpdb->lbgal_rating} r ON i.id = r.ref_id and r.rating_type='gallery'
			WHERE i.published = 1
			GROUP BY i.id
			HAVING id = {$gid}
			ORDER BY i.id ASC
		";
		if($gallery = $wpdb->get_row($query)){
			$gallery->votes = sprintf('%d', $gallery->votes);
			$gallery->rating = sprintf('%1.1f', $gallery->rating);
		}
		return $gallery;
	}
	function getThumbnailTextHTML($item, $settings, $echo = true){
		ob_start();
		?>
		<div class="thumbnail-text <?php echo in_array($settings->_thumbnail->thumb_text_effect, array('slide_up', 'slide_down', 'slide_left', 'slide_right', 'fade_in')) ? 'inner' : '';?> <?php echo $item->type;?>">
            <?php if(in_array($settings->_thumbnail->thumb_text, array('title', 'title_desc'))){?>
            <h3><?php echo $item->title;?></h3>
            <?php }?>
            <?php if(in_array($settings->_thumbnail->thumb_text, array('description', 'title_desc'))){?>
            <p><?php echo $item->description;?></p>
            <?php }?>
        </div>
        <?php $html = ob_get_clean();
		if($echo) echo $html;
		else return $html;
	}
	function getNavigationHTML($total, $options = array('limit' => 10, 'paged' => 1)){		
		$page = $options['paged'] > 0 ? $options['paged'] : 1;
		$limit = $options['limit'];
		$limit = $limit ? $limit : 10;		
		$total_pages = round($total / $limit);
		if($total - $total_pages * $limit > 0) $total_pages++;
		
		$big = 999999999;
		return paginate_links( array(
			'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $page ),
			'total' => $total_pages
		) );
	}
	function getTables(){
		global $wpdb;
		static $tables;
		if($tables) return $tables;
		
		$vars = get_object_vars($wpdb);
		$tables = array();
		foreach($vars as $var => $value){		
			if(strpos($var, 'lbgal_') === 0){
				$tableInfo = new stdClass();
				$tableInfo->name = $wpdb->$var;
				$tableInfo->rows_count = $wpdb->get_var("SELECT count(*) FROM ".$wpdb->$var);
				
				$query = "
					SELECT table_name
					FROM  INFORMATION_SCHEMA.`TABLES` 
					WHERE table_name = '{$tableInfo->name}'
					AND TABLE_SCHEMA = '".DB_NAME."'
				";
				$tableInfo->exists = $wpdb->get_var($query) ? 1 : 0;
				$tables[$wpdb->$var] = $tableInfo;
				
			}
		}
		return $tables;
	}
	function getFileName($dir, $name){
		$return = $name;
		if ($handle = opendir($dir)) {
			$files = array();
			while (false !== ($file = readdir($handle))) {
				if( 0 == strpos($file, $name)){
					$files[] = substr($file, 0, strrpos($file, '.'));
				}
			}	
			$i = 0;
			while(true){
				$i++;
				$return = $name."-".$i;
				if(!in_array($return, $files)){
					break;
				}
				if($i>=1000) break;
			}		
			closedir($handle);
		}
		return $return;
	}
	function isLocalPath($path){
		return preg_match('!'.get_bloginfo('siteurl').'!', $path);
	}
	function getRemoteImage($src, $localpath){
		$data = @file_get_contents($src);
		$tempname = tempnam(LBGAL_TMP_DIR, '');
		file_put_contents($tempname, $data);	
		$sData = getimagesize($tempname);
		$mimeType = $sData['mime'];						
		$filename = md5(time().rand());
		$newname = $localpath.'/'.$filename;
		if(!is_dir( $localpath )) {
			mkdir( $localpath, 0777);
		}
		$error = false;
		switch ($mimeType) {
			case 'image/jpeg':
				$canvas = imagecreatefromjpeg ($tempname);				
				$filename .= '.jpg';
				imagejpeg($canvas, $localpath.'/'.$filename, 100); 
				break;
		
			case 'image/png':
				$canvas = imagecreatefrompng ($tempname);
				$filename .= '.png';
				imagepng($canvas, $localpath.'/'.$filename, floor(100 * 0.09));
				break;
		
			case 'image/gif':
				$canvas = imagecreatefromgif ($tempname);
				$filename .= '.gif';
				imagegif($canvas, $localpath.'/'.$filename);
				break;
			default:
				$error = true;
		}	
		unlink($tempname);
		if($error) return null;
		return array('path' => $localpath.'/'.$filename, 'name' => $filename);
	}
}
?>