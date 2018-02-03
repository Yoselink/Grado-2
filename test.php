<?
require_once 'funciones/conex.php';

$conex = new Conex();

$conex->prepare("SELECT * FROM user");

