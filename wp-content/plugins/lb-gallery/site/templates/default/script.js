// JavaScript Document
(function($){
$.fn.lbGallery = function(opt, params){
	var options = opt;
		options = $.extend({
							   
		}, options || {});
	return $.each(this, function(){
		var root = $(this);
		if(root.attr('lb-gallery')) return;
		root.attr('lb-gallery', 1);			
		var
			galleryViewMode = 'gallery',
			imageViewMode = 'thumbnail',
			testWidthElement = $('<div class="lbgal-testwidth"></div>'),
			dataResponse = {image: null, gallery: null},
			imagePages = 0,
			galleryPages = 0,
			currentImagePage = 0,
			currentGalleryPage = 0,
			galleryID = 0,
			categoryID = 0,
			imageNavigator = {},
			galleryNavigator = {},
			resetAll = false;
		root.before(testWidthElement);
		var i=0;
		//if(0==options.shortcode.show_top_bar) root.find('.lbgal-header').remove();
		
		var getGalleryWidth = function(){		
			return testWidthElement.width();
		}
		var loadGalleries = function(cid, success){
			galleryViewMode = 'gallery';
			if(typeof cid == 'undefined') cid = categoryID;
			else categoryID = cid;
			var elem = root.find('.lbgal-items-list.lbgal-gallery-pagenum-'+categoryID+'-'+(currentGalleryPage+1)+'');
			if(elem.is('div')){
				showPage(elem.addClass('lbgal-hidden'), 0, function(){
				});
				root.find('.lbgal-header').html(galleryNavigator['_'+categoryID+'_'+currentGalleryPage])//.remove();
				buildHeader();
				return false;
			}
			showLoading();
			var query = {
				action: 'lbgal_load_galleries',
				cid: cid,
				gid: root.find('.hdn-current-gid').val(),	
				width: getGalleryWidth(),
				paged: currentGalleryPage+1,
				shortcode: options.shortcode
			}
			
			$.ajax({
				url: LBGallerySettings.ajax,
				data: query,
				type: 'POST',
				dataType: 'json',
				success: function(response){
					//root.width(response.json.settings.width);
					root.find('.lbgal-header').html(response.header);
					showPage($(response.html).addClass('lbgal-hidden').appendTo(root.find('.lbgal-body')), 1, function(){
						buildBody(response.json.settings);	
					});
					categoryID = response.json.cid;
					buildHeader('gallery');						
					galleryPages = response.totalPages;
					root.find('.hdn-current-cid').val(response.json.cid)	
					root.find('.hdn-current-gid').val(response.json.gid)
			
					galleryNavigator['_'+categoryID+'_'+currentGalleryPage] = response.header;
					hideLoading();			
					if(typeof success == 'function') success.call();
				}
			});
		}
		var loadImages = function(gid, success){
			galleryViewMode = 'image';
			var storedGID = galleryID;
			if(typeof gid == 'undefined'){
				gid = galleryID;
			}else{
				galleryID = gid;
			}
			
			var elem = root.find('.lbgal-items-list.lbgal-image-pagenum-'+galleryID+'-'+(currentImagePage+1)+'');
			if(elem.is('div')){
				showPage(elem.addClass('lbgal-hidden'), 1, function(){
				});
				root.find('.lbgal-header').html(imageNavigator['_'+galleryID+'_'+currentImagePage]);
				buildHeader();
				return false;
			}			
			showLoading();
			$.ajax({
				url: LBGallerySettings.ajax,
				data: {
					action: 'lbgal_load_images',
					gid: gid,
					width: getGalleryWidth(),
					paged: currentImagePage,
					imageViewMode: imageViewMode,
					shortcode: options.shortcode
				},
				type: 'POST',
				dataType: 'json',
				success: function(response){
					imagePages = response.totalPages;
					//root.width(response.json.settings.gallery_width);
					root.find('.lbgal-header').html(response.header);
					buildHeader('thumbnail');	
					showPage($(response.html).addClass('lbgal-hidden').appendTo(root.find('.lbgal-body')), 1, function(){
						buildBody(response.json.settings);
					});					
					root.find('.hdn-current-gid').val(response.json.gid)	
					galleryID = response.json.gid
					imageNavigator['_'+galleryID+'_'+currentImagePage] = response.header;
					hideLoading();
					if(typeof success == 'function') success.call();
				}
			});
		}
		var buildGalleryText = function($settings){
			var page = (galleryViewMode == 'gallery' ? currentGalleryPage : currentImagePage)+1,
				ID = galleryViewMode == 'gallery' ? categoryID : galleryID,
				list = root.find('.lbgal-items-list.lbgal-'+galleryViewMode+'-pagenum-'+ID+'-'+page),
				thumbnail = list.find('.lbgal-gallery-thumbnail'),
				text = thumbnail.find('.lbgal-gallery-text').css({opacity: 0.8}),
				height = text.parent().height(),
				width = text.parent().width(),
				css = {},
				animate = {};
			if(text.hasClass('lbgal-visible')){				
				css = {top: 0, left: 0};				
			}else if(text.hasClass('lbgal-slide-up-in')){				
				css = {top: height, left: 0};
				animate = {top: 0};
			}else if(text.hasClass('lbgal-slide-down-in')){
				css = {top: -height, left: 0}
				animate = {top: 0}
			}else if(text.hasClass('lbgal-slide-right-in')){
				css = {top: 0, left: -width}
				animate ={left: 0}
			}else if(text.hasClass('lbgal-slide-left-in')){
				css = {top: 0, left: width};
				animate = {left: 0}
			}else if(text.hasClass('lbgal-fade-in')){
				css = {top: 0, left: 0, opacity: 0}
				animate = {opacity: 0.8}
			}else if(text.hasClass('lbgal-slide-up-out')){				
				css = {top: 0, left: 0};
				animate = {top: -height};
			}else if(text.hasClass('lbgal-slide-down-out')){
				css = {top: 0, left: 0}
				animate = {top: height}
			}else if(text.hasClass('lbgal-slide-right-out')){
				css = {top: 0, left: 0}
				animate ={left: width}
			}else if(text.hasClass('lbgal-slide-left-out')){
				css = {top: 0, left: 0};
				animate = {left: -width}
			}else if(text.hasClass('lbgal-fade-out')){
				css = {top: 0, left: 0, opacity: 0.8}
				animate = {opacity: 0}
			}
			
			text.css(css);
			
			var _settings = galleryViewMode == 'gallery' ? $settings : $settings._thumbnail;
			
			if(_settings.thumb_opacity >= 0)
				thumbnail.find('img').css({opacity: _settings.thumb_opacity});
			thumbnail.hover(function(){
				$(this).find('.lbgal-gallery-text').stop().animate(animate, 350);	
				if(_settings.thumb_hover_opacity >= 0)
					$(this).find('img').stop().animate({opacity: _settings.thumb_hover_opacity}, 350);
			},function(){
				$(this).find('.lbgal-gallery-text').stop().animate(css, 350);	
				if(_settings.thumb_opacity >= 0)
					$(this).find('img').stop().animate({opacity: _settings.thumb_opacity}, 350);
			});

		}
		var buildHeader = function(view){
			// galleries list view mode
			if(galleryViewMode == 'gallery'){
				root.find('select.lbgal-cid').change(function(){
					currentGalleryPage = 0;	
					imageViewMode = 'thumbnail';
					galleryViewMode = 'gallery';
					categoryID = $(this).val();					
					loadGalleries(categoryID);
				});
				root.find('.lbgal-pagination').bind('click', function(){
					var $this = $(this);
					if($this.hasClass('disabled')) return false;					
					if($this.hasClass('prev')){
						currentGalleryPage--;
					}else if($this.hasClass('next')){
						currentGalleryPage++;	
					}
					var elem = root.find('.lbgal-items-list.lbgal-gallery-pagenum-'+categoryID+'-'+(currentGalleryPage+1)+'');
					if(elem.is('div')){
						showPage(elem, 0);
						root.find('.lbgal-header').html(galleryNavigator['_'+categoryID+'_'+currentGalleryPage])
						buildHeader();
						return false;
					}
					loadGalleries(root.find('.hdn-current-cid').val());
					return false;
				});
			}else{
				// images list view mode
				root.find('select.lbgal-gid').change(function(){
					currentImagePage = 0;	
					imageViewMode = 'thumbnail';
					galleryID = $(this).val();
					loadImages();
				});
				root.find('.lbgal-pagination').bind('click', function(){
					var $this = $(this);
					if($this.hasClass('disabled')) return false;
					if($this.hasClass('prev')){
						currentImagePage--;
					}else if($this.hasClass('next')){
						currentImagePage++;	
					}
					var elem = root.find('.lbgal-items-list.lbgal-image-pagenum-'+galleryID+'-'+(currentImagePage+1)+'');
					if(elem.is('div')){
						showPage(elem, 1);
						root.find('.lbgal-header').html(imageNavigator['_'+galleryID+'_'+currentImagePage]);
						buildHeader();
						return false;
					}
					loadImages(root.find('.hdn-current-gid').val());
					return false;
				});
				root.find('.lbgal-switcher').click(function(){
					var $this = $(this);
					if($this.hasClass('thumbnail')){
						imageViewMode = 'thumbnail';	
					}else  if($this.hasClass('filmstrip')){
						imageViewMode = 'filmstrip';	
					}
					currentImagePage = 0;
					loadImages(root.find('.hdn-current-gid').val());
					return false;											
				});
			
				root.find('a.lbgal-back-gallery').click(function(){
					try{
						currentImagePage = 0;
						// find current category to load
						var cid = categoryID;
						loadGalleries(cid);
					}catch(e){alert(e)}
					return false;
				});
			}
			root.find('.lb-tooltip').lbGalleryTooltip({position: 'bottom-center'});
		}
		var buildBody = function($settings){			
			var page = (galleryViewMode == 'gallery' ? currentGalleryPage : currentImagePage)+1,
				ID = galleryViewMode == 'gallery' ? categoryID : galleryID,
				list = root.find('.lbgal-items-list.lbgal-'+galleryViewMode+'-pagenum-'+ID+'-'+page),
				thumbnails = list.find('.lbgal-gallery-thumbnail'),
				loaded = 0,
				total = thumbnails.length;
			
			var _thumbnailLoaded = function(){				
				if(loaded == total){
					buildGalleryText($settings);
					buildRating();
				}					
			}
			var _thumbnailError = function(){
				_thumbnailLoaded();				
			}
			thumbnails.each(function(){
				var $this = $(this),
					img =  $this.find('img'),
					src = img.attr('src');
				img.attr('src', '');
				img.load(function(){
					$(this).css({visibility: 'visible'});
					loaded++;	
					_thumbnailLoaded();
				}).error(function(){
					loaded++;	
					_thumbnailError.call(this);
				}).attr('src', src); // reload image to ensure it trigger event
				$this.find('.lbgal-gallery-text').click(function(){
					$this.find('a.thumbnail-wrapper').trigger('click');											 
				});
			});			
			$.each(list.find('.lbgal-items-row'), function(){
				var $this = $(this),
					li = $this.find('li:not(.lbgal-clearboth)'),
					maxHeight = 0;
				if(options.global.shorten_title == 1){
					var parentWidth = li.width();
					$.each(li, function(){
						var title = $(this).find('.lbgal-title').css({'white-space': 'nowrap', 'display': $.browser.msie && $.browser.version <8 ? '' : 'inline-block'}),
							html = title.html();
						if(title.width() > parentWidth){
							for(var n = html.length, i = n-1; i >=0;i--){
								title.html(title.html().substr(0, i)+"...");
								if(title.width() <= parentWidth){
									title.attr('title', html);
									title.width(parentWidth).lbGalleryTooltip();
									break;
								}
							}
							
						}	
					});					
				}else{	
					li.each(function(){
						var h = $(this).find('.lbgal-title').height();				 
						if(h > maxHeight) maxHeight = h;
					});
					li.find('.lbgal-title').height(maxHeight);
				}
				maxHeight = 0;
				li.each(function(){
					var h = $(this).find('.lbgal-gallery-text .lbgal-description').height();				 
					if(h > maxHeight) maxHeight = h;
				});
				li.find('.lbgal-gallery-text .lbgal-description').height(maxHeight);
				//
			})
			root.find('.lbgal-body').stop().animate({height: list.height()}, 750);
			list.find('h3.lbgal-title.is-gallery').click(function(){
				var gid = $(this).parents('li').find('.hdn-gallery-id').val();
				loadImages(gid);
			});		
			list.find('.lbgal-gallery-thumbnail').click(function(){
				var gid = $(this).parents('li').find('.hdn-gallery-id').val();
				loadImages(gid);												 
			})
				
			if(imageViewMode == 'thumbnail'){
				var lightboxSettings = {
					overlay_gallery_max: 9999,
					theme: options.global.lightbox.theme || 'default',
					overlay_gallery: options.global.lightbox.overlay_gallery == 1 ? true : false,
					show_title: false,//options.global.lightbox.show_title == 1 ? true : false,
					thumb_width: parseInt(options.global.lightbox.thumb_width || 50),
					thumb_height: parseInt(options.global.lightbox.thumb_height || 35),
					deeplinking: false
				}
				if(!options.global.lightbox.social_tools){
					lightboxSettings.social_tools = false	
				}
				root.find('.thumbnail-wrapper').prettyPhoto2(lightboxSettings);	
				root.find('.lbgal-title').click(function(){
					$(this).parents('li').find('.thumbnail-wrapper').trigger('click');										 
				})
			}else if(imageViewMode == 'filmstrip'){
				var scrollable = root.find('.lbgal-filmstrip-thumb-wrapper'),
					scrollableWidth = scrollable.width(),
					filmstripThumbs = scrollable.find('img'),
					isLoaded = false;
				filmstripThumbs.load(function(){
					if(isLoaded) return;
					isLoaded = true;
					if(scrollableWidth > scrollable.parent().width()){						
						var pane = scrollable.parent();
						pane.css({
							height: scrollable.height()+10
						})
						pane.jScrollPane({
							animateScroll: true		
						});
					}	
				});
				scrollable.find('a').each(function(){
					$(this).click(function(){
						showLoading();
						loadViewerImage($(this).attr('rel'), function(){hideLoading()})									
						return false;
					}).lbGalleryTooltip();
				});
				setTimeout(function(){
					scrollable.find('a:first').trigger('click');
				},100);
			}
		}	
		var buildRating = function(){
			var page = (galleryViewMode == 'gallery' ? currentGalleryPage : currentImagePage)+1,
				ID = galleryViewMode == 'gallery' ? categoryID : galleryID,
				list = root.find('.lbgal-items-list.lbgal-'+galleryViewMode+'-pagenum-'+ID+'-'+page),
				rating_form = list.find('.lbgal-rating-form'),
				rating_type = rating_form.hasClass('lbgal-gallery') ? 'gallery' : 'image';
			rating_form.find('li.lbgal-rating-stars')
			.click(function(){
				var $this = $(this);
				var rating = $(this).find('.current-rating').width()/options.rating[options.global.star_style].size[0];
				$.ajax({
					url: LBGallerySettings.ajax,
					data: {
						ref_id: $(this).find('.hdn-item-id').val(),
						action: 'lbgal_rating',
						rating_type: $this.find('.hdn-rating-type').val(),
						rating: rating
					},
					type: 'POST',
					dataType: 'json',
					success: function(response){
						if(response.errorMessage){
							alert(response.errorMessage);
							return false;	
						}
						$this.html(response.html)	
						$this.siblings('.lbgal-rating-text').find('.votes_count').html(response.votes);
						$this.siblings('.lbgal-rating-text').find('.rating_value').html(response.rating);								
					}
				});
			})
			.hover(function(){}, function(){
				var w = parseInt($(this).find('.hdn-current-rating-value').val());
				$(this).find('.current-rating').css({width: w})
			})
			.mousemove(function(e){
				var parentOffset = $(this).parent().offset(), 
			   		x =  e.pageX - $(this).offset().left,
					y = e.pageY - $(this).offset().top,					
					z = options.rating[options.global.star_style].size[0],
					t = parseInt(z*options.global.half_star);
				
				$(this).find('.current-rating').css({width: x - (x%t) + t})
			});	
		}
		var showLoading = function(){
			root.find('.lbgal-mainoverlay').css({display: 'block'});	
		}
		var hideLoading = function(){
			root.find('.lbgal-mainoverlay').css({display: 'none'});	
		}
		var loadViewerImage = function(id, success){
			$.ajax({
				url: LBGallerySettings.ajax,
				data: {
					id: id,
					gid: root.find('.hdn-current-gid').val(),
					action: 'lbgal_load_single_image'
				},
				type: 'POST',
				dataType: 'json',
				success: function(json){
					if(json.image.type == 'video'){
						var iframe = $('<iframe />');
						var videoUrl = null;
						switch(json.image.provider){
							case 'youtube':
								videoUrl = 'http://www.youtube.com/embed/'+getVideoID('v', json.image.fullsrc);
								break;								
							case 'vimeo':
								var regExp = /http:\/\/(www\.)?vimeo.com\/(\d+)/;
								var match = json.image.fullsrc.match(regExp);
								videoUrl = 'http://player.vimeo.com/video/'+ match[2] +'?title=0&amp;byline=0&amp;portrait=0';								
								break;
						}
						iframe.attr({
							width: root.width(),
							height: parseInt(root.width())*344/500,
							src: videoUrl,
							frameborder: 0
						});
						root.find('.lbgal-filmstrip-viewer').css({opacity: 0}).html(json.html)
						root.find('.lbgal-viewer-image').html(iframe);
						
						root.find('.lbgal-filmstrip-viewer-inside').css({
							marginLeft: (root.width() - this.width)/2		   
						});
						root.find('.lbgal-filmstrip-viewer').animate({
							opacity: 1,
							height: root.find('.lbgal-filmstrip-viewer-inside').height()
						});
						buildRating();
						if(success) success.call(this)
						return;	
					}
					var handle = $(new Image()).appendTo($(document.body)),
						css = {};
						
					if(parseInt(json.settings._filmstrip.viewer_height)>0){
						css['max-height'] = json.settings._filmstrip.viewer_height+'px';
					}
					css['max-width'] = root.width();
					handle.load(function(){										 
															 
						root.find('.lbgal-filmstrip-viewer').css({opacity: 0}).html(json.html)
						root.find('.lbgal-viewer-image').html(handle);
						
						root.find('.lbgal-filmstrip-viewer-inside').css({
							marginLeft: (root.width() - this.width)/2		   
						});
						root.find('.lbgal-filmstrip-viewer').animate({
							opacity: 1,
							height: root.find('.lbgal-filmstrip-viewer-inside').height()
						});
						buildRating();
						if(success) success.call(this)
					})
					.addClass('viewer')
					.css(css)
					.attr('src', json.image.fullsrc);
				}
			});
		}
		function getVideoID(name,url){
			name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
			var regexS = "[\\?&]"+name+"=([^&#]*)";
			var regex = new RegExp( regexS );
			var results = regex.exec( url );
			return ( results == null ) ? "" : results[1];
		}
		function showPage(page, type, success){
			if(type == 1 || type == 0){//image
				var oldPage = root.find('.lbgal-items-list:not(.lbgal-hidden)'),
					_success = function(){
						if(!page.is('div')){	
							root.find('.lbgal-body').stop().animate({height: 0}, 750);
						}else{						
							page.css({opacity: 0, left: 0, zIndex: 10})
							.removeClass('lbgal-hidden')
							.stop()
							.animate({opacity: 1}, 1050);
							root.find('.lbgal-body').stop().animate({height: page.height()}, 750);
							if(success) success.call();
						}	
					};
				oldPage
				.stop()
				.css({zIndex: 100, left: 0})
				.animate({left: -oldPage.width()}, 1050, function(){
					oldPage
					.css({zIndex: 1})
					.addClass('lbgal-hidden');										
				});
				if(!oldPage.is('div')){
					_success();
				}else{
					setTimeout(function(){_success();}, 450);	
				}
				
			}
		}
		if(options.shortcode.listview == 'gallery'){
			loadGalleries(options.shortcode.cid);
		}else
			loadImages(options.shortcode.gid);
		var resizeTimer = null,
			$window = $(window),
			windowWidth = $window.width(),
			windowHeight = $window.height(),
			galleryWidth = getGalleryWidth();
		$window.resize(function(){
			clearTimeout(resizeTimer);		
			if(getGalleryWidth() == galleryWidth) return
			showLoading();
			resizeTimer = setTimeout(function(){
				var w = getGalleryWidth();
				if(w == galleryWidth){
					hideLoading();
					return;
				}
				galleryWidth = w;
				resetAll = true;
				root.find('.lbgal-items-list').remove();
				switch(galleryViewMode){
					case 'gallery':
						loadGalleries(undefined, function(){resetAll = false});
						break;
					case 'image':
						loadImages(undefined, function(){resetAll = false});
						break;
				}
			},500);
		})		
	});
}		
$.fn.lbGallerySingle = function(){
		
}
})(jQuery);