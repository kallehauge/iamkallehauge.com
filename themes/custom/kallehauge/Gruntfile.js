module.exports = function (grunt) {
  "use strict";

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        sourceMap: true,
        outputStyle: 'expanded'
      },
      dist: {
        files: [{
          expand: true,
          cwd: 'sass',
          src: ['*.scss', '**/*.scss'],
          dest: 'css',
          ext: '.css',
          extDot: 'last'
        }],
        options: {
          includePaths: require('node-bourbon').includePaths
        }
      }
    },

    watch: {
      scss: {
        files: ['sass/*.scss', 'sass/**/*.scss'],
        tasks: ['sass']
      },

      css: {
        files: ['css/*.css']
      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', [
    'sass',
    'watch'
  ]);

  grunt.registerTask('build', [
    'sass'
  ]);
};
