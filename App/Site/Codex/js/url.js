

/**
 * handles all url operations
 * urlBase must be defined to proceed
 */
var Url = function () {
  if (typeof urlBase === 'undefined') {
    return console.warn('variable urlBase must be defined');
  };
	this.urlBase = urlBase;
};


/**
 * get the base url plus any appended path
 * @param  {string} append path/query
 * @return {string}        
 */
Url.prototype.getUrlBase = function(append) {
  var append = typeof append === 'undefined' ? '' : append;
	return this.urlBase + append;
};


/**
 * jump to urlBase + a specified url
 * @param  {string} path combine base and relative
 * @return {null}              
 */
Url.prototype.redirect = function(path) {
	window.location.href = this.getUrlBase(path);
};


/**
 * jump to exact specified url
 * @param  {string} path combine base and relative
 * @return {null}              
 */
Url.prototype.redirectAbsolute = function(path) {
	window.location.href = path;
};


module.exports = new Url;
