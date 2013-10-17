<?php
Class Db {
	/* Atributos */
	// Atributos Tipo A: Atributos utilizados para conectar a la base de datos (La Base de Datos debe ser la base de datos del proyecto general).
	private $servidor = "localhost";
	private $usuario = "root";
	private $password = "123456";
	private $db = "odontosoft";
	// Atributos Tipo B: Atributos utilizados en la clase.
	private $sql_link;
	private $sql_stmt;
	private $sql_arreglo;
	private static $obj_instancia;

	/* Constructores */
	// Constructor: Construyea la clase de forma automática.
	private function __construct() {
		$this->conectar_db();
	}
	private function __clone() { }
	// Get: Patrón Singleton para evitar más de una instancia de la clase.
	public static function getInstancia() {
		if (!(self::$obj_instancia instanceof self)) {
			self::$obj_instancia = new self();
		}
		return self::$obj_instancia;
	}

	/* Métodos */
	// Método (Privado): Conecta la base de datos una sola vez en caso no se encuentre instanciada la clase.
	private function conectar_db() {
		$this->sql_link = mysql_connect($this->servidor, $this->usuario, $this->password);
		mysql_select_db($this->db, $this->sql_link);
		@mysql_query("SET NAMES 'utf8'");
	}
	// Método (Publico): Ejecuta una consulta a la base de datos.
	public function ejecutar_consulta($consulta) {
		$this->sql_stmt = mysql_query($consulta, $this->sql_link) or die ("Error en el consulta: ".$consulta."<br />".mysql_error());
		return $this->sql_stmt;
	}
	// Método (Publico): Devuelve la fila designada a la consulta realizada anteriormente.
	public function obtener_fila($sql_stmt, $int_fila) {
		if ($int_fila == 0) {
			$this->sql_arreglo = mysql_fetch_array($sql_stmt);
		} else {
			mysql_data_seek($sql_stmt, $int_fila);
			$this->sql_arreglo = mysql_fetch_array($sql_stmt);
		}
		return $this->sql_arreglo;
	}
}
?>