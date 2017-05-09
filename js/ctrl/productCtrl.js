app.controller('productCtrl', function ($scope,$routeParams,DataManager) {

  DataManager.loadAll().then(function(data) {
  	  id = $routeParams.id;
      products = data.product;
      for(i=0;i<products.length;i++) {
        product = products[i];
        if(product.id == id) {
          $scope.product = product;
          break;
        }
      }
      side_path = $scope.product.side_path;
      if(side_path&&side_path.length>0) {
      	side_path[0].active="active";
      }
      
  });

$scope.active1 = "active";
$scope.setActive = function(item) {
	side_path = $scope.product.side_path;
	for (i = 0; i < side_path.length; i++) { 
	    side_path[i].active="";
	}	
    item.active="active";
}
$scope.quantity = 1;
$scope.cart = DataManager.cart;
});