<style>
.upload-form{
	margin:10px 0;
}
.upload-form .header-tab h3{
	display:inline-block;
	margin: 0px;
	padding: 5px 10px;
	line-height: 20px;
	width: 100px;
	background: #DFDFDF;
	border:1px solid #DFDFDF;
	border-bottom:0px solid;
	color: #212121;
	font-weight: normal;
	-moz-border-radius: 5px5px 0px 0px;
	-webkit-border-radius: 5px 5px 0px 0px;
	border-radius: 5px 5px 0px 0px;
	text-shadow: 1px 1px 0px white;
	cursor:pointer;
}
.upload-form .content-tab{
	border:1px solid #DFDFDF;
	background-color:#EFEFEF;
}
.upload-form .content-tab .content{
	margin:10px;
	display:none;
}
.upload-form .header-tab h3.current,
.upload-form .header-tab h3:hover{
	background-color:#FFFFFF;
}
</style>
<div class="upload-form">
	<!--<div class="header-tab">
    	<h3 class="current"><?php _e('Bulk Upload', 'lb-gallery');?></h3>
        <h3><?php _e('Remote Image', 'lb-gallery');?></h3>
        <h3><?php _e('Remote Video', 'lb-gallery');?></h3>
    </div> -->
    <h2 class="nav-tab-wrapper" style="padding-left:10px;margin-bottom:10px;">
    <?php
	$headerTabs = array(
		'bulk_upload' => array('title' => __('Bulk Upload', 'lb-gallery'), 'state' => $this->tabName == 'global' ? ' nav-tab-active' : ''),
		'remote_image' => array('title' => __('Remote Image', 'lb-gallery'), 'state' => $this->tabName == 'category' ? ' nav-tab-active' : ''),
		'remote_video' => array('title' => __('Remote Video', 'lb-gallery'), 'state' => $this->tabName == 'gallery' ? ' nav-tab-active' : '')
	);
	foreach($headerTabs as $name => $tab){
	?>
    	<a href="admin.php?page=lb-gallery/setting&tabname=<?php echo $name;?>" rel="<?php echo $name;?>" class="nav-tab<?php echo $tab['state']?>"><?php echo $tab['title'];?></a>
	<? }?>        
	</h2>
    <div class="content-tab">
    	<div class="content">
        	<table width="100%">
              <tr>
                <td width="40%" valign="top">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="images" class="image_uploads" id="imageFileUpload" />
                    <div id="lbgalImageQueue"></div>
                    <p>Max Size of File <strong><?php echo ini_get  ( "upload_max_filesize"  ); ?></strong></p>
                    <p>File Type ( *.jpg, *.jpeg, *.gif, *.png, *.bmp )</p>
                    <input type="submit" name="add_album" class="button-primary" value="Upload" id="btnImageUpload" />
                </form>
                </td>
                <td align="center" valign="middle">--Or--</td>
                <td width="40%" valign="top">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="images" class="image_uploads" id="zipFileUpload" />
                    <div id="lbgalZipQueue"></div>
                    <p>Max Size of File <strong><?php echo ini_get  ( "upload_max_filesize"  ); ?></strong></p>
                    <p>File Type ( *.zip )</p>
                    <input type="submit" name="add_album" class="button-primary" value="Upload" id="btnZipUpload" />
                </form>
                </td>
              </tr>
            </table>
        </div>
        <div class="content">
        	<form name="add-image" method="post">
            <ul>
        	<li>
            	<label><?php _e('Image URL', 'lb-gallery');?></label><br />
                <input type="text" name="image_url" size="100" id="image_url">                
            </li>
            <li>
            	<label><?php _e('Title', 'lb-gallery');?></label><br />
                <input type="text" name="image_title" size="100" >
            </li>
            <li>
            	<label><?php _e('Description', 'lb-gallery');?></label><br />
                <textarea rows="10" name="image_description" cols="63"></textarea>
			</li>
            <li>
            	<label><?php _e('Link', 'lb-gallery');?></label><br />
                <input type="text" name="image_linkto" size="100"  />
			</li>
            <li>
                <button type="button" class="button ajaxupload" id="upload_image_button"><?php _e('Add Image', 'lb-gallery');?></button>
			</li>
            </ul>
            <input type="hidden" name="media_type" value="image" />
            </form>
        </div>
        <div class="content"> 
        	<form name="add-video" method="post">
            	<ul>
					<li>
                    	<label><?php _e('Video URL or RSS Feed (<em>youtube, vimeo</em>)', 'lb-gallery');?></label><br />
                    	<input type="text" name="video_url" size="100" >                    
                        <select name="video_url_type" id="video_url_type">
							<option value="video"><?php _e('Video', 'lb-gallery');?></option>
                            <option value="rss"><?php _e('RSS', 'lb-gallery');?></option>
                        </select>
                    </li>
                    <li>
                    	<label><?php _e('Video Thumbnail', 'lb-gallery');?></label><br />
                        <input type="text" name="video_thumb" size="100" >
                        <p class="lbgal-description"><?php _e('Empty to get video thumbnail from source', 'lb-gallery');?></p>
					</li>                    
                    <li>
                    	<label><?php _e('Title', 'lb-gallery');?></label><br />
                    	<input type="text" name="video_title" size="100" >
                        <p class="lbgal-description"><?php _e('Empty to get video title from source', 'lb-gallery');?></p>
					</li>                        
                    <li>
                    	<label><?php _e('Description', 'lb-gallery');?></label><br />
                    	<textarea rows="5" name="video_description" cols="63"></textarea>
                        <p class="lbgal-description"><?php _e('Empty to get video description from source', 'lb-gallery');?></p>
                    </li>
                    <li>
                    	<label><?php _e('Link', 'lb-gallery');?></label><br />
                    	<input type="text" name="video_linkto" size="100"  />
                    </li>
                </ul>  
                <button type="button" class="button ajaxupload" id="upload_video_button"><?php _e('Add Video', 'lb-gallery');?></button>                              
            	<input type="hidden" name="media_type" value="video" />
            </form>                                                 
        </div>
    </div>
