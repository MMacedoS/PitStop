<?php
require_once "conexao.php";
class Produtos
{
    private $con;

   public function getProdutos()
    {        
    $con = new Conexao;
    $con->MontarConexao();
    $dados =array();
    $cmd=$con->pdo->query("SELECT p.descricao,p.fornecedor,p.precoCompra,p.precoVenda,p.quantidade,p.status,p.id_prod,p.categoria,p.imagem,e.saldo_Atual FROM produto p inner join estoque e on e.id_prod=p.id_prod order by id_prod desc");
    $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $dados;
    }
    public function getIdProdutos($id)
    {
        $con = new Conexao;
        $con->MontarConexao();
        $dados =array();
        $cmd=$con->pdo->prepare("SELECT descricao,fornecedor,precoCompra,precoVenda,quantidade,status,id_prod,categoria,imagem FROM produto where id_prod=:id order by id_prod desc");
        $cmd->bindValue(':id',$id);
        $cmd->execute();
        $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;

    }
    public function getNomeProdutos($nome)
    {
        $con = new Conexao;
        $con->MontarConexao();
        $dados =array();
        $cmd=$con->pdo->prepare("SELECT descricao,fornecedor,precoCompra,precoVenda,quantidade,status,id_prod,categoria,imagem FROM produto where descricao like :descricao order by id_prod desc");
        $cmd->bindValue(':descricao',"%".$nome."%");
        $cmd->execute();
        $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;

    }
    
    public function insertProdutos($descricao,$status,$imagem,$fornecedor,$precoVenda,$precoCompra,$categoria,$quantidade)
    {     $dados =array();   
        $con = new Conexao;
        $con->MontarConexao();        
        $cmd=$con->pdo->prepare("INSERT INTO produto(descricao,fornecedor,precoCompra,precoVenda,quantidade,status,categoria,imagem)
        values(:descricao,:fornecedor,:precoCompra,:precoVenda,:quantidade,:status,:categoria,:imagem)");
        $cmd->bindValue(":descricao",$descricao);
        $cmd->bindValue(":status",$status);
        $cmd->bindValue(":fornecedor",$fornecedor);
        $cmd->bindValue(":precoVenda",$precoVenda);
        $cmd->bindValue(":precoCompra",$precoCompra);
        $cmd->bindValue(":quantidade",$quantidade);
        $cmd->bindValue(":categoria",$categoria);
        $cmd->bindValue(":imagem",$imagem);

        $dados=$cmd->execute();
        // $dados = $cmd;
        return $dados;
        
    }
    public function updateProdutos($descricao,$status,$imagem,$fornecedor,$precoVenda,$precoCompra,$categoria,$quantidade,$id )
    {     $dados =array();   
        $con = new Conexao;
        $con->MontarConexao();  

        if($imagem!=''){
           
        $cmd=$con->pdo->prepare("UPDATE produto set descricao=:descricao,status=:status,fornecedor=:fornecedor,precoVenda=:precoVenda,precoCompra=:precoCompra,
        quantidade=:quantidade,categoria=:categoria,imagem=:imagem where id_produto=:id");
        $cmd->bindValue(":descricao",$descricao);
        $cmd->bindValue(":status",$status);
        $cmd->bindValue(":fornecedor",$fornecedor);
        $cmd->bindValue(":precoVenda",$precoVenda);
        $cmd->bindValue(":precoCompra",$precoCompra);
        $cmd->bindValue(":quantidade",$quantidade);
        $cmd->bindValue(":categoria",$categoria);
        $cmd->bindValue(":imagem",$imagem);
        $cmd->bindValue(":id",$id);
        
        // $dados = $cmd;
    }else
    {
        $cmd=$con->pdo->prepare("UPDATE produto set descricao=:descricao,status=:status,fornecedor=:fornecedor,precoVenda=:precoVenda,precoCompra=:precoCompra,
        quantidade=:quantidade,categoria=:categoria where id_prod=:id");
        $cmd->bindValue(":descricao",$descricao);
        $cmd->bindValue(":status",$status);
        $cmd->bindValue(":fornecedor",$fornecedor);
        $cmd->bindValue(":precoVenda",$precoVenda);
        $cmd->bindValue(":precoCompra",$precoCompra);
        $cmd->bindValue(":quantidade",$quantidade);
        $cmd->bindValue(":categoria",$categoria);
        $cmd->bindValue(":id",$id);   
    }
    $dados=$cmd->execute();
        return $dados;
        
    }
}


?>