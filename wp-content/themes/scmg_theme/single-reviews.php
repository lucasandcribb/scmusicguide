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


			<div class="review-info">
				<div class="single-review-img"><?php the_post_thumbnail('thumbnail'); ?></div>
				<div class="single-review-title"><span>Band/Album Name: </span> <?php the_title(); ?></div>
				<div class="single-review-genre"><span>Genre: </span> <?php the_field('genre'); ?></div>
				<div class="single-review-release-date"><span>Release Date: </span> <?php $date = get_field('release_date'); echo date("m/d/y", strtotime($date)); ?></div>
				<div class="single-review-by"><span>Review By: </span><?php the_field('reviewed_by'); ?></div>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
			</div>
			<div class="review-content" rel="<?php echo get_the_ID(); ?>">
				<?php the_field('review_content'); ?>
			</div>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
			
				

		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>