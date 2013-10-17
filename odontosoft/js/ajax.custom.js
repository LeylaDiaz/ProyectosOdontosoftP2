var requestobject = new XMLHttpRequest();
var toidajax;

function requerimientos() {
	if (requestobject.readyState == 4) {
		if (requestobject.responseText.indexOf('invalid') == -1) {
			document.getElementById(toidajax).innerHTML = requestobject.responseText;
		} else {
			document.getElementById(toidajax).innerHTML = document.getElementById(toidajax).innerHTML;
		}
	}
}

function ajax(web, data, toid) {
	toidajax = toid;
	requestobject.open("GET", "php/ajax/" + web + ".php?random" + Math.random() + "&" + data, true);
	requestobject.onreadystatechange = requerimientos;
	requestobject.send(null);
}