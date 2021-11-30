<?php


class PagamentoController extends Controller{

    public function BuscaPagamentos($caixa)
    {
        
        $registros =$this->Pagamento->getAll($caixa);

        echo json_encode($registros);
    }

    public function RemoverPagamentos($caixa){
        $dados=$this->Pagamento->removeId($_POST['id']);
        $registros=$this->Pagamento->getAll($caixa);
        echo json_encode($registros);
    }
    public function AddPagamentos($caixa){
        $dados=$this->Pagamento->addPag(@$_POST['valor'],@$_POST['tipo'],$caixa);
        $registros=$this->Pagamento->getAll($caixa);
        echo json_encode($registros);
    }

    public function Atualiza(){
        $dados=$this->Pagamento->upPag(@$_POST['id'],@$_POST['tipo']);
        echo json_encode($dados);
    }
}