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

		$.post('http://localhost/mvc/ajax/admin/card.php',
			{ 
				division_id: $(this).val()
			},
			function(result) {

				if (result) {

					fulfill.find('.team').find('select').html(result);

				} else {

					alert('Unable to get Team Data');

				}

			}, "html");

	});

	// select team change
	fulfill.find('.team').find('select').change(function() {

		// calculate side
		if ($(this).prop('name') == 'team_left_id') {
			var side = 'left';
		} else {
			var side = 'right';
		}

		$.post('http://localhost/mvc/ajax/admin/card.php',
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

						playerOptions = $('select[name="player_' + side + '_' + playerIndex + '_id"]').find('option');

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

			// set labels
			$('.' + side).find('.score-' + index).find('label').html(playerName);

		}

	});

	// input score click
	fulfill.find('.score').find('input').click(function() {

		var currentValue;

 		currentValue = parseFloat($(this).val());

		// cursor select current input (usability)
		$(this).select();

		if (currentValue)
			$(this).val(currentValue + 1);

		if (currentValue >= 3)
			$(this).val(3);

		if (!currentValue)
			$(this).val(1);

	});

	// input score change
	fulfill.find('.score').find('input').change(function() {

		var currentValue;

 		currentValue = parseFloat($(this).val());

		$(this).select();

		if (currentValue > 3)
			$(this).val(3);

	});


}); // Document Ready Function