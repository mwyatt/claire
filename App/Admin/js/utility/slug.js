var feedbackStream = require('admin/feedbackStream');
var _ = require('underscore/underscore');
var url = require('utility/url');
var timeoutId;
var $this;
$('.js-input-title').on('keyup', function(event) {
  $this = $(this);
  clearTimeout(timeoutId);
  timeoutId = setTimeout(function() {
    $.ajax({
      url: url.getUrlBase('admin/ajax/content/generate-slug/'),
      type: 'get',
      dataType: 'json',
      data: {title: $this.val()},
      success: function(friendlyTitle) {
        $('.js-input-slug').val(friendlyTitle);
      },
      error: function(result) {
        feedbackStream.createMessage({
          message: 'Network error.',
          type: 'negative'
        });
      }
    });
  }, 500);
});

// multiple titles
$('.js-input-title-segment').on('keyup', function(event) {
  var title = '';
  _.each($('.js-input-title-segment'), function(input) {
    title += ' ' + $(input).val();
  });
  clearTimeout(timeoutId);
  timeoutId = setTimeout(function() {
    $.ajax({
      url: url.getUrlBase('admin/ajax/content/generate-slug/'),
      type: 'get',
      dataType: 'json',
      data: {title: title},
      success: function(friendlyTitle) {
        $('.js-input-slug').val(friendlyTitle);
      },
      error: function(result) {
        feedbackStream.createMessage({
          message: 'Network error.',
          type: 'negative'
        });
      }
    });
  }, 500);
});
