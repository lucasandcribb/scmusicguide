<?php
/**
Register Widget to display images on Widget
*/
class lbGalleryWidget extends WP_Widget {
    /** constructor */
    function lbGalleryWidget() {
        parent::WP_Widget(false, $name = 'LB Gallery');	
    }
    /**  show widget */
    function widget($args, $instance) {		
		global $wpdb;
        extract( $args );
        $title 			= apply_filters('widget_title', $instance['title']);
		$group			= explode('-', $instance['group_id']);
		$grid			= explode('x', $instance['grid']);
		$offset			= explode('x', $instance['offset']);
		$border_spacing = $instance['border_spacing'];
		$border_style	= explode('-', $instance['border_style']);
		$border_width	= $border_style[0];
		
		$border_style2	= $border_style[0] . 'px ' . $border_style[1] . ' ' . $border_style[2];
		
		$click_event = $instance['click_event'];
		$opacity = $instance['opacity'];
		
		$background_color 	= $instance['background_color'];
		
		$hover_border_style 		= explode('-', $instance['hover_border_style']);
		$hover_opacity 				= $instance['hover_opacity'];
		$hover_background_color 	= $instance['hover_background_color'];
		$hover_speed 	= (int)$instance['hover_speed'];
		if($hover_speed < 0) $hover_speed = 250;
		
		$order_by 	= $instance['order_by'] ? $instance['order_by'] : 'ordering';
		$sort_by 	= $instance['sort_by'] ? $instance['sort_by'] : 'asc';
		$widget_width 				= (int)$instance['widget_width'];
		$thumbnail_height 				= $instance['thumbnail_height'];
		
		echo $before_widget; 
		if ( $title ){
			echo $before_title . $title . $after_title; 
		}
		$items_per_page = $grid[0] * $grid[1];
		switch($group[0]){
			case 'all':
				$query = "
					SELECT i.*
					FROM {$wpdb->lbgal_image} i
					WHERE i.status = 1
				";
				break;
			case 'c':
				$query = "
					SELECT i.*
					FROM {$wpdb->lbgal_image} i
					INNER JOIN {$wpdb->lbgal_gallery} g ON g.id = i.gid
					WHERE i.status = 1
						AND g.cid = ".$group[1]."
				";
				break;
			case 'g':
				$query = "
					SELECT i.*
					FROM {$wpdb->lbgal_image} i
					WHERE i.status = 1
						AND i.gid = ".$group[1]."
				";
				break;
		}
		$query .= " ORDER BY ".($order_by == 'random' ? "RAND()" : "i.$order_by $sort_by")." LIMIT 0, $items_per_page";
		$images = $wpdb->get_results($query);
		$count = count($images);
		if($count == 0){
			echo 'No images';
		}else{?>
        <style>
		.lbgallery-widget ul.lbgal-widget-row{
			list-style:none;
			margin:0 !important;
			padding:0 !important;	
		}
		.lbgallery-widget li.lbgal-widget-col{
			list-style:none;
			margin:0;
			padding:0;	
			float:left;
		}
		.lbgallery-widget .lbgal-clearboth{
			clear:both;
			float:none;
			height:0;
		}
		</style>
        <?php
        	$widgetID = uniqid('lbgallery_widget_');
			$settings = LBGalleryHelper::getAllSettings();
			$pretty  = ($settings['global']->lightbox);
			$prettyPhotoSettings = "			
				{
					'overlay_gallery_max'	: 9999,
					'theme'					: '$pretty->theme',
					'overlay_gallery'		: ".($pretty->overlay_gallery ? 'true' : 'false').", 
					'thumb_width'			: ".$pretty->thumb_width.",
					'thumb_height'			: ".$pretty->thumb_height."
					".($pretty->social_tools == 0 ? ", 'social_tools': false" : '')."
				}
			";
		?>
		<div class="lbgallery-widget" id="<?php echo $widgetID;?>" style="">
        <?php
		$i = 0; 
		if(!$widget_width) $widget_width = 100;
		$thumb_width = ($widget_width - $offset[0] * ($grid[1] - 1)) / $grid[1] - ($border_width+$border_spacing)*2;
		
		if(strlen($thumbnail_height) > 0){
			if(substr($thumbnail_height, -1, 1) == '%'){
				$thumbnail_height = floor((int)$thumbnail_height * $thumb_width / 100);
			}else{
				$thumbnail_height = (int)$thumbnail_height;
			}
		}else{
			$thumbnail_height = $thumb_width;
		}
		
		$row = 0; $col = 0;
		foreach($images as $image){
			$margin_left = $offset[0];
        	if($i % $grid[1] == 0){
				if($i != 0){
					echo '<li class="lbgal-clearboth"></li></ul>';					
				}
				echo '<ul class="lbgal-widget-row">';
				$margin_left = 0;
			}
			$margin_top = $i >= $grid[1] ? $offset[1] : 0;
			?>
			<li class="lbgal-widget-col" style="margin-left:<?php echo $margin_left;?>px;margin-top:<?php echo $margin_top;?>px;border:<?php echo $border_style2;?>;<?php echo $background_color ? 'background-color:'.$background_color.';' : '';?>">
            <?php 
				if($click_event == 'lightbox'){
					$event = $image->filename;
					
				}else if($click_event == 'link'){
					$event = $image->linkto;
				}else{
					$event = 'javascript: void(0);';
				}
			
			?>
            	<a class="prettyPhoto" href="<?php echo $event;?>" rel="lbgalleryWidget[<?php echo $widgetID;?>]" style="display:block;margin:<?php echo $border_spacing;?>px;height:<?php echo $thumbnail_height;?>px;" title="<?php echo $image->title;?>">
            		<img src="<?php echo LBGAL_URL;?>/timthumb.php?src=<?php echo base64_encode($image->thumbname ? $image->thumbname : $image->filename);?>&w=<?php echo $thumb_width;?>&h=<?php echo $thumbnail_height;?>" style="max-width:100% !important;" />
				</a>
			</li>
            <?php
			if($i == $count - 1) echo '<li class="lbgal-clearboth"></li></ul>';
			$i++;
		}
		
		//print_r($settings['global']);
		?>
        </div>	
        <script type="text/javascript">
		(function($){ 
			<?php //if($click_event == 'lightbox') echo 'var _lightboxSettings = ' . json_encode($prettyPhotoSettings);?>
			$('#<?php echo $widgetID;?>')
			.find('li').css({opacity: <?php echo $opacity;?>})
			.hover(function(){
				var css = {
					
				}
				var animate = {
					opacity: '<?php echo $hover_opacity;?>'
				}
				<?php if($hover_border_style[1]){?>
				css['border-style'] = '<?php echo $hover_border_style[1];?>';
				<?php }?>
				
				<?php 
				if($hover_border_style[2]){
					if($hover_border_style[2] == 'transparent' || $border_style[2] == 'transparent'){
						echo "css['borderColor'] = '".$hover_border_style[2]."';";
					}else{
						echo "animate['borderColor'] = '".$hover_border_style[2]."';";
					}
				}?>
				
				<?php 
				if($hover_background_color){
					if($hover_background_color == 'transparent' || $background_color == 'transparent'){
						echo "css['backgroundColor'] = '$hover_background_color';";
					}else{
						echo "animate['backgroundColor'] = '$hover_background_color';";
					}
				}
				?>
				
				$(this).stop().css(css).animate(animate, <?php echo $hover_speed;?>);
			}, function(){
				var css = {
					
				}
				var animate = {
					opacity: '<?php echo $opacity;?>'
				}
				
				<?php if($border_style[1]){?>
				css['border-style'] = '<?php echo $border_style[1];?>';
				<?php }?>
				
				<?php 
				if($border_style[2]){
					if($hover_border_style[2] == 'transparent' || $border_style[2] == 'transparent'){
						echo "css['borderColor'] = '".$border_style[2]."';";
					}else{
						echo "animate['borderColor'] = '".$border_style[2]."';";
					}
				}
				?>
				<?php
				if($background_color){
					if($hover_background_color == 'transparent' || $background_color == 'transparent'){
						echo "css['backgroundColor'] = '$background_color';";
					}else{
						echo "animate['backgroundColor'] = '$background_color';";
					}
				}
				?>				
				$(this).stop().css(css).animate(animate, <?php echo $hover_speed;?>);
			})<?php if($click_event == 'lightbox'){?>.find('a.prettyPhoto').prettyPhoto2(<?php echo $prettyPhotoSettings;?>);<?php }?>
			
		})(jQuery);
		</script>		
		<?php }
		echo $after_widget; 
		
    }
	function get_event_link($page_id, $event_id = null, $rep_id = null){

		$page_link = get_permalink($page_id);//event_id=1&rep_id=149
		if($event_id && $rep_id){
			if(strpos($page_link, '?') === false){
				$page_link .= '?';
			}else{
				$page_link .= '&';
			}
			$page_link .= "event_id=$event_id&rep_id=$rep_id";
		}
		return $page_link;
	}
	
