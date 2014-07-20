$(document).ready(function() {  

	// tell me your there
	console.log('main.js -> document ready'); 

	// to top button
	var topButton = new Button_To_Top({
		button: '.to-top'
	});

	// $('.js-header-button-mobile-menu').on('click', function(event) {
	// 	event.preventDefault();
	// 	$(this).closest('.js-container-header').toggleClass('is-menu-open');
	// });

	// smooth scrolling when clicked
	var smoothScroll = new Smooth_Scroll({
		target: '.js-smooth-scroll',
		topOffset: 75,
		scrollSpeed: 500
	});
	var modelFixedBar = new Model_Fixed_Bar();
	setSubmit();

	$('.js-header-button-mobile-search').on('click', function(event) {
		event.preventDefault();
		$('.js-form-search-query').focus();
	});

	// masonry
	$('.js-contents').masonry({
	  columnWidth: '.js-content',
	  itemSelector: '.js-content'
	});
});
