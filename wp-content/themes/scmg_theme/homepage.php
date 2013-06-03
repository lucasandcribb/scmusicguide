<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>

<?php get_sidebar(); ?>



<div id="banner-slideshow" class="hp-slideshow">
	<div id="slide-next" class="slide-btn"></div>
	<?php $loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 10, 'order' => 'ASC' ) ); ?>
	<?php $count = 0; ?>
	<div id="hp-slide-cont">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); $url = get_permalink(); ?>
				<div id="slide-<?php echo $count; ?>" class="slide-main" rel="<?php echo $count; ?>">
					<a href="<?php echo $url; ?>"><?php the_post_thumbnail('full') ?></a>
				</div>
				<?php $count++; ?>
		<?php endwhile; ?>
	</div>
	<div id="hp-slidethumb-cont">
		<?php $count = 0; ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				<div class="slide-thumb" rel="<?php echo $count; ?>"><?php the_post_thumbnail('full') ?></div>
				<?php $count++; ?>
		<?php endwhile; ?>
	</div>
</div>

<div id="featured-review">
	<a href="/album-reviews"><div class="fr-title">ALBUM REVIEWS</div></a>
	<div class="fr-reveiws">
		<?php $loop = new WP_Query( array( 'post_type' => 'reviews', 'posts_per_page' => 1, 'order' => 'ASC' ) ); 
			  $url = get_permalink(); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="fr-review-one-cont">
				<a class="fr-review-img" href="<?php echo $url; ?>"><?php echo the_post_thumbnail() ?></a>
				<div class="fr-review-title"><a href="<?php echo $url; ?>"><?php the_title(); ?></a></div>
				<div class="review-one-body">
					<?php echo substr(get_field('review_content'), 0, 500).'...'; ?>
				</div>
				<div class="fr-read-more"><a href="<?php echo $url; ?>">Read More</a></div>
			</div>
		<?php endwhile; ?>
		<div id="review-divider"></div>
		<?php $loop = new WP_Query( array( 'post_type' => 'reviews', 'posts_per_page' => 3, 'order' => 'ASC' ) ); 
			  $url = get_permalink(); $rev_num = 1;?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="fr-review-sm-cont rev-<?php echo $rev_num; ?>">
				<a class="fr-review-sm-img" href="<?php echo $url; ?>"><?php echo the_post_thumbnail() ?></a>
				<div class="fr-review-sm-title"><a href="<?php echo $url; ?>"><?php the_title(); ?></a></div>
				<div class="fr-review-sm-body">
					<?php echo substr(get_field('review_content'), 0, 300).'...'; ?>
				</div>
				<div class="fr-read-more"><a href="<?php echo $url; ?>">Read More</a></div>
			</div>
			<?php $rev_num++; ?>
		<?php endwhile; ?>
	</div>
</div>

<div id="new-artists">
	<div id="new-artists-title">NEW ARTISTS</div>
	<div id="new-artists-cont">
		<?php $loop = new WP_Query( array( 'post_type' => 'artists', 'posts_per_page' => 5, 'order' => 'ASC' ) ); ?>
		<?php $url = get_permalink(); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="new-artist">
				<a href="<?php echo $url; ?>">
					<?php echo the_post_thumbnail() ?>
					<div class="new-artist-name"><?php the_title(); ?></div>
				</a>
			</div>
		<?php endwhile; ?>
	</div>
</div>

<!-- <div id="vid-aud-titles">
	<div class="vid-aud-title">FEATURED VIDEOS</div>
</div> 

<div id="hp-vid-list">
  [easy-media med="97,98,102,106"][easy-media med="97,98,102,106"]
</div>-->

<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'content', 'page' ); ?>
<?php endwhile; ?>


<div id="musicians-corner-cont">
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