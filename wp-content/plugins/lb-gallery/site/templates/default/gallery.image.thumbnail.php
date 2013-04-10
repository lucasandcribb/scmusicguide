<?php if($n = count($this->images)){$i = 0;?>
<div class="lbgal-items-list lbgal-image-pagenum-<?php echo $this->gid, '-', $this->currentPage;?>">
<?php
$_thumbnail = $this->settings->_thumbnail;
$ipp = $_thumbnail->thumb_cols * $_thumbnail->thumb_rows;
?>
<?php foreach($this->images as $image){
if($i >= $ipp) break;

$image->rating_type = 'image';
$new_row = ($i % $_thumbnail->thumb_cols == 0);
$margin_left = ($new_row ? 0 : $_thumbnail->col_offset);
$margin_top = $i >= $_thumbnail->thumb_cols ? $_thumbnail->row_offset : 0;
if($new_row){$j=0;
?><ul class="lbgal-items-row"><?php
}
$j++;

$border = $_thumbnail->border_width . 'px ' .$_thumbnail->border_style . ' ' . $_thumbnail->border_color;
?>
<li style="width:<?php echo $_thumbnail->thumb_width+$_thumbnail->border_spacing_leftright*2;?>px;float:left;margin-left:<?php echo $margin_left;?>px;position:relative;margin-top:<?php echo $margin_top;?>px;overflow:hidden;border:<?php echo $border?>;<?php echo $_thumbnail->background_image ? 'background-image:url('.$_thumbnail->background_image.');' : '';?><?php echo $_thumbnail->background_color ? 'background-color:'.$_thumbnail->background_color.';' : '';?>">
<div style="margin:<?php echo $_thumbnail->border_spacing_topbottom;?>px <?php echo $_thumbnail->border_spacing_leftright;?>px;overflow:hidden;">
	<?php $this->root->getThumbnailBlock($image, $this->settings, 'top');	?>
	<div class="lbgal-gallery-thumbnail lbgal-display" style="height:<?php echo $_thumbnail->thumb_height;?>px;position:relative;">
		<a href="<?php echo $image->fullsrc;?>" style="position:relative;display:block;" rel="lbgallery[thumbnail-<?php echo $image->gid;?>]" class="thumbnail-wrapper" title="<?php echo $image->title;?>"><img class="thumbnail" src="<?php echo $image->thumbsrc;?>" style="width:<?php echo $_thumbnail->thumb_width;?>px;max-width:100%;visibility:hidden;" alt="<?php echo $image->title;?>" />
        </a>
        <?php $this->root->getThumbnailBlock($image, $this->settings, 'thumb');	?>
	</div>    
    <?php $this->root->getThumbnailBlock($image, $this->settings, 'bottom');	?>
</div>    
</li>

<?php if($j == $_thumbnail->thumb_cols || $i == $n-1){?>
<li class="lbgal-clearboth"></li>
</ul><?php }?>
<?php $i++; }?>
<?php }?>
</div>