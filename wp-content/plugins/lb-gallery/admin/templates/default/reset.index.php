<style>
.lbgal-list-tables{
	list-style:none;
	margin:0;
	padding:0;
}
.lbgal-list-tables li{
	list-style:none;
	padding:5px;
	border:1px dotted #999999;
	background-color:#F5F5F5;
	width:300px;
}
.lbgal-list-tables li span{
	float:right;
}
</style>
<div class="wrap">
    <div id="lbgal-header-reset" class="icon32"><br>
    </div>
    <h2><?php _e('Reset/Uninstall', 'lb-gallery');?></h2>
    <p>Here you can reset data for lb-gallery plugin or remove all tables before uninstall this plugin.</p>
    <form method="post" name="adminForm">
        <ul class="lbgal-list-tables">
        <?php foreach($this->tables as $table => $info){?>
            <li><?php echo $info->name;?><span><?php echo $info->exists ? $info->rows_count . ' row(s)' : '<font color="red">Not exists</font>';?></span></li>
        <?php }?>  
        </ul>  
		<button type="button" onclick="if(confirm('Are you sure you want to empty all data?')) LBGalleryCore.doTask('empty_data');" class="button">Empty Data</button>    
        <button type="button" onclick="if(confirm('Are you sure you want to remove all tables?')) LBGalleryCore.doTask('remove');" class="button">Remove Tables</button>    
        <input type="hidden" name="task" />
    </form>
</div>    