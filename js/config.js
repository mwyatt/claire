var require = {
  urlArgs: 'bust=' +  (new Date()).getTime(),
	paths: {
	  jquery: 'vendor/jquery',
	  tinymce: 'vendor/tinymce/tinymce',
	  mustache: 'vendor/mustache',
	  jquerySerializeObject: 'vendor/jquery.serialize-object.min',
	  magnificPopup: 'vendor/jquery.magnific-popup'
	},
	shim: {
	  jquerySerializeObject: {
	    deps: ['jquery']
	  },
	  tinymce: {
	    deps: ['jquery']
	  },
	  magnificPopup: {
	    deps: ['jquery']
	  },    
		tinymce: {
			exports: 'tinymce',
			init: function () {
				this.tinymce.DOM.events.domLoaded = true;
				return this.tinymce;
			}
		}
	}
};
