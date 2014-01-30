<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<div class="fb-like" data-href="https://www.facebook.com/SouthCarolinaMusicGuide?fref=ts" data-send="false" data-width="220" data-show-faces="true"></div>
			<div class="fb-follow" data-href="https://www.facebook.com/SouthCarolinaMusicGuide?fref=ts" data-show-faces="true" data-width="220"></div>
			<!-- <div class="fb-comments" data-href="http://scmusicguide.com" data-width="220" data-num-posts="0"></div> -->
			
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>