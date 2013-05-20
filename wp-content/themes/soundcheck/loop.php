<?php

// Theme Options Blog Query
if ( $wp_query->is_posts_page || is_home() || is_page_template( 'template-blog.php' ) ) {
    $blog_args = array(
		'post_type' => 'post', 
		'paged' => soundcheck_get_paged_query_var(),
		'cat' => soundcheck_option( 'blog_category', null )
	);
    query_posts( $blog_args );
}

if( have_posts() ) : 
	while( have_posts() ) : 
		the_post();
		get_template_part( 'content' ); 
	endwhile;
else : 
	get_template_part( 'content', 'archive' ); 
endif;
?>