    /**  */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		
		$instance['title'] 			= strip_tags(stripslashes($new_instance["title"]));		
		$instance['group_id']		= $new_instance['group_id'];
		$instance['grid']			= $new_instance['grid_x'] . 'x' . $new_instance['grid_y'];
		$instance['offset']			= $new_instance['offset_x'] . 'x' . $new_instance['offset_y'];
		$instance['border_style']		= $new_instance['border_width'] . '-' . $new_instance['border_style'] . '-' . $new_instance['border_color'];
		$instance['border_spacing']		= $new_instance['border_spacing'];
		$instance['click_event']		= $new_instance['click_event'];
		$instance['opacity']		= $new_instance['opacity'];
		$instance['background_color']		= $new_instance['background_color'];
		
		$instance['hover_border_style']		= $new_instance['border_width'] . '-' . $new_instance['hover_border_style'] . '-' . $new_instance['hover_border_color'];
		$instance['hover_opacity']		= $new_instance['hover_opacity'];
		$instance['hover_background_color']		= $new_instance['hover_background_color'];
		$instance['hover_speed']		= $new_instance['hover_speed'];
		$instance['order_by']		= $new_instance['order_by'];
		$instance['sort_by']		= $new_instance['sort_by'];
		$instance['thumbnail_height'] 	= $new_instance['thumbnail_height'];
		$instance['widget_width'] 	= $new_instance['widget_width'];
		
