app.controller('galleryCtrl', function ($scope,$rootScope,DataManager) {

	$scope.DataManager = DataManager;
  	$scope.$watch('DataManager.searchText', function (newVal, oldVal, scope) {
	    if(newVal) { 
	      $scope.searchText = newVal;
	    }
	});

	DataManager.loadAll().then(function(data) {
		$scope.products = data.product;
		    
	});
	$scope.cart = DataManager.cart;		

});