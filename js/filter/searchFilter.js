  app.filter('searchFilter', function() {
    return function(input,searchText) {
    	//console.log('searchText='+searchText);
    	if(!searchText) {
    		return input;
    	}
    	//console.log('input=');
    	//console.log(input);
    	var arr = Object.values(input);
		var arrayLength = arr.length;
		//console.log('arrayLength='+arrayLength);
		var newArray = [];
		for (var i = 0; i < arrayLength; i++) {
		    item = arr[i];
		    //console.log('item.name='+item.name);
		    if(item.name.indexOf(searchText) >= 0) {
		    	newArray.push(item);
		    }
		}    	
        return newArray;
    };
  });