<div class="lb-gallery" id="<?php echo $this->elemId;?>" style="width:<?php echo $this->shortcode->width;?>">
<?php if($this->shortcode->show_top_bar){?>
	<div class="lbgal-header">
	</div>
<?php }?>    
    <div class="lbgal-body">    
    </div>
<?php if($this->shortcode->show_bottom_bar){?>    
    <div class="lbgal-header bottom">
	</div>
<?php }?>    
    <div class="lbgal-mainoverlay lbgal-bg"></div>
    <div class="lbgal-mainoverlay lbgal-icon"></div>
    <input type="hidden" class="hdn-current-cid" />
    <input type="hidden" class="hdn-current-gid" />    
</div>
