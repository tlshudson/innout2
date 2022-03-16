<!-- Este controller, faz com que a parte de login seja chamada por model e funcione de maneira obejtiva
para receber os dados na tela de login -->

<?php
loadModel('Login'); //aqui carreguei o modelo que irá trazer o funcionamento correto desse arquivo
session_start();
$exception = null;

if(count($_POST) > 0) { //se a contagem de dados recebida de $_POST for maior que 0
  $login = new Login($_POST); //armazenei os dados de um novo login em uma variável
  try {//aqui joguei os dados de validação fornecidos pelo usuário
    $user = $login->checkLogin();
    $_SESSION['user'] = $user;
    header("Location: day_records.php");
    // echo "Usuário logado!";
  } catch (AppException $e) { //aqui capturei as EXCEÇÕES com os erros
    $exception = $e; //aqui fiz o tratamento de exceções
  }

}

loadView('login', $_POST + ['exception' => $exception]);
//aqui carreguei a parte visual desse script,  juntamente com as exceções recebidas em $_POST
 ?>
