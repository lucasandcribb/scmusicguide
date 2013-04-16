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


});
