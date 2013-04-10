<h2><?php _e('Galleries List', 'lb-gallery')?></h2>
<hr />
<table width="100%">
    <tr>
        <td class="label"><?php _e('Width', 'lb-gallery');?></td>
        <td>
            <input type="text" name="settings[galleries][width]" value="<?php echo $galleries_settings->width;?>" class="textfield" />
        </td>
    </tr>    
    <tr>
        <td class="label"><?php _e('Cols x Rows', 'lb-gallery');?></td>
        <td><input type="text" class="textfield" name="settings[galleries][thumb_cols]" value="<?php echo $galleries_settings->thumb_cols;?>" /> <span>x</span> <input type="text" class="textfield" name="settings[galleries][thumb_rows]" value="<?php echo $galleries_settings->thumb_rows;?>" /><span>(items)</span>
            <p>e.g: 3 x 3</p>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Offset', 'lb-gallery');?></td>
        <td><input type="text" class="textfield" name="settings[galleries][col_offset]" value="<?php echo $galleries_settings->col_offset;?>" /> <span>x</span> <input type="text" class="textfield" name="settings[galleries][row_offset]" value="<?php echo $galleries_settings->row_offset;?>" /> <span>(px)</span>
            <p>e.g: 30 x 30 for column margin and row margin by 30px</p>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Thumbnail Height', 'lb-gallery');?></td>
        <td><input type="text" class="textfield" name="settings[galleries][thumb_height]" value="<?php echo $galleries_settings->thumb_height;?>" /> <span>(px)</span>
            <p>Thumbnail width will be auto calculate by ([Gallery Width] / ([Cols - 1] * [Column Offset])) / [Cols]</p>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Thumbnail Text', 'lb-gallery');?></td>
        <td>
            <table>
            <tr><td valign="top">
                <ul class="lbgal-text-block connectedSortable">
                <?php 
                $usedBlocks = array();
                foreach(array('top', 'thumb', 'bottom') as $block){		
                    $usedBlocks = array_merge($usedBlocks, (array)$galleries_settings->blocks->$block);			
                }
                foreach($galleryBlocks as $k=>$block){
                    if(!in_array($k, $usedBlocks)){
                ?>
                    <li><?php _e($galleryBlocks[$k], 'lb-gallery');?><input type="hidden" name="" value="<?php echo $k;?>" title="" /></li>
                <?php 
                    }
                }					
                ?>                   
                </ul>
            </td>
            <td valign="top">
                <ul class="lbgal-text-block connectedSortable top">
                <?php if($galleries_settings->blocks->top){?>
                <?php foreach($galleries_settings->blocks->top as $k=>$v){?>
                    <li><?php _e($galleryBlocks[$k], 'lb-gallery');?><input type="hidden" name="" value="<?php echo $k;?>" /></li>
                <?php }?>
                <?php }?>
                </ul>
                <ul class="lbgal-text-block connectedSortable thumb">
                <?php if($galleries_settings->blocks->thumb){?>
                <?php foreach($galleries_settings->blocks->thumb as $k=>$v){?>
                    <li><?php _e($galleryBlocks[$k], 'lb-gallery');?><input type="hidden" name="" value="<?php echo $k;?>" /></li>
                <?php }?>
                <?php }?>
                </ul>
                <ul class="lbgal-text-block connectedSortable bottom">
                <?php if($galleries_settings->blocks->bottom){?>
                <?php foreach($galleries_settings->blocks->bottom as $k=>$v){?>
                    <li><?php _e($galleryBlocks[$k], 'lb-gallery');?><input type="hidden" name="" value="<?php echo $k;?>" /></li>
                <?php }?>
                <?php }?>
                </ul>
            </td>
            </tr>
            </table>
            
            <p></p>
        </td>
    </tr>
    <tr>
        <td class="label"><?php _e('Thumbnail Hover Effect', 'lb-gallery');?></td>
        <td>
            <select name="settings[galleries][thumb_text_effect]">  
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
                'fade-out' => 'Fade Out',
                'tooltip' => 'Tooltip'
            );
            foreach($textEffects as $class=>$label){
            ?> 
                <option value="<?php echo $class;?>"<?php echo $galleries_settings->thumb_text_effect == $class ? ' selected="selected"' : ''?>><?php _e($label, 'lb-gallery');?></option>             
            <?php
            }
            ?>                    	            
            </select>
            <p></p>
        </td>
    </tr>
</table>