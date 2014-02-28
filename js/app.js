jQuery(document).ready(function($) {

	// Menu click events
	$('.navbar-fixed-top .menu-btn').on('click', function(e) {
		e.preventDefault();
		$('.main-nav').toggleClass('visible');
		$('.main-nav').on('touchmove', function () { return false; });
	});

});