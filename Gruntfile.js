module.exports = function(grunt) {
	require('time-grunt')(grunt);

	grunt.initConfig({
		sass: {
			dist: {
				files: {
					'style.css': 'scss/style.scss'
				}
			}
		},
		watch: {
			css: {
				files: 'scss/**/*.scss',
				tasks: ['sass']
			},
		},
		browser_sync: {
			dev: {
				bsFiles: {
					src: [
					'style.css',
					'img/**/*',
					'*.php',
					'functions/*.php',
					'js/**/*.js',
					'views/**/*.twig'
					]
				},
				options: {
					watchTask: true,
					host: process.env.DEV_URL,
					proxy: {
						host: "CHANGEME." + process.env.DEV_URL
					}
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-browser-sync');

	grunt.registerTask('default', ['browser_sync', 'watch']);

	
};
