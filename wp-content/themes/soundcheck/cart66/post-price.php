<?php
/**
 * Set the entry price for each post. 
 *
 * @package Soundcheck
 * @since 1.0
 */
$price = soundcheck_cart66_product( array( 'option' => 'price' ) ); 

if( $price ) :
	printf( '<a class="price" href="%1$s" title="%2$s">%3$s</a>',
		esc_url( the_permalink() ),
		soundcheck_the_title_attribute(),
		sprintf( esc_html__( '%s', 'soundcheck' ), $price )
	);
endif; 
?>
