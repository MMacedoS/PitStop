<?php

define('SERVIDOR','localhost');
define('BANCO', 'estoquebbconfort');
define('USUARIO', 'root');
define('SENHA','');

class Conexao{
    private $conexaoSql;
    private $charset;
    public $pdo;
    private $conexao;
    
    public function MontarConexao()
    {
        if(!isset($this->pdo)){
            try {
                $this->charset=array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8');
                $this->pdo=new PDO("mysql:host=".SERVIDOR.";dbname=".BANCO.";",USUARIO,SENHA,$this->charset);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $th)
            {
                die("ERRO: #".$th->getCode()."<br>
                Mensagem:".$th->getMessage()."<br>
                No Arquivo:".$th->getFile()."<br
                Na linha:".$th->getLine());
            }
        }
        return $this->pdo;
    }

    public function login($usuario,$senha){
        try {
            //code...
        
            $res = $this->pdo->prepare("SELECT * from usuarios where email = :usuario and senha = :senha");

            $res->bindValue(":usuario", $usuario);
            $res->bindValue(":senha", md5($senha));
            $res->execute();

            $dados = $res->fetchAll(PDO::FETCH_ASSOC);
            return $dados;
        } catch (\Throwable $th) {
            echo $th;
            die;
        }
    }
    public function insertUser($email,$nome,$senha){
        try {
            //code...
        
            $res = $this->pdo->prepare("INSERT INTO usuarios (email,nome,senha,acesso) values(:email,:nome,:senha,:acesso)");
            $res->bindValue(':email',$email);
            $res->bindValue(':nome',$nome);
            $res->bindValue(':senha',md5($senha));
            $res->bindValue(':acesso','admin');
            $res=$res->execute();

            return true;
        } catch (\Throwable $th) {
            //throw $th;
            echo $th;
            die;
        }
    }
    
}
?>