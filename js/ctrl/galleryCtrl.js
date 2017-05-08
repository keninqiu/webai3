app.controller('galleryCtrl', function ($scope,$rootScope,DataManager) {

	$scope.DataManager = DataManager;
  	$scope.$watch('DataManager.searchText', function (newVal, oldVal, scope) {
	    if(newVal) { 
	      $scope.searchText = newVal;
	    }
	});

	DataManager.loadAll().then(function(data) {
		console.log("data=");
		console.log(data);
		$scope.products = data.product;

		    
	});
	$scope.cart = DataManager.cart;		

	$scope.filterFunction = function(element) {
		if(!$scope.searchText) {
			return true;
		}

		category_id = $scope.searchText.category_id;
		
		if(category_id) {
			categories = element.categories;
			for(i=0;i<categories.length;i++) {
				category = categories[i];
				if(category.category_id == category_id) {
					return true;
				}
			}
			return false;
		}

		text = $scope.searchText.text;

		if(text) {
			$pos = element.keywords.indexOf(text);
			if($pos < 0) {
				return false;
			}
			return true;
		}

		return true;
	};
});