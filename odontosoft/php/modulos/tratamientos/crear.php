<?php
// Permisos:
permiso_medico();
include('./php/clases/Tratamiento.class.php');
include('./php/clases/Db.class.php');
// Inicio:
$alerta_tipo = "no-alerta";
$alerta_mensaje = "";
// Incluimos las clases necesarias:

if(isset($_POST['submit'])) {
	$obj_tratamiento = Tratamiento::getInstancia();
	if($obj_tratamiento->crearTratamiento($_POST['nombre'], $_POST['descripcion'], $_POST['tiempo'], $_POST['costo'])) {
		$alerta_tipo = $obj_tratamiento->getAlerta();
		$alerta_mensaje = $obj_tratamiento->getMensaje();
		$_POST = null; // Limpiamos cajas de Texto.
	} else {
		$alerta_tipo = $obj_tratamiento->getAlerta();
		$alerta_mensaje = $obj_tratamiento->getMensaje();
	}
}
?>
		<title><?php echo $website_nombre; ?></title>
		<script src="./js/tratamientos/crear.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div id="mensaje_alerta" class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>
		<form action="?sitio=<?php echo toUrl(10); ?>" method="post">
			<fieldset>
				<legend>Datos del tratamiento</legend>
				<br />
				Nombre:
				<br />
				<input id="nombre" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$" placeholder="Nombre del tratamiento" required autocomplete="off" type="text" name="nombre" value="<?php printf($_POST['nombre']); ?>" />
				<br />
				<br />
				Descripción:
				<br />
				<textarea maxlength="250" required placeholder="Descripción breve del tratamiento" name="descripcion"><?php printf($_POST['descripcion']); ?></textarea>
				<br />
				<br />
				Tiempo de atención:
				<br />
				<select name="tiempo">
					<option value="0:30" <?php if($_POST['tiempo'] == 1) { echo "selected"; } ?> >0:30</option>
					<option value="1:00" <?php if($_POST['tiempo'] == 2) { echo "selected"; } ?> >1:00</option>
					<option value="1:30" <?php if($_POST['tiempo'] == 3) { echo "selected"; } ?> >1:30</option>
					<option value="2:00" <?php if($_POST['tiempo'] == 4) { echo "selected"; } ?> >2:00</option>
					<option value="2:30" <?php if($_POST['tiempo'] == 5) { echo "selected"; } ?> >2:30</option>
					<option value="3:00" <?php if($_POST['tiempo'] == 6) { echo "selected"; } ?> >3:00</option>
					<option value="3:30" <?php if($_POST['tiempo'] == 7) { echo "selected"; } ?> >3:30</option>
					<option value="4:00" <?php if($_POST['tiempo'] == 8) { echo "selected"; } ?> >4:00</option>
					<option value="4:30" <?php if($_POST['tiempo'] == 9) { echo "selected"; } ?> >4:30</option>
					<option value="5:00" <?php if($_POST['tiempo'] == 10) { echo "selected"; } ?> >5:00</option>
				</select> <?php echo $website_tiempo; ?>
				<br />
				<br />
				Costo variable:
				<br />
				<input onclick="this.value = ''" onblur="this.value = moneda(this.value)" pattern="\d+(\.\d{2})?" placeholder="0.00" required autocomplete="off" type="text" name="costo" value="<?php printf($_POST['costo']); ?>" /> <?php echo $website_dinero; ?>
				<br />
				<br />
				<input type="submit" class="btn" name="submit" value="Crear tratamiento">
			</fieldset>
		</form>