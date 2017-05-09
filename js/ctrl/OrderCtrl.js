app.controller('OrderCtrl', function ($scope,$routeParams,DataManager) {
  id = $routeParams.id;
  DataManager.loadOrder(id).then(function(response) {
      $scope.order = response.order;
      $scope.orderItem = response.orderItem;
  });

});