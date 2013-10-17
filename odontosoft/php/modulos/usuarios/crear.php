<?php
// Permisos:
permiso_administrador();
include('./php/clases/Usuario.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
// Incluimos las clases necesarias:

if(isset($_POST['submit'])) {
	$obj_usuario = Usuario::getInstancia();
	if($obj_usuario->crearUsuario($_POST['nombre'], $_POST['appat'], $_POST['apmat'], $_POST['nick'], $_POST['password'], $_POST['repassword'], $_POST['email'], $_POST['cargo'])) {
		$alerta_tipo = $obj_usuario->getAlerta();
		$alerta_mensaje = $obj_usuario->getMensaje();
		$_POST = null; // Limpiamos cajas de Texto.
	} else {
		$alerta_tipo = $obj_usuario->getAlerta();
		$alerta_mensaje = $obj_usuario->getMensaje();
	}
}
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/usuarios/crear.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div id="mensaje_alerta" class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>
		<form action="?sitio=<?php echo toUrl(2); ?>" method="post">
			<fieldset>
				<legend>Datos del usuario</legend>
				<br />
				Nombre:
				<br />
				<input id="nombre" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$" placeholder="Nombre del usuario" required autocomplete="off" type="text" name="nombre" value="<?php printf($_POST['nombre']); ?>" />
				<br />
				<br />
				Apellido paterno y materno:
				<br />
				<input id="appat" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ]{1,20}$" placeholder="Apellido paterno" required autocomplete="off" type="text" name="appat" value="<?php printf($_POST['appat']); ?>" />
				<input pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ]{1,20}$" placeholder="Apellido materno" required autocomplete="off" type="text" name="apmat" value="<?php printf($_POST['apmat']); ?>" />
				<br />
				<br />
				Nick (Con el cual se identificará el usuario):
				<br />
				<input id="nick" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9]{6,}$" maxlength="6" placeholder="Nickname" required autocomplete="off" type="text" name="nick" value="<?php printf($_POST['nick']); ?>" /> 
				<input id="btn_generar" type="button" class="btn" value="Generar">
				<br />
				<br />
				Ingrese una contraseña y repítala:
				<br />
				<input pattern="^[A-Za-z0-9_ñÑ]{6,}$" placeholder="Contraseña" required autocomplete="off" type="password" name="password" value="<?php printf($_POST['password']); ?>" />
				<input pattern="^[A-Za-z0-9_ñÑ]{6,}$" placeholder="Repita la contraseña" required autocomplete="off" type="password" name="repassword" value="<?php printf($_POST['repassword']); ?>" />
				<br />
				<br />
				Correo electrónico:
				<br />
				<input placeholder="correo@email.com" required autocomplete="off" type="email" name="email" value="<?php printf($_POST['email']); ?>" /><br />
				<br />
				Cargo dentro del sistema:
				<br />
				<select name="cargo">
					<option value="1" <?php if($_POST['cargo'] == 1) { echo "selected"; } ?>>Administrador</option>
					<option value="2" <?php if($_POST['cargo'] == 2) { echo "selected"; } ?>>Médico</option>
					<option value="3" <?php if($_POST['cargo'] == 3) { echo "selected"; } ?>>Secretaria</option>
				</select>
				<br />
				<br />
				<input type="submit" class="btn" name="submit" value="Crear usuario">
			</fieldset>
		</form>