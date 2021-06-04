<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'delete':
					if($cClass -> deletar('item_cardapio','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'novo':
					$_POST['valor']=str_replace(".","",$_POST['valor']);
					$_POST['valor']=str_replace(",",".",$_POST['valor']);
					if($cClass -> inserir($_POST,'item_cardapio'))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'editar':
					if((strlen($_POST['valor'])-strrpos($_POST['valor'], "."))>3)
						$_POST['valor']=str_replace(".","",$_POST['valor']);
					$_POST['valor']=str_replace(",",".",$_POST['valor']);
					//echo $_POST['valor'];
					if($cClass -> acaoCrud($_POST,'item_cardapio','update','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'inserirnopedido':
					//print_r($_POST);
					if($cClass -> inserir($_POST,'pedido_has_item_cardapio'))
					{
						$cClass->listarItensPedido($_POST['pedido_id']);
						if(0<>mysqli_num_rows($cClass->getconsulta()))
						{
							$valortotalpedido=0;
							while($array_ = mysqli_fetch_array($cClass->getconsulta()))
							{
								$valortotalpedido+=($array_['quantidade']*$array_['valor']);
							}
							//echo $valortotalpedido;
							if($cClass->alterar("valor",$valortotalpedido,'pedido','id',$_POST['pedido_id']))
								echo 'OK inicio';//OK
							else
								echo 'erro';
						}
						else
							echo 'nao ha itens neste pedido';
					}
					else
						echo 'erro';
					break;
				case 'inserirnatele':
					if($cClass -> inserir($_POST,'tele_has_item_cardapio'))
					{
						$cClass->listarItensTeleTodos($_POST['tele_id']);
						if(0<>mysqli_num_rows($cClass->getconsulta()))
						{
							$valortotaltele=0;
							while($array_ = mysqli_fetch_array($cClass->getconsulta()))
							{
								$valortotaltele+=($array_['quantidade']*$array_['valor']);
							}
							//echo $valortotalpedido;
							if($cClass->alterar("valor",$valortotaltele,'tele','id',$_POST['tele_id']))
								echo 'OK';//OK
							else
								echo 'erro';
						}
						else
							echo 'nao ha itens nesta tele';
					}
					else
						echo 'erro';
					break;
				case 'pronto':
						if($cClass -> acaoCrud($_POST,'pedido_has_item_cardapio','update','id',$_POST['id']))
							echo 'OK-pronto='.$_POST['id'];
						else
							echo 'erro';
					break;
				case 'entregue':
						if(isset($_POST['categoria']))//o item é bebida
						{
							$quantidade='';//quantidade a ser reduzida no estoque
							$quantEntregue=$_POST['quantEntregue'];
							unset($_POST['categoria']);
							unset($_POST['quantEntregue']);
							if($cClass -> acaoCrud($_POST,'pedido_has_item_cardapio','update','id',$_POST['id']))
							{

								$detalhes=$cClass->pesquisarQuantidadeItem($_POST['id']);
								//echo $detalhes['quantidadeVenda'].'-'.$quantEntregue;
								if($detalhes['formaQuantidade']==$detalhes['formaVenda'])
									$quantidade=$quantEntregue*$detalhes['quantidadeVenda'];
								elseif(($detalhes['formaQuantidade']=="l")&&($detalhes['formaVenda']=="ml")) 
									$quantidade=(($quantEntregue*$detalhes['quantidadeVenda'])/10)/100;
								elseif(($detalhes['formaQuantidade']=="ml")&&($detalhes['formaVenda']=="l"))
									$quantidade=(($quantEntregue*$detalhes['quantidadeVenda'])*10)*100;
								else
									echo 'Não foi possível atualizar a quantidade no estoque, verifique as formas de quantidade e venda!';
								//echo $quantidade.'='.$quantEntregue.'*'.$detalhes['quantidadeVenda'].'/10])/100';
								if($quantidade<>'')
								{
									//echo 'quantidade entregue='.$quantidade;
									$quantidade=$detalhes['quantidade'] - $quantidade;
									$campos = array('id' => $detalhes['id'],'quantidade' => $quantidade);
									if($cClass->acaoCrud($campos,'produto_estoque','update','id',$detalhes['id']))
									{
										echo 'OK-entregue='.$_POST['id'];
										//echo '  atualizei quantidade='.$quantidade;
									}
									else
										echo 'Não foi possível atualizar a quantidade no estoque';
								}
								else//item não está vinculado a nenhum item do estoque
									echo 'OK-entregue='.$_POST['id'];
							}
							else
								echo 'erro';
						}
						else
						{
							if($cClass -> acaoCrud($_POST,'pedido_has_item_cardapio','update','id',$_POST['id']))
							{
								echo 'OK-entregue='.$_POST['id'];
							}
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
