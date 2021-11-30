<?php


class CaixaController extends Controller
{

    public function index($id_apt)
    {
        $caixa=$this->Caixa->CreateCaixa($id_apt);        
        $this->dados=$this->Vendas->updateApt('',$caixa,$id_apt);
        $consumo=$this->Caixa->getConsumo($caixa);
        $this->totalPag=$this->Pagamento->getSoma($caixa);        
        $clientes =$this->Clientes->getClientes();
        $this->mostrarView('caixa',$consumo,$caixa,$id_apt,$clientes);
    }

    public function lista($caixa)
    {       
        
        $this->mostrarlista('produto','',$caixa);
    }
    public function buscaProdutos()
    {
        $this->produtos=$this->Produto->getProdutos();
        echo json_encode($this->produtos);
    }
    
    public function inserir()
    {
        $consumo=$this->Caixa->insertConsumo($_POST['produto'],$_POST['quantidade'],$_POST['valor'],$_POST['caixa']);
        echo json_encode($consumo);
    }
    public function fechar_estoque($id)
    {
        $consumo=$this->Caixa->fechamento($id);
        echo json_encode($consumo);
    }
    public function remover_produto($id)
    {
        $consumo=$this->Caixa->deleteConsumo($id);
        echo json_encode($consumo);
    }
    public function relatorio($id)
    {
        $consumo=$this->Caixa->getConsById($id);
       $this->mostrarRelatorio('caixa',$consumo);
    }
    public function saida($params)
    {
        $params=explode('|',$params);
        // var_dump($params);
        // die;
        $saidas=$this->Caixa->getCaixa($params[0],$params[1]);
        $ConsSaidas=$this->Caixa->getCons($params[0],$params[1]);
        $this->mostrarRelsaida('rel_saida',$saidas,$ConsSaidas,$params[0],$params[1]);
        
    }
    public function atualizaCliente($id){
        $this->dados=$this->Vendas->updateVenda($_POST['vendas'],$_POST['cliente'],$id);
        echo "atualizado";
    }
  
    public function fechado($id_apt)
    {
        $caixa=$this->Caixa->FechadoCaixa($id_apt);        
        $this->dados=$this->Vendas->updateApt('',$caixa,$id_apt);
        $consumo=$this->Caixa->getConsumo($caixa);
        $this->totalPag=$this->Pagamento->getSoma($caixa);        
        $clientes =$this->Clientes->getClientes();
        $this->mostrarView('caixa',$consumo,$caixa,$id_apt,$clientes);
    }

}



?>