<script type="text/javascript">
    var require = {
        baseUrl: '<?php echo $this->getUrl() ?>js/',
        urlArgs: 'bust=' +  (new Date()).getTime(),
    	paths: {
    	  'jquery': 'vendor/jquery/jquery',
    	  'tinymce': 'vendor/tinymce/tinymce',
    	  'mustache': 'vendor/mustache/mustache',
    	  'jquerySerializeObject': 'vendor/jquery-serialize-object/jquery.serialize-object.min',
    	  'magnificPopup': 'vendor/magnific-popup/jquery.magnific-popup'
    	},
    	shim: {
    	  'jquerySerializeObject': {
    	    deps: ['jquery']
    	  },
    	  'tinymce': {
    	    deps: ['jquery']
    	  },
    	  'magnificPopup': {
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
</script>
