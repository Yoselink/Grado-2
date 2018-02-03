<?
require 'conex.php';

class materiales{
	private $enlace;
	private $fecha;
	private $return;

	public function __CONSTRUCT()
	{
		$this->enlace = new Conex();
		$this->fecha = date("Y-m-d H:i:s");
	}

	public function consulta()
	{

    $query = $this->enlace->query("SELECT * FROM material");
    $data = array();

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	public function consultaMateriales()
	{

    $query = $this->enlace->query("SELECT * FROM material");
    $data = array();

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	public function obtener($id) 
	{

    $query = $this->enlace->prepare("SELECT * FROM material WHERE id_material = ?",array("i",$id));
		$query->bind_param("i",$id);
		$query->execute();
		$response = $query->get_result(); 

    if($response->num_rows>0){
			$data = (object) $response->fetch_array(MYSQLI_ASSOC);
		}else{
			$data = NULL;
		} 

    return $data;
	}//obtener

	public function material($id)
	{

    	$query = $this->enlace->prepare("SELECT * FROM material WHERE id_material = ?");
		$query->bind_param("i",$id);
		$query->execute();
		$response = $query->get_result();

    if($response->num_rows>0){
			$data = (object) $response->fetch_array(MYSQLI_ASSOC);
		}else{
			$data = NULL;
		}

    return $data;
	}//obtener

	public function add($material,$descripcion,$cantidad)
	{
		$query = $this->enlace->prepare("SELECT nombre_material FROM material WHERE nombre_material = ? LIMIT 1");
		$query->bind_param("s",$nombre_material);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){
    	$this->return = array("r"=>false,"msj"=>"Material ya registrado!");
		}else{
		  	$query = $this->enlace->prepare("INSERT INTO material (nombre_material,descripcion,cantidad)
											VALUES(?,?,?)");
		  	$query->bind_param("ssi",$material,$descripcion,$cantidad);

		  	if($query->execute()){
					$this->return = array("r"=>true,"msj"=>"Material con exito!");
		  	}else{
					$this->return = array("r"=>false,"msj"=>$this->enlace->error());
		  	}
		  
		}
		

		echo json_encode($this->return);
		
	}//add
	
	//EDITAR materiales
	public function edit($id_material,$nombre_material,$descripcion,$cantidad)
	{
		$query = $this->enlace->prepare("SELECT nombre_material FROM material WHERE nombre_material = ? LIMIT 1");
		$query->bind_param("s",$material);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){  
    	$this->return = array("r"=>false,"msj"=>"Material ya registrado!");
		}else{
			

			
		  	$query = $this->enlace->prepare("UPDATE material SET
									  												
																						nombre_material = ?,
																						descripcion = ?,
																						cantidad= ?
																					WHERE id_material = ? LIMIT 1");

		  	$query->bind_param("ssii",$nombre_material,$descripcion,$cantidad,$id_material);

		  	if($query->execute()){
					$this->return = array("r"=>"mod","msj"=>"Cambios guardados con exito!","reload"=>true,"redirect"=>"?ver=materiales");
			  }else{
			    $this->return = array("r"=>false,"msj"=>"Ha ocurrido un error!");
			  }
			
		}

		echo json_encode($this->return);

	}//Modificar usuario

	//fin editar niveles

}//Class Usuarios

$modelMateriales = new Materiales();

if(isset($_POST['action'])):
  switch ($_POST['action']):
		case 'add':	
			$material    = $_POST["material"];
			$descripcion = $_POST["descripcion"];
			$cantidad = $_POST["cantidad"];

			$modelMateriales->add($material,$descripcion,$cantidad); 
		break;

	case 'edit':
			$id_material        = $_POST["id"];
			$nombre_material   = ucwords(strtolower($_POST["material"]));
			$descripcion = ucwords(strtolower($_POST["descripcion"]));
			$cantidad = $_POST["cantidad"];

			
			$modelMateriales->edit($id_material,$nombre_material,$descripcion,$cantidad);
		break;
	endswitch;
endif;
?>