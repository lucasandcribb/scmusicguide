<h3><?php _e('General', 'lb-gallery');?></h3>
<table width="100%">
	<tr>
    	<td style="width:250px;">Date and Time Format</td>
        <td><input type="text" name="settings[global][date_time_format]" value="<?php echo $this->settings->date_time_format;?>" /></td>
    </tr>
    <tr>
    	<td style="width:250px;">Display Author As</td>
        <td>
        <?php
        $author_field = array(
			array('user_login', 'User Login'),
			array('user_nicename', 'User Nice Name'),
			array('user_email', 'User Email'),
			array('display_name', 'User Display Name')
		);
		?>
        	<select name="settings[global][author_field]">
            	<?php foreach($author_field as $k => $v){?>
                <option value="<?php echo $v[0];?>"<?php echo $v[0]==$this->settings->author_field ? ' selected="selected"' : '';?>><?php echo $v[1];?></option>     
                <?php }?>           
            </select>
        </td>
    </tr>
    <tr>
    	<td style="width:250px;">Auto shorten the long title</td>
        <td>
        	<select name="settings[global][shorten_title]">
				<option value="0">No</option>
				<option value="1"<?php echo $this->settings->shorten_title ? ' selected="selected"' : '';?>>Yes</option>
			</select>                
		</td>
    </tr>
</table>


<h3><?php _e('Rating', 'lb-gallery');?></h3>
<table width="100%">
    <tr>
		<td width="250"><?php _e('Star Style', 'lb-gallery');?></td>
       	<td>
		<?
        $stars = array(
			'yellow_star' => array(
				'title' => 'Yellow Star', 
				'src_on' => 'star_yellow_16x16.png',
				'src_off' => 'star_yellow_off_16x16.png',
				'class' => 'yellow-star',
				'size' => array(16,16)
			),
			'red_star' => array(
				'title' => 'Red Star', 
				'src_on' => 'star_red_16x16.png',
				'src_off' => 'star_red_off_16x16.png',
				'size' => array(16,16),
				'class' => 'red-star'
			),
			'yellow_star_square' => array(
				'title' => 'Yellow Star Square', 
				'src_on' => 'star_yellow_square_16x16.png',
				'src_off' => 'star_yellow_square_off_16x16.png',
				'size' => array(16,16),
				'class' => 'yellow-star-square'
			)
		);
		?>
        	<select name="settings[global][star_style]" id="settings_global_star_style">
            <?php foreach($stars as $key => $star){?>
            	<option value="<?php echo $key;?>"<?php echo $this->settings->star_style == $key ? ' selected="selected"' : '';?>><?php echo $star['title'];?></option>
            <?php }?>    
            </select>
            <style>
			.lbgal-star_preview,
			.lbgal-star_preview span{
				display:inline-block;	
			}
			</style>
            <span class="lbgal-star_preview"><span></span></span>
	        <p></p>
            <script>
			jQuery(function($){
				var starStyle = <?php echo json_encode($stars);?>;
				$('#settings_global_star_style').change(function(){
					var starName = $(this).val(),
						star = starStyle[starName];
						
					
					$('.lbgal-star_preview')
					.css({
						width: star.size[0] * 5,
						height: star.size[1],
						backgroundImage: 'url(<?php echo LBGAL_IMAGES;?>/'+star.src_off+')',
						padding: 0,
					}).find('span')
					.css({
						width: star.size[0] * 2.5,
						height: star.size[1],
						backgroundImage: 'url(<?php echo LBGAL_IMAGES;?>/'+star.src_on+')',
						padding: 0
					});
				}).trigger('change');
			})
			</script>
       </td>
    </tr>   
     
    <tr>
        <td class="label"><?php _e('Star Rating', 'lb-gallery');?></td>
        <td>
        <select name="settings[global][half_star]">
        	<option value="1"<?php echo $this->settings->half_star == 1 ? ' selected="selected"' : '';?>><?php _e("1 Star", "lb-gallery");?></option>
            <option value="0.5"<?php echo $this->settings->half_star == 0.5 ? ' selected="selected"' : '';?>><?php _e("0.5 Star", "lb-gallery");?></option>
            <option value="0.25"<?php echo $this->settings->half_star == 0.25 ? ' selected="selected"' : '';?>><?php _e("0.25 Star", "lb-gallery");?></option>
		</select>            
        	<p>Yes, you can use rating by 0.25 or 0.5 star</p>
        </td>
    </tr>
</table>    
<h3>Lightbox Options</h3>
<table width="100%">
	<tr><td style="width:250px;"></td><td></td></tr>
    <tr>
    	<td>Theme</td>
        <td>
        <?php
		$themes = array(
			'pp_default' 	=> 'Default',
			'dark_rounded' 	=> 'Dark Rounded',
			'dark_square' 	=> 'Dark Square',
			'facebook'		=> 'FaceBook',
			'light_rounded' => 'Light Rounded',
			'light_square'	=>'Light Square'
		);
		?>
        <select name="settings[global][lightbox][theme]">
        <?php foreach($themes as $theme=>$text){ ?>
			<option value="<?php echo $theme;?>"<?php echo $this->settings->lightbox->theme == $theme ? ' selected="selected"' : '';?>><?php echo $text;?></option>
		<?php } ?>
        </select>
        <p>Lightbox theme</p>
        </td>
    </tr>
    <tr>
    	<td>Overlay Gallery</td>
        <td>        	
            <?php $_options = array('0' => 'No', 1 => 'Yes');?>
            <select name="settings[global][lightbox][overlay_gallery]">
            <?php foreach($_options as $k=>$v){?>
            	<option value="<?php echo $k;?>"<?php echo $this->settings->lightbox->overlay_gallery == $k ? ' selected="selected"' : '';?>><?php echo $v;?></option>
            <?php }?>
            </select>
            <p>Show thumbnail of gallery when mouseover on the lightbox</p>
        </td>
    </tr>
    <tr>
    	<td>Gallery Dimension</td>
        <td><input type="text" name="settings[global][lightbox][thumb_width]" size="10" value="<?php echo $this->settings->lightbox->thumb_width;?>" /> x <input type="text" size="10"  name="settings[global][lightbox][thumb_height]" value="<?php echo $this->settings->lightbox->thumb_height;?>" />
        	<p>The width and height of thumbnail gallery (in pixel)</p>
        </td>
    </tr>
    <tr>
    	<td>Social</td>
        <td>
        <?php $_options = array('0' => 'No', 1 => 'Yes');?>
            <select name="settings[global][lightbox][social_tools]">
            <?php foreach($_options as $k=>$v){?>
            	<option value="<?php echo $k;?>"<?php echo $this->settings->lightbox->social_tools == $k ? ' selected="selected"' : '';?>><?php echo $v;?></option>
            <?php }?>
            </select>
            <p>Show Social Tool on the lightbox</p>
        </td>
    </tr>
</table>