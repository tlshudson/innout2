<?php
//classe utilizada para tratar algumas exceções de erro
class AppException extends Exception {

  public function __construct($message, $code = 0, $previous = null){
  parent::__construct($message, $code, $previous);
  }
}

 ?>
