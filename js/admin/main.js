

/**
 * config
 */
requirejs.config({
  paths: {
    jquery: '../vendor/jquery/jquery'
  }
});

// better way to do this?
function baseUrl (append) {
  return '<?php echo $this->getUrl() ?>' + append;
};

/**
 * entry point
 */
define(['jquery', 'feedbackStream'], function ($, feedbackStream) {
  console.log(feedbackStream);
  feedbackStream.createMessage(feedback);
  var moduleName = $('[data-module-name]').attr('data-module-name');
  if (! moduleName) {
    return;
  };
  require([moduleName]);
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
