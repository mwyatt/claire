


// from config.js

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





// from gruntfile

              appDir: 'js',
              baseUrl: 'js',
              dir: 'asset',
              mainConfigFile:'js/build.js',
              findNestedDependencies: true,
              fileExclusionRegExp: /^\./,
              inlineText: true


// attempt at build

({
    mainConfigFile: 'config.js',
    dir: "../asset",
    optimize: "uglify",
    uglify: {
        toplevel: true,
        ascii_only: true,
        beautify: true,
        max_line_length: 1000,

        defines: {
            DEBUG: ['name', 'false']
        },

        no_mangle: true
    }
})



// all build properties


({
    appDir: "some/path/",
    baseUrl: "./",
    mainConfigFile: '../some/path/to/main.js',
    paths: {
        "foo.bar": "../scripts/foo/bar",
        "baz": "../another/path/baz"
    },
    map: {},
    packages: [],
    dir: "../some/path",
    keepBuildDir: false,
    shim: {},
    wrapShim: false,
    locale: "en-us",
    optimize: "uglify",
    skipDirOptimize: false,
    generateSourceMaps: false,
    normalizeDirDefines: "skip",
    uglify: {
        toplevel: true,
        ascii_only: true,
        beautify: true,
        max_line_length: 1000,
        defines: {
            DEBUG: ['name', 'false']
        },
        no_mangle: true
    },
    uglify2: {
        output: {
            beautify: true
        },
        compress: {
            sequences: false,
            global_defs: {
                DEBUG: false
            }
        },
        warnings: true,
        mangle: false
    },
    closure: {
        CompilerOptions: {},
        CompilationLevel: 'SIMPLE_OPTIMIZATIONS',
        loggingLevel: 'WARNING'
    },
    optimizeCss: "standard.keepLines.keepWhitespace",
    cssImportIgnore: null,
    cssIn: "path/to/main.css",
    out: "path/to/css-optimized.css",
    cssPrefix: "",
    inlineText: true,
    useStrict: false,
    pragmas: {
        fooExclude: true
    },
    pragmasOnSave: {
        excludeCoffeeScript: true
    },
    has: {
        'function-bind': true,
        'string-trim': false
    },
    hasOnSave: {
        'function-bind': true,
        'string-trim': false
    },
    namespace: 'foo',
    skipPragmas: false,
    skipModuleInsertion: false,
    stubModules: ['text', 'bar'],
    optimizeAllPluginResources: false,
    findNestedDependencies: false,
    removeCombined: false,
    modules: [
        {
            name: "foo/bar/bop",
            create: true,
            override: {
                pragmas: {
                    fooExclude: true
                }
            }
        },
        {
            name: "foo/bar/bop",
            include: ["foo/bar/bee"]
        },
        {
            name: "foo/bar/bip",
            exclude: [
                "foo/bar/bop"
            ]
        },
        {
            name: "foo/bar/bin",
            excludeShallow: [
                "foo/bar/bot"
            ]
        },
        {
            name: "foo/baz",
            insertRequire: ["foo/baz"]
        }
    ],
    insertRequire: ['foo/bar/bop'],
    name: "foo/bar/bop",
    include: ["foo/bar/bee"],
    insertRequire: ['foo/bar/bop'],
    out: "path/to/optimized-file.js",
    deps: ["foo/bar/bee"],
    out: function (text, sourceMapText) {
    },
    out: "stdout",
    wrap: {
        start: "(function() {",
        end: "}());"
    },
    wrap: true,
    wrap: {
        startFile: "parts/start.frag",
        endFile: "parts/end.frag"
    },
    wrap: {
        startFile: ["parts/startOne.frag", "parts/startTwo.frag"],
        endFile: ["parts/endOne.frag", "parts/endTwo.frag"]
    },
    fileExclusionRegExp: /^\./,
    preserveLicenseComments: true,
    logLevel: 0,
    throwWhen: {
        optimize: true
    },
    onBuildRead: function (moduleName, path, contents) {
        return contents.replace(/foo/g, 'bar');
    },
    onBuildWrite: function (moduleName, path, contents) {
        return contents.replace(/bar/g, 'foo');
    },
    onModuleBundleComplete: function (data) {
        /*
        data.name: the bundle name.
        data.path: the bundle path relative to the output directory.
        data.included: an array of items included in the build bundle.
        If a file path, it is relative to the output directory. Loader
        plugin IDs are also included in this array, but depending
        on the plugin, may or may not have something inlined in the
        module bundle.
        */
    },
    rawText: {
        'some/id': 'define(["another/id"], function () {});'
    },
    cjsTranslate: true,
    useSourceUrl: true,
    waitSeconds: 7,
    skipSemiColonInsertion: false,
    keepAmdefine: false,
    allowSourceOverwrites: false
})
