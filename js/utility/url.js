

/**
 * urlBase must be defined
 */
var Url = function () {
  if (! localStorage.getItem('url/base')) {
    if (typeof urlBase === 'undefined') {
      return console.warn('variable urlBase must be defined');
    };
    localStorage.setItem('url/base', urlBase);
  };
	this.urlBase = localStorage.getItem('url/base');
};


Url.prototype.getUrlBase = function(append) {
  var append = typeof append === 'undefined' ? '' : append;
	return this.urlBase + append;
};


/**
 * jump to a specified url
 * @param  {string} path combine base and relative
 * @return {null}              
 */
Url.prototype.redirect = function(path) {
	window.location.href = this.getUrlBase() + path;
};


/**
 * jump to a specified url
 * @param  {string} path combine base and relative
 * @return {null}              
 */
Url.prototype.redirectAbsolute = function(path) {
	window.location.href = path;
};


module.exports = new Url;
