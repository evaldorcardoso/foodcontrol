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
					$cClass->relatorioVendasPorData($_POST['data_inicio'],$_POST['data_final'],$_POST['dinheiro'],$_POST['credito'],$_POST['debito']);
					
					if(0<>mysqli_num_rows($cClass->getconsulta()))
					{
						echo '<thead>
              					<tr>
                					<th>Data</th>';
                					if($_POST['cliente']=='true')
                						echo '<th>Cliente</th>';
                					if(($_POST['dinheiro']=='true')||($_POST['credito']=='true')||($_POST['debito']=='true'))
                						echo '<th>Modo de Pagamento</th>';
                					if($_POST['pg']=='true')
                					{
                						echo '<th>Garçom</th>';
                						echo '<th>Garçom (R$)</th>';
                					}
                					if($_POST['obs']=='true')
                						echo '<th>Observação</th>';
                					echo '<th>Valor (R$)</th>
                					</tr>
            				</thead>
            			<tbody>';  	
            			$contTotal=0;
                        while($array_=mysqli_fetch_array($cClass->getconsulta()))
						{
							$date=date_create($array_['data_pedido']);
							echo '<tr>
                					<td>'.date_format($date, 'd/m/Y').'</td>';
                					if($_POST['cliente']=='true')
                						echo '<td>'.$array_['nome'].'</td>';
                					if(($_POST['dinheiro']=='true')||($_POST['credito']=='true')||($_POST['debito']=='true'))
                					{
                						$modo_pagamento=$array_['modo_pagamento'];
			                            if($modo_pagamento=='0')
			                                $modo_pagamento='Dinheiro';
			                            if($modo_pagamento=='1')
			                                $modo_pagamento='Crédito';
			                            if($modo_pagamento=='2')
			                                $modo_pagamento='Débito';
			                            echo '<td>'.$modo_pagamento.'</td>';
                					}
                					if($_POST['pg']=='true')
                					{
                						echo '<td>'.$array_['login'].'</td>';
                						echo '<td>'.$array_['porcentagem_garcom'].'</td>';
                					}
                					if($_POST['obs']=='true')
                						echo '<td>'.$array_['obs'].'</td>';
                					echo '<td>'.$array_['valor'].'</td>
                					</tr>';
						$contTotal+=$array_['valor'];
						}
                    	echo '</tbody>';
                    	echo '<div id="totals#'.$contTotal.'*"></div>';
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