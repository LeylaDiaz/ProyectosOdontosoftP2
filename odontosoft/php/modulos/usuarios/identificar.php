<?php
include('./inc/login.php');
?>
		<title><?php echo $website_nombre; ?></title>
	</head>
	<body>
		<div id="navegador"><?php echo $website_ruta; ?></div>
		<div id="mensaje_alerta" class="<?php echo $alerta_tipo; ?>"><?php echo $alerta_mensaje; ?></div>
		<br />
		<form action="?sitio=<?php echo toUrl(1); ?>" method="post">
			<fieldset>
				<legend>Identificarse</legend>
				<br />
				Usuario:
				<br />
				<input maxlength="150" placeholder="Usuario" required autocomplete="off" type="text" name="usuario" />
				<br />
				<br />
				Contraseña:
				<br />
				<input maxlength="150" placeholder="Contraseña" required autocomplete="off" type="password" name="password" />
				<br />
				<br />
				<input type="submit" class="btn" name="submit" value="Ingresar">
			</fieldset>
		</form>