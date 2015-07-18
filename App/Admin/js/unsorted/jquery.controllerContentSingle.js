

/**
 */
var ControllerContentSingle = function () {
	var controller = new ControllerContentMeta;
	tinymce.init({
	    selector: '.js-tinymce',
		menu: {
		    file: {title : 'File'  , items : 'newdocument'},
		    edit: {title : 'Edit'  , items : 'undo redo | cut copy paste pastetext | selectall'},
		    insert : {title : 'Insert', items : 'link media | template hr | image'},
		    view: {title : 'View'  , items : 'visualaid'},
		    format: {title : 'Format', items : 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
		    table: {title : 'Table' , items : 'inserttable tableprops deletetable | cell row column'},
		    tools: {title : 'Tools' , items : 'spellchecker code'}
		}
	});
};
