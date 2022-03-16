<?php
// error_reporting(0);
require_once(dirname(__FILE__, 2) .'/src/config/config.php');
//aqui resolvi o caminho do arquivo a ser utilizado

//urldecode é utilizado para codificar uma url a fim de não expor dados
$uri = urldecode(
  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
); //parse_url é utilizado para quebrar uma url em partes: host, port, user, path...
  //já no exemplo só pegamos a url que mostra a pasta que o site está

//se a uri for igual a uma '/' ou igual a uma string vazia ou igual a index,
if ($uri === '/' || $uri === '' || $uri === '/index.php') {
  $uri = '/day_records.php'; //defina o valor de uri para a view de day_records
}

//aqui fiz um require que chama a pasta controles para definir qual arquivo será chamado
require_once(CONTROLLER_PATH . "{$uri}");
 ?>
 