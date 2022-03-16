<?php

//função para obter a data atual
function getDateAsDateTime($date){ //recebe como parâmetro a formatação da
  return is_string($date) ? new DateTime($date) : $date;
  //retorne a data se for string, senão retorne a um novo formato de data, retorne data
}

//função que verifica se está em uma semana
function isWeekend($date){
  $inputDate = getDateAsDateTime($date);
  return $inputDate->format('N') >= 6;
  //retorne a data que se for maior ou igual a 6, está em um fim de semana
}

//função que verifica a menor data
function isBefore($date1, $date2){
  $inputDate1 = getDateAsDateTime($date1);
  $inputDate2 = getDateAsDateTime($date2);
  return $inputDate1 <= $inputDate2;
}

//função para obter o próximo dia
function getNextDay($date) {
  $inputDate = getDateAsDateTime($date);
  $inputDate->modify('+1 day');
  return $inputDate;
}
 ?>
