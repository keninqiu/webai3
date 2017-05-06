  app.filter('searchFilter', function() {
    return function(input,searchText) {
    	//console.log('searchText='+searchText);

    	if(!searchText) {
    		return input;
    	}
        var res = searchText.split(";");
        var length = res.length;
        if(length == 0) {
            return input;
        }
        var textCondition = '';
        var categoryIdCondition = 0;
        for (i = 0; i < length; i++) {
            condition = res[i];
            conditionArray = condition.split("=");
            conditionLengh = conditionArray.length;
            if(conditionLengh != 2) {
                continue;
            }
            conditionName = conditionArray[0];
            conditionValue = conditionArray[1];
            if(conditionName == "text") {
                textCondition = conditionValue;
            }
            else if(conditionName == "category_id") {
                categoryIdCondition = conditionValue;
            }
        }
        console.log("textCondition="+textCondition);
        console.log("categoryIdCondition="+categoryIdCondition);
    	//console.log('input=');
    	//console.log(input);
    	var arr = Object.values(input);
		var arrayLength = arr.length;
		//console.log('arrayLength='+arrayLength);
		var newArray = [];
		for (var i = 0; i < arrayLength; i++) {
		    item = arr[i];
		    //console.log('item.name='+item.name);
            if(textCondition) {
                if(item.name.indexOf(textCondition) >= 0) {
                    newArray.push(item);
                }                
            }
            if(categoryIdCondition) {
                categories = item.categories;
                if(categories) {
                    categoriesLength = categories.length;
                    for(j=0;j<categoriesLength;j++) {
                        item = categories[j];
                        console.log("item===");
                        console.log(item);
                        console.log(item.category_id);
                        console.log(categoryIdCondition);
                        if(item.category_id == categoryIdCondition) {
                            newArray.push(item);
                        }
                    }                    
                }

            }

		}    	
        return newArray;
    };
  });