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

			<?php /* Start the Loop */ ?>
			<?php $loop = new WP_Query( array( 'post_type' => 'artists' ) ); ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="single-artist-cont">
				<div class="single-artist-title"><?php the_title(); ?></div>
				<div class="single-artist-image"><?php the_post_thumbnail('thumbnail'); ?></div>
				<div class="single-artists-formation"><span>Formation Date: </span><?php $date = get_field('date_of_formation'); echo date("m/d/y", strtotime($date)); ?></div>
				<div><span>Members: </span><?php the_field('members'); ?></div>
				<div><span>Bio: </span><?php the_field('bio'); ?></div>
				<div><span>Discography: </span><?php the_field('discography'); ?></div>
				<div><span>Website: </span><?php the_field('artist_website'); ?></div>
			</div>
			<?php endwhile; ?>


		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>