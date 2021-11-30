<?php

class HomeController extends Controller{
   

    public function index()
    {
        $this->apts=$this->Vendas->getVendas();
        $this->faturamento =$this->Pagamento->getFaturamento();
        $vendas=$this->Vendas->getApt();
        $this->produtos=$this->Produto->getProdutos();
        $this->pagamentos=$this->Pagamento->getPagamentos();
        $estoque=$this->Estoques->BuscaItens();
        $clientes =$this->Clientes->getClientes();
        $this->mostrarIndex('index',$vendas,$this->produtos,$estoque,$clientes);
    }

    public function vendas()
    {
        $this->apts=$this->Vendas->getVendas();
        $vendas=$this->Vendas->getApt();
        $clientes =$this->Clientes->getClientes();
        $this->mostrarIndex('vendas',$vendas,'','',$clientes);
    }
}
?>