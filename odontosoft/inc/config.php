<?php

$website_nombre = "Odontosoft";
$website_url = "";
$website_ruta = "";
$website_tiempo = "hrs.";
$website_dinero = "S/.";

// Activamos sesiones
session_start();

/* Métodos Generales */
// nombreWeb: Recupera el nombre del sitio web y designa una url para la carga en "index.php".
function nombreWeb($sitio) {
	function separador() {
		return "&#187;";
	}
	$url = realUrl($sitio);
	switch($url) {
		// case: (Usado en toUrl para obtener la verdadera URL).
		default:
		case '0': // default/principal
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Principal";
			$GLOBALS['website_url'] = "default/principal";
			break;
		/* Usuarios */
		case '1': // usuarios/identificar
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl($url)."'>Login</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Login";
			$GLOBALS['website_url'] = "usuarios/identificar";
			break;
		case '2': // usuarios/crear
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(3)."'>Listar usuarios</a> ".separador()." <a href='?sitio=".toUrl($url)."'>Crear usuario</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Crear usuario";
			$GLOBALS['website_url'] = "usuarios/crear";
			break;
		case '3': // usuarios/lista
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl($url)."'>Listar usuarios</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Listar usuarios";
			$GLOBALS['website_url'] = "usuarios/lista";
			break;
		case '4': // usuarios/eliminar
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(3)."'>Listar usuarios</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Eliminar usuario";
			$GLOBALS['website_url'] = "usuarios/eliminar";
			break;
		case '5': // usuarios/editar
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(3)."'>Listar usuarios</a> ".separador()." Editar usuario";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Editar usuario";
			$GLOBALS['website_url'] = "usuarios/editar";
			break;
		/* Tratamientos */
		case '10': // tratamientos/crear
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(11)."'>Administrar tratamiento</a> ".separador()." <a href='?sitio=".toUrl($url)."'>Crear tratamiento</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Crear tratamiento";
			$GLOBALS['website_url'] = "tratamientos/crear";
			break;
		case '11': // tratamientos/lista
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl($url)."'>Administrar tratamiento</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Administrar tratamiento";
			$GLOBALS['website_url'] = "tratamientos/lista";
			break;
		case '12': // tratamientos/eliminar
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(11)."'>Administrar tratamiento</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Administrar tratamiento";
			$GLOBALS['website_url'] = "tratamientos/eliminar";
			break;
		case '13': // tratamientos/editar
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(11)."'>Administrar tratamiento</a>".separador()."Editar tratamiento";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Administrar tratamiento";
			$GLOBALS['website_url'] = "tratamientos/editar";
			break;
		/* Citas */
		case '20': // citas/crear
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl($url)."'>Crear cita</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Crear cita";
			$GLOBALS['website_url'] = "citas/crear";
			break;
		/* Historial */
		case '30': // historial/crear
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(31)."'>Listar historiales</a> ".separador()." <a href='?sitio=".toUrl($url)."'>Crear historial</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Crear historial";
			$GLOBALS['website_url'] = "historial/crear";
			break;
		case '31': // historial/lista
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl($url)."'>Listar historiales</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Listar historiales";
			$GLOBALS['website_url'] = "historial/lista";
			break;
		case '32': // historial/eliminar
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl($url)."'>Listar historiales</a>";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Eliminar";
			$GLOBALS['website_url'] = "historial/eliminar";
			break;
		case '33': // historial/ver
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(31)."'>Listar historiales</a> ".separador()." Ver historial";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Eliminar";
			$GLOBALS['website_url'] = "historial/ver";
			break;
		case '34': // historial/administrar/lista
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." Administrar preguntas del historial medico";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Administrar preguntas del historial medico";
			$GLOBALS['website_url'] = "historial/administrar/lista";
			break;
		case '35': // historial/administrar/crear
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(34)."'>Administrar preguntas del historial medico</a> ".separador()." Agregar pregunta";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Agregar pregunta";
			$GLOBALS['website_url'] = "historial/administrar/crear";
			break;
		case '36': // historial/administrar/eliminar
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(34)."'>Administrar preguntas del historial medico</a> ".separador()." Eliminar pregunta";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Eliminar pregunta";
			$GLOBALS['website_url'] = "historial/administrar/eliminar";
			break;
		case '37': // historial/administrar/editar
			$GLOBALS['website_ruta'] = "<a href='./'>".$GLOBALS['website_nombre']."</a> ".separador()." <a href='?sitio=".toUrl(34)."'>Administrar preguntas del historial medico</a> ".separador()." Editar pregunta";
			$GLOBALS['website_nombre'] = $GLOBALS['website_nombre']." - Editar pregunta";
			$GLOBALS['website_url'] = "historial/administrar/editar";
			break;

	}
}
// toUrl: encripta la Url en base64.
function toUrl($url) {
	return base64_encode(base64_encode($url));
}
// realUrl: desencripta la Url para ser utilizada.
function realUrl($url) {
	return base64_decode(base64_decode($url));
}

/* Permisos */
function permiso_administrador() {
	if(base64_decode($_SESSION['c']) != 1) {
		header("location: ./");
		exit();
	}
}
function permiso_medico() {
	if(base64_decode($_SESSION['c']) != 1 && base64_decode($_SESSION['c']) != 2) {
		header("location: ./");
		exit();
	}
}
function permiso_secretaria() {
	if(base64_decode($_SESSION['c']) != 1 && base64_decode($_SESSION['c']) != 2 && base64_decode($_SESSION['c']) != 3) {
		header("location: ./");
		exit();
	}
}
?>