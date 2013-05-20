<?php
/**
 * Featured Image Carousel
 *
 * @package Soundcheck
 * @since 1.0
 */
 
$image_carousel_args = array(
	'orderby'             => 'date', // To randomize, change "date" to "rand"
	'cat'                 => soundcheck_option( 'carousel_category', null ),
	'posts_per_page'      => soundcheck_option( 'carousel_count', 10 ),
	'ignore_sticky_posts' => 1,
	'meta_query'          => array ( 
		array (
			'key' => '_thumbnail_id' 
		)
	)
);

$image_carousel_query = new WP_Query( $image_carousel_args ); ?>

<?php if ( $image_carousel_query->have_posts() ) : ?>
	<aside id="image-carousel-container">
		<div class="lines">
			<span><!-- nothing to see here, css line --></span>
			<span><!-- nothing to see here, css line --></span>
			<span><!-- nothing to see here, css line --></span>
			<span><!-- nothing to see here, css line --></span>
		</div>
		
		<ul id="image-carousel" class="image-carousel-items jcarousel-skin-tango">
			<?php while ( $image_carousel_query->have_posts() ) : $image_carousel_query->the_post(); ?>
		  		<?php $format = ( get_post_format() ) ? get_post_format() : 'standard' ?>
		  	
		  		<li class="image-carousel-item">
		  	  		<figure class="entry-thumbnail">
		  				<a class="thumbnail-icon <?php echo esc_attr( $format ) ?>" href="<?php the_permalink() ?>" title="<?php soundcheck_the_title_attribute() ?>">
		  	    			<?php the_post_thumbnail( 'theme-carousel' ); ?>
		  	    		</a>
		  	  		</figure><!-- .entry-thumbnail -->
		  		</li><!-- .image-carousel-item -->
			<?php endwhile; // end while loop ?>
		</ul><!-- #mycarousel -->
	</aside><!-- .image-carousel -->

<?php else : ?>
	
	<aside class="default-notice">
		<h3><?php _e( 'Featured Image Carousel', 'soundcheck' ); ?></h3>
		<p><?php _e( 'The featured image carousel requires at least one post with a featured image.', 'soundcheck' ) ?></p>
	</aside>

<?php endif; // end image carousel post check ?>

<?php wp_reset_query();?>
