<form name="adminForm" method="post" action="<?php echo get_bloginfo('siteurl');?>/wp-admin/admin.php?page=lb-gallery/image" >
<div class="tablenav top">	
    <table width="100%">
        <tr>
            <td>
	        <?php _e('Select Gallery', 'lb-gallery');?>            
            <?php echo $lists['filter_gallery'];?>           
            <select name="bulk_action">
                <option value=""><?php _e('Bulk Actions', 'lb-gallery');?></option>
                <option value="active"><?php _e('Active', 'lb-gallery');?></option>
                <option value="deactive"><?php _e('Deactive', 'lb-gallery');?></option>
                <option value="remove"><?php _e('Remove', 'lb-gallery');?></option>                    
            </select>
            <button class="button" id="button-apply" type="button" ><?php _e('Apply', 'lb-gallery');?></button>
            <a class="button-primary" href="<?php echo get_bloginfo('siteurl');?>/wp-admin/admin.php?page=lb-gallery"><?php _e('Back to Gallery', 'lb-gallery');?></a>
            
            </td>                   
        </tr>
    </table>                            
</div>
    
    <table class="wp-list-table widefat fixed posts">
        <thead>
            <tr>
            	<th scope="col" width="50" style="text-align:right;width:50px;">#</th>
                <th class="check-column" scope="col" width="30" ><input type="checkbox" class="chk-all" onclick="LBGalleryCore.checkAll(this.checked);"></th>
                <th scope="col" width="100" align=""><?php _e('Preview', 'lb-gallery');?></th>
                <th scope="col"><?php _e('Title', 'lb-gallery');?></th>                           
                <th width="130"><?php _e('Action', 'lb-gallery');?></th>
                <th width="40"><?php _e('Sort', 'lb-gallery');?></th>
            </tr>
        </thead>
        <tfoot>
        	<tr>
                <th scope="col" width="50" style="text-align:right;">#</th>
            	<th class="check-column" width="30" scope="col"><input type="checkbox" class="chk-all"  onclick="LBGalleryCore.checkAll(this.checked);"></th>
                <th scope="col" ><?php _e('Preview', 'lb-gallery');?></th>
                <th scope="col"><?php _e('Title', 'lb-gallery');?></th>       
                <th><?php _e('Action', 'lb-gallery');?></th>
                <th><?php _e('Sort', 'lb-gallery');?></th>
            </tr>
        </tfoot>
	    <tbody id="images-list">
       	<?php if($total){ $i = 0; ?>
        <?php foreach($images as $row){?>
        <?php	
			$paged = $_REQUEST['paged'];
			$active_link = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			
			$active_link = remove_query_arg( array( 'act', 'id' ), $active_link );
			
			$active_link .= '&act='.($row->status==1 ? 'deactive' : 'active').'&noheader=true&id='.$row->id . ($paged ? '&paged='.$paged : '');
			$active_text = ($row->status==1 ? 'Active' : 'Deactive');
			
			///$class = ($row->default==0 ? 'default' : '');
			
			$active_icon = LBGAL_IMAGES.'/'.($row->status ? "tick_16x16.png" : "untick_16x16.png");
			$active_title = ($row->status==1 ? "Deactive" : "Active")." this transition";

			$remove_link = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];				
			$remove_link = remove_query_arg( array( 'act', 'id' ), $remove_link );
			$remove_link .= '&act=remove&noheader=true&id='.$row->id . ($paged ? '&paged='.$paged : '');
			$remove_link = "if(confirm('Are you sure')) location.href='".$remove_link."'";
			$remove_title = "Remove this image";
			
			$remove_icon = LBGAL_IMAGES."/trash_16x16.gif";
			///////////////
			$class = ($i % 2 == 0) ? 'row0' : 'row1';
			$index = ($page-1)*$limit+$i+1;
		?>
        	<tr class="<?php echo $class;?>" id="image-<?php echo $row->id;?>">
                <td align="right">
					<?php echo ($lists['paged'] - 1) * $lists['limit'] + ($i+1);?>
                    <input type="hidden" class="lbgal-editinline-title" value="<?php echo $row->title;?>" />
                    <input type="hidden" class="lbgal-editinline-source" value="<?php echo $row->filename;?>" />
                    <input type="hidden" class="lbgal-editinline-thumbname" value="<?php echo $row->thumbname;?>" />
                    <input type="hidden" class="lbgal-editinline-linkto" value="<?php echo $row->linkto;?>" />
                    <textarea style="display:none;" class="lbgal-editinline-description"><?php echo $row->description;?></textarea>
				</td>
            	<td align=""><input type="checkbox" id="cb<?php echo $i;?>" name="iid[]" value="<?php echo $row->id;?>" class="chk-row" onclick="LBGalleryCore.isChecked(this.checked);" /></td>
                <td align="left">              		
                <img src="<?php echo $row->thumbsrc;?>" />
                <?php if(!$row->featured_image){?>
					<a href="javascript: void(0);" onclick="LBGalleryCore.listItemTask('cb<?php echo $i;?>', 'featured');" title="<?php echo $remove_title;?>"><?php _e('Set Featured', 'lb-gallery');?>
	                </a>
				<?php }else{?>
                <font color="#FF0000"><?php _e('Featured Image', 'lb-gallery');?></font>
                <?php }?>
                </td>
                <td class="" align="left">
                    <strong><?php echo $row->title ? $row->title : '[No Title]';?></strong>                   
				</td>                             
                <td align="left" valign="middle" style="vertical-align:middle;">
                	<a href="" rel="<?php echo $row->id;?>" class="action-button editrow" title="Edit this item">
                    	<img src="<?php echo LBGAL_IMAGES;?>/edit_16x16.png" border="0" />
                    </a>
                    <a href="" class="action-button saverow" title="Save this item">
                    	<img src="<?php echo LBGAL_IMAGES;?>/save_16x16.png" border="0" />
                    </a>
                    <a class="action-button" href="javascript:void(0);" title="Active/Deactive this item" onclick="LBGalleryCore.listItemTask('cb<?php echo $i;?>', '<?php echo $row->status ? 'deactive' : 'active';?>');" >
                    	<img src="<?php echo $active_icon;?>" border="0" />
                    </a>
                    <a class="action-button" href="javascript: void(0);" title="Remove this item" onclick="if(confirm('Are you sure you wish to remove this image?')){ LBGalleryCore.listItemTask('cb<?php echo $i;?>', 'remove');}">
						<img src="<?php echo $remove_icon;?>" border="0" align="<?php echo $remove_title;?>" />
                    </a>
                   
				</td>
                <td class="lbgal-move-handle"><span title="Drag to sort item"></span></td>
            </tr>            
		<?php 
			$i++;
			}
		?>            
		<?php }else{?>            
        	<tr>
            	<td colspan="6"><?php _e('No items', 'lb-gallery');?></td>
            </tr>
        <?php }?>
        </tbody>        
    </table>
    <input type="hidden" name="task" />  
    <input type="hidden" name="noheader" value="true" />  
    <input type="hidden" name="boxchecked" value="0" />
