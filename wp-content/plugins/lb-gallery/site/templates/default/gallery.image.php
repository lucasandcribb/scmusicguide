<?php $id = uniqid('lbgallery');
print_r($gallery);
echo floor('10000%');
?>
<div id="lb-gallery-testwidth"></div>
<div class="lb-gallery" id="<?php echo $id;?>" style="width:<?php echo $settings->gallery_width;?>;">
	<div class="lbgal-header">
		<?php echo $lists['galleries'];?>
        <span class="lbgal-nav-wrapper">
            <a href="" class="lbgal-nav prev"><<</a>
            <span class="lbgal-paged-wrapper"><?php echo $lists['pagination'];?></span>
            <a href="" class="lbgal-nav next">>></a>
        </span>
        <span class="image-view-mode">
            <a href="thumbnail">Thumbnail</a>
            <a href="filmstrip">Filmstrip</a>
            <a href="single">Single</a>
        </span>
        <?php if($settings->enable_rating == 'gallery'){?>
        <ul class="rating-form gallery" style="margin:5px 0;width:100%;;height:16px;">
            <li class="background-rating"></li>        
            <li class="xxx" style="width:80px;position:relative;">
                <span class="current-rating" style="width:<?php echo ($gallery->rating/5)*80?>px;display:block;height:16px;background-image:url(http://localhost/wordpress/3.3.1/wp-content/plugins/lb-advance-comment/templates/default/images/star_2_on.png);"></span>
                <input type="hidden" class="hdn-current-rating-value" value="<?php echo ($gallery->rating/5)*80;?>" />
                <input type="hidden" class="hdn-gallery-id" value="<?php echo $gallery->id;?>" />
            </li>
            <li class="xxx-text" style="position:absolute;top:0;left:90px;height:16px;font-size:12px;line-height:18px;">(<span class="votes_count"><?php echo $gallery->votes;?></span> / <span class="rating_value"><?php echo $gallery->rating;?></span> ratings)</li>
        </ul>
        <?php }?>
        <div style="clear:both;"></div>
	</div>
    <div class="lbgal-gallery-wrapper">
	<?php //echo $this->fetch('gallery.image.'.$image_view, 'lb-gallery');?>    	
	</div>
    <div style="position:absolute;top:0;left:0;right:0;bottom:0;visibility:visible;background-color:#fff;opacity:0.5;display:none;" class="lbgal-overlay-loading"></div>
    <div style="position:absolute;top:0;left:0;right:0;bottom:0;visibility:visible;display:none;background-image:url(http://ajaxload.info/cache/FF/FF/FF/00/00/00/9-0.gif);background-repeat:no-repeat;background-position:center;" class="lbgal-overlay-loading"></div>
    <input type="text" class="hdn-imageview" value="<?php echo $image_view;?>" />
</div>
<script>

var loadImage = null;
/*var <?php echo $id;?> = {
	thumbnail: 
	rows: <?php echo $rows;?>,
	cols: <?php echo $cols;?>,
	row_offset: <?php echo $row_offset;?>,
	col_offset: <?php echo $col_offset;?>,
	col_width: <?php echo $col_width;?>,
	col_height: <?php echo $col_height;?>,
	border_width: <?php echo $border_width;?>,
	width:<?php echo  $settings->gallery_width;?>
};*/
var <?php echo $id;?>_string = '<?php echo base64_encode(json_encode($settings));?>';
var <?php echo $id;?> = {
	gallery_width: '<?php echo $settings->gallery_width;?>',
	enable_rating: '<?php echo $settings->enable_rating;?>',
	view_mode: {
		thumbnail: {
			thumbnail_cols: '<?php echo $settings->view_mode->thumbnail->thumbnail_cols;?>',
			thumbnail_rows: '<?php echo $settings->view_mode->thumbnail->thumbnail_rows;?>',
			col_offset: '<?php echo $settings->view_mode->thumbnail->col_offset;?>',
			row_offset: '<?php echo $settings->view_mode->thumbnail->row_offset;?>',
			thumbnail_height: '<?php echo $settings->view_mode->thumbnail->thumbnail_height;?>',
			thumb_text: '<?php echo $settings->view_mode->thumbnail->thumb_text;?>',
			thumb_text_effect: '<?php echo $settings->view_mode->thumbnail->thumb_text_effect;?>'
		},
		filmstrip: {
			viewer_height: '<?php echo $settings->view_mode->filmstrip->viewer_height;?>',
			thumbnail_width: '<?php echo $settings->view_mode->filmstrip->thumbnail_width;?>',
			thumbnail_height: '<?php echo $settings->view_mode->filmstrip->thumbnail_height;?>',
			thumb_text: '<?php echo $settings->view_mode->filmstrip->thumb_text;?>',
			thumb_text_effect: '<?php echo $settings->view_mode->filmstrip->thumb_text_effect;?>',
			viewer_text: '<?php echo $settings->view_mode->filmstrip->viewer_text;?>',
			viewer_text_effect: '<?php echo $settings->view_mode->filmstrip->viewer_text_effect;?>'
		}
	}
};
jQuery('#<?php echo $id;?>').lbGallery(<?php echo $id;?>, <?php echo $id;?>_string);
(function($){
return;
var root = jQuery('#<?php echo $id;?>')
$('a.imageview').click(function(){
	jQuery('#<?php echo $id;?>').find('.hdn-imageview').val($(this).attr('href'));
	if($(this).attr('href') == 'thumbnail'){
		root.find('.lbgal-nav-wrapper').css({display: ''})
	}else{
		root.find('.lbgal-nav-wrapper').css({display: 'none'})
	}
	loadImage();
	return false;
});

$('.lbgal-nav').click(function(){
	var current = root.find('.lbgal-paged').val();
	var max = root.find('.lbgal-paged').get(0).options.length;
	
	if($(this).hasClass('prev')){
		
		if(current>1) current--		
		else return false;
	}
	if($(this).hasClass('next')){
		if(current < max) current++
		else return false;
	}
	try{
	root.find('.lbgal-paged').val(current).trigger('change');
	}catch(e){alert(e)}
	return false;
})

loadImage = function(){
	
	if($(this).hasClass('lbgal-gallery-select')) root.find('.lbgal-paged').val(1)
	//alert($(this).hasClass('lbgal-gallery-select'))
	//alert(this+','+this.value);
	var $this = $(this);
	root.find('.lbgal-overlay-loading').css({display: 'block'});
	jQuery.ajax({
		url: LBGallerySettings.ajax, 
		data: jQuery.extend({
			action: 'load_image',
			image_view: root.find('.hdn-imageview').val(),
			gallery_id: root.find('.lbgal-gallery-select').val(),
			paged: root.find('.lbgal-paged').val()
		}, <?php echo $id;?>),
		dataType: 'json',
		success: function(r){
			//alert(r);
			root.find('.lbgal-<?php echo $image_view;?>-wrapper').html(r.html);
			if($this.hasClass('lbgal-gallery-select')) root.find('.lbgal-paged-wrapper').html(r.pagination);
			root.find('.lbgal-overlay-loading').css({display: 'none'});
		}
	});
}
})(jQuery)
</script>