$(document).ready(function() {  

	// tell me your there
	console.log('main.js -> document ready'); 

	// system objects
	var system = new System();
	var form = new Form();

	// things
	var menuPrimary = new Menu_Primary();

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
	$('.js-home-cover').owlCarousel({
		slideSpeed: 200,
		paginationSpeed: 200,
		singleItem: true
	});

	// gallery
	$('.js-gallery').owlCarousel({
		slideSpeed: 200,
		paginationSpeed: 200
	});

	// scroll direction
	var scrollDirection = new Scroll_Direction({
		container: 'html'
	});
});
