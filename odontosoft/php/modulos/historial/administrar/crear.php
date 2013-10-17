<?php
// Permisos:
permiso_medico();
include('./php/clases/Historial.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
// Incluimos las clases necesarias:

if(isset($_POST['submit'])) {
	$obj_historial = Historial::getInstancia();

	if($_POST['isOpcion'] == 1) $_POST['isOpcion'] = true; else $_POST['isOpcion'] = false;
	if($_POST['isMultiple'] == 1) $_POST['isMultiple'] = true; else $_POST['isMultiple'] = false;
	// Modificado y agregado
	$insertar = false;
	if($_POST['isOpcion']) {
		$nro_opciones = $_POST["nro_opciones"];
		for($i = 1; $i <= $nro_opciones; $i++) {
			$arrayOpciones[$i] = $_POST["opcion_".$i];
			//echo $arrayOpciones[$i];
		}
		// Primera y segunda opcion requerida
		if($arrayOpciones[1] == "" || $arrayOpciones[1] == NULL || $arrayOpciones[2] == "" || $arrayOpciones[2] == NULL) {
			$alerta_tipo = "error";
			$alerta_mensaje = "Si una pregunta posee opciones se requiere al menos dos opciones rellenadas.";
		} else $insertar = true;
	} else $insertar = true;

	if($insertar) {
		if($obj_historial->crearPreguntaHistorial($_POST['pregunta'],$_POST['isOpcion'],$_POST['isMultiple'], $arrayOpciones, $nro_opciones)) {
			$alerta_tipo = $obj_historial->getAlerta();
			$alerta_mensaje = $obj_historial->getMensaje();
			$_POST = null; // Limpiamos cajas de Texto.
		} else {
			$alerta_tipo = $obj_historial->getAlerta();
			$alerta_mensaje = $obj_historial->getMensaje();
		}
	}
	// Modificado y agregado
}
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/historial/administrar/crear.js" type="text/javascript"></script>

	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div id="mensaje_alerta" class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>
		<form action="?sitio=<?php echo toUrl(35); ?>" method="post">
			<fieldset>
				<legend>Agregar una pregunta</legend>
				<br />
				Ingrese pregunta:
				<br />
				<input autocomplete="off" placeholder="Enunciado de la pregunta" required pattern="^[¿?¡!a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}$" name="pregunta" style="width: 320px;" />
				<br />
				<br />
				¿La pregunta tiene opciones? <input type="radio" id="jSi" name="isOpcion" value="1">Si <input id="jNo" checked type="radio" name="isOpcion" value="0">No
				<br />
				<br />
				<div id="jisOpcion" style="visibility: hidden; height: 0px;">
				<br />
				Ingrese las opciones:
				<br />
				<br />
				<div id="p_mops">
					<p><label for="p_opcs"><input autocomplete="off" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9 ]{1,500}$" type="text" id="p_opc" size="20" name="opcion_1" value="" placeholder="Nueva opción" /></label></p>
					<p><label for="p_opcs"><input autocomplete="off" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9 ]{1,500}$" type="text" id="p_opc" size="20" name="opcion_2" value="" placeholder="Nueva opción" /></label></p>
				</div>
				<br />
				<a href="#" id="addOpc"><input type="submit" class="btn" name="submit" value="+ Opción"></a>		
				<br />
				<br />
				¿La pregunta puede ser marcada con mas de una opcion? <input type="radio" name="isMultiple" value="0">Si <input checked type="radio" name="isMultiple" value="0">No 
				<input style="visibility: hidden;" readonly type="text" id="nro_opciones" name="nro_opciones" value="0" size="1" />
				<br />
				</div>
				<br />
				<input type="submit" class="btn" name="submit" value="Agregar pregunta">
				<br />
			</fieldset>
		</form>