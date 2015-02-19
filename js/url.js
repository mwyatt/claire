

/**
 * urlBase must be defined
 */
var Url = function () {
  if (typeof urlBase === 'undefined') {
    return console.warn('variable urlBase must be defined');
  };
	this.urlBase = urlBase;
};


Url.prototype.getUrlBase = function() {
	return this.urlBase;
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
