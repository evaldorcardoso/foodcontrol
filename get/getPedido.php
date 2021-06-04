<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'delete':
					$pedido_com_itens=$cClass -> pesquisarTabela2('pedido_has_item_cardapio','pedido_id',$_POST['id']);
					if(0<mysqli_num_rows($pedido_com_itens))
					{
						echo 'Existem itens neste pedido, ele não pode ser excluído';
					}
					else
					{
						if($cClass -> deletar('pedido','id',$_POST['id']))
							echo 'OK';
						else
							echo 'erro';
					}
					break;
				case 'new':
					/*if($cClass -> inserir($_POST,'pedido'))
					{
						$id=$cClass -> pegaUltimoIdInserido();
						echo 'OK pedido='.$id;
					}
					else
						echo 'erro';*/
					if($_POST['mesa_id']=='0')
						unset($_POST['mesa_id']);
					echo 'OK pedido='.$cClass -> inserir_retornando_id($_POST,'pedido');
					break;
				case 'editar':
					if($_POST['mesa_id']=='0')
						unset($_POST['mesa_id']);
					if($cClass -> acaoCrud($_POST,'pedido','update','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'fechar':
					if($cClass->countFecharPedido($_POST['id'])<>0)//verifica se todos os itens estão pagos
						unset($_POST['situacao']);
					if ($cClass->alterar('porcentagem_garcom','porcentagem_garcom+'.$_POST['porcentagem_garcom'],'pedido','id',$_POST['id']))
					{
						if($cClass -> acaoCrud($_POST,'pedido','update','id',$_POST['id']))
							echo 'OK';						
						else
							echo 'erro';
					}
					break;
				case 'imprimir':
					include_once "../nfiscal/imprime_nao_fiscal.php";
					imprime_pedido($_POST['idpedido']);
					break;
				case 'imprimir_comanda':
					include_once "../nfiscal/imprime_nao_fiscal.php";
					imprime_pedido_categoria($_POST['idpedido'],$_POST['categoria']);
					break;
				case 'imprimir_cartao':
					include_once "../nfiscal/imprime_nao_fiscal.php";
					imprime_numero_pedido($_POST['idpedido']);
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
