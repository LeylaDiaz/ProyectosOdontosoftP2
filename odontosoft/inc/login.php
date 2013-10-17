<?php
if(isset($_POST[usuario]) && $_POST[usuario] != null) {
	include('./php/clases/Usuario.class.php');
	include('./php/clases/Db.class.php');
	// Inicio:
	$alerta_tipo = "no-alerta";
	$alerta_mensaje = "";

	$str_usuario = strtolower($_POST[usuario]);
	$obj_usuario = Usuario::getInstancia();
	$obj_usuario->getFromUsuarioLoginbyId($str_usuario);
	$str_upassword = md5($_POST[password]);
	//echo "BD: ".$obj_usuario->getPassword()."<br />";
	//echo "US: ".$str_upassword."<br />";
	if($obj_usuario->getPassword() == $str_upassword) {
		$_SESSION['u'] = base64_encode($str_usuario);
		$_SESSION['c'] = base64_encode($obj_usuario->getCargo());
		$_SESSION['i'] = base64_encode($obj_usuario->getId());
		header("location: ./");
	} else {
		$alerta_tipo = "error";
		$alerta_mensaje = "El usuario no coincide con la contraseña.";
	}
}
?>