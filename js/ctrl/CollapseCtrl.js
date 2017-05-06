app.controller('CollapseCtrl', function ($scope,DataManager,$translate) {
  $scope.isNavCollapsed = true;
  $scope.isCollapsed = false;
  $scope.isCollapsedHorizontal = false;
  $scope.selectedLang = 'zh';
  DataManager.loadAll().then(function(data) {
      console.log(data);
      $scope.category = data.category;
  });
  $scope.changeLang = function(lang) {
  	$translate.use(lang);
  	$scope.selectedLang = lang;
  }

  $scope.index = function() {
    DataManager.searchText = '';
  }

  $scope.showCategory = function(id) {
    DataManager.searchText = 'category_id='+id;
  }

  $scope.items = [
    'zh',
    'en'
  ];

  $scope.status = {
    isopen: false
  };

  $scope.toggled = function(open) {
    $log.log('Dropdown is now: ', open);
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };

  $scope.appendToEl = angular.element(document.querySelector('#dropdown-long-content'));  

  
});