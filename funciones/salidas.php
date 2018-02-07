<?
namespace Funciones;

if(!class_exists('\Database\Conex')){
	require 'conex.php';	
}

class Salidas{
	private $enlace;
	private $return;
	private $user;

	public function __CONSTRUCT()
	{
		$this->enlace = new \Database\Conex();
		$this->user   = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
	}

	public function consulta()
	{
    $query = $this->enlace->query("SELECT s.*,u.id_user,u.nombre,u.apellido
																							FROM salidas AS s
																							INNER JOIN user AS u ON u.id_user = s.id_user");
    $data = [];

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	public function selectByType($type)
	{
    $query = $this->enlace->query("SELECT s.*,u.id_user,u.nombre,u.apellido
																							FROM salidas AS s
																							INNER JOIN user AS u ON u.id_user = s.id_user
																							WHERE tipo = {$type}");
    $data = [];

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	public function countByType($type)
	{
		$query = $this->enlace->prepare("SELECT COUNT(id_salida) AS salidas,SUM(cantidad) AS cantidad FROM salidas WHERE tipo = ?");
		$query->bind_param('i',$type);
		$query->execute();
		$response = $query->get_result();

    if($response->num_rows>0){
			$data = (object) $response->fetch_array(MYSQLI_ASSOC);
		}else{
			$data = NULL;
		}

		return $data;
	}

	public function obtener($id) 
	{
    $query = $this->enlace->prepare("SELECT s.*,u.id_user,u.nombre,u.apellido,u.cedula,u.email
																							FROM salidas AS s
																							INNER JOIN user AS u ON u.id_user = s.id_user
																						WHERE s.id_salida = ? LIMIT 1",array('i',$id));
		$query->bind_param('i',$id);
		$query->execute();
		$response = $query->get_result(); 

    if($response->num_rows>0){
			$data = (object) $response->fetch_array(MYSQLI_ASSOC);
		}else{
			$data = NULL;
		} 

    return $data;
	}//obtener

	//Obtener todos las salidas de un producto
	public function get($producto){
		$query = $this->enlace->prepare("SELECT s.*,u.id_user,u.nombre,u.apellido
																							FROM salidas AS s
																							INNER JOIN user AS u ON u.id_user = s.id_user
																							WHERE s.id_producto = ?");
		$query->bind_param('i',$producto);
		$query->execute();
		$response = $query->get_result();
    $data = [];

    while($row = $response->fetch_array()){
    	$data[] = (object)$row;
    }

		return $data;
	}

	//Agregar salida
	public function add($producto,$cantidad)
	{
		$query = $this->enlace->prepare("SELECT * FROM productos WHERE id_producto = ? LIMIT 1");
		$query->bind_param('i',$producto);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows > 0){
			$item = (object) $response->fetch_array(MYSQLI_ASSOC);

			if( ($item->cantidad - $cantidad) >= 0 ){

				$actualiza = $this->actualizarInventario($producto,$cantidad);

				if($actualiza){
					$query = $this->enlace->prepare("INSERT INTO salidas (id_user,id_producto,tipo,contenido,cantidad)
																													VALUES(?,?,?,?,?)");

					$contenido = "<b>Producto:</b> {$item->nombre_producto}<br>";
					$contenido .= "<b>Descripcion:</b> {$item->descripcion}<br>";
					$contenido .= "<b>Modelo:</b> {$item->modelo}";

			  	$query->bind_param("iiisi",$this->user,$producto,$item->tipo,$contenido,$cantidad);

			  	if($query->execute()){
						$this->return = array('r'=>true,'msj'=>'Salida registrada con exito!','reload'=>true,'redirect'=>'?ver=salidas&opc=ver&id='.$query->insert_id);
			  	}else{
			  		//Rollback
			  		//Devolver el inventario restado anteriormente
			  		$this->actualizarInventario($producto,$cantidad,true);

						$this->return = array("r"=>false,"msj"=>"Ha ocurrido un error.");
			  	}
			  }else{
    			$this->return = array("r"=>false,"msj"=>"Ha ocurrido un error1.");
			  }
		  }else{
    		$this->return = array("r"=>false,"msj"=>"La cantidad supera lo actual disponible.");
		  }
		}else{
    	$this->return = array("r"=>false,"msj"=>"Producto no encontrado.");
		}
		
		echo json_encode($this->return);
	}//add

	private function actualizarInventario($producto,$cantidad,$suma = false){
		//Si suma es true, se suma la cantidad al inventario,  sino, se resta

		$cantidad = $suma ? $cantidad : ($cantidad*-1);

		$query = $this->enlace->prepare("UPDATE productos SET cantidad = cantidad + ? WHERE id_producto = ? LIMIT 1");
		$query->bind_param('ii',$cantidad,$producto);

		return $query->execute();
	}

}

$modelSalidas = new \Funciones\Salidas();

if(isset($_POST['action'])):
  switch ($_POST['action']):
		case 'add_salida':	
			$producto    = $_POST["producto"];
			$cantidad    = $_POST["cantidad"];

			$modelSalidas->add($producto,$cantidad);
		break;
	endswitch;
endif;
?>