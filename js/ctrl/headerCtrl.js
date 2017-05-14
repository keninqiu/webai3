app.controller('headerCtrl', function ($scope,$rootScope,DataManager,$location,$translate) {

	$scope.cart = DataManager.cart;
 	$scope.search = function() {
		DataManager.searchText = {text:$scope.searchText};
		$location.path( "/" );
 	}

 	$scope.lang_use = $translate.use();
});