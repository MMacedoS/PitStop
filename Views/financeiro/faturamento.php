<?php
 require_once ROOT_PATH."/Views/header.php";
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>


<div class="col main pt-5 mt-3">
    
   

    <nav class="navbar navbar-light bg-light justify-content-between col-lg-12 col-md-8">
        <a class="navbar-brand">Faturamento</a>
        <form class="form-inline">
            <label for="inicio"></label>
            <input type="date" id="inicio" class="form-control ml-4 mr-4" value="<?=Date('Y-m-d')?>">
            <label for="fim">até</label>
            <input type="date" id="fim" class="form-control ml-4 mr-4" value="<?=Date('Y-m-d')?>">
            <button class="btn btn-outline-danger my-2 my-sm-0 mr-5" id="buscaFaturamento">Buscar</button>
            <!-- <button class="btn btn-outline-primary my-2 my-sm-0 mr-5" onclick="addModal(event);">Adicionar</button> -->
            <!-- <input class="form-control mr-sm-2" type="search" placeholder="pesquisa" id="busca" onkeyup="buscar();" aria-label="Search"> -->
            <!-- <button class="btn btn-outline-success my-2 my-sm-0" onclick="buscar();" type="button">Pesquisar</button> -->
        </form>
    </nav>

    <div class="row mb-3">
                <div class="col-xl-3 col-sm-6 py-2" onclick="alert('opa');">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body bg-success">
                            <div class="rotate">
                                <i class="fa fa-user fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Entradas</h6>
                            <h1 class="text-center  mt-4" id="entrada">R$</h1>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 py-2" onclick="alert('opa');">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body bg-info">
                            <div class="rotate">
                                <i class="fa fa-user fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Saidas</h6>
                            <h1 class="text-center  mt-4" id="saida">R$</h1>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 py-2" onclick="alert('opa');">
                    <div class="card bg-secondary text-white h-100">
                        <div class="card-body bg-secondary">
                            <div class="rotate">
                                <i class="fa fa-user fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Caixa</h6>
                            <h1 class="text-center  mt-4" id="caixa">R$</h1>
                        </div>
                    </div>
                </div>
                
    </div>


    <div class="col-lg-12 col-md-8 mt-3">
        <div class="table-responsive" id="lista">
         <!-- <table id="example" class="table table-striped" style="width:100%"> -->
        <!-- <thead>
            <tr>
                <th>Código</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Apelido</th>
                <th>Nome</th>
                <th>Ações</th>
               
            </tr>
        </thead>
        <tbody> -->
     
        <!-- </tbody> -->
        <!-- <tfoot>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Status</th>
                <th>Ações</th>
               
            </tr>
        </tfoot> -->
    <!-- </table> -->
        </div>
    </div>

</div>



<script>
$(document).ready(function(){  
  lista(<?=json_encode($registros)?>);
  $('#example').DataTable();
  
});

function card(entrada)
{

    $('#entrada').text('R$ '+entrada);
    var inicio=$('#inicio').val();
    var fim=$('#fim').val();
    $.ajax({
      method:'POST',
      url:'<?=$path?>/Financeiro/somaSaidas',
      data:{inicio:inicio,fim:fim},
      dataType:'json',
      success:function(response){
       console.log(response);   
       $('#saida').text('R$ '+response[0].saldo);
      $('#caixa').text('R$ '+ (entrada-response[0].saldo));
      }
  });
    
}

function lista(dados){
    let saldo=0.0;
    html='';
    html+=' <table id="example" class="table table-striped" style="width:100%">';
    html+='<thead>';
    html+=' <tr>';
    html+='<th>Código</th>';
    html+='<th>Data</th>';
    html+='<th>Valor</th>';
    html+='<th>Apelido</th>';
    html+='<th>Nome</th>';
    html+='<th>Ações</th>';
    html+='</tr>';
    html+='</thead>';
    html+='<tbody>';
    dados.forEach(element =>{
        html+=' <tr>';
        html+=' <td>';
        html+=element.id_pagamento;
        html+=' </td>';

        html+=' <td>';
        var date=element.created_at.split('-');
        html+=date[2]+'/'+date[1]+'/'+date[0];
        html+=' </td>';

        html+=' <td>';
        html+=element.valor;
        saldo=saldo+parseFloat(element.valor);
        html+=' </td>';

        html+=' <td>';
        html+=element.apelido;
        html+=' </td>';

        html+=' <td>';
        html+=element.nome;
        html+=' </td>';
        
        html+=' <td>';
        html+='<a href="<?=ROTA_PATH?>/caixa/fechado/'+element.id_venda+'" class="btn btn-secondary ml-2">Voltar o caixa</a>';
        html+=' </td>';
        html+= '</tr>';
    });

    html+='</tbody>';
    html+='</table>';
    card(saldo);
    $('#lista').html(html);

}

$(document).on('click','#buscaFaturamento',function(envent){
    event.preventDefault();
    var inicio=$('#inicio').val();
    var fim=$('#fim').val();
    $.ajax({
      method:'POST',
      url:'<?=$path?>/Financeiro/faturamentoDatas',
      data:{inicio:inicio,fim:fim,data:'data'},
      dataType:'json',
      success:function(response){
       console.log(response);   
       lista(response);
       $('#example').DataTable();
      }
  });
});
</script>


<?php
 require_once ROOT_PATH."/Views/footer.php";
?>