app.controller('headerCtrl', function ($scope,DataManager) {

	$scope.cart = DataManager.cart;
 
});