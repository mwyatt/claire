/**
 * Simply Spectral
 * Main Script
 */
 
 
// Contents
// =============================================================================

//	# Import
//	# Reset
//	# Core


// Document Ready
// =============================================================================

$(document).ready(function() {


	// Init
	// ===========================================================================
		
	// change form required input
	$('input.required, textarea.required').change(function() {
	
		$(this).css('background', 'transparent');
		
	});
		
	// hovering over modal		
	
	var timeout;
	
	function doTimeout() {
		clearTimeout(timeout);
		timeout = setTimeout(removeModals, 500);
	}	
	
	function removeModals() {
		$('.modal.model').remove();
		$('.modal.accessory').remove();		
	}	
		
	if ($('#map').length) {
	
		// Gmaps.js
		map = new GMaps({
			el: '#map',
			lat: 53.69248,
			lng: -2.193667
		});

		map.addMarker({
			lat: 53.69248,
			lng: -2.193667,
			title: 'Simply Spectral',
			infoWindow: {
				content: '<p><b>Simply Spectral</b><br>Unit 5, The Sidings,<br>New Line Industrial Estate,<br>Bacup, Lancs,<br>OL13 9RW</p>'
			}
		});
		
	}
	
	// Hover Intent
	$("nav .drop").hoverIntent({
				over: dropShow, 
				timeout: 500, 
				out: dropHide
	});
	
	function dropShow() {
		$(this).find('.content').fadeIn('fast');
	}
	
	function dropHide() {
		$(this).find('.content').fadeOut('fast');
	}
	
	
	// Utility
	// ===========================================================================
	
	// Click the Document
	$(document).mouseup(function() {
		$('.enquiry .btn').removeClass('active');
		$('.modal').removeClass('active');
		$('.modal.model').remove();
		$('.modal.accessory').remove();		
	});	
	
	// Hit Escape
	$(document).keyup(function(e) {

		if (e.keyCode == 27) {
			
			$('.modal.model').remove();
			$('.modal.accessory').remove();			
			$('.modal').removeClass('active');			
			$('.enquiry .btn').removeClass('active');
			
		}   // esc
		
	});	

	// Click Close
	
	$('.close').mouseup(function() {
		$('.enquiry .btn').removeClass('active');
		$('.modal').removeClass('active');
	});	

	// Click Modals

	$('.modal').mouseup(function() {
		return false;
	});	
	
	// Text Inputs Placeholders

	$('input[type="text"]').focus(function() {
		if (dataDefault = $(this).attr('data-default')) {
			if (dataDefault == this.value)
				this.value = '';
		}
	});	
	
	$('input[type="text"]').focusout(function() {
		if ((this.value == '') && (dataDefault = $(this).attr('data-default')))
			this.value = dataDefault;
	});	
	
	
	// Home
	// ===========================================================================
	
	/*// Range Link Titles
	
	$('.range .item').hover(function() {
		$(this).find('.title').find('a').css('color', '#e87208');
	}, function() {
		$(this).find('.title').find('a').css('color', '#333');	
	});*/
	
	// Enquiry
		
	$('.enquiry .btn').click(function() {

		$(this).toggleClass('active');
		$('.enquiry').find('.modal').toggleClass('active');
			
	});


	// Range
	// ===========================================================================

	// Scroll Fixed
	
	if ($('.scrollFixed').length) {
	
		$(function() {

				var $sidebar   = $('.scrollFixed'), 
						$window    = $(window),
						offset     = $sidebar.offset(),
						topPadding = 15;

				$window.scroll(function() {
						if ($window.scrollTop() > offset.top) {
								$sidebar.stop().animate({
										marginTop: $window.scrollTop() - offset.top + topPadding
								});
						} else {
								$sidebar.stop().animate({
										marginTop: 0
								});
						}
				});
				
		});
	
	}
	
	// Accordion
	
	$('ul.accordion').accordion();
	$('a[href=#120]').trigger('activate-node');	
	
	
		// Customise and Buy Process
		// =========================================================================

		HtmlBreakDownTable =
			'<table width="100%" cellspacing="0" cellpadding="0">' +
				'<tbody>' +
				'</tbody>' +
			'</table>';
		
		HtmlBreakDownRowModel = '<tr class="model" data-model="" data-description="" data-price="" data-specification="" data-width="" data-height=""><td class="title"></td><td class="price"></td></tr>';
		
		function HtmlBreakDownRow(className) {
		
			var html = 
				'<tr class="' + className + '">' +
					'<td class="title"></td>' +
					'<td class="price"></td>' +
				'</tr>';		
		
			return html;
				
		}
		
		HtmlBreakDownRowTotal = '<tr class="total"><td class="title">Total</td><td class="price total" itemprop="price">0</td></tr>';		
					
					
		// Scroll or Click Customise and Buy
		// Please remember this is polling every second.
		// =========================================================================
	
		/*setTimeout(function() {

				var 	target = $('#customise-and-buy').offset().top,
							btn = $('a[href="#customise-and-buy"]');

				var interval = setInterval(function() {
				
						if ($(window).scrollTop() >= target) {
						
							if (btn.html() == 'Customise and Buy')
								btn.html('Add to Basket');
								
						} else {
						
							if (btn.html() == 'Add to Basket')
								btn.html('Customise and Buy');
						
						}
						
				}, 1000);

		}, 1500);	*/
	
	
		// Set Total
		// =========================================================================	
	
		function updateTotal() {
		
			var breakDown = $('.breakDown').find('table').find('tbody');
			var $total = 0;
					
			breakDown.find('.price').each(function() {
				
				if (!$(this).hasClass('total')) {
				
					// if price exists
					if ($(this).html()) {
					
						$price = $(this).html();
						
						$price = $price.replace(/\u00A3/g, '');
										
						$total = parseFloat($total) + parseFloat($price);
					
					}
				
				}
				
			});
			
			breakDown
				.find('.price.total').html('&#163;' + $total);
			
		};
				
		// 1. Choose your Model
		// =========================================================================	
		
		$('.panel.model .item').click(function() {
		
			// pull information on model
			var panel = $('.panel.model');
			var nextPanel = $('.panel.colour');
			var position = $(this).offset();
			var dataTitle = $(this).find('.title').html();
			var dataPrice = $(this).attr('data-price');
			var dataModel = $(this).attr('data-model');
			var dataDescription = $(this).attr('data-description');
			var dataWidth = $(this).attr('data-width');
			var dataHeight = $(this).attr('data-height');
						
			// init breakdown table
			var breakDown = $('.breakDown')
				.append(HtmlBreakDownTable).find('table').find('tbody');
			
			// row total
			breakDown
				.prepend(HtmlBreakDownRowTotal);
			
			// row model
			breakDownRowModel = breakDown.prepend(HtmlBreakDownRowModel).find('.model');
			breakDownRowModel
				.find('.title').html('Model ' + dataTitle);
			breakDownRowModel
				.find('.price').html(dataPrice);
				
			// set attributes
			breakDownRowModel.attr('data-model', dataModel);
			breakDownRowModel.attr('data-description', dataDescription);
			breakDownRowModel.attr('data-width', dataWidth);
			breakDownRowModel.attr('data-height', dataHeight);
			
			// panel
			panel
				.find('.main-title').find('h3')
					.html('Model ' + dataTitle + ' Selected')
			panel
					.addClass('selected');

			// set radio button
			$(this).find('input[type="radio"]').attr('checked', true);
					
			// update the total
			updateTotal();
			
			// open next panel
			nextPanel.removeClass('unselected');
				
			// open first accordion tab
			$('a[href=#base]').trigger('activate-node');	
			
		});
		
			// Modal
			
			$('.panel.model .item').hover(function() {
								
				// clear all modals
				removeModals();
								
				// pull information on model
				var position = $(this).offset();
				var dataTitle = $(this).find('.title').html();
				var dataDescription = $(this).attr('data-description');
				var dataPrice = $(this).attr('data-price');
				var dataSpecification = $(this).attr('data-specification');
				
				// append modal
				$('body').append(
					'<div class="model modal">' +
						'<h3 class="title">' + dataTitle + '</h3>' +
						'<div class="price">' + dataPrice + '</div>' +
						'<p class="description">' + dataDescription + '</p>' +
						'<img src="' + dataSpecification + '" width="380" height="80">' +
					'</div>'
				);
				
					// position modal
					modal = $('.modal.model')
						.css('top', position.top - 170)
						.css('left', position.left + 30);
						
					clearTimeout(timeout);	
					
					$('.modal.model').on('hover', clearTimeout(timeout));	
										
			}, function() {
			
				doTimeout();
			
			});
			

			
			
				/*// Modal Hover

				function hoverModal() {
						
					console.log('hovering in modal');
					return false;
				
				}, 
				function () {
				
					console.log('hovering out modal');
					modal.remove();
					
				}*/
					
			
			
		// 2. Choose your Colour
		// =========================================================================
		
		$('.panel.colour .item').click(function() {
		
			var panel = $('.panel.colour');
			var nextPanel = $('.panel.accessory');
			var breakDown = $('.breakDown').find('table').find('tbody');
			var title = $(this).attr('data-title');
			var price = $(this).attr('data-price');
			
			console.log(HtmlBreakDownRow('colour'));
			
			// row colour
			var rowColour = breakDown.prepend(HtmlBreakDownRow('colour')).find('.colour');
			rowColour
				.find('.title').html('Colour ' + title);
			rowColour
				.find('.price').html(price);
				
			// panel
			panel
				.find('.main-title').find('h3').html('Colour ' + title + ' Selected');
			panel
				.addClass('selected');

			// update the total
			updateTotal();
			
			// change btn to add to basket
			var btn = $('a[href="#customise-and-buy"]');
			btn.html('Add to Basket');
			btn.addClass('active');
			btn.attr('onclick', 'document.formRange.submit()');

			// Setup Range Specific Accessories
			var range = $('#content').find('.page-title').html().toLowerCase();
			var model = $('.breakDown').find('table').find('tbody').find('.model');
			
			// core switch for deciding 
			switch(range)
			{
			case 'brick':
	
				breakDownRowModel = breakDown.find('.model');
					
				// get attributes
				var dataModel = breakDownRowModel.attr('data-model');
				var dataDescription = breakDownRowModel.attr('data-description');
				var dataWidth = breakDownRowModel.attr('data-width');
				var dataHeight = breakDownRowModel.attr('data-height');
				
				console.log(dataModel);
				console.log(dataDescription);
				console.log(dataWidth);
				console.log(dataHeight);
				
				
				
				
				
				break;
			case 'scala':
				// code here
				break;
			default:
				// default code
			}
			
			// open panel accessories
			nextPanel
				.removeClass('unselected');
			
		});
		
			// Hover
			
			$('.panel.colour .item').hover(function() {
				
				var	colour = $(this).css('background-color');
				var scrollFixedThumb = $('.scrollFixed').find('.thumb'); 
				
				// set new colour
				scrollFixedThumb.css('background-color', colour);
				
			});
			
			
		// 3. Choose your Accessories
		// =========================================================================	

		$('.panel.accessory .item').click(function() {
		
			// get info on $(this)
			var panel = $('.panel.model');
			var dataTitle = $(this).find('.title').html();
			var dataPrice = $(this).attr('data-price');
			
			// update breakdown table
			var breakDown = $('.breakDown').find('table').find('tbody').prepend(HtmlBreakDownRow('accessory'));
			
			// row model
			breakDownRowModel = breakDown.find('.accessory');
			breakDownRowModel
				.find('.title').html('Model ' + dataTitle);
			breakDownRowModel
				.find('.price').html(dataPrice);

			// update the total
			updateTotal();
		
			// remove accessory
			$(this).remove();
			
		});			
			
			// Accessories Modal
			
			$('.panel.accessory .item').hover(function() {
				
				// clear all modals
				removeModals();				
				
				// pull information on accessory
				var position = $(this).offset();
				var dataTitle = $(this).find('.title').html();
				var dataDescription = $(this).attr('data-description');
				var dataPrice = $(this).attr('data-price');
				var dataSpecification = $(this).attr('data-specification');
				
				// append modal
				$('body').append(
					'<div class="modal accessory">' +
						'<h3 class="title">' + dataTitle + '</h3>' +
						'<p class="description">' + dataDescription + '</p>' +
						'<div class="price">' + dataPrice + '</div>' +
					'</div>'
				);
				
					// position modal
					modal = $('.modal.accessory')
						.css('top', position.top - 170)
						.css('left', position.left + 30);
										
					clearTimeout(timeout);	
							
					$('.modal.accessory').on('hover', clearTimeout(timeout));	
							
			}, function() {
			
				doTimeout();
			
			});

	
}); // Document Ready Function


// example js object

/*
	function Cat ($breed) {
	
		this.$breed = $breed;
		this.$type = 'big';
		this.$color = 'ginger';
		
		this.getSummary = getSummary;
	
	}

	function getSummary() {
	
		return 'My Cat is ' + this.$color + ' ' + this.$breed;
	
	}
	
	var $cat = new Cat('super rare');
	
	$cat.$color = 'pink';
	
	console.log($cat.getSummary());
	
	
	// extend jquery exists function
	$.fn.exists = function () {
			return this.length !== 0;
	}	
	*/