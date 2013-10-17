<?php
// Permisos:
include('../../clases/Tratamiento.class.php');
include('../../clases/Cita.class.php');
include('../../clases/Db.class.php');
if(isset($_GET['tratamiento'])) {
	$obj_tratamiento = Tratamiento::getInstancia();
	$obj_tratamiento->getAllFromTratamientobyNombreAJAX($_GET['tratamiento']);
}
if(isset($_GET['tiempo'])) {
	$obj_tratamiento = Cita::getInstancia();
	$obj_tratamiento->horasDisponiblesAJAX($_GET['tiempo']);
}
?>