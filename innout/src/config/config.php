<?php

date_default_TimeZone_Set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt-BR.utf-8', 'portuguese');
//com setlocalee LC_TIME defino informações locais como linguagem, tpo de texto...

//Constantes gerais
//constante de daily time foi convertida em segundos
//logo aqui fiz uma operação para transformar as horas trabalhadas em segundos
define('DAILY_TIME', 60 * 60 * 8);

//Aqui defini o nome das Pastas do Projeto
define('MODEL_PATH', realpath(dirname(__FILE__) .'/../models'));
define('VIEW_PATH', realpath(dirname(__FILE__) .'/../views'));
define('TEMPLATE_PATH', realpath(dirname(__FILE__) . '/../views/template'));
define('CONTROLLER_PATH', realpath(dirname(__FILE__) .'/../controllers'));
define('EXCEPTION_PATH', realpath(dirname(__FILE__) .'/../exceptions'));

//Aqui fiz requires para instanciar arquivos importantes para o funcionamento do MVC
require_once(realpath(dirname(__FILE__) .'/database.php'));
require_once(realpath(dirname(__FILE__) .'/loader.php'));
require_once(realpath(dirname(__FILE__) .'/session.php'));
require_once(realpath(dirname(__FILE__) .'/date_utils.php'));
require_once(realpath(dirname(__FILE__) .'/utils.php'));
require_once(realpath(MODEL_PATH . '/Model.php'));
require_once(realpath(MODEL_PATH . '/User.php'));
require_once(realpath(EXCEPTION_PATH . '/AppException.php'));
require_once(realpath(EXCEPTION_PATH . '/ValidationException.php'));
//realpath é utilizado para resolver os caminhos absolutos dos arquivos
//aqui usei o nome das pastas criadas ali em cima para referenciar os arquivos a serem utilizados
 ?>
