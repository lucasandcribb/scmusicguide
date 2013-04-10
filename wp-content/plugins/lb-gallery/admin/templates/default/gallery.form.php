<div class="wrap">
    <div id="lbgal-header-gallery" class="icon32"><br>
    </div>
    <h2><?php _e('Galleries', 'lb-gallery');?></h2>
    <table width="100%" class="tablenav top">
    	<tr>
        	<td>
            	<a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=lb-gallery" class="button"><?php _e('Back to Galleries', 'lb-gallery');?></a>
            </td>
        </tr>
    </table>
    <form method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=lb-gallery&noheader=true" enctype="multipart/form-data" name="adminForm">
	<div class="metabox-holder">
		<div class="postbox">
			<h3><?php _e('Gallery', 'lb-gallery');?></h3>			 
            <table cellpadding="10" cellspacing="10" class="form-table">
                <tr>
                    <th width="30%"><?php _e('Title', 'lb-gallery');?></td>
                    <td><input type="text" name="gallery[title]" value="<?php echo $gallery->title;?>" size="100" id="input-gallery-title" /></td>
                </tr>                
                <tr>
                	<td><?php _e('Category', 'lb-gallery');?></td>
                    <td><?php echo $lists['category'];?></td>
                </tr>
                <tr>
                	<td><?php _e('Author', 'lb-gallery');?></td>
                    <td><?php echo $lists['author'];?></td>
                </tr>
                <tr>
                    <td><?php _e('Description', 'lb-gallery');?></td>
                    <td><textarea name="gallery[description]" cols="100" rows="10"><?php echo $gallery->description;?></textarea></td>
                </tr>
                <tr>
                	<td>Link To</td>
                    <td><input type="text" name="gallery[linkto]" value="<?php echo $gallery->linkto;?>" size="100" /></td>
                </tr>
                <tr>
                    <td><?php _e('Active', 'lb-gallery');?></td>
                    <td>
                    	<select name="gallery[published]">
                        	<option value="0"<?php echo $gallery->published ? '' : ' selected="selected"';?>>Deactive</option>
                            <option value="1"<?php echo $gallery->published == 1 ? ' selected="selected"' : '';?>>Active</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php _e('Preview', 'lb-gallery');?></td>
                    <td>
						<?php if($gallery->preview){?>
                        <img src="<?php echo $gallery->preview;?>" style="margin:3px;" /><br />
                        <?php }?>
                        <?php echo $lists['image'];?>						
                    </td>
			    </tr>			                                       
            </table>
            <input type="hidden" name="task" />
            <input type="hidden" name="noheader" value="true" />
            <input type="hidden" name="gallery[id]" value="<?php echo $gallery->id;?>" />
                       
		</div>
	</div>
    <button type="button" class="button" id="button-save"><?php _e('Save', 'lb-gallery');?></button>
    <button type="button" class="button" id="button-apply"><?php _e('Apply', 'lb-gallery');?></button>
    <button type="button" class="button" id="button-save-new"><?php _e('Save & New', 'lb-gallery');?></button>
    <button type="button" class="button" id="button-save-upload"><?php _e('Save & Upload Images', 'lb-gallery');?></button>            
    <button type="button" class="button" id="button-cancel" onclick="LBGalleryCore.doTask('cancel');"><?php _e('Cancel', 'lb-gallery');?></button> 
    </form>
</div>
<script type="text/javascript">
(function($){
var checkForm = function(){
	var title = $('#input-gallery-title'),
		category = $('#select-gallery-cid'),
		author = $('#select-gallery-author');
	if(title.val() == null || title.val() == ''){
		alert('Please enter gallery title');
		title.focus();
		return false;
	}
	if(category.val() == null || category.val() == ''){
		alert('Please select a category');
		category.focus();
		return false;
	}
	if(author.val() == null || author.val() == ''){
		alert('Please select an author');
		author.focus();
		return false;
	}
	return true;
}
$('#button-save').click(function(){
	if(!checkForm()) return false;
	LBGalleryCore.doTask('save');
})
$('#button-apply').click(function(){
	if(!checkForm()) return false;
	LBGalleryCore.doTask('apply');
})
$('#button-save-new').click(function(){
	if(!checkForm()) return false;
	LBGalleryCore.doTask('save_new');
})
$('#button-save-upload').click(function(){
	if(!checkForm()) return false;
	LBGalleryCore.doTask('save_upload');
})
})(jQuery);
</script>