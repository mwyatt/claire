$(document).ready(function() {  

	// tell me your there
	console.log('main.js -> document ready'); 

	// to top button
	var topButton = new Button_To_Top({
		button: '.to-top'
	});

	// smooth scrolling when clicked
	var smoothScroll = new Smooth_Scroll({
		target: '.js-smooth-scroll',
		topOffset: 75,
		scrollSpeed: 500
	});

	// fixed
	var modelFixedBar = new Model_Fixed_Bar();

	// setup submit buttons
	setSubmit();

	$('.js-header-button-mobile-search').on('click', function(event) {
		event.preventDefault();
		$('.js-form-search-query').focus();
	});

	// equalheight
	equalheight('.js-content');
	$(window).resize(function(){
		equalheight('.js-content');
	});

	// product single carousel
	$('.js-content-single-gallery').owlCarousel({
		slideSpeed: 200,
		paginationSpeed: 200,
		singleItem: true
	});
});
