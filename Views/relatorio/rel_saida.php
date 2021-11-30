<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        
    });
</script> -->



<?php 
// require_once 'Controllers/caixaController.php';
// echo $inicio=$_GET['inicio'];
// $fim=$_GET['fim'];
// exit;
 include('pdf/mpdf.php');

//  $con = new SituacaoController();
$totalgeral=0;
 $pagina="";

$pagina.='<html>';

    $pagina.='<head>

    <style>

        

        #customers {

            // margin-top:3%;

            margin-top:5%;

            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;

            border-collapse: collapse;

            width: 100%;

            border: 1px solid #ddd;

        }

        

        #customers tr:nth-child(even) {

            background-color: #ffff99;

        }

        

        #customers tr:hover {

            background-color: #ddd;

        }

        

        #customers th {

            padding-top: 10px;

            padding-bottom: 10px;

            // text-align: left;

            background-color: #4CAF50;

            color: white;

        }

        

        table,

        th,

        td {

            border: 1px solid black;

            white-space: nowrap;
            text-align:center;

        }

        .titulo{

            text-align:center;

        }

        .rodape{

            // margin-top:100px;

        }

        

    </style>

    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <title>Boletim Alunos</title>

</head>

';




$inicio=explode("-",$inicio);
$inicio=$inicio[2].'/'.$inicio[1].'/'.$inicio[0];

$fim=explode("-",$fim);
$fim=$fim[2].'/'.$fim[1].'/'.$fim[0];

$pagina.='<body>';

$pagina.='<table id="customers" width="100%">
<tr>
<th width="33%" colspan="3"  style="font-size: 24;" align="center"><strong>Saidas</strong></th> 
</tr>
<tr>
    <td colspan="3" width="50%">De '.$inicio.' á '.$fim.'</td>
</tr>
</table>



';
$saida=0;
   $pagina.='<table id="customers">';
        foreach($saidas as $key => $value){
         $saida=0;
            $pagina.='<tr>';
            $pagina.='<th colspan="5">'.$value['caixa'].'</th>';
            $pagina.='</tr><tr>';
            $pagina.='<th>Data</th>';
            $pagina.='<th>Produto</th>';
            $pagina.='<th>Quantidade</th>';
            $pagina.='<th>Valor Unitario</th>';
            $pagina.='<th>Total</th>';
            $pagina.='</tr>';
            foreach($consumos as $key=>$consumo){
            if($consumo['id_caixa']==$value['id_caixa']){

                $dtconsumo=explode("-",$consumo['data']);
                $dtconsumo=$dtconsumo[2].'/'.$dtconsumo[1].'/'.$dtconsumo[0];
            $pagina.='<tr>';
             $pagina.='<td>'.$dtconsumo.'</td>';
             $pagina.='<td>'.$consumo['produto'].'</td>';
             $pagina.='<td>'.$consumo['quantidade'].'</td>';
             $pagina.='<td>R$ '.$consumo['valorUnitario'].'</td>';
             $total=$consumo['valor'];
             $pagina.='<td>R$ '.number_format($total,2).'</td>';
            $pagina.='</tr>';
            $saida+=$total;
            $totalgeral+=$total;
            }
           
        }
        $pagina.='<tr><td colspan="5" style="color:green;font-size:18pt">Valor: R$ '.$saida.'</td></tr>';

    }
            $pagina.="<tr>";
            $pagina.="<th>Valor Total do consumo: </th>";
            $pagina.='<th colspan="3" style="font-size:20px;text-align:center;background-color:#005f12;">R$: '.$totalgeral.'</th>';
            $pagina.="</tr>";
        
    $pagina.='</table>';
        



   

   

    $pagina.='</body>';



$pagina.='</html>';



$html=$pagina;



// echo $pagina;



// var_dump($clientes[1]);

// die




$mpdf = new \mPDF("utf-8", 'A4-P');
$mpdf->allow_charset_conversion = true;                                
$mpdf->pdf->charset_in = 'iso-8859-1';
$mpdf->DeflMargin = 3;

$mpdf->DefrMargin = 3;

$mpdf->SetTopMargin(3);

$mpdf->AddPage();



    $mpdf->WriteHTML($html);

    $mpdf->Ln(2);



$mpdf->Output('Boletim.pdf', 'I');




 

?>