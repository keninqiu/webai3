var app = angular.module('app', ['ui.bootstrap','pascalprecht.translate']);
app.config(['$translateProvider', function($translateProvider) {
  $translateProvider.useStaticFilesLoader({
      files: [{
          prefix: '/i18n/category/locale-',
          suffix: '.json'
      }, {
          prefix: '/i18n/product/locale-',
          suffix: '.json'
      }]
  });
  $translateProvider.preferredLanguage('en');  
  $translateProvider.useSanitizeValueStrategy('escape');
}]);
