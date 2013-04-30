/*global jQuery */
/*!	
* Responsive-Portfolio-Gallery
*
* Copyright 2011, http://www.freshdesignweb.com/
* Released under the WTFPL license 
*
*/

(function( $, undefined ) {$.HoverDir=function(e,t){this.$el=$(t);this._init(e)};$.HoverDir.defaults={hoverDelay:0,reverse:false};$.HoverDir.prototype={_init:function(e){this.options=$.extend(true,{},$.HoverDir.defaults,e);this._loadEvents()},_loadEvents:function(){var e=this;this.$el.bind("mouseenter.hoverdir, mouseleave.hoverdir",function(t){var n=$(this),r=t.type,i=n.find("article"),s=e._getDir(n,{x:t.pageX,y:t.pageY}),o=e._getClasses(s);i.removeClass();if(r==="mouseenter"){i.hide().addClass(o.from);clearTimeout(e.tmhover);e.tmhover=setTimeout(function(){i.show(0,function(){$(this).addClass("da-animate").addClass(o.to)})},e.options.hoverDelay)}else{i.addClass("da-animate");clearTimeout(e.tmhover);i.addClass(o.from)}})},_getDir:function(e,t){var n=e.width(),r=e.height(),i=(t.x-e.offset().left-n/2)*(n>r?r/n:1),s=(t.y-e.offset().top-r/2)*(r>n?n/r:1),o=Math.round((Math.atan2(s,i)*(180/Math.PI)+180)/90+3)%4;return o},_getClasses:function(e){var t,n;switch(e){case 0:!this.options.reverse?t="da-slideFromTop":t="da-slideFromBottom";n="da-slideTop";break;case 1:!this.options.reverse?t="da-slideFromRight":t="da-slideFromLeft";n="da-slideLeft";break;case 2:!this.options.reverse?t="da-slideFromBottom":t="da-slideFromTop";n="da-slideTop";break;case 3:!this.options.reverse?t="da-slideFromLeft":t="da-slideFromRight";n="da-slideLeft";break}return{from:t,to:n}}};var logError=function(e){if(this.console){console.error(e)}};$.fn.hoverdir=function(e){if(typeof e==="string"){var t=Array.prototype.slice.call(arguments,1);this.each(function(){var n=$.data(this,"hoverdir");if(!n){logError("cannot call methods on hoverdir prior to initialization; "+"attempted to call method '"+e+"'");return}if(!$.isFunction(n[e])||e.charAt(0)==="_"){logError("no such method '"+e+"' for hoverdir instance");return}n[e].apply(n,t)})}else{this.each(function(){var t=$.data(this,"hoverdir");if(!t){$.data(this,"hoverdir",new $.HoverDir(e,this))}})}return this}})( jQuery );

/*
jQuery(function(){jQuery(window).scroll(function(){if(jQuery("#mbCenter").size()>0){var e=parseInt(jQuery(document).scrollTop());var t=jQuery("#mbCenter").offset();var n=parseInt(t.top+jQuery("#mbCenter").height()+90-e);var r=jQuery(window).height()-n;if(e<t.top-25){setTimeout(function(){jQuery("#mbCenter").stop().animate({top:jQuery(window).scrollTop()+jQuery("#mbCenter").height()/2+60},500)},150)}if(r>1&&jQuery(window).height()<=jQuery("#mbCenter").height()+90){setTimeout(function(){jQuery("#mbCenter").stop().animate({top:jQuery(window).scrollTop()+150},500)},150)}else if(r>1&&jQuery(window).height()>jQuery("#mbCenter").height()+90){jQuery("#mbCenter").stop().animate({top:jQuery(window).scrollTop()+250},500)}}})}) */

jQuery(function(){jQuery(window).scroll(function(){if(jQuery("#mbCenter").size()>0){var e=parseInt(jQuery(document).scrollTop());var t=jQuery("#mbCenter").offset();var n=parseInt(t.top+jQuery("#mbCenter").height()+90-e);var r=jQuery(window).height()-n;if(e<t.top-90){setTimeout(function(){jQuery("#mbCenter").stop().animate({top:jQuery(window).scrollTop()+340},500)},150)}if(r>1&&jQuery(window).height()<jQuery("#mbCenter").height()-90){setTimeout(function(){jQuery("#mbCenter").stop().animate({top:t.top+340},500)},150)}else if(r>1&&jQuery(window).height()>jQuery("#mbCenter").height()+90){setTimeout(function(){jQuery("#mbCenter").stop().animate({top:jQuery(window).scrollTop()+340},500)},150)}}})})


/*
	StyleSwitcher script from  A List Apart
	Authored by Paul Sowden and Peter-Paul Koch
	http://www.alistapart.com/articles/alternate/
*/

function easyActiveStyleSheet(e){var t,n,r;for(t=0;n=document.getElementsByTagName("link")[t];t++){if(n.getAttribute("rel").indexOf("style")!=-1&&n.getAttribute("title")){n.disabled=true;if(n.getAttribute("title")==e)n.disabled=false}}}function getActiveStyleSheet(){var e,t;for(e=0;t=document.getElementsByTagName("link")[e];e++){if(t.getAttribute("rel").indexOf("style")!=-1&&t.getAttribute("title")&&!t.disabled)return t.getAttribute("title")}return null}function getPreferredStyleSheet(){var e,t;for(e=0;t=document.getElementsByTagName("link")[e];e++){if(t.getAttribute("rel").indexOf("style")!=-1&&t.getAttribute("rel").indexOf("alt")==-1&&t.getAttribute("title"))return t.getAttribute("title")}return null}