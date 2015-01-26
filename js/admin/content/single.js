require(['jquery', 'tinymce', 'admin/content/meta'], function ($, tinymce, contentMeta) {

  // wysi
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

  // slug
  var timeoutId;
  var $this;
  $('.js-input-title').on('keypress.content-single', function(event) {
    $this = $(this);
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function() {
      $.ajax({
        url: '../../../ajax/content/generate-slug/',
        type: 'get',
        dataType: 'json',
        data: {title: $this.val()},
        success: function(friendlyTitle) {
          $('.js-input-slug').val(friendlyTitle)
        },
        error: function(result) {
          console.log(result);
        }
      });
      
    }, 500);
  });
});
