<?php

class PagamentoModel extends Conexao{
  

    public function getAll($caixa)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT * FROM pagamento where id_caixa='$caixa'");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;        
    }
    public function getPagamentos(){
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT sum(valor) as saldo FROM pagamento where created_at=curdate()");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados; 
    }
    public function getSoma($caixa)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT sum(valor) as total FROM pagamento where id_caixa='$caixa'");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;        
    }
    public function removeId($id)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("DELETE FROM pagamento WHERE id_pagamento=:id");
        $cmd->bindValue(':id',$id);
        $cmd->execute();
        if($cmd){
        return true;
        }else{
            return false;
        }
        
    }
    public function addPag($valor,$tipo,$caixa)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("INSERT INTO pagamento SET valor=:valor, tipo=:tipo,id_caixa=:id_caixa");
        $cmd->bindValue(':valor',$valor);
        $cmd->bindValue(':tipo',$tipo);
        $cmd->bindValue(':id_caixa',$caixa);
        $cmd->execute();
        return $cmd;
    }
    public function upPag($id,$tipo)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("UPDATE pagamento SET tipo=:tipo WHERE id_pagamento=:id");
        $cmd->bindValue(':tipo',$tipo);
        $cmd->bindValue(':id',$id);
        $cmd->execute();
        return $cmd;
    }
// financeirooooo

    public function getEntradasHj()
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("SELECT COALESCE(sum(valor),0) as saldo FROM pagamento WHERE created_at=curdate() and tipo='Carteira'");
        $cmd->execute();
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
    }

    public function getEntradasMes()
    {
        $mes=date('m');
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT COALESCE(sum(valor),0) as saldo FROM pagamento WHERE created_at LIKE '%-$mes-%' and tipo='Carteira'");
        
        // var_dump($cmd);
        // die;
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
    }

    public function getAllCarteira()
    {
        $mes=date('m');
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT c.id_caixa,c.abertura,c.caixa,p.id_pagamento as codPagamento ,p.valor,p.tipo,v.id_venda,v.createdAt,v.nome as apelido,cli.nome FROM pagamento p 
        INNER JOIN caixa c on p.id_caixa=c.id_caixa 
        INNER JOIN vendas v on v.id_venda=c.caixa 
        INNER JOIN cliente cli on cli.id_cliente=v.cliente 
        WHERE p.tipo='Carteira'");
        
        // var_dump($cmd);
        // die;
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
    }

    // saidas
    public function getSaidaHj()
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("SELECT COALESCE(sum(valor),0) as saldo FROM saida WHERE data=curdate() and status=0");
        $cmd->execute();
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
    }

    public function getSaidaMes()
    {
        $mes=date('m');
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT COALESCE(sum(valor),0) as saldo FROM saida WHERE data LIKE '%-$mes-%' and status=0");
        
        // var_dump($cmd);
        // die;
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
    }

    public function getAllSaida()
    {
        $mes=date('m');
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT * FROM saida ");
        
        // var_dump($cmd);
        // die;
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
    }

    public function insertSaida($descricao,$valor,$data,$obs)
    {
      
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("INSERT INTO saida set descricao=:descricao,valor=:valor,data=:data,observacao=:observacao");
        $cmd->bindValue(":descricao",$descricao);
        $cmd->bindValue(":valor",$valor);
        $cmd->bindValue(":data",$data);
        $cmd->bindValue(":observacao",$obs);
        $cmd->execute();
         return $cmd;
    }
    public function updateSaida($descricao,$valor,$data,$obs,$id)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("UPDATE saida set descricao=:descricao,valor=:valor,data=:data,observacao=:observacao where id_saida=:id");
        $cmd->bindValue(":descricao",$descricao);
        $cmd->bindValue(":valor",$valor);
        $cmd->bindValue(":data",$data);
        $cmd->bindValue(":observacao",$obs);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
         return $cmd;
    }
    public function updateStatusSaida($id)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT * FROM saida WHERE id_saida='$id'");
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);
        if($cmd[0]['status']==0)
        {
            $cmd=$con->pdo->query("UPDATE saida SET status=1 WHERE id_saida='$id'");
        }else
        {
            $cmd=$con->pdo->query("UPDATE saida SET status=0 WHERE id_saida='$id'");
        }

        return true;
    }
    public function getSaidaId($id)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("SELECT * FROM saida WHERE id_saida='$id'");
        $cmd->execute();
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
    }
    public function getFaturamento()
    {
        $mes=date('m');
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT DISTINCT COALESCE((SELECT sum(d.valor) from pagamento d where d.tipo='dinheiro'),'0')as dinheiro,
        COALESCE((SELECT sum(c.valor) from pagamento c where  c.tipo='Carteira'),'0') as carteira,
        COALESCE((SELECT sum(d.valor) from pagamento d where  d.tipo='Cartão Crédito'),'0') as credito,
        COALESCE((SELECT sum(d.valor) from pagamento d where d.tipo='Cartão Débito'),'0') as debito,
        COALESCE((SELECT sum(d.valor) from pagamento d where d.tipo='Transferencia'),'0') as transferencia 
        FROM pagamento p where p.created_at like '%-$mes-%'");
        
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
    }
    
    public function getPagDate($inicio,$fim)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT p.*,v.id_venda,v.nome as apelido,cli.nome FROM pagamento p
         INNER JOIN caixa c on p.id_caixa=c.id_caixa 
        INNER JOIN vendas v on v.id_venda=c.caixa
         INNER JOIN cliente cli on cli.id_cliente=v.cliente
         where p.created_at BETWEEN '$inicio' and '$fim'");        
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
    }

    public function somaSaidas($inicio,$fim){
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT coalesce(SUM(valor),0)as saldo FROM `saida` where data BETWEEN '$inicio' and '$fim' and status=1");        
        $cmd=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $cmd;
        
    }

}


?>