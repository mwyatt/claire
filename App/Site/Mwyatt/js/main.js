$(document).ready(function() {  

	// toggle menu primary
	$('.js-toggle-menu-primary').on('click', function(event) {
		event.preventDefault();
		$('html').toggleClass('menu-primary-is-active');
	});

	// to top button
	var topButton = new Button_To_Top({
		button: '.to-top'
	});

	// smoothscroll
	var smoothScroll = new Smooth_Scroll();

	// scroll direction
	var scrollDirection = new Scroll_Direction({
		container: 'html'
	});
});
