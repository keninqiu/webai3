app.controller('productCtrl', function ($scope,DataManager, $routeParams) {

  DataManager.loadAll().then(function(data) {
  	  id = $routeParams.id;
  	  console.log("id="+id);
      products = data.product;
      console.log(products);
      $scope.product = products[id];
      console.log($scope.product);
      side_path = $scope.product.side_path;
      side_path[0].active="active";
  });

$scope.active1 = "active";
$scope.setActive = function(item) {
	side_path = $scope.product.side_path;
	for (i = 0; i < side_path.length; i++) { 
	    side_path[i].active="";
	}	
    item.active="active";
}
 
});