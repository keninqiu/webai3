function cartItem(sku, name, price, quantity) { 
	this.sku = sku; 
	this.name = name; 
	this.price = price * 1; 
	this.quantity = quantity * 1; 
}


function shoppingCart(cartName) { 
	//http://mrbool.com/angularjs-creating-a-shopping-cart-application/32183
	this.cartName = cartName; 
	this.clearCart = false; 
	this.checkoutParameters = {}; 
	this.items = []; 
	this.loadItems(); 
	var self = this; 
	/*
	$(window).unload(function () { 
		if (self.clearCart) { self.clearItems(); } 
		self.saveItems(); 
		self.clearCart = false;
	}); 
	*/
}

shoppingCart.prototype.addItem = function (sku,name,price,quantity) {
	item = new cartItem(sku, name, price, quantity); 
	this.items.push(item); 
}

shoppingCart.prototype.loadItems = function () { 
	var items = localStorage != null ? localStorage[this.cartName + "_items"] : null; 
	if (items != null && JSON != null) { 
		try { 
			var items = JSON.parse(items); 
			for (var i = 0; i < items.length; i++) { 
				var item = items[i]; 
				if (item.sku != null && item.name != null && item.price != null && item.quantity != null) { 
					item = new cartItem(item.sku, item.name, item.price, item.quantity); 
					this.items.push(item); 
				} 
			} 
		} catch (err) {
		} 
	} 
} 
shoppingCart.prototype.saveItems = function () { 
	if (localStorage != null && JSON != null) { 
		localStorage[this.cartName + "_items"] = JSON.stringify(this.items); 
	} 
}

shoppingCart.prototype.getTotalPrice = function (sku) { 
	var total = 0; 
	for (var i = 0; i < this.items.length; i++) { 
		var item = this.items[i]; 
		if (sku == null || item.sku == sku) { 
			total += this.toNumber(item.quantity * item.price); 
		} 
	} 
	return total; 
} 
shoppingCart.prototype.getTotalCount = function (sku) { 
	var count = 0; 
	for (var i = 0; i < this.items.length; i++) { 
		var item = this.items[i]; 
		if (sku == null || item.sku == sku) { 
			count += this.toNumber(item.quantity); 
		} 
	} 
	return count; 
}

shoppingCart.prototype.clearItems = function () { 
	this.items = []; 
	this.saveItems(); 
}

shoppingCart.prototype.addCheckoutParameters = function (serviceName, merchantID, options) { 
	if (serviceName != "PayPal") { 
		throw "Name of the service must be 'PayPal'."; 
	} 
	if (merchantID == null) { 
		throw " Need merchantID in order to checkout."; 
	} 
	//this.checkoutParameters[serviceName] = new checkoutParameters(serviceName, merchantID, options); 
} 

shoppingCart.prototype.checkout = function (serviceName, clearCart) { 
	if (serviceName == null) { 
		var p = this.checkoutParameters[Object.keys(this.checkoutParameters)[0]]; 
		serviceName = p.serviceName; 
	} 
	if (serviceName == null) { 
		throw "Use the 'addCheckoutParameters' method to define at least one checkout service."; 
	} 
	var parms = this.checkoutParameters[serviceName]; 
	if (parms == null) { 
		throw "Cannot get checkout parameters for '" + serviceName + "'."; 
	} 
	switch (parms.serviceName) { 
		case "PayPal": 
			this.checkoutPayPal(parms, clearCart); 
			break; 
		default: 
			throw "Unknown checkout service: " + parms.serviceName; 
	} 
}

shoppingCart.prototype.checkoutPayPal = function (parms, clearCart) { 
	var data = { 
		cmd: "_cart", business: parms.merchantID, upload: "1", rm: "2", charset: "utf-8" 
	}; 
	for (var i = 0; i < this.items.length; i++) { 
		var item = this.items[i]; 
		var ctr = i + 1; 
		data["item_number_" + ctr] = item.sku; 
		data["item_name_" + ctr] = item.name; 
		data["quantity_" + ctr] = item.quantity; 
		data["amount_" + ctr] = item.price.toFixed(2); 
	} 
	var form = $('<form/></form>'); 
	form.attr("action", "https://www.paypal.com/cgi-bin/webscr"); 
	form.attr("method", "POST"); form.attr("style", "display:none;"); 
	this.addFormFields(form, data); 
	this.addFormFields(form, parms.options); 
	$("body").append(form); 

	this.clearCart = clearCart == null || clearCart; 
	form.submit(); 
	form.remove(); 
}

shoppingCart.prototype.addFormFields = function (form, data) { 
	if (data != null) { 
		$.each(data, function (name, value) { 
			if (value != null) { 
				var input = $("<input></input>").attr("type", "hidden").attr("name", name).val(value); 
				form.append(input); 
			} 
		}); 
	} 
} 
shoppingCart.prototype.toNumber = function (value) { 
	value = value * 1; 
	return isNaN(value) ? 0 : value; 
}

