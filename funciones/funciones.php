<?
namespace Funciones;

if(!class_exists('Database\Conex')){
	require 'conex.php';	
}

class Funciones{
	private $enlace;
	private $return;

	public function __CONSTRUCT()
	{
		$this->enlace = new \Database\Conex();
	}

	public function login($email,$pass)
	{
		$query = $this->enlace->prepare("SELECT * FROM user WHERE email = ?");
		$query->bind_param("s",$email);
		$query->execute();
		$response = $query->get_result();

		if($response->num_rows>0){
			$user = $response->fetch_array(MYSQLI_ASSOC);
			if(password_verify($pass,$user['password']) ) {
				$_SESSION['id']    = $user['id_user'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['nivel'] = $user['nivel'];

				$this->return = array("r"=>true,"msj"=>"Iniciando sesion...");

			}else{
				$this->return = array("r"=>false,"msj"=>"Usuario y/o clave incorrectos");
			}
		}else{
			$this->return = array("r"=>false,"msj"=>"Usuario y/o clave incorrectos");
		}

		echo json_encode($this->return);
	}


	public function logout(){
		session_start();
		session_destroy();
		$this->return = array("r"=>true);
		echo json_encode($this->return);
	}

}//Class Funciones

$modelFunciones = new Funciones();

if(isset($_POST['action'])):
  switch ($_POST['action']):
		case 'login':
			$email = $_POST['email'];
			$pass  = $_POST['password'];

			$modelFunciones->login($email,$pass);
		break;

		case 'logout':
			
			$modelFunciones->logout();
		break;
	endswitch;
endif;
?>