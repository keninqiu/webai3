app.controller('cartCtrl', function ($scope,$routeParams,DataManager,$route) {

	$scope.store = DataManager.store;
	$scope.cart = DataManager.cart;
	if($routeParams.productSku != null) {
		$scope.product = $scope.store.getProduct($routeParams.productSku);
	}
 	
 	$scope.confirm = function() {
 		data = $scope.cart.confirm();
 		DataManager.confirmOrder(data);

 		$route.reload();
 		console.log(data);
 	}
});