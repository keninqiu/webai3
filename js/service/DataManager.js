app.factory('DataManager', ['$http', '$q','$location',  function($http, $q,$location) {  
var myStore = new store(); 
var myCart = new shoppingCart("MyStore"); 
myCart.addCheckoutParameters("PayPal", "abc@gmail.com");

    var dataManager = {
        _pool: {},
        deferred: false,
        loadAll: function() {
        	var scope = this;
        	if(!scope.deferred) {
            	scope.deferred = $q.defer();
			    $http.get('json/data.json')
			       .then(function(res){
			       	  console.log("return from json");
			          data = res.data;  
			          scope.deferred.resolve(data);      
			        });  
		    }
            return scope.deferred.promise;
        },
        confirmOrder: function(data) {


            url = "/admin/order/confirm";

            $http({
                method: 'POST',
                url: url,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                transformRequest: function(obj) {
                    var str = [];
                    for(var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    return str.join("&");
                },
                data: data
            }).then(function (response) {
                console.log(response.data);
                order_id = response.data.order_id;
                orderUrl =  "/order/"+ order_id;
                console.log(orderUrl);
                $location.path(orderUrl);
            });             
        },
        store: myStore, 
        cart: myCart,
        searchText:{}

    };
    return dataManager;
}]);