var tiempo = 5;

$(document).ready(function () {
	setTimeout(function () {
		location.href='?sitio=TXc9PQ==';
	}, tiempo * 1000 + 500);
	setInterval(function () {
		if(tiempo > 0) {
			tiempo--;
			$("#tiempo").text(tiempo);
		}
	}, 1000);
});