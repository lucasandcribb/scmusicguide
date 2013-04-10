<div class="wrap">
    <div id="lbgal-header-category" class="icon32"><br>
    </div>
    <h2><?php _e('Category', 'lb-gallery');?></h2>
    <form name="adminForm" method="post" action="" >
    <table width="100%">
    <tr>
    <td width="40%" valign="top">
    	<h3><?php _e('New Category', 'lb-gallery');?></h3>    
        	<div>
            <label><?php _e('Name', 'lb-gallery');?></label><br />
            <input type="text" name="category[name]" id="input-category-name" value="<?php echo $category->name;?>" class="lbgal-input">                
			</div>
            <br />
            <div>
            	<label><?php _e('Description', 'lb-gallery');?></label><br />
                <textarea class="lbgal-textarea" rows="10" name="category[description]"><?php echo $category->description;?></textarea>
            </div>
            <div>
            	<button class="button" type="button" id="button-save"><?php _e('Save Category', 'lb-gallery');?></button>
                <?php if($_REQUEST['cid']){?>
				<button class="button" type="button" id="button-save-new"><?php _e('Save as New', 'lb-gallery');?></button>
                <?php }?>
                <button class="button" type="button" id="button-cancel" onclick="LBGalleryCore.doTask('cancel');"><?php _e('Cancel', 'lb-gallery');?></button>                
            </div>
            <input type="hidden" name="category[id]" value="<?php echo $category->id;?>" />		     
    </td>
    <td width="60%" valign="top">
    <table class="tablenav top" width="100%">
    	<tr>
        	<td>
                <select name="bulk_action">
                    <option value=""><?php _e('Bulk Actions', 'lb-gallery');?></option>
                    <option value="remove"><?php _e('Remove', 'lb-gallery');?></option>
                </select>
                <button type="button" id="button-apply" class="button-primary"><?php _e('Apply', 'lb-gallery');?></button>
			</td>			
		</tr>
	</table>                                    
    </div>
    <table width="100%" class="wp-list-table widefat fixed posts">
    	<thead>
        	<tr>
	        	<th width="50" align="right" style="text-align:right;">#</th>
                <th width="30"><input type="checkbox" class="chk-all"  onclick="LBGalleryCore.checkAll(this.checked);"></th>
    	        <th><?php _e('Name', 'lb-gallery');?></th>
    	        <th width="100"><?php _e('Galleries', 'lb-gallery');?></th>
                <th width="120"><?php _e('Action','lb-gallery');?></th>
			</tr>               
        </thead>
        <tfoot>
        	<tr>
	        	<th align="right" style="text-align:right;">#</th>
                <th><input type="checkbox" class="chk-all"  onclick="LBGalleryCore.checkAll(this.checked);"></th>
    	        <th><?php _e('Name', 'lb-gallery');?></th>
                <th><?php _e('Galleries', 'lb-gallery');?></th>
                <th><?php _e('Action','lb-gallery');?></th>
			</tr>                
        </tfoot>
        <tbody>
        <?php if($total){$i = 0;?>
        <?php foreach($categories as $cat){?>
        	<tr>
            	<td style="text-align:right;"><?php echo ($i+1);?></td>
                <td align=""><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $cat->id;?>" class="chk-row" onclick="LBGalleryCore.isChecked(this.checked);" /></td>
                <td>
                	<a href="admin.php?page=lb-gallery/category&amp;task=edit&amp;cid=<?php echo $cat->id;?>">
					<?php echo $cat->name ? $cat->name : "[No Name]";?>
                    </a>
				</td>
                <td>
                	<?php echo $cat->galleries_count;?>
                </td>
                <td>
                	<a href="admin.php?page=lb-gallery/category&amp;task=edit&amp;cid=<?php echo $cat->id;?>" class="action-button editrow" title="<?php _e('Edit this item', 'lb-gallery');?>">
                    	<img src="<?php echo LBGAL_IMAGES;?>/edit_16x16.png" border="0" />
                    </a>
                    <a class="action-button" href="admin.php?page=lb-gallery/setting&tabname=gallery&cid=<?php echo $cat->id;?>" title="Settings" onclick="javascript:void(0);">
						<img src="<?php echo LBGAL_IMAGES."/settings_16x16.png";?>" border="0" alt="<?php _e('Settings', 'lb-gallery');?>" />
                    </a>
                	<a class="action-button" href="javascript: void(0);" title="<?php _e('Remove this item', 'lb-gallery');?>" onclick="if(confirm('Are you sure you wish to remove this category?')) {LBGalleryCore.listItemTask('cb<?php echo $i;?>', 'remove');}">
						<img src="<?php echo LBGAL_IMAGES."/trash_16x16.gif";?>" border="0" alt="<?php _e('Remove this item', 'lb-gallery');?>" />
                    </a>
                    
                </td>
            </tr>
        <?php 
		$i++;
		}?>
        <?php }else{?>
        	<tr><td colspan="5"><?php _e('No item', 'lb-gallery');?>
            </td>
            </tr>
		<?php }?>            
        </tbody>
    </table>
    </td>
    </tr>
    </table>
    <input type="hidden" name="task" />  
    <input type="hidden" name="noheader" value="true" />  
    <input type="hidden" name="boxchecked" value="0" />
    </form>       
</div>    
<script type="text/javascript">
(function($){
var checkForm = function(){
	var text = $('#input-category-name');
	if(text.val() == null || text.val() == ''){
		alert('Please enter category name');
		text.focus();
		return false;
	}
	return true;
}
$('#button-apply').click(function(){
	var action = this.form.bulk_action.value;
	if(action == null || action == ''){
		alert('Please select an action');
		return false;
	}
	if(!confirm('Are you sure you wish to do this action')){
		return false;
	}
	LBGalleryCore.doTask(action);
});

$('#button-save').click(function(){
	if(checkForm()){
		 LBGalleryCore.doTask('save');
	}
});

$('#button-save-new').click(function(){
	if(checkForm()){
	 	LBGalleryCore.doTask('save_new');
	}
});

})(jQuery);
</script>