<?php 
include_once  ROOT_PATH."/Views/header.php";

?>
<style>
.main {
    max-width: 1200px;
    margin: 0 auto;
}

h1 {
    font-size: 24px;
    font-weight: 400;
    text-align: center;
}

img {
    height: auto;
    max-width: 100%;
    vertical-align: middle;
}


.btn:hover {
    background-color: rgba(255, 255, 255, 0.12);
}

.cards {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    margin: 0;
    padding: 0;
}

.cards_item {
    display: flex;
    cursor: cell;
    padding: 1rem;
}

@media (min-width: 40rem) {
    .cards_item {
        width: 50%;
    }
}

@media (min-width: 56rem) {
    .cards_item {
        width: 15%;
    }
}

.card {
    background-color: white;
    border-radius: 0.25rem;
    box-shadow: 0 20px 40px -14px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.card_content {
    padding: 4px;
    background: linear-gradient(to bottom left, #007bff 40%, #007bff 80%);

}

.card_title {
    color: #ffffff;
    font-size: 1.1rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: capitalize;
    margin: 0px;
    padding: 5px;
}

.card_text {
    color: #ffffff;
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 1.25rem;
    font-weight: 400;
}

.made_by {
    font-weight: 400;
    font-size: 13px;
    margin-top: 35px;
    text-align: center;
}
</style>
<div class="col main pt-5 mt-3">
    <nav class="navbar navbar-light bg-light justify-content-between col-lg-12 col-md-8">
        <a class="navbar-brand">Lista de Produtos</a>
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="pesquisa" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Pesquisar</button>
        </form>
    </nav>

    <div class="main">
        <ul class="cards" id="lista">
        <!-- <php  foreach($this->dados as $value){?> -->
            <!-- <li class="cards_item">
                <div class="card">
                    <div class="card_image"><img src="<=$path?>/estoque/Views/assets/<=$value['imagem']?>"></div>
                    <div class="card_content">
                        <h2 class="card_title text-center"><=$value['descricao']?></h2>
                        <p class="card_text  text-center">R$:<=$value['precoVenda']?></p>
                         <button class="btn card_btn">ADD</button> 
                    </div>
                </div>
            </li> -->
            <!-- <php }?> -->

        </ul>
    </div>

    <h3 class="made_by">Mauricio Macedo</h3>








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
                <h4 class="modal-title" id="myModalLabel">Defina a quantidade.</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                    <input type="hidden" id="id">
                    <input type="hidden" id="saldo">
                        <div class="col">
                            <label for="">Quantidade</label>
                            <input type="number"  min="1" id="quantidade" class="form-control" value="1">
                           
                            <input style="display:none;" type="number" step="0.01" id="preco" min="1" class="form-control" value="1">
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="$('#myCadastrar').modal('hide')" >Close</button>
                <button type="button" class="btn btn-success" onclick="salvar()">CADASTRAR</button>
            </div>
        </div>
    </div>
</div>

<?php 
include_once ROOT_PATH."/Views/footer.php";
?>

<script>
function addModal(event) {
    event.preventDefault();
    $('#myCadastrar').modal('show');
}
function lista(dados)
{
    html='';
    console.log(dados);
    dados.forEach(element => { 
        html+="<li class="+"cards_item"+"><a onclick='add("+element['id_prod']+","+element['precoVenda']+","+element['saldo_Atual']+")'>";
        html+='<div class="card">';
        html+='<div class="card_image"><img src="<?=$path?>/Views/assets/'+element['imagem']+'"></div>';
        html+='<div class="card_content">';
                        html+='<h2 class="card_title text-center">'+element['descricao']+'</h2>';
                        html+='<p class="card_text  text-center">R$:'+element['precoVenda']+'</p>';
                        html+='<p class="card_text  text-center">'+element['saldo_Atual']+' disponiveis</p>';
                        
                    html+='</div>';
                html+='</div>';
            html+='</a></li>';
    });

    $('#lista').html(html);
}

$(document).ready(function(){
    
    $.ajax({
        method:'POST',
        url:'<?=$path?>/caixa/buscaProdutos',
        dataType:'json',
        success:function(dados){
            lista(dados);
        }

    });
    
});

function add(id,preco,saldo)
{   
    if(saldo<=5){window.alert("Estoque Baixo "+saldo+ " itens")}

    $('#id').val(id);
    $('#preco').val(preco)
    $('#saldo').val(saldo)
    $('#myCadastrar').modal('show');
}
function salvar(){
    var caixa="<?=$caixa?>";
    var id_prod=$('#id').val();
    var quantidade=$('#quantidade').val();
    var valor=$('#preco').val();
    var saldo = $('#saldo').val();
    valor=valor*quantidade;
    $.ajax({
        method:'post',
        url:'<?=$path?>/caixa/inserir',
        data:{caixa:caixa,produto:id_prod,quantidade:quantidade,valor:valor},
        dataType:'json',
        success:function(resposta){
            if(resposta)
            {
                $('#myCadastrar').modal('hide');
                window.alert("produto addicionado com sucesso");
                if((saldo-quantidade)<=0){
                    window.alert("produto com estoque negativo");
                }
                window.location.reload();
            }
        }
    });
    
}

</script>