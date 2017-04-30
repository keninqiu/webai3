app.controller('galleryCtrl', function ($scope,DataManager) {
	$scope.init = function() {
		DataManager.loadAll().then(function(data) {
		    $scope.products = data.product;
		    console.log($scope.products);
		    console.log(DataManager.searchText);
		    searchText = DataManager.searchText;
		    if(searchText) {
				for (i = 0; i < $scope.products.length; i++) { 
				    product = $scope.products[i];
				    name = product.name;
				    var n = name.indexOf(searchText);
				    if(n == -1) {
				    	$scope.products.splice( i, 1 );
				    }
				}		    	
		    }
		    
		});
		$scope.cart = DataManager.cart;		
	}

});