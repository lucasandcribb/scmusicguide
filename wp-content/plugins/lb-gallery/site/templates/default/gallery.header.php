<?php
if($this->shortcode->show_top_bar || $this->shortcode->show_bottom_bar){
if($this->listview == 'gallery'){
echo '<div style="float:left;">';
	if($this->shortcode->show_category_dropdown){
	echo $this->lists['categories'];   
	}
	echo '<span class="lbgal-navigation-wrapper">';
	if($this->totalPages > 1){	
	?>
    
    <span class="lbgal-navigation lbgal-navigation-<?php echo $this->cid, '-', $this->currentPage;?>">
	<a href="" class="lbgal-button lbgal-pagination lb-tooltip prev<?php echo $this->currentPage <= 1 ? ' disabled': '';?>" title="<?php echo _e('Previous', 'lb-gallery');?>"></a>    
	<span class="lbgal-button lb-tooltip"><?php echo $this->currentPage;?></span>
	<a href="" class="lbgal-button lb-tooltip lbgal-pagination next<?php echo $this->currentPage >= $this->totalPages ? ' disabled': '';?>" title="<?php echo _e('Next', 'lb-gallery');?>"></a>
    </span>
	<?php	
	}
	echo '</span>';
echo '</div>';
}else if($this->listview == 'image'){
echo '<div style="float:left;">';
	if($this->shortcode->show_gallery_dropdown){
	echo $this->lists['galleries'];    
	}
echo '</div>';
?>
<div class="lbgal-navigation-wrapper" style="float:right;">
<?php if($this->shortcode->show_back_gallery_button){?>
<a href="" class="lbgal-button lbgal-back-gallery lb-tooltip" title="<?php _e('Back to Gallery', 'lb-gallery');?>"></a>
<?php }
if($this->totalPages > 1 /* && $this->allSettings['global']->default_view == 'thumbnail'*/){
?>
<span class="lbgal-navigation lbgal-navigation-<?php echo $this->gid, '-', $this->currentPage;?>">
<a href="" class="lbgal-button lbgal-pagination lb-tooltip prev<?php echo $this->currentPage <= 1 ? ' disabled': '';?>" title="<?php echo _e('Previous', 'lb-gallery');?>"></a>
<span class="lbgal-button lb-tooltip"><?php echo $this->startItem, '-', $this->endItem;?></span>
<a href="" class="lbgal-button lb-tooltip lbgal-pagination next<?php echo $this->currentPage >= $this->totalPages ? ' disabled': '';?>" title="<?php echo _e('Next', 'lb-gallery');?>"></a>
</span>
<?php	
}
echo '</div>';
}
?>&nbsp;
<div style="clear:both;"></div>
<?php }?>