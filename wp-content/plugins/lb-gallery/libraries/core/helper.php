<?php
class LBGalleryHelper2 extends LBGalleryObject{
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
}