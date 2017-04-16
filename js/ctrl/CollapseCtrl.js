app.controller('CollapseCtrl', function ($scope,$http) {
  $scope.isNavCollapsed = true;
  $scope.isCollapsed = false;
  $scope.isCollapsedHorizontal = false;
  $http.get('json/category.json')
       .then(function(res){
          $scope.category = res.data;     
          console.log($scope.category);           
        });  
});