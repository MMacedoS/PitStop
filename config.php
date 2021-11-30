<?php 

date_default_timezone_set('America/Sao_Paulo');
$pathurl="http://$_SERVER[HTTP_HOST]"."/pitstop";
@session_start();
$code =$_SESSION['code'];
$nome =$_SESSION['nome'];
$painel=$_SESSION['painel'];

if(@$_GET['acao']=='quebra'){
        @session_start();
       $_SESSION['code']='';
       $_SESSION['nome']='';
       $_SESSION['painel']='';
       session_destroy();
       
        header("Location: ".$pathurl."/login.php?#paralogin");
        exit();
    }
?>
<?php

        if($_SESSION['registro']){
            $segundos= time() - $_SESSION['registro'];
        }
        if($segundos > $_SESSION['limite']){
            unset($_SESSION['code']);
            unset($_SESSION['nome']);
            unset($_SESSION['painel']);
            unset($_SESSION['limite']);
            unset($_SESSION['registro']);
            session_destroy();
                header("Location: ".$pathurl."/login.php?#paralogin");
                exit();
    
        }else{
    
            $_SESSION['registro']=time();
        }

                if(session_status()==PHP_SESSION_NONE){
                    session_destroy();
                    //  
                    header("Location: ".$pathurl."/login.php?#paralogin");
                        exit();
                }else{

                if (empty($code)) {
                    
                    header("Location: ".$pathurl."/login.php?#paralogin");

                    session_destroy();
                exit();

                } elseif(empty($nome)){
                
                    header("Location: ".$pathurl."/login.php?#paralogin");
                        session_destroy();
                        exit();
                }elseif(empty($painel)){
                    session_destroy();     
                
                    header("Location: ".$pathurl."/login.php?#paralogin");
                    exit();
                }
                elseif ($painel_atual!=$painel){

                                session_destroy();
                                echo 'errro';
                                exit();
                    }
                

                }
?>