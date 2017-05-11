app.factory('DataManager', ['$http', '$q','$location','$translate',  function($http, $q,$location,$translate) {  
var myStore = new store(); 
var myCart = new shoppingCart("MyStore"); 
myCart.addCheckoutParameters("PayPal", "abc@gmail.com");

    var dataManager = {
        _pool: {},
        deferred: false,
        deferredOrder: false,
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
        loadOrder: function(id) {
            console.log("id="+id);
            var scope = this;
            url = '/admin/order/detail?id='+id;
            console.log(url);

            if(!scope.deferredOrder) {
                scope.deferredOrder = $q.defer();
                $http.get(url)
                   .then(function(res){
                      console.log("return from jsonabce");
                      data = res.data;  
                      console.log(data);
                      scope.deferredOrder.resolve(data);      
                    });  
            }
            return scope.deferredOrder.promise;

        },
        getPrice: function(product) {
            var scope = this;
            if(!product) {
                return 0;
            }
            if(scope.language == 'zh_CN' || scope.language == 'zh') {
                return product.price_rmb;
            }
            return product.price;
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
        language: $translate.use(),
        searchText:{}

    };
    return dataManager;
}]);