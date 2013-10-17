<?php
// Permisos:
permiso_secretaria();
include('./php/clases/Historial.class.php');
include('./php/clases/Paciente.class.php');
include('./php/clases/Db.class.php');
// Incluimos las clases necesarias:
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/tratamientos/lista.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<br />
		<div class="contenedor">
			<a href="?sitio=<?php echo toUrl('30'); ?>"><input class="btn" style="float: right;" type="button" value="Crear historial" /></a>
			<form action="?sitio=<?php echo toUrl(31); ?>" method="post">
				<input size="35" placeholder="Nombre del paciente" required autocomplete="off" type="text" name="criterio" value="<?php printf($_POST['criterio']); ?>" />
				<input type="submit" class="btn" name="submit" value="Buscar">
			</form>
		</div>
		<br />
		<table>
			<tr>
				<td class="cb" width="35%">Nombre</td>
				<td class="cb" width="25%">Mostrar historial</td>
				<td class="cb" width="15%">Editar</td>
				<td class="cb" width="15%">Eliminar</td>
			</tr>
			<?php
				$obj_historial = Historial::getInstancia();
				if(isset($_POST['submit'])) {
					// Si he presionado buscar: Busco por criterio.
					$obj_historial->listarHistoriales();
				} else {
					// Si NO he presionado buscar, LISTA TODO.
					$obj_historial->listarHistoriales();
				}
			?>
		</table>
		<br />
		<div class="contenedor"><a href="?sitio=<?php echo toUrl('30'); ?>"><input class="btn" style="float: right;" type="button" value="Crear historial" /></a></div>