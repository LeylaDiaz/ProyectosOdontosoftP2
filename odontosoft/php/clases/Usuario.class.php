<?php
class Usuario {
	/* Atributos */
	// Atributos Tipo A: Atributos utilizados en la clase.
	private $id;
	private $nombre;
	private $appat;
	private $apmat;
	private $nick;
	private $password;
	private $email;
	private $cargo;

	// Atributos Tipo B: Atributos utilizados internamente por la clase.
	private static $obj_instancia;
	public $alerta;
	public $mensaje;

	/* Constructores */
	// Constructor: Construye a la clase de forma automática.
	private function __construct() { }
	private function __clone() { }
	// Get: Patrón Singleton para evitar más de una instancia de la clase.
	public static function getInstancia() {
		if (!(self::$obj_instancia instanceof self)) {
			self::$obj_instancia = new self();
		}
		return self::$obj_instancia;
	}

	/* Get y Set*/
	public function getAlerta() {
		return $this->alerta;
	}
	public function getMensaje() {
		return $this->mensaje;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function getAppat() {
		return $this->appat;
	}
	public function getApmat() {
		return $this->apmat;
	}
	public function getNick() {
		return $this->nick;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getCargo() {
		return $this->cargo;
	}
	public function getPassword() {
		return $this->password;
	}
	public function getId() {
		return $this->id;
	}

	/* Métodos */
	// Método (Público): Registro de Usuarios.
	public function crearUsuario($nombre, $appat, $apmat, $nick, $password, $repassword, $email, $cargo) {
		// Validación: Contraseñas iguales.
		if($password == $repassword)
			$password = md5($password);
		else {
			$this->alerta = "error";
			$this->mensaje = "Las contraseñas no coinciden.";
			return false;
		}
		// Validación: El usuario ya existe en la Bd.
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT nick FROM usuario WHERE nick = '".$nick."';");
		if($obj_bd->obtener_fila($sql_stmt, 0)) {
			$this->alerta = "alerta";
			$this->mensaje = "El nick ya existe.";
			return false;
		}
		// Validación: El email ya existe en la Bd.
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT email FROM usuario WHERE email = '".$email."';");
		if($obj_bd->obtener_fila($sql_stmt, 0)) {
			$this->alerta = "alerta";
			$this->mensaje = "El email ya se encuentra en uso.";
			return false;
		}
		// Registro en la BD:
		if($obj_bd->ejecutar_consulta("INSERT INTO usuario(nombre, appat, apmat, nick, password, email, cargo) VALUES 
			('$nombre', '$appat', '$apmat', '$nick', '$password', '$email', $cargo);")) {
			$this->alerta = "exito";
			$this->mensaje = "El usuario ha sido creado correctamente.";
		} else {
			$this->alerta = "error";
			$this->mensaje = "Ha ocurrido un error en la base de datos.";
			return false;
		}
		return true;
	}

	// Método (Público): Modificar de Usuario.
	public function modificarUsuario($id, $nombre, $appat, $apmat, $nick, $password, $repassword, $email, $cargo) {
		// Insertar contraseña?
		$bool_password = false;
		if($password != "")
			$bool_password = true;
		// Edicion en la BD:
		if($password == $repassword)
			$password = md5($password);
		else {
			$this->alerta = "error";
			$this->mensaje = "Las contraseñas no coinciden.";
			return false;
		}
		// Obtengo los datos del propio usuario
		$this->getFromUsuariosbyId($id);
		$obj_bd = Db::getInstancia();
		// Validación: El usuario ya existe en la Bd.
		if($this->nick != $nick) {
			$sql_stmt = $obj_bd->ejecutar_consulta("SELECT nick FROM usuario WHERE nick = '".$nick."';");
			if($obj_bd->obtener_fila($sql_stmt, 0)) {
				$this->alerta = "alerta";
				$this->mensaje = "El nick ya existe.";
				return false;
			}
		}
		// Validación: El email ya existe en la Bd.
		if($this->email != $email) {
			$sql_stmt = $obj_bd->ejecutar_consulta("SELECT email FROM usuario WHERE email = '".$email."';");
			if($obj_bd->obtener_fila($sql_stmt, 0)) {
				$this->alerta = "alerta";
				$this->mensaje = "El email ya se encuentra en uso.";
				return false;
			}
		}
		if($bool_password == true) {
			// Con password
			$consult_sql = "UPDATE usuario SET nombre ='$nombre', 
							   appat ='$appat',
							   apmat ='$apmat',
							   nick ='$nick',
							   password ='$password',
							   email ='$email',
							   cargo ='$cargo' 
			WHERE id = $id;";
		} else {
			// Sin password
			$consult_sql = "UPDATE usuario SET nombre ='$nombre', 
							   appat ='$appat',
							   apmat ='$apmat',
							   nick ='$nick',
							   email ='$email',
							   cargo ='$cargo' 
			WHERE id = $id;";
		}
		if($obj_bd->ejecutar_consulta($consult_sql)) {
			$this->alerta = "exito";
			$this->mensaje = "El usuario ha sido editado correctamente.";
		} else {
			$this->alerta = "error";
			$this->mensaje = "Ha ocurrido un error en la base de datos.";
			return false;
		}
		return true;
	}

	public function getAllFromUsuarios() {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nick, nombre, appat, apmat, cargo FROM usuario ORDER BY cargo;");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			?><tr>
				<td><?php echo $array_rpta['nick']; ?></td>
				<td><?php echo $array_rpta['nombre']." <i>".$array_rpta['appat']." ".$array_rpta['apmat']."</i>"; ?></td>
				<td><?php 
					$c = $array_rpta['cargo'];
					switch($c) {
						case 1:
							echo "Administrador";
							break;
						case 2:
							echo "Médico";
							break;
						case 3:
							echo "Secretario";
							break;
					}
				 ?></td>
				<td><a href="?sitio=<?php echo toUrl(5); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Editar</td>
				<td><a onclick="return confirmar();" href="?sitio=<?php echo toUrl(4); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Eliminar</a></td>
			</tr><?php
		}
	}

	public function getFromUsuariosbyId($id) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nick, nombre, appat, apmat, cargo, email FROM usuario WHERE id = $id;");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			$this->nick = $array_rpta['nick'];
			$this->nombre = $array_rpta['nombre'];
			$this->appat = $array_rpta['appat'];
			$this->apmat = $array_rpta['apmat'];
			$this->cargo = $array_rpta['cargo'];
			$this->email = $array_rpta['email'];
		}
	}

