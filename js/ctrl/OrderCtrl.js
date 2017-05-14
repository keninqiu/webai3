app.controller('OrderCtrl', function ($scope,$routeParams,DataManager,paymentModal) {
  id = $routeParams.id;
  DataManager.loadOrder(id).then(function(response) {
      $scope.order = response.order;
      $scope.orderItem = response.orderItem;
  });

  $scope.$on('paidResult', function(event, data) {
  	  console.log("data in paidResult");
  	  console.log(data);
      if(data == 0) {
      	  $scope.order.status = 1;
      }
      else {
      	  $scope.order.status = -1;
      }
  });
  $scope.saveCustomer = function(status, response) {
  	console.log('response=');
  	console.log(response);
    $http.post('/save_customer', { token: response.id });
  };

  $scope.showPaymentModal = function() {
  	console.log('showPaymentModal here');
        var modalOptions = {
            closeButtonText: 'Cancel',
            order_id: id,
            actionButtonText: 'Delete Customer',
            headerText: 'Adwords account selection',
            bodyText: 'Sorry, we can not find a Google Ads account attached to this email address?  Do you want an account set up?'
        };

        paymentModal.showModal({}, modalOptions).then(function (result) {

        });
  }
});