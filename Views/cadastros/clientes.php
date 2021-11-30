<?php 
include_once  ROOT_PATH."/Views/header.php";

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
<style>
#tamanhoModal{
  max-width: 90% !important;
}

</style>
<!-- <div class="col main pt-5 mt-3">
    <nav class="navbar navbar-light bg-light justify-content-between col-lg-12 col-md-8">
        <a class="navbar-brand">Lista de Categorias</a>
        <form class="form-inline">
            <button class="btn btn-outline-primary my-2 my-sm-0 mr-5" onclick="addModal(event);">Adicionar</button>
            <input class="form-control mr-sm-2" type="search" placeholder="pesquisa" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Pesquisar</button>
        </form>
    </nav>

    <div class="main">
  <ul class="cards">
    <li class="cards_item">
      <div class="card">
        <div class="card_image"><img src="https://picsum.photos/500/300/?image=10"></div>
        <div class="card_content">
          <h2 class="card_title">Card Grid Layout</h2>
          <p class="card_text">Demo of pixel perfect pure CSS simple responsive card grid layout</p>
          <button class="btn card_btn">Read More</button>
        </div>
      </div>
    </li>
  
  </ul>
</div> -->

<!-- <h3 class="made_by">Mauricio Macedo</h3> -->
<!-- </div> -->

<div class="col main pt-5 mt-3">
    <nav class="navbar navbar-light bg-light justify-content-between col-lg-12 col-md-8">
        <a class="navbar-brand">Lista de Funcionario</a>
        <form class="form-inline">
            <button class="btn btn-outline-primary my-2 my-sm-0 mr-5" onclick="addModal(event);">Adicionar</button>
            <!-- <input class="form-control mr-sm-2" type="search" placeholder="pesquisa" id="busca" onkeyup="buscar();" aria-label="Search"> -->
            <!-- <button class="btn btn-outline-success my-2 my-sm-0" onclick="buscar();" type="button">Pesquisar</button> -->
        </form>
    </nav>
