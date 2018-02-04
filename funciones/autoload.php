<?
//Funcion Autolad para cargar los archivos
function Autoload($classname)
{
	$x = explode('\\',$classname);
	$classname = end($x);
  //Can't use __DIR__ as it's only in PHP 5.3+
  $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.strtolower($classname).'.php';
  /*echo $filename."<br>";*/
  if (is_readable($filename)) {
    require_once $filename;
  }
}

if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
  //SPL autoloading was introduced in PHP 5.1.2
  if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
    spl_autoload_register('Autoload', true, true);
  } else {
    spl_autoload_register('Autoload');
  }
} else {
  function __autoload($classname)
  {
    Autoload($classname);
  }
}
?>