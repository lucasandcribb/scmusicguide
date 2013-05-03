<?php
/*
Template Name: Artist Index
*/
?>
<?php get_header(); ?>

	<?php $alph_array = array("All","1-10","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"); ?>
	<?php $genre_array = array("Acoustic","Bluegrass","Blues","Funk","Rock"); ?>

	<div id="artist-index">
		<?php $loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 15, 'order' => 'ASC' ) ); ?>

		<?php 	
			$genreCount = 0;
			foreach ($genre_array as $genre) {
				$genreCount++;
			}
		?>

		<div class="index-links">
			<?php for ($i = 0; $i < 28; $i++) {
    			echo "<a href='#index-".$alph_array[$i]."' class='alpha-link' rel='".$alph_array[$i]."'>".$alph_array[$i]."</a> ";
			} ?>
		</div>
		<div class="index-links">
			<?php for ($i = 0; $i < $genreCount; $i++) {
    			echo "<a href='#index-".$genre_array[$i]."' class='genre-link' rel='".$genre_array[$i]."'>".$genre_array[$i]."</a> ";
			} ?>
		</div>

		<div class="filters">

		</div>
			
		<?php for ($i = 0; $i < 27; $i++) { ?>
			<div id="<?php echo $alph_array[$i]; ?>" class="index-single-cont" alpha="<?php echo $alph_array[$i]; ?>">
				<div class="index-section-title"><?php echo $alph_array[$i]; ?></div>
				<?php 
				while ( $loop->have_posts() ) : $loop->the_post();
					$url = get_permalink();
					$array_val = $alph_array[$i];
					$index = get_field('index');
					$cats = wp_get_post_categories();
					if ($index == $array_val) { ?>
					
						<div class="artist-section" alpha="<?php echo $alph_array[$i];?>" genre="<?php $categories = get_the_category(); if($categories){ foreach($categories as $category) {echo $category->cat_name; }}?>" >
							<a href="<?php echo $url; ?>">
								<div class="artist-img"><?php the_post_thumbnail('thumbnail'); ?></div>
								<div class="artist-title"><?php the_title(); ?></div>
							</a>
							</br>
							<div class="artist-genre">
								<a class='genre-title'>Genre: </a>
								<?php
								$categories = get_the_category();
								$separator = ' ';
								$output = '';
								if($categories){
									foreach($categories as $category) {
										$output .= '<a href="#" class="genre-each" rel="'.$category->cat_name.'">'.$category->cat_name.'</a>'.$separator;
									}
									echo trim($output, $separator);
								}
								?>
							</div>
						</div>
					
					<?php }
				endwhile; 
				?>
			</div>
		<?php } ?>

		
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>