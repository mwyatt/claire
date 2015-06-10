var url = require('url');

$('.js-division-delete').on('click', function() {
  $.ajax({
    url: url.getUrlBase('admin/division/1/'),
    type: 'delete',
    dataType: 'json',
    data: data,
    complete: function(result) {},
    success: function(result) {},
    error: function(result) {}
  });
});
