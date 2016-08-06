/**
 * Created by Daniel on 18.07.2016.
 */
module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        config: {
            mainColor: '#ffffff',
            node_modules: ['node_modules'],
            scripts: ['js'],
            scripts_build: ['../js'],
            styles: ['css'],
            styles_build: ['../css'],
            vendorStyles: ['css/bootstrap.min.css'],
            vendorScripts: ['js/bootstrap.min.js']
        },
        uglify: {
            options: {
                banner: '/* <%= pkg.name %> <%= pkg.version %> <%= grunt.template.today("isoDateTime") %> - This line was generated automatically. Do not remove. */\n'
            },
            build: {
                files: {
                    '<%= config.scripts_build %>/scripts.min.js': ['<%= config.scripts %>/scripts.js'],
                    '<%= config.scripts_build %>/vendor.min.js': '<%= config.vendorScripts %>'
                }
            }
        },
        cssmin: {
            options: {
                banner: '/* <%= pkg.name %> <%= pkg.version %> <%= grunt.template.today("isoDateTime") %> - This line was generated automatically. Do not remove. */',
                keepSpecialComments: 0
            },
            build: {
                files: {
                    '<%= config.styles_build %>/theme.min.css': ['<%= config.styles %>/theme.css'],
                    '<%= config.styles_build %>/vendor.min.css': '<%= config.vendorStyles %>'
                }
            }
        },
        less: {
            develop: {
                options: {
                    paths: ['<%= config.styles %>']
                },
                files: {
                    '<%= config.styles %>/theme.css': '<%= config.styles %>/theme.less'
                }
            }
        },
        copy: {
            build: {
                files: [{
                    expand: true,
                    filter: 'isFile',
                    flatten: true,
                    src: '<%= config.node_modules %>/bootstrap/dist/css/bootstrap.min.css',
                    dest: 'css'
                },{
                    expand: true,
                    filter: 'isFile',
                    flatten: true,
                    src: '<%= config.node_modules %>/bootstrap/dist/js/bootstrap.min.js',
                    dest: 'js'
                },{
                    expand: true,
                    filter: 'isFile',
                    flatten: true,
                    src: '<%= config.node_modules %>/jquery/dist/jquery.min.js',
                    dest: '../js'
                }]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-copy');

    grunt.registerTask('default', ['']);
    grunt.registerTask('build', ['copy','uglify','less','cssmin']);
    grunt.registerTask('styles', ['less','cssmin']);
};