<?php
/*
Template Name: Album Reviews
*/
?>
<?php get_header(); ?>

	<?php get_sidebar(); ?>
	
	<?php $loop = new WP_Query( array( 'post_type' => 'reviews', 'posts_per_page' => 10, 'order' => 'DESC' ) ); ?>
	<?php while ( $loop->have_posts() ) : $loop->the_post(); 
		$url = get_permalink();
		$name = get_field('artist_name'); $newUrl = str_replace(' ', '-',$name); $lowerUrl = strtolower($newUrl);?>
		
			<div class="album-review-cont">
				<div class="album-review-title">
					<a href="<?php echo $url ?>"><?php the_title(); ?></a>
				</div>
				<div class="album-review-img"><?php the_post_thumbnail('thumbnail'); ?></div>
				<div class="album-review-info">
					<div><span>Album Name - Band: </span> <?php the_title(); ?></div>
					<div><span>Genre: </span> <?php the_field('genre'); ?></div>
					<div><span>Release Date: </span> <?php $date = get_field('release_date'); echo date("m/d/y", strtotime($date)); ?></div>
					<div><span>Review By: </span><?php the_field('reviewed_by'); ?></div>
					<div class="ratings"><span><?php get_template_part( 'content', 'page' ); ?></div>
				</div>
				<div rel="<?php echo get_the_ID(); ?>" class="expand-review">+ Click to Read Full Review</div>
				<div rel="<?php echo get_the_ID(); ?>" class="retract-review">- Click to Hide Review</div>
				<div class="album-review-content" rel="<?php echo get_the_ID(); ?>">
					<?php the_field('review_content'); ?>
				</div>
			</div>
		
	<?php endwhile; ?>


<?php get_footer(); ?>