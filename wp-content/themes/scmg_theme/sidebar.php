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
			<div class="fb-like" data-href="http://scmusicguide.com" data-send="false" data-width="215" data-show-faces="false"></div>
			<div class="fb-comments" data-href="http://scmusicguide.com" data-width="215" data-num-posts="5"></div>
			
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>