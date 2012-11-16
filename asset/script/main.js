/**
 * MVC
 * Main Script
 */


// # Document Ready
// ============================================================================

$(document).ready(function() {

	// global

	var
		fulfill = $('.fulfill')
		, selectDivision = $('select[name="division_id"]')
		, selectTeamGroup = $(fulfill).find('.team').find('select')
		, selectPlayerGroup = $(fulfill).find('.player').find('select')
		, inputScore = $(fulfill).find('.score').find('input')
		, btnPlayUp = $(fulfill).find('.play-up')
		;

	// on

	selectDivision.on('change', changeDivision);
	selectTeamGroup.on('change', changeTeam);
	selectPlayerGroup.on('change', changePlayer);
	inputScore.on('keyup', changeInputScore);
	inputScore.on('click', clickInputScore);
	btnPlayUp.on('click', clickBtnPlayUp);


	/**
	 * trigger once division select is used
	 * @return {null} 
	 */
	function changeDivision() {

		$.post('http://' + window.location.host + '/mvc/ajax/team/',
			{ 
				division_id: $(this).val()
			},
			function(result) {

				if (result) {

					// set options of team group
					
					$(selectTeamGroup).html(result);

				}

			}, "html"
		);

		// reset player select

		$(selectPlayerGroup).html('');

	}


	/**
	 * trigger once team select is used
	 * @return {null} 
	 */
	function changeTeam() {

		var
			side
			;

		// calculate side

		if ($(this).prop('name') == 'team[left]')
			side = 'left';
		else
			side = 'right';

		$.post('http://' + window.location.host + '/mvc/ajax/fixture/',
			{ 
				team_id: $(this).val()
			},
			function(result) {

				if (result) {

					// set results
					
					$(fulfill).find('.' + side).find('.player').find('select').html(result);

					// sets the selected index for each select box
					
					for (var index = 0; index < 3; index ++) { 

						playerIndex = index + 1;

						playerOptions = $('select[name="player[' + side + '][' + playerIndex + ']"]').find('option');

						playerOptions.each(function(optionIndex) {
							if ((optionIndex) == (index + 1)) {

								// set index as selected, 1, 2, 3
								
								$(this).prop('selected', 'selected');

								// set player labels
								
								$('.' + side).find('.score-' + playerIndex).find('label').html($(this).html());
								
							}
						});

					}

				}

			}, "html"
		);
		
	}


	/**
	 * change player
	 * @return {null} 
	 */
	function changePlayer() {

		var
			parts
			, playerName
			, index
			, side
			;

		playerName = $(this).find('option:selected').html();

		parts = $(this).prop('name').replace(']', '').replace(']', '');
		parts = parts.split('[');

		if (2 in parts) {

			index = parts[2];

			if (1 in parts)
				side = parts[1];

			$('.' + side).find('.score-' + index).find('label').html(playerName);

		}

	}


	/**
	 * input score click
	 * @return {null} 
	 */
	function clickInputScore() {

		$(this).select();

	}


	/**
	 * input score change
	 * @return {null} 
	 */
	function changeInputScore(e) {

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
		
		updateTotal();

	}


	/**
	 * tots up the main totals for the fixture
	 * @return {[type]} [description]
	 */
	function updateTotal() {

		var
			score
			, leftTotal = 0
			, rightTotal = 0;

		$(fulfill).find('.left').find('.score').find('input').each(function() {

	 		score = parseInt($(this).val());
	 		if (isNaN(score))
	 			score = 0;

			leftTotal = leftTotal + score;

		});

		$(fulfill).find('.right').find('.score').find('input').each(function() {

	 		score = parseInt($(this).val());
	 		if (isNaN(score))
	 			score = 0;

			rightTotal = rightTotal + score;

		});

		// set left and right total display and hidden inputs

		$(fulfill).find('.left').find('.total').find('p').html(leftTotal);
			$(fulfill).find('.left').find('.total').find('input').val(leftTotal);
		$(fulfill).find('.right').find('.total').find('p').html(rightTotal);
			$(fulfill).find('.right').find('.total').find('input').val(rightTotal);

	}


	function clickBtnPlayUp() {

		var btn = $(this);
		$(this).addClass('active');

		$.post('http://' + window.location.host + '/mvc/ajax/player/',
			{ 
				all: true
			},
			function(result) {

				if (result) {

					
					$(btn).siblings('select').html(result);

				}

			}, "html"
		);

	}


}); // Document Ready Function