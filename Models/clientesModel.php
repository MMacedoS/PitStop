<?php
require_once "conexao.php";
class ClientesModel
{
    private $con;

   public function getClientes()
    {        
    $con = new Conexao;
    $con->MontarConexao();
    $dados =array();
    $cmd=$con->pdo->query("SELECT id_cliente,nome,endereco,telefone,status,email FROM cliente where status='1' order by id_cliente asc");
    $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $dados;
    }
    public function getIdCliente($id)
    {
        $con = new Conexao;
        $con->MontarConexao();
        $dados =array();
        $cmd=$con->pdo->prepare("SELECT nome,telefone,endereco,email FROM cliente where id_cliente=:id");
        $cmd->bindValue(':id',$id);
        $cmd->execute();
        $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;

    }
    public function getNomeApt($nome)
    {
        $con = new Conexao;
        $con->MontarConexao();
        $dados =array();
        $cmd=$con->pdo->prepare("SELECT nome,status,id_venda FROM vendas where nome like :nome order by id_venda desc");
        $cmd->bindValue(':nome',"%".$nome."%");
        $cmd->execute();
        $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;

    }
    
    public function insertCliente($nome,$telefone,$endereco,$email)
    {     $dados =array();   
        $con = new Conexao;
        $con->MontarConexao();        
        $cmd=$con->pdo->prepare("INSERT INTO cliente(nome,telefone,endereco,email) values(:nome,:telefone,:endereco,:email)");
        $cmd->bindValue(":nome",$nome);
        $cmd->bindValue(":telefone",$telefone);
        $cmd->bindValue(":endereco",$endereco);
        $cmd->bindValue(":email",$email);

        $dados=$cmd->execute();
        // $dados = $cmd;
        return $dados;
        
    }
    public function updateCliente($nome,$telefone,$endereco,$email,$id)
    {     $dados =array();   
        $con = new Conexao;
        $con->MontarConexao();  

        if($id>0){
            $cmd=$con->pdo->prepare("UPDATE cliente set nome=:nome, telefone=:telefone,endereco=:endereco,email=:email where id_cliente=:id");
            $cmd->bindValue(":nome",$nome);
            $cmd->bindValue(":telefone",$telefone);
            $cmd->bindValue(":endereco",$endereco);
            $cmd->bindValue(":email",$email);
            $cmd->bindValue(":id",$id);
            $dados=$cmd->execute();
            
        }
        
    
        return $dados;
        
    }
}


?>