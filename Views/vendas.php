<?php 
include "header.php";
// $painel=md5('logado');

?>
<style>
li.cards_item {
    display: inline-block;
    text-align: center; 
    padding:10px;
}
.main {
    padding: 0;
}
ul.cards {
    display: inline-block;
}
li .card {
    width: 100%;
}
.card_image img {
    width: 100%;
    height: 30vh;
}
</style>
<div class="col main pt-5 mt-3">
            <h1 class="display-4 d-none d-sm-block">
            Lista de Caixas 
            </h1>
            <hr>
           <p>
           <form class="form-inline">
            <button class="btn btn-outline-primary my-2 my-sm-0 mr-5 col-sm-4" onclick="addModal(event);">Adicionar</button>
            <!-- <input class="form-control mr-sm-2 text-left pull-right col-sm-6" type="search" placeholder="Pesquisa" id="busca" onkeyup="buscar();" aria-label="Search"> -->
            <!-- <button class="btn btn-outline-success my-2 my-sm-0" onclick="buscar();" type="button">Pesquisar</button> -->
            </form>
            </p>


           <div class="main">

            <ul class="cards" id="listaVendas">
            <?php foreach($vendas as $key=>$value){?>
               <li class="cards_item">
                <div class="card">
                    <div class="card_image">
                    <?php  if($value['status']==1){?>
                            <a href="<?=ROTA_PATH?>/caixa/index/<?=$value['id_venda']?>"><img src="<?=ROTA_PATH?>/Views/assets/vendas.jpg"></a>
                    <?php }else{?>
                        <!-- <a href="<=ROTA_PATH?>/caixa/index/<=$value['id_venda']?>"> <img src="<=ROTA_PATH?>/Views/assets/fechada.png"></a> -->                        
                    <?php }?>
                    </div>
                    <div class="card_content">
                    <h2 class="card_title"><?=$value['nome']?></h2>   
                    </div>
                </div>
                </li>
                <?php }?>
            </ul>
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
                        <label for="">Apelido</label>
                            <input type="text" class="form-control" id="vendas" name="vendas" placeholder="ex: CAIXA 01" required>
                        </div>
                        <div class="col-sm-6">
                     <label for="">Código cliente cadastrado</label>                            
                            <input type="search" class="form-control" name="cliente" id="cliente" placeholder="escolha um funcionario" list="listaClientes">
                            <datalist id="listaClientes">
                                <?php foreach($clientes as $key => $value){?>
                                    <option value="<?=$value['id_cliente']?>"><?=$value['nome']?></option>                                
                                <?php }?>
                            </datalist>
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
           
                <!-- <div class="col-lg-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>#</th>
                                    <th>Label</th>
                                    <th>Header</th>
                                    <th>Column</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1,001</td>
                                    <td>responsive</td>
                                    <td>bootstrap</td>
                                    <td>cards</td>
                                    <td>grid</td>
                                </tr>
                                <tr>
                                    <td>1,002</td>
                                    <td>rwd</td>
                                    <td>web designers</td>
                                    <td>theme</td>
                                    <td>responsive</td>
                                </tr>
                                <tr>
                                    <td>1,003</td>
                                    <td>free</td>
                                    <td>open-source</td>
                                    <td>download</td>
                                    <td>template</td>
                                </tr>
                                <tr>
                                    <td>1,003</td>
                                    <td>frontend</td>
                                    <td>developer</td>
                                    <td>coding</td>
                                    <td>card panel</td>
                                </tr>
                                <tr>
                                    <td>1,004</td>
                                    <td>migration</td>
                                    <td>bootstrap 4</td>
                                    <td>mobile-first</td>
                                    <td>design</td>
                                </tr>
                                <tr>
                                    <td>1,005</td>
                                    <td>navbar</td>
                                    <td>sticky</td>
                                    <td>jumbtron</td>
                                    <td>header</td>
                                </tr>
                                <tr>
                                    <td>1,006</td>
                                    <td>collapse</td>
                                    <td>affix</td>
                                    <td>submenu</td>
                                    <td>flexbox</td>
                                </tr>
                                <tr>
                                    <td>1,007</td>
                                    <td>layout</td>
                                    <td>examples</td>
                                    <td>themes</td>
                                    <td>grid</td>
                                </tr>
                                <tr>
                                    <td>1,008</td>
                                    <td>migration</td>
                                    <td>bootstrap 4</td>
                                    <td>flexbox</td>
                                    <td>design</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> -->


            </div>
            <!--/row-->

           

        
            <!-- <a id="layouts"></a> -->
          
           
                <!-- <div class="col-lg-6">
                    <-- Nav tabs ->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#home1" role="tab" data-toggle="tab">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#profile1" role="tab" data-toggle="tab">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#messages1" role="tab" data-toggle="tab">Messages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#settings1" role="tab" data-toggle="tab">Settings</a>
                        </li>
                    </ul> -->

                    <!-- Tab panes
                    <div class="tab-content">
                        <br>
                        <div role="tabpanel" class="tab-pane active" id="home1">
                            <h4>Home</h4>
                            <p>
                                1. These Bootstrap 4 Tabs work basically the same as the Bootstrap 3.x tabs.
                                <br>
                                <br>
                                <button class="btn btn-primary-outline btn-lg">Wow</button>
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile1">
                            <h4>Pro</h4>
                            <p>
                                2. Tabs are helpful to hide or collapse some addtional content.
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="messages1">
                            <h4>Messages</h4>
                            <p>
                                3. You can really put whatever you want into the tab pane.
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="settings1">
                            <h4>Settings</h4>
                            <p>
                                4. Some of the Bootstrap 3.x components like well and panel have been dropped for the new card component.
                            </p>
                        </div>
                    </div> -->
                <!-- </div> -->
               
                    </div><!--/card-->
                </div><!--/col-->
               
            </div><!--/row-->

        </div>
        <!--/main col-->
    </div>

</div>
<!--/.container-->
<script>

// const cliente=<=json_encode($clientes)?>
// console.log(cliente);

// function ativo(){
//     var check=document.getElementById('status').checked;
//     if(check){
//         document.getElementById('status').value =true;
//     }else{
//         document.getElementById('status').value =false;
//     }
// }

function listavendas(dados){
    

}

function addModal(event) {
    event.preventDefault();
    $('#myCadastrar').modal('show');
}

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

function cadastrar(){
    var categoria=$('#categoria').val();
    // var status=document.getElementById('status').checked;
      
    
    // alert(form_data);
    var id=$('#id').val();
     if($('#vendas').val()==''){
         window.stop();
     }
    if(id=='0'){
    $.ajax({
                method: 'POST',
                processData: false,
                contentType: false,
                dataType: 'json',
                url: '<?=$path?>/cadastro/inserir_Venda',
                data:new FormData(document.getElementById("form_categorias")),
                success: function(response) {
                    console.log(response);
                    window.location.href="<?=ROTA_PATH?>/caixa/index/"+response;
                    // console.log(response);
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

<?php 
include "footer.php";
?>