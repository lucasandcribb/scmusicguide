<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>

	<div id="featured-artist">
		<div class="featured-title">Featured Artist</div>
		<?php $loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 15, 'order' => 'ASC' ) ); ?>
		<?php $artist_arry = array(); $count = 0;?>
		<?php while ( $loop->have_posts() ) : $loop->the_post();
			$id = get_the_ID();
			array_push($artist_arry, $id);
			$count++;
		endwhile; $random = rand(0,$count); $featured_id = $artist_arry[$random]; ?>
		<?php
			$post = get_post($featured_id);
			$img = get_the_post_thumbnail($featured_id);
			$title = $post->post_title;
		?>

		<div id="featured-img"><?php echo $img; ?></div>
		<div id="featured-name"><?php echo $title; ?></div>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>