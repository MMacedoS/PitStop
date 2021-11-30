<?php
require_once "conexao.php";
class Vendas
{
    private $con;

   public function getApt()
    {        
    $con = new Conexao;
    $con->MontarConexao();
    $dados =array();
    $cmd=$con->pdo->query("SELECT nome,status,id_venda FROM vendas where status=1 order by id_venda asc");
    $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $dados;
    }

    public function getVendas()
    {        
        $con = new Conexao;
        $con->MontarConexao();
        $dados =array();
        $cmd=$con->pdo->query("SELECT * FROM vendas where createdAt=curdate() order by id_venda asc");
        $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
    }
    public function getIdApt($id)
    {
        $con = new Conexao;
        $con->MontarConexao();
        $dados =array();
        $cmd=$con->pdo->prepare("SELECT nome,status,id_venda FROM vendas where id_venda=:id order by id_venda desc");
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
    
    public function insertVenda($nome,$cliente)
    {     $dados =array();   
        $con = new Conexao;
        $con->MontarConexao();        
        $cmd=$con->pdo->prepare("INSERT INTO vendas(nome,cliente) values(:nome,:cliente)");
        $cmd->bindValue(":nome",$nome);
        $cmd->bindValue(":cliente",$cliente);
        $dados=$cmd->execute();
        $dados = $con->pdo->lastInsertId();
        // $dados = $cmd;
        return $dados;
        
    }
    public function updateApt($nome,$caixa,$id)
    {     $dados =array();   
        $con = new Conexao;
        $con->MontarConexao();  

        $cmd=$con->pdo->prepare("SELECT v.nome,v.status,v.id_venda,c.id_cliente FROM vendas v inner join cliente c on c.id_cliente=v.cliente where v.id_venda=:id order by v.id_venda desc");
        $cmd->bindValue(':id',$id);
         $cmd->execute();
       $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        if($dados[0]['status']==0){
           
                 $insert=$con->pdo->prepare("UPDATE vendas set caixa=:caixa, status=:status where id_venda=:id");
                 $insert->bindValue(":caixa",$caixa);
                 $insert->bindValue(":status",1);
                 $insert->bindValue(":id",$id);
                 $insert->execute();
                 
                          
            
        }       
    
        return $dados;
        
    }
    public function updateVenda($nome,$cliente,$id)
    {     $dados =array();   
        $con = new Conexao;
        $con->MontarConexao();  
        $insert=$con->pdo->prepare("UPDATE vendas set cliente=:cliente, nome=:nome where id_venda=:id");
        $insert->bindValue(":cliente",$cliente);
        $insert->bindValue(":nome",$nome);
        $insert->bindValue(":id",$id);
        $insert->execute();

        return $dados;
        
    }
}


?>