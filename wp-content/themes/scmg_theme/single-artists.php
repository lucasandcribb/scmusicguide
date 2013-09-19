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
					<div class="artist-tracks"><?php the_field('artist_tracks') ?></div>
					<div class="singel-artist-genre"><span>Genre: </span>
						<?php
						$categories = get_the_category();
						$separator = ' ';
						$output = '';
						if($categories){
							foreach($categories as $category) {
								$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
							}
						echo trim($output, $separator);
						}
						?>
					</div>
					<div class="artist-bio"><span>Bio: </span><div class="single-artist-image"><?php the_post_thumbnail('full'); ?></div><?php the_field('bio'); ?></div>
					<div class="artist-website artist-site-links"><a href="<?php the_field('artist_website'); ?>" target="blank"><?php the_title(); ?>&#39;s Website</a></div>
					<div class="artist-facebook artist-site-links"><a href="<?php the_field('artist_facebook_page'); ?>" target="blank"><?php the_title(); ?> on Facebook</a></div>
					<div class="artist-twitter artist-site-links"><a href="<?php the_field('artist_twitter'); ?>" target="blank">Follow <?php the_title(); ?> on Twitter</a></div>
					<div class="artist-reverbnation artist-site-links"><a href="<?php the_field('artist_reverbnation'); ?>" target="blank"><?php the_title(); ?> Music on Reverbnation</a></div>
					<div class="artist-youtube artist-site-links"><a href="<?php the_field('artist_youtube'); ?>" target="blank">View <?php the_title(); ?> YouTube Videos</a></div>
					<div class="artist-itunes artist-site-links"><a href="<?php the_field('artist_itunes'); ?>" target="blank">Buy <?php the_title(); ?>&#39;s Music at iTunes</a></div>
					
				</div>
			<?php endwhile; ?>


			<div class="single-artist-video-title"><span></span></div>
			

		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>