		return $instance;
    }
    /**  */
    function form($instance) {	
		global $wpdb;
		$title 					= esc_attr($instance['title']);		  			
		$group_id				= $instance['group_id'];
		
		$grid	 				= explode('x', $instance['grid']);
		if(!is_array($grid)) $grid = array(0, 0);
		if($grid[0] < 1) $grid[0] = 1;
		if($grid[1] < 1) $grid[1] = 1;
		
		$offset	 				= explode('x', $instance['offset']);
		if(!is_array($offset)) $offset = array(0, 0);
		if(is_null($offset[0]) || $offset[0] < 0) $offset[0] = 0;
		if(is_null($offset[1]) || $offset[1] < 0) $offset[1] = 0;
		$border_spacing			= $instance['border_spacing'];
		if(is_null($border_spacing) || $border_spacing < 0) $border_spacing = 0;
		
		$border_style 			= explode('-', $instance['border_style']);
		if(!is_array($border_style) || count($border_style) < 3) $border_style = array('0', 'solid', '#000000');
		
		$click_event 			= $instance['click_event'];
		if(is_null($click_event)) $click_event = 'lightbox';
		
		$opacity 				= $instance['opacity'];
		if(is_null($opacity)) $opacity = 1;
		
		$background_color 		= $instance['background_color'];
		
		$hover_border_style 		= explode('-', $instance['hover_border_style']);
		if(!is_array($hover_border_style) || count($hover_border_style) < 3 ) $hover_border_style = array('0', 'solid', '#000000');
		
		$hover_opacity 				= $instance['hover_opacity'];
		if(is_null($hover_opacity)) $hover_opacity = 1;
		
		$hover_background_color 	= $instance['hover_background_color'];
		
		$hover_speed 				= $instance['hover_speed'];
		$order_by 					= $instance['order_by'];
		$sort_by 					= $instance['sort_by'];
		
		$thumbnail_height 			= $instance['thumbnail_height'];
		if(is_null($thumbnail_height) || $thumbnail_height < 0) $thumbnail_height = '100%';
		
		$widget_width 				= $instance['widget_width'];
		if(is_null($widget_width) || $widget_width < 0) $widget_width = 100;
		
		$query = "			
			SELECT *
			FROM {$wpdb->lbgal_category}
		";
		$options = array('<option value="all">All Galleries</option>');
		if($categories = $wpdb->get_results($query)){
			foreach($categories as $category){
				$options[] = '<option value="c-'.$category->id.'"'.(($group_id === 'c-'.$category->id) ? ' selected="selected"' :'' ).'>&nbsp;&nbsp;&nbsp;-'.$category->name.'</option>';
				$query = "
					SELECT g.id, g.title, count(i.id) as images
					FROM {$wpdb->lbgal_gallery} g
					LEFT JOIN {$wpdb->lbgal_image} i ON i.gid = g.id
					WHERE g.cid = {$category->id}
					GROUP BY g.id
				";
				if($galleries = $wpdb->get_results($query)){
					foreach($galleries as $gallery){
						
						$options[] = '<option value="g-'.$gallery->id.'"'.(($group_id === 'g-'.$gallery->id) ? ' selected="selected"' :'' ).'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-'.$gallery->title.' ('.$gallery->images.')</option>';
					}
				}
			}
		}
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </label>
		</p>	        
       	<label for="<?php echo $this->get_field_id('group_id'); ?>"><?php _e('Group');?>
            <p>
        	<select name="<?php echo $this->get_field_name('group_id'); ?>" id="<?php echo $this->get_field_id('group_id'); ?>">
            	<?php echo implode("\n", $options);?>
            </select>
        	</p>        
        </label>
        <label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('Order By');?>
            <p>
        	<select name="<?php echo $this->get_field_name('order_by'); ?>" id="<?php echo $this->get_field_id('order_by'); ?>">
            <?php
            foreach(array('ordering'=>'Ordering', 'title'=>'Title', 'created'=>'Date', 'random'=>'Random') as $order=>$title){
				echo '<option value="'.$order.'"'.($order == $order_by ? ' selected="selected"' : '').'>'.$title.'</option>';
			}
			?>
            </select>
            <select name="<?php echo $this->get_field_name('sort_by'); ?>" id="<?php echo $this->get_field_id('sort_by'); ?>">
            <?php
            foreach(array('asc', 'desc') as $sort){
				echo '<option value="'.$sort.'"'.($sort == $sort_by ? ' selected="selected"' : '').'>'.ucfirst($sort).'</option>';
			}
			?>
            </select>
        	</p>        
        </label>
		<?php _e('Rows x Columns'); ?> 
		<p>
            <input class="widefat" id="<?php echo $this->get_field_id('grid_x'); ?>" name="<?php echo $this->get_field_name('grid_x'); ?>" type="text" value="<?php echo $grid[0]; ?>" size="5" style="width:50px;" /> x <input class="widefat" id="<?php echo $this->get_field_id('grid_y'); ?>" name="<?php echo $this->get_field_name('grid_y'); ?>" type="text" value="<?php echo $grid[1]; ?>" size="5" style="width:50px;" />
		</p>
        Widget Width
		<p>
        	<input class="widefat" id="<?php echo $this->get_field_id('widget_width'); ?>" name="<?php echo $this->get_field_name('widget_width'); ?>" type="text" value="<?php echo $widget_width; ?>" size="5" />                
            <small>In pixel. e.g: 100px or 100</small>
		</p>
        <?php _e('Thumbnail Height'); ?> 
		<p>
        	<input class="widefat" id="<?php echo $this->get_field_id('thumbnail_height'); ?>" name="<?php echo $this->get_field_name('thumbnail_height'); ?>" type="text" value="<?php echo $thumbnail_height; ?>" size="5" />        
            <small>In pixel or percent of the thumb width. e.g: 100px or 50% </small>
		</p>
        <?php _e('Offset'); ?> 
		<p>
            <input class="widefat" id="<?php echo $this->get_field_id('offset_x'); ?>" name="<?php echo $this->get_field_name('offset_x'); ?>" type="text" value="<?php echo $offset[0]; ?>" size="5" style="width:50px;" /> x <input class="widefat" id="<?php echo $this->get_field_id('offset_y'); ?>" name="<?php echo $this->get_field_name('offset_y'); ?>" type="text" value="<?php echo $offset[1]; ?>" size="5" style="width:50px;" />
            <br /><small>The space between cols and rows</small>
		</p>
        <?php _e('Border'); ?> 
		<p>
            <input class="widefat" id="<?php echo $this->get_field_id('border_width'); ?>" name="<?php echo $this->get_field_name('border_width'); ?>" type="text" value="<?php echo $border_style[0]; ?>" size="5" style="width:50px;" /> - <?php echo $this->_getBorderStyleList($this->get_field_name('border_style'), $this->get_field_id('border_style'),$border_style[1]);?> - <input class="widefat" id="<?php echo $this->get_field_id('border_color'); ?>" name="<?php echo $this->get_field_name('border_color'); ?>" type="text" value="<?php echo $border_style[2]; ?>" size="7" style="width:70px;" />
            <small>Border width, style (dashed, dotted, solid), color (in hex, empty for transparent)</small>
		</p>
        <?php _e('Border Spacing'); ?> 
		<p>
            <input class="widefat" id="<?php echo $this->get_field_id('border_spacing'); ?>" name="<?php echo $this->get_field_name('border_spacing'); ?>" type="text" value="<?php echo $border_spacing; ?>" size="5" />
            <small></small>
		</p>
        <?php _e('Opacity'); ?> 
		<p>
        	<?php echo $this->_getOpacityList($this->get_field_name('opacity'), $this->get_field_id('opacity'), $opacity);?>
		</p>
        <?php _e('Background Color'); ?> 
		<p>
            <input class="widefat" id="<?php echo $this->get_field_id('background_color'); ?>" name="<?php echo $this->get_field_name('background_color'); ?>" type="text" value="<?php echo $background_color; ?>" size="5" />
            <br /><small>In hex, empty for transparent</small>
		</p>
        <hr />
        
        <?php _e('Hover Border'); ?> 
		<p>
            <input class="widefat" type="text" value="<?php echo $border_style[0]; ?>" size="5" style="width:50px;" disabled="disabled" /> - <?php echo $this->_getBorderStyleList($this->get_field_name('hover_border_style'), $this->get_field_id('hover_border_style'),$hover_border_style[1]);?> - <input class="widefat" id="<?php echo $this->get_field_id('hover_border_color'); ?>" name="<?php echo $this->get_field_name('hover_border_color'); ?>" type="text" value="<?php echo $hover_border_style[2]; ?>" size="7" style="width:70px;" />
		</p>
        <?php _e('Hover Opacity'); ?> 
		<p>
        	<?php echo $this->_getOpacityList($this->get_field_name('hover_opacity'), $this->get_field_id('hover_opacity'), $hover_opacity);?>            
		</p>
        <?php _e('Hover Background Color'); ?> 
		<p>
            <input class="widefat" id="<?php echo $this->get_field_id('hover_background_color'); ?>" name="<?php echo $this->get_field_name('hover_background_color'); ?>" type="text" value="<?php echo $hover_background_color; ?>" size="5" />
		</p>
        <?php _e('Hover Speed'); ?> 
		<p>
        	<?php echo $this->_getMinisecondList($this->get_field_name('hover_speed'), $this->get_field_id('hover_speed'),$hover_speed);?> ms
            
		</p>
        <hr />
        <?php _e('Click Event'); ?> 
		<p>
        <?php
		$_options = array('none' => 'None', 'lightbox' => 'Open Lightbox', 'link' => 'Link');
		?>
        	<select id="<?php echo $this->get_field_id('click_event'); ?>" name="<?php echo $this->get_field_name('click_event'); ?>">
            <?php foreach($_options as $k => $v){?>
            	<option value="<?php echo $k;?>"<?php echo $click_event == $k ? ' selected="selected"' : '';?>><?php echo $v;?></option>
            <?php }?>
            </select>           
		</p>
        <?php
    }
    private function _getBorderStyleList($name, $id = '', $selected = 'solid'){
		$_borderStyles = array(
			'solid' => 'Solid',
			'dotted' => 'Dotted',
			'dashed' => 'Dashed'
		);
		$options = array();
		$options[] = '<select name="'.$name.'" id="'.$id.'">';
		foreach($_borderStyles as $k => $v){
			$options[] = '<option value="'.$k.'"'.($k == $selected ? ' selected="selected"' : '').'>'.$v.'</option>';
		}
		$options[] = '</select>';
		return implode("\n", $options);
	}
	private function _getOpacityList($name, $id = '', $selected = 1){
		$options = array();
		$selected = $selected * 10;
		$options[] = '<select name="'.$name.'" id="'.$id.'">';
		for($i = 0; $i <= 10; $i+=1){
			$options[] = '<option value="'.($i/10).'"'.($i == $selected ? ' selected="selected"' : '').'>'.($i/10).'</option>';
		}
		$options[] = '</select>';
		return implode("\n", $options);
	}
	private function _getMinisecondList($name, $id = '', $selected = 250){
		$options = array();
		$options[] = '<select name="'.$name.'" id="'.$id.'">';
		for($i = 0; $i <= 1000; $i+=50){
			$options[] = '<option value="'.$i.'"'.($i == $selected ? ' selected="selected"' : '').'>'.$i.'</option>';
		}
		$options[] = '</select>';
		return implode("\n", $options);
	}
} 
// register widget
add_action('widgets_init', create_function('', 'return register_widget("lbGalleryWidget");'));
?>