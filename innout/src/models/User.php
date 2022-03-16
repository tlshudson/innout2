<?php
class User extends Model{
  protected static $tableName = 'users';
  //aqui guardei a informção dos users dentro de uma variável
  protected static $columns = [
      'id',
      'name',
      'password',
      'email',
      'start_date',
      'end_date',
      'is_admin',
    ];
    //aqui guardei os parâmetros que um usuário tem dentro de uma variável
}

 ?>
