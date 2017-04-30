
function store() 
{ 
	this.rings = [ 
		new product("rings1", "Halo", "Classic-C905R7", 25), 
		new product("rings2", "Gemstone", "Classic-C904P5", 30), 
		new product("rings3", "Pave", "Classic-939R7", 18), 
		new product("rings4", "Cathedral", "Classic-938R7", 32), 
		new product("rings5", "Vintage", "OClassic-918CU7", 24), 
		new product("rings6", "Channel-Set", "Classic-924R7", 11), 
		new product("rings7", "Swirl", "Classic-917R7", 16), 
		new product("rings8", "Bezel", "Classic-916R7", 20), 
		new product("rings9", "Prong", "Classic-916R6", 10), 
		new product("rings10", "Emerald", "Classic-912RD7", 26), 
		new product("rings11", "Pear", "Classic-911RD7", 8), 
		new product("rings13", "Cushion", "Classic-916RD6", 5), 
		new product("rings14", "Princess", "Classic-910R7", 19) 
	]; 
} 
store.prototype.getProduct = function (sku) { 
	for (var i = 0; i < this.rings.length; i++) { 
		if (this.rings[i].sku == sku) return this.rings[i]; 
	} 
	return null; 
}
