<?php
class Login extends Model{

  public function validate(){
    $errors = [];

    if (!$this->email) {
      $errors['email'] = 'E-mail é um campo obrigatório!';
    }

    if (!$this->password) {
      $errors['password'] = 'Senha é um campo obrigatório!';
    }
    if (count($errors) > 0) {
      throw new ValidationException($errors);
    }
  }

  public function checkLogin(){ //função utilizada para checar os dados de login caso estejam corretos
    $this->validate();
    $user = User::getOne(['email' => $this->email]); //user recebe a classe usuário junto com os arrays de email vindos do banco de dados
    if ($user) { //se usuário for verdadeiro
      if ($user->end_date) {
        throw new AppException('Usuário está desligado da empresa!'); //senão retorne a uma nova exceção
      }
      if (password_verify($this->password, $user->password)) { //se a função para verificar a compatibilida de senha for correta
        return $user; //retorna o usuário
      }
    }
    throw new AppException('Usuário e/ou senha inválidos!'); //senão retorne a uma nova exceção

  }
}

 ?>
