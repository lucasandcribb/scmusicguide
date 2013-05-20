<?php 
/**
 * The loop for displaying singular page content (single, page, attachements)
 *
 * @package Soundcheck
 * @since 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ) ?>>
    <?php get_template_part( 'post', 'header' ) ?>
    <?php get_template_part( 'post', 'meta' ) ?>
    <?php get_template_part( 'post', 'format' ) ?>
    
    <?php if( is_search() ) :  ?>
    	<div class="entry-content">
    		<?php the_excerpt(); ?>
    	</div><!-- .entry-content -->
    <?php elseif( $post->post_content != '' ) : ?>
    	<div class="entry-content">
    		<?php
    		if( ! is_singular() ) global $more; $more = 0;
    		the_content( __( ' &hellip; Continue Reading', 'soundcheck' ) );

    		?>
    	</div><!-- .entry-content -->
    <?php endif; // End Archive and Search page check ?>


    <?php comments_template( '', true ); ?>
</article><!-- #post-## -->