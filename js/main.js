var ajax = '<div class="ajax"></div>';

/**
 * takes control of a list of items and makes them scrollable fun
 * functions this can perform:
 * scroll between banners using speed option
 */
(function($){
	$.fn.cover = function(options) {
		if (! this.length) return;
		var core = this;
		var defaults = {
			speed: 6000
			, fadeSpeed: 200
		}
		var options = $.extend(defaults, options);
		var interval = {
			timer: 0
			, start: function() {
				clearTimeout(interval.timer);
				interval.timer = setInterval(next, options.speed);
			}
			, stop: function() {
				clearTimeout(interval.timer);
				interval.timer = setInterval(next, options.speed);
			}
		}
		var info = {
			total: $(core).find('a').length
			, current: 0
			, next: 0
		}
		if (info.total > 1) {
			start();
		};
		function start() {
			$.each($(core).find('a'), function(index) {
				if (index > 0) {
					$(this).addClass('hide');
				} else {
					$(this).removeClass('bring-out');
					$(this).addClass('bring-in');
				}
			});
			interval.start();
		}
		function next() {
			info.current += 1;
			if (info.current == info.total) {
				info.current = 0;
			};
			$.each($(core).find('a'), function(index) {
				if (info.current == index) {
					$(this).removeClass('bring-out').removeClass('hide').addClass('bring-in');
				} else {
					$(this).removeClass('bring-in').addClass('bring-out');
				}
			});
		}
	};
})(jQuery);

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
		if (resize.docWidth > 975) {
			if ($('.content.division.overview').length) {
				load.divisionReadResultSummary($('.content.division.overview').data('division-id'));
			};
		} else {
			// $(search.container).off();
			// $(navSub.container).off();
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
			$(navMain.container).find('li > a').on('click', function(e) {
				if ($(this).parent().find('.drop').length) {
					navMain.openClose(this, e);
				};
			});
		}
	},

	openClose: function(button, e) {
		$(navMain.container).find('.active').removeClass('active');
		$(button).parent().addClass('active');
		e.preventDefault();
	}
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
			search.input = $(search.container).find('input[name="search"]');
			// $(search.input).on('change', search.setTimer);
			$(search.input).on('keyup', search.setTimer);			
		}
	},

	setTimer: function() {
		clearTimeout(search.timer);
		search.timer = setTimeout(search.poll, search.delay);
	},

	poll: function() {
		if ($(search.input).val().length < 2) {
			$(search.container).find('section').html('');
			return false;
		}
		if (! $(search.container).find('section').length) {
			$(search.input).after('<section></section>');
		};
		$(search.container).find('section').html(ajax);
		$.getJSON(url.base + '/ajax/search/?search=' + $(search.input).val() + '&limit=5', function(results) {
			if (results) {
				$(search.container).find('section').html('');
				$.each(results, function(index, result) {
					$(search.container).find('section').append('<a href="' + result.guid + '">' + result.name + '</a>');
				});
			} else {
				$(search.container).find('section').remove();
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

var load = {

	fixtureReadByTeam: function() {
		if ($('.content.team.single').find('.fixture').length) {
			return false;
		}
		$('.content.team.single').find('.players').after(
			'<div class="row fixture clearfix ajax">'
			+ '</div>'
		);
		$.getJSON(
			url.base + '/ajax/tt-fixture/',
			{read_by_team: $('.content.team.single').data('id')},
			function(results) {
				$('.ajax').removeClass('ajax');
				if (results) {
					$('.content.team.single').find('.fixture').append('<h2>Fixtures</h2>');
					var output = '';
					$.each(results, function(index, result) {
						output += (result.date_fulfilled ? '<a href="' + result.guid + '" class="card clearfix">' : '<div class="card clearfix">');
						output += '<div class="team-left">' + result.team_left_name + '</div>'
						output += (result.date_fulfilled ? '<div class="score-left">' + result.team_left_score + '</div>' : '');
						output += '<div class="team-right">' + result.team_right_name + '</div>'
						output += (result.date_fulfilled ? '<div class="score-right">' + result.team_right_score + '</div>' : '');
						output += (result.date_fulfilled ? '</a>' : '</div>')
					});
					$('.content.team.single').find('.fixture').append(output);
				} else {
					$('.content.team.single').find('.fixture').remove();
				}
			}
		);
	},
	playerReadByTeam: function() {
		if ($('.content.team.single').find('.players').length) {
			return false;
		} else {
			$('.content.team.single').find('.general-stats').after(
				'<div class="players clearfix">'
					+ '<h2>Registered players</h2>'
					+ '<div class="ajax"></div>'
				+ '</div>'
			);
		}
		$.getJSON(url.base + '/ajax/player/?team_id=' + $('.content.team.single').data('id'), function(results) {
			if (results) {
				$('.ajax').remove();
				html = '<ul>';
				$.each(results, function(index, result) {
					html += '<li><a href="' + result.guid + '" title="View player ' + result.name + '">' + result.name + '</a></li>';
				});
				html += '</ul>';
				$('.content.team.single').find('.players').find('h2').after(html);
			}
		});
	},
	playerReadSingle: function() {
		$.getJSON(url.base + '/ajax/search/?search=' + $(search.input).val() + '&limit=5', function(results) {
			if (results) {
				$(search.section).html('');
				$.each(results, function(index, result) {
					$(search.section).append('<a href="' + result.guid + '">' + result.name + '</a>');
				});
			}
		});
	},
	playerReadFixture: function() {
		$.getJSON(url.base + 'ajax/tt-fixture-result/?method=readByPlayerId&action=' + $('.content.player.single').data('id'), function(results) {
			if (results) {
				$('.content.player.single').find('.performance').after(
					'<div class="fixture clearfix">'
						+ '<h2>Fixtures</h2>'
					+ '</div>'
				);
				$.each(results, function(index, result) {
					$('.content.player.single').find('.fixture').append(
						'<a href="' + result.guid + '" class="card clearfix">'
							+ '<div class="team-left">' + result.team_left_name + '</div>'
							+ '<div class="score-left">' + result.team_left_score + '</div>'
							+ '<div class="team-right">' + result.team_right_name + '</div>'
							+ '<div class="score-right">' + result.team_right_score + '</div>'
						+ '</a>'
					);
				});
			}
		});
	},
	playerReadRankChange: function() {
		$.getJSON(url.base + '/ajax/tt-encounter-part/?method=readRankChange&player_id=' + $('.content.player.single').data('id'), function(result) {
			if (result) {
				$('.content.player.single').find('.performance').prepend('<span class="tag total ' + (result['player_rank_change'] > 0 ? 'positive' : 'negative') + '">' + (result['player_rank_change'] > 0 ? '+' : '') + result['player_rank_change'] + '</span>');
			}
		});
	},
	playerReadPerformance: function() {
		var side = '';
		var otherSide = '';
		var victor = '';
		var playerId = $('.content.player.single').data('id');
		$.getJSON(url.base + '/ajax/tt-encounter-result/', {player_id: playerId, limit: 3}, function(results) {
			if (results) {
				if ($('.content.player.single').find('.performance').length) {
					return;
				};
				$.each(results, function(index, result) {
					$('.content.player.single').find('.general-stats').after(
						'<div class="performance clearfix">'
							+ '<h2>Performance</h2>'
						+ '</div>'
					);
					if (result['player_left_id'] == playerId) {
						side = 'left';
						otherSide = 'right';
					} else {
						side = 'right';
						otherSide = 'left';
					}
					if (result[side + '_score'] == 3) {
						victor = 'Won';
					} else {
						victor = 'lost';
					}
					$('.content.player.single').find('.performance').append('<p>' + victor + ' vs <a href="' + result['player_' + otherSide + '_guid'] + '" title="View player ' + result['player_' + otherSide + '_full_name'] + '">' + result['player_' + otherSide + '_full_name'] + '</a> <span class="rank-change tag ' + (result[side + '_rank_change'] > 0 ? 'positive' : 'negative') + '">' + (result[side + '_rank_change'] > 0 ? '+' : '') + result[side + '_rank_change'] + '</span></p>');
				});
			}
		});
	},
	divisionReadResultSummary: function(id) {
		// if ($('.content.division.overview').find('table.summary').length) {
		// 	return false;
		// };
		$.getJSON(url.base + '/ajax/division/?summary=' + id, function(data) {
			if (data) {
				if (! data.result.length) {
					return false;
				};
				var resultFound;
				var htmlHeading = '';
				var htmlRows = '';
				var html = '<table class="main summary" width="100%" cellspacing="0" cellpadding="0"><tr><th></th>';
				$.each(data['team'], function(index, team) {
					html += '<th><a href="' + team.guid + '" title="' + team.name + '">' + team.name + '</a></th>';
				});
				html += '</tr>';
				$.each(data['team'], function(index, teamRow) {
					html += '<tr><th><a href="' + teamRow.guid + '" title="' + teamRow.name + '">' + teamRow.name + '</a></th>';
					$.each(data['team'], function(index2, team) {
						if (teamRow.id == team.id) {
							html += '<td class="cant-play"></td>';
						} else {
							resultFound = false;
							$.each(data['result'], function(index3, result) {
								if (result.team_left_id == teamRow.id && result.team_right_id == team.id) {
									html += '<td class="played"><a href="' + result.guid + '" title="' + result.team_left_name + ' vs ' + result.team_right_name + '">' + result.left_score + ' - ' + result.right_score + '</a></td>';
									resultFound = true;
								};
							});
							if (! resultFound) {
								html += '<td class="not-played"></td>';
							}
						}
					});
					html += '</tr>';
				});
				html += '</table>';
				if (! $('.content.division.overview table.main.summary').length) {
					$('.content.division.overview').find('h1').after(html);
				};
			}
		});
	}
}

function closeActive () {
	$('.active').removeClass('active');
}

// $(document).mouseup(function(e) {
// 	closeActive();
// });

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
	if ($(this).hasClass('disabled')) {
		return false;
	}
	$(this).addClass('disabled');
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
	if ($('.content.home').length) {
		$('.cover').cover();
	};
	if ($('.content.gallery').length) {
		$('.file').magnificPopup({type:'image'});
	}
	if ($('.content.player.single').length) {
		load.playerReadPerformance();
		load.playerReadRankChange();
		load.playerReadFixture();
	};
	if ($('.content.team.single').length) {
		// load.playerReadByTeam();
		load.fixtureReadByTeam();
	};
});