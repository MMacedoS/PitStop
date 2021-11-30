
<?php
 require_once "Models/conexao.php";
$pdo=new Conexao();
$pdo->MontarConexao();
@session_start();
?>

<?php
    if(empty($_POST['email_login']) || empty($_POST['senha_login']))
    {
        header("Location: login.php?login=0");
    }
    if(@$_POST['senha_auto']){
        $nome=$_POST['nome_cad'];$email=$_POST['email_cad'];$senha_cad=$_POST['senha_cad'];$senha_auto=$_POST['senha_auto'];
        if(md5($senha_auto)==md5('@gerenciapitstop')){
            try {
                    //code...
            
                    $dados=$pdo->insertUser($email,$nome,$senha_cad);
                
                if($dados){ 
                        echo "<script>window.alert('ADD com sucesso')</script>";
                        }
                
                } catch (\Throwable $th) {
                    //throw $th;
                }
        }
    }
else {
        $usuario = $_POST['email_login'];
        $senha = $_POST['senha_login'];
        // echo md5($senha);
        $dados=$pdo->login($usuario,$senha);
        echo $linhas = count($dados);
        // var_dump($dados);
        if(md5($senha)==$dados[0]['senha']){
                        if($linhas > 0){
                        // echo 'suecesso';
                        @session_start();
                            $_SESSION['code']=$dados[0]['id_user'];;
                            $_SESSION['nome']=$dados[0]['email'];
                            $_SESSION['nomeUsuario']=$dados[0]['nome'];
                            $_SESSION['painel']=md5('logado');
                            $tempolimite=1900;
                            $_SESSION['registro']=time();
                            $_SESSION['limite']=$tempolimite;
                            
                            if(@$_SESSION['painel']) {                                
                                // @session_start();
                                
                                header("location:index.php");
                                // die;
                                
                            }
                                    
                        }else{
                            echo "<script language='javascript'>window.alert('Dados Incorretos!!'); </script>";
                            echo "<script language='javascript'>window.location='index.php?login'; </script>";
                            header("Location: login.php?#paralogin");
                            exit();
                            
                        } 
                    }else{
                        // echo "<script language='javascript'>window.alert('Dados Incorretos!!'); </script>";
                        // echo "<script language='javascript'>window.location='index.php?login'; </script>";
                        header("Location: login.php?#paralogin");
                        exit();
                    }
}


?>

