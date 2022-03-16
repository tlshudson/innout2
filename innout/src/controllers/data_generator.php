<?php
loadModel('WorkingHours');

Database::executeSQL('DELETE FROM working_hours');
Database::executeSQL('DELETE FROM users where id > 5');

//esta função tem como base calcular o horário regular, extra e horário atrasado que um funcionário trabalha
function getDayTemplateByOdds($regularRate, $extraRate, $lazyRate){
  $regularDayTemplate = [
    'time1' => '08:00:00',
    'time2' => '12:00:00',
    'time3' => '13:00:00',
    'time4' => '17:00:00',
    'worked_time' => DAILY_TIME
  ]; //dia normal de um funcionário que bate o ponto no horário exato

  $extraHourDayTemplate = [
    'time1' => '08:00:00',
    'time2' => '12:00:00',
    'time3' => '13:00:00',
    'time4' => '18:00:00',
    'worked_time' => DAILY_TIME + 3600
  ]; //dia de um funciário que faz horaŕio extra, aqui adicionamos 3600 que convertido dá 1 hora extra trabalhada

  $lazyDayTemplate = [
    'time1' => '08:30:00',
    'time2' => '12:00:00',
    'time3' => '13:00:00',
    'time4' => '17:00:00',
    'worked_time' => DAILY_TIME - 1800
  ]; //dia de um funcionário que chega atrasado, aqui é retirado 30min em formato de segundos pois o fun. se atrasou

  $value = rand(0, 100); //aqui a porcentagem do fucionário fazer 3 dias de trabalho diferente
  if ($value <= $regularRate) { //se a porcentagem fosse menor ou igual a um dia normal de trabalho
    return $regularDayTemplate; //retorne ao um dia normal de serviço
  } elseif ($value <= $regularRate + $extraRate) { //senão verifique se é menor ou igual a um dia normal com adicional de horário
    return $extraHourDayTemplate; //retorne a horário extra de trabalho
  } else { //se não
    return $lazyDayTemplate; //retorne a um dia que faltou cumprir o horário
  }
}

//função para prencher as horas trabalhadas
function populateWorkingHours($userId, $initialDate,
 $regularRate, $extraRate, $lazyRate){
    $currentDate = $initialDate; //data atual recebe data inicial
    $yesterday = new DateTime(); //forneci uma nova data em today
    $yesterday->modify('-1 day');
    $columns = ["id" => null, 'user_id' => $userId, 'work_date' => $currentDate]; //aqui guardei informações do banco de dados em variáveis

    while(isBefore($currentDate, $yesterday)) { //enquanto(função para verificar se a data é antiga), pega data atual e data de hoje
      if (!isWeekend($currentDate)) { //se (função verifica fim de semana com parâmetro da data atual) for falsa
        $template = getDayTemplateByOdds($regularRate, $extraRate, $lazyRate); //template recebe os parâmetros de dias trabalhados dos funcionários
        $columns = array_merge($columns, $template); //colunas recebe uma função que combina um ou mais arrays
        $workingHours = new WorkingHours($columns); //working_hours recebe a classe com banco de dados, com os parâmetros com os arrays de columns
        $workingHours->insert();//apontei a função save que faz a conexão e traz as informaçãos do SQL
      }
      //aqui trouxe a data atual, recebendo a data do próximo dia com um formato
      $currentDate = getNextDay($currentDate)->format('Y-m-d');
      $columns['work_date'] = $currentDate; //atribui um array a uma variável com função de formato de data
    }
}

$lastMonth = strtotime('first day of last month');
populateWorkingHours(1, date('Y-m-1'), 70, 20, 10);
populateWorkingHours(3, date('Y-m-d', $lastMonth), 20, 75, 5);
populateWorkingHours(4, date('Y-m-d', $lastMonth), 20, 10, 70);

echo "Deu tudo certo!";
 ?>
