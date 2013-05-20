<?php  
/**
 * The secondary sidebar. This page determines the page type and shows the appropriate widgets.	
 *
 * @package Soundcheck
 * @since 1.0
 */
?>

<section id="secondary-sidebar" class="sidebar" role="complementary">
	<?php
	if( is_single() ) :
	    if( soundcheck_product_type_page() ) {
	    	get_template_part( 'cart66/content', 'product-purchase' );
	    	dynamic_sidebar( 'sidebar-secondary-product' );
	    } else {
	    	dynamic_sidebar( 'sidebar-secondary-single' );
	    }
	    
	elseif( is_category() || is_search() || is_archive() || is_home() ) :
	    dynamic_sidebar( 'sidebar-secondary-multiple' );
	
	elseif( is_page() || is_404() ) :
	    dynamic_sidebar( 'sidebar-secondary-page' );
	
	endif; 
	?>
</section><!-- #secondary-sidebar -->
