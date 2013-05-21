<div class="entry-content">
	<?php 
	/**
	 * The Content
	 *
	 */
	if( ! is_singular() ) : 
	    global $more; 
	    $more = 0;
	endif;
	
	the_content( sprintf( '<span class="moretext">%1$s</span>', __( '&hellip; Continue Reading', 'soundcheck' ) ) ); ?>
	
	
	<?php
	/**
	 * Page Links
	 *
	 */
	$args = array(
	    'before' => sprintf( '<p class="pagelinks"><span>%s</span><br />', __( 'Pages:', 'soundcheck' ) ),
	    'after' => '</p>',
	    'link_before' => '<span class="page-numbers">',
	    'link_after' => '</span>'
	);
	
	wp_link_pages( $args ); ?>
	
	<?php  
	/**
	 * Tags
	 *
	 */
	if ( ( $tag_list = get_the_tag_list( '', __( ', ', 'soundcheck' ) ) ) ) {
		printf( 'Tagged: %1$s', $tag_list );
	}
	?>
	
</div>
