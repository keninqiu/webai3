app.directive('gallery', function(DataManager) { 	
	  return {
	    restrict: 'E',
	    scope: {
	      productInfo: '=info'
	    },  	
	    templateUrl: 'template/gallery.html'
	  };
});