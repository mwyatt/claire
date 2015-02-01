({
  "paths": {
    "jquery": "vendor/jquery",
    "tinymce": "vendor/tinymce/tinymce",
    "mustache": "vendor/mustache",
    "jquerySerializeObject": "vendor/jquery.serialize-object.min",
    "magnificPopup": "vendor/jquery.magnific-popup'"
  },
  "shim": {
    "jquerySerializeObject": {
      "deps": ["jquery"]
    },
    "tinymce": {
      "deps": ["jquery"]
    },
    "magnificPopup": {
      "deps": ["jquery"]
    },    
    "tinymce": {
      "exports": "tinymce"
    }
  },
  "name": "main",
  "out": "asset/main.js",
  "removeCombined": true,
  "optimize": "uglify",
  "uglify": {
    "toplevel": true,
    "ascii_only": true,
    "beautify": true,
    "max_line_length": 1000,
    "defines": {
        "DEBUG": ["name", "false"]
    },
    "no_mangle": true
  }
})
