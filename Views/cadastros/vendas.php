<?php 
include_once  ROOT_PATH."/Views/header.php";

?>
<div class="col main pt-5 mt-3">
    <nav class="navbar navbar-light bg-light justify-content-between col-lg-12 col-md-8">
        <a class="navbar-brand">Lista de Vendas</a>
        <form class="form-inline">
            <button class="btn btn-outline-primary my-2 my-sm-0 mr-5" onclick="addModal(event);">Adicionar</button>
            <input class="form-control mr-sm-2" type="search" placeholder="pesquisa" id="busca" onkeyup="buscar();" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" onclick="buscar();" type="button">Pesquisar</button>
        </form>
    </nav>

    <div class="col-lg-12 col-md-8">
        <div class="table-responsive" id="lista">
           
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
<div class="modal fade" id="myCadastrar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Vendas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_categorias" enctype="multipart/form-data">
                    <div class="row">
                    <input type="hidden" name="id" id="id" value="0">
                        <div class="col">
                        <label for="">Vendas</label>
                            <input type="text" class="form-control" id="vendas" name="vendas" placeholder="APT 01">
                        </div>
                        <div class="col-sm-2">
                        <label for="">Ativo</label>
                            <input type="checkbox" id="status" class="form-control" checked value="true" onclick="ativo();" name="status">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="cadastrar();" data-dismiss="modal">CADASTRAR</button>
            </div>
        </div>
    </div>
</div>

<?php 
include_once ROOT_PATH."/Views/footer.php";
?>

<script>

// const previewImg = document.querySelector('.preview-img');
// const fileChooser = document.querySelector('.imagem');

// fileChooser.onchange = e => {
//     // arquivo que faremos o upload
//     const fileToUpload = e.target.files.item(0);
//     const reader = new FileReader();

// // evento disparado quando o reader terminar de ler 
// reader.onload = e => previewImg.src = e.target.result;

// // solicita ao reader que leia o arquivo 
// // transformando-o para DataURL. 
// // Isso disparará o evento reader.onload.
// reader.readAsDataURL(fileToUpload);
// };
</script>

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
    $('#myCadastrar').modal('show');
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
    array={};
    $.ajax({
                method: 'POST',
                dataType: 'json',
                url: '<?=$path?>/cadastro/Buscar_Apt',
                success: function(response) {                    // console.log(response);
                    array=response;
                    lista(response,0);
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

function editar(obj,param){
  var column = $(obj).parents("tr").find("td:nth-child(" + param + ")");
  var dados = column.html();
  $('#id').val(dados);

                $('#myCadastrar').modal('show');
                
}

function cadastrar(){
    var categoria=$('#categoria').val();
    var status=document.getElementById('status').checked;
      
    
    // alert(form_data);
    var id=$('#id').val();
    
    if(id=='0'){
    $.ajax({
                method: 'POST',
                processData: false,
                contentType: false,
                url: '<?=$path?>/cadastro/inserir_Apt',
                data:new FormData(document.getElementById("form_categorias")),
                success: function(response) {
                    // window.location.reload();
                    console.log(response);
                }
            });
    }else
    {
        $.ajax({
                method: 'POST',
                url: '<?=$path?>/cadastro/update_Apt',
                data:new FormData(document.getElementById("form_categorias")),
                processData: false,
                contentType: false,
                success: function(response) {
                    window.location.reload();
                }
            });
       
    }
}

</script>