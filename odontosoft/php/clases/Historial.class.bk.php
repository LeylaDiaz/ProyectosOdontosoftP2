<?php 
class Historial {
	/* Atributos */
	// Atributos Tipo A: Atributos utilizados en la clase.
	private $p1;
	private $p2;
	private $p3;
	private $p4;
	private $p5;
	private $p6;
	private $p7;
	private $p8;
	private $p9;
	private $p10;
	private $p11;
	private $p12;
	private $p13;
	private $p14;

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
	public function crearHistorial($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$nombre,$appat,$apmat,$dni,$telefono,$direccion) {
		$obj_bd = Db::getInstancia();
		$obj_paciente = Paciente::getInstancia();
		// Registro en la BD:
		if($obj_bd->ejecutar_consulta("INSERT INTO paciente(nombre,appat,apmat,dni,telefono,direccion) VALUES 
			('$nombre','$appat','$apmat','$dni','$telefono','$direccion');")) {

			$ultimoid = $obj_paciente->getUltimoIdPaciente();

			if($obj_bd->ejecutar_consulta("INSERT INTO historial(id_paciente,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13) VALUES 
			($ultimoid,'$p1','$p2','$p3','$p4','$p5','$p6','$p7','$p8','$p9','$p10','$p11','$p12','$p13');")) {
				$this->alerta = "exito";
				$this->mensaje = "Historial creado correctamente.";
			} else {
				$this->alerta = "error";
				$this->mensaje = "Ha ocurrido un error en la base de datos.";
				return false;
			}
		} else {
			$this->alerta = "error";
			$this->mensaje = "Ha ocurrido un error en la base de datos.";
			return false;
		}
		return true;
	}
	public function listarHistoriales()
	{
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nombre, appat, apmat FROM paciente");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			?><tr>
				<td><?php echo $array_rpta['nombre']." ".$array_rpta['appat']." ".$array_rpta['apmat']; ?></td>
				<td><a href="?sitio=<?php echo toUrl(33); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Mostrar historial</a></td>
				<td>Editar</td>
				<td><a onclick="return confirmar();" href="?sitio=<?php echo toUrl(32); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Eliminar</a></td>
			</tr><?php
		}
	}
	public function removeHistorial($id) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id FROM historial WHERE id_paciente = $id");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			$idHistorial = $array_rpta['id'];
		}
		$sql_stmt = $obj_bd->ejecutar_consulta("DELETE FROM paciente WHERE id = $id");
		$sql_stmt = $obj_bd->ejecutar_consulta("DELETE FROM historial WHERE id = $idHistorial");
		$this->alerta = "exito";
		$this->mensaje = "Historial eliminado correctamente, redireccionando en <span id='tiempo'>5</span> segundos.";
	}
	public function mostrarHistorial($id) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT * FROM historial WHERE id_paciente = $id");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			$sql_stmt2 = $obj_bd->ejecutar_consulta("SELECT * FROM paciente WHERE id = ".$array_rpta['id_paciente']);
			while ($array_rpta2 = $obj_bd->obtener_fila($sql_stmt2, 0)) {
				$nombre = $array_rpta2['nombre'];
				$appat = $array_rpta2['appat'];
				$apmat = $array_rpta2['apmat'];
				$dni = $array_rpta2['dni'];
				$telefono = $array_rpta2['telefono'];
				$direccion = $array_rpta2['direccion'];
			}
	?>
		<fieldset>
			<legend>Rellene los siguienets datos</legend>
			<br />
			Nombre: <?php echo $nombre." ".$array_rpta['appat']." ".$array_rpta['apmat']; ?>
			<br />
			<br />
			DNI: <?php echo $dni; ?>
			<br />
			<br />
			Teléfono personal: <?php echo $telefono; ?>
			<br />
			<br />
			Dirección: <?php echo $direccion; ?>
			<br />
			<br />
			<hr />
			¿Ha estado hospitalizado en los ultimos meses? ¿Por qué?:
			<br />
			<?php echo $array_rpta['p1'] ?>
			<br />
			<br />
			¿Ha estado bajo atencion médica en estos últimos meses? ¿Por qué? ¿Dónde?
			<br />
			<?php echo $array_rpta['p2'] ?>
			<br />
			<br />
			¿Es alérgico a alguna droga, anestesia y/o antibióticos? ¿Cuáles?
			<br />
			<?php echo $array_rpta['p3'] ?>
			<br />
			<br />
			¿Ha tenido hemorragia, que haya tenido que ser tratada?
			<br />
			<?php echo $array_rpta['p4'] ?>
			<br />
			<br />
			Ha tenido alguna de estas enfermedades:
			<br />
			<?php 
				$final = explode("|", $array_rpta['p5']);
				$i = 0;
				foreach ($final as $key) {
					if($i != 0) {
						if($key != "") {
							echo ", $key";
						}
					} else {
						if($key != "") {
							echo "$key";
						} else {
							echo "Ninguna enfermedad encontrada";
						}
						$i++;
					}
				}
				echo ".";
			?>
			<br /> 
			<br />
			Ha tenido alguna otra enfermedad:
			<br />
			<?php echo $array_rpta['p6'] ?>
			<br />
			<br />
			¿Esta tomando algún medicamento actualmente? ¿Cuál?
			<br />
			<?php echo $array_rpta['p7'] ?>
			<br />
			<br />
			¿Esta embarazada? ¿Cuántas semanas o meses?
			<br />
			<?php echo $array_rpta['p8'] ?>
			<br />
			<br />
			¿Está amamantando?
			<br />
			<?php echo $array_rpta['p9'] ?>
			<br />
			<br />
			En caso de urgencia llamar al teléfono:
			<br />
			<?php echo $array_rpta['p10'] ?>
			<br />
			<br />
			Teléfono y dirección de su servicio médico en caso de urgencia. Si en caso lo tuviera.
			<br />
			<?php echo $array_rpta['p11'] ?>
			<br />
			<br />
			¿Cuándo ha sido su última consulta dental?
			<br />
			<?php echo $array_rpta['p12'] ?>
			<br />
			<br />
			Observaciones:
			<br />
			<?php echo $array_rpta['p13'] ?>
			<br />
		</fieldset>
	<?
		}
	}
}
?>