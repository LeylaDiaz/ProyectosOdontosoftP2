<?php 
class Historial {
	/* Atributos */
	// Atributos Tipo A: Atributos utilizados en la clase.
	private $id;
	private $pregunta;
	private $isOpcion;
	private $isMultiple;
	private $opciones;

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
	//
	public function getId() {
		return $this->id;
	}
	public function getPregunta() {
		return $this->pregunta;
	}
	public function getIsOpcion() {
		return $this->isOpcion;
	}
	public function getOpciones() {
		return $this->opciones;
	}
	public function getIsMultiple() {
		return $this->isMultiple;
	}

	/* Métodos */
	//$_POST['pregunta'],$_POST['isOpcion'],$_POST['isMultiple'], $arrayOpciones, $nro_opciones
	public function crearPreguntaHistorial($pregunta, $isOpcion, $isMultiple, $opciones, $nro) {
		$obj_bd = Db::getInstancia();

		if($pregunta == "" || $pregunta == null) {
			$this->alerta = "alerta";
			$this->mensaje = "La pregunta no debe estar vacia.";
			return false;
		}

		// Registro en la BD:
		if($isOpcion == 1) $isOpcion = true; else $isOpcion = false;
		if($isMultiple == 1) $isMultiple = true; else $isMultiple = false;

		if($obj_bd->ejecutar_consulta("INSERT INTO preg_hist(pregunta, isMultiple) VALUES 
			('$pregunta', '$isMultiple');")) {
			// Insertamos opciones
			if($nro > 0) {
				// Id:
				$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id FROM preg_hist ORDER BY id ASC");
				while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
					$id_preg = $array_rpta['id'];
				}
				//
				for($i = 1; $i <= $nro; $i++) {
					if($opciones[$i] != "") {
						if($obj_bd->ejecutar_consulta("INSERT INTO opc_preg_hist(id_preg, opcion) VALUES 
						('$id_preg', '".$opciones[$i]."');")) {
							$this->alerta = "exito";
							$this->mensaje = "Se agregó la pregunta al historial.";
						} else {
							$this->alerta = "error";
							$this->mensaje = "Ha ocurrido un error en la base de datos.";	
						}
					}
				}
			}
		} else {
			$this->alerta = "error";
			$this->mensaje = "Ha ocurrido un error en la base de datos.";
			return false;
		}
	}

	public function tieneOpciones($id)
	{
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT * FROM opc_preg_hist WHERE id_preg = $id ORDER BY opcion");
		$i = 1;
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			$this->opciones[$i] = $array_rpta['opcion'];
			$i++;
		}
	}

	public function listarPreguntasHistoriales()
	{
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT * FROM preg_hist ORDER BY id");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			?><tr>
				<td><?php echo $array_rpta['pregunta']; ?></td>
				<td><?php 
					$this->opciones = null;
					$this->tieneOpciones($array_rpta['id']);
					if($this->opciones[1] != "") {
						$primero = true;
						foreach ($this->opciones as $opcion) {
							if($primero) {
								echo $opcion;
								$primero = false;
							} else {
								echo ", ".$opcion;
							}
						}
					} else {
						echo "Pregunta sin opciones";
					}
				?>.</td>
				<td><a href="?sitio=<?php echo toUrl(37); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Editar</a></td>
				<td><a onclick="return confirmar();" href="?sitio=<?php echo toUrl(36); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Eliminar</a></td>
			</tr><?php
		}
	}

	public function removePreguntaHistorial($id) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("DELETE FROM preg_hist WHERE id = $id");
		$sql_stmt = $obj_bd->ejecutar_consulta("DELETE FROM opc_preg_hist WHERE id_preg = $id");
		$this->alerta = "exito";
		$this->mensaje = "Pregunta eliminada correctamente, redireccionando en <span id='tiempo'>5</span> segundos.";
	}

	public function modificarPreguntaHistorial($id, $pregunta, $isOpcion, $isMultiple, $opciones, $nro) {
		$obj_bd = Db::getInstancia();
		$consult_sql = "UPDATE preg_hist SET pregunta = '$pregunta', 
							   isMultiple = '$isMultiple'
						WHERE id = $id;";

		if($obj_bd->ejecutar_consulta($consult_sql)) {
			$sql_stmt = $obj_bd->ejecutar_consulta("DELETE FROM opc_preg_hist WHERE id_preg = $id");
			if($isOpcion) {
				// Remuevo datos
				$this->alerta = "exito";
				$this->mensaje = "Pregunta editada correctamente.";
				// Reinserto datos:
				if($nro > 0) {
					$id_preg = $id;
					for($i = 1; $i <= $nro; $i++) {
						if($opciones[$i] != "") {
							if($obj_bd->ejecutar_consulta("INSERT INTO opc_preg_hist(id_preg, opcion) VALUES 
							('$id_preg', '".$opciones[$i]."');")) {
								$this->alerta = "exito";
								$this->mensaje = "Se agregó la pregunta al historial.";
							} else {
								$this->alerta = "error";
								$this->mensaje = "Ha ocurrido un error en la base de datos.";	
							}
						}
					}
				}
			} else {
				$this->alerta = "exito";
				$this->mensaje = "Se agregó la pregunta al historial.";
			}
		} else {
			$this->alerta = "error";
			$this->mensaje = "Ha ocurrido un error en la base de datos.";
			return false;
		}
	}

	public function getFromPreguntaHistorialbyId($id) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, pregunta, isMultiple FROM preg_hist WHERE id = $id;");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			$this->pregunta = $array_rpta['pregunta'];
			$this->isMultiple = $array_rpta['isMultiple'];
			$this->tieneOpciones($array_rpta['id']);
		}
	}

	// A modificar!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	public function getFromPreguntaHistorial() {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, pregunta, isOpcion, opciones, isMultiple FROM preg_hist;");
		$nropregunta = 5;
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			echo $nropregunta.") ".$array_rpta['pregunta'];
			$i = 0;
			if($array_rpta['isOpcion']) {
				$final = explode(",", $array_rpta['opciones']);
				if($array_rpta['isMultiple']) {
					echo "<br />";
				}
				foreach ($final as $key) {
					?>
					<input type="<?
						if($array_rpta['isMultiple']) {
							echo "checkbox";
						} else {
							echo "radio";
						}
						if($key[0] == " ") {
							$key[1] = ucfirst($key[1]);
						}
					 ?>" name="p<? 
					 	if($array_rpta['isMultiple']) {
					 		echo $nropregunta."_".$i;
					 	} else echo $nropregunta; ?>" value="<? echo strtolower($key); ?>"> <? echo ucfirst($key); ?>
					<?
					$i++;
				}
			} else {
				?>
				<br />
				<input name="p<? echo $nropregunta; ?>" type="text" name="" style="width: 300px;" />
				<?
			}
			echo "<br /><br />";
			$nropregunta++;
		}
	}

}
?>
