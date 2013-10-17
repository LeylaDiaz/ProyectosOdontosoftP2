<?php
// Permisos:
permiso_secretaria();
include('./php/clases/Historial.class.php');
include('./php/clases/Paciente.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
$obj_historial = Historial::getInstancia();
$id_desencriptado = realUrl($_GET['id']);
$obj_historial->removeHistorial($id_desencriptado);
// Objeto obtiene la alerta y el mensaje:
$alerta_tipo = $obj_historial->getAlerta();
$alerta_mensaje = $obj_historial->getMensaje();
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/historial/eliminar.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>