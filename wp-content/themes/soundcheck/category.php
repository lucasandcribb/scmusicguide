<?php
/**
 * The category template file.
 *
 * @package Soundcheck
 * @since 1.0
 */

get_header(); ?>

<?php if( 1 == soundcheck_option( 'carousel_multiple' ) ) soundcheck_get_image_carousel( 'multiple' )	?>


<section id="content" role="contentinfo">

	<?php 
	$blog_category = soundcheck_option( 'blog_category' );

	if( $blog_category && is_category( $blog_category ) ) {
		// Do nothing
	} else {
		get_template_part( 'page', 'header' );
	}
	?>
	
	<div class="customAjaxAddToCartMessage Cart66Success" style="display:none"></div>	

	<?php 
	$product_category = soundcheck_option( 'products_category' );

	if( ! empty( $product_category ) && ( is_category( $product_category ) || soundcheck_is_subcategory( $product_category ) ) ) {
	    get_template_part( 'cart66/loop', 'product' );
	} else {
	    get_template_part( 'loop' );
	}
	?>
	
	<?php get_template_part( 'content', 'pagination' ); ?>
</section><!-- #content -->

<?php if( soundcheck_has_right_sidebar() ) get_sidebar( 'secondary' ); ?>

<?php get_footer(); ?>