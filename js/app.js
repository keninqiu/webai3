var app = angular.module('app', ['ui.bootstrap','pascalprecht.translate','ngRoute']);
app.config(['$translateProvider','$routeProvider', function($translateProvider,$routeProvider) {
    $translateProvider.useStaticFilesLoader({
        files: [{
            prefix: '/i18n/category/locale-',
            suffix: '.json'
        }, {
            prefix: '/i18n/product/locale-',
            suffix: '.json'
        }, {
            prefix: '/i18n/setting/locale-',
            suffix: '.json'
        }]
    });
    $translateProvider.preferredLanguage('zh');  
    $translateProvider.useSanitizeValueStrategy('escape');

    $routeProvider
    .when("/", {
        templateUrl : "template/main.html"
    })
    .when("/category/:id", {
        templateUrl : "template/category.html"
    })  
    ;  
}]);
