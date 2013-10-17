<?php
class Tratamiento {
	/* Atributos */
	// Atributos Tipo A: Atributos utilizados en la clase.
	private $nombre;
	private $descripcion;
	private $hora;
	private $costo;

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
	public function getDescripcion() {
		return $this->descripcion;
	}
	public function getTiempo() {
		return $this->hora;
	}
	public function getCosto() {
		return $this->costo;
	}

	/* Métodos */
	// Método (Público):
	public function crearTratamiento($nombre, $descripcion, $tiempo, $costo) {
		if($costo <= 0) {
			$this->alerta = "error";
			$this->mensaje = "El costo variable debe ser mayor a cero.";
			return false;
		}
		// Validación: El tratamiento ya existe en la Bd.
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT nombre FROM tratamiento WHERE nombre = '".$nombre."';");
		if($obj_bd->obtener_fila($sql_stmt, 0)) {
			$this->alerta = "alerta";
			$this->mensaje = "El nombre del tratamiento ya existe.";
			return false;
		}
		// Registro en la BD:
		if($obj_bd->ejecutar_consulta("INSERT INTO tratamiento(nombre, descripcion, tiempo, costo) VALUES 
			('$nombre', '$descripcion', '$tiempo', $costo);")) {
			$this->alerta = "exito";
			$this->mensaje = "El tratamiento ha sido creado correctamente.";
		} else {
			$this->alerta = "error";
			$this->mensaje = "Ha ocurrido un error en la base de datos.";
			return false;
		}
		return true;
	}

	public function getAllFromTratamiento() {
		$obj_bd = Db::getInstancia();
		// Lista TODO.
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT * FROM tratamiento ORDER BY nombre;");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			// Empieza a recorrer el arreglo que es la respuesta de la consulta.
			?>
			<table class="super-tabla">
				<tr>
					<td width="35%"><?php echo $array_rpta['nombre']; ?></td>
					<td width="15%"><?php 
						$tiempo = explode(":", $array_rpta['tiempo']);
						echo $tiempo[0].":".$tiempo[1]; ?></td>
					<td width="20%"><?php echo number_format($array_rpta['costo'], 2, '.', ''); ?></td>
					<td><a href="?sitio=<?php echo toUrl(13); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Editar</td>
					<td width="15%"><a onclick="return confirmar();" href="?sitio=<?php echo toUrl(12); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Eliminar</a></td>
				</tr>
				<tr>
					<td colspan="5"><?php echo $array_rpta['descripcion']; ?></td>
				</tr>
			</table>
		<?php
		}
	}

