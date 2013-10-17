<?php
// Permisos:
permiso_administrador();
include('./php/clases/Tratamiento.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
// Incluimos las clases necesarias:

$int_id_tratamiento = realUrl($_GET['id']);
//echo "Id: ".$int_id_tratamiento;
$obj_tratamiento = Tratamiento::getInstancia();
if(isset($_POST['submit'])) {
	if($obj_tratamiento->modificarTratamiento($int_id_tratamiento, $_POST['nombre'], $_POST['descripcion'], $_POST['tiempo'], $_POST['costo'])) {
		$alerta_tipo = $obj_tratamiento->getAlerta();
		$alerta_mensaje = $obj_tratamiento->getMensaje();
		$_POST = null; // Limpiamos cajas de Texto.
	} else {
		$alerta_tipo = $obj_tratamiento->getAlerta();
		$alerta_mensaje = $obj_tratamiento->getMensaje();
	}
}
// Otenemos los datos del usuario seleccionado:
$obj_tratamiento->getFromTratamientobyId($int_id_tratamiento);
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/tratamientos/crear.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div id="mensaje_alerta" class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>
		<form action="?sitio=<?php echo toUrl(11); ?>&id=<?php echo $_GET['id']; ?>" method="post">
			<fieldset>
				<legend>Datos del tratamiento</legend>
				<br />
				Nombre:
				<br />
				<input id="nombre" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$" placeholder="Nombre del tratamiento" required autocomplete="off" type="text" name="nombre" value="<?php printf($obj_tratamiento->getNombre()); ?>" />
				<br />
				<br />
				Descripción:
				<br />
				<textarea maxlength="250" required placeholder="Descripción breve del tratamiento" name="descripcion"><?php printf($obj_tratamiento->getDescripcion()); ?></textarea>
				<br />
				<br />
				Tiempo de atención:
				<br />
				<select name="tiempo">
					<option value="0:30" <?php if($obj_tratamiento->getTiempo() == "00:30:00") { echo "selected"; } ?> >0:30</option>
					<option value="1:00" <?php if($obj_tratamiento->getTiempo() == "01:00:00") { echo "selected"; } ?> >1:00</option>
					<option value="1:30" <?php if($obj_tratamiento->getTiempo() == "01:30:00") { echo "selected"; } ?> >1:30</option>
					<option value="2:00" <?php if($obj_tratamiento->getTiempo() == "02:00:00") { echo "selected"; } ?> >2:00</option>
					<option value="2:30" <?php if($obj_tratamiento->getTiempo() == "02:30:00") { echo "selected"; } ?> >2:30</option>
					<option value="3:00" <?php if($obj_tratamiento->getTiempo() == "03:00:00") { echo "selected"; } ?> >3:00</option>
					<option value="3:30" <?php if($obj_tratamiento->getTiempo() == "03:30:00") { echo "selected"; } ?> >3:30</option>
					<option value="4:00" <?php if($obj_tratamiento->getTiempo() == "04:00:00") { echo "selected"; } ?> >4:00</option>
					<option value="4:30" <?php if($obj_tratamiento->getTiempo() == "04:30:00") { echo "selected"; } ?> >4:30</option>
					<option value="5:00" <?php if($obj_tratamiento->getTiempo() == "05:00:00") { echo "selected"; } ?> >5:00</option>

				</select> <?php echo $website_tiempo; ?>
				<br />
				<br />
				Costo variable:
				<br />
				<input onclick="this.value = ''" onblur="this.value = moneda(this.value)" pattern="\d+(\.\d{2})?" placeholder="0.00" required autocomplete="off" type="text" name="costo" value="<?php printf($obj_tratamiento->getCosto()); ?>" /> <?php echo $website_dinero; ?>
				<br />
				<br />
				<input type="submit" class="btn" name="submit" value="Guardar tratamiento">
			</fieldset>
		</form>