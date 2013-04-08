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


});