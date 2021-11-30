<?php 
include_once  ROOT_PATH."/Views/header.php";

?>
<div class="col main pt-5 mt-3">
<!-- div acima para organizar junto com o menu -->
<nav class="navbar navbar-light bg-light justify-content-between col-lg-12 col-md-8">
        <a class="navbar-brand">Saida</a>
        <form class="form-inline">
            <label for="data_inicio"></label>
            <input type="date" id="data_inicio" class="form-control ml-4 mr-4" value="<?=Date('Y-m-d')?>">
            <label for="data_fim">até</label>
            <input type="date" id="data_fim" class="form-control ml-4 mr-4" value="<?=Date('Y-m-d')?>">
            <button class="btn btn-outline-danger my-2 my-sm-0 mr-5" onclick="buscar(event);">Buscar</button>
            <!-- <button class="btn btn-outline-primary my-2 my-sm-0 mr-5" onclick="addModal(event);">Adicionar</button> -->
            <!-- <input class="form-control mr-sm-2" type="search" placeholder="pesquisa" id="busca" onkeyup="buscar();" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" onclick="buscar();" type="button">Pesquisar</button> -->
        </form>
    </nav>

    <div class="col-lg-12 col-md-8">
        <div class="table-responsive" id="lista">
                       
        </div>
    </div>

</div>
            <!--/row-->

<!-- Modal -->
<div class="modal fade" id="myCadastrar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Entrada</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_categorias" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <label for="produto">Produto</label>
                            <select name="" class="form-control" id="produto">
                                <?php foreach($this->produtos as $value){?>
                                <option value="<?=$value['id_prod']?>"><?=$value['descricao']?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                    <input type="hidden" name="id" id="id">
                        <div class="col">
                        <label for="quantidade">Quantidade</label>
                            <input type="number" min="0" class="form-control" id="quantidade" name="quantidade">
                        </div>
                        <div class="col">
                        <label for="data">Data</label>
                            <input type="date"  class="form-control" id="data" name="data" value="<?=date('Y-m-d')?>">
                        </div>
                        <!-- <div class="col-sm-2">
                        <label for="">Ativo</label>
                            <input type="checkbox" id="status" class="form-control" checked value="true" onclick="ativo();" name="status">
                        </div>                         -->
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
                <button type="button" class="btn btn-success" onclick="salvar();" data-dismiss="modal">CADASTRAR</button>
            </div>
        </div>
    </div>
</div>

 <?php 
include_once ROOT_PATH."/Views/footer.php";
?>

<script>
function dataAtualFormatada(){
    var data = new Date(),
        dia  = data.getDate().toString(),
        diaF = (dia.length == 1) ? '0'+dia : dia,
        mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0'+mes : mes,
        anoF = data.getFullYear();
    return diaF+"/"+mesF+"/"+anoF;
}

function buscar(event){
    event.preventDefault();
    var inicio=$('#data_inicio').val();
    var fim=$('#data_fim').val();

    window.open("<?=$path?>/estoque/caixa/saida/"+inicio+"|"+fim,"_blank");

}
</script>

