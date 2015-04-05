'use strict';

module.exports = function (grunt) {
  // Load grunt-* tasks automatically
  require('load-grunt-tasks')(grunt);

  grunt.loadNpmTasks('grunt-contrib-less');

  // Define the configuration for all the tasks
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Test settings
    karma: {
      unit: {
        configFile: 'karma-test/karma.conf.js',
        singleRun: true
      }
    },

    //compile Less files
    less: {
      development: {
        options: {
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: {
          "public/styles/main.css": "public/styles/styles.less"
        }
      }
    },

    //concatenate files
    concat: {
      options: {
        separator: ''
      },
      css: {
        src: ['public/styles/**/*.css'],
        dest: 'public/styles/<%= pkg.name %>.css'
      }
    },

    // Watches files for changes and runs tasks based on the changed files
    watch: {
      styles: {
        files: ['public/styles/**/*.less'],
        tasks: ['less']
      }
    }
  });

  //REGISTER CALLABLE TASKS
  grunt.registerTask('test', ['karma']);

};
