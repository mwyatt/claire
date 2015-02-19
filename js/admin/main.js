var $ = require('jquery');
var feedbackStream = require('admin/feedbackStream');

// cont
$.ajaxSetup({
  timeout: 10000,
  cache: false
});
feedbackStream.createMessage(feedback);
var moduleName = $('[data-moduleName]').attr('data-moduleName');
if (! moduleName) {
  return;
};

// cant be done with browserify?
// require(['admin/' + moduleName]);

// replace with sick routing plugin
// is there a way to pick up where you need to route js based on the url alone?
// think about login and dashboard, both go to same place
if (moduleName == 'login') {
  require('admin/login');
};
if (moduleName == 'option/all') {
  require('admin/option/all');
};
if (moduleName == 'content/single') {
  require('admin/content/single');
};
