<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">


		<?php if ( have_posts() ) : ?>
			<?php $excl_title = get_title(); ?>

			<div class="review-info">
				<div class="single-review-img"><a href="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); echo $image[0]; ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div>
				<div class="single-review-title"><?php echo $excl_title; ?></div>
				
			</div>
			<div class="review-content" rel="<?php echo get_the_ID(); ?>">
				<?php get_template_part( 'content', get_post_format() ); ?>
			</div>
			<div class="review-band-links">
				<div>Artist Website:</div>
				<a href="<?php the_field('artist_website'); ?>"><?php the_field('exclusive_website_link'); ?></a>
				<div>Artist Facebook:</div>
				<a href="<?php the_field('artist_facebook'); ?>"><?php the_field('exclusive_facebook_link'); ?></a>
				<div>Artist YouTube:</div>
				<a href="<?php the_field('artist_youtube'); ?>"><?php the_field('exclusive_youtube_link'); ?></a>
				<div>Artist iTunes:</div>
				<a href="<?php the_field('artist_itunes'); ?>"><?php the_field('exclusive_itunes_link'); ?></a>
			</div>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php comments_template(); ?>
			<?php endwhile; ?>
			
				
		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>