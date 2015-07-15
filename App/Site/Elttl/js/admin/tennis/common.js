var feedbackStream = require('admin/feedbackStream');
var url = require('url');
require('admin/helper/slugify');


// delete single tennis thing
var $button;
$('.js-tennis-delete-single').on('click', function() {
  $button = $(this);
  $.ajax({
    url: url.getUrlBase('admin/tennis/' + $button.data('singular') + '/' + $button.data('id') + '/'),
    type: 'delete',
    dataType: 'json',
    success: function(result) {
      feedbackStream.createMessage(result);
      url.redirect('admin/tennis/' + $button.data('singular') + '/');
    },
    error: function(result) {
      feedbackStream.createMessage({message: 'Problem while deleting ' + $button.data('singular')});
    }
  });
});