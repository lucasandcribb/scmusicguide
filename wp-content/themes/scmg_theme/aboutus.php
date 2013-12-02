<?php
/*
Template Name: About Us
*/
?>
<?php get_header(); ?>

<?php get_sidebar(); ?>

<div id="primary" class="site-content">
	<div id="content" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
			<?php comments_template( '', true ); ?>
			<?php $artist_array = array(); ?>
			<?php $a_loop = new WP_Query( array( 'post_type' => 'bio', 'posts_per_page' => 100, 'order' => 'ASC' ) ); ?>
			<?php while ( $a_loop->have_posts() ) : $a_loop->the_post(); $a_id = get_the_ID(); ?>
				<div class="about-us-profile">
					<?php the_post_thumbnail('full'); ?>
					<div class="profile-info">
						<div class="profile-titles">
							<div class="about-name"><?php the_title(); ?></div></br>
							<div class="about-title"><?php the_field('title') ?></div>
						</div>
						<?php the_field('bio') ?>
					</div>
				</div>
			<?php endwhile; ?>
		<?php endwhile; // end of the loop. ?>




		


		


	</div><!-- #content -->
</div><!-- #primary -->


<?php get_footer(); ?>