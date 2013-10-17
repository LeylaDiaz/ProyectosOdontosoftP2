<?php
// Permisos:
permiso_medico();
include('./php/clases/Tratamiento.class.php');
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
			<a href="?sitio=<?php echo toUrl('10'); ?>"><input class="btn" style="float: right;" type="button" value="Crear tratamiento" /></a>
			<form action="?sitio=<?php echo toUrl(11); ?>" method="post">
				<input size="35" placeholder="Ingrese nombre del tratamiento" required autocomplete="off" type="text" name="criterio" value="<?php printf($_POST['criterio']); ?>" />
				<input type="submit" class="btn" name="submit" value="Buscar">
			</form>
		</div>
		<br />
		<table>
			<tr>
				<td class="cb" width="35%">Nombre</td>
				<td class="cb" width="15%">Tiempo de atención (<?php echo $website_tiempo; ?>)</td>
				<td class="cb" width="20%">Costo variable (<?php echo $website_dinero; ?>)</td>
				<td class="cb" width="15%">Editar</td>
				<td class="cb" width="15%">Eliminar</td>
			</tr>
			<?php
				$obj_tratamiento = Tratamiento::getInstancia();
				if(isset($_POST['submit'])) {
					// Si he presionado buscar: Busco por criterio.
					$obj_tratamiento->getAllFromTratamientoByCriterio($_POST['criterio']);
				} else {
					// Si NO he presionado buscar, LISTA TODO.
					$obj_tratamiento->getAllFromTratamiento();
				}
			?>
		</table>
		<br />
		<div class="contenedor"><a href="?sitio=<?php echo toUrl('10'); ?>"><input class="btn" style="float: right;" type="button" value="Crear tratamiento" /></a></div>