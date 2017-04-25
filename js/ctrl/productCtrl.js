app.controller('productCtrl', function ($scope,DataManager, $routeParams) {

  DataManager.loadAll().then(function(data) {
  	  id = $routeParams.id;
  	  console.log("id="+id);
      products = data.product;
      console.log(products);
      $scope.product = products[id];
      console.log($scope.product);
  });
 
});