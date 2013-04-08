<?php
/*
Template Name: Artist Index
*/
?>
<?php get_header(); ?>

	<?php $alph_array = array("1-10","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"); ?>

	<div id="artist-index">
		<?php $loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 15, 'order' => 'ASC' ) ); ?>

		<div id="index-links">
		<?php for ($i = 0; $i < 27; $i++) {
    		echo "<a href='#index-".$alph_array[$i]."' rel='".$alph_array[$i]."'>".$alph_array[$i]."</a> ";
		} ?>
		</div>
			
		<?php for ($i = 0; $i < 27; $i++) { ?>
			<div id="<?php echo $alph_array[$i]; ?>" class="index-single-cont">
				<div class="index-section-title"><?php echo $alph_array[$i]; ?></div>
				<?php 
				while ( $loop->have_posts() ) : $loop->the_post();
					$url = get_permalink();
					$array_val = $alph_array[$i];
					$index = get_field('index');
					if ($index == $array_val) { ?>
					<a href="<?php $url; ?>">
						<div id="index-<?php echo $alph_array[$i];?>" class="artist-section">
							<div class="artist-img"><?php the_post_thumbnail('thumbnail'); ?></div>
							<div class="artist-title"><?php the_title(); ?></div>
						</div>
					</a>
					<?php }
				endwhile; 
				?>
			</div>
		<?php } ?>

		
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>