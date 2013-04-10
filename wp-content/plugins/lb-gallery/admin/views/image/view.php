<?php
class LBGalleryViewImage extends LBGalleryView{
	function __construct(){
		/*$this->_paged = ($_REQUEST['paged'] > 0 ? $_REQUEST['paged'] : 1);
		$this->_limit = 5;
		$this->_total = 0;
		$this->_rowIndex = 0;		*/
	}
	function display(){
		global $wpdb, $lbgalleryAdminTemplate;
		
		$gid = $_REQUEST['gid'];
		if(!$gid){
			$query = "
				SELECT id
				FROM {$wpdb->lbgal_gallery}
				ORDER BY id ASC
				LIMIT 0, 1				
			";
			$gid = $wpdb->get_var($query);
		}
				
		$query = "
			SELECT count(id)
			FROM {$wpdb->lbgal_image}
			WHERE gid = {$gid}
		";
		$total = $wpdb->get_var($query);
		
		$query = "
			SELECT i.*, g.featured_image
			FROM {$wpdb->lbgal_image} i
			LEFT JOIN {$wpdb->lbgal_gallery} g ON g.featured_image = i.id
			WHERE i.gid = {$gid}
			ORDER BY ordering ASC	
		";			
		/*			
			LIMIT ".(($this->getPaged()-1)*$this->getLimit() . "," . $this->getLimit())."
		";*/
		$images = null;
		if($images = $wpdb->get_results($query)){
			foreach($images as $k => $item){
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
					$thumbsrc = LBGAL_URL . '/timthumb.php?src=' . base64_encode($thumbsrc) . '&w=80&h=60';
					$images[$k]->fullsrc = $fullsrc;
					$images[$k]->thumbsrc = $thumbsrc;
				}else if($item->type == 'video'){
					$thumbsrc = LBGAL_URL . '/timthumb.php?src=' . base64_encode($item->thumbname) . '&w=80&h=60';
					$images[$k]->thumbsrc = $thumbsrc;
					//$images[$k]->viewHTML = $provider->getViewHTML();
				}
			}
		}
		
		//$lists = array('limit' => $this->getLimit(), 'paged' => $this->getPaged());
		//$lists['pagination'] = LBGalleryHelper::getNavigationHTML($this->getTotal(), array('limit' => $this->getLimit(), 'paged' => $this->getPaged()));
		
		$lists = array();
		$lists['filter_gallery'] = '<select name="gid" id="filters_gid" onchange="this.form.submit();">';
		$query = "
			SELECT *
			FROM {$wpdb->lbgal_category}
		";
		if($categories = $wpdb->get_results($query)){
			foreach($categories as $category){
				$lists['filter_gallery'] .= '<optgroup label="'.($category->name?$category->name:'[No Title]').'">';		
				$query = "
					SELECT g.*, count(i.id) as image_count 
					FROM {$wpdb->lbgal_gallery} g
					LEFT JOIN {$wpdb->lbgal_image} i ON g.id = i.gid
					GROUP BY g.id
					HAVING cid = {$category->id}
				";
				if($galleries = $wpdb->get_results($query)){
					foreach($galleries as $gal){
						$lists['filter_gallery'] .= '<option value="'.$gal->id.'"'.($gal->id==$gid ? ' selected="selected"' : '').'>'.($gal->title?$gal->title:'No Title').' ('.$gal->image_count.')</option>';
					}
				}
				$lists['filter_gallery'] .= '</optgroup>';
			}
		}
		$lists['filter_gallery'] .= '</select>';
		
		$tpl = $lbgalleryAdminTemplate;
		$tpl->set('images', $images);
		$tpl->set('category', $category);
		$tpl->set('total', $total);
		$tpl->set('lists', $lists);
		$tpl->set('view', $this);
		$tpl->set('gid', $gid);
		
		echo $tpl->fetch('image.index');
	}
	/*function getTotal(){
		return $this->_total;
	}
	function getLimit(){
		return $this->_limit;
	}
	function getPaged(){
		return $this->_paged;
	}
	function getOffset(){
		return ($this->getPaged() - 1) * $this->getLimit() + $this->_rowIndex + 1;
	}*/
}