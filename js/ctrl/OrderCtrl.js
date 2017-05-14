app.controller('OrderCtrl', function ($scope,$routeParams,DataManager,paymentModal) {
	console.log("begin OrderCtrl");

	  id = $routeParams.id;
	console.log("id==="+id);
	  DataManager.loadOrder(id).then(function(response) {
	      $scope.order = response.order;
	      console.log("order ==== ");
	      console.log($scope.order);
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
            order_id: id        
        };

        paymentModal.showModal({}, modalOptions).then(function (result) {

        });
  }

  $scope.onError = function (err) {
  	console.log('onError');
  };
  $scope.onStream = function (stream) {
  	console.log('onStream');
  };
  $scope.onSuccess = function () {
  	console.log('onSuccess');
  };  
});