

var Page_Tennis_Fixture_Single = function (options) {
	console.log('Page_Tennis_Fixture_Single.ready');
	this.isFilled;
	this.setResource(pageTennisFixtureSingleResource);
	this.exclude();
	this.determineState(this);
	this.eventsRefresh(this);

	// filled is setup in a new way
	if (this.getIsFilled()) {
		this.formFill(this);
	};
};


Page_Tennis_Fixture_Single.prototype.formFill = function(data) {

	// resource
	var resource = data.getResource();
	var fixture = resource.fixture;
	var encounters = resource.encounters;
	var encounter;
	var divisions = resource.divisions;
	var division;
	var teams = resource.teams;
	var team;
	var players = resource.players;
	var player;
	var html = '';
	var sides = ['left', 'right'];
	var side;

	// fill division
	for (var i = divisions.length - 1; i >= 0; i--) {
		division = divisions[i];
		$('.js-fixture-single-division').html(data.getOption(division.name, division.id));
	};

	// fill teams using fixture as template
	for (var a = sides.length - 1; a >= 0; a--) {
		side = sides[a];
		for (var b = teams.length - 1; b >= 0; b--) {
			team = teams[b];
			if (fixture['team_id_' + side] == team.id) {
				$('.js-fixture-single-team[data-side="' + side + '"]').html(data.getOption(team.name, team.id));
			};
		};
	};

	// fill players using encounters as template
	
};




/**
 * sets up the state of the fixture, is it filled or not?
 * @param  {object} data 
 * @return {null}      
 */
Page_Tennis_Fixture_Single.prototype.determineState = function(data) {
	var resource = data.getResource();
	this.setIsFilled(resource.isFilled);
};


Page_Tennis_Fixture_Single.prototype.eventsRefresh = function(data) {

	if (data.isFilled) {

		// division
		$('.js-fixture-single-division').on('change.page-tennis-fixture-single', function(event) {
			data.divisionChange(data, $(this));
		});

		// team
		$('.js-fixture-single-team').on('change.page-tennis-fixture-single', function(event) {
			data.teamChange(data, $(this));
		});
	};

	// player
	$('.js-fixture-single-player').on('change.page-tennis-fixture-single', function(event) {
		data.playerChange(data, $(this));
	});

	// player.play-up
	$('.js-fixture-single-button-play-up').on('click', function(event) {
		data.playUp(data, $(this));
	});
};


Page_Tennis_Fixture_Single.prototype.playUp = function(data, trigger) {

	// resource
	var resource = data.getResource();
	var side = trigger.data('side');
	var position = trigger.data('position');
	var players = resource.players;
	var player;
	var html = '';

	// empty player and add initial value
	var playerSelect = $('.js-fixture-single-player[data-side="' + side + '"][data-position="' + position + '"]').html(data.getOption('', ''));

	// fill player select with all players
	for (var i = players.length - 1; i >= 0; i--) {
		player = players[i];
		html += data.getOption(player.name_first + ' ' + player.name_last, player.id);
	};
	playerSelect.html(playerSelect.html() + html);
};


Page_Tennis_Fixture_Single.prototype.getOption = function(name, value) {
	return '<option value="' + value + '">' + name + '</option>';
};


/**
 * the division select has changed
 * @param  {object} data    
 * @param  {object} trigger select
 * @return {null}         
 */
Page_Tennis_Fixture_Single.prototype.divisionChange = function(data, trigger) {

	// resource
	var resource = data.getResource();
	var divisionId = trigger.val();
	var teams = resource.teams;
	var team;
	var html = '';

	// empty team, player and add initial values
	var teamSelect = $('.js-fixture-single-team').html(data.getOption('', ''));
	$('.js-fixture-single-player').html(data.getOption('', ''));

	// fill team selects with teams from the division
	for (var i = teams.length - 1; i >= 0; i--) {
		team = teams[i];
		if (team.division_id == divisionId) {
			html += data.getOption(team.name, team.id);
		};
	};
	teamSelect.html(teamSelect.html() + html);
};


/**
 * the team select has changed
 * @param  {object} data    
 * @param  {object} trigger select
 * @return {null}         
 */
Page_Tennis_Fixture_Single.prototype.teamChange = function(data, trigger) {

	// resource
	var resource = data.getResource();
	var teamId = trigger.val();
	var side = trigger.data('side');
	var players = resource.players;
	var player;
	var html = '';

	// empty player and add initial values
	var playerSelect = $('.js-fixture-single-player[data-side="' + side + '"]').html(data.getOption('', ''));

	// fill team selects with player from the team
	for (var i = players.length - 1; i >= 0; i--) {
		player = players[i];
		if (player.team_id == teamId) {
			html += data.getOption(player.name_first + ' ' + player.name_last, player.id);
		};
	};
	playerSelect.html(playerSelect.html() + html);
	data.playerArrange(data, side);
};


Page_Tennis_Fixture_Single.prototype.updatePlayerLabel = function(data, side, position, playerName) {
	console.log(data, side, position, playerName);
	$('.js-fixture-single-score-row-encounter-label[data-side="' + side + '"][data-position="' + position + '"]').html(playerName);
};


/**
 * arranges players into their select slots
 * @param  {object} data 
 * @param  {string} side left, right
 * @return {null}      
 */
