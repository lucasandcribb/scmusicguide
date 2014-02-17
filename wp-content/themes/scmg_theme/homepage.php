<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>

<?php get_sidebar(); ?>



<div id="banner-slideshow" class="hp-slideshow banner-slideshow-hp">
	<div id="slide-next" class="slide-btn"></div>

	<?php $slide_array = array();
		
	$slide_loop = new WP_Query( array( 'post_type' => 'any', 'category_name' => 'Homepage Slider', 'posts_per_page' => 4 ) ); 

	while ( $slide_loop->have_posts() ) : $slide_loop->the_post(); $slide_id = get_the_ID();
		array_push($slide_array, $slide_id);
	endwhile;

	$totalSlideCount = 0; foreach ($slide_array as $singleSlide) {$totalSlideCount++;} ?>

	<div id="hp-slide-cont">
		<?php for($s=0;$s<$totalSlideCount;$s++) {
			$slide_id = $slide_array[$s]; 
			$slideOne = get_post($slide_id); 
			$slide_title = $slideOne->post_title; 
			$slide_permalink = get_permalink($slide_id);
			$image = get_field('homepage_slider_image', $slide_id);
			$video = get_field('homepage_slider_video', $slide_id); ?>
		
		
			<?php if ($image['url']) { ?>
				<div id="slide-<?php echo $s; ?>" class="slide-main image-slide" rel="<?php echo $s; ?>">
					<img src="<?php echo $image['url']; ?>" />
					<a href="<?php echo $slide_permalink; ?>"><div class="hp-slide-title"><?php echo $slide_title; ?></div></a>
				</div>
			<?php } else { ?>
				<div id="slide-<?php echo $s; ?>" class="slide-main video-slide" rel="<?php echo $s; ?>">
					<?php echo $video; ?>
					<a href="<?php echo $slide_permalink; ?>"><div class="hp-slide-title"><?php echo $slide_title; ?></div></a>
				</div>
			<?php } ?>
			
			
		<?php } ?>

		<div class="index-dots-cont">
			<?php for ($d=0;$d<$totalSlideCount;$d++) { ?>
				<div class="each-dot-cont">
					<div class="index-dots" rel="<?php echo $d; ?>"></div>
				</div>
			<?php } ?>
		</div>

	</div>

	<div class="hp-vid-alert">
		<img class="pause-slides on" src="/wp-content/images/pause.png" />
		<div class="pause-slide-mssg">Pause Slideshow</div>
		<img class="play-slides" src="wp-content/images/play.png" />
		<div class="play-slide-mssg">Play Slideshow</div>
	</div>

</div>


<div id="featured-review" class="featured-section">
	<a href="/album-reviews"><div class="fr-title">ALBUM REVIEWS</div></a>
	<div class="fr-reveiws">
		<?php $loop = new WP_Query( array( 'post_type' => 'reviews', 'posts_per_page' => 1, 'order' => 'DESC') ); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); 
				$id = get_the_ID(); $review_url = get_permalink(); $content = get_post_meta($id, 'review_content', true);?>
			<div class="fr-review-one-cont">
				<a class="fr-review-img" href="<?php echo $review_url; ?>"><?php echo the_post_thumbnail() ?></a>
				<div class="fr-review-title"><a href="<?php echo $review_url; ?>"><?php the_title(); ?></a></div>
				<div class="review-one-body">
					<?php echo substr($content, 0, 400).'...'; ?>
				</div>
				<div class="fr-read-more"><a href="<?php echo $review_url; ?>">Read More</a></div>
			</div>
		<?php endwhile; ?>
		<div id="review-divider"></div>
		<?php $loop = new WP_Query( array( 'post_type' => 'reviews', 'posts_per_page' => 3, 'order' => 'DESC') ); 
			  $rev_num = 1;?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); 
				$id = get_the_ID(); $review_url = get_permalink(); $content = get_post_meta($id, 'review_content', true);?>
			<div class="fr-review-sm-cont rev-<?php echo $rev_num; ?>">
				<a class="fr-review-sm-img" href="<?php echo $review_url; ?>"><?php echo the_post_thumbnail() ?></a>
				<div class="fr-review-sm-title"><a href="<?php echo $review_url; ?>"><?php the_title(); ?></a></div>
				<div class="fr-review-sm-body">
					<?php echo substr($content, 0, 200).'...'; ?>
				</div>
				<div class="fr-read-more"><a href="<?php echo $review_url; ?>">Read More</a></div>
			</div>
			<?php $rev_num++; ?>
		<?php endwhile; ?>
	</div>