	public function getAllFromTratamientoByCriterio($criterio) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT * FROM tratamiento WHERE nombre LIKE '%$criterio%' ORDER BY nombre;");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			?>
				<tr>
					<td width="35%"><?php echo $array_rpta['nombre']; ?></td>
					<td width="15%"><?php 
						$tiempo = explode(":", $array_rpta['tiempo']);
						echo $tiempo[0].":".$tiempo[1]; ?></td>
					<td width="20%"><?php echo number_format($array_rpta['costo'], 2, '.', ''); ?></td>
					<td width="15%">Editar</td>
					<td width="15%"><a onclick="return confirmar();" href="?sitio=<?php echo toUrl(12); ?>&id=<?php echo toUrl($array_rpta['id']); ?>">Eliminar</a></td>
				</tr>
				<tr>
					<td colspan="5"><?php echo $array_rpta['descripcion']; ?></td>
				</tr>
		<?php
		}
	}

	public function removeTratamientoById($id) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("DELETE FROM tratamiento WHERE id = $id");
		$this->alerta = "exito";
		$this->mensaje = "Tratamiento eliminado correctamente, redireccionando en <span id='tiempo'>5</span> segundos.";
	}

	// (!) Externos al módulo "tratamiento":

	public function getAllFromTratamientoAJAX() {
		$obj_bd = Db::getInstancia();
		return $sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nombre FROM tratamiento;");
	}

	// 
	public function getFromTratamientobyId($id) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT id, nombre, descripcion, tiempo, costo FROM tratamiento WHERE id = $id;");
		while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
			$this->nombre = $array_rpta['nombre'];
			$this->descripcion = $array_rpta['descripcion'];
			$this->hora = $array_rpta['tiempo'];
			$this->costo = $array_rpta['costo'];
		}
	}

	public function getAllFromTratamientobyNombreAJAX($criterio) {
		$obj_bd = Db::getInstancia();
		$sql_stmt = $obj_bd->ejecutar_consulta("SELECT * FROM tratamiento WHERE nombre = '$criterio';");
		if($obj_bd->obtener_fila($sql_stmt, 0)) {
			$sql_stmt = $obj_bd->ejecutar_consulta("SELECT * FROM tratamiento WHERE nombre = '$criterio';");
			while ($array_rpta = $obj_bd->obtener_fila($sql_stmt, 0)) {
				$tiempo = explode(":", $array_rpta['tiempo']);
				?>
				<legend class="legend-exito">Tratamiento: <? echo $array_rpta['nombre']; ?></legend>
				<br />
				<div class="ajax-list">Tiempo de atención estimado: <b><? echo $tiempo[0].":".$tiempo[1]; ?> hrs</b>, costo variable: <b>S/. <? echo number_format($array_rpta['costo'], 2, '.', ''); ?></b>.</div>
				<br />
				<? echo $array_rpta['descripcion']; ?>
				<br />
				<br />
				<div class="ajax-list">Costo final: 
				<input id="t_costo" name="t_costo" onclick="this.value = ''" onblur="this.value = moneda(this.value)" pattern="\d+(\.\d{2})?" placeholder="0.00" autocomplete="off" type="text" value="<? echo number_format($array_rpta['costo'], 2, '.', ''); ?>" /> S/.</div>
				<!-- I - Campos AJAX -->
				<input id="t_nombre" name="t_nombre" readonly class="campo-ajax" value="<? echo $array_rpta['nombre']; ?>" />
				<input id="t_tiempo" name="t_tiempo" readonly class="campo-ajax" value="<? echo $tiempo[0].":".$tiempo[1]; ?>" />
				<!-- F - Campos AJAX -->
				<br />
				<br />
				<input onclick="validarcosto();" type="button" class="btn" value="Agregar a la lista de tratamientos">
				<?php
			}
		} else {
			?>
			<legend class="legend-error">Error: Tratamiento seleccionado</legend>
			<br />
			No se han encontrado coincidencias con el tratamiento seleccionado.
			<?
		}
	}
	// Método (Público): Modificar de tratamiento
	public function modificarTratamiento($id, $nombre, $descripcion, $tiempo, $costo) {
		
		// Obtengo los datos del propio tratamiento
		$this->getFromTratamientobyId($id);
		$obj_bd = Db::getInstancia();
		// Validación: El tratamiento ya existe en la Bd.
		if($this->nombre != $nombre) {
			$sql_stmt = $obj_bd->ejecutar_consulta("SELECT nombre FROM tratamiento WHERE nombre = '".$nombre."';");
			if($obj_bd->obtener_fila($sql_stmt, 0)) {
				$this->alerta = "alerta";
				$this->mensaje = "El nombre del tratamiento ya existe.";
				return false;
			}
		}
	
		$consult_sql = "UPDATE tratamiento SET nombre ='$nombre', 
							   nombre ='$nombre',
							   descripcion ='$descripcion',
							   tiempo ='$tiempo',
							   costo ='$costo'
			WHERE id = $id;";

		if($obj_bd->ejecutar_consulta($consult_sql)) {
			$this->alerta = "exito";
			$this->mensaje = "El tratamiento ha sido editado correctamente.";
		} else {
			$this->alerta = "error";
			$this->mensaje = "Ha ocurrido un error en la base de datos.";
			return false;
		}
		return true;
	}
}
?>