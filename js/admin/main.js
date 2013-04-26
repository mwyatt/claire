var BASE_URL = $('body').data('url-base');

var feedback = {
	container: false,
	speed: 'fast',

	init: function() {
		feedback.container = $('.feedback');
		$(feedback.container).on('click', feedback._click);
	},

	_click: function() {
		$(this).fadeOut(feedback.speed);
		// setTimeout(showFeedback, 1000);
		// function showFeedback() {
		// 	feedback.fadeIn(animationSpeed);
		// 	setTimeout(hideFeedback, 10000);
		// }
		// function hideFeedback() {
		// 	// feedback.fadeOut(animationSpeed);
		// }
	}
}

var select = {
	container: false,
	division: false,
	team: false,
	player: false,
	side: false,

	init: function() {
		select.container = $('.content');
		select.division = $(select.container).find('select[name="division_id"]');
		select.team = $(select.container).find('select[name^="team"]');
		select.player = $(select.container).find('select[name^="player"]');
		$(select.division).on('change', select.loadTeam);
		$(select.container).find('.play-up').on('click', select.clickPlayUp);
		$(select.container).find('.score').find('input').on('click', select.clickInputScore);
		$(select.container).find('.score').find('input').on('keyup', select.changeScore);
	},

	loadTeam: function() {
		select._reset('player');
		$(select.team).html('');
		$.getJSON(BASE_URL + '/ajax/team/?division_id=' + $(select.division).val(), function(results) {
			if (results) {
				$(select.team).append('<option value="0"></option>');
				$.each(results, function(index, result) {
					$(select.team).append('<option value="' + result.id + '">' + result.name + '</option>');
				});
				$(select.team).on('change', select.loadPlayer);
			}
		});		
	},

	clickPlayUp: function() {
		var button = $(this);
		var select = $(this).closest('select');
		$.getJSON(BASE_URL + '/ajax/player/', function(results) {
			if (results) {
				$(select).html('');
				$.each(results, function(index, result) {
					$(select).append('<option value="' + result.id + '">' + result.name + '</option>');
				});
				$(select).on('change', select.changePlayer);
			}
		});
	},

	updatePlayer: function(index, name) {
		$('.' + select.side).find('.score-' + index).find('label.name').html(name);
	},

	clickInputScore: function() {
		$(this).select();
	},

	arrangePlayer: function() {
		for (var index = 0; index < 3; index ++) { 
			playerIndex = index + 1;
			playerOptions = $('select[name="player[' + select.side + '][' + playerIndex + ']"]').find('option');
			playerOptions.each(function(optionIndex) {
				if ((optionIndex) == (index)) {
					$(this).prop('selected', 'selected');
					select.updatePlayer(playerIndex, $(this).html());
				}
			});
		}
	},

	_reset: function(key) {
		if (key == 'player') {
			$(select.container).find('select[name^="player"]').html('');
		}
		if (key == 'score') {
			$(select.container).find('select[name^="player"]').html('');
		}
	},

	updateFixtureScore: function() {
		var
			score
			, leftTotal = 0
			, rightTotal = 0;

		$(select.container).find('.left').find('.score').find('input').each(function() {

	 		score = parseInt($(this).val());
	 		if (isNaN(score))
	 			score = 0;

			leftTotal = leftTotal + score;

		});

		$(select.container).find('.right').find('.score').find('input').each(function() {

	 		score = parseInt($(this).val());
	 		if (isNaN(score))
	 			score = 0;

			rightTotal = rightTotal + score;

		});

		// set left and right total display and hidden inputs

		$(select.container).find('.left').find('.total').find('p').html(leftTotal);
			$(select.container).find('.left').find('.total').find('input').val(leftTotal);
		$(select.container).find('.right').find('.total').find('p').html(rightTotal);
			$(select.container).find('.right').find('.total').find('input').val(rightTotal);
	},

	changeScore: function(e) {
				// exclude tab, shift, backspace key

				if ((e.keyCode == 9) || (e.keyCode == 16)|| (e.keyCode == 8))
					return false;

				// continue...

				var
					currentValue
					, parts
					, index
					, oppositeScore
					;

		 		currentValue = parseInt($(this).val());
		 		if (currentValue == NaN)
		 			currentValue = 0;

				parts = $(this).prop('id').split('_');

				if (2 in parts) {

					if ($(this).val() >= 3)
						oppositeScore = 0;
					else
						oppositeScore = 3;

					if (parts[2] == 'left')
						$('#encounter_' + parts[1] + '_right').val(oppositeScore);
					else
						$('#encounter_' + parts[1] + '_left').val(oppositeScore);

				}

				if (!currentValue)
					$(this).val(0);

				// if ((currentValue == 0) || (currentValue)) 
				// 	$(this).val(currentValue + 1);

				// if (currentValue == 2)
				// 	$(this).val(2);

				if (currentValue > 3)
					$(this).val(3);

				// update the totals
				
				select.updateFixtureScore();
	},

	loadPlayer: function() {
		if ($(this).attr('name') == 'team[left]') {
			select.side = 'left';
		} else {
			select.side = 'right';
		}
		select.player = $(select.container).find('.' + select.side).find('select[name^="player"]');
		$(select.player).html('');
		$.getJSON(BASE_URL + '/ajax/player/?team_id=' + $('.' + select.side).find('select[name^="team"]').val(), function(results) {
			if (results) {
				$.each(results, function(index, result) {
					$(select.player).append('<option value="' + result.id + '">' + result.full_name + '</option>');
				});
				select.arrangePlayer();
				$(select.player).on('change', function() {
					var name = $(this).find('option:selected').html();
					var parts = $(this).prop('name').replace(']', '').replace(']', '').split('[');
					if (2 in parts) {
						select.updatePlayer(parts[2], name);
					}

				});
			}
		});	
	}
}

function formSubmit() {
	$(this).closest('form').submit();
	return false;
}

// document ready

$(document).ready(function() {
	less.watch();
	$.ajaxSetup ({  
		cache: false
	});
	select.init();
	feedback.init();
	$('form').find('a.submit').on('mouseup', formSubmit);
	if ($('.content.page').length || $('.content.press').length) {
		var editor = new wysihtml5.Editor("textarea", {
		  toolbar:        "toolbar",
		  parserRules:    wysihtml5ParserRules,
		  useLineBreaks:  false
		});
	}
	$(document).mouseup(removeModals);	
	$(document).keyup(function(e) {
		if (e.keyCode == 27)
			removeModals();
	});	
	function removeModals() {
		$('*').removeClass('active');
	}
	var user = $('header.main').find('.user');
	user.find('a').on('click', clickUser);
	function clickUser() {
		user.addClass('active');
	}
	var websiteTitle = $('header.main').find('.title').find('a');
	websiteTitleText = $('header.main').find('.title').find('a').html();
	websiteTitle.hover(function over() {
		var text = $(this).html();
		text = 'Open ' + text + ' Homepage';
		$(this).html(text);
	},
	function out() {
		$(this).html(websiteTitleText);
	});
}); // document ready