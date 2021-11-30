<?php
require_once "./Models/PagamentoModel.php";
date_default_timezone_set('America/Sao_Paulo');
require_once './dompdf/autoload.inc.php';

        //CARREGAR DOMPDF
        
        use Dompdf\Dompdf;

@session_start();
class FinanceiroController extends Controller{
    
    public function entrada()
    {
        $registros1 =$this->Pagamento->getEntradasHj();
        $resgistro2 = $this->Pagamento->getEntradasMes();
        $registros = $this->Pagamento->getAllCarteira();
        $this->financeiro('entrada',$registros1,$resgistro2,$registros);

    }

    public function saida()
    {
       
        $registros1 =$this->Pagamento->getSaidaHj();
        $resgistro2 = $this->Pagamento->getSaidaMes();
        $registros = $this->Pagamento->getAllSaida();
        $this->financeiro('saida',$registros1,$resgistro2,$registros);
    }

    public function faturamento()
    {
        $registros = $this->Pagamento->getPagDate(date('Y-m-d'),date('Y-m-d'));
        $this->financeiro('faturamento','','',$registros);
    }

    public function updateStatus($id)
    {
        $registros1 =$this->Pagamento->updateStatusSaida($id);
        echo $registros1;
    }
    public function insertSaida()
    {
        $registros1 =$this->Pagamento->insertSaida($_POST['descricao'],$_POST['valor'],$_POST['data'],$_POST['obs']);
        echo $registros1;
    }
    public function updateSaida($id)
    {
        $registros1 =$this->Pagamento->updateSaida($_POST['descricao'],$_POST['valor'],$_POST['data'],$_POST['obs'],$id);
        echo $registros1;
    }
    public function getIdSaida($id)
    {
        $registros1 =$this->Pagamento->getSaidaId($id);
        echo json_encode($registros1);
    }

    public function faturamentoDatas(){
       
            $this->registros = $this->Pagamento->getPagDate($_POST['inicio'],$_POST['fim']);

            echo json_encode($this->registros);
            // die;
            
       
    }

    public function somaSaidas()
    {
        $registros = $this->Pagamento->somaSaidas($_POST['inicio'],$_POST['fim']);
        echo json_encode($registros);
    }

    public function imprimir(){
        

        $dataInicial =20;
        $dataFinal = 20;
        $tipo = 12;



        //ALIMENTAR OS DADOS NO RELATÓRIO
        $html = utf8_encode(file_get_contents("http://localhost/BBconfort/Views/relatorio/rel/rel_mov.php?dataInicial=".$dataInicial."&dataFinal=".$dataFinal."&tipo=".$tipo));
        // echo $html;


        //INICIALIZAR A CLASSE DO DOMPDF
        $pdf = new DOMPDF();

        //Definir o tamanho do papel e orientação da página
        $pdf->set_paper('A4', 'portrait');

        //CARREGAR O CONTEÚDO HTML
        $pdf->load_html(utf8_decode($html));

        //RENDERIZAR O PDF
        $pdf->render();

        //NOMEAR O PDF GERADO
        $pdf->stream(
        'relatorioMov.pdf',
        array("Attachment" => false)
        );

    }
    
}



?>