<!-- </br></br> -->
    <div class="col-lg-12 col-md-8 mt-3">
        <div class="table-responsive" id="lista">
        <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Status</th>
                <th>Ações</th>
               
            </tr>
        </thead>
        <tbody>
      <?php foreach($registros as $key=>$value){?>
            <tr>
                <td><?=$value['id_cliente']?></td>
                <td><?=$value['nome']?></td>
                <td><?=$value['status']?></td>
                <td><button class="btn btn-info editar" id="<?=$value['id_cliente']?>">&#9998;</button></td>               
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
<div class="modal fade" id="myCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog" id="tamanhoModal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Funcionario</h4>
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
                        <label for="">Nome do Funcionario</label>
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

<?php 
include_once ROOT_PATH."/Views/footer.php";
?>


<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>

var array;
let pag=0;

function ativo(){
    var check=document.getElementById('status').checked;
    if(check){
        document.getElementById('status').value =true;
    }else{
        document.getElementById('status').value =false;
    }
}

function addModal(event) {
    event.preventDefault();
    $('#myCliente').modal('show');
}

function lista(dados,numero)
{
    var html="";
    var totol= dados.length;    
    var ultimapag=Math.round(totol);
    //  pag+=numero;
    let pag2=0
    // console.log("primeiro"+pag);
    if(ultimapag>10){
         pag2=pag+10;
        
    }else
        {
        // console.log(dados[0]['id_cat']);
         pag2=ultimapag;
    }
    
    // console.log("pgar "+array.length);
    
     html+='<table class="table table-striped">'+
                '<thead class="thead-inverse">'+
                
                    '<tr>'+
                        '<th>Cód</th>'+
                        '<th>Nome</th>'+
                        '<th>Status</th>'+
                        '<th>Ações</th>'+
                    '</tr>'+
               
                '</thead>'+
                '<tbody>';
               for(let i=pag;i<pag2;i++){
                // console.log("pag"+pag);
                // console.log("pag2"+pag2);
                   if(dados[i]!=null){
               
                    html+='<tr>'+
                        '<td id="codigo">'+dados[i]['id_venda']+'</td>';
                        html+='<td>'+dados[i]['nome']+'</td>';
                        if(dados[i]['status']==0){
                        html+='<td>Ativo</td>';
                        }else{html+='<td>Ocupado</td>';}
                        html+='<td><button onclick="editar(this,1);">&#9998;</button></td>'+
                       
                    '</tr>';
                    }
                    }
                html+='</tbody>'+
                '</table> <nav aria-label="Navegação de página exemplo">'+
                '<ul class="pagination">';
                if(pag==0){
                    html+='<li class="page-item"><button class="btn btn-secondary" disabled>Anterior</button></li>';
                }else{
                    html+='<li class="page-item"><button class="btn btn-secondary" onclick="anterior('+'10'+')" >Anterior</button></li>';
                } 
                if(pag2-10==pag){
                    html+='<li class="page-item"><button class="btn btn-primary" onclick="proxima('+'10'+')">Próximo</button></li>';
                }else{
                    
                }
                html+='</ul>'+
                '</nav>';
            

            $('#lista').html(html);
}

$(document).ready(function(){
  $('#example').DataTable();
    array={};
    $.ajax({
                method: 'POST',
                dataType: 'json',
                url: '<?=$path?>/cadastro/Buscar_Apt',
                success: function(response) {                    // console.log(response);
                    array=response;
                    // lista(response,0);
                }
            });

});

function buscar(){
    var busca=$('#busca').val();
    $.ajax({
                method: 'POST',
                dataType: 'json',
                data:{busca:busca},
                url: '<?=$path?>/cadastro/Buscar_Apt',
                success: function(response) {
                    // console.log(response);
                    lista(response,0);
                }
            });

}

function anterior(valor)
{
    pag-=valor;
    // console.log(pag);
    lista(array,10);
}
function proxima(valor)
{
    var ultimapag=Math.round(array.length);
    if(pag<ultimapag){
        pag+=valor;
    // console.log(pag);
    lista(array,10);
    }
   
}

$(document).on('click','.editar',function(){
    var user_id=$(this).attr("id");
  $('#id').val(user_id);
  $.ajax({
      method:'POST',
      url:'<?=$path?>/cadastro/buscaIDcliente/'+user_id,
      dataType:'json',
      success:function(response){
        //   console.log(response[0].nome);
          $('#nome').val(response[0].nome);
          $('#telefone').val(response[0].telefone);
          $('#endereco').val(response[0].endereco);
          $('#email').val(response[0].email);
        $('#myCliente').modal('show');
      }
  });

                
                
});

function cadastrar(){
    
    // alert(form_data);
    var id=$('#id').val();
    
    if(id=='0'){
    $.ajax({
                method: 'POST',
                processData: false,
                contentType: false,
                url: '<?=$path?>/cadastro/inserirCliente',
                data:new FormData(document.getElementById("form_cliente")),
                success: function(response) {
                    window.location.reload();
                    console.log(response);
                }
            });
    }else
    {
        
        $.ajax({
                method: 'POST',
                url: '<?=$path?>/cadastro/updateCliente',
                data:new FormData(document.getElementById("form_cliente")),
                processData: false,
                contentType: false,
                success: function(response) {
                    window.location.reload();
                    console.log(response);
                }
            });
       
    }
}


function mascaraDeTelefone(telefone){
    const textoAtual = telefone.value;
    const isCelular = textoAtual.length === 11;
    let textoAjustado;
    if(isCelular) {
        const parte1 = textoAtual.slice(0,2);
        const parte2 = textoAtual.slice(2,7);
        const parte3 = textoAtual.slice(7,11);
        textoAjustado = `(${parte1}) ${parte2}-${parte3}`        
    } else {
        const parte1 = textoAtual.slice(0,2);
        const parte2 = textoAtual.slice(2,6);
        const parte3 = textoAtual.slice(6,10);
        textoAjustado = `(${parte1}) ${parte2}-${parte3}`
    }

    telefone.value = textoAjustado;
}

</script>