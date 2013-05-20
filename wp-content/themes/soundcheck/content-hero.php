<?php 
/**
 * @package Soundcheck
 * @since 1.0
 */
?>

<div id="hero">
    <div class="slides">
    	<?php
    	$hero_randomize = soundcheck_option( 'hero_randomize' ) == 1 ? 'rand' : 'date';
    	$hero_category = soundcheck_option( 'hero_category' );
    	
    	$hero_args = array( 
			'post_status' => 'publish',
			'cat' => $hero_category,
			'posts_per_page' => -1,
			'ignore_sticky_posts' => 1,
			'orderby' => $hero_randomize
    	);
    	
    	$hero_query = new WP_Query( $hero_args );
    	
    	if( $hero_category && $hero_query->have_posts() ) : 
    		while ( $hero_query->have_posts() ) : 
    			$hero_query->the_post();
    			
				$attachment_image_src = ( has_post_thumbnail() ) ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'theme-hero' ) : false;
    		
				$post_class = sprintf( 'slide post-%d', get_the_ID() );
				?>
				
				<div <?php post_class( $post_class ) ?> style="background: <?php echo get_post_meta( get_the_ID(), 'background_color', true ) ?> url(<?php echo $attachment_image_src[0] ?>) 50% 0 no-repeat">
    				<div class="slide-content-container">
    					<?php if ( '' != $post->post_content || get_post_format() ) : ?>
    						<article class="slide-content">
								<?php if ( $post->post_content != '' ) : ?>
									<?php get_template_part( 'post', 'content' ) ?>
								<?php endif; ?>
    						</article><!-- .slide-content -->
    					<?php endif; // end content and post format check ?>
    					
    					<?php edit_post_link( __( 'Edit Slide', 'soundcheck' ), '<div class="edit-link">', '</div>' ); ?>
    				</div><!-- .slide-content-container -->
    			</div><!-- .slide -->
    		<?php endwhile; // end hero slides loop ?>
		
		<?php else : // no hero slide available, show default notice ?>
    		<?php  
			printf( '<div class="%1$s" style="background: url(%2$s) 50% 0 no-repeat;">',
			    join( ' ', get_post_class( 'slide default-notice' ) ),
			    esc_url( get_template_directory_uri() . '/images/default-hero-image.jpg' )
			);
    		?>
    			<article class="default-notice slide-content">
    				<h3><?php _e( 'Hero Slide Setup', 'soundcheck' ); ?></h3>
    				<p>
    				<?php  
    				printf( __( 'It looks like you have not setup a category to be used for Hero slides.<br /> Add a new %1$s and get things moving.', 'soundcheck' ),
    				    sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
    				    	esc_url( get_admin_url() . 'themes.php?page=soundcheck_options&section=hero_section' ),
    				    	esc_attr( 'Set a Hero category' ),
    				    	esc_html( 'Hero slide' )
    				    )
    				);
    				?>
    			</article>
    		</div>
    	<?php endif; // end hero slides check ?>
    	
    	<?php wp_reset_postdata(); ?>
    </div><!-- .slides -->
    
    <div class="controls">
    	<a href="#" class="prev ir" title="Previous"><?php _e( 'Previous', 'soundcheck' ); ?></a>
    	<a href="#" class="next ir" title="Next"><?php _e( 'Next', 'soundcheck' ); ?></a>
    </div><!-- .controls -->
</div><!-- #hero -->