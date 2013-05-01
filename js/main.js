var a =  document.createElement('a');
a.href = window.location.href;
var url = {
    base: $('body').data('url-base'),
    source: window.location.href,
    protocol: a.protocol.replace(':',''),
    host: a.hostname,
    port: a.port,
    query: a.search,
    params: (function(){
        var ret = {},
            seg = a.search.replace(/^\?/,'').split('&'),
            len = seg.length, i = 0, s;
        for (;i<len;i++) {
            if (!seg[i]) { continue; }
            s = seg[i].split('=');
            ret[s[0]] = s[1];
        }
        return ret;
    })(),
    file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1],
    hash: a.hash.replace('#',''),
    path: a.pathname.replace(/^([^\/])/,'/$1'),
    relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1],
    segments: a.pathname.replace(/^\//,'').split('/')
};

var scroll = {
	docPosition: $(window).scrollTop(),
	breakPointOne: 0,
	nav: false,
	delay: 200,
	timer: 0,

	initialise: function() {
		scroll.nav = $('header').find('nav');
		$(window).scroll(function() {
			clearTimeout(scroll.timer);
			scroll.timer = setTimeout(scroll.poll, scroll.delay);
		});
	},

	poll: function() {
		scroll.setDocPosition();
		// scroll.breakPointOne = $('#jump-feature-tilts').offset().top;
		// if (scroll.docPosition > scroll.breakPointOne && resize.docWidth > 1020) {
		// 	$(scroll.nav).addClass('active');
		// } else {
		// 	$(scroll.nav).removeClass('active');
		// }
	},

	setDocPosition: function() {
		return scroll.docPosition = $(window).scrollTop();
	}
}

var resize = {
	docWidth: document.documentElement.clientWidth,
	delay: 200,
	timer: 0,

	initialise: function() {
		resize.setTimer();
		$(window).resize(resize.setTimer);
	},

	setTimer: function() {
		clearTimeout(resize.timer);
		resize.timer = setTimeout(resize.poll, resize.delay);
	},

	poll: function() {
		resize.setDocWidth();
		console.log(resize.docWidth);
		if (resize.docWidth > 0 && resize.docWidth < 481) {
			$(search.container).off().on('mouseup', search.openClose);
			$(navSub.container).off().on('mouseup', navSub.openClose);
		} else {
			$(search.container).off();
			$(navSub.container).off();
		}
	},

	setDocWidth: function() {
		return resize.docWidth = document.documentElement.clientWidth;
	}
}

var navMain = {
	container: false,
	drop: false,

	initialise: function(container) {
		if ($(container).length) {
			navMain.container = $(container);
			// navMain.drop = $('body').find('.drop' + '.' + $(navMain.container).attr("class"));
			$(navMain.container).find('li').find('a').on('mouseup', navMain.openClose);
		}
	},

	openClose: function() {
		$(this).parent().toggleClass('active');
		preventDefault(e);
		// $(navMain.drop).find('a').on('mouseup', clickprevent);
	}
}

function preventDefault(e) {
	e.preventDefault();
}

var search = {
	container: false,
	input: false,
	section: false,
	timer: 0,
	delay: 400,

	initialise: function(container) {
		if ($(container).length) {
			search.container = $(container);
			search.input = $(search.container).find('input[name="query"]');
			$(search.input).on('change', search.setTimer);
			$(search.input).on('keyup', search.setTimer);			
		}
	},

	setTimer: function() {
		clearTimeout(search.timer);
		search.timer = setTimeout(search.poll, search.delay);
	},

	poll: function() {
		if ($(search.input).val().length < 2) {
			$(search.section).html('');
			return false;
		}
		if (! search.section) {
			$(search.input).after('<section></section>');
			search.section = $(search.container).find('section');
		};
		$(search.section).html('');
		$.getJSON(url.base + '/ajax/search/?query=' + $(search.input).val() + '&limit=5', function(results) {
			if (results) {
				console.log(results);
				$(search.section).html('');
				$.each(results, function(index, result) {
					$(search.section).append('<a href="' + result.guid + '">' + result.name + '</a>');
				});
			}
		});
	},

	openClose: function() {
		$(search.container).find('.close').off().on('mouseup', search.openClose);
		$(search.container).toggleClass('active');
		$(search.container).find('form').on('mouseup', clickprevent);
		$(search.container).find('input').on('mouseup', clickprevent);
		$(search.input).val('');
		$(search.section).html('');
		$(search.input).focus();
	}
}

var navSub = {
	container: false,

	initialise: function(container) {
		if ($(container).length) {
			navSub.container = $(container);
		}
	},

	openClose: function() {
		$(navSub.container).toggleClass('active');
	}
}

