app.controller('CollapseCtrl', function ($scope,DataManager) {
  $scope.isNavCollapsed = true;
  $scope.isCollapsed = false;
  $scope.isCollapsedHorizontal = false;

  DataManager.loadAll().then(function(data) {
      console.log(data);
      $scope.category = data.category;
  });
 
});