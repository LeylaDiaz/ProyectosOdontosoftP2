$(document).ready(function () {
	$("#btn_generar").click(function () {
		if($("#appat").val().length < 2) {
			$("#mensaje_alerta").text("El apellido paterno debe tener al menos 2 caracteres para generar el nick.");
			$("#mensaje_alerta").attr('class', 'alerta');
		} else 
		if($("#nombre").val().length < 2) {
			$("#mensaje_alerta").text("El nombre debe tener al menos 2 caracteres para generar el nick.");
			$("#mensaje_alerta").attr('class', 'alerta');
		} else {
			$("#mensaje_alerta").text("");
			$("#mensaje_alerta").attr('class', 'no-alerta');
			nick = $("#appat").val().substring(0, 2) + $("#nombre").val().substring(0, 2) + aleatorio(10, 99);
			$("#nick").val(nick.toLowerCase());
		}
	})
});

function aleatorio(inf, sup) {
	return parseInt(inf) + Math.round(Math.random() * (sup - inf));
} 