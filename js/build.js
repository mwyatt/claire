/*
 * This is an example build file that demonstrates how to use the build system for
 * require.js.
 *
 * THIS BUILD FILE WILL NOT WORK. It is referencing paths that probably
 * do not exist on your machine. Just use it as a guide.
 *
 *
 */

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
