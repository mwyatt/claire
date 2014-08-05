
// inject into global scope
var system = {};


/**
 * backbone for js objects, url primarly used for ajax calls
 * initiated right now and added to global scope
 * @param {object} options 
 */
var System = function (options) {
	this.page = $('.page');
	this.documentBody = $(document.body);
	this.setEnvironment(this);
	this.setUrl(this);
};


/**
 * space for configuring initial things
 * @param {object} data 
 */
System.prototype.setEnvironment = function(data) {
	$.ajaxSetup({
		timeout: 10000,
		cache: false
	});
};


/**
 * routes the app away to another url
 * @param  {string} path 
 * @return {null}      
 */
System.prototype.route = function(path) {
	window.location.href = path;
};


/**
 * return part of the url object
 * @param  {string} key 
 * @return {string}     
 */
System.prototype.getUrl = function(key) {
	return this.url[key];
};


/**
 * request the page jquery selection
 * @return {$} 
 */
System.prototype.getPage = function() {
	return this.page;
};


/**
 * request the documentBody jquery selection
 * @return {$} 
 */
System.prototype.getDocumentBody = function() {
	return this.documentBody;
};


/**
 * boot up url object, stems from selecting dom element with the url stored
 * somewhere
 * @param {object} data 
 */
System.prototype.setUrl = function(data) {
	data.url = {};
	data.url.base = urlBase;
	data.url.ajax = data.url.base + 'ajax/'
	data.url.admin = data.url.base + 'admin/';
	data.url.adminAjax = data.url.admin + 'ajax/';
	data.url.currentNoQuery = [location.protocol, '//', location.host, location.pathname].join('');
};