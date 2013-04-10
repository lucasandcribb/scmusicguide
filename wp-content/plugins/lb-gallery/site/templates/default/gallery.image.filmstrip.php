<div class="">
<?php 
if($total = count($this->images)){
	$viewerHeight = (int)$this->settings->_filmstrip->viewer_height;	
	foreach($this->images as $img){
	?>
    <div class="lbgal-filmstrip-viewer" style=" <?php echo $viewerHeight ? 'height:'.$viewerHeight.'px;' : '';?>">
    <!--<img class="viewer" src="<?php echo $img->fullsrc;?>" style="max-width:100%;<?php echo $viewerHeight ? 'max-height:'.$viewerHeight.'px;' : '';?>" />-->
    </div>
    <?php
		break;
	}
	$totalWidth = $total * $this->settings->_filmstrip->thumb_width + ($total-1) * $this->settings->_filmstrip->thumb_offset;	
?>
	<div style="overflow:hidden;overflow:auto;">
        <ul style="width:<?php echo $totalWidth;?>px;list-style:none;margin:0;padding:0;" class="lbgal-filmstrip-thumb-wrapper">
        <?php 
		$i = 0;
		foreach($this->images as $image){			
			$margin = $i < $total - 1 ? $this->settings->_filmstrip->thumb_offset : 0;
			$title = array();
			switch($this->settings->_filmstrip->thumb_tooltip){
				case 1:
					$title[] = $image->title;
					break;
				case 2: 
					$title[] = $image->description;
					break;
				case 3: 
					$title[] = $image->title;
					$title[] = $image->description;
					break;
			}
		?>     
            <li style="float:left;margin-right:<?php echo $margin;?>px;position:relative;width:<?php echo $this->settings->_filmstrip->thumb_width?>px;overflow:hidden;" class="lbgal-gallery-thumbnail filmstrip">
                <a href="" rel="<?php echo $image->id?>"<?php echo count($title) ? ' title="'.implode('::', $title).'"' : '';?>><img class="image-list" style="max-width:100%;" src="<?php echo $image->thumbsrc;?>" /></a>
                <?php //$this->root->getThumbnailBlock($image, $this->settings, 'bottom');	?>
                <span class="focus lt"></span>
                <span class="focus rt"></span>
                <span class="focus lb"></span>
                <span class="focus rb"></span>
            </li>
        <?php 
			$i++;
		}
		?>
        	<li style="clear:both;"></li>
        </ul>
    </div>
<?php
}
?>    
</div>