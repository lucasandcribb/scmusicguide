<?php
/**
 * Adds the Audio Player widget.
 *
 * @package Soundcheck
 */


/**
 * Soundcheck Audio Player widget class.
 *
 * @package soundcheck
 * @subpackage Widgets
 * @since 1.0
 */

add_action( 'widgets_init', 'soundcheck_audio_player_widget_load' );

function soundcheck_audio_player_widget_load() { 
	register_widget( 'soundcheck_audio_player_widget' );
}

class soundcheck_audio_player_widget extends WP_Widget {

	function soundcheck_audio_player_widget() {
		$widget_ops = array( 
			'classname' => 'soundcheck_audio_player_widget', 
			'description' => 'A custom audio player widget.' 
		);

		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'soundcheck_audio_player_widget'
		);

		$this->WP_Widget( 'soundcheck_audio_player_widget', __( 'Audio Player', 'soundcheck' ), $widget_ops, $control_ops ); 
	}
	
    function form( $instance ) {
	    $defaults = array(
			'title' => '',
			'widget_title' => '',
			'album_id' => '',
			'autoplay' => 0,
			'album_info' => 0,
			'playlist' => 0
	    );
	    
	    $instance = wp_parse_args( (array) $instance, $defaults );
	    
	    if( $instance['album_id'] ) {
			$instance['title'] = get_the_title( $instance['album_id'] );
	    }
	   
	    $text_option = '<p><label for="%2$s">%1$s</label><br /><input type="text" class="widefat" id="%2$s" name="%3$s" value="%4$s" /></p>';
	    $checkbox_option = '<p><input class="checkbox" type="checkbox" id="%2$s" name="%3$s" %4$s value="1" /> <label for="%2$s">%1$s</label></p>';
	    
		// Widget Title - Admin Form (hidden)
		// Used to set Widget Title to Album Title via Album ID
		printf( '<input type="hidden" id="%2$s" name="%3$s" value="%4$s" />',
			esc_html__( 'Hidden Title:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( $instance['title'] )
		);
				
		$albums = soundcheck_get_widget_discography_list();
		// Album
		printf( '<p><label for="%2$s">%1$s</label><br /><select id="%2$s" name="%3$s" class="widefat">%4$s</select></p>',
			esc_html__( 'Album:', 'soundcheck' ),
			esc_attr( $this->get_field_id( 'album_id' ) ),
			esc_attr( $this->get_field_name( 'album_id' ) ),
			// array of options, selected option
			soundcheck_array_to_select( $albums, $instance['album_id'] )
		);
		
		// Album Info
		printf( $checkbox_option, 
			esc_html__( 'Show album info?', 'soundcheck' ),
			esc_attr( $this->get_field_id('album_info') ),
			esc_attr( $this->get_field_name('album_info') ),
			checked( absint( $instance['album_info'] ), 1, false )
		);
				
		// Playlist
		printf( $checkbox_option, 
			esc_html__( 'Show playlist button?', 'soundcheck' ),
			esc_attr( $this->get_field_id('playlist') ),
			esc_attr( $this->get_field_name('playlist') ),
			checked( absint( $instance['playlist'] ), 1, false )
		);
		
		// Autoplay
		printf( $checkbox_option, 
			esc_html__( 'Autoplay album?', 'soundcheck' ),
			esc_attr( $this->get_field_id('autoplay') ),
			esc_attr( $this->get_field_name('autoplay') ),
			checked( absint( $instance['autoplay'] ), 1, false )
		);
    }
    
    function update( $new_instance, $old_instance ) {
    	
    	$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['album_id'] = absint( $new_instance['album_id'] );
		//$instance['album_info'] = ( isset( $new_instance['album_info'] ) ? 1 : 0 );
		//$instance['playlist'] =  ( isset( $new_instance['playlist'] ) ? 1 : 0 );
		//$instance['autoplay'] = ( isset( $new_instance['autoplay'] ) ? 1 : 0 );
        
        return $new_instance;
    }
	
    function widget( $args, $instance ) {
		extract( $args );
		
		$instance['album_info'] = ( isset( $instance['album_info'] ) ) ? $instance['album_info'] : false;
		$instance['playlist'] = ( isset( $instance['playlist'] ) ) ? $instance['playlist'] : false;
		$instance['autoplay'] = ( isset( $instance['autoplay'] ) ) ? $instance['autoplay'] : false;
		
		print $before_widget;
		
		print do_shortcode( sprintf( '[p75_audio_player album_id="%1$s" autoplay="%2$s" content="%3$s" playlist="%4$s"]', 
		    esc_html( $instance['album_id'] ),
		    absint( $instance['autoplay'] ),
		    absint( $instance['album_info'] ),
		    absint( $instance['playlist'] )
		) );

		print $after_widget;
    }
}

function soundcheck_get_widget_discography_list() {
	/* Set arguements to query audio post formats */
	$args = array(
	    'posts_per_page' => -1,
	    'post_status' => 'publish',
	    'tax_query' => array(
	    	array (
	    		'taxonomy' => 'post_format',
	    		'field' => 'slug',
	    		'terms' => 'post-format-audio'
	    	)
	  	)
	);
		
	/* Create new query from $args */
	$discography_query = new WP_Query( $args );
	
	/* Loop through posts and add tracks to the $playlist array */
	while( $discography_query->have_posts() ) : 
	    $discography_query->the_post();
	    $albums[get_the_id()] = get_the_title();
	endwhile;
	
	/* As it says… */
	wp_reset_query();
	
	return $albums;
}

?>