<?php
 require_once ROOT_PATH."/Views/header.php";
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">

<div class="col main pt-5 mt-3">
    <nav class="navbar navbar-light bg-light justify-content-between col-lg-12 col-md-8">
        <a class="navbar-brand">Contas a receber</a>
        <form class="form-inline">
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
                            <h6 class="text-uppercase">Hoje</h6>
                            <h1 class="text-center  mt-4">R$ <?=$info1[0]['saldo']?></h1>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 py-2" onclick="alert('opa');">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body bg-info">
                            <div class="rotate">
                                <i class="fa fa-user fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Mês</h6>
                            <h1 class="text-center  mt-4">R$ <?=$info2[0]['saldo']?></h1>
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
                <th>Apelido</th>
                <th>Nome</th>
                <th>Ações</th>
               
            </tr>
        </thead>
        <tbody>
      <?php foreach($registros as $key=>$value){?>
            <tr>
                <td><?=$value['codPagamento']?></td>
                <td><?php $date=explode('-',$value['createdAt']); echo $date[2].'/'.$date[1].'/'.$date[0];?></td>
                <td><?=$value['valor']?></td>
                <td><?=$value['apelido']?></td>
                <td><?=$value['nome']?></td>
                <td><button class="btn btn-info editar" id="<?=$value['codPagamento']?>">&#9998;</button><a href="<?=ROTA_PATH?>/caixa/fechado/<?=$value['id_venda']?>" class="btn btn-secondary ml-2">Voltar o caixa</a></td> 
                           
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
<div class="modal fade" id="myReceber" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Receber Pagamento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                    <input type="text" name="id" id="id">
                    <div class="col">
                        <label for="tipo">Tipo Pagamento</label>
                        <select class="form-select form-control" id="tipo">
                            <option value="dinheiro" selected>Dinheiro</option>
                            <option value="Transferência">Transferência</option>
                            <option value="Cartão Débito">Cartão Débito</option>
                            <option value="Cartão Crédito">Cartão Crédito</option>
                            <?=$this->dados[0]['id_cliente']==1?'':'<option value="Carteira">Carteira</option>'?>
                            
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
            <div class="row mx-auto">
                <button type="button" class="btn btn-danger col py-3 px-md-5 mr-4" data-dismiss="modal">Não</button>
               
                <button type="button" class="btn btn-success col py-3 px-md-5 " id="simReceber" data-dismiss="modal">Sim</button>
            </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myAddReceber" tabindex="-1" role="dialog">
    <div class="modal-dialog" id="tamanhoModal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Clientes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_cliente" enctype="multipart/form-data">
                    <div class="row">
                    <input type="hidden" name="id" id="id" value="0">
                        <div class="col-sm-12">
                        <label for=""></label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="ex: Namec Gacoe" required>
                        </div>
                                             
                    </div>
                    <div class="row">
                    
                        <div class="col-sm-6">
                        <label for="">Telefone</label>
                            <input type="text" class="form-control" id="telefone" onblur="mascaraDeTelefone(this)" name="telefone" placeholder="7599999999 ou 75999999999" required>
                        </div>
                        <div class="col-sm-6">
                        <label for="">Endereço</label>
                        <input type="text"  class="form-control" id="endereco" name="endereco" placeholder="" required>
                        </div>                        
                    </div>
                    <div class="row">
                    
                        <div class="col-sm-12">
                        <label for="">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="" required>
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

$(document).on('click','.editar',function(){
    var user_id=$(this).attr("id");
    $('#id').val(user_id);
//   $.ajax({
//       method:'POST',
//       url:'<?=$path?>/cadastro/buscaIDcliente/'+user_id,
//       dataType:'json',
//       success:function(response){
//         //   console.log(response[0].nome);
         
        $('#myReceber').modal('show');
//       }
//   });               
                
});
$(document).on('click','#simReceber',function(){
    var id=$('#id').val();
    var tipo=$('#tipo').val();
    $.ajax({
      method:'POST',
      url:'<?=$path?>/Pagamento/Atualiza/',
      data:{id:id,tipo:tipo},
      dataType:'json',
      success:function(response){
        window.location.reload();      

      }
  });
});


function addModal(event)
{
    event.preventDefault();
    $('#myAddReceber').modal('show');
}
</script>
<?php
 require_once ROOT_PATH."/Views/footer.php";
?>