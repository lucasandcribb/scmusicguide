<div class="lbgal-filmstrip-viewer-inside" style="position:relative;">
<?php $this->view->getThumbnailBlock($this->image, $this->settings, 'top');	?>
<div class="lbgal-gallery-thumbnail">
	<div class="lbgal-viewer-image"></div>
    <?php $this->view->getThumbnailBlock($this->image, $this->settings, 'thumb');	?>
</div>
<?php $this->view->getThumbnailBlock($this->image, $this->settings, 'bottom');	?>
</div>