</div>   
<?php
$user = wp_get_current_user();
?>
<script type="text/javascript">
(function($){

	$.each($('.upload-form .nav-tab-wrapper a'), function(index){
		$(this).click(function(){		
			$('.upload-form .nav-tab-wrapper a.nav-tab-active').removeClass('nav-tab-active');
			$('.upload-form .content-tab .content').css({
				display: 'none'
			})
			$('.upload-form .content-tab .content:eq('+index+')')
			.stop()
			.css({display: 'block'})
			.animate({
				opacity: 1,
			})
			$(this).addClass('nav-tab-active');
			return false;
		})
	});
	$('.upload-form .nav-tab-wrapper a:first').trigger('click');
	$('#video_url_type').change(function(){
		var $this = $(this);
		$this.parents('ul').find('li:gt(0)').css({display: $this.val() == 'video' ? 'block' : 'none'});
	}).trigger('change');
	
	// ajax upload
	jQuery(document).ready(function ($) {
		$('#lbgalImageQueue').hide();
		
		$("#imageFileUpload").uploadify({
			'uploader': '<?php echo LBGAL_LIBS_URL; ?>/uploadify/uploadify.swf',
			'script': '<?php echo get_bloginfo("siteurl"); ?>/wp-admin/admin.php?page=lb-gallery/image&task=upload',
			//'script': '<?php echo get_bloginfo("siteurl"); ?>/wp-admin/admin.php?',
			'cancelImg': '<?php echo LBGAL_LIBS_URL; ?>/uploadify/images/cancel.png',
			'folder': 'uploads',
			'scriptData': {
				'gid': '<?php echo $gid;?>',
				'media_type': 'imageupload',
				'upload-image-verify': 'yes',
				user_id: '<?php echo $user->ID?>'
			},
			'fileDesc': 'jpg/jpeg',
      		'displayData': 'percentage',      		
			'queueID': 'lbgalImageQueue',
			'auto': false,
			'fileDataName': 'images',
			'wmode':'transparent',
			'method': 'POST',
			'fileExt': '*.jpg;*.jpeg;*.png;*.gif;*.bmp',
			'multi': true,
			'buttonImg':'<?php echo LBGAL_LIBS_URL; ?>/uploadify/images/browse-files.png',
			'width' : 81, 
			'sizeLimit': parseInt(LBGallerySettings.maxUploadSize),
			'onSelect': function () {
				$('#lbgalImageQueue').show();
			},
			'onAllComplete': function () {
				//window.location = window.location;                        
				document.adminForm.submit();
			}
		});
		
		$('#btnImageUpload').live('click', function () {
			$('#imageFileUpload').uploadifyUpload();
			return false;
		});

		$('#lbgalZipQueue').hide();
		$("#zipFileUpload").uploadify({
			'uploader': '<?php echo LBGAL_LIBS_URL; ?>/uploadify/uploadify.swf',
			'script': '<?php echo get_bloginfo("siteurl"); ?>/wp-admin/admin.php?page=lb-gallery/image&task=upload',
			'cancelImg': '<?php echo LBGAL_LIBS_URL; ?>/uploadify/images/cancel.png',
			'folder': 'uploads',
			'scriptData': {
				'gid': '<?php echo $gid;?>',
				'media_type': 'zipupload',
				'upload-image-verify': 'yes',
				user_id: '<?php echo $user->ID?>'
			},
			'queueID': 'lbgalZipQueue',
			'auto': false,
			'fileDataName': 'images',
			'wmode':'transparent',
			'method': 'POST',
			'fileDesc': 'Zip File',
			'fileExt': '*.zip;*.rar',
			'multi': false,
			'buttonImg':'<?php echo LBGAL_LIBS_URL; ?>/uploadify/images/select-zip.png',
			'width' : 84, 
			'sizeLimit': parseInt(LBGallerySettings.maxUploadSize),
			'onSelect': function () {
				$('#lbgalZipQueue').show();
			},
			'onAllComplete': function () {
				//window.location = window.location;                        
				document.adminForm.submit();
			}
		});
		$('#btnZipUpload').live('click', function () {
			$('#zipFileUpload').uploadifyUpload();
			return false;
		});
	});
})(jQuery);
</script>
            