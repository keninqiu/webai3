app.service('paymentModal', ['$uibModal','DataManager','$rootScope',
    function ($uibModal,DataManager,$rootScope) {

        var modalDefaults = {
            backdrop: true,
            keyboard: true,
            modalFade: true,
            templateUrl: '/template/modal/payment_modal.html'
        };

        var modalOptions = {
            closeButtonText: 'Close',
            actionButtonText: 'OK',
            headerText: 'Proceed?',
            bodyText: 'Perform this action?'
        };

        this.showModal = function (customModalDefaults, customModalOptions) {
            if (!customModalDefaults) customModalDefaults = {};
            customModalDefaults.backdrop = 'static';
            return this.show(customModalDefaults, customModalOptions);
        };

        this.saveCustomer = function(status, response) {
            console.log('response=');
            console.log(response);

            //$http.post('/save_customer', { token: response.id });
          };
        this.show = function (customModalDefaults, customModalOptions) {
            //Create temp objects to work with since we're in a singleton service
            var tempModalDefaults = {};
            var tempModalOptions = {};

            //Map angular-ui modal custom defaults to modal defaults defined in service
            angular.extend(tempModalDefaults, modalDefaults, customModalDefaults);

            //Map modal.html $scope custom properties to defaults defined in service
            angular.extend(tempModalOptions, modalOptions, customModalOptions);

            if (!tempModalDefaults.controller) {
                tempModalDefaults.controller = function ($scope, $uibModalInstance) {
                    $scope.modalOptions = tempModalOptions;
                    $scope.modalOptions.ok = function (result) {
                        $uibModalInstance.close(result);
                    };
                    $scope.modalOptions.pay = function(result) {
                        number = $scope.number;
                        exp_year = $scope.exp_year;
                        exp_month = $scope.exp_month;
                        cvc = $scope.cvc;
                        order_id = customModalOptions.order_id;
                        currency = "cad";
                        DataManager.payOrder(number,exp_year,exp_month,cvc,order_id,currency)
                        .then(function (response) {
                            console.log("response===");
                            console.log(response);
                            data = response.data;
                            if(!data || data.state != 0) {
                                $scope.modalOptions.errorMsg = data.msg;
                            }
                            else {
                                $rootScope.$broadcast('paidResult', 0);
                                $uibModalInstance.dismiss('cancel');
                            }
                        });
                      };                   
                    $scope.modalOptions.close = function (result) {
                        $rootScope.$broadcast('paidResult', -1);
                        $uibModalInstance.dismiss('cancel');
                    };
                }
            }

            return $uibModal.open(tempModalDefaults).result;
        };

    }]);