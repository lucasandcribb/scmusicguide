/*
 * Hello Tabs plugin v 1.0
 * Copyright (c) 2012 Anton Korda
 * Date: 2012-04-5 20:42:16 -0500
 */

(function($) {

    $.fn.extend({
        helloTabs: function(options) {
	
			var defaults = {
					speed : 500,
					effect : 'showHide',
			        easing : false,
			        menuId : '#tabs-menu',
					contentId : '#tabs-content-inner',
			}
			
			var options = $.extend(defaults, options);
			
			var speed = options.speed;
			var easing = options.easing;
			var menuId = options.menuId;
			var contentId = options.contentId;
			var effect = options.effect;

			
			return this.each(function() {
				
				var obj = $(this);
				$(obj).prepend('<ul id="'+menuId.replace("#","").replace(".","")+'" class="tabs-menu clearfix"></ul>');
				var menu = $(menuId,obj);
				var content = $(contentId,obj);
		
			
			
			    var maxH = -1;
				var maxW = $(obj).parent().width()+1;
				$('> div', content).each(function(i){
                      
				      $(this).addClass('parent');
					  				
					  var h = $(this).height(); 
					  maxH = h > maxH ? h : maxH;

					  objId = $(this).attr('id'); 
					  objHeading = $('h2',this).text();
					  if(objHeading=='' || objHeading=='undefined'){
						objHeading=i+1;
					  }else{
						$('h2', this).remove();
					  }
					  $(menu).append('<li class=' + objId + '><a href="#">' + objHeading + '</a></li>');
					  
				});
				
			    
				$('> div', content).first().addClass('show');
				$('> li', menu).first().addClass('selected');
				
				
				
				$('li a', menu).click(function(){
					if (!$(this).parent().hasClass('selected')) {    
						$('li', menu).removeClass('selected');
						$(this).parent().addClass('selected');
						
						var selement = $('div.parent:eq(' + $('> li a', menu).index(this) + ')', content);
						var helement = $('div.parent', content);
						tabWidth(selement, speed);
						hideElement(helement, effect, speed, easing);
						showElement(selement, effect, speed, easing);
						
					}
					return false;
				});
				
				
				
				function tabWidth(parent, speed){
					$(content).animate({height : parent.height()},speed);
				}
				
				function hideElement(element, effect, speed, easing){
					switch(effect){
						case 'slideDownSlideUp' : 
						case 'fadeInSlideUp' :
						case 'fadeInSlideUpDelay' :
						case 'slideDownSlideUpDelay' : element.stop(true,true).slideUp(speed,easing); break;
						case 'fadeInFadeOutDelay' : 
						case 'slideDownFadeOutDelay' : element.stop(true,true).fadeOut(speed,easing); break;
						case 'showHide' : element.stop(true,true).hide(); break;
						case 'showHideAnimate' : element.stop(true,true).hide(speed,easing); break;
						case 'leftShowLeftHide' :
						case 'topShowLeftHide' :
						case 'bottomShowLeftHide' : 
						case 'rightShowLeftHide' : element.stop(true,true).rightHide(speed, easing, maxW); break;
						case 'leftShowRightHide' : 
						case 'topShowRightHide' : 
						case 'bottomShowRightHide' :
						case 'rightShowRightHide' : element.stop(true,true).leftHide(speed, easing, maxW); break;
						case 'bottomShowBottomHide' : 
						case 'leftShowBottomHide' :
						case 'rightShowBottomHide' : 
						case 'topShowBottomHide' : element.stop(true,true).bottomHide(speed, easing, maxH); break;
						case 'topShowTopHide' : 
						case 'leftShowTopHide' : 
						case 'rightShowTopHide' : 
						case 'bottomShowTopHide' : element.stop(true,true).topHide(speed, easing, maxH); break;
					}
				}
				
				function showElement(element, effect, speed, easing){
					switch(effect){
						case 'slideDownSlideUp' : element.stop(true,true).slideDown(speed,easing); break;
						case 'slideDownSlideUpDelay' : 
						case 'slideDownFadeOutDelay' :element.stop(true,true).delay(speed).slideDown(speed,easing); break;
						case 'fadeInSlideUpDelay' :
						case 'fadeInFadeOutDelay' : element.stop(true,true).delay(speed).fadeIn(speed,easing); break;
						case 'fadeInSlideUp' : element.stop(true,true).fadeIn(speed,easing); break;
						case 'showHide' : element.stop(true,true).show(); break;
						case 'showHideAnimate' : element.stop(true,true).show(speed,easing); break;
						case 'rightShowRightHide' :
						case 'rightShowTopHide' : 
						case 'rightShowBottomHide' : 
						case 'rightShowLeftHide' : element.stop(true,true).leftShow(speed, easing, maxW); break;
						case 'leftShowRightHide' : 
						case 'leftShowTopHide' : 
						case 'leftShowBottomHide' : 
						case 'leftShowLeftHide' : element.stop(true,true).rightShow(speed, easing, maxW); break;
						case 'topShowLeftHide' : 
						case 'topShowRightHide' : 
						case 'topShowTopHide' : 
						case 'topShowBottomHide' : element.stop(true,true).topShow(speed, easing, maxH); break;
						case 'bottomShowLeftHide' :
						case 'bottomShowRightHide' :
						case 'bottomShowBottomHide' : 
						case 'bottomShowTopHide' : element.stop(true,true).bottomShow(speed, easing, maxH); break;
					}
				}
	

				
				
				
				
			});
			
			
			
		}	
    });
	
	//effects
	$.fn.topShow = function(speed, easing, max){
	    $(this).show();
	    $(this).css({'position':'absolute','left':'15px','top':-(max)});
	    return $(this).stop().animate({
			'top' : '0px'
		}, speed || 500, easing || 'swing');
    };

	$.fn.leftShow = function(speed, easing, max){
	    $(this).show();
	    $(this).css({'position':'absolute', 'top': '0','left':max});
	    return $(this).stop().animate({
			'left' : '15px'
		}, speed || 500, easing || 'swing');
    };
	
	$.fn.bottomShow = function(speed, easing, max){
	    $(this).show();
	    $(this).css({'position':'absolute','left':'15px','top':(max)});
	    return $(this).stop().animate({
			'top' : '0px'
		}, speed || 500, easing || 'swing');
    };
	
	$.fn.rightShow = function(speed, easing, max){
	    $(this).show();
	    $(this).css({'position':'absolute','top': '0','left':-(max)});
	    return $(this).stop().animate({
			'left' : '15px'
		}, speed || 500, easing || 'swing');
    };
	
	$.fn.topHide = function(speed, easing, max){
	    $(this).css('position','absolute');
	    return $(this).stop().animate({
			'top' : -(max)
		}, speed || 500, easing || 'swing' );
 
	};
	
	$.fn.bottomHide = function(speed, easing, max){
	    $(this).css('position','absolute');
	    return $(this).stop().animate({
			'top' : (max)
		}, speed || 500, easing || 'swing');
 
	};
	
	$.fn.rightHide = function(speed, easing, max){
	    $(this).css('position','absolute');
	    return $(this).stop().animate({
			'left' : -(max)
		}, speed || 500,easing || 'swing');
 
	};

	$.fn.leftHide = function(speed, easing, max){
	    $(this).css('position','absolute');
	    return $(this).stop().animate({
			'left' : (max)
		}, speed || 500, easing || 'swing');
 
	};
	
	
})(jQuery);