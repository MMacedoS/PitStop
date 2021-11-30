<?php 
include_once  ROOT_PATH."/Views/header.php";

?>
<style>
.tamanhoPag{
    height:200px !important;
}
</style>
<div class="col main pt-5 mt-3">
    <nav class="navbar navbar-light bg-light justify-content-between col-lg-12 col-md-8">
        <a class="navbar-brand">Caixa do Cliente: <?= $this->dados[0]['nome'];?>  <a class="btn btn-outline-primary my-2 my-sm-0 " type="button" id="addCliente">&#9998</a> </a>
        <form class="form-inline">
            <a class="btn btn-outline-primary my-2 my-sm-0 mr-5" type="submit" href="<?=$path?>/caixa/lista/<?=$caixa?>" id="add">ADD</a>
            <!-- <input class="form-control mr-sm-2" type="search" placeholder="pesquisa" id="busca" onkeyup="buscar();" aria-label="Search"> -->
            <!-- <button class="btn btn-outline-success my-2 my-sm-0" onclick="buscar();" type="button">Pesquisar</button> -->
        </form>
    </nav>

    <div class="col-lg-12 col-md-8">
        <div class="table-responsive" id="lista">
        <table class="table table-striped">
                <thead class="thead-inverse">
                
                    <tr>
                        <th>Descicao</th>
                        <th>quatidade</th>
                        <th>Valor UN</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
               
                </thead>
                <tbody>
               <?php 
               $total=0.0;
               foreach($this->consumos as $value){
                   $total+=$value['preco']*$value['itens'];
                   ?>
               
                    <tr>
                        <td id="codigo"><?=$value['descricao']?></td>
                        <td><?=$value['itens']?></td>
                        <td>R$ <?=$value['preco']?></td>
                        <td>R$ <?=number_format($value['preco']*$value['itens'],2,',','')?></td>
                        <td><button class="btn btn-danger" onclick="remover('<?=$value['id_consumo']?>');">&#9746;</button></td>
                    </tr>
                    <?php }?>
                    
                </tbody>
                </table>                
        </div>
        <?php $valor=@$total-@$this->totalPag[0]['total']; ?>
        <div class="row mx-auto">
                <h3>Valor Total do consumo: R$: <?=number_format($total,2,',','')?></h3>
                <div class="row  ml-2">
                    <div class="col mb-2">
                        <button class="btn <?php echo $valor==0?'btn-success':'btn-danger ';?>" onclick="<?php echo $valor==0?'fechar(event)':"alert('Adicione a forma pagamento')";?>">Finalizar Caixa</button>
                    </div>
                    <div class="col mb-2">
                        <button class="btn <?php echo $valor==0?'btn-success':'btn-warning ';?> " onclick="pag(event,'<?=$valor?>')">Pgto Lançados:R$ <?=$this->totalPag[0]['total']?></button>
                    </div>
                    <div class="col mb-2">
                        <button class="btn btn-success " onclick="imprimir(event)">Imprimir Caixa</button>
                    </div>
                </div>
        </div>
    </div>









    <!-- <form>
  <div class="row">
    <div class="col">
      <input type="text" class="form-control" placeholder="First name">
    </div>
    <div class="col">
      <input type="text" class="form-control" placeholder="Last name">
    </div>
  </div>
</form> -->


</div>
<!-- Modal -->
<div class="modal fade" id="myCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cliente <?=$this->dados[0]['nome']?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="form_cliente" enctype="multipart/form-data">
                    <div class="row">
                    <input type="hidden" name="id" id="id" value="0">
                        <div class="col">
                        <label for="">Apelido</label>
                            <input type="text" class="form-control" id="vendas" name="vendas"  value="<?=@$this->dados[0]['nome']?>" placeholder="ex: Conceição do Biliu" required>
                        </div>
                        <div class="col-sm-6">
                     <label for="">Código cliente cadastrado</label>                            
                            <input type="search" class="form-control" name="cliente" id="cliente" value="<?=$this->dados[0]['id_cliente']?>" placeholder="escolha um cliente" list="listaClientes">
                            <datalist id="listaClientes">
                                <?php foreach($clientes as $key => $value){?>
                                    <option value="<?=$value['id_cliente']?>"><?=$value['nome']?></option>                                
                                <?php }?>
                            </datalist>
                        </div>
                    </div>
                    
                </form>

            </div>
            <div class="modal-footer">
            <div class="row mx-auto">
                <button type="button" class="btn btn-danger col py-3 px-md-5 mr-4" data-dismiss="modal">Não</button>
               
                <button type="button" class="btn btn-success col py-3 px-md-5" id="atualizarCliente" data-dismiss="modal">Atualizar</button>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myCadastrar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Finalizar Caixa <?=$this->dados[0]['nome']?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form id="form_categorias" enctype="multipart/form-data">
                    <div class="row">
                    <input type="hidden" name="id" id="id">
                        <div class="col">
                        <label for="">Categoria</label>
                            <input type="text" class="form-control" id="categoria" name="categoria" placeholder="nome da categoria">
                        </div>
                        <div class="col-sm-2">
                        <label for="">Ativo</label>
                            <input type="checkbox" id="status" class="form-control" checked value="true" onclick="ativo();" name="status">
                        </div>                        
                    </div>
                    <div class="row">
                    <div class="col mt-2">
                        <label for="">Imagem</label>
                        <input type="file" name="imagem" class="imagem" id="imagem">
                        <img class="preview-img" id="preview" src="" style="width:40%">
                    </div>
                    </div>
                </form> -->

            </div>
            <div class="modal-footer">
            <div class="row mx-auto">
                <button type="button" class="btn btn-danger col py-3 px-md-5 mr-4" data-dismiss="modal">Não</button>
               
                <button type="button" class="btn btn-success col py-3 px-md-5" onclick="fechamento();" data-dismiss="modal">Sim</button>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myC" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Pagamento de <?=$this->dados[0]['nome']?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">    
                <div class="container table-responsive" id="listaPag">
                <!-- <h4 class="text-center">Lista de Pagamentos</h4>
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Valor</th>
                            <th>Tipo</th>
                            <th>Ação</th>
                        </tr>
                    </thead>    
                    <tbody>
                        <tr>
                            <td>R$: 200,0</td>
                            <td>Dinheiro</td>
                            <td><button class="btn btn-danger" onclick="removerPag('<=$value['id_pagamento']?>');">&#9746;</button></td>
                        </tr>
                       
                        <tr>
                        <td colspan="3"><p class="float-right">10 registros</p></td>
                        </tr>
                    </tbody>
                       
                           
                        
                    </table> -->
                </div>
                <hr>
                <h4 class="text-center">Cadastro de Pagamento</h4>
                <p>Total Consumo:R$ <b><?=number_format(@$total,2,',','')?></b></p>
                <div class="row mt-2">
                
                    <div class="col">
                        <label for="valor">Valor R$:</label>
                        <input type="number" step="0.00" class="form-control" value="<?=@$total-@$this->totalPag[0]['total']?>"  id="valor" placeholder="Valor ex: 20.00">
                    </div>
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

            </div>
            <div class="modal-footer">
            <div class="row mx-auto">
                <button type="button" class="btn btn-danger col py-3 px-md-5 mr-4" data-dismiss="modal">CANCELAR</button>
               
                <button type="button" class="btn btn-success col py-3 px-md-5" onclick="salvar(event);" data-dismiss="modal">ADICIONAR</button>
            </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#addCliente').click(function(event){
    event.preventDefault();
    $("#myCliente").modal("show");
});

