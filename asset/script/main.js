/**
 * MVC
 * Main Script
 */


// # Document Ready
// ============================================================================

$(document).ready(function() {


// # /admin/card/
// ============================================================================

$('select[name="division"]').change(function() {

	$.post('http://localhost/mvc/ajax/admin/card.php',
		{ 
			division_id: $(this).val()
		},
		function(result) {

			if (result) {

				console.log(result);

			} else {

				console.log('Failure');

			}

		}, "html");

});


}); // Document Ready Function