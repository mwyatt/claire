var buttonToTop = require('buttonToTop');
var smoothScroll = require('smoothScroll');
var scrollDirection = require('scrollDirection');
var equalHeight = require('equalHeight');
var scrollDirection = require('scrollDirection');
var menuPrimary = require('menuPrimary');
require('owlcarousel/owl-carousel/owl.carousel.min');


$(document).ready(function() {  

	// tell me your there
	console.log('main.js -> document ready'); 

	// scroll direction
	scrollDirection.init({
		container: 'html'
	});

	// things
	menuPrimary.events();

	// to top button
	buttonToTop.init({
		button: '.to-top'
	});

	// smoothscroll
	smoothScroll.init({
		target: '.menu-primary-level-1-link',
		topOffset: 75,
		scrollSpeed: 500
	});

	$('.js-header-button-mobile-search').on('click', function(event) {
		event.preventDefault();
		$('.js-form-search-query').focus();
	});

	// equalheight
	equalHeight('.js-content');
	$(window).resize(function(){
		equalHeight('.js-content');
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
	scrollDirection.init({
		container: 'html'
	});

	$('.js-magnific-gallery').magnificPopup({
		type:'image'
	});
});