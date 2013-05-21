<?php
/**
 * Adds the Social Sharing widget.
 *
 * @package Soundcheck
 */


/**
 * Soundcheck Social Sharing widget class.
 *
 * @package soundcheck
 * @subpackage Widgets
 * @since 1.0
 */

add_action( 'widgets_init', 'soundcheck_social_sharing_widget_load' );

function soundcheck_social_sharing_widget_load() { 
	register_widget( 'soundcheck_social_sharing_widget' );
}

class soundcheck_social_sharing_widget extends WP_Widget {

	function soundcheck_social_sharing_widget() {
		$widget_ops = array( 
			'classname' => 'soundcheck_social_sharing_widget', 
			'description' => 'Facebook, Twitter, Google +1, and Email sharing links.' 
		);

		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'soundcheck_social_sharing_widget' 
		);

		$this->WP_Widget( 'soundcheck_social_sharing_widget', __( 'Social Sharing', 'soundcheck' ), $widget_ops, $control_ops ); 
	}
	
    function widget( $args, $instance ) {
		extract( $args );
		
		add_action( 'wp_footer', 'soundcheck_social_sharing_footer_scripts' );
		
		echo $before_widget; 
		?>
		
		<ul class="sharing-buttons">
			<li class="facebook-send">
				<div id="fb-root"></div>
				<div class="fb-like" data-href="<?php the_permalink() ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
			</li><!-- .facebook-send -->
			
			<li class="twitter-button">
				<a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="<?php esc_attr( soundcheck_option( 'social_twitter' ) ) ?>"><?php _e( 'Tweet', 'soundcheck' ); ?></a>
			</li><!-- .twitter-button -->
			
			<li class="google-plus">
				<g:plusone size="medium"></g:plusone>
			</li><!-- .google-plus -->
			
			<li class="email-this">
				<a href="mailto:?subject=<?php echo rawurlencode( get_the_title() ) . '&amp;body=' . rawurlencode( 'In regards to: ' ) . rawurlencode( get_the_title() ) . ' &ndash; ' . get_permalink(); ?>" title="<?php esc_attr_e( 'Email ', 'soundcheck' ) . esc_attr__( the_title_attribute() ); ?>"><!-- nothing to see here, email this --></a>
			</li><!-- .email-this -->
		</ul><!-- .sharing-buttons -->
		
		<div class="clearfix"><!-- nothing to see here --></div>
		
		<?php echo $after_widget;
    }
}

function soundcheck_social_sharing_footer_scripts() {
	?>
	<!-- Facebook (Social Sharing Widget) -->
	<script>
	    (function(d){
	      var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
	      js = d.createElement('script'); js.id = id; js.async = true;
	      js.src = "//connect.facebook.net/en_US/all.js#appId=231736140209773&xfbml=1";
	      d.getElementsByTagName('head')[0].appendChild(js);
	    }(document));
	</script>
	
	<!-- Twitter (Social Sharing Widget) -->
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	
	<!-- Google+ (Social Sharing Widget) -->
	<script type="text/javascript">
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/plusone.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
	<?php
}


?>