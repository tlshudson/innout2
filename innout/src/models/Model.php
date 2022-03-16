<?php

//a classe model foi feita para realizar as consultas e buscar parâmetros comandados pelo user
class Model{
  protected static $tableName = '';
  protected static $columns = [];
  protected $values = [];
  //a propriedade values, recebe os valores dos arrays no formato chave => valor

  function __construct($arr){ //função para construir um array
    $this->loadFromArray($arr); //função para adicionar valores nos arrays
  }
//para esta função recebe-se uma variável com arrays contidos
  public function loadFromArray($arr){
    if ($arr) { //se $arr estiver setado
      foreach ($arr as $key => $value) { //aqui utilizei o foreach para percorrer  os arrays construídos, transformando no padrão chave=>valor
        $this->$key = $value; //aqui passei os parâmetros da chave dentro de valor, caso o parâmetro chave não exista ele chama o __set
        //no método __set ele aponta os valores lógicos dentro da chave, e depois chama o método mágico __get
      }
    }
  }

  public function __get($key){ //a função get recebe chave como parâmetro
    return isset($this->values[$key]) ? $this->values[$key] : null; //retornando os valores com parãmetro de chave, ou seja recebe chave e mostra o valor
  }

  public function __set($key, $value){//a função set recebe chave e valor como parâmetro
  $this->values[$key] = $value; //apontando o valor das chaves e setando no array value
  }

  public static function getOne($filters = [], $columns = '*') { //getOne recebe os dados da tela de login e faz a validação dos arrays contidos dentro do banco de dados
    $class = get_called_class(); //aqui atribui uma função que retorna o nome da classe através do método estático
    $result = static::getResultSetFromSelect($filters, $columns); //aqui recebo os dados de maneira filtrada e suas respecticas colunas
    return $result ? new $class($result->fetch_assoc()) : null; //retorne ao resultado se resultado dos arrays associativos for válido, senão retorne nulo
  }

  public static function get($filters = [], $columns = '*') { //função utilzizada para receber e imprimir os usuários do banco de dados
    $objects = []; //vaŕiável de arrays vazios
    $result = static::getResultSetFromSelect($filters, $columns); //aqui recebo os dados de maneira filtrada e suas respecticas colunas
    if ($result) { //se resulado for verdadeiro
      $class = get_called_class(); //aqui atribui uma função que retorna o nome da classe através do método estático
      while ($row = $result->fetch_assoc()) { //enquanto as linhas tem valores atribuidos através da variável result com os arrays de usuários construídos atribui os arrays associativos a cada linha
        array_push($objects, new $class($row)); //adiciono objetos na classe usuário através das linhas com arrays associativos
      }
    }
    return $objects;
  }


  public static function getResultSetFromSelect($filters = [], $columns = '*'){ //a função pública getSelect tem como objetivo selecionar e imprimir os valores formatados dos dados do sql
    $sql = "SELECT ${columns} FROM " //$sql SELECIONA os parâmetros dentro de colunas DA tabela users
      . static::$tableName //concatenei os parâmetros incluidos de users(tabela)
      . static::getFilters($filters); //concatenei os filtros incluidos da função obterFiltros
      $result = Database::getResultFromQuery($sql);//aqui armazenei a conexão com o banco de dados dentro de uma variável
    if($result-> num_rows === 0) { //se o número de linhas dentro da database for estritamente igual a zero
      return null; //retorna a um valor nulo
    }else {
      return $result; //retorne a conexão com o banco de dados
    }
  }

  //esta função tem como objetivo trazer as informações  do banco de dados, da parte de usuário e horas trabalhadas
  public function insert(){
    $sql = "INSERT INTO " . static::$tableName . " (" //aqui guardei informações para: Inserir dentro da função estática working_hours. Concatenei o "("
      . implode(",", static::$columns) . ") VALUES ("; //aqui concatenei um implode para juntar os elementos das colunas e serem separados por ",". Fechei o ")", e chamei os VALORES (...
    foreach(static::$columns as $col) { //percorri cada coluna como $col
      $sql .= static::getFormatedValue($this->$col) . ","; //fiz uma concatenação atributiva chamando um método estático para formatar os valores de cada $col percorrido
    }
    $sql[strlen($sql) - 1] = ')'; //aqui chamei uma função para calcular o tamanho de uma string de modo que quando sobrar um espaço, fechar os parêntese ")"
    $id = Database::executeSQL($sql); //aqui guardei a função de executar o banco de dados com o SQL acima
    $this->id = $id; //apontei a a variável acima como se fosse uma função
  }

  public function updtate(){
    $sql = "UPDATE " . static::$tableName . " SET ";
    foreach(static::$columns as $col){
      $sql .= "${col} = " . static::getFormatedValue($this->$col) . ",";
    }
    $sql[strlen($sql) - 1] = ' ';
    $sql .= "WHERE id = {$this->id}";
    Database::executeSQL($sql);
  }

  private static function getFilters($filters){//a função filtros tem objetivo de filtrar o que vai ser impresso na tela de execuçãp
    $sql = ''; //recebe um sql vazio pois vai ser usada na função pública principal de maneira estática
    if (count($filters) > 0) { //se a contagem de filtros for maior que 0
      $sql .= " WHERE 1 = 1";
      foreach ($filters as $column => $value) { //Para cada filtros temos colunas apontando do valor de colunas para a váriavel value que contém os arrays de informações dos usuários
        $sql .= " AND ${column} = "  . static::getFormatedValue($value); //complementando o valor de sql concatenando
      } //adicionando o valor de cada coluna específica junto com a função que irá fomatar o valor
    }
    return $sql;
  }

  private static function getFormatedValue($value){ //esta função privada tem como objetivo formatar os valores do sql obtidos na tabela, formatando-os para serem impressos de acordo com seus tipos
    if(is_null($value)){//se o valor for nulo
      return "null"; ///retornar nulo
    }elseif (gettype($value) === 'string') { //senão, obtenha o valor, e verifique se for estritamente igual ao tipo string
      return "'${value}'"; //retornor o valor com aspas simples
    }else { //senão
      return $value; //retornar o valor de maneira bruto sem forma de tratamento
    }
  }
}
?>