Page_Tennis_Fixture_Single.prototype.playerArrange = function(data, side) {
	var options;
	var option;
	for (var position = 1; position < 4; position ++) { 
		options = $('.js-fixture-single-player[data-side="' + side + '"][data-position="' + position + '"]').find('option');
		for (var index = options.length - 1; index >= 0; index--) {
			joption = $(options[index]);
			if (index == position) {
				joption.prop('selected', 'selected');
				data.updatePlayerLabel(data, side, position, joption.html());
			}
		};
	}
};


/**
 * the player select has changed
 * @param  {object} data    
 * @param  {object} trigger select
 * @return {null}         
 */
Page_Tennis_Fixture_Single.prototype.playerChange = function(data, trigger) {
	data.updatePlayerLabel(data, trigger.data('side'), trigger.data('position'), trigger.find('option:selected').html());
};


/**
 * handles exclusion of particular row
 * @return {null} 
 */
Page_Tennis_Fixture_Single.prototype.exclude = function() {
	$('.js-fixture-single-score-row-exclude-checkbox').on('click.page-tennis-fixture-single', function(event) {
		var jthis = $(this);
		jthis.closest('.js-fixture-single-score-row').removeClass('is-excluded');
		if (jthis.prop('checked')) {
			jthis.closest('.js-fixture-single-score-row').addClass('is-excluded');
		};
	});
};


/**
 * currently contains:
 * 		divisions
 * 		teams
 * 		players
 * @return {array} 
 */
Page_Tennis_Fixture_Single.prototype.getResource = function() {
	return this.resource;
};


/**
 * sets the database resource which was json encoded
 * @param {object} resource 
 */
Page_Tennis_Fixture_Single.prototype.setResource = function(resource) {
	this.resource = resource;
	return this;
};


Page_Tennis_Fixture_Single.prototype.getIsFilled = function() {
	return this.isFilled;
};


/**
 * sets the database IsFilled which was json encoded
 * @param {object} IsFilled 
 */
Page_Tennis_Fixture_Single.prototype.setIsFilled = function(isFilled) {
	this.isFilled = isFilled;
	return this;
};


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
		$('.play-up').on('mouseup', select.playUp);
	},

	// loadTeam: function() {
	// 	select._reset('player');
	// 	$(select.team).html('');

	// 	$.getJSON(url.base + '/ajax/team/?division_id=' + $(select.division).val(), function(results) {
	// 		if (results) {
	// 			$(select.team).append('<option value="0"></option>');
	// 			$.each(results, function(index, result) {
	// 				$(select.team).append('<option value="' + result.id + '">' + result.name + '</option>');
	// 			});
	// 			$(select.team).on('change', select.loadPlayer);
	// 			$(select.team).prop("disabled", false);
	// 		}
	// 	});		
	// },

	playUp: function() {
		var playerSelect;
		var playUpButton = $(this);
		$(playUpButton).off();
		if ($(this).hasClass('left')) {
			playerSelect = $(this).parent().find('select[name^="player[left]"]');
		} else {
			playerSelect = $(this).parent().find('select[name^="player[right]"]');
		}
		$.getJSON(url.base + '/ajax/player/', function(results) {
			if (results) {
				$(playerSelect).html('');
				$.each(results, function(index, result) {
					$(playerSelect).append('<option value="' + result.id + '">' + result.name + '</option>');
				});
				$(playerSelect).on('change', select.changePlayer);
				$(playUpButton).fadeOut('fast');
			}
		});
	},

	updatePlayerLabel: function(side, index, name) {
		$('label[for$="' + side + '"].player-' + index).html(name);
	},

	clickInputScore: function() {
		$(this).select();
	},

	arrangePlayerSelect: function() {
		for (var index = 0; index < 3; index ++) { 
			playerIndex = index + 1;
			playerOptions = $('select[name="player[' + select.side + '][' + playerIndex + ']"]').find('option');
			playerOptions.each(function(optionIndex) {
				if ((optionIndex) == (index + 1)) {
					$(this).prop('selected', 'selected');
					select.updatePlayerLabel(select.side, playerIndex, $(this).html());
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
		var score, leftTotal = 0, rightTotal = 0;
		$(select.container).find('.row.score').find('input[name$="[left]"]').each(function() {
	 		score = parseInt($(this).val());
	 		if (isNaN(score))
	 			score = 0;
			leftTotal = leftTotal + score;
		});
		$(select.container).find('.row.score').find('input[name$="[right]"]').each(function() {
	 		score = parseInt($(this).val());
	 		if (isNaN(score))
	 			score = 0;
			rightTotal = rightTotal + score;
		});
		$(select.container).find('.row.total').find('.left').html(leftTotal);
		$(select.container).find('.row.total').find('.right').html(rightTotal);
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
		select.player = $(select.container).find('select[name^="player[' + select.side + ']"]');
		$(select.player).html('');
		$.getJSON(url.base + '/ajax/player/?team_id=' + $(this).val(), function(results) {
			if (results) {
				$(select.player).append('<option value="0">Absent Player</option>');
				$.each(results, function(index, result) {
					$(select.player).append('<option value="' + result.id + '">' + result.full_name + '</option>');
				});
				select.arrangePlayerSelect();
				$(select.player).on('change', function() {
					select.updatePlayerLabel($(this).data('side'), $(this).data('position'), $(this).find('option:selected').html());
				});
				$(select.player).prop("disabled", false);
			}
		});	
	}
}
