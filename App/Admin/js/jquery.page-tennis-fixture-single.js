

/**
 * completely removed from any ajax, works independently and quickly
 * @param {object} options 
 */
var Page_Tennis_Fixture_Single = function (options) {
	this.isFilled;
	this.setResource(pageTennisFixtureSingleResource);
	this.determineState(this);
	this.eventsRefresh(this);

	// filled is setup in a new way
	if (this.getIsFilled()) {
		this.formFill(this);
	};

	// force update of score
	this.updateTotals(this);
};


/**
 * simple array of sides definition
 * @param  {object} data 
 * @return {array}      
 */
Page_Tennis_Fixture_Single.prototype.getSides = function(data) {
	return ['left', 'right'];
};


/**
 * fills out the form as it was when it was saved
 * @param  {object} data 
 * @return {null}      
 */
Page_Tennis_Fixture_Single.prototype.formFill = function(data) {

	// resource
	var resource = data.getResource();
	var fixture = resource.fixture;
	var encounterStructure = resource.encounterStructure;
	var encounterStructureRow;
	var encounterStructurePart;
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
		html = data.getOption('', 0);
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
			encounterStructureRow = encounterStructure[position - 1];
			encounterStructurePart = encounterStructureRow[side == 'left' ? 0 : 1];
			encounter = encounters[position - 1];
			playerId = encounter['player_id_' + side];
			options = $('.js-fixture-single-player[data-side="' + side + '"][data-position="' + encounterStructurePart + '"]').find('option');
			for (var o = options.length - 1; o >= 0; o--) {
				joption = $(options[o]);
				if (playerId == joption.val()) {
					joption.prop('selected', 'selected');
					data.updatePlayerLabel(data, side, encounterStructurePart, joption.html());
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


/**
 * updates the total fixture scores at the bottom
 * @param  {object} data 
 * @return {null}      
 */
Page_Tennis_Fixture_Single.prototype.updateTotals = function(data) {

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
		total = isNaN(parseFloat(total)) ? 0 : total;
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


/**
 * adds common events for inputs and selects
 * @param  {object} data 
 * @return {null}      
 */
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
		// event.preventDefault();
		data.encounterExclude(data, $(this));
	});

	// select score when clicking
	$('.js-fixture-single-encounter-input').on('click.page-tennis-fixture-single', function(event) {
		$(this).select();
	});

	// update totals when changing the encounter inputs
	$('.js-fixture-single-encounter-input').on('change.page-tennis-fixture-single', function(event) {
		data.smartFillEncounter(data, $(this));
		data.updateTotals(data);
	});

	// delete fixture add hidden value
	$('.js-form-button-fixture-delete').off().on('click.page-tennis-fixture-single', function(event) {
		event.preventDefault();
		$(this)
			.after('<input name="delete" type="hidden" value="1">')
			.closest('form')
			.submit();
	});
};


/**
 * tries to predict the encounter scores in that row based on 1 input
 * @param  {object} data    
 * @param  {object} trigger 
 * @return {null}         
 */
Page_Tennis_Fixture_Single.prototype.smartFillEncounter = function(data, trigger) {
	var sides = data.getSides();
	var scoreOpposing = 0;
	var score = parseInt(trigger.val());
	if (score > 3) {
		score = 3;
	};
	if (score < 3) {
		scoreOpposing = 3;
	};
	score = isNaN(parseFloat(score)) ? 0 : score;
	trigger.val(score);
	for (var s = sides.length - 1; s >= 0; s--) {
		side = sides[s];
		if (trigger.data('side') != side) {
			$('.js-fixture-single-encounter-input[data-side="' + side + '"][data-row="' + trigger.data('row') + '"]').val(scoreOpposing);
		};
	};
};


/**
 * when the exclude tickbox is checked the row is toggled exclude
 * @todo the checkbox does not respond to being checked
 * @param  {object} data    
 * @param  {object} trigger 
 * @return {null}         
 */
Page_Tennis_Fixture_Single.prototype.encounterExclude = function(data, trigger) {
	var row = trigger.closest('.js-fixture-single-score-row').toggleClass('is-excluded');
	trigger.prop('checked', row.hasClass('is-excluded'));
};


/**
 * clicked next to a player this renders all the players in the league
 * to choose from when a player needs to play from another division
 * @param  {object} data    
 * @param  {object} trigger 
 * @return {null}         
 */
Page_Tennis_Fixture_Single.prototype.playUp = function(data, trigger) {

	// resource
	var resource = data.getResource();
	var side = trigger.data('side');
	var position = trigger.data('position');
	var players = resource.players;
	var player;
	var html = '';

	// empty player and add initial value
	var playerSelect = $('.js-fixture-single-player[data-side="' + side + '"][data-position="' + position + '"]').html(data.getOption('', 0));

	// fill player select with all players
	for (var i = players.length - 1; i >= 0; i--) {
		player = players[i];
		html += data.getOption(player.name_first + ' ' + player.name_last, player.id);
	};
	playerSelect.html(playerSelect.html() + html);
};


/**
 * html option structure
 * @param  {string} name  
 * @param  {string} value id
 * @return {string}       
 */
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
	var teamSelect = $('.js-fixture-single-team').html(data.getOption('', 0));
	$('.js-fixture-single-player').html(data.getOption('', 0));

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
	var playerSelect = $('.js-fixture-single-player[data-side="' + side + '"]').html(data.getOption('', 0));

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


/**
 * finds player label and updates with appropriate name of player
 * @param  {object} data       
 * @param  {string} side       
 * @param  {int} position   
 * @param  {string} playerName 
 * @return {null}            
 */
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
