$(document).ready(function() {  
	var html = $('html');

	// toggle menu primary
	$('.js-toggle-menu-primary').on('click', function(event) {
		event.preventDefault();
		html.toggleClass('menu-primary-is-active');
	});
	
	// remove menu when clicked away
	$(document).on('click', function(event) {
		if (! $(event.target).closest('.js-menu-primary').length && ! $(event.target).closest('.js-toggle-menu-primary').length) {
			html.removeClass('menu-primary-is-active');
		}
	});

	// escape key
	$(document).on('keyup', function(event) {
		if (event.keyCode == 27) {
			html.removeClass('menu-primary-is-active');
		} 
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
