<?php
/**
 * The main template file.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

	<?php if( 1 == soundcheck_option( 'carousel_home' ) ) soundcheck_get_image_carousel( 'home' )	?>

	<?php get_sidebar( 'home' ) ?>

<?php get_footer(); ?>