<div class="wrap">
    <div id="lbgal-header-gallery" class="icon32"><br>
    </div>
    <h2><?php _e('Galleries', 'lb-gallery');?></h2>
    <form name="adminForm" method="post" action="<?php echo get_bloginfo('siteurl');?>/wp-admin/admin.php?page=lb-gallery">
    <table width="100%" class="tablenav top">
    	<tr>
        	<td>            	
                <select name="bulk_action">
                    <option value=""><?php _e('Bulk Actions', 'lb-gallery');?></option>
                    <option value="active"><?php _e('Active', 'lb-gallery');?></option>
                    <option value="deactive"><?php _e('Deactive', 'lb-gallery');?></option>
                    <option value="remove"><?php _e('Remove', 'lb-gallery');?></option>                    
                </select>
                <button type="button" class="button" id="button-apply" ><?php _e('Apply', 'lb-gallery');?></button>
                
                <a href="<?php echo get_bloginfo('siteurl');?>/wp-admin/admin.php?page=lb-gallery&amp;task=edit" class="button-primary"><?php _e('Add Gallery', 'lb-gallery');?></a>
            </td>
        </tr>
    </table>
    <table class="wp-list-table widefat fixed posts" id="galleries-list">
        <thead>
            <tr>
            	<th style="width:60px;text-align:right;" >#</th>
                <th class="check-column" scope="col" width="30" align="center" >
                <input type="checkbox" class="chk-all"  onclick="LBGalleryCore.checkAll(this.checked);"></th>                
                <th scope="col" ><?php _e('Title', 'lb-gallery');?></th>
                <th scope="col" ><?php _e('Category', 'lb-gallery');?></th>
                <th scope="col" style="width:80px;"><?php _e('Author', 'lb-gallery');?></th>
                <th  style="width:120px;"><?php _e('Featured Image', 'lb-gallery');?></th>
                <th width="130" ><?php _e('Photos', 'lb-gallery');?></th>
                <th width="130"><?php _e('Action', 'lb-gallery');?></th>
                <th width="40"><?php _e('Sort', 'lb-gallery');?></th>
            </tr>
        </thead>
        <tfoot>
        	<tr>
	            <th style="width:60px;text-align:right;">#</th>            
            	<th class="check-column" scope="col"><input type="checkbox" class="chk-all"  onclick="LBGalleryCore.checkAll(this.checked);"></th>
                <th scope="col"><?php _e('Title', 'lb-gallery');?></th>
                <th scope="col" ><?php _e('Category', 'lb-gallery');?></th>
                <th scope="col"><?php _e('Author', 'lb-gallery');?></th>
                <th><?php _e('Featured Image', 'lb-gallery');?></th>
                <th><?php _e('Photos', 'lb-gallery');?></th>
                <th><?php _e('Action', 'lb-gallery');?></th>
                <th width=""><?php _e('Sort', 'lb-gallery');?></th>
            </tr>
        </tfoot>
	    <tbody>
       	<?php if($total){$i=0;?>
        <?php foreach($galleries as $row){?>
        <?php	
			
			$remove_link = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];				
			$remove_link = remove_query_arg( array( 'task', 'id' ), $active_link );
			$remove_link .= '&noheader=true&task=remove&id='.$row->id;
			$remove_link = "if(confirm('Are you sure?')) location.href='".$remove_link."'";
			$remove_title = "Remove this gallery";			
			$remove_icon = LBGAL_IMAGES."/trash_16x16.gif";
			
			$active_icon = LBGAL_IMAGES.'/'.($row->published ? "tick_16x16.png" : "untick_16x16.png");
			$active_title = ($row->published==1 ? "Deactive" : "Active")." this item";
			
			$edit_link = get_option('siteurl')."/wp-admin/admin.php?page=lb-gallery&task=edit&gid=".$row->id;				
			$edit_title = "Click to edit this gallery";
			$edit_icon = LBGAL_IMAGES."/edit_16x16.png";

			$class = ($i % 2 == 0) ? 'row0' : 'row1';
		?>
        	<tr class="<?php echo $class;?>">
            	<td align="right"><?php echo $i+1;?></td>            
            	<td align="center">
                    <input type="checkbox" id="cb<?php echo $i;?>" name="gid[]" value="<?php echo $row->id;?>" class="chk-row" onclick="LBGalleryCore.isChecked(this.checked);" />
				</td>
                <td align="left">
					<a title="<?php _e('Click to edit', 'lb-gallery');?>" href="<?php echo $edit_link?>"><?php echo $row->title ? $row->title : '[No Title]';?></a>
				</td>
                <td scope="col" ><a href="admin.php?page=lb-gallery/category&task=edit&cid=<?php echo $row->id;?>"><?php echo $row->catname;?></a></td>
                <td align="left"><?php echo $row->user_nicename;?>
                </td>
                <td align="left">
                <?php if($row->featured_image){?>
					<img src="<?php echo $row->featured_image;?>" />
				<?php }else{?>                	
                <strong>[No Preview]</strong>
                <?php }?>
                </td>
                <td align="left">
                	(<?php echo $row->image_count;?>&nbsp;<?php _e('photos', 'lb-gallery');?>)
                	<a href="<?php echo get_option('siteurl')."/wp-admin/admin.php?page=lb-gallery/image&gid=".$row->id;?>">
                    <?php _e('Upload', 'lb-gallery');?>
                    </a>
                </td>
                <td align="left" width="" valign="middle" style="vertical-align:middle;">
                	<a class="action-button" href="<?php echo $edit_link;?>" title="<?php echo $edit_title;?>">
                		<img src="<?php echo $edit_icon;?>" border="0" align="<?php echo $edit_title;?>" />
                    </a>
                    <a class="action-button" href="javascript:void(0);" title="Active/Deactive this item" onclick="LBGalleryCore.listItemTask('cb<?php echo $i;?>', '<?php echo $row->published ? 'deactive' : 'active';?>');" >
                    	<img src="<?php echo $active_icon;?>" border="0" />
                    </a>				
                	<a class="action-button"  href="javascript: void(0);" onclick="if(confirm('Are you you wish to remove this gallery?')){LBGalleryCore.listItemTask('cb<?php echo $i;?>', 'remove');}" title="<?php echo $remove_title;?>">
                		<img src="<?php echo $remove_icon;?>" border="0" align="<?php echo $remove_title;?>" />
                    </a>
				</td>
                <td class="lbgal-move-handle"><span title="Drag to sort item"></span></td>
            </tr>
		<?php 
			$i++;
			}?>            
		<?php }else{?>            
        	<tr>
            	<td colspan="9"><?php _e('No item', 'lb-gallery');?></td>
            </tr>
        <?php }?>
        </tbody>
        
    </table>
   	<input type="hidden" name="task" value="" />
    <input type="hidden" name="noheader" value="true" />  
    <input type="hidden" name="boxchecked" value="0" />
	</form>
</div>
<script>
(function($){
$('#button-apply').click(function(){
	var action = this.form.bulk_action.value;
	if(action == null || action == ''){
		alert('Please select an action');
		return false;
	}
	if(!confirm('Are you sure you wish to do this action?')){
		return false;
	}
	LBGalleryCore.doTask(this.form.bulk_action.value);
})
$('#galleries-list tbody').sortable({
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
		
		$.each($('#galleries-list tbody tr'), function(i){
			$(this).find('td:eq(0)').html(i+1);
			ids.push($(this).find('td:eq(1) .chk-row').val());
			orderings.push(i); 
		})
		$.ajax({
			url: '<?php echo get_bloginfo('siteurl');?>/wp-admin/admin-ajax.php',
			data: {
				action: 'update_order',
				ids: ids.join(','),
				orderings: orderings.join(','),
				list: 'gallery'
			},
			success: function(response){
				//alert(response);
			}
		});
	}
});
})(jQuery);
</script>