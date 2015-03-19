

/**
 * dependencies
 */
var $ = require('vendor/jquery');


/**
 * package of helper functions
 */
var Helper = function () {};


/**
 * routes the app away to another url
 * @param  {string} path 
 * @return {null}      
 */
Helper.prototype.route = function(path) {
	window.location.href = path;
};


/**
 * retreives a mustache template from cache or requests
 * @todo make compatible with localStorage
 * @param  {object} config template, success
 * @return {null}        calls the success function
 */
Helper.prototype.getMustacheTemplate = function (config) {
	var urlBase = this.urlBase;
  var templates = localStorage.getItem('mustache/template');

  // init templates
  if (templates) {
    templates = JSON.parse(templates);
  } else {
    templates = {};
  };

  // cache or new
  if (templates.hasOwnProperty(config.template)) {
    config.success(JSON.parse(templates[config.template]));
  } else {
    $.ajax({
      url: urlBase('mustache/' + config.template + '.mst'),
      type: 'get',
      dataType: 'text',
      complete: function(response) {

        // store
        templates[config.template] = JSON.stringify(response.responseText);
        localStorage.setItem('mustache/template', JSON.stringify(templates));
      },
      success: config.success
    });
  }
};


// return
module.exports = new Helper;
