<?php
permiso_administrador();
// Permisos:
include('./php/clases/Usuario.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
// Incluimos las clases necesarias:
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/usuarios/lista.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<br />
		<div class="contenedor">
			<a href="?sitio=<?php echo toUrl(2); ?>"><input class="btn" style="float: right;" type="button" value="Crear usuario" /></a>
			<form action="?sitio=<?php echo toUrl(3); ?>" method="post">
				<select name="patron">
					<option <?php if($_POST['patron'] == 1) echo "selected"; ?> value="1">Nick</option>
					<option <?php if($_POST['patron'] == 2) echo "selected"; ?> value="2">Nombre</option>
					<option <?php if($_POST['patron'] == 3) echo "selected"; ?> value="3">Apellido paterno</option>
					<option <?php if($_POST['patron'] == 4) echo "selected"; ?> value="4">Apellido materno</option>
				</select>
				<input placeholder="Ingrese criterio" required autocomplete="off" type="text" name="criterio" value="<?php printf($_POST['criterio']); ?>" />
				<input type="submit" class="btn" name="submit" value="Buscar">
			</form>
		</div>
		<br />
		<table>
			<tr>
				<td class="cb" width="10%">Nick</td>
				<td class="cb">Nombre y apellidos</td>
				<td class="cb">Cargo</td>
				<td class="cb" width="10%">Editar</td>
				<td class="cb" width="10%">Eliminar</td>
			</tr>
			<?php
				$obj_usuario = Usuario::getInstancia();
				if(isset($_POST['submit'])) {
					$obj_usuario->getUsuariosByCriterio($_POST['criterio'], $_POST['patron']);
				} else {
					$obj_usuario->getAllFromUsuarios();
				}
			?>
		</table>
		<br />
		<div class="contenedor"><a href="?sitio=<?php echo toUrl(2); ?>"><input class="btn" style="float: right;" type="button" value="Crear usuario" /></a></div>