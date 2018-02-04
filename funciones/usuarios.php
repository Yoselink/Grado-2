<?
namespace Funciones;

if(!class_exists('\Database\Conex')){
	require 'conex.php';	
}

class Usuarios{
	private $enlace;
	private $fecha;
	private $return;

	public function __CONSTRUCT()
	{
		$this->enlace = new \Database\Conex();
		$this->fecha = date("Y-m-d H:i:s");
	}

	public function consulta()
	{

    $query = $this->enlace->query("SELECT * FROM user");
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

	public function consultaDivision()
	{

    $query = $this->enlace->query("SELECT * FROM divisiones");
    $data = array();

    while($row = $query->fetch_array()){
    	$data[] = (object)$row;
    }

    return $data;
	}//consulta

	

	public function obtener($id)
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

	public function add($nombre,$apellido,$cedula,$nivel,$division,$email,$pass)
	{
		$query = $this->enlace->prepare("SELECT email FROM user WHERE email = ? LIMIT 1");
		$query->bind_param("s",$email);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){
    	$this->return = array("r"=>false,"msj"=>"Email ya registrado!");
		}else{
			$query = $this->enlace->prepare("SELECT cedula FROM user WHERE cedula = ? LIMIT 1");
			$query->bind_param("s",$cedula);
			$query->execute();
			$response = $query->get_result();

			if($response->num_rows>0){
				$this->return = array("r"=>false,"msj"=>"Cedula ya registrada!");
			}else{
		  	$query = $this->enlace->prepare("INSERT INTO user (email,nombre,apellido,cedula,nivel,division_id,password,fecha_reg)
											VALUES(?,?,?,?,?,?,?,?)");
		  	$query->bind_param("ssssiiss",$email,$nombre,$apellido,$cedula,$nivel,$division,$pass,$this->fecha);

		  	if($query->execute()){
					$this->return = array("r"=>true,"msj"=>"Usuario registrado con exito!");
		  	}else{
					$this->return = array("r"=>false,"msj"=>$this->enlace->error());
		  	}
		  }
		}

		echo json_encode($this->return);
		
	}//add

	public function edit($id,$nombre,$apellido,$cedula,$nivel,$division,$email)
	{
		$query = $this->enlace->prepare("SELECT email FROM user WHERE email = ? AND id_user != ? LIMIT 1");
		$query->bind_param("si",$email,$id);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){
    	$this->return = array("r"=>false,"msj"=>"Email ya registrado!");
		}else{
			$query = $this->enlace->prepare("SELECT cedula FROM user WHERE cedula = ? AND id_user != ? LIMIT 1");
			$query->bind_param("si",$cedula,$id);
			$query->execute();
			$response = $query->get_result();

			if($response->num_rows>0){
				$this->return = array("r"=>false,"msj"=>"Cedula ya registrada!");
			}else{
		  	$query = $this->enlace->prepare("UPDATE user SET
									  												email       = ?,
																						nombre      = ?,
																						apellido    = ?,
																						cedula      = ?,
																						nivel       = ?,
																						division_id = ?
																					WHERE id_user = ? LIMIT 1");

		  	$query->bind_param("ssssssi",$email,$nombre,$apellido,$cedula,$nivel,$division,$id);

		  	if($query->execute()){
					$this->return = array("r"=>"mod","msj"=>"Cambios guardados con exito!","reload"=>true,"redirect"=>"?ver=usuarios&opc=ver&id=".$id);
			  }else{
			    $this->return = array("r"=>false,"msj"=>"Ha ocurrido un error!");
			  }
			}
		}

		echo json_encode($this->return);

	}//Modificar usuario

}//Class Usuarios

$modelUser = new Usuarios();

if(isset($_POST['action'])):
  switch ($_POST['action']):
		case 'add':
			$nombre   = ucwords(strtolower($_POST["nombre"]));
			$apellido = ucwords(strtolower($_POST["apellido"]));
			$cedula   = $_POST["cedula"];
			$nivel    = $_POST["nivel"];
			$division = $_POST["division"];
			$email     = ucfirst(strtolower($_POST["email"]));
			$pass      = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$modelUser->add($nombre,$apellido,$cedula,$nivel,$division,$email,$pass);
		break;

		case 'edit':
			$id        = $_POST["id"];
			$nombre   = ucwords(strtolower($_POST["nombre"]));
			$apellido = ucwords(strtolower($_POST["apellido"]));
			$cedula   = $_POST["cedula"];
			$nivel    = $_POST["nivel"];
			$division = $_POST["division"];
			$email     = ucfirst(strtolower($_POST["email"]));
			
			$modelUser->edit($id,$nombre,$apellido,$cedula,$nivel,$division,$email);
		break;
	endswitch;
endif;
?>