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



// /**  

//  * rules
//  * all blocks of functionaltiy seperated into 'module**'
//  */
// $(document).ready(function() {
// 	console.log('admin->ready');
// 	system = new System;
// 	var form = new Form;
// 	var controller = new Controller;
// });
