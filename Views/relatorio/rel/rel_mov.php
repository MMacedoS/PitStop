
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<?php 
$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$tipo = $_GET['tipo'];

if($tipo != 'Todas' and $tipo != 'Entrada'){
	$tipo = 'Saída';
}


$dataIni = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFin = implode('/', array_reverse(explode('-', $dataFinal)));



?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>

	@page {
		margin: 0px;

	}

	.footer {
		position:absolute;
		bottom:0;
		width:100%;
		background-color: #ebebeb;
		padding:10px;
	}

	.cabecalho {    
		background-color: #ebebeb;
		padding-top:15px;
		margin-bottom:30px;
	}

	.titulo{
		margin:0;
	}

	.areaTotais{
		border : 0.5px solid #bcbcbc;
		padding: 15px;
		border-radius: 5px;
		margin-right:25px;
	}

	.areaTotal{
		border : 0.5px solid #bcbcbc;
		padding: 15px;
		border-radius: 5px;
		margin-right:25px;
		background-color: #f9f9f9;
		margin-top:2px;
	}

	.pgto{
		margin:1px;
	}



</style>


<div class="cabecalho">
	
	<div class="row">
		<div class="col-sm-4">	
			
		</div>
		<div class="col-sm-6">	
			<h3 class="titulo"><b>SysMedical - Hospitais e Clínicas</b></h3>
			<h6 class="titulo">Rua da Q-Cursos Networks Nº 1000, Centro - BH - MG - CEP 30555-555</h6>
		</div>
	</div>
	

</div>

<div class="container">


	<div class="row">
		<div class="col-sm-6">	
			 <big><big> RELATÓRIO DE MOVIMENTAÇÕES  </big> </big> 
		</div>
		<div class="col-sm-6">	
			<small><?php 
			if($tipo == 'Todas'){
				echo 'Todas as Movimentações';
			}else{
				echo 'Movimentações de '.$tipo;
			}
			?></small>
		</div>

	</div>

	<div class="row">
		<div class="col-sm-6">	

		</div>
		<div class="col-sm-6">	
			<small><b> Data Inicial:</b> <?php echo $dataIni; ?> <b> Data Final:</b> <?php echo $dataFin; ?> </small>
		</div>

	</div>

	<hr>




	<br><br>

	

		<table class="table">
			<tr bgcolor="#f9f9f9">
				<td style="font-size:12px"> <b>Tipo</b> </td>
				<td style="font-size:12px"> <b>Movimento</b> </td>
				<td style="font-size:12px"> <b> Valor</b> </td>
				<td style="font-size:12px"> <b> Tesoureiro</b> </td>
				
				<td style="font-size:12px"> <b> Data</b> </td>
				
			</tr>
			

			
				<tr>
					<td style="font-size:12px"> 0</td>
					<td style="font-size:12px"> 0</td>
					<td style="font-size:12px"> R$ </td>
					<td style="font-size:12px"> 00</td>

					<td style="font-size:12px"> <</td>

				</tr>

		
		</table>


	<hr>


	<hr>

	<?php
	if($tipo == 'Todas'){

		?>

		<div class="row">
			<div class="col-sm-12">	
				<p style="font-size:12px">
					<b>Quantidade de Entradas:</b>  0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b>Quantidade de Saídas:</b>  0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;




				</p>
			</div>
		</div>

		<div class="row">

			<div class="col-sm-7">	
				<p style="font-size:12px">
					<b>Valor das Entradas:</b> <font color="green"> R$ ,00 </font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b>Valor das Saídas:</b><font color="red"> R$ ,00 </font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;




				</p>
			</div>
			<div class="col-sm-3">	
				<p style="font-size:12px" align="right">
					<b>Saldo Total:</b>
					<?php 
					$saldo=0;
					if($saldo >= 0){
						?>
						<font color="green">R$ <?php echo $saldo ?>,00 </font>
						<?php 
					}else{
						?>
						<font color="red">R$ <?php echo $saldo ?>,00 </font> 
						<?php 
					}

					?>





				</p>
			</div>

		</div>

	<?php }else{

		?>

		<div class="row">
			<div class="col-sm-8">	
				<small><b> Quantidade de Movimentações:</b> <?php echo 0; ?> </small>
			</div>
			<div class="col-sm-4">	
				<small><b> Valor Total:</b> R$<?php echo @$total_mov; ?>,00 </small>
			</div>

		</div>

		<?php
	}

	?>





	
</div>


<div class="footer">
	<p style="font-size:12px" align="center">Desenvolvido por Hugo Vasconcelos - Q-Cursos Networks</p> 
</div>


