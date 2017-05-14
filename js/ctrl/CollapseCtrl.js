app.controller('CollapseCtrl', function ($scope,DataManager,$translate) {
  $scope.isNavCollapsed = true;
  $scope.isCollapsed = false;
  $scope.isCollapsedHorizontal = false;
  //$scope.selectedLang = 'zh';

  DataManager.loadAll().then(function(data) {
      console.log(data);
      $scope.category = data.category;
      lang_use = $translate.use().trim();
      if(!lang_use || ["zh","zh_CN","en","en_US"].indexOf(lang_use) < 0) {
        $scope.changeLang('en');
      }      
  });
  $scope.changeLang = function(lang) {
  	$translate.use(lang);
    DataManager.language = lang;
  }

  $scope.index = function() {
    DataManager.searchText = {};
  }

  $scope.showCategory = function(id) {
    DataManager.searchText = {category_id:id};
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