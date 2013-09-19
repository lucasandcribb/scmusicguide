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
			<?php $loop = new WP_Query( array( 'post_type' => 'exclusive' ) ); ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="single-exclusive-cont">
				<div class="exclusive-title-cont">
					<div class="single-exclusive-title"><?php echo $excl_title; ?></div>
				</div>
				<div class="exclusive-content" rel="<?php echo get_the_ID(); ?>">
					<?php get_template_part( 'content', get_post_format() ); ?>
				</div>
				<div class="exclusive-post-video">
					<div class="exclusive-vid-title"><?php the_field('exclusive_video_title') ?></div>
					<div class="exclusive-vid-holder"><?php the_field('exclusive_videos') ?></div>
				</div>
	
				<div class="exclusive-post-track">
					<div class="exclusive-vid-title"><?php the_field('exclusive_track_title') ?></div>
					<div class="exclusive-vid-holder"><?php the_field('exclusive_music_track') ?></div>
				</div>
	
				
				<div class="artist-website artist-site-links"><a href="<?php the_field('exclusive_website_link'); ?>" target="blank"><?php the_field('exclusive_artist_name'); ?>&#39;s Website</a></div>
				<div class="artist-facebook artist-site-links"><a href="<?php the_field('exclusive_facebook_link'); ?>" target="blank"><?php the_field('exclusive_artist_name'); ?> on Facebook</a></div>
				<div class="artist-twitter artist-site-links"><a href="<?php the_field('exclusive_twitter_link'); ?>" target="blank">Follow <?php the_field('exclusive_artist_name'); ?> on Twitter</a></div>
				<div class="artist-reverbnation artist-site-links"><a href="<?php the_field('exclusive_reverbnation_link'); ?>" target="blank"><?php the_field('exclusive_artist_name'); ?> Music on Reverbnation</a></div>
				<div class="artist-youtube artist-site-links"><a href="<?php the_field('exclusive_youtube_link'); ?>" target="blank">View <?php the_field('exclusive_artist_name'); ?> YouTube Videos</a></div>
				<div class="artist-itunes artist-site-links"><a href="<?php the_field('exclusive_itunes_link'); ?>" target="blank">Buy <?php the_field('exclusive_artist_name'); ?>&#39;s Music at iTunes</a></div>
			</div>
			<?php endwhile; ?>
			

		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>