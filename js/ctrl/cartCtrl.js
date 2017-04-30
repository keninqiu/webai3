app.controller('cartCtrl', function ($scope,$routeParams,DataManager) {

	$scope.store = DataManager.store;
	$scope.cart = DataManager.cart;
	if($routeParams.productSku != null) {
		$scope.product = $scope.store.getProduct($routeParams.productSku);
	}
 
});