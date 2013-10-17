<?php
class Cita {
	/* Atributos */
	// Atributos Tipo A: Atributos utilizados en la clase.
	private $id_paciente;
	private $nombre_tratamientos;
	private $fecha;
	private $costo_final;

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
	// Método (Público):
	public function crearTratamiento($nombre_paciente, $nombre_tratamientos, $tiempo, $fecha, $costo_final) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT nombre FROM paciente WHERE nombre = '".$nombre_paciente."';");
		if($obj_bd->obtener_fila($sql_stmt, 0)) {
			// Registro en la BD:
			if($obj_bd->ejecutar_consulta("INSERT INTO cita(nombre_paciente, nombre_tratamientos, tiempo, fecha, costo_final) VALUES 
				('$nombre_paciente', '$nombre_tratamientos', '$tiempo', '$fecha', $costo_final);")) {
				$this->alerta = "exito";
				$this->mensaje = "La cita ha sido creada correctamente.";
			} else {
				$this->alerta = "error";
				$this->mensaje = "Ha ocurrido un error en la base de datos.";
				return false;
			}
			return true;
		} else {
			$this->alerta = "error";
			$this->mensaje = "El paciente no existe en la base de datos, rellene el formulario nuevamente.";
			return false;
		}
	}

	public function horasDisponiblesAJAX($criterio) {
		$fechaNormal = date("d/m/Y", strtotime($criterio));
		// BD:
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT * FROM cita WHERE fecha LIKE '%$criterio%';");
		$o = 0;
		$hnd = array();
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			$hora_i = date("H:i:s", strtotime($array_rpta['fecha']));
			list($hora1, $min1, $seg1) = split('[:]', $array_rpta['tiempo']);
			list($hora2, $min2, $seg2) = split('[:]', $hora_i);
			$hora_f = date("H:i:s", mktime($hora1 + $hora2, $min1 + $min2 - 30, 0));
			echo $hora_i." - ".$hora_f."<br />";
			$hnd[$o] = $hora_i;
			$o++;
			$hnd[$o] = $hora_f;
			$o++;
		}
		// Hora
			$nm = false;
			$myhora = "07:30";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
			$nm = false;
			$myhora = "07:00";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
			$nm = false;
			$myhora = "06:30";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
			$nm = false;
			$myhora = "06:00";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
			$nm = false;
			$myhora = "05:30";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
			$nm = false;
			$myhora = "05:00";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
			$nm = false;
			$myhora = "04:30";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
			$nm = false;
			$myhora = "04:00";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
			$nm = false;
			$myhora = "03:30";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
			$nm = false;
			$myhora = "03:00";
			foreach($hnd as $value) {
				if($value == $myhora.":00") {
					$nm = true;
				}
			}
			if($nm == false) {
				?>
				<tr>
					<td width="40%"><? echo $myhora; ?></td>
					<td width="50%"><? echo $fechaNormal; ?></td>
					<td width="10%"><input checked type="radio" name="fecha_final" value="<? echo $criterio." ".$myhora.":00"; ?>"></td>
				</tr>
				<?
			}
		// Hora
	}
}
?>