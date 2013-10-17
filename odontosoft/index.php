<?php
ob_start(); // Evita error de Hearde's
$sitio = $_GET['sitio'];
// Incluimos todos los scripts necesarios para el funcionamineto de la página:
include('./inc/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link href="./css/style.css" rel="stylesheet" />
		<link href="./favicon.ico" rel="icon" type="image/x-icon" />
		<script src="./js/jquery.min.js" type="text/javascript"></script>
<?php
nombreWeb($sitio);
if($website_url == "" or $website_url == "index") {
	include("./php/modulos/default/principal.php");
} else {
	if(file_exists("./php/modulos/".$website_url.".php")) {
		include("./php/modulos/".$website_url.".php");
	} else {
		include("./php/modulos/default/principal.php");
	}
} ?>

	</body>
</html>