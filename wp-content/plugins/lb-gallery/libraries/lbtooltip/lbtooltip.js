// JavaScript Document
(function($){
$.fn.lbGalleryTooltip = function(options){
	var tooltipWrapper = $('.lbtooltip-wrapper');
	var contentWrapper = null;
	if(!tooltipWrapper.hasClass('lbtooltip-wrapper')){
		tooltipWrapper = $('<div class="lbtooltip-wrapper"></div>').css({display: 'none'}).appendTo($(document.body));
		contentWrapper = $('<div class="lbtooltip-content" />').appendTo(tooltipWrapper).html('');
		tooltipWrapper.append('<span class="lbtooltip-arrow" />');
	}else{
		contentWrapper = tooltipWrapper.find('.lbtooltip-content');	
	}
	var isShow = false, timer = null;
	options = $.extend({
		position: "top-center"				   
	}, options);
	return $.each(this, function(){
		var self = $(this);
		if(self.attr('lb-tooltip')) return;
		self.attr('lb-tooltip', true);
		if(!self.attr('title')) return;
		var offset = {start: {}, end: {}};
		var animate = true;
		//var timer = null;
		var text = (self.attr('title') || '').split('::');
		if(text.length == 2){
			$.data(this, 'title', text[0]);
			$.data(this, 'text', text[1]);
		}else if(text.length == 1){
			$.data(this, 'text', text[0]);
		}
		self.removeAttr('title');
		var _mouseout = function(){
			clearTimeout(timer);			
			tooltipWrapper
			.stop()
			.animate({
				opacity: 0,
				top: offset.start.y
			}, 250, function(){
				$(this).css({display: 'none'})	
			});	
			isShow = false;
		}
		self.mouseover(function(){   
			clearTimeout(timer);timer = null;
			var html = [],
				title = $.data(this, 'title'),
				text = $.data(this, 'text');
				
				
			if(title) html.push('<h3 class="lb-tooltip-title">'+title+'</h3>');
			if(text) html.push('<span class="lb-tooltip-text">'+text+'</span>');
			contentWrapper
			.html(html.join(''));
			var position = self.offset();
			//$('#xxxxxxxxxxxxxx').html(Math.random()+':'+position.top)	
			var offsets = options.position.split('-');
			switch(offsets[0]){
				case 'top':
					offset.end.y = position.top-tooltipWrapper.height()-5;	
					offset.start.y = offset.end.y-15;	
					contentWrapper.css({marginBottom: 13, marginTop: 0});
					tooltipWrapper.find('.lbtooltip-arrow')
					.css({
						bottom: 0,
						top: 'auto',
						left:(tooltipWrapper.width()-24)/2,
						backgroundPosition: '0 -14px'
					});
					break;
				case 'bottom':
					offset.end.y = position.top+self.height()+5;//tooltipWrapper.height()-5;	
					offset.start.y = offset.end.y+15;	
					contentWrapper.css({marginTop: 13, marginBottom: 0});	
					tooltipWrapper.find('.lbtooltip-arrow')
					.css({
						top: 0,
						bottom: 'auto',
						left:(tooltipWrapper.width()-24)/2,
						backgroundPosition: '0 0'
					});
			}
			if(offsets[1] == 'center'){
				offset.start.x = offset.end.x = position.left+(self.width()-tooltipWrapper.width())/2;	
			}
			tooltipWrapper
			.stop()
			.css({
				 display: 'block',
				 top: offset.start.y,
				 left: offset.start.x,
				 opacity: 0
			}).animate({
				top: offset.end.y,
				left: offset.end.x,
				opacity: 1
			}, 250)
			isShow = true;
		}).mouseout(function(){
			_mouseout.call(this);
		})
		.click(function(){
			$(this).trigger('mouseout');
			_mouseout.call(this);
		})
		.mousemove(function(evt){
			return;
			if(isShow){
				tooltipWrapper.css({
					top: evt.pageY + options.position.y,
					left: evt.pageX + options.position.x
				});	
			}
		});
	})
}		  
})(jQuery)