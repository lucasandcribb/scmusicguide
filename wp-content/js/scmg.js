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
            newLeft = ind * -752;
        $('.slide-main').each(function() {
            var slideIndex = parseInt($(this).attr('rel'));
            if (slideIndex == ind) {
                $('.current').removeClass('current');
                $(this).addClass('current');
                $('#hp-slide-cont').animate({'margin-left': newLeft}, 1500);
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
        leftPos = parseInt($('#hp-slide-cont').css('margin-left'));
    if (count == nextSlideIndex) {
        $('#hp-slide-cont .current').removeClass('current');
        $('.slide-main').first().addClass('current');
        $('#hp-slide-cont').css({'margin-left': 0}, 1500);
        $('.slide-thumb').first().addClass('current-thumb');
    } else {
        $('.slide-main').each(function() {
            if (parseInt($(this).attr('rel')) == nextSlideIndex) {
                $('#hp-slide-cont .current').removeClass('current');
                $(this).addClass('current');
                leftPos = leftPos - 752;
                $('#hp-slide-cont').animate({'margin-left': leftPos}, 1500);
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











