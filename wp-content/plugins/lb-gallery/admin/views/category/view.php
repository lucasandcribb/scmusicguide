<?php
class LBGalleryViewCategory extends LBGalleryView{
	function __construct(){
		/*$this->_paged = ($_REQUEST['paged'] > 0 ? $_REQUEST['paged'] : 1);
		$this->_limit = 5;
		$this->_total = 0;
		$this->_rowIndex = 0;		*/
	}
	function display(){
		global $wpdb, $lbgalleryAdminTemplate;
		
		$cid = $_REQUEST['cid'];
		$query = "
			SELECT *
			FROM {$wpdb->lbgal_category}
			WHERE id = {$cid}
		";
		$category = $wpdb->get_row($query);
		
		$query = "
			SELECT count(id)
			FROM {$wpdb->lbgal_category}
		";
		$this->_total = $wpdb->get_var($query);
		
		$query = "
			SELECT c.*, count(g.id) as galleries_count
			FROM {$wpdb->lbgal_category} c
			LEFT JOIN {$wpdb->lbgal_gallery} g ON g.cid=c.id
			GROUP BY c.id
		";
		$categories = $wpdb->get_results($query);
		$tpl = $lbgalleryAdminTemplate;
		$tpl->set('categories', $categories);
		$tpl->set('category', $category);
		$tpl->set('total', $this->_total);
		//$tpl->set('lists', array('limit' => $this->getLimit(), 'paged' => $this->getPaged()));
		echo $tpl->fetch('category.list');
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