<?php

?>
		<title><?php echo $website_nombre; ?></title>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<fieldset>
			<legend>Usuarios</legend>
			<br />
			<li>Identificarse: <?php
				if(isset($_SESSION['u'])) {
					?>Bienvenido <? echo base64_decode($_SESSION['u']); ?> (<a href="./inc/exit.php">salir</a> - <a href="?sitio=<? echo toUrl('5'); ?>&id=<? echo toUrl(base64_decode($_SESSION['i'])); ?>">editar</a>)<?
				} else {
					?><a href="?sitio=<?php echo toUrl('1'); ?>">aqui</a> <? }
				?>
			</li>
			<? if(isset($_SESSION['u'])) { ?>
				<? if(base64_decode($_SESSION['c']) == 1) { // Administradores ?>
			<li>Listar usuarios: <a href="?sitio=<?php echo toUrl('3'); ?>">aqui</a></li>
			<li>Crear usuarios: <a href="?sitio=<?php echo toUrl('2'); ?>">aqui</a></li>
				<? } ?>
			<? } ?>
		</fieldset>
		<? if(isset($_SESSION['u'])) { ?>
			<? if(base64_decode($_SESSION['c']) == 1 || base64_decode($_SESSION['c']) == 2) { // Medicos ?>
		<fieldset>
			<legend>Tratamientos</legend>
			<br />
			<li>Administrar tratamientos: <a href="?sitio=<?php echo toUrl('11'); ?>">aqui</a></li>
			<li>Crear tratamientos: <a href="?sitio=<?php echo toUrl('10'); ?>">aqui</a></li>
		</fieldset>
			<? } ?>
			<? if(base64_decode($_SESSION['c']) == 1 || base64_decode($_SESSION['c']) == 2 || base64_decode($_SESSION['c']) == 3) { // Secretaria ?>
		<fieldset>
			<legend>Citas</legend>
			<br />
			<li>Atender cita: <a href="?sitio=<?php echo toUrl('20'); ?>">aqui</a></li>
		</fieldset>
			<? } ?>
			<? if(base64_decode($_SESSION['c']) == 1 || base64_decode($_SESSION['c']) == 2 || base64_decode($_SESSION['c']) == 3) { // Secretaria ?>
		<fieldset>
			<legend>Historial</legend>
			<br />
			<? if(base64_decode($_SESSION['c']) == 1 || base64_decode($_SESSION['c']) == 2) {
				?><li>Administrar preguntas del historial medico: <a href="?sitio=<?php echo toUrl('34'); ?>">aqui</a></li>
			<? } ?>
			<li>Crear Historial: <a href="?sitio=<?php echo toUrl('30'); ?>">aqui</a></li>
			<li>Listar Historiales: <a href="?sitio=<?php echo toUrl('31'); ?>">aqui</a></li>
		</fieldset>
			<? } ?>
		<? } ?>
