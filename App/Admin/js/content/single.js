var contentMeta = require('admin/content/meta');
var url = require('utility/url');


// wysi
tinymce.init(require('admin/tinymceConfig'));

// slug
var timeoutId;
var $this;
$('.js-input-title').on('keypress.content-single', function(event) {
  $this = $(this);
  clearTimeout(timeoutId);
  timeoutId = setTimeout(function() {
    $.ajax({
      url: url.getUrlBase('admin/ajax/content/generate-slug/'),
      type: 'get',
      dataType: 'json',
      data: {title: $this.val()},
      success: function(friendlyTitle) {
        $('.js-input-slug').val(friendlyTitle)
      },
      error: function(result) {
        console.log(result);
      }
    });
  }, 500);
});
