<?php
class LBGalleryViewGallery extends LBGalleryView{
	function display(){
		global $wpdb, $lbgalleryAdminTemplate;
		$tpl = $lbgalleryAdminTemplate;
		$page = $_REQUEST['paged'];
		if(!$page || $page < 0) $page = 1;
		$limit = 10;
		$start = ($page-1)*$limit;
		$sql = "
			SELECT count(id) FROM {$wpdb->lbgal_gallery}
		";
		$total = $wpdb->get_var($sql);
		$sql = "
			SELECT g.*, count(i.id) as image_count, u.user_nicename, c.name catname
			FROM {$wpdb->lbgal_gallery} g
			INNER JOIN {$wpdb->users} u ON u.ID = g.author
			INNER JOIN {$wpdb->lbgal_category} c ON c.id = g.cid
			LEFT JOIN {$wpdb->lbgal_image} i ON g.id = i.gid
			GROUP BY g.id
			ORDER BY g.ordering ASC		
		";
		
		if($galleries = $wpdb->get_results($sql)){
			foreach($galleries as $k=>$gallery){
				if($gallery->featured_image){
					$image = $wpdb->get_row("SELECT * FROM {$wpdb->lbgal_image} WHERE id={$gallery->featured_image}");
					if($image){ 
						$image = LBGalleryHelper::getImage($image);				
						$image->thumbsrc = preg_replace('!w=-?[0-9]+!', 'w=100', $image->thumbsrc);
						$image->thumbsrc = preg_replace('!h=-?[0-9]+!', 'h=80', $image->thumbsrc);
						$galleries[$k]->featured_image = $image->thumbsrc;
					}
				}
			}
		}
		
		
		
		//$tpl = new LBGalleryTemplate();
		$tpl->set('galleries', $galleries);
		$tpl->set('total', $total);
		$tpl->set('pagination', LBGalleryHelper::getNavigationHTML($total));
		$tpl->set('view', $this);
		
		echo $tpl->fetch('gallery.list');
	}
	function getImagesList($gid){
		global $wpdb;
		$query = "
			SELECT *
			FROM {$wpdb->lbgal_image}
			WHERE gid = {$gid}
		";
		$result = array();
		$result[] = '<div class="lbgal-image-combo">';
		$result[] = '<span class="lbgal-combo-label"></span>';
		$result[] = '<ul>';
		if($images = $wpdb->get_results($query)){
			foreach($images as $image){
				if($image->type == 'image'){
					$fullsrc = $image->storage == 'local' ? LBGAL_GALLERY_URL . '/' . $gid . '/' . $image->filename : $image->filename;
					$thumbsrc = LBGAL_URL . '/timthumb.php?src=' . base64_encode($fullsrc) . '&w=100&h=80';
				}else if($image->type == 'video'){
					$thumbsrc = LBGAL_URL . '/timthumb.php?src=' . base64_encode($image->thumbname) . '&w=100&h=80';
				}
				$result[] = '<li><img src="'.($thumbsrc).'" />'.$image->title.'</li>';
			}
		}
		$result[] = '</ul></div>';
		return implode('', $result);
	}
	function edit(){
		global $wpdb, $lbgalleryAdminTemplate;
		$gid = $_REQUEST['gid'];
		$query = "
			SELECT g.*, u.*
			FROM {$wpdb->lbgal_gallery} g
			LEFT JOIN {$wpdb->users} u ON u.ID = g.author
			WHERE g.id = '{$gid}'
		";
		if($gallery = $wpdb->get_row($query)){
			$pageTitle = __('Edit Gallery', 'lb-gallery');
			$query = "
				SELECT *
				FROM {$wpdb->lbgal_image}
				WHERE id = {$gallery->featured_image}
			";
			if($image = $wpdb->get_row($query)){
				if($image) $image = LBGalleryHelper::getImage($image);
				$gallery->preview = $image->thumbsrc;
			}
		}else{
			$gallery = new stdClass();
			$gallery->id = 0;		
			$pageTitle = __('New Gallery', 'lb-gallery');
		}
		$lists = array();
		
		$query = "
			SELECT c.*, count(g.id) as gallery_count 
			FROM {$wpdb->lbgal_category} c
			LEFT JOIN {$wpdb->lbgal_gallery} g ON c.id = g.cid
			GROUP BY c.id
		";
		$lists['category'] = '<select name="gallery[cid]" id="select-gallery-cid">';
		$lists['category'] .= '<option value="">'.__('SELECT CATEGORY', 'lb-gallery').'</option>';
		if($categories = $wpdb->get_results($query)){
			foreach($categories as $category){
				$lists['category'] .= '<option value="'.$category->id.'"'.($category->id == $gallery->cid ? ' selected="selected"' : '').'>'.($category->name ? $category->name : '[No Title]').'('.$category->gallery_count.')</option>';
			}
		}
		$lists['category'] .= '</select>';
		
		$lists['image'] = '<select name="gallery[featured_image]">';
		$lists['image'] .= '<option value="">'.__('--SELECT IMAGE--', 'lb-gallery').'</option>';
		$query = "
			SELECT *
			FROM {$wpdb->lbgal_image}
			WHERE gid = {$gallery->id}
		";
		if($images = $wpdb->get_results($query)){
			foreach($images as $image){
				if($image) $image = LBGalleryHelper::getImage($image);
				$lists['image'] .= '<option value="'.$image->id.'"'.($image->id == $gallery->featured_image ? ' selected="selected"' : '').'>'.$image->fullsrc.'</option>';
			}
		}
		$lists['image'] .= '</select>';
		
		$query = "
			SELECT *
			FROM {$wpdb->users}
		";
		$users = $wpdb->get_results($query);
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;
		ob_start();
		?>
        <select name="gallery[author]" id="select-gallery-author">        	
            <?php
			if($n = count($users)){
				foreach($users as $user){
				echo '<option value="'.$user->ID.'"'.($user->ID == $gallery->author || $user->ID == $uid ? ' selected="selected"' : '').'>'.$user->user_nicename.'</option>';
				}
			}
			?>
        </select>
        <?php
		$html = ob_get_clean();
		$lists['author'] = $html;
		
		$tpl = $lbgalleryAdminTemplate;
		$tpl->set('gallery', $gallery);
		$tpl->set('pageTitle', $pageTitle);
		$tpl->set('lists', $lists);
		
		echo $tpl->fetch('gallery.form');
	}
	function getFeatureImage($gid){
	
	}
}