<?php  
/**
 * The home sidebar template. Displays widgets to show only on the home page.
 *
 * @package Soundcheck
 * @since 1.0
 */
?>
<section id="home-sidebar" role="complementary">

	<div id="col-1" class="grid-3">
		<?php dynamic_sidebar( 'home-column-1' ); ?>  			
	</div>
	
	<div id="col-2" class="grid-6">
		<?php dynamic_sidebar( 'home-column-2' ); ?>  			
	</div>
	
	<div id="col-3" class="grid-3">
		<?php dynamic_sidebar( 'home-column-3' ); ?>  			
	</div>
</section><!-- #homebar-sidebar -->