app.controller('galleryCtrl', function ($scope,DataManager) {

  DataManager.loadAll().then(function(data) {
      $scope.products = data.product;
      console.log("info===");
      console.log($scope.info);
  });
 
});