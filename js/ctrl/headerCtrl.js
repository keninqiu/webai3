app.controller('headerCtrl', function ($scope,$rootScope,DataManager,$location) {

	$scope.cart = DataManager.cart;
 	$scope.search = function() {
		DataManager.searchText = ("text=" + $scope.searchText);
		$location.path( "/" );
 	}
});