<?php
/**
 * Pagination
 *
 * @package Soundcheck
 * @since 1.0
 */
if( $wp_query->max_num_pages > 1 ) : ?>
	<nav class="pagenavi">
		<?php
		$big     = 999999999;
		$base    = str_replace( $big, '%#%', get_pagenum_link( $big ) );
		$total   = $wp_query->max_num_pages;
		$current = max( 1, get_query_var('paged') );
		
		printf( '<span class="pages">' . __( 'Page %1$d of %2$d', 'themeit' ) . '</span>', absint( $current ), absint( $total ) );
		
		$pagination_args = array(
		    'base'      => $base,
		    'format'    => '?paged=%#%&page_id=' . get_the_ID(),
		    'current'   => $current,
		    'total'     => $total,
		    'prev_text' => '&laquo;',
		    'next_text' => '&raquo;'
		);
		
		print paginate_links( $pagination_args );
		?>
	</nav>
<?php endif; ?>