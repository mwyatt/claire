var feedbackStream = require('admin/feedbackStream');

// cont
$.ajaxSetup({
  timeout: 10000,
  cache: false
});
feedbackStream.createMessage(feedback);
var module = $('.page');
if (! module) {
  return;
};

// replace with sick routing plugin
// is there a way to pick up where you need to route js based on the url alone?
// think about login and dashboard, both go to same place
if (module.hasClass('login')) {
  require('admin/login');
};
if (module.hasClass('option-all')) {
  // require('admin/option/all');
};