</form>
<div style="display:none;">
<table id="inlineedit">
    <tr id="inline-edit">
        <td>
        <fieldset>
        	<legend><h3>Quick Edit</h3></legend>
            <table width="100%">
                <tr><td><?php _e('Title', 'lb-gallery');?></td></tr>
                <tr><td><input type="text" class="lbgal-editinline-title" value="" /></td></tr>
                <tr><td><?php _e('Description', 'lb-gallery');?></td></tr>
                <tr><td><textarea class="lbgal-editinline-description"></textarea></td></tr>
                <tr><td><?php _e('Source', 'lb-gallery');?></td></tr>
                <tr><td><input type="text" class="lbgal-editinline-source" value="" /></td></tr>
                <tr><td><?php _e('Thumbnail', 'lb-gallery');?></td></tr>
                <tr><td><input type="text" class="lbgal-editinline-thumbname" value="" /></td></tr>
                <tr><td><?php _e('Link', 'lb-gallery');?></td></tr>
                <tr><td><input type="text" class="lbgal-editinline-linkto" value="" /></td></tr>
                <tr>
                    <td>
                    	<button type="button" class="button lbgal-cancel"><?php _e('Cancel', 'lb-gallery');?></button>
                        <button type="button" class="button-primary lbgal-save"><?php _e('Save', 'lb-gallery');?></button>
                        <img class="ajax-loading" src="<?php echo get_bloginfo('siteurl');?>/wp-admin/images/wpspin_light.gif" />
                    </td>
                </tr>
            </table>
		</fieldset>            
        </td>
    </tr>    
