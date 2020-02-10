<?php

require './vendor/autoload.php';
use Model\Rota;
$confs =  parse_ini_file('.env', true);

foreach($confs as $key => $conf){
    putenv("{$key}={$conf}");
}

$rota = new Rota();
$rota->Paginacao();



    
	
  

