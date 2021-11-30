<?php
 require_once ROOT_PATH."/Views/header.php";
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
<div class="col main pt-5 mt-3">
    <nav class="navbar navbar-light bg-light justify-content-between col-lg-12 col-md-8">
        <a class="navbar-brand">Contas a pagar</a>
        <form class="form-inline">
            <button class="btn btn-outline-primary my-2 my-sm-0 mr-5" onclick="addModal(event);">Adicionar</button>
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
                            <h6 class="text-uppercase">Hoje</h6>
                            <h1 class="text-center  mt-4">R$ <?=@$info1[0]['saldo']?></h1>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 py-2" onclick="alert('opa');">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body bg-info">
                            <div class="rotate">
                                <i class="fa fa-user fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Contas do Mês á Pagar</h6>
                            <h1 class="text-center  mt-4">R$ <?=@$info2[0]['saldo']?></h1>
                        </div>
                    </div>
                </div>
                
    </div>
    <div class="col-lg-12 col-md-8 mt-3">
        <div class="table-responsive" id="lista">
        <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Descricao</th>
                <th>Situação</th>
                <th>Ações</th>
               
            </tr>
        </thead>
        <tbody>
      <?php foreach($registros as $key=>$value){?>
            <tr>
                <td><?=$value['id_saida']?></td>
                <td><?php $date=explode('-',$value['data']); echo $date[2].'/'.$date[1].'/'.$date[0];?></td>
                <td><?=$value['valor']?></td>
                <td><?=$value['descricao']?></td>
                <td> <?= $value['status']==0?'<button class="btn btn-danger atualiza" id="'.$value['id_saida'].'">Aguarda</button>':' <button class="btn btn-success atualiza" id="'.$value['id_saida'].'">OK</button>'?></td>
                <td><button class="btn btn-info editar" id="<?=$value['id_saida']?>">&#9998;</button>               
                </td>  
              
              
            </tr>
          <?php }?> 
        </tbody>
        <!-- <tfoot>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Status</th>
                <th>Ações</th>
               
            </tr>
        </tfoot> -->
    </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myAddReceber" tabindex="-1" role="dialog">
    <div class="modal-dialog" id="tamanhoModal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Contas a Pagar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_saida" enctype="multipart/form-data">
                    <div class="row">
                    <input type="hidden" name="id" id="id" value="0">
                        <div class="col-sm-12">
                        <label for="">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="ex: descrição" required>
                        </div>
                                             
                    </div>
                    <div class="row">
                    
                        <div class="col-sm-6">
                        <label for="">Valor</label>
                            <input type="number" step="0.00" class="form-control" id="valor" name="valor" placeholder="" required>
                        </div>
                        <div class="col-sm-6">
                        <label for="">Data Vencimento</label>
                        <input type="date"  class="form-control" id="data" name="data"  required>
                        </div>                        
                    </div>
                    <div class="row">
                    
                        <div class="col-sm-12">
                        <label for="">obs</label>
                            <input type="text" class="form-control" id="obs" name="obs" placeholder="" required>
                        </div>
                                           
                    </div>
                    <!-- <div class="row">
                    <div class="col mt-2">
                        <label for="">Imagem</label>
                        <input type="file" name="imagem" class="imagem" id="imagem">
                        <img class="preview-img" id="preview" src="" style="width:40%">
                    </div>
                    </div> -->
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="window.location.reload()" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="cadastrar();" data-dismiss="modal">Salvar</button>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function(){
  $('#example').DataTable();
});
</script>

<script>

function addModal(event)
{
    event.preventDefault();
    $('#myAddReceber').modal('show');
}

function cadastrar()
{
    var id=$('#id').val();
    if(id==0)
    {
        $.ajax({
            processData: false,
            contentType: false,
            url:'<?=$path?>/financeiro/insertSaida',
            dateType:'json',
            method:'POST',
            data:new FormData(document.getElementById("form_saida")),
            success:function(response){
                window.location.reload();
            }
        });
    }else{
        $.ajax({
            processData: false,
            contentType: false,
            url:'<?=$path?>/financeiro/updateSaida/'+id,
            dateType:'json',
            method:'POST',
            data:new FormData(document.getElementById("form_saida")),
            success:function(response){
                window.location.reload();
            }
        });
    }
}


$(document).on('click','.editar',function(){
    var user_id=$(this).attr("id");
    $.ajax({
            url:'<?=$path?>/financeiro/getIdSaida/'+user_id,
            dataType:'json',
            method:'POST',
            success:function(response){
                // console.log(response[0][descricao]);
                $('#id').val(user_id);
                $('#descricao').val(response[0].descricao);
                $('#valor').val(response[0].valor);
                $('#data').val(response[0].data);
                $('#obs').val(response[0].observacao);
                $('#myAddReceber').modal('show');
            }
        });

});
$(document).on('click','.atualiza',function(){
    var id=$(this).attr('id');
    $.ajax({
            url:'<?=$path?>/financeiro/updateStatus/'+id,
            dataType:'json',
            method:'POST',
            success:function(response){
                window.location.reload();
            }
        });
});
</script>
<?php
 require_once ROOT_PATH."/Views/footer.php";
?>