<?php
/**
 * The single template file.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<?php if( 1 == soundcheck_option( 'carousel_single' ) ) soundcheck_get_image_carousel( 'single' )	?>

<section id="content" role="contentinfo">

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>
		    <?php get_template_part( 'post', 'header' ); ?>
		    
		    <?php if ( ! soundcheck_product_type_page() ) : ?>
		    	<?php get_template_part( 'post', 'meta' ); ?>
		    <?php endif; ?>
		    
			<?php get_template_part( 'post', 'format' ); ?>
		    
			<?php if ( $post->post_content != '' ) : ?>
				<?php get_template_part( 'post', 'content' ); ?>
			<?php endif; ?>
			
			<?php if ( is_single() ) : ?>
				<nav id="single-navigation" class="clearfix">
				    <span class="prev"><?php previous_post_link( '%link', __( '<span class="button">&laquo; Prev</span>', 'themeit' ), true ); ?></span>
				    <span class="next"><?php next_post_link( '<span class="button">%link</span>', __( 'Next &raquo;', 'themeit' ), true ); ?></span>
				</nav><!-- #nav-single -->
			<?php endif; ?>
		
		    <?php comments_template( '', true ); ?>
		</article><!-- #post-## -->
		
	<?php endwhile; ?>
</section><!-- #content -->

<?php if( soundcheck_has_right_sidebar() ) get_sidebar( 'secondary' ); ?>

<?php get_footer(); ?>