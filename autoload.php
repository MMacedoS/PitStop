<?php

spl_autoload_register(function($nome_instacia){
    if(file_exists("Controllers/".$nome_instacia.".php"))
    {
        require "Controllers/".$nome_instacia.".php";
    }
    if(file_exists("Core/".$nome_instacia.".php"))
    {
        require "Core/".$nome_instacia.".php";
    }
    if(file_exists("Models/".$nome_instacia.".php"))
    {
        require "Models/".$nome_instacia.".php";
    }

});

?>