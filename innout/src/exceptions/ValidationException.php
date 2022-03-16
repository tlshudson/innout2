<?php
// classe que prevê erros de validação nos campos de email e login
class ValidationException extends AppException {

  private $errors = [];

  public function __construct($errors = [],
    $message = 'Erros de validação',
    $code = 0, $previous = null){
  parent::__construct($message, $code, $previous);
  $this->errors = $errors;
  }

  public function getErrors(){
    return $this->errors;
  }

  public function get($att){
    return $this->errors[$att];
  }
}

 ?>
