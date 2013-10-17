<?php
class Paciente {
	/* Atributos */
	// Atributos Tipo A: Atributos utilizados en la clase.
	private $id;
	private $nombre;

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

	/* Métodos */
	public function getAllFromPacienteAJAX() {
		$obj_bd = Db::getInstancia();
		return $sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nombre FROM paciente;");
	}

	public function getUltimoIdPaciente() {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id FROM paciente;");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			$this->id = $array_rpta['id'];
		}
		return $this->id;
	}
}
?>