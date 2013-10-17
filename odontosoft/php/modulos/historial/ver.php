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
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/usuarios/crear.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div id="mensaje_alerta" class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>
<?php
$obj_historial = Historial::getInstancia();
$sql_stmt = $obj_historial->mostrarHistorial(realUrl($_GET['id'])); ?>