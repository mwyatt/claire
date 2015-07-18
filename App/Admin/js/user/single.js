
var toggled = false;
$('.js-toggle-all-permissions').on('click', function(event) {
  if (toggled) {
    $('[type="checkbox"]').prop('checked', false);
    toggled = $('[type="checkbox"]').prop('checked');
  } else {
    $('[type="checkbox"]').prop('checked', true);
    toggled = $('[type="checkbox"]').prop('checked');
  };
});
