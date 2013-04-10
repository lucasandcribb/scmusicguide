<?php if($total = count($this->galleries)){?>
<div class="lbgal-items-list lbgal-gallery-pagenum-<?php echo $this->cid, '-', $this->currentPage;?>">
<?php 
$i = 0; $j = 0;
$rows = $this->settings->thumb_rows; $cols = $this->settings->thumb_cols;
$border = $this->settings->border_width . 'px ' .$this->settings->border_style . ' ' . $this->settings->border_color;
$html = array();
foreach($this->galleries as $key=>$gallery){
	if($i % $cols == 0 && $i){
		$j++;		
	}
	if($i % $cols == 0) $margin_left = 0;
	else $margin_left = $this->settings->col_offset;
	if(!$html[$j]) $html[$j] = '';
	//$gallery->type = 'gallery';
	$margin_top = $i >= $cols ? $this->settings->row_offset : 0;
	$gallery->rating_type = 'gallery';
	ob_start();
?>	
	<li style="margin-left:<?php echo $margin_left;?>px;margin-top:<?php echo $margin_top;?>px;float:left;width:<?php echo $this->settings->thumb_width+$this->settings->border_spacing_leftright*2;?>px;border:<?php echo $border?>;<?php echo $this->settings->background_image ? 'background-image:url('.$this->settings->background_image.');' : '';?><?php echo $this->settings->background_color ? 'background-color:'.$this->settings->background_color.';' : '';?>">
    <div style="margin:<?php echo $this->settings->border_spacing_topbottom;?>px <?php echo $this->settings->border_spacing_leftright;?>px;overflow:hidden;">
    	<input type="hidden" class="hdn-gallery-id" value="<?php echo $gallery->id;?>" />
    	<?php $this->root->getGalleryBlock($gallery, $this->settings, 'top');	?>
        <div class="lbgal-gallery-thumbnail lbgal-display" style="height:<?php echo $this->settings->thumb_height;?>px;">
        	<img src="<?php echo $gallery->thumbsrc;?>" style="width:<?php echo $this->settings->thumb_width;?>px;height:<?php echo $this->settings->thumb_height;?>px;" />
		<?php $this->root->getGalleryBlock($gallery, $this->settings, 'thumb');	?>
        </div>
        <?php $this->root->getGalleryBlock($gallery, $this->settings, 'bottom');	?>
	</div>        
	</li>
<?php 	
	$html[$j].= ob_get_clean();
	$i++;
}
echo '<ul class="lbgal-items-row">'.implode('<li class="lbgal-clearboth"></li></ul><ul class="lbgal-items-row">', $html).'<li  class="lbgal-clearboth"></li></ul>';
?>
</div>
<?php 
}?>