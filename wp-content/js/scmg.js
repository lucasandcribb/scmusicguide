$(document).ready(function() {


	$('.expand-review').click(function() {
		var expandId = $(this).attr('rel');
		$('.expand-review').hide();
		$('.retract-review').fadeIn();
		$(this).parent().children('.album-review-content').fadeIn();
	});
	$('.retract-review').click(function() {
		var expandId = $(this).attr('rel');
		$('.retract-review').hide();
		$('.expand-review').fadeIn();
		$(this).parent().children('.album-review-content').fadeOut();
	});

    $('#featured-artist').mouseenter(function() {
    	$('#featured-name').css({'opacity':1.0});
    }).mouseleave(function() {
    	$('#featured-name').css({'opacity':0.7});
    });

    $('.alpha-link').click(function() {
    	var filter = $(this).attr('rel');
    	$('.index-single-cont').each(function() {
    		var alpha = $(this).attr('alpha');
    		if (filter == alpha) {
    			$(this).show();
    		} else if (filter == 'All') {
    			$(this).show();
    		} else {
    			$(this).hide();
    		}
    	});
    });


    $('.genre-link').click(function() {
    	var filter = $(this).attr('rel');
    	$('.index-single-cont').find('.artist-section').each(function() {
    		var genre = $(this).attr('genre');
    		if ( genre.contains(filter) ) {
    			$(this).parent().show();
    		} else {
    			$(this).parent().hide();
    		}
    	});
    	$('.index-single-cont').each(function() {
    		if ($(this).find('.artist-section').length == 0) {
    			$(this).hide();
    		}
    	})
    });

    $('.slide-main').first().addClass('current');
    $('.current').fadeIn(500);
    $('.slide-thumb').first().addClass('current-thumb');
    
    var hpSlideInterval;
    hpSlideInterval = setInterval(function() {
        hpSlideNext();
    }, 5000);

    $('#hp-slide-cont').mouseenter(function() {
        clearInterval(hpSlideInterval);
    }).mouseleave(function() {
        hpSlideInterval = setInterval(function() {
            hpSlideNext();
        },  5000);
    });

    $('#hp-slidethumb-cont').mouseenter(function() {
        clearInterval(hpSlideInterval);
    }).mouseleave(function() {
        hpSlideInterval = setInterval(function() {
            hpSlideNext();
        },  5000);
    });

    $('.slide-thumb').click(function() {
        $('.slide-thumb').removeClass('current-thumb');
        $(this).addClass('current-thumb');
        var ind = parseInt($(this).attr('rel')),
            currentId = '#slide-'+ind;
        $('.slide-main').each(function() {
            var slideIndex = parseInt($(this).attr('rel'));
            if (slideIndex == ind) {
                $('.current').removeClass('current');
                $(this).addClass('current');
                $('.current').fadeIn(1000);
            }
        });
    });

    $('#Musicians_Corner .widget_better_rss_widget').first().show();   

    $('.mc-nav-tabs').click(function() {
        var tab = $(this).attr('rel');
        $('.mc-nav-tabs').removeClass('mc-nav-current');
        $(this).addClass('mc-nav-current');
        $('#Musicians_Corner ul li .widgettitle').each(function() {
            var title = $(this).html();
            if (tab == title) {
                $('.widget_better_rss_widget').hide();
                $(this).parent().show();
            }
        });
    });

});

function hpSlideNext() {
    var count = 0;
    $('.slide-main').each(function() {
        count++;
    });
    var currentSlide = parseInt($('#hp-slide-cont .current').attr('rel')),
        nextSlideIndex = currentSlide + 1,
        leftPos = parseInt($('#hp-slide-cont').css('margin-left')),
        currentId = '#slide-'+currentSlide;
    if (count == nextSlideIndex) {
        $('#hp-slide-cont .current').removeClass('current');
        $('.slide-main').first().addClass('current');        
        $('.current').fadeIn(1000);
        $(currentId).fadeOut();
        $('.slide-thumb').removeClass('current-thumb');
        $('.slide-thumb').first().addClass('current-thumb');
    } else {
        $('.slide-main').each(function() {
            if (parseInt($(this).attr('rel')) == nextSlideIndex) {
                $('#hp-slide-cont .current').removeClass('current');
                $(this).addClass('current');
                $('.current').fadeIn(1000);
                $(currentId).fadeOut();
            }
        })
        $('.slide-thumb').each(function() {
            if (parseInt($(this).attr('rel')) == nextSlideIndex) {
                $('.slide-thumb').removeClass('current-thumb');
                $(this).addClass('current-thumb');
            }
        });
    }
}













