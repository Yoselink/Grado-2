<?
require_once 'funciones/conex.php';

$conex = new Conex();
var_dump($conex);
$conex->prepare("SELECT * FROM user");

