// JavaScript Document
(function($){
$.fn.lbGallery = function(options){
	options = $.extend({
					   
	}, options || {});
	return $.each(this, function(){
		var self = $(this);							 
		self.$ = function(selector){
			return self.find(selector);
		}
		$.each(self.$('.lbgal-gallery-wrapper'), function(){
			var $this = $(this),
				overlay = $('<div class="">asdas</div>');
			$this.append(overlay)
		});
		//alert(self.$('.lbgal-gallery-image').html())
	})	
}		

})(jQuery);
