module.exports = {
    plugins: 'image media code link template table paste autosave',
    selector: '.js-tinymce',
    height: 500,
    content_css: '../../../asset/admin/tinymce-content.css',
    paste_word_valid_elements: "b,strong,i,em,h1,h2",
    autosave_interval: "5s",
    relative_urls: false,
    image_class_list: [
        {title: 'None', value: ''},
        {title: 'left', value: 'left mr1 mb1'},
        {title: 'right', value: 'right ml1 mb1'}
    ],
	menu: {
        edit: {
        	title: 'Edit',
        	items: 'undo redo | cut copy paste pastetext | selectall'
        },
        view: {
        	title: 'View',
        	items: 'code'
        },
        table: {
        	title: 'Table',
        	items: 'inserttable tableprops deletetable | cell row column'
        }
	},
	toolbar: 'styleselect | link image media | code',
	valid_styles: {'*': ''}
};
