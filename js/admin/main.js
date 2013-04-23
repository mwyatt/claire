var BASE_URL = $('body').data('url-base');

var selectDrop = {
	container: false,
	division: false,
	team: false,

	init: function() {
		selectDrop.container = $('.content');
		selectDrop.division = $(selectDrop.container).find('select[name="division_id"]');
		selectDrop.team = $(selectDrop.container).find('select[name="team_id"]');
		$(selectDrop.division).on('change', selectDrop.loadTeam);
	},

	loadTeam: function() {
		$(selectDrop.team).html('');
		$.getJSON(BASE_URL + '/ajax/team/?division_id=' + $(selectDrop.division).val(), function(results) {
			if (results) {
				$.each(results, function(index, result) {
					$(selectDrop.team).append('<option value="' + result.id + '">' + result.name + '</option>');
				});
			}
		});		
	}
}





/**
 * media
 * @type {Object}
 */
// var media = {
// 	container: false,
// 	uploadDir: BASE_URL + 'img/upload/',
// 	htmlModule: '<div class="row"><label for="media">Media</label></div>',

// 	init: function(container) {
// 		media.container = $(container);
// 	},

// 	loadCurrent: function() {
// 		$.getJSON(BASE_URL + '/ajax/main-content/?media=' + $(media.container).data('id'), function(results) {
// 			if (results) {
// 				console.log(results);
// 				$(media.container).find('.row').last().after(media.htmlModule);
// 				$.each(results, function(index, result) {
// 					$(media.container).find('.row').last().find('label').after('<a href="' + media.uploadDir + result.basename + '"><img src="' + media.uploadDir + result.basename + '" alt="' + result.filename + '"><span class="title">' + result.filename + '</span></a>');
// 				});
// 			} else {
// 				// console.log('value');
// 			}
// 		});		
// 	}
// }


function formSubmit() {
	$(this).closest('form').submit();
	return false;
}

/* main.js */

// document ready

$(document).ready(function() {

	less.watch();

	$.ajaxSetup ({  
		cache: false  
	});


	if ($('.content.player').length || $('.content.team').length) {
		selectDrop.init();
	}

	if ($('.content.update').length) {
		media.init('.content.update');
		media.loadCurrent();
	}










	if ($('.content.page').length || $('.content.press').length) {

		var editor = new wysihtml5.Editor("textarea", {
		  toolbar:        "toolbar",
		  parserRules:    wysihtml5ParserRules,
		  useLineBreaks:  false
		});
		
	}


	// admin/ (login)

	$("form.login").submit(function() {
		
		// Variable(s)
		var form = $("form.login");
		var fieldName;
		var field;
		var valid = true;
		
		// Function checkField
		function checkField(fieldName) {
		
			// Set Field
			field = $("input[name='"+fieldName+"']", form);
			
			// Check Field
			if (field.val() == "") {  
				$(field)
					.toggleClass("error")
					.focus();
				valid = false;
			}				
		}
		
		// Removes any Errors
		$(".error").toggleClass("error");
		
		checkField("password");
		checkField("username");
		
		return valid;			
	});	


	// admin/posts/press/new/

	if ($('.post.press.new').length) {

		var $module = $('.post.press.new');
		var title = $module.find('input[name="title"]');
		var type = $module.find('input[name="type"]');
		var attachments = $module.find('.attachments');

		title.on('change', e_change_post_title);
		title.on('keyup', e_change_post_title);

		function e_change_post_title() {

			if (! title.val()) return false;
			// if (title.val().length < 3) return false;
			
			var slug = $('.slug');
		
			$.get('http://' + window.location.host + '/git/mvc/ajax/post/',
				{ method: 'slug', type: type.val(), title: title.val() },
				function(result) {

					var link = slug.find('a');
					link.html(result);
					link.attr('href', 'http://' + window.location.host + '/post/' + result);
					
				}
				, 'html'
			);

		}

		attachments.find('.add').on('click', e_click_attachments_add);

		function e_click_attachments_add() {

			
			
			return false;

		}
		
	}

	// global

	var fulfill = $('.fulfill');
	var selectDivision = $('select[name="division_id"]');
	var selectTeamGroup = $(fulfill).find('.team').find('select');
	var selectPlayerGroup = $(fulfill).find('.player').find('select');
	var inputScore = $(fulfill).find('.score').find('input');
	var btnPlayUp = $(fulfill).find('.play-up');
	var feedback = $('.feedback');
	var websiteTitle = $('header.main').find('.title').find('a');
	var user = $('header.main').find('.user');

	// on

	// selectDivision.on('change', changeDivision);
	selectTeamGroup.on('change', changeTeam);
	selectPlayerGroup.on('change', changePlayer);
	inputScore.on('keyup', changeInputScore);
	inputScore.on('click', clickInputScore);
	btnPlayUp.on('click', clickBtnPlayUp);

	// universal

	// click the document
	
	$(document).mouseup(removeModals);	

	// hit a key escape
	
	$(document).keyup(function(e) {
		if (e.keyCode == 27)
			removeModals();
	});	

	function removeModals() {
		$('*').removeClass('active');
	}

	// user

	user.find('a').on('click', clickUser);

	function clickUser() {
		user.addClass('active');
	}

	// website title

	websiteTitleText = $('header.main').find('.title').find('a').html();

	websiteTitle.hover(function over() {
		var text = $(this).html();
		text = 'Open ' + text + ' Homepage';
		$(this).html(text);
	},
	function out() {
		$(this).html(websiteTitleText);
	});

	// feedback
	
	if (feedback.length) {

		var
			animationSpeed = 'fast';

		// setTimeout(showFeedback, 1000);

		// function showFeedback() {
		// 	feedback.fadeIn(animationSpeed);
		// 	setTimeout(hideFeedback, 10000);
		// }

		// function hideFeedback() {
		// 	// feedback.fadeOut(animationSpeed);
		// }

		feedback.on('click', clickFeedback);

		function clickFeedback() {
			$(this).fadeOut(animationSpeed);
		}

	}

	// /**
	//  * trigger once division select is used
	//  * @return {null} 
	//  */
	// function changeDivision() {

	// 	$.get('http://' + window.location.host + '/git/mvc/ajax/team/',
	// 		{ division_id: $(this).val() },
	// 		function(result) {
	// 			if (result) {
	// 				$(selectTeamGroup).html(result);
	// 			}
	// 		}, "html"
	// 	);

	// 	// reset player select
	// 	$(selectPlayerGroup).html('');

	// }


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

		$.get('http://' + window.location.host + '/git/mvc/ajax/fixture/',
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

		$.post('http://' + window.location.host + '/git/mvc/ajax/player/',
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


}); // document ready