</table> 
</div>
<script>
(function($){
var buttonSave = $('.inline-edit .lbgal-save'),
	buttonCancel = $('.inline-edit .lbgal-cancel');
buttonSave.live('click', function(){
	var t = $(this),
		parent = t.parents('.inline-edit'),
		filename = $('.lbgal-editinline-source', parent);
	if(filename.val() == '' || filename.val() == null || filename.val().indexOf('http') == -1){
		alert('Please enter image or video url');
		filename.focus();
		return false;
	}
	parent.find('.ajax-loading').css({visibility: 'visible'});
	$.ajax({
		url: LBGallerySettings.ajax,
		data: {
			id: getId(parent.attr('id')),
			action: 'lbgal_save_inline',
			title: $('.lbgal-editinline-title', parent).val(),
			description: $('.lbgal-editinline-description', parent).val(),
			filename: $('.lbgal-editinline-source', parent).val(),
			thumbname: $('.lbgal-editinline-thumbname', parent).val(),
			linkto: $('.lbgal-editinline-linkto', parent).val()
		},
		dataType: 'json',
		type: 'POST',
		success: function(response){
			var tq = parent.prev();
			$('.lbgal-editinline-title', tq).val(response.title);
            $('.lbgal-editinline-source', tq).val(response.filename);
            $('.lbgal-editinline-thumbname', tq).val(response.thumbname);
            $('.lbgal-editinline-description', tq).val(response.description);
			$('.lbgal-editinline-linkto', tq).val(response.linkto);
			
			tq.find('td:eq(2) img').attr('src', LBGallerySettings.pluginbase+'/timthumb.php?src='+Base64.encode(response.thumbname ? response.thumbname : response.filename)+'&w=80&h=60');
			tq.find('td:eq(3) strong').html(response.title.length ? response.title : '[No Title]');
			tq.css({display: 'table-row'}).next().remove();			
		}
	});
});
buttonCancel.live('click',function(){
	$(this)
	.parents('.inline-edit')
	.prev()
	.css({display: 'table-row'})
	.next().remove();
});
var getId = function(o) {
	var id = typeof o == 'object' ? $(o).closest('tr').attr('id') : o,
		parts = id.split('-');
	return parts[parts.length - 1];
}
var revert = function(){
	$('.inline-edit')
	.prev()
	.css({display: 'table-row'})
	.next().remove();
}
$('#images-list').find('.action-button.editrow').each(function(){
	var button = $(this),
		parent = button.parents('tr');
	button.click(function(){		
		var editRow,
			tds = parent.find('td'),
			id = getId(parent.attr('id'));
		revert();
		parent.css({display: 'none'});
		editRow = $('#inline-edit').clone(true).attr('id', 'edit-'+id).addClass('inline-edit');//parent.next().css({display: 'table-row'});
		$('td', editRow).attr('colspan', tds.length);
		$('.lbgal-editinline-title', editRow).val($('.lbgal-editinline-title', parent).val());
		$('.lbgal-editinline-description', editRow).val($('.lbgal-editinline-description', parent).val());
		$('.lbgal-editinline-thumbname', editRow).val($('.lbgal-editinline-thumbname', parent).val());
		$('.lbgal-editinline-source', editRow).val($('.lbgal-editinline-source', parent).val());
		$('.lbgal-editinline-linkto', editRow).val($('.lbgal-editinline-linkto', parent).val());
		parent.after(editRow);
		return false;
		parent.find('.editable').each(function(){
			var text = $(this),
				textParent = text.parent();
			text.css({
				display: 'block', 
				width: textParent.width(), 
				//height: textParent.height()
			}).attr('disabled', false).siblings('div').css({display: 'none'});
		});
		button.css({display: 'none'}).siblings('.action-button.saverow').css({display: 'inline-block'});
		parent.find('td:eq(1) input').attr('checked', true);
		return false;
	})
});
$('#images-list').find('.action-button.saverow').each(function(){
	var button = $(this).css({display: 'none'}),
		parent = button.parents('tr');
	button.click(function(){
		button.css({display: 'none'}).siblings('.action-button.editrow').css({display: 'inline-block'});
		LBGalleryCore.doTask('saveall');
		return false;
	})
});
$('.chk-row').change(function(){
	//alert($(this).attr('checked'))
	if($(this).attr('checked') == undefined)
		$(this).parents('tr')
		.find('textarea.editable')
		.attr('disabled', true)
		.css({display: 'none'})
		.siblings('div').css({display: 'block'});
})
$('#images-list').sortable({
	handle: 'td:last',
	axis: 'y',
	helper: function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index){
			$(this).width($originals.eq(index).width())
		});
		return $helper;
	},
	start: function(){	
	},
	stop: function(){
		var ids = [],
			orderings = [];
		
		$.each($('#images-list tr'), function(i){
			$(this).find('td:eq(0)').html(i+1);
			ids.push($(this).find('td:eq(1) .chk-row').val());
			orderings.push(i); 
		})
		$.ajax({
			url: LBGallerySettings.ajax,
			data: {
				action: 'update_order',
				ids: ids.join(','),
				orderings: orderings.join(','),
				list: 'image'
			},
			success: function(response){
				//alert(response);
			}
		});
	}
});
})(jQuery);
</script>