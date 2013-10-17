<?php
// Permisos:
permiso_secretaria();
include('./php/clases/Historial.class.php');
include('./php/clases/Paciente.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
// Incluimos las clases necesarias:

$obj_historial = Historial::getInstancia();
if(isset($_POST['submit'])) {
	/*
	if($obj_historial->crearHistorial()) {
		$alerta_tipo = $obj_historial->getAlerta();
		$alerta_mensaje = $obj_historial->getMensaje();
		$_POST = null; // Limpiamos cajas de Texto.
	} else {
		$alerta_tipo = $obj_usuario->getAlerta();
		$alerta_mensaje = $obj_usuario->getMensaje();
	}
	*/
}
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/usuarios/crear.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div id="mensaje_alerta" class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>
		<form action="?sitio=<?php echo toUrl(30); ?>" method="post">
			<fieldset>
				<br />
				1) Ingrese su nombre:				<br />
				<input name="p1" type="text" name="" style="width: 300px;" />
				<br />
				<br />
				2) Sexo: <input type="radio" name="p2" value="masculino"> Masculino	<input type="radio" name="p2" value=" femenino">  Femenino
				<br />
				<br />
				3) Dirección:
				<br />
				<input name="p3" type="text" name="" style="width: 300px;" />
				<br />
				<br />
				4) Teléfono
				<br />
				<input name="p4" type="text" name="" style="width: 300px;" />
				<br />
				<br />
				<?php
					$obj_historial->getFromPreguntaHistorial();
				?>
				<br />
				<input type="submit" class="btn" name="submit" value="Crear historial">
				<br />
			</fieldset>
		</form>