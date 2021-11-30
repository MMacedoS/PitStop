<?php

require_once "./Models/caixaModel.php";
require_once "./Models/vendasModel.php";
require_once "./Models/clientesModel.php";
require_once "./Models/produtos.php";
require_once "./Models/estoques.php";
require_once "./Models/PagamentoModel.php";
require_once "./Models/categorias.php";

class Controller
{

    public $Vendas;
    public $Pagamentos;
    public $Estoques;
    public $Clientes;
    public $Produto;
    public $Caixa;
    public $categorias;

    public function __construct(){
        $this->Vendas= new Vendas;
        $this->Pagamento= new PagamentoModel;
        $this->Estoques= new Estoques;
        $this->Produto= new Produtos;
        $this->Clientes= new ClientesModel;
        $this->Caixa=new CaixaModel;
        $this->Categorias=new Categorias;
    }

    public $dados;
    public $consumos;
    public $categoria;
    public $produtos;
    public $faturamento;
    public $entra_estoque;
    public $sai_estoque;
    public $apts;
    public $registros;
    public $baixa_estoque;
    public $totalPag=0;
    public $pagamentos=0.0;

    public function mostrarIndex($nome,$vendas,$produto,$estoques,$clientes)
    {
        $this->dados=$nome;
        $this->produtos=$produto;
        require_once('Views/'.$nome.'.php');
    }
    public function mostrarView($nome,$registros,$caixa,$apt,$clientes)
    {
        $this->consumos=$registros;
        require_once('Views/cadastros/'.$nome.'.php');
    }



    public function mostrarlista($nome,$dado,$caixa)
    {   $caixa=$caixa;
        $this->dados=$dado;
        require_once('Views/listas/'.$nome.'.php');
    }
    public function mostrarViewEstoque($nome,$estoque,$produto,$entra,$baixa)
    {
        $this->dados=$estoque;
        $this->produtos=$produto;
        $this->entra_estoque=$entra;
        $this->baixa_estoque=$baixa;
        require_once('Views/estoque/'.$nome.'.php');
    }

    public function mostrarRelatorio($nome,$consumos)
    {
        $this->dados=$consumos;
        require_once('Views/relatorio/'.$nome.".php");
    }
    public function mostrarRelsaida($nome,$saidas,$consumos,$inicio,$fim)
    {
        require_once('Views/relatorio/'.$nome.'.php');
    }
    public function buscaRelCaixa($inicio,$fim)
    {
        $caixas=$this->Caixa->getCaixa(1,$inicio,$fim);
        
        return $caixas;
    }

    public function financeiro($nomePage,$info1,$info2,$registros)
    {
        require_once('Views/financeiro/'.$nomePage.'.php');
    }
}
?>