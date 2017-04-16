var app = angular.module('app', ['ui.bootstrap','pascalprecht.translate','ngRoute']);
app.config(['$translateProvider','$routeProvider', function($translateProvider,$routeProvider) {
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

    $routeProvider
    .when("/", {
        templateUrl : "main.html"
    })
    .when("/women", {
        templateUrl : "women.html"
    })
    .when("/children", {
        templateUrl : "children.html"
    })
    .when("/men", {
        templateUrl : "men.html"
    })
    .when("/groupon", {
        templateUrl : "groupon.html"
    })    
    ;  
}]);