</div>


<div id="exclusive-container" class="featured-section">
	<div id="exclusive-title" class="fr-title">FEATURED ARTIST</div>
	<div id="exclusive-content">
		<?php $artist_array = array(); ?>
		<?php $e_loop = new WP_Query( array( 'post_type' => 'exclusive', 'posts_per_page' => 1, 'order' => 'DESC' ) ); ?>
		<?php while ( $e_loop->have_posts() ) : $e_loop->the_post(); $excl_url = get_permalink();?>
			
			<div id="exclusive-vid-container"  class="exclusive-video">
				<div class="exclusive-vid-title"><?php the_field('exclusive_video_title') ?></div>
				<div id="exclusive-vid-holder" class="exclusive-vid-holder"><?php the_field('exclusive_videos') ?></div>
			</div>

			<div class="exclusive-article">
				<div class="exclusive-article-title"><?php the_title(); ?></div>
				<div class="exclusive-article-divider"></div>
				<div class="exclusive-article-content">
					<?php echo get_template_part('content',get_post_format()); ?>
					<a href="<?php echo $excl_url; ?>">...Read More</a>
				</div>
				
			</div>

			<div id="exclusive-track-container" class="music-player">
				<div class="exclusive-vid-title"><?php the_field('exclusive_track_title') ?></div>
				<div id="exclusive-track-holder" class="exclusive-vid-holder"><?php the_field('exclusive_music_track') ?></div>
			</div>

		<?php endwhile; ?>

	</div>
</div>


