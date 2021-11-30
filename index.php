<?php
$painel_atual='40b7a3a1d5bab18e2b591461de8b38d6';

define('ROTA_PATH',"http://$_SERVER[HTTP_HOST]".'/pitstop');
define('ROOT_PATH', dirname(__FILE__));
define('ASSETS',ROOT_PATH."/Views/assets/");
require "config.php";
require "autoload.php";
$c = new Core();