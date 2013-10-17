<?php
// Permisos:
permiso_administrador();
include('./php/clases/Usuario.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
$obj_usuario = Usuario::getInstancia();
$id_desencriptado = realUrl($_GET['id']);
$obj_usuario->removeUsuarioById($id_desencriptado);
// Objeto obtiene la alerta y el mensaje:
$alerta_tipo = $obj_usuario->getAlerta();
$alerta_mensaje = $obj_usuario->getMensaje();
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/usuarios/eliminar.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>