<div id="featured-spot-ss-guest" class="featured-section">
	<div id="exclusive-title" class="fr-title">SIGHTS AND SOUNDS</div>
	<!-- <div class="s-nav">
		<div id="tab-nav-spot" class="s-nav-tabs s-nav-current" rel="Spotlight">Spotlight</div>
		<div id="tab-nav-ss" class="s-nav-tabs" rel="Sights and Sounds">Sights and Sounds</div>
		<div id="tab-nav-guest" class="s-nav-tabs" rel="Guest List">Guest List</div>
	</div> -->
	<!-- <div id="hp-spotlight-tab" class="spotlight-tabs">
		<h2 class="widgettitle">Spotlight</h2>
		<div class="fr-reveiws">
			<?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 1, 'order' => 'DESC', 'category_name' => 'In The Spotlight' ) ); 
				   $cats = wp_get_post_categories(); ?>
			<?php while ( $loop->have_posts() ) : $loop->the_post(); $spoturl = get_permalink();?>
				<div class="fr-review-one-cont">
					<a class="fr-review-img" href="<?php echo $spoturl; ?>"><?php echo the_post_thumbnail() ?></a>
					<div class="fr-review-title"><a href="<?php echo $spoturl; ?>"><?php the_title(); ?></a></div>
					<div class="review-one-body">
						<?php echo substr(get_the_content(), 0, 400).'...'; ?>
					</div>
					<div class="fr-read-more"><a href="<?php echo $spoturl; ?>">Read More</a></div>
				</div>
			<?php endwhile; ?>
			<div id="review-divider"></div>
			<?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'order' => 'DESC', 'category_name' => 'In The Spotlight' ) ); 
				  $rev_num = 1;?>
			<?php while ( $loop->have_posts() ) : $loop->the_post(); $spoturl = get_permalink(); ?>
				<div class="fr-review-sm-cont rev-<?php echo $rev_num; ?>">
					<a class="fr-review-sm-img" href="<?php echo $spoturl; ?>"><?php echo the_post_thumbnail() ?></a>
					<div class="fr-review-sm-title"><a href="<?php echo $spoturl; ?>"><?php the_title(); ?></a></div>
					<div class="fr-review-sm-body">
						<?php echo substr(get_the_content(), 0, 200).'...'; ?>
					</div>
					<div class="fr-read-more"><a href="<?php echo $spoturl; ?>">Read More</a></div>
				</div>
				<?php $rev_num++; ?>
			<?php endwhile; ?>
		</div>
	</div> -->
	
		<div class="fr-reveiws">
			<?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 1, 'order' => 'DESC', 'category_name' => 'Sights and Sounds' ) ); 
				  $cats = wp_get_post_categories(); ?>
			<?php while ( $loop->have_posts() ) : $loop->the_post(); $url = get_permalink(); ?>
				<div class="fr-review-one-cont">
					<a class="fr-review-img" href="<?php echo $url; ?>"><?php echo the_post_thumbnail() ?></a>
					<div class="fr-review-title"><a href="<?php echo $url; ?>"><?php the_title(); ?></a></div>
					<div class="review-one-body">
						<?php echo substr(get_the_content(), 0, 400).'...'; ?>
					</div>
					<div class="fr-read-more"><a href="<?php echo $url; ?>">Read More</a></div>
				</div>
			<?php endwhile; ?>
			<div id="review-divider"></div>
			<?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'order' => 'DESC', 'category_name' => 'Sights and Sounds' ) ); 
				  $rev_num = 1;?>
			<?php while ( $loop->have_posts() ) : $loop->the_post(); $url = get_permalink(); ?>
				<div class="fr-review-sm-cont rev-<?php echo $rev_num; ?>">
					<a class="fr-review-sm-img" href="<?php echo $url; ?>"><?php echo the_post_thumbnail() ?></a>
					<div class="fr-review-sm-title"><a href="<?php echo $url; ?>"><?php the_title(); ?></a></div>
					<div class="fr-review-sm-body">
						<?php echo substr(get_the_content(), 0, 200).'...'; ?>
					</div>
					<div class="fr-read-more"><a href="<?php echo $url; ?>">Read More</a></div>
				</div>
				<?php $rev_num++; ?>
			<?php endwhile; ?>
		</div>
	
	<!-- <div id="hp-guest-tab" class="spotlight-tabs">
		<h2 class="widgettitle">Guest List</h2>
		<div class="fr-reveiws">
			<?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 1, 'order' => 'DESC', 'category_name' => 'The Guest List' ) ); 
				  $cats = wp_get_post_categories(); ?>
			<?php while ( $loop->have_posts() ) : $loop->the_post(); $url = get_permalink(); ?>
				<div class="fr-review-one-cont">
					<a class="fr-review-img" href="<?php echo $url; ?>"><?php echo the_post_thumbnail() ?></a>
					<div class="fr-review-title"><a href="<?php echo $url; ?>"><?php the_title(); ?></a></div>
					<div class="review-one-body">
						<?php echo substr(get_the_content(), 0, 400).'...'; ?>
					</div>
					<div class="fr-read-more"><a href="<?php echo $url; ?>">Read More</a></div>
				</div>
			<?php endwhile; ?>
			<div id="review-divider"></div>
			<?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'order' => 'DESC', 'category_name' => 'The Guest List' ) ); 
				  $rev_num = 1;?>
			<?php while ( $loop->have_posts() ) : $loop->the_post(); $url = get_permalink(); ?>
				<div class="fr-review-sm-cont rev-<?php echo $rev_num; ?>">
					<a class="fr-review-sm-img" href="<?php echo $url; ?>"><?php echo the_post_thumbnail() ?></a>
					<div class="fr-review-sm-title"><a href="<?php echo $url; ?>"><?php the_title(); ?></a></div>
					<div class="fr-review-sm-body">
						<?php echo substr(get_the_content(), 0, 200).'...'; ?>
					</div>
					<div class="fr-read-more"><a href="<?php echo $url; ?>">Read More</a></div>
				</div>
				<?php $rev_num++; ?>
			<?php endwhile; ?>
		</div> -->
	</div>
</div>


