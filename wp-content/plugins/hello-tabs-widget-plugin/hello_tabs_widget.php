<?php

function hello_get_registered_sidebars() {
	$sidebars;
    global $wp_registered_sidebars;
    if( empty( $wp_registered_sidebars ) )
        return;
	foreach( $wp_registered_sidebars as $sidebar ) : 
       $sidebars[]= array('id' => $sidebar['id'], 'name' => $sidebar['name']);
    endforeach; 
	return $sidebars;
}

function hello_get_sidebar_widgets($sidebar_id) {
    $widget_active = get_option('sidebars_widgets');
	if($widget_active){
		foreach( $widget_active[$sidebar_id] as $sidebar ) : 
			$return_array[]= $sidebar;
	    endforeach; 
	 }
	return $return_array;
}


function hello_show_sidebar($index = 1, $container = 'li', $widgets = array()) {
	global $wp_registered_sidebars, $wp_registered_widgets;

	if ( is_int($index) ) {
		$index = "sidebar-$index";
	} else {
		$index = sanitize_title($index);
		foreach ( (array) $wp_registered_sidebars as $key => $value ) {
			if ( sanitize_title($value['name']) == $index ) {
				$index = $key;
				break;
			}
		}
	}

	$sidebars_widgets = wp_get_sidebars_widgets();
	if ( empty( $sidebars_widgets ) )
		return false;

	if ( empty($wp_registered_sidebars[$index]) || !array_key_exists($index, $sidebars_widgets) || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]) )
		return false;

	$sidebar = $wp_registered_sidebars[$index];

	$did_one = false;
	foreach ( (array) $sidebars_widgets[$index] as $id ) {

		if ( !isset($wp_registered_widgets[$id]) ) continue;

		$params = array_merge(
			array( array_merge( $sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']) ) ),
			(array) $wp_registered_widgets[$id]['params']
		);

		// Substitute HTML id and class attributes into before_widget
		$classname_ = '';
		foreach ( (array) $wp_registered_widgets[$id]['classname'] as $cn ) {
			if ( is_string($cn) )
				$classname_ .= '_' . $cn;
			elseif ( is_object($cn) )
				$classname_ .= '_' . get_class($cn);
		}
		$classname_ = ltrim($classname_, '_');
		$params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);

		$params = apply_filters( 'dynamic_sidebar_params', $params );
		
		if(!empty($widgets)){
			if(in_array($id,$widgets)){
				$callback = $wp_registered_widgets[$id]['callback'];
	        }else{
				echo $callback='';
			}
		}else{
			$callback = $wp_registered_widgets[$id]['callback'];
		}

				do_action( 'dynamic_sidebar', $wp_registered_widgets[$id] );
		

		
       // if($addClass!='') $addClass= 'class="'.$addClass.'"';
		if ( is_callable($callback) ) {
			
			 echo $container ? '<'.$container.' id="'.$id.'" style="height:auto;width:100%;">' : '';
			call_user_func_array($callback, $params);
			 echo $container ? '</'.$container.'>' : '';
			$did_one = true;
		}
	}

	return $did_one;
}



/**Hello Tabs Widget Class*/
class hello_tabs_widget extends WP_Widget {
protected static $did_script = false;

    /** constructor */
    function hello_tabs_widget() {
        parent::WP_Widget(false, $name = 'HELLO TABS', array( 'description' => 'Create widgets tabs' ));
		add_action('wp_enqueue_scripts', array($this, 'scripts'));		
    }
   
   
   function scripts(){
    if(!self::$did_script && is_active_widget(false, false, $this->id_base, true)){
	  
	  wp_register_script( 'hello_tabs_js', plugin_dir_url( __FILE__ ).'js/hello.tabs.1.0.js',array('jquery'));
	  wp_register_style( 'hello_tabs_css', plugin_dir_url( __FILE__ ).'css/helloTabs.css');
	  wp_enqueue_style('hello_tabs_css');
	  wp_enqueue_script('hello_tabs_js');
      self::$did_script = true;
    }           	
  }
   
   
    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
        $title 	    = $instance['title'];
		$wp_sidebar 		= $instance['wp_sidebar'];
		$wp_widgets[]     = $instance['wp_widgets'];
		$unique 		= $instance['unique'];
		$animSpeed     = $instance['animSpeed'];
		$animation     = $instance['animation'];
		$easing     = $instance['easing'];
        $classID 		= $instance['classID'];

