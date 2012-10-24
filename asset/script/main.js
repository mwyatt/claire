/**
 * MVC
 * Main Script
 */


// # Document Ready
// ============================================================================

$(document).ready(function() {


	fulfill = $('.fulfill');


	// # /admin/card/
	// ========================================================================

	// select division change
	fulfill.find('select[name="division_id"]').change(function() {

		$.post('http://localhost/mvc/ajax/admin/fixture/fulfill.php',
			{ 
				division_id: $(this).val()
			},
			function(result) {

				if (result) {

					fulfill.find('.team').find('select').html(result);
					fulfill.find('.player').find('select').html('');

				} else {

					alert('Unable to get Team Data');

				}

			}, "html");

	});

	// select team change
	fulfill.find('.team').find('select').change(function() {

		// calculate side
		if ($(this).prop('name') == 'team[left]') {
			var side = 'left';
		} else {
			var side = 'right';
		}

		$.post('http://localhost/mvc/ajax/admin/fixture/fulfill.php',
			{ 
				team_id: $(this).val()
			},
			function(result) {

				if (result) {

					// set results
					fulfill.find('.' + side).find('.player').find('select').html(result);

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



				} else {

					alert('Unable to get Player Data');

				}

			}, "html");

	});

	// select player change
	fulfill.find('.player').find('select').change(function() {

		var parts, playerName, index, side;

		playerName = $(this).find('option:selected').html();

		parts = $(this).prop('name').split('_');

		if (2 in parts) {

			index = parts[2];

			if (1 in parts)
				side = parts[1];

			$('.' + side).find('.score-' + index).find('label').html(playerName);

		}

	});

	// input score click
	fulfill.find('.score').find('input').click(function() {

		var currentValue, parts, index;

 		currentValue = parseInt($(this).val());
 		if (currentValue == NaN)
 			currentValue = 0;

		parts = $(this).prop('name').split('_');

		if (2 in parts) {

			if (parts[2] == 'left')
				$('#encounter_' + parts[1] + '_right').val(3);
			else
				$('#encounter_' + parts[1] + '_left').val(3);

		}

		if (!currentValue)
			$(this).val(0);

		if ((currentValue == 0) || (currentValue)) 
			$(this).val(currentValue + 1);

		if (currentValue == 2)
			$(this).val(2);

		if (currentValue > 2)
			$(this).val(0);

		// update the totals
		updateTotal();

	});

	// input score change
	fulfill.find('.score').find('input').change(function() {

		return;

	});

	function updateTotal() {

		var score, leftTotal = 0, rightTotal = 0;

		fulfill.find('.left').find('.score').find('input').each(function() {

	 		score = parseInt($(this).val());
	 		if (isNaN(score))
	 			score = 0;

			leftTotal = leftTotal + score;

		});

		fulfill.find('.right').find('.score').find('input').each(function() {

	 		score = parseInt($(this).val());
	 		if (isNaN(score))
	 			score = 0;

			rightTotal = rightTotal + score;

		});

		fulfill.find('.left').find('.total').find('p').html(leftTotal);
		fulfill.find('.right').find('.total').find('p').html(rightTotal);

	}


}); // Document Ready Function