var app = angular.module('app', ['ui.bootstrap','pascalprecht.translate','ngRoute','stripe']);
app.config(['$translateProvider','$routeProvider', function($translateProvider,$routeProvider) {
    Stripe.setPublishableKey('pk_test_xVAqsYMxwh3AZfJcYu1hruyE');
    $translateProvider.useStaticFilesLoader({
        files: [{
            prefix: '/i18n/locale-',
            suffix: '.json'
        }]
    });
    //$translateProvider.preferredLanguage('zh'); 
    $translateProvider.determinePreferredLanguage(); 
    $translateProvider.useSanitizeValueStrategy('escape');

    $routeProvider
    .when("/", {
        templateUrl : "template/main.html"
    })
    .when("/category/:id", {
        templateUrl : "template/category.html"
    })  
    .when("/product/:id", {
        templateUrl : "template/product.html"
    })  
    .when("/order/:id", {
        templateUrl : "template/order.html"
    })      
    .when('/cart', {
        templateUrl: 'template/cart.html'
    })       
    ;  
}]);
