/* main.js */

$(document).ready(function() {

	var $BASEURL = $('body').data('url-base');

	less.watch();

	$.ajaxSetup ({  
		cache: false  
	});

	// $(document).resize(function(){ //Update dimensions on resize
	//   sw = document.documentElement.clientWidth;
	//   sh = document.documentElement.clientHeight;
	//   checkMobile();
	// });
	  
	// //Check if Mobile
	// function checkMobile() {
	// 	var breakpoint = 200;
	//   mobile = (sw > breakpoint) ? false : true;

	//   console.log(mobile);

	//   if (!mobile) { //If Not Mobile
	//     $('[role="tabpanel"],#nav,#search').show(); //Show full navigation and search
	//   } else { //Hide 
	//     if(!$('#nav-anchors a').hasClass('active')) {
	//       $('#nav,#search').hide(); //Hide full navigation and search
	//     }
	//   }
	// }

	var opts = {
	  lines: 9, // The number of lines to draw
	  length: 0, // The length of each line
	  width: 4, // The line thickness
	  radius: 8, // The radius of the inner circle
	  corners: 1, // Corner roundness (0..1)
	  rotate: 0, // The rotation offset
	  color: '#000', // #rgb or #rrggbb
	  speed: 1.5, // Rounds per second
	  trail: 70, // Afterglow percentage
	  shadow: false, // Whether to render a shadow
	  hwaccel: false, // Whether to use hardware acceleration
	  className: 'spinner', // The CSS class to assign to the spinner
	  zIndex: 2e9, // The z-index (defaults to 2000000000)
	  top: 'auto', // Top position relative to parent in px
	  left: 'auto' // Left position relative to parent in px
	};

	$.fn.spin = function(opts) {
	  this.each(function() {
	    var $this = $(this),
	        data = $this.data();

	    if (data.spinner) {
	      data.spinner.stop();
	      delete data.spinner;
	    }
	    if (opts !== false) {
	      data.spinner = new Spinner($.extend({color: $this.css('color')}, opts)).spin(this);
	    }
	  });
	  return this;
	};

	var search = $('input[name="search"]');
	console.log(search.val());

	search.on('change', change_search);
	search.on('keyup', change_search);

	/**
	 * returns matching results based on search query
	 * @todo turn this into a timed event so that it is not triggered after all keypresses
	 * @return {[type]} [description]
	 */
	function change_search() {

		if (! search.val())
			return false;

		if (search.val().length < 3)
			return false;
		
		$.getJSON($BASEURL+'/ajax/search/?default='+search.val(), function(results) {
			if (results) {
				var section = search.parent().find('section').html('');
				$.each(results, function(index, result) {
					$(section).append('<a class="'+result.type.toLowerCase()+'" href="'+result.guid+'">'+result.name+'<span>'+result.type+'</span></a>');
				});
			}
		});

	}

	function header_button() {
		var header = $('header.main');
		this.core = $(header).find('.button').find('span');
		var button_search = $(header).find('.button.search').find('> span');
		var button_results = $(header).find('.button.results').find('> span');
		var button_menu = $(header).find('.button.menu').find('> span');
		var buttons = $(header).find('.button');

		this._click = function() {
			var parent = $(this).parent();
			if ($(parent).hasClass('active')) {
				$(parent).removeClass('active');
				$(button_search).html('1');
				$(button_results).html('9');
				$(button_menu).html('2');
				return;
			}
			$(buttons).removeClass('active');
			$(button_search).html('1');
			$(button_results).html('9');
			$(button_menu).html('2');
			$(parent).addClass('active');
			$(this).html('7');
			
			if ($(parent).hasClass('search')) {
				$(parent).find('input[type="text"]').focus();
			}
		}

	}

	header_button = new header_button;
	header_button.core.on('click', header_button._click);

	function header_navigation() {
		this.items = $('header.main').find('nav > div').find('> a');
		this.open;

		this.open = function() {
			var sub_menus = $('header.main').find('nav > div');
			var sub_menu = $(this).parent();
			$(sub_menus).removeClass('active');
			$(sub_menu).addClass('active');
			return false;
		}
	}

	header_navigation = new header_navigation;
	$(header_navigation.items).on('click', header_navigation.open);


	function accordion() {
		var accordions = $('.accordion');
		this.h2 = $(accordions).find('h2');
		this._close_all;
		this._open = function() {
			var parent = $(this).parent();
			var sections = $(accordions).find('section');
			var section = $(parent).find('section').html('');
			if ($(parent).hasClass('active')) {
				$(parent).removeClass('active');
				$(sections).html('');
			} else {
				$(sections).html('');
				$(accordions).removeClass('active');
				$(parent).addClass('active');

				if ($(parent).hasClass('press')) {
					$.getJSON($BASEURL+'/ajax/post/?type=press&limit=3', function(results) {
						$(parent).spin(opts);
						if (results) {
							$.each(results, function(index, result) {
								var d = new Date(0);
								d.setUTCSeconds(result.date_published);
								$(section).append('<a href="'+result.title_slug+'">'+result.title+'<span>'+d.getUTCDate()+'/'+d.getUTCMonth()+'/'+d.getUTCFullYear()+'</span></a>');
							});
						}
						$(parent).spin(false);
					});
				}

				if ($(parent).hasClass('player')) {
					$.getJSON($BASEURL+'/ajax/player/?team_id='+$(parent).data('team-id'), function(results) {
						$(parent).spin(opts);
						if (results) {
							$.each(results, function(index, result) {
								$(section).append('<a href="'+result.guid+'">'+result.full_name+'</a>');
							});
						}
						$(parent).spin(false);
					});
				}

				if ($(parent).hasClass('progress')) {
					$.getJSON($BASEURL+'/ajax/encounter-part/?method=row&player_id='+$(parent).data('player-id'), function(results) {
						$(parent).spin(opts);
						if (results) {
							$.each(results, function(index, result) {
								$(section).append('<div>'+result.player_rank_change+'</div>');
							});
						}
						$(parent).spin(false);
					});
				}

			}
		}


	}

	var accordion = new accordion;
	$(accordion.h2).on('click', accordion._open);

	if ($('.content.player.single').length) {
		$.getJSON($BASEURL+'/ajax/encounter-part/?method=group&player_id='+$('.accordion.progress').data('player-id'), function(result) {
			if (result)
				$('.accordion.progress').append('<span>'+result[0].player_rank_change+'</span>');
				$('.accordion.progress > span').fadeIn(500);
		});
	}

});