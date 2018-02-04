<?
if(!class_exists('Database\Conex')){
	require 'conex.php';	
}

class Niveles{
	private $enlace;
	private $fecha;
	private $return;

	public function __CONSTRUCT()
	{
		$this->enlace = new Database\Conex();
		$this->fecha = date("Y-m-d H:i:s");
	}

	public function consulta()
	{

    $query = $this->enlace->query("SELECT * FROM nivel");
    $data = array();

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	public function consultaNivel()
	{

    $query = $this->enlace->query("SELECT * FROM nivel");
    $data = array();

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	public function obtener($id) 
	{

    $query = $this->enlace->prepare("SELECT * FROM nivel WHERE id_nivel = ?",array("i",$id));
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

	public function niveles($id)
	{

    	$query = $this->enlace->prepare("SELECT * FROM user WHERE id_user = ?");
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

	public function add($nivel,$descripcion)
	{
		$query = $this->enlace->prepare("SELECT nombre_nivel FROM nivel WHERE nombre_nivel = ? LIMIT 1");
		$query->bind_param("s",$nivel);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){
    	$this->return = array("r"=>false,"msj"=>"Nivel ya registrado!");
		}else{
		  	$query = $this->enlace->prepare("INSERT INTO nivel (nombre_nivel,descripcion)
											VALUES(?,?)");
		  	$query->bind_param("ss",$nivel,$descripcion);

		  	if($query->execute()){
					$this->return = array("r"=>true,"msj"=>"Nivel registrado con exito!");
		  	}else{
					$this->return = array("r"=>false,"msj"=>$this->enlace->error());
		  	}
		  
		}
		

		echo json_encode($this->return);
		
	}//add
	
	//EDITAR niveles
	public function edit($id_nivel,$nombre_nivel,$descripcion)
	{
		$query = $this->enlace->prepare("SELECT nombre_nivel FROM nivel WHERE nombre_nivel = ? LIMIT 1");
		$query->bind_param("s",$nivel);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){  
    	$this->return = array("r"=>false,"msj"=>"Nivel ya registrado!");
		}else{
			

			
		  	$query = $this->enlace->prepare("UPDATE nivel SET
									  												
																						nombre_nivel       = ?,
																						descripcion = ?
																					WHERE id_nivel = ? LIMIT 1");

		  	$query->bind_param("ssi",$nombre_nivel,$descripcion,$id_nivel);

		  	if($query->execute()){
					$this->return = array("r"=>"mod","msj"=>"Cambios guardados con exito!","reload"=>true,"redirect"=>"?ver=niveles");
			  }else{
			    $this->return = array("r"=>false,"msj"=>"Ha ocurrido un error!");
			  }
			
		}

		echo json_encode($this->return);

	}//Modificar usuario

	//fin editar niveles

}//Class Usuarios

$modelNiveles = new Niveles();

if(isset($_POST['action'])):
  switch ($_POST['action']):
		case 'add':	
			$nivel    = $_POST["nivel"];
			$descripcion = $_POST["descripcion"]; 

			$modelNiveles->add($nivel,$descripcion); 
		break;

	case 'edit':
			$id_nivel        = $_POST["id"];
			$nombre_nivel   = ucwords(strtolower($_POST["nivel"]));
			$descripcion = ucwords(strtolower($_POST["descripcion"]));

			
			$modelNiveles->edit($id_nivel,$nombre_nivel,$descripcion);
		break;
	endswitch;
endif;
?>