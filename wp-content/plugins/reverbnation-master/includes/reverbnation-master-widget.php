<?php
//Hook Widget
add_action( 'widgets_init', 'reverbnation_master_widget' );
//Register Widget
function reverbnation_master_widget() {
register_widget( 'reverbnation_master_widget' );
}

class reverbnation_master_widget extends WP_Widget {
	function reverbnation_master_widget() {
	$widget_ops = array( 'classname' => 'Reverbnation Master', 'description' => __('Reverbnation Master plugs-in perfectly into wordpress and allows you to display all the reverbnation juice inside any widget template position. ', 'reverbnation_master') );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'reverbnation_master_widget' );
	$this->WP_Widget( 'reverbnation_master_widget', __('Reverbnation Master', 'reverbnation_master'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		//Our variables from the widget settings.
		$name = "Reverbnation Master";
		$title = isset( $instance['title'] ) ? $instance['title'] :false;
		$reverbnationspacer ="'";
		$show_reverbbutton = isset( $instance['show_reverbbutton'] ) ? $instance['show_reverbbutton'] :false;
		$reverbpage = $instance['reverbpage'];
		echo $before_widget;
		
		// Display the widget title
	if ( $title )
		echo $before_title . $name . $after_title;
	//Display Reverbnation Player

	//Display Reverbnation Profile Button
	if ( $show_reverbbutton )
			$url_loc = plugins_url();
			echo '<a href="'.$reverbpage.'" target="_blank"><img src="'.$url_loc.'/reverbnation-master/images/reverbnation_button.png"></a>';
	echo $after_widget;
	}
	//Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_reverbbutton'] = $new_instance['show_reverbbutton'];
		$instance['reverbpage'] = $new_instance['reverbpage'];
		return $instance;
	}
	function form( $instance ) {
	//Set up some default widget settings.
	$defaults = array( 'name' => __('Reverbnation Master', 'reverbnation_master'), 'title' => true, 'show_reverbbutton' => false, 'reverbpage' => false );
	$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<b>Check the buttons to be displayed:</b>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['title'], true ); ?> id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><b><?php _e('Display Widget Title', 'reverbnation_master'); ?></b></label></br>
	</p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['show_reverbbutton'], true ); ?> id="<?php echo $this->get_field_id( 'show_reverbbutton' ); ?>" name="<?php echo $this->get_field_name( 'show_reverbbutton' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_reverbbutton' ); ?>"><b><?php _e('Reverbnation Profile Button', 'reverbnation_master'); ?></b></label></br>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'reverbpage' ); ?>"><?php _e('insert Reverbnation Profile link:', 'reverbnation_master'); ?></label></br>
	<input id="<?php echo $this->get_field_id( 'reverbpage' ); ?>" name="<?php echo $this->get_field_name( 'reverbpage' ); ?>" value="<?php echo $instance['reverbpage']; ?>" style="width:auto;" />
	</p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; width:16px; vertical-align:middle;" />
	&nbsp;
	<b>Reverbnation Player</b>
	</p>
	<div class="description">Only available in advanced version.</div><br>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; width:16px; vertical-align:middle;" />
	&nbsp;
	<b>Reverbnation Master Website</b>
	</p>
	<p><a class="button-secondary" href="http://wordpress.techgasp.com/reverbnation-master/" target="_blank" title="Reverbnation Master Info Page">Info Page</a> <a class="button-secondary" href="http://wordpress.techgasp.com/reverbnation-master-documentation/" target="_blank" title="Reverbnation Master Documentation">Documentation</a> <a class="button-primary" href="http://wordpress.techgasp.com/reverbnation-master/" target="_blank" title="Reverbnation Master Wordpress">Advanced Version</a></p>
<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>
		<p>
		<img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; width:16px; vertical-align:middle;" />
		&nbsp;
		<b>Advanced Version Updater:</b>
		</p>
		<div class="description">The advanced version updater allows to automatically update your advanced plugin. Only available in advanced version.</div>
	<?php
	}
 }
?>