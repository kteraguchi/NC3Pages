// Karma configuration
// Generated on Fri May 09 2014 18:33:30 GMT+0900 (JST)


/**
 * Karma configuration
 *
 * @param {object} config configuration
 */
module.exports = function(config) {
  config.set({

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',


    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['jasmine'],


    // list of files / patterns to load in the browser
    files: [
      '../../NetCommons/webroot/angular/angular.js',
      '../../NetCommons/webroot/jquery/jquery.min.js',
      '../../NetCommons/webroot/angular-bootstrap/ui-bootstrap.min.js',
      '../../NetCommons/webroot/base/js/base.js',
      '../../NetCommons/webroot/angular-ui-tinymce/src/tinymce.js',
      '../../../../vendors/bower_components/angular-mocks/angular-mocks.js',
      '../webroot/js/pages.js',
      'spec/javascripts/pages.spec.js'
    ],


    // list of files to exclude
    exclude: [

    ],


    // preprocess matching files before serving them to the browser
    // available preprocessors:
    //                   　　https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
      '../webroot/js/*.js': 'coverage'
    },


    // test results reporter to use
    // possible values: 'dots', 'progress'
    // available reporters: https://npmjs.org/browse/keyword/karma-reporter
    reporters: ['progress', 'coverage'],


    // web server port
    port: 9876,


    // enable / disable colors in the output (reporters and logs)
    colors: true,


    // level of logging
    // possible values:
    //     config.LOG_DISABLE ||
    //     config.LOG_ERROR ||
    //     config.LOG_WARN ||
    //     config.LOG_INFO ||
    //     config.LOG_DEBUG
    logLevel: config.LOG_INFO,
    //logLevel: config.LOG_DEBUG,


    // enable / disable watching file and
    //   executing tests whenever any file changes
    autoWatch: true,


    // start these browsers
    // available browser launchers:
    //                        https://npmjs.org/browse/keyword/karma-launcher
    // browsers: ['Firefox','PhantomJS'],
    browsers: ['PhantomJS'],


    // Continuous Integration mode
    // if true, Karma captures browsers, runs the tests and exits
    singleRun: false,

    // optionally, configure the reporter
    coverageReporter: {
      type: 'html',
      dir: 'coverage/'
    }
  });
};
