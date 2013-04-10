<?php
class LBGalleryShortcode{
	var $tpl = null;
	function __construct(){
		global $lbgallerySiteTemplte;
		$this->tpl = $lbgallerySiteTemplte;
	}
	function display($atts){
		ob_start();
		$atts = shortcode_atts(array(
			'listview' 		=> 'gallery',
			'cid'		=> null,
			'gid'		=> null,
			'width'		=> '100%',
			'show_top_bar' => 1,
			'show_bottom_bar' => 0,
			'show_category_dropdown' => 1,
			'show_gallery_dropdown' => 1,
			'show_back_gallery_button' => 1
			
		), $atts);
		
		$atts = LBGalleryUtil::toObject($atts);
		global $wpdb, $lbgallerySiteTemplte;
		$tpl = $lbgallerySiteTemplte; // shortent
		
		// get default category
		if(!$atts->cid){
			$query = "
				SELECT id FROM {$wpdb->lbgal_category} ORDER BY name LIMIT 0, 1
			";
			$atts->cid = $wpdb->get_var($query);
		}
		// get default gallery
		if(!$atts->gid){
			$query = "
				SELECT id FROM {$wpdb->lbgal_gallery} ORDER BY title LIMIT 0, 1
			";
			$atts->gid = $wpdb->get_var($query);
		}
		if(preg_match('!^[0-9]+$!', $atts->width)){
			$atts->width .= 'px';
		}
		$allSettings = LBGalleryHelper::getAllSettings();
		$settingsKey = uniqid('lbgalSettings_');
		$elemId = uniqid('lbgallery_');
		$tpl->assignRef('elemId', $elemId);
		$tpl->assignRef('shortcode', $atts);
		$tpl->assignRef('allSettings', $allSettings);
		echo $tpl->fetch('shortcode.main');
		?>
        <script type="text/javascript">
		<?php
		
		$allSettings = LBGalleryHelper::getAllSettings();
		$allSettings['shortcode'] = new stdClass();
		foreach($atts as $prop=>$val){
			$allSettings['shortcode']->$prop = $atts->$prop;
		}
		?>
		var <?php echo $settingsKey;?> = <?php echo str_replace('}', ' }', json_encode($allSettings));?>;
		jQuery(function($){
			$('.lb-gallery#<?php echo $elemId;?>').lbGallery(<?php echo $settingsKey;?>);
		});
		</script>
        <?php
		return ob_get_clean();
	}
	function ajax_load_galleries($cid = null){
		global $wpdb;
		$cid = $cid ? $cid : $_REQUEST['cid'];
		$gid = $_REQUEST['gid'];		
		if($gid && !$cid){
			$cid = $wpdb->get_var("SELECT cid FROM {$wpdb->lbgal_gallery} WHERE id={$gid}");
		}		
		$shortcode = LBGalleryUtil::toObject($_REQUEST['shortcode']);		
		$clientWidth = $_REQUEST['width'];		
		$settings = LBGalleryHelper::getCategorySettings($cid);
		$allSettings = LBGalleryHelper::getAllSettings();				
		if(strpos($shortcode->width, '%')!==false){
			$clientWidth = floor($shortcode->width)/100 * $clientWidth;
		}else{
			$clientWidth = floor($shortcode->width);
		}
		// calculate the width and height of thumbnail
		$thumb_width = floor(($clientWidth - ($settings->thumb_cols - 1) * $settings->col_offset)/$settings->thumb_cols) - ($settings->border_width + $settings->border_spacing_leftright)*2;;
		if(strpos($settings->thumb_height, '%') !== false){
			$thumb_height = (floor($settings->thumb_height) / 100)*$thumb_width;
		}else{
			$thumb_height = floor($settings->thumb_height);
		}
		$settings->thumb_width = $thumb_width;
		$settings->thumb_height= $thumb_height;
		
		// items per page
		$ipp = $settings->thumb_rows * $settings->thumb_cols;
		
		$paged = $_REQUEST['paged'];
		if($paged < 1 )$paged = 1;
		
		$query = "
			SELECT 	g.*, u.".$allSettings['global']->author_field." as author_name, 
					count(i.id) as images_count, i.`filename`,i.`thumbname`,i.`type`,i.`storage`,i.provider				
				FROM {$wpdb->lbgal_gallery} g
				INNER JOIN {$wpdb->users} u ON u.ID=g.author
				LEFT JOIN {$wpdb->lbgal_image} i ON g.id = i.gid AND i.status=1
				WHERE g.published=1				
				GROUP BY g.id
				HAVING cid = {$cid}
				ORDER BY g.id ASC			
		";
		$galleries = $wpdb->get_results($query);
		$total = count($galleries);
		$totalPages = (int)($total / $ipp);
		if($total % $ipp) $totalPages++;
		if($galleries){
			$galleries = array_slice($galleries, ($paged-1)*$ipp, $ipp);
			foreach($galleries as $id=>$gallery){
				$query = "
					SELECT *
					FROM {$wpdb->lbgal_image}
					WHERE gid = {$gallery->id}
							AND status=1
				";
				$galleries[$id]->images = $wpdb->get_results($query);				
				$ratings = LBGalleryHelper::getGallery($gallery->id);
				$galleries[$id]->rating = $ratings->rating;
				$galleries[$id]->votes = $ratings->votes;
				// get featured image
				if($gallery->featured_image){
					$query = "
						SELECT * FROM {$wpdb->lbgal_image} WHERE id={$gallery->featured_image}
					";
				}else{
					$query = "
						SELECT * FROM {$wpdb->lbgal_image} WHERE gid={$gallery->id}
						LIMIT 0,1
					";
				}
				$featured_image = $wpdb->get_row($query);
				if($featured_image->type == 'image'){
					if(preg_match('!^https?:\/\/!', $featured_image->filename)){
						$fullsrc = $featured_image->filename;
					}else{
						$fullsrc = $featured_image->storage == 'local' ? LBGAL_GALLERY_URL . '/' . $featured_image->gid . '/' . $featured_image->filename : $featured_image->filename;
					}
					$thumbsrc = $featured_image->thumbname ? $featured_image->thumbname : $fullsrc;
					if(preg_match('!^https?:\/\/!', $thumbsrc)){
					}else{
						$thumbsrc = $featured_image->storage == 'local' ? LBGAL_GALLERY_URL . '/' . $featured_image->gid . '/thumbs/' . $thumbsrc : $featured_image->thumbname;
					}
					$thumbsrc = LBGAL_URL . '/timthumb.php?src=' . base64_encode($fullsrc) . '&w='.($thumb_width).'&h='.($thumb_height);
										
					$galleries[$id]->thumbsrc = $thumbsrc;
				}else if($featured_image->type == 'video'){
					$thumbsrc = LBGAL_URL . '/timthumb.php?src=' . base64_encode($featured_image->thumbname) . '&w='.($thumb_width).'&h='.($thumb_height);
					$galleries[$id]->thumbsrc = $thumbsrc;
				}
			}	
		}else $galleries = array();
		
		
		//header 
		$lists = array();

		if($shortcode->show_category_dropdown){
			$lists['categories'] = '<select name="lbgal-cid" id="lbgal-cid" class="lbgal-cid">';
			$query = "
				SELECT c.*, count(g.cid) as gallery_count
					FROM {$wpdb->lbgal_category} c
					LEFT JOIN {$wpdb->lbgal_gallery} g ON g.cid=c.id AND g.published=1
					GROUP BY c.id
					ORDER BY c.name ASC
			";
			if($categories = $wpdb->get_results($query)){
				foreach($categories as $category){
					$lists['categories'] .= '<option value="'.$category->id.'"'.($category->id == $cid ? ' selected="selected"' : '').'>'.($category->name?$category->name:'[No Title]').' ('.$category->gallery_count.')'.'</option>';
				}
			}
			$lists['categories'] .= '</select>';
		}
		$this->tpl->assignRef('allSettings', $allSettings);
		$this->tpl->assignRef('cid', $cid);
		$this->tpl->assignRef('gid', $gid);
		$this->tpl->assignRef('totalPages', $totalPages);
		$this->tpl->assignRef('currentPage', $paged);
		$this->tpl->assignRef('listview', 'gallery');
		$this->tpl->assignRef('lists', $lists);
		//			
		$this->tpl->assignRef('galleries', $galleries);
		$this->tpl->assignRef('root', $this);
		$this->tpl->assignRef('shortcode', $shortcode);
		$this->tpl->assignRef('settings', $settings);
		$json = new stdClass();
		$json->json 	= array('cid' => $cid, 'gid' => $gid, 'galleries' => $galleries, 'settings' => $settings);
		$json->header	= $this->tpl->fetch('gallery.header');
		if(!$json->header) $json->header = "&nbsp;";
		$json->html 	= $this->tpl->fetch('gallery.gallery');
		$json->totalPages = $totalPages;
		
		echo json_encode($json);			
		die();
	}
	/**
	*	AJAX: load images
	*
	*/
	function ajax_load_images($gid = null){
		global $wpdb;		
		$gid 			= $gid ? $gid : $_REQUEST['gid'];
		$clientWidth 	= $_REQUEST['width'];
		$settings 		= LBGalleryHelper::getGallerySettings($gid);
		$allSettings 	= LBGalleryHelper::getAllSettings();
		$shortcode 		= LBGalleryUtil::toObject($_REQUEST['shortcode']);
		if(strpos($shortcode->width, '%')!==false){
			$clientWidth = (floor($shortcode->width) * $clientWidth)/100;
		}else{
			$clientWidth = floor($shortcode->width);
		}
		$_thumbnail = $settings->_thumbnail;
		$cols = $_thumbnail->thumb_cols;
		$rows = $_thumbnail->thumb_rows;
		
		//border width
		//$settings->_thumbnail->border_width = 1;
		//$settings->_thumbnail->border_spacing = 10;
		
		$thumb_width = floor(($clientWidth - ($cols - 1) * $_thumbnail->col_offset)/$cols) - ($_thumbnail->border_width + $_thumbnail->border_spacing_leftright)*2;
		$settings->_thumbnail->thumb_width = $thumb_width;
		// calculate the width and height of the thumbnail
		if(strpos($_thumbnail->thumb_height, '%') !== false){
			$thumb_height = (floor($_thumbnail->thumb_height) / 100)*$thumb_width;
		}else{
			$thumb_height = floor($_thumbnail->thumb_height);
		}
		$settings->_thumbnail->thumb_height = $thumb_height;
		
		// get header nav
		$lists = array();
		
		if($shortcode->show_gallery_dropdown){
			$lists['galleries'] = '<select class="lbgal-gid" name="" id="">';
			$query = "
				SELECT c.*
					FROM {$wpdb->lbgal_category} c
			";
			if($categories = $wpdb->get_results($query)){
				foreach($categories as $category){
					$lists['galleries'] .= '<optgroup label="'.($category->name?$category->name:'[No Title]').'">';
					$query = "
						SELECT g.*, count(i.gid) as image_count
						FROM {$wpdb->lbgal_gallery} g
						LEFT JOIN {$wpdb->lbgal_image} i ON i.gid = g.id  AND i.status=1
						WHERE cid = {$category->id}
							AND g.published=1
						GROUP BY g.id
					";
					if($galleries = $wpdb->get_results($query)){
						foreach($galleries as $gallery){
							$lists['galleries'] .= '<option value="'.$gallery->id.'"'.($gallery->id == $gid ? ' selected="selected"' : '').'>'.($gallery->title?$gallery->title:'[No Title]').' ('.$gallery->image_count.')'.'</option>';
						}
					}
					$lists['galleries'] .= '</optgroup>';
				}
			}
			$lists['galleries'] .= '</select>';
		} // end if
		
		$settings->paged = $_REQUEST['paged'] + 1;
		
		// get list of images
		$images = LBGalleryHelper::getImagesByGallery($gid, $settings);
		
		
		$this->tpl->assignRef('gid', $gid);
		$this->tpl->assignRef('settings', $settings);		
		$this->tpl->assignRef('listview', 'image');
		$this->tpl->assignRef('lists', $lists);
		//			
		$this->tpl->assignRef('images', $images);
		$this->tpl->assignRef('root', $this);
		$json = new stdClass();
		$json->json 	= array('gid' => $gid, 'images' => $images, 'settings' => $settings);
		$json->pages	= array();
		
		$items_per_page = $settings->_thumbnail->thumb_cols * $settings->_thumbnail->thumb_rows;
		$total = count($images);
		$total_pages = floor($total / $items_per_page);
		if($total % $items_per_page) $total_pages++;			
		$this->tpl->assignRef('allSettings', $allSettings);
		$this->tpl->assignRef('currentPage', $_REQUEST['paged']+1);
		$html = array();
		$images = array_slice($images, $_REQUEST['paged']*$items_per_page, $items_per_page);
		$this->tpl->assignRef('images', $images);
		$html = $this->tpl->fetch('gallery.image.thumbnail');
		$start = $_REQUEST['paged'] * $items_per_page + 1;
		$end = $start + $items_per_page - 1;
		if($end > $total) $end = $total;
		$this->tpl->assignRef('startItem', $start);
		$this->tpl->assignRef('endItem', $end);
		$this->tpl->assignRef('totalPages', $total_pages);
		$this->tpl->assignRef('shortcode', $shortcode);
		$json->totalPages = $total_pages;
		$json->header	= $this->tpl->fetch('gallery.header');
		if(!$json->header) $json->header = "&nbsp;";
		$json->html 	= $html;
		
		echo json_encode($json);			
		die();
	}
	function ajax_load_single_image(){
		$id = $_POST['id'];
		$gid = $_POST['gid'];
		$settings = LBGalleryHelper::getGallerySettings($gid, null, 'object');
		$settings->image_view = 'filmstrip';
		if($images = LBGalleryHelper::getImagesByGallery($gid, $settings)){
			foreach($images as $image){
				if($image->id == $id) break;	
			}
			$allSettings = LBGalleryHelper::getAllSettings();
			$json = new stdClass();
			$json->settings = $settings;
			$json->image = $image;
			$this->tpl->assignRef('image', $image);
			$this->tpl->assignRef('settings', $settings);
			$this->tpl->assignRef('view', $this);
			$_REQUEST['viewer_blocks'] = 1;
			$json->html = $this->tpl->fetch('gallery.image.single');
			echo json_encode($json);
		}
		die();
	}
	function ajax_user_rate(){
		global $wpdb;
		$currentUser = wp_get_current_user();
		if(!$currentUser->ID){
			$json = array('errorMessage' => __('Please login to vote', 'lb-gallery'));
		}else{
			extract($_POST);
			$query = "
				SELECT id
				FROM {$wpdb->lbgal_rating}
				WHERE ref_id = {$ref_id} AND user_id = {$currentUser->ID} AND rating_type = '{$rating_type}'
			";
			if($id = $wpdb->get_var($query)){
				$query = "
					UPDATE {$wpdb->lbgal_rating} SET rating_value = {$rating}
					WHERE user_id = {$currentUser->ID} AND ref_id = {$ref_id} AND id = {$id}
				";				
			}else{
				$query = "
					INSERT INTO {$wpdb->lbgal_rating}(user_id, ref_id, rating_type, rating_value)
					VALUES('{$currentUser->ID}', '{$ref_id}', '$rating_type', '{$rating}')
				";
			}

			$wpdb->query($query);

			if($rating_type == 'gallery'){
				$item = LBGalleryHelper::getGallery($ref_id);
				
			}else{
				$item = LBGalleryHelper::getImage($ref_id);
			}
			$item->rating_type = $rating_type;
			
			$query = "
			SELECT `value` FROM {$wpdb->lbgal_setting} WHERE `key` = 'GLOBAL_SETTINGS'
			";
			$settings= LBGalleryHelper::getSettings('GLOBAL_SETTINGS');
			$stars = LBGalleryHelper::getSettings('RATING_STAR_SETTINGS');
			$key = $settings->star_style;
			$starStyle = $stars->$key;
		
			ob_start();
			?>
            <span class="current-rating" style="width:<?php echo ($item->rating/5)*$starStyle->size[0]*5;?>px;"></span>
            <input type="hidden" class="hdn-current-rating-value" value="<?php echo ($item->rating/5)*$starStyle->size[0]*5;?>" />
            <input type="hidden" class="hdn-item-id" value="<?php echo $item->id;?>" />
            <input type="hidden" class="hdn-rating-type" value="<?php echo $item->rating_type;?>" />
            <?php
			$response = ob_get_clean();
			$json = array(
				'html' 		=> $response,
				'votes' 	=> $item->votes,
				'rating' 	=> sprintf('%1.1f', $item->rating)
			);
		}
		echo json_encode($json);
		die();
	}
	function getGalleryBlock($gallery, $settings, $position = 'top'){
		global $wpdb;
		$allSettings = LBGalleryHelper::getAllSettings();		
		if(count($settings->blocks->$position)){
			echo '<div class="lbgal-gallery-text lbgal-'.$position.' lbgal-'.$settings->thumb_text_effect.'">';
			foreach($settings->blocks->$position as $field){
				switch($field){
					case 'title':
						$text = preg_replace('!{TITLE}!', ($gallery->title ? $gallery->title : '[No Title]'), $settings->blocks_text->title);
						echo '<h3 class="lbgal-title is-gallery">'.$text.'</h3>';
						break;
					case 'description':
						$text = preg_replace('!{DESCRIPTION}!', ($gallery->description ? $gallery->description : '[No Text]'), $settings->blocks_text->description);
						echo '<div class="lbgal-description">'.$text.'&nbsp;</div>';
						break;
					case 'author':
						$text = preg_replace('!{AUTHOR}!', $gallery->author_name, $settings->blocks_text->author);
						echo '<p class="lbgal-block">'.$text.'</p>';
						break;
					case 'date':
						$text = preg_replace('!{DATE}!', date($allSettings['global']->date_time_format, $gallery->created), $settings->blocks_text->date);
						echo '<p  class="lbgal-block">'.$text.'</p>';
						break;
					case 'rating':
						$gallerySettings = LBGalleryHelper::getCategorySettings($gallery->cid);
						////$stars = LBGalleryHelper::getSettings('RATING_STAR_SETTINGS');
						if($gallerySettings->gallery_rating == '1'){
							$gallery->type = 'gallery';
							ob_start();
							$this->getRatingForm($gallery);
							$text = ob_get_clean();
							echo preg_replace('!{RATING}!', $text, $settings->blocks_text->rating);				
						}
						break;	
					case 'num_of_photos':
						$text = preg_replace('!{NUM_OF_PHOTO}!', $gallery->images_count, $settings->blocks_text->num_of_photo);
						echo '<p class="lbgal-block">'.$text.'</p>';
						break;	
					case 'link':
						$gallerySettings = LBGalleryHelper::getCategorySettings($gallery->cid);
						
						if($gallerySettings->gallery_link == '1'){	
						?>
                        <p class="lbgal-block"><a class="lbgal-readmore" href="<?php echo $gallery->linkto?>"><?php echo $settings->blocks_text->link;?></a></p>
                        <?php
						}
						break;																						
				}
			}
			echo '</div>';
		}
	}
	function getThumbnailBlock($item, $settings, $position = 'top'){
		$settings->image_view = 'thumbnail';
		$view = '_'.$settings->image_view;
		$effect = $settings->image_view == 'thumbnail' ? $settings->_thumbnail->thumb_text_effect : $settings->_filmstrip->viewer_text_position;
		$allSettings = LBGalleryHelper::getAllSettings();
		$blocks = ($_REQUEST['viewer_blocks']) ? $settings->$view->viewerblocks : $settings->$view->blocks;
		if(count($blocks->$position)){
			$classes = array(
				'lbgal-gallery-text',
				'lbgal-'.$position,
				'lbgal-'.$effect,
				'lbgal-'.$item->type
			);
			if($position == 'thumb'){
				$classes[] = 'lbgal-viewer-desc';
			}
			echo '<div class="'.implode(' ', $classes).'">';
			foreach($blocks->$position as $field){
				switch($field){
					case 'title':
						$text = preg_replace('!{TITLE}!', ($item->title ? $item->title : '[No Title]'), $settings->_thumbnail->blocks_text->title);
						echo '<h3 class="lbgal-title">'.$text.'</h3>';
						break;
					case 'description':
						$text = preg_replace('!{DESCRIPTION}!', ($item->description ? $item->description : '[No Text]'), $settings->_thumbnail->blocks_text->description);
						echo '<div class="lbgal-description">'.$text.'</div>';
						break;
					case 'author':
						$text = preg_replace('!{AUTHOR}!', $item->author_name, $settings->_thumbnail->blocks_text->author);
						echo '<p class="lbgal-block">'.$text.'</p>';
						break;
					case 'date':
						$text = preg_replace('!{DATE}!', date($allSettings['global']->date_time_format, $item->created), $settings->_thumbnail->blocks_text->date);
						echo '<p  class="lbgal-block">'.$text.'</p>';
						break;
					case 'rating':					
						if($settings->enable_rating == '1'){								
							ob_start();
							$this->getRatingForm($item);
							$text = ob_get_clean();
							echo preg_replace('!{RATING}!', $text, $settings->_thumbnail->blocks_text->rating);
						}
						break;
					case 'link':
						if($settings->enable_link == '1'){	
						?>
                        <p  class="lbgal-block"><a class="lbgal-readmore" href="<?php echo $item->linkto;?>"><?php echo $settings->_thumbnail->blocks_text->link;?></a></p>
                        <?php
						}
						break;																								
				}
			}
			echo '</div>';
		}
	}
	function getRatingForm($item, $class = array()){
		global $wpdb;
		$query = "
			SELECT `value` FROM {$wpdb->lbgal_setting} WHERE `key` = 'GLOBAL_SETTINGS'
		";
		$settings= LBGalleryHelper::getSettings('GLOBAL_SETTINGS');
		$stars = LBGalleryHelper::getSettings('RATING_STAR_SETTINGS');
		$key = $settings->star_style;
		$starStyle = $stars->$key;
	?>
    	
		<ul class="lbgal-rating-form lbgal-<?php echo $item->type;?> <?php echo $starStyle->class;?>">
			<li class="background-rating"></li>        
			<li class="lbgal-rating-stars" style="">
				<span class="current-rating" style="width:<?php echo ($item->rating/5)*$starStyle->size[0]*5;?>px;"></span>
				<input type="hidden" class="hdn-current-rating-value" value="<?php echo ($item->rating/5)*$starStyle->size[0]*5;?>" />
				<input type="hidden" class="hdn-item-id" value="<?php echo $item->id;?>" />
                <input type="hidden" class="hdn-rating-type" value="<?php echo $item->rating_type;?>" />
			</li>
			<li class="lbgal-rating-text">(<span class="votes_count"><?php echo $item->votes;?></span> / <span class="rating_value"><?php echo $item->rating;?></span> ratings)</li>		
        </ul>
	<?php        
	}
}
