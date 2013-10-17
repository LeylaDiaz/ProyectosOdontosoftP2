var contador = -1; // Contador de tratamientos
var costo_final = 0;
var tiempo_total = "00:00";
var t_nombre = new Array();
var t_tiempo = new Array();
var t_costor = new Array();

function moneda(cantidad) {
	var val = parseFloat(cantidad); 
	if (isNaN(val)) return "0.00";
	if (val <= 0) return "0.00"; 
	val += "";
	if (val.indexOf('.') == -1) { return val+".00"; } else { val = val.substring(0,val.indexOf('.')+3); } 
	val = (val == Math.floor(val)) ? val + '.00' : ((val*10 == Math.floor(val*10)) ? val + '0' : val); 
	return val; 
}

/* AJAX - Funciones PURAS Javascript para reconocimiento de datos (JQUERY => BUG!!!) */
function validarcosto() {
	if(document.getElementById('t_costo').value <= 0) {
		document.getElementById('mensaje_alerta').className = "error";
		document.getElementById('mensaje_alerta').innerHTML = "El costo del tratamiento no puede ser menor o igual a <? echo $website_dinero; ?> 0.00.";
		window.scrollTo(0, 0);
	} else {
		/* Costo aceptado */
		document.getElementById('mensaje_alerta').className = "no-alerta";
		document.getElementById('mensaje_alerta').innerHTML = "";
		t_nombre.push($("#t_nombre").val());
		t_tiempo.push($("#t_tiempo").val());
		t_costor.push($("#t_costo").val());
		contador++;
		var row = "<tr id='tr_" + contador + "'><td>" + t_nombre[contador] + "</td><td>" + t_tiempo[contador] + "</td><td style='text-align: right;' >" + t_costor[contador] + "</td><td><a href='#' onclick='eliminar(" + contador + ")'>Eliminar</a></td></tr>";
		costo_final = moneda(parseInt(costo_final) + parseInt(t_costor[contador])); // Actualizamos el costo
		/* I - Sumar HORAS */
		var dot1 = tiempo_total.indexOf(":");
		var dot2 = t_tiempo[contador].indexOf(":");
		var m1 = tiempo_total.substr(0, dot1);
		var m2 = t_tiempo[contador].substr(0, dot2);
		var s1 = tiempo_total.substr(dot1 + 1);
		var s2 = t_tiempo[contador].substr(dot2 + 1);
		var sRes = (Number(s1) + Number(s2));
		var mRes;
		var addMinuto = false;
		if (sRes >= 60) {
			addMinuto = true;
			sRes -= 60;
		}
		mRes = (Number(m1) + Number(m2) + (addMinuto? 1: 0));
		tiempo_total = horas(String(mRes),2) + ":" + minutos(String(sRes),2);
		/* F - Sumar HORAS */
		$("#tratamientos-escojidos").append(row);
		$('#tiempo-final').text(tiempo_total);
		$('#costo-final').text(costo_final);
	}
}

function horas(string, len) {
	if (string.length <len) {
		addchar=(len - string.length) ;
		for (i = 0; i < addchar; i++) {
			string = "0" + string;
		}
	}
	if (string.length > len) {
		string = substr(string,0,len);
	}
	return string;
}

function minutos(string, len) {
	if (string.length < len) {
		addchar=(len - string.length) ;
		for (i = 0; i <addchar; i++) {
			string = string + "0";
		}
	}
	if (string.length > len) {
		string=substr(string,0,len);
	}
	return string;
}

function eliminar(num) {
	$('#tr_' + num).remove();
	costo_final = moneda(parseInt(costo_final) - parseInt(t_costor[num]));
	/* I - Restar HORAS */
	var dot1 = tiempo_total.indexOf(":");
	var dot2 = t_tiempo[num].indexOf(":");
	var m1 = tiempo_total.substr(0, dot1);
	var m2 = t_tiempo[num].substr(0, dot2);
	var s1 = tiempo_total.substr(dot1 + 1);
	var s2 = t_tiempo[num].substr(dot2 + 1);
	if(s2 == 30 && s1 == 0) {
		var sRes = (Number(30));
		var mRes = (Number(m1) - Number(m2) - Number(1));
	} else {
		var sRes = (Number(s1) - Number(s2));
		var mRes = (Number(m1) - Number(m2));
	}
	tiempo_total = horas(String(mRes),2) + ":" + minutos(String(sRes),2);
	/* F - Restar HORAS */
	$('#tiempo-final').text(tiempo_total);
	$('#costo-final').text(costo_final);
	t_nombre[num] = "";
	t_tiempo[num] = "";
	t_costor[num] = "";
}

function validar_formulario(formulario) {
	if(costo_final <= 0) {
		document.getElementById('mensaje_alerta').className = "alerta";
		document.getElementById('mensaje_alerta').innerHTML = "El sistema no ha detectado tratamientos selecionados para ésta cita.";
		window.scrollTo(0, 0);
		return(false);
	}
	if(tiempo_total == "00:00") {
		document.getElementById('mensaje_alerta').className = "alerta";
		document.getElementById('mensaje_alerta').innerHTML = "El sistema no ha detectado tratamientos selecionados para ésta cita.";
		window.scrollTo(0, 0);
		return(false);
	}
	if(formulario.fecha_final.value == "") {
		document.getElementById('mensaje_alerta').className = "alerta";
		document.getElementById('mensaje_alerta').innerHTML = "No se ha seleccionado una fecha y hora para la atención de la cita.";
		window.scrollTo(0, 0);
		return(false);
	}
	$('#ajax-costo_final').val($('#costo-final').text());
	$('#ajax-tiempo_final').val($('#tiempo-final').text());
	var tratamiento_bd = "";
	for(var i = 0; i < t_nombre.length; i++) {
		if(t_nombre[i] != "") {
			tratamiento_bd = t_nombre[i] + "|" + tratamiento_bd;
		}
	}
	$('#ajax-tratamientos_final').val(tratamiento_bd);
}