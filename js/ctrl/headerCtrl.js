app.controller('headerCtrl', function ($scope,DataManager,$location) {

	$scope.cart = DataManager.cart;
 	$scope.search = function() {
 		var searchText = $scope.searchText;
		DataManager.searchText = searchText;
		$location.path( "/" );		
 	}
});