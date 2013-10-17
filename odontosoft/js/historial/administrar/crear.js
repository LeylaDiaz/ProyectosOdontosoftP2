var nro = 0;

$(document).ready(function () {
	$("#jSi").click(function() {
		$("#jisOpcion").css('visibility', 'visible');
		$("#jisOpcion").css('height', 'auto');  
		$('#nro_opciones').val(nro-1);
	});
	$("#jNo").click(function() {  
		$("#jisOpcion").css('visibility', 'hidden'); 
		$("#jisOpcion").css('height', '0px'); 
		$('#nro_opciones').val('0'); 
	});
});

$(function() {
	var scntDiv = $('#p_mops');
	nro = $('#p_mops p').size() + 1;
	$('#addOpc').live('click', function() {
		$('<p><label for="p_opcs"><input autocomplete="off" required pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9 ]{1,500}$" type="text" id="p_opc" size="20" name="opcion_' + nro +'" value="" placeholder="Nueva opción" /></label> <a href="#" id="remScnt">Eliminar</a></p>').appendTo(scntDiv);
		nro++;
		$('#nro_opciones').val(nro-1);
		return false;
	});

	$('#remScnt').live('click', function() {
		if(nro > 2) {
			$(this).parents('p').remove();
		}
		return false;
	});
});