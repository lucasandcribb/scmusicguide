if(typeof LBGalleryCore == 'undefined') var LBGalleryCore = {};
(function($){
LBGalleryCore.ajaxUpload = {
	current: 0,
	options: {
		url: ''	
	},
	upload: function(options){		
		var options = options || {},
			query = "",
			form = $(options.form),
			name = 'ajax_upload_iframe_'+(++this.current),
			iframe = $('<iframe name="'+name+'" />').appendTo($(document.body));
		iframe.load(function(){
			var contents = '';							 
			if ( this.contentDocument ){ // FF
				contents = $(this.contentDocument.getElementsByTagName('body')[0]).html();
			}else if ( iFrame.contentWindow ){ // IE
				contents = $(this.contentWindow.document.getElementsByTagName('body')[0]).html();
			}	
			success = options.success || function(){};
			
			success.call(this, contents);
			//location.href = location.href;
		}).css({
			display: 'none',
			height: 0,
			width: 0
		})	
		
		
		form.attr({
			target: name,
			method: 'post',
			action: options.url// + (options.url.indexOf('?') != -1 ? '&' : '?') + query,			
		});		
		if(options.data){
			query = [];
			for(var param in options.data) {
				$('<input type="hidden" name="'+param+'" />').val(options.data[param]).appendTo(form);
			}
			query = query.join('&');
		}
		//alert(options.url + (options.url.indexOf('?') != -1 ? '&' : '?') + query)
		form.submit();
	}	
}

$(document).ready(function(){
	//alert($('.button.ajaxupload').length);						   
	$('.button.ajaxupload').click(function(){
		var form = this.form,
			fname = form.name,
			gid = $(document.adminForm).find('#filters_gid').val();		
		if(fname == 'add-image'){
			if(form.image_url.value == '' || form.image_url.value == null || form.image_url.value.indexOf('http')==-1){
				alert('Please enter image url');
				form.image_url.focus();
				return false;
			}	
		}else{
			if(form.video_url.value == '' || form.video_url.value == null || form.video_url.value.indexOf('http')==-1){
				alert('Please enter video/RSS Feed URL');
				form.video_url.focus();
				return false;
			}
		}
		LBGalleryCore.ajaxUpload.upload({
			form: this.form,
			url: LBGallerySettings.rootsite+'/wp-admin/admin.php?page=lb-gallery/image&task=upload&noheader=true',
			data: {
				gid: gid
			}, 
			success: function(responseText){
				location.href = 'admin.php?page=lb-gallery/image&gid='+gid
			}
		});										 
	})						   
});
})(jQuery)