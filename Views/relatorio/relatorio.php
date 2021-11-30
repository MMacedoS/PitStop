
<?php $path="http://$_SERVER[HTTP_HOST]".'/BBconfort';?>
<!DOCTYPE >
<html>
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
<meta charset="utf-8">
  
  
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width">
<title>Imprimir</title>
<link rel="stylesheet" type="text/css" href="<?=$path?>/relatorios/css/relatorio.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>


<script>
  // window.alert('funfuuuu');
  var inicio="<?=$_GET['inicio']?>";
  var fim="<?=$_GET['fim']?>";

  $.ajax({
        method:'post',
        url:'<?=$path?>/situacao/buscaRelEntrada/'+inicio+','+fim,
        dataType:'json',
        success:function(resposta)
        {         
          window.itens =resposta;
        }
});
  
//  var s='<=$situacao?>';
//  if (s=="AP" || s=="AP_ano") {
  window.titulo="Relação de Entradas ";
//  }else{
  // window.titulo="Relação de Reprovados";
//  }
</script>
<body>
<div class="float" onclick="window.print();">
    <img src="<?=$path?>/relatorios/images/print.png" alt="">
</div>

</body>
<script src="<?=$path?>/relatorios/js/Empresa.js"></script>
<script src="<?=$path?>/relatorios/configurations/Configurations.js"></script>
<script src="<?=$path?>/relatorios/js/Relatorio.js"></script> 
<script src="<?=$path?>/relatorios/js/GeraRelatorio.js"></script>
</html>