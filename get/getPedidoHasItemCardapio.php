<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'delete':
					$item=$cClass->pesquisarTabela2('pedido_has_item_cardapio','id',$_POST['id']);
					$item=mysqli_fetch_array($item);
					if($item['quantidade_entregue']==0)
					{
						$cClass -> deletar('pedido_has_item_cardapio','id',$_POST['id']);
					}
					else
					{
						if($item['quantidade']>$item['quantidade_entregue'])
						{
							$cClass->alterar('quantidade',$item['quantidade_entregue'],'pedido_has_item_cardapio','id',$_POST['id']);
						}
						else
						{
							echo 'Impossivel excluir o item pois já foi entregue para o cliente';
							break;
						}
					}
					$cClass->listarItensPedido($_POST['pedido_id']);
					if(0<>mysqli_num_rows($cClass->getconsulta()))
					{
						$valortotalpedido=0;
						while($array_ = mysqli_fetch_array($cClass->getconsulta()))
							$valortotalpedido+=($array_['quantidade']*$array_['valor']);
							
						//echo $valortotalpedido;
						if($cClass->alterar("valor",$valortotalpedido,'pedido','id',$_POST['pedido_id']))
							echo 'OK';//OK
						else
							echo 'erro';
					}
					else
					{
						if($cClass->alterar("valor","0",'pedido','id',$_POST['pedido_id']))
							echo 'OK';//OK
						else
							echo 'erro';
					}
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