var spinnerOptions = {
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

function closeActive () {
	$('.active').removeClass('active');
}

$(document).keyup(function(e) {
	// backspace
	if (e.keyCode == 8) {
		search.poll;
	}
	// escape
	if (e.keyCode == 27) {
		closeActive();
	} 
});

function clickprevent(e) {
	e.stopPropagation(); // prevent item from being selected also
}

function formSubmit() {
	$(this).closest('form').submit();
	return false;
}

$(document).ready(function() {
	less.watch();
	$('form').find('a.submit').on('mouseup', formSubmit);
	resize.initialise();
	scroll.initialise();
	search.initialise('header .search');
	navMain.initialise('nav.main');
	navSub.initialise('nav.sub');
	$.ajaxSetup ({  
		cache: false  
	});
	$.fn.spin = function(spinnerOptions) {
	  this.each(function() {
	    var $this = $(this),
	        data = $this.data();
	    if (data.spinner) {
	      data.spinner.stop();
	      delete data.spinner;
	    }
	    if (spinnerOptions !== false) {
	      data.spinner = new Spinner($.extend({color: $this.css('color')}, spinnerOptions)).spin(this);
	    }
	  });
	  return this;
	};
	// $('header').find('div.search').find('form').on('click', clickprevent);
	// $('header').find('nav.main').find('ul').on('click', clickprevent);
	// function resize() {
	// 	var documentWidth;
	// 	var scale_mobile_portrait = 320;
	// 	var scale_mobile_landscape = 480;
	// 	var scale_tablet_portrait = 600;
	// 	var scale_tablet_landscape = 1024;
	// 	var scale_desktop = 1382;

	// 	this.poll;
	// 	this._scale_tablet_portrait;
	// 	this.timer;

	// 	this.poll = function() {

	// 		documentWidth = document.documentElement.clientWidth;
	// 		$('header').find('nav.main').off();
	// 		$('header').find('div.search').off();
	// 		$('header').find('nav.main').find('div').off();

	// 		if (documentWidth < scale_mobile_landscape+1) {
	// 			$('header').find('nav.main').on('click', menu.activateIcon);
	// 			$('header').find('div.search').on('click', menu.activateIcon);
	// 			$('header').find('nav.main').find('div').on('click', menu.activateSub);
	// 		}

	// 		if (documentWidth > scale_tablet_portrait) {
	// 			$('header').find('.active').removeClass('active');
	// 		}

	// 	}
	// }
	// var menu = new menu();
	// var resize = new resize;
	// resize.poll();
	// $(window).resize(function() {
	// 	clearTimeout(resize.timer);
	// 	resize.timer = setTimeout(resize.poll, 200);
	// });





	// function accordion() {
	// 	var accordions = $('.accordion');
	// 	this.h2 = $(accordions).find('h2');
	// 	this._close_all;
	// 	this._open = function() {
	// 		var parent = $(this).parent();
	// 		var sections = $(accordions).find('div');
	// 		var section = $(parent).find('div').html('');
	// 		if ($(parent).hasClass('active')) {
	// 			$(parent).removeClass('active');
	// 			$(sections).html('');
	// 		} else {
	// 			$(sections).html('');
	// 			$(accordions).removeClass('active');
	// 			$(parent).addClass('active');
	// 			$(parent).spin(opts);

	// 			if ($(parent).hasClass('press')) {
	// 				$.getJSON(url.base + '/ajax/main-content?type=press&limit=3', function(results) {
	// 					if (results) {
	// 						$.each(results, function(index, result) {
	// 							var d = new Date(0);
	// 							d.setUTCSeconds(result.date_published);
	// 							$(section).append('<a href="'+url.base + 'post/'+result.title_slug+'/">'+result.title+'<span>'+d.getUTCDate()+'/'+d.getUTCMonth()+'/'+d.getUTCFullYear()+'</span></a>');
	// 						});
	// 					}
	// 					$(parent).spin(false);
	// 				});
	// 			}

	// 			if ($(parent).hasClass('player')) {
	// 				$.getJSON(url.base + '/ajax/player/?team_id='+$(parent).data('team-id'), function(results) {
	// 					$(parent).spin(opts);
	// 					if (results) {
	// 						$.each(results, function(index, result) {
	// 							$(section).append('<a href="'+result.guid+'">'+result.full_name+'</a>');
	// 						});
	// 					}
	// 					$(parent).spin(false);
	// 				});
	// 			}

	// 			if ($(parent).hasClass('progress')) {
	// 				$.getJSON(url.base + '/ajax/encounter-part/?method=row&player_id='+$(parent).data('player-id'), function(results) {
	// 					$(parent).spin(opts);
	// 					if (results) {
	// 						$.each(results, function(index, result) {
	// 							$(section).append('<div>'+result.player_rank_change+'</div>');
	// 						});
	// 					}
	// 					$(parent).spin(false);
	// 				});
	// 			}

	// 		}
	// 	}
	// }
	// var accordion = new accordion;
	// $(accordion.h2).on('click', accordion._open);
	// if ($('.content.player.single').length) {
	// 	$.getJSON(url.base + '/ajax/encounter-part/?method=group&player_id='+$('.accordion.progress').data('player-id'), function(result) {
	// 		if (result)
	// 			$('.accordion.progress').append('<span>'+result[0].player_rank_change+'</span>');
	// 			$('.accordion.progress > span').fadeIn(500);
	// 	});
	// }
});