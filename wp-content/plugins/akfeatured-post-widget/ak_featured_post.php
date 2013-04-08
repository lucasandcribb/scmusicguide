<?
/*
Plugin Name: AK: Featured Post Sidebar Widget
Plugin URI: http://cssboss.com/featured_post
Description: Easily configure this widget to display any amount of posts (from 1 to 99) from a category into any widgetized area of your blog. Video is more my style, so check out this video tutorial I made for the plugin <a href="http://www.youtube.com/watch?v=eWhafkO7uJQ">Here</a>
Version: 1.7
Author: Andrew Kaser
Author URI: http://www.cssboss.com/about
Text-Domain: ak-featured-posted
*/

/*  Copyright 2012  ANDREW KASER  (email : Kaser@CSSBoss.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	class ak_featured_post_widget extends WP_Widget {

		public function form( $instance ) {
			// define all variables of the widget, and also set default values 
			if ( isset( $instance[ 'category' ] ) ) { $category = $instance[ 'category' ]; } else { $category = __( 'Featured' , 'text_domain' ); }
			if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ]; } else { $title = __( 'Featured Post' , 'text_domain' ); }
			
			if ( isset( $instance[ 'show_post_limit' ] ) ) { $show_post_limit = $instance[ 'show_post_limit' ]; } else { $show_post_limit = __( '1' , 'text_domain' ); }
			if ( isset( $instance[ 'order_post' ] ) ) { $order_post = $instance[ 'order_post' ]; } else { $order_post = __( 'DESC' , 'text_domain' ); }
			
			if ( isset( $instance[ 'link_title_to_cat' ] ) ) { $link_title_to_cat = $instance[ 'link_title_to_cat' ]; } else { $link_title_to_cat = __( 'checked' , 'text_domain' ); }
			if ( isset( $instance[ 'show_post_title' ] ) ) { $show_post_title = $instance[ 'show_post_title' ]; } else { $show_post_title = __( 'checked' , 'text_domain' ); }
			
			if ( isset( $instance[ 'show_featured_image' ] ) ) { $show_featured_image = $instance[ 'show_featured_image' ]; } else { $show_featured_image = __( 'checked' , 'text_domain' ); }
			if ( isset( $instance[ 'image_align' ] ) ) { $image_align = $instance[ 'image_align' ]; } else { $image_align = __( 'center' , 'text_domain' ); }
			if ( isset( $instance[ 'image_size' ] ) ) { $image_size = $instance[ 'image_size' ]; } else { $image_size = __( 'medium' , 'text_domain' ); }
			if ( isset( $instance[ 'image_width' ] ) ) { $image_width = $instance[ 'image_width' ]; } else { $image_width = __( '' , 'text_domain' ); }
			if ( isset( $instance[ 'image_height' ] ) ) { $image_height = $instance[ 'image_height' ]; } else { $image_height = __( '' , 'text_domain' ); }
			
			if ( isset( $instance[ 'post_type' ] ) ) { $post_type = $instance[ 'post_type' ]; } else { $post_type = __( 'post' , 'text_domain' ); }
			if ( isset( $instance[ 'custom_post_type' ] ) ) { $custom_post_type = $instance[ 'custom_post_type' ]; } else { $custom_post_type = __( '' , 'text_domain' ); }
			
			if ( isset( $instance[ 'show_support_link' ] ) ) { $show_support_link = $instance[ 'show_support_link' ]; } else { $show_support_link = __( 'checked' , 'text_domain' ); }
			
			$post_type_id = $this->get_field_id( 'post_type' ); 
			?>
		
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title :' ); ?></label> 
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" style="width:192px;"/>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"> <?php _e( 'Post Type :' ); ?> </label> 
				<select id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" onchange="showOps(this)" class="post_type_option" style="width: 161px;">	
					<option value="post" <? if ( $post_type == "post" ) { echo 'selected="selected"'; } ?> >Post</option>
					<option value="custom" <? if ( $post_type == "custom" ) { echo 'selected="selected"'; } ?> >Custom Post Type</option>
				</select>
			</p>
			<p id="<?php echo $this->get_field_id( 'post_type' ); ?>_id"  <?php if ( $post_type != "custom") { echo 'style="display:none;"'; } ?> class="hidden_options">
				<label for="<?php echo $this->get_field_id( 'custom_post_type' ); ?>"><?php _e( 'Custom Post Type:' ); ?></label> 
				<input id="<?php echo $this->get_field_id( 'custom_post_type' ); ?>" name="<?php echo $this->get_field_name( 'custom_post_type' ); ?>" type="text" value="<?php echo esc_attr( $custom_post_type); ?>" style="width:225px;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'show_post_limit' ); ?>"><?php _e( 'Show How Many Posts:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'show_post_limit' ); ?>" name="<?php echo $this->get_field_name( 'show_post_limit' ); ?>" type="text" value="<?php echo esc_attr( $show_post_limit ); ?>" maxlength="2" style="text-align:center;width:95px;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('order_post'); ?>"><?php _e('Order Posts:'); ?></label>
				<select id="<?php echo $this->get_field_id( 'order_post' ); ?>" name="<?php echo $this->get_field_name( 'order_post' ); ?>" style="width:154px;" >
					<option value="ASC" <?php if ( $order_post == "ASC" ) { echo 'selected="selected"'; } ?>>Oldest to Newest</option>
					<option value="DESC" <?php if ( $order_post == "DESC" ) { echo 'selected="selected"'; } ?>>Newest to Oldest</option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category :' ); ?></label>
				<select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" style="width:165px;" >
					<option value="none">All</option>
					<?php
						$categories_list = get_categories();
						foreach ($categories_list as $list_category ) {

							if ( $list_category->cat_ID == $category ) {
								$selected = 'selected="selected"';
							} else {
								$selected = '';
							}

							echo '<option value="'.$list_category->cat_ID.'" '. selected($list_category->cat_ID, $instance['category']).'>'. $list_category->cat_name.'</option>';
						}
					?>
				</select>
			</p>

			<p style="text-align:right;">
				<label for="<?php echo $this->get_field_id( 'show_post_title' ); ?>"><?php _e( 'Show The Post\'s Title :' ); ?></label> 
				<input id="<?php echo $this->get_field_id( 'show_post_title' ); ?>" name="<?php echo $this->get_field_name( 'show_post_title' ); ?>" type="checkbox" value="<?php echo esc_attr( $show_post_title ); ?>" <?php checked( (bool) $show_post_title, true ); ?> onchange="showLinktitle(this)" />
			</p>

			<p id="<?php echo $this->get_field_id( 'show_post_title' ); ?>_id"  style="text-align:right;<?php if ( $show_post_title == false ) { echo 'display:none;'; } ?>" class="hidden_options">
				<label for="<?php echo $this->get_field_id( 'link_title_to_cat' ); ?>"><?php _e( 'Link Title To Category :' ); ?></label> 
				<input id="<?php echo $this->get_field_id( 'link_title_to_cat' ); ?>" name="<?php echo $this->get_field_name( 'link_title_to_cat' ); ?>" type="checkbox" value="<?php echo esc_attr( $link_title_to_cat ); ?>" <?php checked( (bool) $link_title_to_cat, true ); ?> />
			</p>

			<p style="text-align:right;">
				<label for="<?php echo $this->get_field_id( 'show_featured_image' ); ?>"><?php _e( 'Show Featured Image :' ); ?></label> 
				<input id="<?php echo $this->get_field_id( 'show_featured_image' ); ?>" name="<?php echo $this->get_field_name( 'show_featured_image' ); ?>" type="checkbox" value="<?php echo esc_attr( $show_featured_image ); ?>" <?php checked( (bool) $show_featured_image, true ); ?> onchange="showFeaturedImageOps(this)"/>
			</p>

			<p <?php if ( $show_featured_image == false ) { echo 'style="display:none;"'; } ?> class="hidden_options">
				<label for="<?php echo $this->get_field_id( 'image_align' ); ?>"><?php _e( 'Align Image :' ); ?></label> 
				<select id="<?php echo $this->get_field_id( 'image_align' ); ?>" name="<?php echo $this->get_field_name( 'image_align' ); ?>" style="width:150px;">	
					<option value="left" <? if ( $image_align == "left" ) { echo 'selected="selected"'; } ?>  style="text-align:left;">Left</option>
					<option value="center" <? if ( $image_align == "center" ) { echo 'selected="selected"'; }  ?>   style="text-align:center;">Center</option>
					<option value="right" <? if ( $image_align == "right" ) { echo 'selected="selected"'; }  ?>  style="text-align:right;" >Right</option>
				</select>
			</p>

			<p <?php if ( $show_featured_image == false ) { echo 'style="display:none;"'; } ?> class="hidden_options">
				<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size :' ); ?></label> 
				<select id="<?php echo $this->get_field_id( 'image_size' ); ?>" name="<?php echo $this->get_field_name( 'image_size' ); ?>" class="image_size_options" onchange="showOps(this)" style="width:154px;">	
					<option value="custom" <? if ( $image_size == "custom" ) { echo 'selected="selected"'; } ?>  >Custom</option>
					<option value="thumbnail" <? if ( $image_size == "thumbnail" ) { echo 'selected="selected"'; } ?> >Thumbnail</option>
					<option value="medium" <? if ( $image_size == "medium" ) { echo 'selected="selected"'; } ?> >Medium</option>
					<option value="large" <? if ( $image_size == "large" ) { echo 'selected="selected"'; } ?> >Large</option>
					<option value="full" <? if ( $image_size == "full" ) { echo 'selected="selected"'; } ?> >Full</option>
				</select>
			</p>

			<p id="<?php echo $this->get_field_id( 'image_size' ); ?>_id" <?php if ( $image_size != "custom") { echo 'style="display:none;"'; } ?> class="hidden_options">
				<label for="<?php echo $this->get_field_id( 'image_width' ); ?>"><?php _e( 'Width :' ); ?></label> 
				<input id="<?php echo $this->get_field_id( 'image_width' ); ?>" name="<?php echo $this->get_field_name( 'image_width' ); ?>" type="text" value="<?php echo esc_attr( $image_width ); ?>" <?php checked( (bool) $image_width, true ); ?> style="width:65px;text-align:center;" />
				<label for="<?php echo $this->get_field_id( 'image_height' ); ?>"><?php _e( 'Height :' ); ?></label> 
				<input id="<?php echo $this->get_field_id( 'image_height' ); ?>" name="<?php echo $this->get_field_name( 'image_height' ); ?>" type="text" value="<?php echo esc_attr( $image_height ); ?>" <?php checked( (bool) $image_height, true ); ?> style="width:69px; text-align:center;" />
			</p>

			<p style="text-align:right;">
				<label for="<?php echo $this->get_field_id( 'show_support_link' ); ?>"><?php _e( 'Show Support Link :' ); ?></label> 
				<input id="<?php echo $this->get_field_id( 'show_support_link' ); ?>" name="<?php echo $this->get_field_name( 'show_support_link' ); ?>" type="checkbox" value="<?php echo esc_attr( $show_support_link ); ?>" <?php checked( (bool) $show_support_link, true ); ?> />
			</p>

			<p style="text-align:right;">
				<a href="http://www.cssboss.com" target="_blank">CSSBoss.com</a> - <a href="http://www.youtube.com/subscription_center?add_user=thecssboss" target="_blank">Youtube</a> - <a href="http://www.csssboss.com/donate" target="_blank">Donate</a> <strong>&#9774;</strong>
			</p>
			<?php
			
		}

		public function widget($args, $instance)
		{
			// let's save the post data for after the widget.
			global $post;
			$post_old = $post;

			extract( $args );	// grabbing all the args for the widget

			// setting all the args for the widget
			$title = apply_filters( 'widget_title', $instance['title'] );
			
			// I hate when I can't select to display posts from ALL categories if I want to... so here you go :)
			if ( $instance['category'] != "none" ) {
				$category = '&cat='.$instance['category'];
			} else {
				$category = '';
			}

			$post_type				= $instance['post_type'];
			$custom_post_type 		= $instance['custom_post_type'];
			$order_post 			= $instance['order_post'];
			$link_title_to_cat 		= $instance['link_title_to_cat'];
			$show_post_title 		= $instance['show_post_title'];
			$show_post_limit 		= $instance['show_post_limit'];
			$show_featured_image 	= $instance['show_featured_image'];
			$show_support_link 		= $instance['show_support_link'];
			$image_size 			= $instance['image_size'];
			$image_align 			= $instance['image_align'];

			// build the size variable to use with wp_query
			if ( $image_size == "custom" ) {
				$image_width = $instance['image_width'];
				$image_height = $instance['image_height'];
				$size = array( $image_width, $image_height );
			} else {
				$size = $image_size;
			}

			// start the widget
			echo $before_widget;

			// Let's build the title of the widget
			if ( $link_title_to_cat ) {
				echo $before_title . '<a href="' . get_category_link($category) . '">'.$title.'</a>'.$after_title;
			} else {
				echo $before_title . $title . $after_title;
			}

			// some post type checks real quick
			if ($post_type == "custom" ) {
				$post_type = $custom_post_type;
			}

			echo "<ul>"; // thanks Dan ;)

			// this is where all the magic happens.
			$ak_featured_posts_query = new WP_Query( $category.'&showposts='.$show_post_limit.'&order='.$order_post.'&post_type='.$post_type ); // get new post data

			while ( $ak_featured_posts_query->have_posts() ) : $ak_featured_posts_query->the_post();
				$image_title = get_the_title();  // The alt text for the featured image
				?>
					<li>
						<a href="<?php the_permalink(); ?>">
							<?php
								if ($show_post_title) // To show the title of the post, or not...
								{
									the_title();
								}

								if ( $show_featured_image )
								{
									if ( has_post_thumbnail() )
									{
										echo '<br />';
										the_post_thumbnail($size,
											array(
												'class' => 'ak_featured_post_image align'.$image_align.' ',
												'title' => $image_title
											)
										);
									} 
								}
							?>
							<br style="clear:both;" />
						</a>
					</li>
				<?php
			endwhile;

			echo "</ul>";

			if ( $show_support_link ) 
			{ 
				echo '<p>Powered By <a href="http://www.cssboss.com/featured_post" target="_blank">AK: Featured Post</a></p>'; 
			}

			echo $after_widget; // end widget

			$post = $post_old; // finally, restoring the original post data, as if we never even touched it ;)
		}
		
		//fun stuff is over
		public function __construct() 
		{
			parent::__construct(
	 			'ak_featured_post_widget', // Base ID
				'AK: Featured Post', // Name
				array( 'description' => __( 'Display the latest post from a category', 'text_domain' ), ) // Args
			);
		}
	
		public function ak_featured_post()
		{
			$widget_ops = array(
				'classname'=>'ak-featured-post', // class that will be added to li element in widgeted area ul
				'description'=>'Display post from category' // description displayed in admin
			);
			$control_ops = array(
				'width'=>200, 'height'=>250, // width of input widget in admin
				'id_base'=>'ak-featured-post' // base of id of li element ex. id="example-widget-1"
			);
			$this->WP_Widget( 'ak_featured_post', 'AK: Featured Post', $widget_ops, $control_ops ); // "Example Widget" will be name in control panel
		}
		
		public function update( $new_instance, $old_instance ) 
		{
			// save the widget info
			$instance = array();
			$instance['show_post_limit'] 	 = strip_tags( $new_instance['show_post_limit'] );
			$instance['order_post'] 		 = strip_tags( $new_instance['order_post'] );
			$instance['post_type'] 			 = strip_tags( $new_instance['post_type'] );
			$instance['custom_post_type']	 = strip_tags( $new_instance['custom_post_type'] );
			$instance['category'] 			 = strip_tags( $new_instance['category'] );
			$instance['title'] 				 = strip_tags( $new_instance['title'] );
			$instance['image_align']		 = strip_tags( $new_instance['image_align'] );
			$instance['image_size'] 		 = strip_tags( $new_instance['image_size'] );
			$instance['image_width'] 		 = strip_tags( $new_instance['image_width'] );
			$instance['image_height'] 		 = strip_tags( $new_instance['image_height'] );
			$instance['link_title_to_cat'] 	 = ( isset( $new_instance['link_title_to_cat'] ) ? 1 : 0 );
			$instance['show_post_title'] 	 = ( isset( $new_instance['show_post_title'] ) ? 1 : 0 );
			$instance['show_featured_image'] = ( isset( $new_instance['show_featured_image'] ) ? 1 : 0 );
			$instance['show_support_link'] 	 = ( isset( $new_instance['show_support_link'] ) ? 1 : 0 );
			return $instance;
		}
	}
	
	function ak_admin_js_enque($hook) {
	    if( $hook == 'widgets.php' )
	    wp_enqueue_script( 'my_custom_script', plugins_url('/akfp_admin_widget.js', __FILE__) , array( 'jquery' ) );
	}
	add_action( 'admin_enqueue_scripts', 'ak_admin_js_enque' );
	add_action( 'widgets_init', create_function( '', 'register_widget( "ak_featured_post_widget" );' ) );

?>