	public function getFromUsuarioLoginbyId($nick) {
		$obj_bd = Db::getInstancia();
		// Si encontramos al usuario con el nick:
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nick, cargo, password FROM usuario WHERE nick = '$nick';");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			$this->id = $array_rpta['id'];
			$this->nick = $array_rpta['nick'];
			$this->cargo = $array_rpta['cargo'];
			$this->password = $array_rpta['password'];
		}
	}

	public function removeUsuarioById($id) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("DELETE FROM usuario WHERE id = $id");
		$this->alerta = "exito";
		$this->mensaje = "Usuario eliminado correctamente, redireccionando en <span id='tiempo'>5</span> segundos.";
	}

	public function getUsuariosByCriterio($criterio, $patron) {
		$obj_bd = Db::getInstancia();
		switch($patron) {
			case 1: // Nick
				$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nick, nombre, appat, apmat, cargo FROM usuario WHERE nick LIKE '%$criterio%' ORDER BY cargo;");
				while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
					?><tr>
						<td><?php echo $array_rpta['nick']; ?></td>
						<td><?php echo $array_rpta['nombre']." <i>".$array_rpta['appat']." ".$array_rpta['apmat']."</i>"; ?></td>
						<td><?php 
							$c = $array_rpta['cargo'];
							switch($c) {
								case 1:
									echo "Administrador";
									break;
								case 2:
									echo "Médico";
									break;
								case 3:
									echo "Secretario";
									break;
							}
						 ?></td>
						<td>Editar</td>
						<td><a onclick="return confirmar();" href="?sitio=<?php echo toUrl(4); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Eliminar</a></td>
					</tr><?php
				}
				break;
			case 2: // Nombre
				$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nick, nombre, appat, apmat, cargo FROM usuario WHERE nombre LIKE '%$criterio%' ORDER BY cargo;");
				while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
					?><tr>
						<td><?php echo $array_rpta['nick']; ?></td>
						<td><?php echo $array_rpta['nombre']." <i>".$array_rpta['appat']." ".$array_rpta['apmat']."</i>"; ?></td>
						<td><?php 
							$c = $array_rpta['cargo'];
							switch($c) {
								case 1:
									echo "Administrador";
									break;
								case 2:
									echo "Médico";
									break;
								case 3:
									echo "Secretario";
									break;
							}
						 ?></td>
						<td>Editar</td>
						<td><a onclick="return confirmar();" href="?sitio=<?php echo toUrl(4); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Eliminar</a></td>
					</tr><?php
				}
				break;
			case 3: // ApPaterno
				$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nick, nombre, appat, apmat, cargo FROM usuario WHERE appat LIKE '%$criterio%' ORDER BY cargo;");
				while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
					?><tr>
						<td><?php echo $array_rpta['nick']; ?></td>
						<td><?php echo $array_rpta['nombre']." <i>".$array_rpta['appat']." ".$array_rpta['apmat']."</i>"; ?></td>
						<td><?php 
							$c = $array_rpta['cargo'];
							switch($c) {
								case 1:
									echo "Administrador";
									break;
								case 2:
									echo "Médico";
									break;
								case 3:
									echo "Secretario";
									break;
							}
						 ?></td>
						<td>Editar</td>
						<td><a onclick="return confirmar();" href="?sitio=<?php echo toUrl(4); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Eliminar</a></td>
					</tr><?php
				}
				break;
			case 4: // ApMaterno
				$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nick, nombre, appat, apmat, cargo FROM usuario WHERE apmat LIKE '%$criterio%' ORDER BY cargo;");
				while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
					?><tr>
						<td><?php echo $array_rpta['nick']; ?></td>
						<td><?php echo $array_rpta['nombre']." <i>".$array_rpta['appat']." ".$array_rpta['apmat']."</i>"; ?></td>
						<td><?php 
							$c = $array_rpta['cargo'];
							switch($c) {
								case 1:
									echo "Administrador";
									break;
								case 2:
									echo "Médico";
									break;
								case 3:
									echo "Secretario";
									break;
							}
						 ?></td>
						<td><a href="?sitio=<?php echo toUrl(45); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Editar</a></td>
						<td><a onclick="return confirmar();" href="?sitio=<?php echo toUrl(4); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Eliminar</a></td>
					</tr><?php
				}
				break;
		}
	}
}
?>