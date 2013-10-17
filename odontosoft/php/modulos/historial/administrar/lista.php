<?php
// Permisos:
permiso_medico();
include('./php/clases/Historial.class.php');
include('./php/clases/Db.class.php');
// Incluimos las clases necesarias:
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/historial/administrar/lista.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<br />
		<div class="contenedor">
			<a href="?sitio=<?php echo toUrl('35'); ?>"><input class="btn" style="float: right;" type="button" value="Agregar pregunta" /></a>
		</div>
		<br />
		<br />
		<table>
			<tr>
				<td class="cb" width="35%">Pregunta</td>
				<td class="cb" width="25%">Opciones</td>
				<td class="cb" width="15%">Editar</td>
				<td class="cb" width="15%">Eliminar</td>
			</tr>
			<?php
				$obj_historial = Historial::getInstancia();
				$obj_historial->listarPreguntasHistoriales();
			?>
		</table>
		<br />
		<div class="contenedor"><a href="?sitio=<?php echo toUrl('35'); ?>"><input class="btn" style="float: right;" type="button" value="Agregar pregunta" /></a></div>