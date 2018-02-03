<?

class Conex {
  // The database connection
  protected static $conex;

  public function connect() {

    if(!isset(self::$conex)) {
      
			mysqli_report(MYSQLI_REPORT_STRICT);
      self::$conex = new mysqli("localhost","root","", "upel");
    }

    if(self::$conex === false) {
      // Handle error - notify administrator, log to a file, show an error screen, etc.
      return false;
    }
    return self::$conex;
  }

  public function query($query) {
    $conex = $this -> connect();
    
    $result = $conex -> query($query);

    return $result;
  }

  public function prepare($query) {
    $conex = $this -> connect();
    
    $result = $conex -> prepare($query);

    return $result;
  }

  public function error() {
    $conex = $this -> connect();
    	return $conex -> error;
    }
}

?>