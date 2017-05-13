app.controller('OrderCtrl', function ($scope,$routeParams,DataManager) {
  id = $routeParams.id;
  DataManager.loadOrder(id).then(function(response) {
      $scope.order = response.order;
      $scope.orderItem = response.orderItem;
  });

  $scope.saveCustomer = function(status, response) {
    $http.post('/save_customer', { token: response.id });
  };
  
});