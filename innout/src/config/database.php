<?php

class Database{
  //função pública estática para fazer a conexão com banco de dados
  public static function getConnection(){
    //aqui criei uma variavel para definir o caminho dos dados de conexão
    $envPath = realpath(dirname(__FILE__) . '/../env.ini');
    // realpath é utilizado para mostrar o caminho até o arquivo
    // dirname retorna o caminho do diretório pai
    $env = parse_ini_file($envPath);
    //parse_ini_file é utilizado para interpretar um arquivo .INI, nesse caso o arquivo foi guardado dentro da váriavel
    $conn = new mysqli($env['host'], $env['username'],
    $env['password'], $env['database']);
    //aqui passei os parâmetros da conexão encontrados no arquivo .INI

    if ($conn->connect_error) { //se a o erro de conexão for verdadeiro
      die("Erro: " . $conn->connect_error); //retorna erro
    } else {
      return $conn; //senão retornar a conexão
    }

  }

  public static function getResultFromQuery($sql){ //função criada para mostrar o resultado prévio da consulta sql
    $conn = self::getConnection();
    //variável utilizada para armazenar a chamada do método da conexão
    $result = $conn->query($sql);
    //aqui utilizei uma variável para guardar o resultado da conexão com bo banco de dados
    $conn->close();
    return $result;
  }

  public static function executeSQL($sql){
    $conn = self::getConnection();
    if(!mysqli_query($conn, $sql)) {
      throw new Exception(mysqli_error($conn));
    }
    $id = $conn->insert_id;
    $conn->close();
    return $id;
  }
}

 ?>
