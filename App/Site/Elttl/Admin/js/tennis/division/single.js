var url = require('utility/url');

$('.js-tennis-delete-single').on('click', function() {
  $.ajax({
    url: url.getUrlBase('admin/division/' +  + '/'),
    type: 'delete',
    dataType: 'json',
    data: data,
    complete: function(result) {},
    success: function(result) {},
    error: function(result) {}
  });
});
