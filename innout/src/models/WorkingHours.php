<?php
//este arquivo tem como função fornecer o modelo de horas trabalhadas de cada funcionário
class WorkingHours extends Model{
  protected static $tableName = 'working_hours';
  //variável estática protegida que guarda o nome da tabela no SQL
  protected static $columns = [
      'id',
      'user_id',
      'work_date',
      'time1',
      'time2',
      'time3',
      'time4',
      'worked_time'
    ];
    //variável protegida que guarda os parâmetros de  colunas do banco de dados

  public static function loadFromUserAndDate($userId, $workDate){
    $registry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);

    if (!$registry) {
     $registry = new WorkingHours([
        'user_id' => $userId,
        'work_date' => $workDate,
        'worked_time' => 0
       ]);
     }
     return $registry;
    }
    
    public function getNextTime(){
      if(!$this->time1) return 'time1';
      if(!$this->time2) return 'time2';
      if(!$this->time3) return 'time3';
      if(!$this->time4) return 'time4';
   return null;
  }

  public function innout($time){
    $timeColumn = $this->getNextTime();
    if (!$timeColumn) {
    throw new AppException("Você já fez os 4 batimentos do dia!");
    }
    
    $this->timeColumn = $time;
    if ($this->id) {
      $this->updtate();
    } else{
      $this->insert();
    }
  }
}

 ?>
