<?php
session_start();
requireValidSession();

loadModel('WorkingHours');

$date = (new Datetime())->getTimestamp(); //aqui guardei os valores da função de data e hora atual na variável
$today = strftime('%d de %B de %Y', $date);
//guardei as formações de data na variável today

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

//aqui aqui carreguei a view juntamente com a variável que contém  a data e hora atuais
loadTemplateView('day_records', [
  'today' => $today,
  'records' => $records
]);
 ?>
