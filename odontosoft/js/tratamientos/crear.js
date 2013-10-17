function moneda(cantidad) {
	var val = parseFloat(cantidad); 
	if (isNaN(val)) return "0.00";
	if (val <= 0) return "0.00"; 
	val += "";
	if (val.indexOf('.') == -1) { return val+".00"; } else { val = val.substring(0,val.indexOf('.')+3); } 
	val = (val == Math.floor(val)) ? val + '.00' : ((val*10 == Math.floor(val*10)) ? val + '0' : val); 
	return val; 
}