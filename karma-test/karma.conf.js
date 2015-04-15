// Karma configuration
// http://karma-runner.github.io/0.12/config/configuration-file.html
// Generated on 2015-01-03 using
// generator-karma 0.8.2

module.exports = function(config) {
  config.set({
    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,

    // base path, that will be used to resolve files and exclude
    basePath: '../public/',

    // testing framework to use (jasmine/mocha/qunit/...)
    frameworks: ['jasmine'],

    // list of files / patterns to load in the browser
    files: [
      "libs/ng-file-upload/angular-file-upload-shim.min.js",
      "libs/json3/lib/json3.js",
      'libs/angular/angular.js',
      'libs/angular-mocks/angular-mocks.js',
      'libs/angular-cookies/angular-cookies.js',
      'libs/angular-resource/angular-resource.js',
      'libs/angular-route/angular-route.js',
      'libs/angular-sanitize/angular-sanitize.js',
      'libs/angular-touch/angular-touch.js',
      "libs/ng-file-upload/angular-file-upload.min.js",
      "libs/jquery/dist/jquery.min.js",
      "libs/bootstrap/dist/js/bootstrap.min.js",
      "libs/d3/d3.min.js",
      'scripts/**/*.js',
      'scripts/*.js',
      'views/**/*.html',
      '../karma-test/spec/**/*.js',
    ],

    // list of files / patterns to exclude
    exclude: [],

    // web server port
    port: 8080,

    // Start these browsers, currently available:
    // - Chrome
    // - ChromeCanary
    // - Firefox
    // - Opera
    // - Safari (only Mac)
    // - PhantomJS
    // - IE (only Windows)
    browsers: [
    ],

    // Which plugins to enable
    plugins: [
      'karma-firefox-launcher',
      'karma-jasmine'
    ],

    // Continuous Integration mode
    // if true, it capture browsers, run tests and exit
    singleRun: false,

    colors: true,

    // level of logging
    // possible values: LOG_DISABLE || LOG_ERROR || LOG_WARN || LOG_INFO || LOG_DEBUG
    logLevel: config.LOG_INFO,

    // Uncomment the following lines if you are using grunt's server to run the tests
    // proxies: {
    //   '/': 'http://localhost:9000/'
    // },
    // URL root prevent conflicts with the site root
    // urlRoot: '_karma_'
  });
};
