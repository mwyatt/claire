var ajax = '<div class="ajax"></div>';

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
				division.container = '.content.division.overview';
				division.readResultSummary($('.content.division.overview').data('division-id'));
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
			search.input = $(search.container).find('input[name="query"]');
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

var division = {
	container: false,

	readResultSummary: function(id) {
		if ($(division.container).find('table.summary').length) {
			return false;
		};
		$.getJSON(url.base + '/ajax/division/?summary=' + id, function(data) {
			if (data) {
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
				$(division.container).find('h1').after(html);
			}
		});
	}
}

var fixtureResult = {

	readByTeam: function() {
	$.getJSON(url.base + '/ajax/tt-fixture-result/?method=readByTeam&action=' + $('.content.team.single').data('id'), function(results) {
			if (results) {
				console.log(results);
				$.each(results, function(index, result) {
					$('.content.team.single').find('.fixture').append(
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
	}
}

var player = {
	container: false,

	readByTeam: function() {
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
				console.log(results);
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

	readSingle: function() {
		$.getJSON(url.base + '/ajax/search/?query=' + $(search.input).val() + '&limit=5', function(results) {
			if (results) {
				// console.log(results);
				$(search.section).html('');
				$.each(results, function(index, result) {
					$(search.section).append('<a href="' + result.guid + '">' + result.name + '</a>');
				});
			}
		});
	},

	readFixture: function() {
		$.getJSON(url.base + '/ajax/tt-fixture-result/?method=readByPlayerId&player_id=' + $('.content.player.single').data('id'), function(results) {
			if (results) {
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

	readRankChange: function() {
		$.getJSON(url.base + '/ajax/tt-encounter-part/?method=readRankChange&player_id=' + $('.content.player.single').data('id'), function(result) {
			if (result) {
				$('.content.player.single').find('.performance').prepend('<span class="total">' + result['player_rank_change'] + '</span>');
				if (parseInt(result['player_rank_change'])) {
					$('.content.player.single').find('.performance').find('.total').addClass('positive');
				} else {
					$('.content.player.single').find('.performance').find('.total').addClass('negative');
				}
			}
		});
	},

	readPerformance: function() {
		var side = '';
		var otherSide = '';
		var victor = '';
		var playerId = $('.content.player.single').data('id');
		$.getJSON(url.base + '/ajax/tt-encounter-result/?player_id=' + playerId + '&limit=3', function(results) {
			if (results) {
				// console.log(results);
				$.each(results, function(index, result) {
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
					$('.content.player.single').find('.performance').append('<div>' + victor + ' vs <a href="' + result['player_' + otherSide + '_guid'] + '" title="View player ' + result['player_' + otherSide + '_full_name'] + '">' + result['player_' + otherSide + '_full_name'] + '</a> <span class="rank-change">' + result[side + '_rank_change'] + '</span></div>');
				});
			}
		});
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
	zIndex: 2e9, // The z-index (defaults to 2000000000)
	top: 'auto', // Top position relative to parent in px
	left: 'auto' // Left position relative to parent in px
};

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
	if ($('.content.player.single').length) {
		player.readRankChange();
		player.readPerformance();
		player.readFixture();
	};
	if ($('.content.team.single').length) {
		player.readByTeam();
		fixtureResult.readByTeam();
	};
});