        ?>
        <?php echo $before_widget; ?>
		<?php if($unique) $unique = $unique."-";?>
		<div id="<?php echo $unique;?>tabsWrapper" style="display:none" >
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<div id="<?php echo $unique;?>tabs" class="tabs <?php echo $classID; ?>">
				<div id="<?php echo $unique;?>tabs-content" class="tabs-content">
						<div id="<?php echo $unique;?>tabs-content-inner" class="tabs-content-inner">
						<?php if ( !function_exists('dynamic_sidebar') || !hello_show_sidebar($wp_sidebar,'div',$wp_widgets[0]) ) : ?>
						<?php endif; ?>
						</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
	
		
			jQuery(document).ready(function($) {
				 $('#<?php echo $unique;?>tabsWrapper').fadeIn();
			     $('#<?php echo $unique;?>tabs').helloTabs({
					menuId: '#<?php echo $unique; ?>tabs-menu',
					contentId: '#<?php echo $unique; ?>tabs-content-inner',
					<?php if(easing != ''){ ?>
					easing: <?php echo '"'.$easing.'"'; ?>,
					<?php } ?>
					effect: <?php echo '"'.$animation ? '"'.$animation.'"' : '"showHideAnimate"'.'"'; ?>,
					speed: <?php echo $animSpeed ? $animSpeed : '500'; ?>
				 });
			});
		</script>
        <?php echo $after_widget; ?>
        <?php
    }
	
    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['animSpeed'] = $new_instance['animSpeed'];
		$instance['wp_widgets'] = $new_instance['wp_widgets'];
		$instance['easing'] = $new_instance['easing'];
		$instance['animation'] = $new_instance['animation'];
		$instance['wp_sidebar'] = $new_instance['wp_sidebar'];
		$instance['unique'] = strip_tags($new_instance['unique']);
		$instance['classID'] = $new_instance['classID'];
        return $instance;
    }

    /** @see WP_Widget::form */
    function form( $instance) {

	  

		$effects = array('','swing', 'easeInQuad','easeOutQuad','easeInOutQuad','easeInCubic',
						 'easeOutCubic','easeInOutCubic','easeInQuart','easeOutQuart','easeInOutQuart',
						 'easeInQuint','easeOutQuint','easeInOutQuint','easeInSine','easeOutSine',
						 'easeInOutSine','easeInExpo','easeOutExpo','easeInOutExpo','easeInCirc',
						 'easeOutCirc','easeInOutCirc','easeInElastic','easeOutElastic','easeInOutElastic',
						 'easeInBack','easeOutBack','easeInOutBack','easeInBounce','easeOutBounce','easeInOutBounce'
						);
						
		$animations = array('slideDownSlideUp', 'fadeInSlideUp','fadeInSlideUpDelay', 'slideDownSlideUpDelay', 
						    'fadeInFadeOutDelay', 'slideDownFadeOutDelay', 'showHide', 'showHideAnimate',
						    'leftShowLeftHide', 'topShowLeftHide', 'bottomShowLeftHide',  'rightShowLeftHide', 
							'leftShowRightHide', 'topShowRightHide', 'bottomShowRightHide', 'rightShowRightHide', 
							'bottomShowBottomHide', 'leftShowBottomHide', 'rightShowBottomHide', 'topShowBottomHide',
							'topShowTopHide', 'leftShowTopHide', 'rightShowTopHide', 'bottomShowTopHide' 
							);
		
		
		
		$animation = esc_attr($instance['animation']);	
        $title = esc_attr($instance['title']);	
	    $animSpeed = esc_attr($instance['animSpeed']);
		$wp_widgets[] = $instance['wp_widgets'];
		
		$wp_sidebar = esc_attr($instance['wp_sidebar']);
		$easing =esc_attr($instance['easing']);
	    $unique = esc_attr($instance['unique']);				
        $classID = esc_attr($instance['classID']);
		$column	= esc_attr($instance['column']);
		$push	= esc_attr($instance['push']);
		$pull	= esc_attr($instance['pull']);
		
        ?>
         
		 <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		 
		 <p>	
			<label for="<?php echo $this->get_field_name('wp_sidebar'); ?>"><?php _e('Sidebar:'); ?></label> 
			<select  name="<?php echo $this->get_field_name('wp_sidebar'); ?>" id="wp_sidebar" class="widefat">
				<?php 
				foreach (hello_get_registered_sidebars() as $sb) {
					if($sb['name'] != "Inactive Widgets"){
						echo '<option value="' . $sb['id']. '" id="' . $sb['id'] . '"', $wp_sidebar == $sb['id'] ? ' selected="selected"' : '', '>', $sb['name'], '</option>';
					}
				}
				?>
			</select>		
		</p> 
		
		
		
		
		
		
		<p>	

				<?php 
				if($wp_sidebar!='' ){
					is_array($wp_widgets[0]) ? '' : $wp_widgets[0] = hello_get_sidebar_widgets($wp_sidebar);
				?>
				<select name="<?php echo $this->get_field_name('wp_widgets'); ?>[]" id="wp_widgets" class="widefat" multiple="multiple">
				
				<?php
				foreach (hello_get_sidebar_widgets($wp_sidebar) as $widget) {
					    if($widget != '' ){
						echo '<option value="' . $widget. '" id="' . $widget . '"', in_array($widget,$wp_widgets[0]) ? ' selected="selected"' : '', '>', $widget, '</option>';
						}
				
				}
				
				?>
				</select>
				<?php } ?>
		</p> 
		
		
		
		
		
		
		 		<span style="color:#afafaf;font-size:11px;text-transform:uppercase;"><?php _e('tabs settings'); ?></span> 
		<hr size="1" width="100%" color="dfdfdf" />
		 
		 <p>
          <label for="<?php echo $this->get_field_id('unique'); ?>"><?php _e('Tabs ID:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('unique'); ?>" name="<?php echo $this->get_field_name('unique'); ?>" type="text" value="<?php echo $unique; ?>" />
        </p>
		 
				<p>
          <label for="<?php echo $this->get_field_id('animSpeed'); ?>"><?php _e('Speed:'); ?></label> 
          <input  id="<?php echo $this->get_field_id('animSpeed'); ?>" name="<?php echo $this->get_field_name('animSpeed'); ?>" class="widefat" type="text" value="<?php echo $animSpeed; ?>" />
        </p>
		
		
		<p>	
			<label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e('Effect:'); ?></label> 
			<select name="<?php echo $this->get_field_name('animation'); ?>" id="<?php echo $this->get_field_id('animation'); ?>" class="widefat">
				<?php 
				foreach ($animations as $anim->name) {
					echo '<option value="' . $anim->name . '" id="' . $anim->name . '"', $animation == $anim->name ? ' selected="selected"' : '', '>', $anim->name, '</option>';
				}
				?>
			</select>
		</p> 
		
		<p>	
			<label for="<?php echo $this->get_field_id('easing'); ?>"><?php _e('Easing:'); ?></label> 
			<select name="<?php echo $this->get_field_name('easing'); ?>" id="<?php echo $this->get_field_id('easing'); ?>" class="widefat">
				<?php 
				foreach ($effects as $effect) {
					echo '<option value="' . $effect . '" id="' . $effect . '"', $easing == $effect ? ' selected="selected"' : '', '>', $effect, '</option>';
				}
				?>
			</select>
		</p> 	
			
			
		 <p>
          <label for="<?php echo $this->get_field_id('classID'); ?>"><?php _e('Additional class(ses):'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('classID'); ?>" name="<?php echo $this->get_field_name('classID'); ?>" type="text" value="<?php echo $classID; ?>" />
        </p>
		
		<fieldset>
		
        <?php 
    }


} 

add_action('widgets_init', create_function('', 'return register_widget("hello_tabs_widget");'));

?>