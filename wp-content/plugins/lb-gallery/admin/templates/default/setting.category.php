<?php 
$galleryBlocks = array(
	'title' => 'Title', 
	'description' => 'Description', 
	'rating' => 'Rating', 
	'author' => 'Author', 
	'date' => 'Date', 
	'num_of_photos' => 'Num of Photos',
	'link' => 'Link'
);

?>
<table width="100%">
    <tr>
        <td class="label" style="width:200px;">
        <?php _e('Select a category', 'lb-gallery');?>
        </td>
        <td>
            <?php echo $lists['gallery'];?>        
        </td>
    </tr>
</table>
<br />
<table width="100%">
	<tr><td style="width:200px;"></td><td></td></tr>
	<!--<tr>
        <td class="label" style="width:250px;"><?php _e('Show Top Bar', 'lb-gallery');?></td>
        <td>
        <select name="settings[category][show_top_bar]">
        	<option value="0"<?php echo $this->settings->show_top_bar ? '' : ' selected="selected"';?>><?php _e('No', 'lb-gallery');?></option>
            <option value="1"<?php echo !$this->settings->show_top_bar ? '' : ' selected="selected"';?>><?php _e('Yes', 'lb-gallery');?></option>
        </select>
        </td>
    </tr>
    <tr>
        <td class="label" style="width:250px;"><?php _e('Show Categories Dropdown', 'lb-gallery');?></td>
        <td>
        <select name="settings[category][show_category_dropdown]">
        	<option value="0"<?php echo $this->settings->show_category_dropdown ? '' : ' selected="selected"';?>><?php _e('No', 'lb-gallery');?></option>
            <option value="1"<?php echo !$this->settings->show_category_dropdown ? '' : ' selected="selected"';?>><?php _e('Yes', 'lb-gallery');?></option>
        </select>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Show Galleries Dropdown', 'lb-gallery');?></td>
        <td>
        <select name="settings[category][show_gallery_dropdown]">
        	<option value="0"<?php echo $this->settings->show_gallery_dropdown ? '' : ' selected="selected"';?>><?php _e('No', 'lb-gallery');?></option>
            <option value="1"<?php echo !$this->settings->show_gallery_dropdown ? '' : ' selected="selected"';?>><?php _e('Yes', 'lb-gallery');?></option>
        </select>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Show Back Gallery Button', 'lb-gallery');?></td>
        <td>
        <select name="settings[category][show_back_gallery_button]">
        	<option value="0"<?php echo $this->settings->show_back_gallery_button ? '' : ' selected="selected"';?>><?php _e('No', 'lb-gallery');?></option>
            <option value="1"<?php echo !$this->settings->show_back_gallery_button ? '' : ' selected="selected"';?>><?php _e('Yes', 'lb-gallery');?></option>
        </select>
        </td>
    </tr> 
    <tr>
        <td class="label" style="width:200px;"><?php _e('Width', 'lb-gallery');?></td>
        <td>
            <input type="text" name="settings[category][width]" value="<?php echo $this->settings->width;?>" class="textfield" /><span>(% or px)</span>
            <p>Width in pixel or percent of the page, e.g: 1000px or 100%</p>
        </td>
    </tr>--> 
    <tr>
        <td class="label" style="width:200px;"><?php _e('Gallery Rating?', 'lb-gallery');?></td>
        <td>
            <select name="settings[category][gallery_rating]">
                <option value="1"<?php echo $this->settings->gallery_rating == '1' ? ' selected="selected"' : '';?>><?php _e('Yes', 'lb-gallery');?></option>
                <option value="0"<?php echo $this->settings->gallery_rating == '0' ? ' selected="selected"' : '';?>><?php _e('No', 'lb-gallery');?></option>
            </select>
            <p>Enable rating for each image or all images in a gallery</p>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Gallery Read More Link?', 'lb-gallery');?></td>
        <td>
            <select name="settings[category][gallery_link]">
                <option value="1"<?php echo $this->settings->gallery_link == '1' ? ' selected="selected"' : '';?>><?php _e('Yes', 'lb-gallery');?></option>
                <option value="0"<?php echo $this->settings->gallery_link == '0' ? ' selected="selected"' : '';?>><?php _e('No', 'lb-gallery');?></option>
            </select>
            <p>Enable link for each image or each gallery</p>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Cols x Rows', 'lb-gallery');?></td>
        <td><input type="text" class="textfield" name="settings[category][thumb_cols]" value="<?php echo $this->settings->thumb_cols;?>" /> <span>x</span> <input type="text" class="textfield" name="settings[category][thumb_rows]" value="<?php echo $this->settings->thumb_rows;?>" /><span>(items)</span>
            <p>Number of col and row, e.g: 3 x 3</p>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Offset', 'lb-gallery');?></td>
        <td><input type="text" class="textfield" name="settings[category][col_offset]" value="<?php echo $this->settings->col_offset;?>" /> <span>x</span> <input type="text" class="textfield" name="settings[category][row_offset]" value="<?php echo $this->settings->row_offset;?>" /> <span>(px)</span>
            <p>The space between cols and rows, e.g: 30 x 30 for column margin and row margin are 30px</p>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Thumbnail Width', 'lb-gallery');?></td>
        <td>
        	<input type="text" class="textfield" name="" value="???" disabled="disabled" />
            <p>Thumbnail width will be auto calculate by ([Width] / ([Cols - 1] * [Column Offset])) / [Cols]</p>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Thumbnail Height', 'lb-gallery');?></td>
        <td><input type="text" class="textfield" name="settings[category][thumb_height]" value="<?php echo $this->settings->thumb_height;?>" /> <span>(% or px)</span>
            <p>Thumbnail Height in % (of Thumbnail Width) or px format</p>
        </td>
    </tr>
    <tr><td colspan="2" height="30"></td></tr>
    <tr>
        <td class="label"><?php _e('Thumbnail Layout', 'lb-gallery');?></td>
        <td>
            <table>
            <tr><td valign="top">
                <ul class="lbgal-text-block connectedSortable">
                <?php 
                $usedBlocks = array();
                foreach(array('top', 'thumb', 'bottom') as $block){		
                    $usedBlocks = array_merge($usedBlocks, (array)$this->settings->blocks->$block);			
                }
                foreach($galleryBlocks as $k=>$block){
                    if(!in_array($k, $usedBlocks)){
                ?>
                    <li class="dragable"><?php _e($galleryBlocks[$k], 'lb-gallery');?><input type="hidden" name="" value="<?php echo $k;?>" title="" /></li>
                <?php 
                    }
                }					
                ?>                   
                </ul>
            </td>
            <td valign="top">
                <ul class="lbgal-text-block connectedSortable top">
                	<li class="lb-block-description"><p><?php _e('Above the thumbnail', 'lb-gallery');?></p></li>
                <?php if($this->settings->blocks->top){?>
                <?php foreach($this->settings->blocks->top as $k=>$v){?>
                    <li class="dragable"><?php _e($galleryBlocks[$k], 'lb-gallery');?><input type="hidden" name="" value="<?php echo $k;?>" /></li>
                <?php }?>
                <?php }?>
                </ul>                
                <ul class="lbgal-text-block connectedSortable thumb">                	
                	<li class="lb-block-description"><p><?php _e('Inside the thumbnail', 'lb-gallery');?></p></li>
                <?php if($this->settings->blocks->thumb){?>
                <?php foreach($this->settings->blocks->thumb as $k=>$v){?>
                    <li class="dragable"><?php _e($galleryBlocks[$k], 'lb-gallery');?><input type="hidden" name="" value="<?php echo $k;?>" /></li>
                <?php }?>
                <?php }?>
                </ul>
                <ul class="lbgal-text-block connectedSortable bottom">
                	<li class="lb-block-description"><p><?php _e('Below the thumbnail', 'lb-gallery');?></p></li>
                <?php if($this->settings->blocks->bottom){?>
                <?php foreach($this->settings->blocks->bottom as $k=>$v){?>
                    <li class="dragable"><?php _e($galleryBlocks[$k], 'lb-gallery');?><input type="hidden" name="" value="<?php echo $k;?>" /></li>
                <?php }?>
                <?php }?>
                </ul>
            </td>
            </tr>
            </table>
            
            <p>Drag and Drop blocks from left to right to display blocks on the list</p>
        </td>
    </tr><tr>
    	<td>Blocks's Text</td>
        <td>
        	<div>
                Title<br />
                <input type="text" name="settings[category][blocks_text][title]" value="<?php echo $this->settings->blocks_text->title;?>" size="50" style="color:#999;" />
            </div>
            <div><br />
                Description<br />
                <input type="text" name="settings[category][blocks_text][description]" value="<?php echo $this->settings->blocks_text->description;?>" size="50" style="color:#999;" />
            </div>
            <div><br />
                Author<br />
                <input type="text" name="settings[category][blocks_text][author]" value="<?php echo $this->settings->blocks_text->author;?>" size="50" style="color:#999;" />
            </div>
            <div><br />
                Date<br />
                <input type="text" name="settings[category][blocks_text][date]" value="<?php echo $this->settings->blocks_text->date;?>" size="50" style="color:#999;" />
            </div>
            <div><br />
                Num Of Photos<br />
                <input type="text" name="settings[category][blocks_text][num_of_photo]" value="<?php echo $this->settings->blocks_text->num_of_photo;?>" size="50" style="color:#999;" />
            </div>
            <div><br />
                Link<br />
                <input type="text" name="settings[category][blocks_text][link]" value="<?php echo $this->settings->blocks_text->link;?>" size="50" style="color:#999;" />
            </div>
            <div><br />
                Rating<br />
                <input type="text" name="settings[category][blocks_text][rating]" value="<?php echo $this->settings->blocks_text->rating;?>" size="50" style="color:#999;" />
            </div>
        </td>
    </tr> 
    <tr>
        <td class="label"><?php _e('Thumbnail Opacity', 'lb-gallery');?></td>
        <td>
        	<select name="settings[category][thumb_opacity]">
            <?php $opacity = $this->settings->thumb_opacity*10;
			for($i = 0; $i <= 10; $i++){?>
            	<option value="<?php echo $i/10;?>"<?php echo $i == $opacity ? ' selected="selected"' : '';?>><?php echo $i/10;?></option>
            <?php }?>
            </select> 
            <p></p>       	
        </td>
	</tr>
    <tr>
        <td class="label"><?php _e('Thumbnail Hover Opacity', 'lb-gallery');?></td>
        <td>
        	<select name="settings[category][thumb_hover_opacity]">
            <?php $opacity = $this->settings->thumb_hover_opacity*10;
			for($i = 0; $i <= 10; $i++){?>
            	<option value="<?php echo $i/10;?>"<?php echo $i == $opacity ? ' selected="selected"' : '';?>><?php echo $i/10;?></option>
            <?php }?>
            </select> 
            <p></p>       	
        </td>
	</tr>   
    <tr>
        <td class="label"><?php _e('Text Hover Effect', 'lb-gallery');?></td>
        <td>
            <select name="settings[category][thumb_text_effect]">  
            <?php 
            $textEffects = array(
                'visible' => 'Always visible',
                'slide-up-in' => 'Slide Up In',
                'slide-down-in' => 'Slide Down In',
                'slide-left-in' => 'Slide Left In',
                'slide-right-in' => 'Slide Right In',
                'fade-in' => 'Fade In',
                'slide-up-out' => 'Slide Up Out',
                'slide-down-out' => 'Slide Down Out',
                'slide-left-out' => 'Slide Left Out',
                'slide-right-out' => 'Slide Right Out',
                'fade-out' => 'Fade Out'
            );
            foreach($textEffects as $class=>$label){
            ?> 
                <option value="<?php echo $class;?>"<?php echo $this->settings->thumb_text_effect == $class ? ' selected="selected"' : ''?>><?php _e($label, 'lb-gallery');?></option>             
            <?php
            }
            ?>                    	            
            </select>
            <p></p>
        </td>
    </tr>
    <tr>
    	<td>Border</td>
        <td>        	
            <input type="text" size="10" name="settings[category][border_width]" value="<?php echo $this->settings->border_width;?>" /> <span>(px)</span>
            <?php
            $_borderStyles = array(
                'dashed', 'dotted', 'solid' 
            );
            ?>
            <select name="settings[category][border_style]">
            <?php foreach($_borderStyles as $style){?>
                <option value="<?php echo $style;?>"<?php echo $this->settings->border_style == $style ? ' selected="selected"' : '';?>><?php echo $style;?></option>
            <?php }?>
            </select> 
            <input type="text" size="10" name="settings[category][border_color]" value="<?php echo $this->settings->border_color;?>" /> <div class="colorSelector"><div style="background-color: <?php echo $this->settings->border_color;?>;"></div></div><span>(hex)</span>
            <span>(width-style-color)</span>
            <p>Border Width (in pixel), style (dashed-dotted-solid), color (in hex, empty for transparent). e.g: 1px solid #000000</p>
        </td>
    </tr>    
    <tr>
    	<td>Border Spacing</td>
        <td>
        	<input type="text" size="10" name="settings[category][border_spacing_topbottom]" value="<?php echo $this->settings->border_spacing_topbottom;?>" /> <span>px (top-bottom)</span>
            <br />
            <input type="text" size="10" name="settings[category][border_spacing_leftright]" value="<?php echo $this->settings->border_spacing_leftright;?>" /> <span>px (left-right)</span>
            <p>Border spacing from top, bottom and left, right</p>
        </td>
    </tr>
    <tr>
    	<td>Background</td>
        <td>
        	<input type="text" size="10" name="settings[category][background_color]" value="<?php echo $this->settings->background_color;?>" /> <div class="colorSelector"><div style="background-color: <?php echo $this->settings->background_color;?>;"></div></div><span>(Color)</span>
            <p>(Color in hex format, empty for transparent)</p>
            <br />
            <input type="text" size="100" name="settings[category][background_image]" value="<?php echo $this->settings->background_image;?>" /> (Image)
            <p>(URL of an image, empty for none)</p>
        </td>
    </tr>
</table>
<script>
(function($){
$.each($('.colorSelector'), function(){
	var $this = $(this),
		$input = $this.prev();
	$this.ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$input.val('#'+hex.toUpperCase());
			$this.find('div').css({backgroundColor: $input.val()});
			$this.ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor($input.val());
		},
		onChange: function(hsb, hex, rgb){
			$input.val('#'+hex.toUpperCase());
			$this.find('div').css({backgroundColor: $input.val()});
		}
	})
});
})(jQuery);
</script>