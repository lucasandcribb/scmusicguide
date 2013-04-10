<style>
table td{
	vertical-align:top;
}
table td.label{
	width:150px;	
	padding-top:5px;
}
table td input.textfield{
	width:100px;
}
table td p{
	font-style:italic;
	font-size:10px;
	color:#666666;
}
table td span{
	padding-top:5px;
}
#gallery_top_block,
#gallery_thumb_block,
#gallery_bottom_block{
	min-height:38px;
	border:1px dotted #DDD;
	background-color:#FFF;
	margin:0 0 10px 0;
	width:208px;
}
.gallery_thumb_block{
	list-style:none;
	margin:0;
	padding:0;
	width:208px;
	min-height:38px;
	border:1px dotted #DDD;
}
.gallery_thumb_block li,
#gallery_top_block li,
#gallery_thumb_block li,
#gallery_bottom_block li{
	background-color:#F5F5F5;
	border:1px solid #DDD;
	width:200px;
	margin:3px;
	text-align:right;
	height:30px;
	line-height:30px;
}
.lbgal-text-block{
	margin:0 0 30px 0;
	padding:0;
	border:1px dashed #DDD;
	min-height:36px;
	width:200px;
	position:relative;
}
.lbgal-text-block li.lb-block-description{
	position:absolute;
	padding:5px;
	left:0;
	top:  -25px;
	white-space:nowrap;
	z-index:10;
}
.lbgal-text-block li.dragable{
	margin:3px;
	border:1px solid #DDD;
	background-color:#f5f5f5;
	padding:0 5px;
	line-height:28px;
	height:28px;
	cursor:move;
	position:relative;
	z-index:100;
}
.tab-header{
	font-size:18px;
	margin-right:10px;
	text-decoration:none;
	margin-bottom:5px;
	display:inline-block;
}
.tab-header.active{
	color:#D54E21;
	background-color:#DCF7CA;
	padding:5px;
	-webkit-border-radius: 4px;
	-moz-border-radius:4px;
	border-radius:4px;	
}
.lbgal-catname-option{
	font-weight:bold;
	font-size:2em;
	_background-color:#DDF7CC;
	color:#FF6633;
	padding:5px 0;
}
</style>
<?php
global $wpdb;
?>
<script>
jQuery(function($) {
        /*$("#gallery_thumb_text, #gallery_top_block, #gallery_thumb_block, #gallery_bottom_block").sortable({
        	connectWith: '.connectedSortable'
        });*/		
		$('#btnSave').click(function(){
			$.each($('.connectedSortable'), function(){
				var parent = $(this);
				$.each(parent.find('li'), function(){
					var hdn =$(this).find('input');
					if(parent.hasClass('top')){
						hdn.attr('name', 'settings[category][blocks][top]['+hdn.val()+']');
					}else if(parent.hasClass('thumb')){
						hdn.attr('name', 'settings[category][blocks][thumb]['+hdn.val()+']');
					}else if(parent.hasClass('bottom')){
						hdn.attr('name', 'settings[category][blocks][bottom]['+hdn.val()+']');
					}
				})
			});
			
			$.each($('.connectedSortable2'), function(){
				var parent = $(this);
				$.each(parent.find('li'), function(){
					var hdn =$(this).find('input');
					if(parent.hasClass('top')){
						hdn.attr('name', 'settings[gallery][_thumbnail][blocks][top]['+hdn.val()+']');
					}else if(parent.hasClass('thumb')){
						hdn.attr('name', 'settings[gallery][_thumbnail][blocks][thumb]['+hdn.val()+']');
					}else if(parent.hasClass('bottom')){
						hdn.attr('name', 'settings[gallery][_thumbnail][blocks][bottom]['+hdn.val()+']');
					}
				})
			})
			$.each($('.connectedSortable3'), function(){
				var parent = $(this);
				$.each(parent.find('li'), function(){
					var hdn =$(this).find('input');
					if(parent.hasClass('top')){
						hdn.attr('name', 'settings[gallery][_filmstrip][blocks][top]['+hdn.val()+']');
					}else if(parent.hasClass('thumb')){
						hdn.attr('name', 'settings[gallery][_filmstrip][blocks][thumb]['+hdn.val()+']');
					}else if(parent.hasClass('bottom')){
						hdn.attr('name', 'settings[gallery][_filmstrip][blocks][bottom]['+hdn.val()+']');
					}
				})
			})
			$.each($('.connectedSortable4'), function(){
				var parent = $(this);
				$.each(parent.find('li'), function(){
					var hdn =$(this).find('input');
					if(parent.hasClass('top')){
						hdn.attr('name', 'settings[gallery][_filmstrip][viewerblocks][top]['+hdn.val()+']');
					}else if(parent.hasClass('thumb')){
						hdn.attr('name', 'settings[gallery][_filmstrip][viewerblocks][thumb]['+hdn.val()+']');
					}else if(parent.hasClass('bottom')){
						hdn.attr('name', 'settings[gallery][_filmstrip][viewerblocks][bottom]['+hdn.val()+']');
					}
				})
			})
			LBGalleryCore.doTask('save');
		});
		$('.connectedSortable').sortable({
			connectWith: '.connectedSortable',
			items: '> .dragable'
		})
		$('.connectedSortable2').sortable({
			connectWith: '.connectedSortable2',
			items: '> .dragable'
		})
		$('.connectedSortable3').sortable({
			connectWith: '.connectedSortable3',
			items: '> .dragable'
		})
		$('.connectedSortable4').sortable({
			connectWith: '.connectedSortable4',
			items: '> .dragable'
		})
    });
</script>

<div class="wrap">
    <div id="lbgal-header-settings" class="icon32"><br>
    </div>
    <h2><?php _e('Settings', 'lb-gallery');?></h2>
    <h2 class="nav-tab-wrapper" style="padding-left:10px;margin-bottom:10px;">
    <?php
	$headerTabs = array(
		'global' => array('title' => __('Global', 'lb-gallery'), 'state' => $this->tabName == 'global' ? ' nav-tab-active' : ''),
		'category' => array('title' => __('Galleries List', 'lb-gallery'), 'state' => $this->tabName == 'category' ? ' nav-tab-active' : ''),
		'gallery' => array('title' => __('Images List', 'lb-gallery'), 'state' => $this->tabName == 'gallery' ? ' nav-tab-active' : '')
	);
	foreach($headerTabs as $name => $tab){
	?>
    	<a href="admin.php?page=lb-gallery/setting&tabname=<?php echo $name;?>" class="nav-tab<?php echo $tab['state']?>"><?php echo $tab['title'];?></a>
	<? }?>        
	</h2>
    <form method="post" name="adminForm">  
    <?php echo $this->fetch("setting.".$this->tabName);?>
    <?php //require_once('setting.galleries.php');?>    
    <?php //require_once('setting.gallery.php');?>    
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="tabname" value="<?php echo $this->tabName;?>" />
    <button type="button" onclick="" class="button" id="btnSave"><?php _e('Save Settings', 'lb-gallery');?></button>
    </form>
</div>    