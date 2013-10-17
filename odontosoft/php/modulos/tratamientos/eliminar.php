<?php
// Permisos:
permiso_medico();
include('./php/clases/Tratamiento.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
$obj_tratamiento = Tratamiento::getInstancia();
$id_desencriptado = realUrl($_GET['id']);
$obj_tratamiento->removeTratamientoById($id_desencriptado);
// Objeto obtiene la alerta y el mensaje:
$alerta_tipo = $obj_tratamiento->getAlerta();
$alerta_mensaje = $obj_tratamiento->getMensaje();
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/tratamientos/eliminar.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>