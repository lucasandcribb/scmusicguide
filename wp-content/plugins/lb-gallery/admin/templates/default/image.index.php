<div class="wrap">
    <div id="lbgal-header-image" class="icon32"><br>
    </div>
    <h2><?php _e('Images', 'lb-gallery');?></h2>
    <?php echo $this->fetch('image.list');?>
	<?php echo $this->fetch('image.upload');?>
	<?php //echo $this->fetch('image.remote');?>    
</div>    
<script type="text/javascript">
(function($){

$('#button-apply').click(function(){
	var action = $(this.form.bulk_action);
	if(action.val() == '' || action.val() == null){
		alert('Please select an action');
		action.focus();
		return false;
	}
	if(!confirm('Are you sure you wish to do this action?')) return false;
	LBGalleryCore.doTask(action.val());
});

})(jQuery);
</script>