app.factory('DataManager', ['$http', '$q',  function($http, $q) {  
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
        store: myStore, 
        cart: myCart,
        searchText:''

    };
    return dataManager;
}]);