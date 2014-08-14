

var Page_Tennis_Fixture_Single = function (options) {
	console.log('Page_Tennis_Fixture_Single->ready');
	this.setForms(this);
};


Page_Tennis_Fixture_Single.prototype.setForms = function(data) {

};



var exclude = {
	container: $('.exclude'),

	init: function() {
		$(exclude.container).on('click', exclude.isChecked);
	},

	isChecked: function() {
		if ($(this).find('input').prop('checked')) {
			$(this).closest('.row.score').addClass('excluded');
		} else {
			$(this).closest('.row.score').removeClass('excluded');
		}
	}
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

	loadTeam: function() {
		select._reset('player');
		$(select.team).html('');

		$.getJSON(url.base + '/ajax/team/?division_id=' + $(select.division).val(), function(results) {
			if (results) {
				$(select.team).append('<option value="0"></option>');
				$.each(results, function(index, result) {
					$(select.team).append('<option value="' + result.id + '">' + result.name + '</option>');
				});
				$(select.team).on('change', select.loadPlayer);
				$(select.team).prop("disabled", false);
			}
		});		
	},

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
