<?php
// Permisos:
permiso_administrador();
include('./php/clases/Usuario.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
// Incluimos las clases necesarias:

$int_id_usuario = realUrl($_GET['id']);
//echo "Id: ".$int_id_usuario;
$obj_usuario = Usuario::getInstancia();
if(isset($_POST['submit'])) {
	if($obj_usuario->modificarUsuario($int_id_usuario, $_POST['nombre'], $_POST['appat'], $_POST['apmat'], $_POST['nick'], $_POST['password'], $_POST['repassword'], $_POST['email'], $_POST['cargo'])) {
		$alerta_tipo = $obj_usuario->getAlerta();
		$alerta_mensaje = $obj_usuario->getMensaje();
		$_POST = null; // Limpiamos cajas de Texto.
	} else {
		$alerta_tipo = $obj_usuario->getAlerta();
		$alerta_mensaje = $obj_usuario->getMensaje();
	}
}
// Otenemos los datos del usuario seleccionado:
$obj_usuario->getFromUsuariosbyId($int_id_usuario);
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/usuarios/crear.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div id="mensaje_alerta" class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>
		<form action="?sitio=<?php echo toUrl(5); ?>&id=<?php echo $_GET['id']; ?>" method="post">
			<fieldset>
				<legend>Datos del usuario</legend>
				<br />
				Nombre:
				<br />
				<input id="nombre" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$" placeholder="Nombre del usuario" required autocomplete="off" type="text" name="nombre" value="<?php printf($obj_usuario->getNombre()); ?>" />
				<br />
				<br />
				Apellido paterno y materno:
				<br />
				<input id="appat" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ]{1,20}$" placeholder="Apellido paterno" required autocomplete="off" type="text" name="appat" value="<?php printf($obj_usuario->getAppat()); ?>" />
				<input pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ]{1,20}$" placeholder="Apellido materno" required autocomplete="off" type="text" name="apmat" value="<?php printf($obj_usuario->getApmat()); ?>" />
				<br />
				<br />
				Nick (Con el cual se identificará el usuario):
				<br />
				<input id="nick" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9]{6,}$" maxlength="6" placeholder="Nickname" required autocomplete="off" type="text" name="nick" value="<?php printf($obj_usuario->getNick()); ?>" /> 
				<input id="btn_generar" type="button" class="btn" value="Generar">
				<br />
				<br />
				Ingrese una contraseña y repítala:
				<br />
				<input pattern="^[A-Za-z0-9_ñÑ]{6,}$" placeholder="Contraseña" autocomplete="off" type="password" name="password" value="" />
				<input pattern="^[A-Za-z0-9_ñÑ]{6,}$" placeholder="Repita la contraseña" autocomplete="off" type="password" name="repassword" value="" />
				<br />
				<br />
				Correo electrónico:
				<br />
				<input placeholder="correo@email.com" required autocomplete="off" type="email" name="email" value="<?php printf($obj_usuario->getEmail()); ?>" /><br />
				<br />
				Cargo dentro del sistema:
				<br />
				<select name="cargo">
					<option value="1" <?php if($obj_usuario->getCargo() == 1) echo "selected"; ?>>Administrador</option>
					<option value="2" <?php if($obj_usuario->getCargo() == 2) echo "selected"; ?>>Médico</option>
					<option value="3" <?php if($obj_usuario->getCargo() == 3) echo "selected"; ?>>Secretaria</option>
				</select>
				<br />
				<br />
				<input type="submit" class="btn" name="submit" value="Editar usuario">
			</fieldset>
		</form>