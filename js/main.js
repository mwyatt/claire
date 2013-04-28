var BASE_URL = $('body').data('url-base');

var search = {
	box: false,
	section: false,

	initialise: function(box) {
		search.box = $(box);
		search.section = $(search.box).parent().find('section');
		$(search.box).on('change', change);
		$(search.box).on('keyup', change);
	},

	change: function() {
		if (! $(search.box).val()) {
			return false;
		}
		if ($(search.box).val().length < 3) {
			return false;
		}
		$.getJSON(BASE_URL + '/ajax/search/?query=' + $(search.box).val() + '&limit=10', function(results) {
			if (results) {
				$(search.section).html('');
				$.each(results, function(index, result) {
					$(section).append('<a class="' + result.type.toLowerCase() + '" href="' + result.guid + '">' + result.name + '</a>');
				});
			}
		});
	}
}

function menu() {
	this.activateIcon;
	this.activateSub;
	this.activateIcon = function() {
		if ($(this).hasClass('active'))
			return $(this).removeClass('active');
		$('header').find('nav.main').removeClass('active');
		$('header').find('div.search').removeClass('active');
		$(this).addClass('active');
		if ($(this).hasClass('search'))
			$(this).find('input[type="text"]').focus();
	}
	this.activateSub = function() {
		if ($(this).hasClass('active'))
			return $(this).removeClass('active');
		$('header').find('nav.main').find('div').removeClass('active');
		$(this).parent().parent().parent().addClass('active');
		$(this).addClass('active');
	}
}

function clickprevent(e) {
	e.stopPropagation(); // prevent item from being selected also
}

$(document).ready(function() {
	less.watch();
	$.ajaxSetup ({  
		cache: false  
	});
	search.initialise('input[name="search"]');
	$('header').find('div.search').find('form').on('click', clickprevent);
	$('header').find('nav.main').find('ul').on('click', clickprevent);
	function resize() {
		var documentWidth;
		var scale_mobile_portrait = 320;
		var scale_mobile_landscape = 480;
		var scale_tablet_portrait = 600;
		var scale_tablet_landscape = 1024;
		var scale_desktop = 1382;

		this.poll;
		this._scale_tablet_portrait;
		this.timer;

		this.poll = function() {

			documentWidth = document.documentElement.clientWidth;
			$('header').find('nav.main').off();
			$('header').find('div.search').off();
			$('header').find('nav.main').find('div').off();

			if (documentWidth < scale_mobile_landscape+1) {
				$('header').find('nav.main').on('click', menu.activateIcon);
				$('header').find('div.search').on('click', menu.activateIcon);
				$('header').find('nav.main').find('div').on('click', menu.activateSub);
			}

			if (documentWidth > scale_tablet_portrait) {
				$('header').find('.active').removeClass('active');
			}

		}
	}
	var menu = new menu();
	var resize = new resize;
	resize.poll();

	$(window).resize(function() {
		clearTimeout(resize.timer);
		resize.timer = setTimeout(resize.poll, 200);
	});

	var opts = {
	  lines: 7, // The number of lines to draw
	  length: 2, // The length of each line
	  width: 2, // The line thickness
	  radius: 8, // The radius of the inner circle
	  corners: 0, // Corner roundness (0..1)
	  rotate: 0, // The rotation offset
	  color: '#fff', // #rgb or #rrggbb
	  speed: 1.5, // Rounds per second
	  trail: 50, // Afterglow percentage
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



	function accordion() {
		var accordions = $('.accordion');
		this.h2 = $(accordions).find('h2');
		this._close_all;
		this._open = function() {
			var parent = $(this).parent();
			var sections = $(accordions).find('div');
			var section = $(parent).find('div').html('');
			if ($(parent).hasClass('active')) {
				$(parent).removeClass('active');
				$(sections).html('');
			} else {
				$(sections).html('');
				$(accordions).removeClass('active');
				$(parent).addClass('active');
				$(parent).spin(opts);

				if ($(parent).hasClass('press')) {
					$.getJSON(BASE_URL + '/ajax/main-content?type=press&limit=3', function(results) {
						if (results) {
							$.each(results, function(index, result) {
								var d = new Date(0);
								d.setUTCSeconds(result.date_published);
								$(section).append('<a href="'+BASE_URL + 'post/'+result.title_slug+'/">'+result.title+'<span>'+d.getUTCDate()+'/'+d.getUTCMonth()+'/'+d.getUTCFullYear()+'</span></a>');
							});
						}
						$(parent).spin(false);
					});
				}

				if ($(parent).hasClass('player')) {
					$.getJSON(BASE_URL + '/ajax/player/?team_id='+$(parent).data('team-id'), function(results) {
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
					$.getJSON(BASE_URL + '/ajax/encounter-part/?method=row&player_id='+$(parent).data('player-id'), function(results) {
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
		$.getJSON(BASE_URL + '/ajax/encounter-part/?method=group&player_id='+$('.accordion.progress').data('player-id'), function(result) {
			if (result)
				$('.accordion.progress').append('<span>'+result[0].player_rank_change+'</span>');
				$('.accordion.progress > span').fadeIn(500);
		});
	}

});