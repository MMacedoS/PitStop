<?php 
include_once  ROOT_PATH."/Views/header.php";

?>
<div class="col main pt-5 mt-3">
    <div class="row mb-3">
        <div class="col-xl-3 col-sm-6 py-2">
            <a href="<?=$path?>/situacao/index/entrada">
                <div class="card bg-success text-white h-100">
                    <div class="card-body bg-success">
                        <div class="rotate">
                            <i class="fa fa-user fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Entradas HOJE</h6>
                        <h1 class="display-4"><?=count($this->entra_estoque)?></h1>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6 py-2">
            <a href="<?=$path?>/cadastro/produto">
                <div class="card text-white bg-danger h-100">
                    <div class="card-body bg-danger">
                        <div class="rotate">
                            <i class="fa fa-list fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Produtos</h6>
                        <h1 class="display-4"><?=count($this->produtos)?></h1>
                    </div>
                </div>
            </a>
        </div>
        <!-- <div class="col-xl-3 col-sm-6 py-2" onclick="alert('opa');">
            <div class="card text-white bg-info h-100">
                <div class="card-body bg-info">
                    <div class="rotate">
                        <i class="fa fa-twitter fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Saidas</h6>
                    <h1 class="display-4"><=count($this->sai_estoque)?></h1>
                </div>
            </div>
        </div> -->
        <div class="col-xl-3 col-sm-6 py-2 " onclick="alert('opa');">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <div class="rotate">
                        <i class="fa fa-share fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Estoque</h6>
                    <h1 class="display-4"><?=count($this->dados)?> Itens</h1>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->

    <div class="table-responsive" id="lista">

        
    </div>
    <script>
    $(document).ready(function(){
        var html="";
        $.ajax({
            method:'post',
            url: '<?=$path?>/situacao/baixa_estoque',
            dataType:'json',
            success:function(resposta)
            {
                if(resposta.length>=1){
                html+='<p>Produtos abaixo de 10 itens</p>'
                html+='<table class="table table-striped">';
                html+='<thead>';
                html+='<tr>';
                    html+='<th>Produtos</th>';
                    html+='<th>Quantidade disponivel</th>';

                html+='</tr>';
            html+='</thead>';
            html+='<tbody>';
            resposta.forEach(function(dados){
               html+='<tr>';
                    html+='<td>'+dados['descricao']+'</td>';
                    html+='<td>'+dados['saldo_Atual']+'</td>';
                html+='</tr>';
            });
            html+='</tbody>';
        html+='</table>';
            $('#lista').html(html);
            }
            }
        });
    });
</script>
    <?php 
include_once ROOT_PATH."/Views/footer.php";
?>
