<?php
/*
Template Name: Artist Index
*/
?>
<?php get_header(); ?>

<div id="banner-slideshow" class="hp-slideshow banner-slideshow-artist">
	<div id="slide-next" class="slide-btn"></div>

	<?php $slide_array = array(); ?>
		
	<?php $slide_loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 100, 'order' => 'DESC' ) ); ?>
	<?php while ( $slide_loop->have_posts() ) : $slide_loop->the_post(); $slide_id = get_the_ID(); ?>
		<?php array_push($slide_array, $slide_id); ?>
	<?php endwhile; ?>
	<?php $totalSlideCount = 0; foreach ($slide_array as $singleSlide) {$totalSlideCount++;} ?>
	<?php $slide_numbers = range(0,$totalSlideCount-1);
	shuffle($slide_numbers);
	$slideRandNumbers = array_slice($slide_numbers, 0, 10);?>
	
	<div id="hp-slide-cont">
		<?php for($s=0;$s<10;$s++) {
			$slide_num = $slideRandNumbers[$s]; 
			$slide_id = $slide_array[$slide_num]; 
			$slideOne = get_post($slide_id); 
			$slide_title = $slideOne->post_title; 
			$slide_permalink = get_permalink($slide_id); 
			$slide_content = $slideOne->post_content;?>
			<div id="slide-<?php echo $s; ?>" class="slide-main" rel="<?php echo $s; ?>">
				<a href="<?php echo $slide_permalink; ?>"><?php echo $slide_content; ?></a>
				<a href="<?php echo $slide_permalink; ?>"><div class="slide-title"><?php echo $slide_title; ?></div></a>
			</div>
		<?php } ?>
	</div>
	<div id="hp-slidethumb-cont">
		<?php for($t=0;$t<10;$t++) {
			$thumb_num = $slideRandNumbers[$t]; 
			$thumb_id = $slide_array[$thumb_num]; 
			$thumbOne = get_post($thumb_id); 
			$thumb_permalink = get_permalink($thumb_id);
			$thumb_content = $thumbOne->post_content;
			?>
			<div class="slide-thumb slide-thumb-artist" rel="<?php echo $t; ?>"><?php echo $thumb_content; ?></div>
		<?php } ?>
	</div>

</div>

	<?php $alph_array = array("All","1-10","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"); ?>
	<?php $genre_array = array("All","Acoustic","Alternative","Americana","Bluegrass","Blues","Country","Folk","Funk","Indie","Pop","Punk","Reggae","Rock","Roots","Singer-Songwriter","Soul","Stompgrass","World"); ?>

	<div id="artist-index">
		<?php $loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 500, 'order' => 'ASC' ) ); ?>

		<?php 	
			$genreCount = 0;
			foreach ($genre_array as $genre) {
				$genreCount++;
			}
		?>

		<div class="index-links alpha-index-links">
			<div id="alpha-index-dd" class="index-dd-btn">Filter by Name</div>
			<div id="alpha-index-cont">
			<?php for ($i = 0; $i < 28; $i++) {
			     echo "<a href='#index-".$alph_array[$i]."' class='alpha-link' rel='".$alph_array[$i]."'>".$alph_array[$i]."</a> ";
			} ?>
			</div>
		</div>
		<div class="index-links genre-index-links">
			<div id="genre-index-dd" class="index-dd-btn">Filter by Genre</div>
			<div id="genre-index-cont">
			<?php for ($i = 0; $i < $genreCount; $i++) {
			     echo "<a href='#index-".$genre_array[$i]."' class='genre-link' rel='".$genre_array[$i]."'>".$genre_array[$i]."</a> ";
			} ?>
			</div>
		</div>


		<!-- INDEX DROPDOWN -->
		<!-- <select class="index-links index-link-dd">
			<option>Filter by Letter</option>
			<//?php for ($i = 0; $i < 28; $i++) {
    			echo "<option href='#index-".$alph_array[$i]."' class='alpha-link' rel='".$alph_array[$i]."'>".$alph_array[$i]."</option> ";
			} ?>
		</select>
		<select class="index-links index-link-dd">
			<option>Filter by Genre</option>
			<//?php for ($i = 0; $i < $genreCount; $i++) {
    			echo "<option href='#index-".$genre_array[$i]."' class='genre-link' rel='".$genre_array[$i]."'>".$genre_array[$i]."</option> ";
			} ?>
		</select> -->





		<div class="filters">

		</div>
			
		<?php for ($i = 0; $i < 27; $i++) { ?>
			<div id="<?php echo $alph_array[$i]; ?>" class="index-single-cont" alpha="<?php echo $alph_array[$i]; ?>">
				<div class="index-section-title"><?php echo $alph_array[$i]; ?></div>
				<?php 
				while ( $loop->have_posts() ) : $loop->the_post();
					$url = get_permalink();
					$array_val = $alph_array[$i];
					$band_name = get_the_title();
					$index = $band_name[0];
					$cats = wp_get_post_categories();
					if ($index == $array_val) { ?>
					
						<div class="artist-section <?php $categories = get_the_category(); if($categories){ foreach($categories as $category) {echo $category->cat_name." "; }}?>" alpha="<?php echo $alph_array[$i];?>"  >
							<div class="artist-img artist-index-detail"><a href="<?php echo $url; ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div>
							<div class="artist-title artist-index-detail"><a href="<?php echo $url; ?>"><?php the_title(); ?></a></div>
							<div class="artist-genre artist-index-detail">
								<div class='genre-title'>Genre: </div>
								<?php
								$categories = get_the_category();
								$separator = ' ';
								$output = '';
								if($categories){
									foreach($categories as $category) {
										$output .= '<div class="genre-each" rel="'.$category->cat_name.'">'.$category->cat_name.'</div>'.$separator;
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