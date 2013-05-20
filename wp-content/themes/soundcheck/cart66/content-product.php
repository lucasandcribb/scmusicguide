<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>
    <?php get_template_part( 'post', 'header' ) ?>
    <?php get_template_part( 'post', 'image' ) ?>
    
    <div class="entry-footer">
    	<?php
    	print do_shortcode( sprintf( '[add_to_cart ajax="yes" item="%1$s"]', 
    	    soundcheck_cart66_product( array( 
    	    	'id' => get_the_ID(), 
    	    	'option' => 'itemnumber', 
    	    	'echo' => 0
    	    ) )
    	));
    	?>
    	
    	<?php get_template_part( 'cart66/post', 'price' ) ?>
    </div>
</article><!-- #post-## -->
