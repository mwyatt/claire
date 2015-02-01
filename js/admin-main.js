define(['jquery', 'admin/feedbackStream'], function ($, feedbackStream) {
  $.ajaxSetup({
    timeout: 10000,
    cache: false
  });
  feedbackStream.createMessage(feedback);
  var moduleName = $('[data-moduleName]').attr('data-moduleName');
  if (! moduleName) {
    return;
  };
  require(['admin/' + moduleName]);
});
