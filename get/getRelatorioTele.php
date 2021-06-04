<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'carregaItens':
					$cClass->relatorioTelePorData($_POST['data_inicio'],$_POST['data_final']);
					
					if(0<>mysqli_num_rows($cClass->getconsulta()))
					{
						echo '<thead>
              					<tr>
                					<th>Data</th>';
                					if($_POST['cliente']=='true')
                						echo '<th>Cliente</th>';
                					if($_POST['usuario']=='true')
                						echo '<th>Usuário</th>';
                					if($_POST['ac']=='true')
                					{
                						echo '<th>Taxa de Entrega</th>';
                					}
                					echo '<th>Valor (R$)</th>
                					</tr>
            				</thead>
            			<tbody>';  	
            			$contTotal=0;
                        while($array_=mysqli_fetch_array($cClass->getconsulta()))
						{
							$date=date_create($array_['data_tele']);
							echo '<tr>
                					<td>'.date_format($date, 'd/m/Y').'</td>';
                					if($_POST['cliente']=='true')
                						echo '<td>'.$array_['nome'].'</td>';
                					if($_POST['usuario']=='true')
                						echo '<td>'.$array_['login'].'</td>';
                					if($_POST['ac']=='true')
                					{
                						echo '<td>'.$array_['taxa'].'</td>';
                					}
                					echo '<td>'.number_format($array_['valor']+$array_['taxa'],2).'</td>
                					</tr>';
						$contTotal+=$array_['valor']+$array_['taxa'];
						}
                    	echo '</tbody>';
                    	echo '<div id="totals#'.number_format($contTotal,2).'*"></div>';
					}
					else
						echo '<center>Não há dados no período selecionado!</center>';
					break;
				default:
					# code...
					break;
			}
		}
		else
		{
			?>
			
				<script>
					setTimeout(function () { // wait 3 seconds and reload
		        	location.href="../index.php";
		        	}, 2000);
		        
				</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
			<?php
		}
?>
</html>