<?php
permiso_secretaria();
// Permisos:
include('./php/clases/Tratamiento.class.php');
include('./php/clases/Paciente.class.php');
include('./php/clases/Cita.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
// Incluimos las clases necesarias:
$obj_tratamiento = Tratamiento::getInstancia();
$obj_paciente = Paciente::getInstancia();

if(isset($_POST['submit'])) {
	$obj_cita = Cita::getInstancia();
	if($obj_cita->crearTratamiento($_POST['paciente'], $_POST['tratamientos_final'], $_POST['tiempo_final'], $_POST['fecha_final'], $_POST['costo_final'])) {
		$alerta_tipo = $obj_cita->getAlerta();
		$alerta_mensaje = $obj_cita->getMensaje();
		$_POST = null; // Limpiamos cajas de Texto.
	} else {
		$alerta_tipo = $obj_cita->getAlerta();
		$alerta_mensaje = $obj_cita->getMensaje();
	}
}

/* AJAX - Paciente */
$consulta = $obj_paciente->getAllFromPacienteAJAX();
while($row = mysql_fetch_array($consulta)) {
	$nombre_paciente[] = '"'.$row['nombre'].'"';
}
$array_pacientes = implode(", ", $nombre_paciente);
/* AJAX - Tratamiento */
$consulta = $obj_tratamiento->getAllFromTratamientoAJAX();
while($row = mysql_fetch_array($consulta)) {
	$nombre_tratamiento[] = '"'.$row['nombre'].'"';
}
$array_tratamiento = implode(", ", $nombre_tratamiento);
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/jquery.custom.min.js" type="text/javascript"></script>
		<script src="./js/ajax.custom.js" type="text/javascript"></script>
		<script src="./js/cita/crear.js" type="text/javascript"></script>
		<script>
		$(document).ready(function() {
			/* AJAX - Paciente */
			var pacientes = new Array(<?php echo $array_pacientes; ?>);
			$("#paciente").autocomplete({
				source: pacientes
			});
			/* AJAX - Tratamiento */
			var tratamientos = new Array(<?php echo $array_tratamiento; ?>);
			$("#tratamiento").autocomplete({
				source: tratamientos
			});
			/* Data - Tratamiento: Recupera tratamiento mediante AJAX. */
			$("#btn-tratamiento").click(function() {
				vardata = 'tratamiento=' + $("#tratamiento").val();
				ajax('citas/crear', vardata, 'data-tratamiento');
			});
			/* Data - Tratamiento: Recupera tratamiento mediante AJAX. */
			$("#btn-horarios").click(function() {
				vardata = 'tiempo=' + $("#fecha").val();
				ajax('citas/crear', vardata, 'horarios-recomendados');
			});
		});
		</script>
	</head>
	<body>
		<form action="?sitio=<?php echo toUrl(20); ?>" method="post" onSubmit="return validar_formulario(this);">
			<div id="navegador"><?php echo $website_ruta; ?></div>
			<div id="mensaje_alerta" class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>
			<fieldset style="float: left; margin-top: 0px;">
				<legend>Datos del tratamiento</legend>
				<br />
				Nombre del paciente:
				<br />
				<input id="paciente" onclick="this.value = ''" size="30" maxlength="150" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,150}$" placeholder="Nombre completo del paciente" required autocomplete="off" type="text" name="paciente" value="<?php printf($_POST['paciente']); ?>" />
				<br />
				<br />
				Tratamiento:
				<br />
				<input id="tratamiento" onclick="this.value = ''" size="30" maxlength="150" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,150}$" placeholder="Tratamiento a aplicar" autocomplete="off" type="text" name="tratamiento" value="<?php printf($_POST['tratamiento']); ?>" /> 
				<input id="btn-tratamiento" type="button" class="btn" value="Seleccionar">
			</fieldset>
			<fieldset id="data-tratamiento">
				<legend>Tratamiento seleccionado</legend>
				<br />
				Aquí se mostrarán los datos generales del tratamiento que seleccione.
			</fieldset>
			<br class="clear" />
			<fieldset>
				<legend>Tratamiento agregados para la cita</legend>
				<br />
				<table class="inter-tabla" id="tratamientos-escojidos">
					<tr>
						<td class="cb" width="70%">Nombre</td>
						<td class="cb" width="10%">Tiempo (<? echo $website_tiempo ?>)</td>
						<td class="cb" width="10%">Costo (<? echo $website_dinero; ?>)</td>
						<td class="cb" width="10%">Eliminar</td>
					</tr>
				</table>
				<table style="margin: 0px; border: 0px; border-top: 1px solid black; margin-top: -1px;">
					<tr style="border: 0px;">
						<td width="70%"></td>
						<td id="tiempo-final" style="border-bottom: 1px solid black; background-color: #fff;" width="10%">00:00</td>
						<td id="costo-final" style="text-align: right; border-bottom: 1px solid black; background-color: #fff;" width="10%">0.00</td>
						<td style="border-right: 1px solid transparent;" width="10%"></td>
					</tr>
				</table>
				<br />
				Seleccione una fecha para buscar horarios disponibles en ella: <input min="<? echo date("Y-m-d"); ?>" value="<? echo date("Y-m-d"); ?>" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" type="date" id="fecha" />
				<br />
				<br />
				<input id="btn-horarios" type="button" class="btn" value="Buscar horarios disponibles">
			</fieldset>
			<br />
			<fieldset>
				<legend>Horarios recomendados</legend>
				<br />
				<table class="inter-tabla">
					<tr>
						<td class="cb" width="40%">Hora</td>
						<td class="cb" width="50%">Día</td>
						<td class="cb" width="10%">Seleccionar</td>
					</tr>
				</table>
				<table class="inter-tabla" id="horarios-recomendados" style="border-top: 1px solid transparent;">
					
				</table>
				<!-- I - Campos Ajax -->
				<input class="campo-ajax" type="text" id="ajax-costo_final" name="costo_final">
				<input class="campo-ajax" type="text" id="ajax-tratamientos_final" name="tratamientos_final">
				<input class="campo-ajax" type="text" id="ajax-tiempo_final" name="tiempo_final">
				<input class="campo-ajax" type="radio" name="fecha_final" value="">
				<!-- F - Campos Ajax -->
				<br />
				<input type="submit" class="btn" name="submit" value="Crear cita en la agenda">
			</fieldset>
		</form>