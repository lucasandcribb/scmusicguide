<?php
/*
Template Name: Album Reviews
*/
?>
<?php get_header(); ?>

	<?php get_sidebar(); ?>

	<?php $alph_array = array("All","1-10","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"); ?>

	<select class="index-links index-link-dd">
		<option>Filter by Album Name</option>
		<?php for ($i = 0; $i < 28; $i++) {
    		echo "<option href='#index-".$alph_array[$i]."' class='album-filter' rel='".$alph_array[$i]."'>".$alph_array[$i]."</option> ";
		} ?>
	</select>
	<select class="index-links index-link-dd">
		<option>Filter by Band Name</option>
		<?php for ($i = 0; $i < 28; $i++) {
    		echo "<option href='#index-".$alph_array[$i]."' class='artist-filter' rel='".$alph_array[$i]."'>".$alph_array[$i]."</option> ";
		} ?>
	</select>
	
	<?php $loop = new WP_Query( array( 'post_type' => 'reviews', 'posts_per_page' => 25, 'order' => 'DESC' ) ); ?>
	<?php while ( $loop->have_posts() ) : $loop->the_post(); 
		$url = get_permalink();
		$name = get_field('artist_name'); $newUrl = str_replace(' ', '-',$name); $lowerUrl = strtolower($newUrl);
		$album = get_field('album_name');
		$name_index = $name[0];
		$album_index = $album[0]?>
		
			<div class="album-review-cont" album-index="<?php echo $album_index; ?>" band-index="<?php echo $name_index; ?>">
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
	<div class="show-all-reviews">+ SHOW ALL REVIEWS</div>

<?php get_footer(); ?>