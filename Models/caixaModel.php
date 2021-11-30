<?php
require_once "conexao.php";

class CaixaModel{

    public function CreateCaixa($apt){
        $con=new Conexao;
        $con->MontarConexao();
        $ap=$con->pdo->query("SELECT nome,status,caixa,id_venda from Vendas where id_venda='$apt'");
        $ap=$ap->fetchAll(PDO::FETCH_ASSOC);
        $caixa=$ap[0]['id_venda'];
        $data=Date('Y-m-d');
        if($ap[0]['status']==0){
        $dados=$con->pdo->prepare('INSERT INTO caixa (caixa,abertura,status) values(:caixa,:abertura,:status)');
        $dados->bindValue(':caixa',$caixa);
        $dados->bindValue(':abertura',$data);
        $dados->bindValue(':status',0);
        $dados->execute();
        $dados = $con->pdo->lastInsertId();
        }else{
            $dados=$ap[0]['caixa'];
        }
        return $dados;
    }

    public function getConsumo($caixa){
        $con=new Conexao;
        $con->MontarConexao();
        $dados=$con->pdo->query("SELECT con.*,cai.caixa,p.descricao,sum(con.quantidade)as itens,p.precoVenda as preco from consumo con inner join caixa cai on cai.id_caixa=con.id_caixa 
        inner join produto p on p.id_prod=con.produto where cai.id_caixa='$caixa' GROUP BY produto");
        $dados=$dados->fetchAll(PDO::FETCH_ASSOC);        
        return $dados;
    }
    function insertConsumo($produto,$quantidade,$valor,$caixa)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $dados=$con->pdo->prepare('INSERT INTO consumo (produto,data,quantidade,valor,id_caixa) values(:produto,:data,:quantidade,:valor,:caixa)');
        $dados->bindValue(':produto',$produto);
        $dados->bindValue(':data',Date('Y-m-d'));
        $dados->bindValue(':quantidade',$quantidade);
        $dados->bindValue(':valor',$valor);
        $dados->bindValue(':caixa',$caixa);
        $dados=$dados->execute();    
        return $dados;
    }

    function fechamento($id)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $dados=$con->pdo->prepare('UPDATE caixa set status=:status,fechamento=:fechamento where id_caixa=:caixa');
        $dados->bindValue(':caixa',$id);
        $dados->bindValue(':fechamento',Date('Y-m-d'));
        $dados->bindValue(':status','1');
        $dados=$dados->execute();    
        return $dados;
    }

    function deleteConsumo($id)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $dados=$con->pdo->prepare('DELETE FROM consumo where id_consumo=:id');
        $dados->bindValue(':id',$id);
        $dados=$dados->execute();    
        return $dados;
    }
    function getConsById($id)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $dados=$con->pdo->query("SELECT con.valor,v.nome,con.quantidade,pro.precoVenda,con.data,pro.descricao,cai.caixa,cai.abertura FROM consumo con INNER JOIN caixa cai on cai.id_caixa=con.id_caixa INNER JOIN produto pro on pro.id_prod=con.produto INNER JOIN vendas v on cai.id_caixa=v.caixa where con.id_caixa='$id'");
        $dados=$dados->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }

    function getCaixa($inicio,$fim)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $dados=$con->pdo->query("SELECT * FROM caixa c where c.status='1' and c.fechamento between '$inicio' and '$fim'");
        $dados=$dados->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
    }

    function getCons($inicio,$fim)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $dados=$con->pdo->query("SELECT cons.*,p.precoVenda as valorUnitario FROM consumo cons inner join produto p on cons.produto=p.id_prod where cons.data between '$inicio' and '$fim'");
        $dados=$dados->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
    }

    public function FechadoCaixa($apt){
        $con=new Conexao;
        $con->MontarConexao();
        $ap=$con->pdo->query("SELECT nome,status,caixa,id_venda from Vendas where id_venda='$apt'");
        $ap=$ap->fetchAll(PDO::FETCH_ASSOC);
             
        $dados=$ap[0]['caixa'];
        return $dados;
    }
}

?>