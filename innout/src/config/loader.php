<?php
//esta função tem como objetivo fazer um require com a extensão automática do arquivo desejado
function loadModel($modelName) {
  require_once (MODEL_PATH . "/{$modelName}.php");
}
//esta função view recebe o nome do arquivo e um parâmetro em forma de array para ser impresso
function loadView($viewName, $params = array()){
  if (count($params) > 0) {//se a contagem de parametros for maior que 0
    foreach ($params as $key => $value) { //para cada parâmetro temos chave apontada em valor
      if (strlen($key) > 0) { //se a contagem de strings armazenadas em chave for maior que 0
        ${$key} = $value; //aqui fiz o formato que o parÂmetro impresso será recebido
      } //aponto uma chave(texto) = valor(que será impresso)*
    }
  }
  require_once(VIEW_PATH . "/{$viewName}.php");
}

function loadTemplateView($viewName, $params = array()){
if (count($params) > 0) {//se a contagem de parametros for maior que 0
  foreach ($params as $key => $value) { //para cada parâmetro temos chave apontada em valor
    if (strlen($key) > 0) { //se a contagem de strings armazenadas em chave for maior que 0
      ${$key} = $value; //aqui fiz o formato que o parÂmetro impresso será recebido
    } //aponto uma chave(texto) = valor(que será impresso)*
  }
}

$user = $_SESSION['user'];
$workingHours = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
$workedInterval = $workingHours->getWorkedInterval()->format('%H:%I:%S');
$exitTime = $workingHours->getExitTime()->format('H:i:s');

require_once(TEMPLATE_PATH . "/header.php");
require_once(TEMPLATE_PATH . "/left.php");
require_once(VIEW_PATH . "/{$viewName}.php");
require_once(TEMPLATE_PATH . "/footer.php");
}

//função utilizada para renderizar os ícones na tela de registros de dias trabalhados
function renderTitle($title, $subtitle, $icon = null){
  require_once(TEMPLATE_PATH . "/title.php");
}
 ?>
