<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main-container div and all content after
 *
 * @package Soundcheck
 * @since 1.0
 */
?>
</div><!-- #main -->

<div id="footer-container">
    <footer id="footer">
    	<?php
    	/**
    	 * Copyright
    	 *
    	 */
    	$of_footer_copyright_default = 'Your Band Name - All Rights Reserved';
    	$of_footer_copyright = stripslashes( soundcheck_option( 'footer_copyright', $of_footer_copyright_default ) ); 
    	
    	printf( '<p id="copyright" role="contentinfo">%1$s <time datetime="%2$s">%3$d</time> %4$s</p>',
    	    esc_html__( '&copy; ', 'soundcheck' ),
    	    esc_attr__( date( 'Y-m-d' ), 'soundcheck' ),
    	    esc_html__( date( 'Y' ), 'soundcheck' ),
    	    sprintf( esc_html__( '%s', 'soundcheck' ), $of_footer_copyright )
    	); 
    	?>
    	
    	<ul id="media-icons">
    		<?php
    		/**
    		 * Social Networking Menu Items
    		 *
    		 */
    		$sites = array(
    			'amazon'     => 'Amazon',
    			'itunes'     => 'iTunes',
    			'soundcloud' => 'SoundCloud',
    			'bandcamp'   => 'Bandcamp',
    			'myspace'    => 'MySpace',
    			'lastfm'     => 'Last.fm',
    			'twitter'    => 'Twitter',
    			'facebook'   => 'Facebook',
    			'vimeo'      => 'Vimeo',
    			'youtube'    => 'YouTube',
    			'flickr'     => 'Flickr',
    			'rss'        => 'RSS'
    		);

    		// Loop through $sites
    		foreach( $sites as $key => $value ) { ?>
    		
    			<?php 
    			// Continue if username theme option is provided
    			if( ! ( $url = soundcheck_option( 'social_' .  $key ) ) ) 
    				continue;
    			
    			// Check for RSS is up to bat in loop and set its value accordingly					
    			if( 'rss' === $key ) {
    				$url = ( $feedburner_url = soundcheck_option( 'feedburner_url' ) ) ? $feedburner_url : get_bloginfo( 'rss2_url' );
    			}
    			?>
    			
    			<li class="<?php echo esc_attr( $key ) ?> ir">
    				<?php  
    				printf( '<a class="tooltip" href="%1$s" title="%2$s" target="_blank">%3$s</a>',
    					esc_url( $url ),
    					sprintf( esc_attr__( 'Link to %s', 'soundcheck' ), $value ),
    					sprintf( esc_html__( '%s', 'soundcheck' ), $value )
    				);
    				?>
    			</li>
    		<?php } // End $sites foreach loop ?>
    	</ul><!-- .media-icons -->
    	
    	<?php  
    	printf( '<p id="role-credits">%1$s<a href="http://lukemcdonald.com">%2$s</a> &amp; %3$s <a href="http://wordpress.org">%4$s</a></p>',
    		__( 'Designed by ', 'soundcheck' ),
    		__( 'Luke McDonald', 'soundcheck' ),
    		__( 'Powered by', 'soundcheck' ),
    		__( 'WordPress', 'soundcheck' )
    	);
    	?>
    
    </footer><!-- #footer -->
</div><!-- #footer-container -->

<?php wp_footer(); ?>

<!--[if lt IE 8 ]>
  <script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->
  <script type="text/javascript">
	$("section article header").next(".entry-meta").hide();
  </script>
</body>
</html>