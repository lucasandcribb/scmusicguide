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

});