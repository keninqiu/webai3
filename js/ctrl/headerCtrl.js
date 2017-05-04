app.controller('headerCtrl', function ($scope,$rootScope,DataManager,$location) {

	$scope.cart = DataManager.cart;
 	$scope.search = function() {
		DataManager.searchText = $scope.searchText;
		$location.path( "/" );
 	}
});