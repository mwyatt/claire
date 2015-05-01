(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
// require('vendor/jquery/owlCarousel');


$(document).ready(function() {  

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

	$('.js-header-button-mobile-search').on('click.namespace', function(event) {
		event.preventDefault();
		console.log('value');
		$('.js-form-search-query').focus();
	});

	// equalheight
	// equalheight('.js-content');
	// $(window).resize(function(){
	// 	equalheight('.js-content');
	// });

	// product single carousel
	// $('.js-content-single-gallery').owlCarousel({
	// 	slideSpeed: 200,
	// 	paginationSpeed: 200,
	// 	singleItem: true
	// });
});



/**
 * watches the scrollwindow and displays a to top button when moving down
 * over a threshold
 * dependancy $
 */
var Button_To_Top = function (options) {
	var defaults = {
		threshold: 100,
		button: '.null',
		classLabel: 'is-active',
		delay: 200
	};
	this.options = $.extend(defaults, options);
	this.timer;
	this.events(this);
};


Button_To_Top.prototype.events = function(data) {
	var button = $(data.options.button);
	$(window).on('scroll.button-to-top', function(event) {
		clearTimeout(data.timer);
		data.timer = setTimeout(function(event) {
			documentPosition = $(document).scrollTop();
			if (documentPosition > data.options.threshold) {
				button.addClass(data.options.classLabel);
			} else {
				button.removeClass(data.options.classLabel);
			}
		}, data.options.delay);
	});
};


var Smooth_Scroll = function (options) {
	var defaults = {
		target: '.js-smooth-scroll',

		// offsets the scroll down if there is a
		// fixed header for example
		topOffset: 50,
		scrollSpeed: 500,
		activeClass: 'has-smooth-scroll',
		direct: ''
	};
	this.options = $.extend(defaults, options);
	this.cache = {
		target: $(this.options.target)
	};
	var firstEvent = {};
	firstEvent.data = this;

	// clicking a targeted item
	firstEvent.data.cache.target.off('click.smoothScroll').on('click.smoothScroll', firstEvent.data, function(event) {
		event.preventDefault();
		firstEvent.data.scrollTo(firstEvent, this.hash);
	});

	// immediatly scroll to
	if (firstEvent.data.options.direct) {
		firstEvent.data.scrollTo(firstEvent, firstEvent.data.options.direct);
	};
};


/**
 * takes a clicked button and smooth scrolls to its hash
 * target is the jquery selector string
 * @param  {object} event
 * @param  {string} target
 */
Smooth_Scroll.prototype.scrollTo = function(event, target) {
	var timer = 0;
	var destination = 0;
	if ($(target).offset().top > $(document).height() - $(window).height()) {
		destination = $(document).height() - $(window).height();
	} else {
		destination = $(target).offset().top;
		destination = destination - event.data.options.topOffset;
	}
	$('html, body').animate({scrollTop:destination}, event.data.options.scrollSpeed, 'swing');

	// add class to target, remove it after timeout
	$('.' + event.data.options.activeClass).removeClass(event.data.options.activeClass);
	clearTimeout(timer);
	target = $(target);
	target.addClass(event.data.options.activeClass);
	timer = setTimeout(function() {
		target.removeClass(event.data.options.activeClass);
	}, 1000);
};



var Model_Fixed_Bar = function (options) {
	var defaults = {
		target: '.js-fixed-bar'
	}
	this.options = $.extend(defaults, options);
	this.cache = {
		// fieldSlug: '.js-input-slug',
		// fieldTitle: '.js-input-title'
	};
	this.timer;
	this.events(this);
};


Model_Fixed_Bar.prototype.events = function(data) {
	$(window).on('scroll.fixed-bar', function(event) {
		clearTimeout(data.timer);
		if (! $(window).scrollTop()) {
			return $(data.options.target).removeClass('is-scrolling');
		};
	    data.timer = setTimeout(function() {
	    	$(data.options.target).addClass('is-scrolling');
	    }, 0);
	});
};


/* Thanks to CSS Tricks for pointing out this bit of jQuery
http://css-tricks.com/equal-height-blocks-in-rows/
It's been modified into a function called at page load and then each time the page is resized. One large modification was to remove the set height before each new calculation. */

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

},{}]},{},[1]);
