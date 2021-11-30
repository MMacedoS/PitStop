
<?php
require_once "conexao.php";
class Estoques
{
    public function situacao(){
        $con = new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT p.descricao,e.saldo_Atual,e.saldo_Anterior FROM estoque e INNER JOIN produto p on p.id_prod=e.id_prod");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }


    public function entrada(){
        $con = new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT p.descricao,e.data,e.quantidade FROM entrada_estoque e INNER JOIN produto p on p.id_prod=e.id_prod where e.data>=curDate()");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }
    public function entradaByDate($inicio,$fim){
        $con = new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT e.id_entra as Código,p.descricao as Produto,e.data as Data,e.quantidade as Quantidade FROM entrada_estoque e INNER JOIN produto p on p.id_prod=e.id_prod where  e.data between '$inicio' and '$fim' ");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }
    public function entradaById($id){
        $con = new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT e.id_entra,e.id_prod,e.data,e.quantidade FROM entrada_estoque e where e.id_entra='$id'");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }
    public function insertEntrada($produto,$quantidade,$data)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("INSERT INTO entrada_estoque (id_prod,quantidade,data) values(:produto,:quantidade,:data)");
        $cmd->bindValue(':produto',$produto);
        $cmd->bindValue(':quantidade',$quantidade);
        $cmd->bindValue(':data',$data);
        $cmd->execute();
        if($cmd){
            return true;
        }else{
            return false;
        }
    }
    
    public function updateEntrada($produto,$quantidade,$data,$id)
    {
        $con=new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->prepare("UPDATE entrada_estoque SET id_prod=:produto, quantidade=:quantidade, data=:data WHERE id_entra=:id");
        $cmd->bindValue(':produto',$produto);
        $cmd->bindValue(':quantidade',$quantidade);
        $cmd->bindValue(':data',$data);
        $cmd->bindValue(':id',$id);
        $cmd->execute();
        if($cmd){
            return true;
        }else{
            return false;
        }
    }
    public function saida(){
        $con = new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT p.descricao,s.data,s.quantidade,s.id_pag,s.cliente,s.id_saida,s.id_prod FROM saida_estoque s INNER JOIN produto p on p.id_prod=s.id_prod where s.data>=curDate()");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }
    public function BuscaBaixa(){
        $con = new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT p.descricao,s.saldo_Atual FROM estoque s INNER JOIN produto p on p.id_prod=s.id_prod where s.saldo_Atual<=10");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }
    public function BuscaItens(){
        $con = new Conexao;
        $con->MontarConexao();
        $cmd=$con->pdo->query("SELECT sum(s.saldo_Atual) as itens FROM estoque s INNER JOIN produto p on p.id_prod=s.id_prod");
        $dados=$cmd->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }
}

?>