<!-- <div id="new-artists" class="featured-section">
	<div id="new-artists-title">FEATURED ARTISTS</div>
	<div id="new-artists-cont">
		<?php $artist_array = array(); ?>
		<?php $a_loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 100, 'order' => 'DESC' ) ); ?>
		<?php while ( $a_loop->have_posts() ) : $a_loop->the_post(); $a_id = get_the_ID(); ?>
			<?php array_push($artist_array, $a_id); ?>
		<?php endwhile; ?>
		<?php $artistCount = 0; foreach ($artist_array as $artists) {$artistCount++;} ?>

		<?php $a_numbers = range(0,$artistCount-1);
		shuffle($a_numbers);
		$fiveArtists = array_slice($a_numbers, 0, 5); ?>

		<?php for($n=0;$n<5;$n++) {
			$array_num = $fiveArtists[$n]; 
			$a_id = $artist_array[$array_num]; 
			$artistOne = get_post($a_id); 
			$a_title = $artistOne->post_title; 
			$a_permalink = get_permalink($a_id); ?>
			<div class="new-artist" rel="<?php echo $a_id; ?>">
				<a href="<?php echo $a_permalink; ?>">
					<?php echo get_the_post_thumbnail($a_id); ?>
					<div class="new-artist-name"><?php echo $a_title; ?></div>
				</a>
			</div>
		<?php } ?>	
	</div>
</div> -->


<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'content', 'page' ); ?>
<?php endwhile; ?>






<div id="musicians-corner-cont" class="featured-section">
	<div class="musicians-corner-title">MUSICANS CORNER</div>
	<div class="mc-nav">
		<div id="mc-nav-news" class="mc-nav-tabs mc-nav-current" rel="News">NEWS</div>
		<div id="mc-nav-tips" class="mc-nav-tabs" rel="Tips">TIPS</div>
		<div id="mc-nav-diy" class="mc-nav-tabs" rel="DIY">DIY</div>
	</div>
	<?php echo do_shortcode("[widgets_on_pages id='Musicians Corner']") ?>
</div>



<div id="hp-widget-holder">

	<!-- <div id="featured-artist" class="hp-custom-widget">
		<div class="featured-title">Featured Artist</div>
		<?php $loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 500, 'order' => 'ASC' ) ); ?>
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
			$url = get_permalink($featured_id);
		?>
		<a href="<?php echo $url; ?>">
			<div id="featured-img"><?php echo $img; ?></div>
			<div id="featured-name"><?php echo $title; ?></div>
		</a>
	</div> -->

<!-- 	<div id="locally-grown" class="hp-custom-widget">
		<div class="lg-title">Locally Grown</div>
		<?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 500, 'order' => 'ASC' ) ); ?>
		<?php $lg_arry = array(); $count = 0;?>
		<?php while ( $loop->have_posts() ) : $loop->the_post();
			$id = get_the_ID();
			$local = get_field('locally_grown');
			if ($local == 1) {
				array_push($lg_arry, $id);
			}
			$count++;
		endwhile; $random = rand(0,$count); $lg_id = $lg_arry[$random]; ?>
		<?php
			$post = get_post($lg_id);
			$img = get_the_post_thumbnail($lg_id);
			$title = $post->post_title;
			$url = get_permalink($lg_id);
			$artist = get_field('artist_name_post',$lg_id);
		?>
		<a href="<?php echo $url; ?>">
			<div id="lg-img"><?php echo $img; ?></div>
			<div id="lg-name"><?php echo $title; ?></div>
			<div id="lg-artist"><?php echo $artist; ?></div>
		</a>
	</div> -->

	<!-- <div id="sights-sounds" class="hp-custom-widget">
		<div class="ss-title">Sights and Sounds</div>
		<?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 5, 'order' => 'ASC' ) ); ?>
		<?php $ss_arry = array(); $count = 0;?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<?php $ss = get_field('sights_and_sounds'); ?>
			<?php if ($ss == true) { ?>
			<div class="ss-list">
				<a href="<?php echo $url; ?>">
					<div id="ss-img"><?php the_post_thumbnail('thumbnail'); ?></div>
					<div id="ss-name"><?php the_title(); ?></div>
				</a>
			</div>
			<?php } ?>
		<?php endwhile; ?>
	</div> -->

	<!-- <div id="show-single-artist-in-month" class="hp-custom-widget">
		<div class="ss-title">Test to show one artist for current month</div>
		<?php 	$month = date(F);
				$year = date('Y'); 
				$loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 1, 'order' => 'ASC', 'year=' . $year . '&monthnum=' . $month ) ); ?>
		<?php $array = array(); $count = 0;?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="ss-list TEST">
				<a href="<?php echo $url; ?>">
					<div id="ss-img"><?php the_post_thumbnail('thumbnail'); ?></div>
					<div id="ss-name"><?php the_title(); ?></div>
				</a>
			</div>
		<?php endwhile; ?>
	</div> -->

</div>

<?php get_footer(); ?>