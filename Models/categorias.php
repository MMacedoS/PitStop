<?php
require_once "conexao.php";
class Categorias
{
    private $con;

   public function getCategorias()
    {        
    $con = new Conexao;
    $con->MontarConexao();
    $dados =array();
    $cmd=$con->pdo->query("SELECT categoria,status,id_cat FROM categoria order by id_cat desc");
    $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $dados;
    }
    public function getIdCategorias($id)
    {
        $con = new Conexao;
        $con->MontarConexao();
        $dados =array();
        $cmd=$con->pdo->prepare("SELECT categoria,status,id_cat,imagem FROM categoria where id_cat=:id order by id_cat desc");
        $cmd->bindValue(':id',$id);
        $cmd->execute();
        $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;

    }
    public function getNomeCategorias($nome)
    {
        $con = new Conexao;
        $con->MontarConexao();
        $dados =array();
        $cmd=$con->pdo->prepare("SELECT categoria,status,id_cat,imagem FROM categoria where categoria like :categoria order by id_cat desc");
        $cmd->bindValue(':categoria',"%".$nome."%");
        $cmd->execute();
        $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;

    }
    
    public function insertCategorias($categoria,$status,$imagem)
    {     $dados =array();   
        $con = new Conexao;
        $con->MontarConexao();        
        $cmd=$con->pdo->prepare("INSERT INTO categoria(categoria,status,imagem) values(:categoria,:status,:imagem)");
        $cmd->bindValue(":categoria",$categoria);
        $cmd->bindValue(":status",$status);
        $cmd->bindValue(":imagem",$imagem);
        $dados=$cmd->execute();
        // $dados = $cmd;
        return $dados;
        
    }
    public function updateCategorias($categoria,$status,$id,$imagem )
    {     $dados =array();   
        $con = new Conexao;
        $con->MontarConexao();  

        if($imagem!=''){
           
        $cmd=$con->pdo->prepare("UPDATE categoria set categoria=:categoria,status=:status,imagem=:imagem where id_cat=:id");
        $cmd->bindValue(":categoria",$categoria);
        $cmd->bindValue(":status",$status);
        $cmd->bindValue(":imagem",$imagem);
        $cmd->bindValue(":id",$id);
        
        // $dados = $cmd;
    }else
    {
        $cmd=$con->pdo->prepare("UPDATE categoria set categoria=:categoria,status=:status where id_cat=:id");
        $cmd->bindValue(":categoria",$categoria);
        $cmd->bindValue(":status",$status);
        $cmd->bindValue(":id",$id);   
    }
    $dados=$cmd->execute();
        return $dados;
        
    }
}


?>