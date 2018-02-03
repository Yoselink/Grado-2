<?
require 'conex.php';

class solicitudes{
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

    $query = $this->enlace->query("SELECT * FROM solicitudes");
    $data = array();

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	public function consultaSolicitudes()
	{

    $query = $this->enlace->query("SELECT * FROM solicitudes");
    $data = array();

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	public function obtener($id) 
	{

    $query = $this->enlace->prepare("SELECT * FROM solicitudes WHERE id_solicitud = ?",array("i",$id));
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

	public function material(solicitudes
    	$query = $this->enlace->prepare("SELECT * FROM solicitudes WHERE id_solicitud= ?");
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

	public function add($solicitudes,$nombre_solicitud,$area_solicitud,$descripcion)
	{
		$query = $this->enlace->prepare("SELECT nombre_solicitud FROM solicitudes WHERE nombre_solicitud = ? LIMIT 1");
		$query->bind_param("s",$nombre_solicitud);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){
    	$this->return = array("r"=>false,"msj"=>"Solicitud registrada!");
		}else{
		  	$query = $this->enlace->prepare("INSERT INTO solicitudes (nombre_solicitud,area_solicitud,descripcion)
											VALUES(?,?,?)");
		  	$query->bind_param("sss",$solicitudes,$area_solicitud,$descripcion);

		  	if($query->execute()){
					$this->return = array("r"=>true,"msj"=>"Solicitud registrada con exito!");
		  	}else{
					$this->return = array("r"=>false,"msj"=>$this->enlace->error());
		  	}
		  
		}
		

		echo json_encode($this->return);
		
	}//add
	
	//EDITAR materiales
	public function edit($id_solicitud,$nombre_solicitud,$area_solicitud,$descripcion)
	{
		$query = $this->enlace->prepare("SELECT nombre_solicitud FROM material WHERE nombre_solicitud = ? LIMIT 1");
		$query->bind_param("s",$solicitudes);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){  
    	$this->return = array("r"=>false,"msj"=>"Solicitud ya registrada!");
		}else{
			

			
		  	$query = $this->enlace->prepare("UPDATE solicitudes SET
									  												
																						nombre_solicitud = ?,
																						area_solicitud = ?,
																						descripcion= ?
																					WHERE id_solicitud = ? LIMIT 1");

		  	$query->bind_param("sssi",$nombre_solicitud,$area_solicitud,$descripcion,$id_solicitud);

		  	if($query->execute()){
					$this->return = array("r"=>"mod","msj"=>"Cambios guardados con exito!","reload"=>true,"redirect"=>"?ver=solicitudes");
			  }else{
			    $this->return = array("r"=>false,"msj"=>"Ha ocurrido un error!");
			  }
			
		}

		echo json_encode($this->return);

	}//Modificar usuario

	//fin editar niveles

}//Class Usuarios

$modelSolicitudes = new Solicitudes();

if(isset($_POST['action'])):
  switch ($_POST['action']):
		case 'add':	
			$nombre_solicitud = $_POST["nombre_solicitud"];
			$area_solicitud = $_POST["area_solicitud"];
			$descripcion = $_POST["descripcion"];
			

			$modelSolicitudes->add($nombre_solicitud,$area_solicitud,$descripcion); 
		break;

	case 'edit':
			$id_solicitud        = $_POST["id"];
			$nombre_solicitud   = ucwords(strtolower($_POST["nombre_solicitud"]));
			$area_solicitud = ucwords(strtolower($_POST["area_solicitud"]));
			$descripcion = ucwords(strtolower($_POST["descripcion"]));
			

			
			$modelSolicitudes->edit($id_solicitud,$nombre_solicitud,$area_solicitud,$descripcion);
		break;
	endswitch;
endif;
?>