$('#atualizarCliente').click(function(event){
    event.preventDefault();
    $.ajax({
        method:'POST',
        dataType:'json',
        processData: false,
        contentType: false,
        data:new FormData(document.getElementById("form_cliente")),      
        url:'<?=$path?>/Caixa/atualizaCliente/<?=$apt?>',
        success:function(response){
            window.location.reload();      
        }
    })
});

function salvar(event){
//  console.log($("#valor").val())
  
    event.preventDefault();
    var valor=$('#valor').val();
    var tipo=$('#tipo').val();
    if(valor>0){
    $.ajax({
        method:'POST',
        dataType:'json',
        data:{valor:valor,tipo:tipo},
        url:'<?=$path?>/Pagamento/AddPagamentos/<?=$caixa?>',
    }).done(function(response){
        // console.log(response);
        if(response.length > 0){
            window.location.reload();
            $('#listaPag').addClass("tamanhoPag");
            lista(response);     
        }
    });
    }else{
        window.location.reload();
    }
}

function fechar(event)
{
    event.preventDefault();
    $("#myCadastrar").modal("show");
    
}
function fechamento(){
    $.ajax({
        method:'POST',
        url:'<?=$path?>/caixa/fechar_estoque/<?=$caixa?>',
    }).done(function(response){
        window.location.href="<?=$path?>";
    });
}
function pag(event,valor)
{
    $('#listaPag').removeClass("tamanhoPag");   
    event.preventDefault();
    $("#myC").modal("show");
    $.ajax({
        method:'POST',
        dataType:'json',
        url:'<?=$path?>/Pagamento/BuscaPagamentos/<?=$caixa?>',
    }).done(function(response){
        // console.log(response);
        if(response.length > 0){
            $('#valor').val(valor);
            $('#listaPag').addClass("tamanhoPag");
            lista(response);     
        }else{
        
        }
    });
    
}

function remover(id)
{
    // event.preventDefault();
    $.ajax({
        method:'POST',
        url:'<?=$path?>/caixa/remover_produto/'+id,
    }).done(function(response){
        window.location.reload();
    });
}
function imprimir(event){
    event.preventDefault();
   
    window.open("<?=$path?>/caixa/relatorio/<?=$caixa?>","_blank");
}


function lista(dados)
{
    var lista ='';
    html='<h4 class="text-center">Lista de Pagamentos</h4><table class="table">';
    html+='<table class="table">';
    html+='<tr>';
        html+='<th>Valor</th>';
        html+='<th>tipo</th>';
        html+='<th>Ação</th>';    
    html+="</tr>";
    dados.forEach(element => {
        
            html+="<tr>";
                html+='<td>'+element.valor+'</td>';
                html+='<td>'+element.tipo+'</td>';
                html+='<td><button class="btn btn-danger remover" id="'+element.id_pagamento+'">&#9746;</button></td>';  
            html+="</tr>";
    });
    html+='<tr>';
        html+='<td colspan="3"><p class="float-right">'+dados.length+' registros</p></td>';
    html+="</tr>";
    // console.log(html)
    $('#listaPag').html(html);
}

$(document).on('click','.remover',function(){
    var user_id=$(this).attr("id");
    console.log(user_id);

    $.ajax({
        method:'POST',
        dataType:'json',
        url:'<?=$path?>/Pagamento/RemoverPagamentos/<?=$caixa?>',
        data:{id:user_id}
    }).done(function(response){
        // console.log(response);
        if(response.length > 0){
            $('#listaPag').addClass("tamanhoPag");
            lista(response);     
        }else{
            $('#listaPag').removeClass("tamanhoPag");
            lista(response);  
        }
    });

});

</script>
<?php 
include_once ROOT_PATH."/Views/footer.php";
?>


