

var Page_Tennis_Fixture_Single = function (options) {
	console.log('Page_Tennis_Fixture_Single.ready');
	this.isFilled;
	this.setResource(pageTennisFixtureSingleResource);
	this.determineState(this);
	this.eventsRefresh(this);

	// filled is setup in a new way
	if (this.getIsFilled()) {
		this.formFill(this);
	};

	// force update of score
	this.updateScore(this);
};


Page_Tennis_Fixture_Single.prototype.getSides = function(data) {
	return ['left', 'right'];
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
	var teamId;
	var players = resource.players;
	var player;
	var html = '';
	var sides = data.getSides();
	var side;
	var position;

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

	// fill players using teams as reference
	for (var a = sides.length - 1; a >= 0; a--) {
		html = data.getOption('', '');
		side = sides[a];
		teamId = $('.js-fixture-single-team[data-side="' + side + '"]').val();
		for (var b = players.length - 1; b >= 0; b--) {
			player = players[b];
			if (player.team_id == teamId) {
				html += data.getOption(player.name_first + ' ' + player.name_last, player.id);
			};
		};
		$('.js-fixture-single-player[data-side="' + side + '"]').html(html);
	};

	// arrange players based on encounters
	var options;
	var joption;
	var playerId;
	position = 1;
	for (var s = sides.length - 1; s >= 0; s--) {
		side = sides[s];
		for (var position = 1; position < 4; position ++) {
			encounter = encounters[position - 1];
			playerId = encounter['player_id_' + side];
			options = $('.js-fixture-single-player[data-side="' + side + '"][data-position="' + position + '"]').find('option');
			for (var o = options.length - 1; o >= 0; o--) {
				joption = $(options[o]);
				if (playerId == joption.val()) {
					joption.prop('selected', 'selected');
					data.updatePlayerLabel(data, side, position, joption.html());
				};
			};
		};
	};

	// fill encounters
	for (var e = encounters.length - 1; e >= 0; e--) {
		encounter = encounters[e];

		// excludes
		if (encounter.status == 'exclude') {
			data.encounterExclude(data, $('.js-fixture-single-score-row-exclude-checkbox[data-row="' + e + '"]'));
		};

		// scores
		for (var s = sides.length - 1; s >= 0; s--) {
			side = sides[s];
			$('.js-fixture-single-encounter-input[data-side="' + side + '"][data-row="' + e + '"]').val(encounter['score_' + side]);
		};
	};
};


Page_Tennis_Fixture_Single.prototype.updateScore = function(data) {

	// resources
	var sides = data.getSides();
	var total;
	var inputScores;
	var jinputScore;
	
	// count each side and change total
	for (var s = sides.length - 1; s >= 0; s--) {
		side = sides[s];
		total = 0;
		inputScores = $('.js-fixture-single-encounter-input[data-side="' + side + '"]');
		for (var r = inputScores.length - 1; r >= 0; r--) {
			jinputScore = $(inputScores[r]);
			total += parseInt(jinputScore.val());
		};
		$('.js-fixture-single-total[data-side="' + side + '"]').html(total.toString());
	};
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

	if (! data.isFilled) {

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
	$('.js-fixture-single-button-play-up').on('click.page-tennis-fixture-single', function(event) {
		data.playUp(data, $(this));
	});

	// encounter exclude
	$('.js-fixture-single-score-row-exclude-checkbox').on('click.page-tennis-fixture-single', function(event) {
		event.preventDefault();
		data.encounterExclude(data, $(this));
	});

	// select score when clicking
	$('.js-fixture-single-encounter-input').on('click.page-tennis-fixture-single', function(event) {
		$(this).select();
	});

	// update totals when changing the encounter inputs
	$('.js-fixture-single-encounter-input').on('change.page-tennis-fixture-single', function(event) {
		console.log($(this).val());
		data.updateScore(data);
	});
};


Page_Tennis_Fixture_Single.prototype.encounterExclude = function(data, trigger) {
	var row = trigger.closest('.js-fixture-single-score-row').toggleClass('is-excluded');
	trigger.prop('checked', row.hasClass('is-excluded'));
	console.log(trigger.prop('checked'));
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
	var joption;
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

	// playUp: function() {
	// 	var playerSelect;
	// 	var playUpButton = $(this);
	// 	$(playUpButton).off();
	// 	if ($(this).hasClass('left')) {
	// 		playerSelect = $(this).parent().find('select[name^="player[left]"]');
	// 	} else {
	// 		playerSelect = $(this).parent().find('select[name^="player[right]"]');
	// 	}
	// 	$.getJSON(url.base + '/ajax/player/', function(results) {
	// 		if (results) {
	// 			$(playerSelect).html('');
	// 			$.each(results, function(index, result) {
	// 				$(playerSelect).append('<option value="' + result.id + '">' + result.name + '</option>');
	// 			});
	// 			$(playerSelect).on('change', select.changePlayer);
	// 			$(playUpButton).fadeOut('fast');
	// 		}
	// 	});
	// },

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
