<?
namespace Funciones;

if(!class_exists('\Database\Conex')){
	require 'conex.php';	
}

class productos{
	private $enlace;
	private $return;
	private $producto;
	public $salidas;

	public function __CONSTRUCT()
	{
		$this->enlace  = new \Database\Conex();
		$this->salidas = new \Funciones\Salidas();
	}

	public function consulta()
	{
    $query = $this->enlace->query("SELECT * FROM productos");
    $data = array();

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	public function selectByType($type)
	{
		$query = $this->enlace->prepare("SELECT COUNT(id_producto) AS total FROM productos WHERE tipo = ?");
		$query->bind_param('i',$type);
		$query->execute();
		$response = $query->get_result();

    if($response->num_rows>0){
			$data = (object) $response->fetch_array(MYSQLI_ASSOC);
			$data = $data->total;
		}else{
			$data = NULL;
		}

		return $data;
	}

	public function obtener($id) 
	{

    $query = $this->enlace->prepare("SELECT * FROM productos WHERE id_producto = ? LIMIT 1",array("i",$id));
		$query->bind_param('i',$id);
		$query->execute();
		$response = $query->get_result();

    if($response->num_rows>0){
    	$this->producto = $id;
			$data = (object) $response->fetch_array(MYSQLI_ASSOC);
		}else{
			$data = NULL;
		}

    return $data;
	}//obtener

	public function add($producto,$tipo,$descripcion,$modelo,$cantidad)
	{
		$query = $this->enlace->prepare("SELECT nombre_producto FROM productos WHERE nombre_producto = ? LIMIT 1");
		$query->bind_param("s",$producto);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){
    	$this->return = array("r"=>false,"msj"=>"Producto ya registrado!");
		}else{
	  	$query = $this->enlace->prepare("INSERT INTO productos (nombre_producto,tipo,descripcion,modelo,cantidad)
																											VALUES(?,?,?,?,?)");
	  	$query->bind_param("sissi",$producto,$tipo,$descripcion,$modelo,$cantidad);

	  	if($query->execute()){
				$this->return = array("r"=>true,"msj"=>"Producto agregado con exito!");
	  	}else{
				$this->return = array("r"=>false,"msj"=>"Ha ocurrido un error.");
	  	}
		}
		
		echo json_encode($this->return);
	}//add
	
	//EDITAR productos
	public function edit($id,$producto,$tipo,$descripcion,$modelo,$cantidad)
	{
		$query = $this->enlace->prepare("SELECT nombre_producto FROM productos WHERE nombre_producto = ? AND id_producto != ? LIMIT 1");
		$query->bind_param('si',$producto,$id);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){  
    	$this->return = array("r"=>false,"msj"=>"Producto ya registrado!");
		}else{
	  	$query = $this->enlace->prepare("UPDATE productos SET
																		   			nombre_producto = ?,
																		   			tipo            = ?,
																			  		descripcion     = ?,
																			  		modelo          = ?,
																					  cantidad        = ?
																				  WHERE id_producto = ? LIMIT 1");

	  	$query->bind_param("sissii",$producto,$tipo,$descripcion,$modelo,$cantidad,$id);

	  	if($query->execute()){
				$this->return = array("r"=>"mod","msj"=>"Cambios guardados con exito!","reload"=>true,"redirect"=>"?ver=productos");
		  }else{
		    $this->return = array("r"=>false,"msj"=>"Ha ocurrido un error!");
		  }
		}

		echo json_encode($this->return);
	}//Modificar

	public function salidas(){
		return $this->salidas->get($this->producto);
	}

}

$modelProductos = new \Funciones\productos();

if(isset($_POST['action'])):
  switch ($_POST['action']):
		case 'add_producto':	
			$producto    = $_POST["producto"];
			$tipo        = $_POST["tipo"];
			$descripcion = $_POST["descripcion"];
			$modelo      = $_POST["modelo"];
			$cantidad    = $_POST["cantidad"];

			$modelProductos->add($producto,$tipo,$descripcion,$modelo,$cantidad);
		break;

	case 'edit_producto':
			$id          = $_POST["id"];
			$producto    = $_POST["producto"];
			$tipo        = $_POST["tipo"];
			$descripcion = $_POST["descripcion"];
			$modelo      = $_POST["modelo"];
			$cantidad    = $_POST["cantidad"];
			
			$modelProductos->edit($id,$producto,$tipo,$descripcion,$modelo,$cantidad);
		break;
	endswitch;
endif;
?>