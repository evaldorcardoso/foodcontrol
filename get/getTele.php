<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'delete':
					if($cClass -> deletar('tele','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'novo':
					if($cClass -> inserir($_POST,'tele'))
					{
						$id=$cClass -> pegaUltimoIdInserido();
						echo 'OK tele='.$id;
					}
					else
						echo 'erro';
					break;
				case 'editar':
					if($cClass -> acaoCrud($_POST,'tele','update','id',$_POST['id']))
						echo 'OK tele='.$_POST['id'];
					else
						echo 'erro';
					break;
				case 'taxaTele':
					if((strlen($_POST['taxa'])-strrpos($_POST['taxa'], "."))>3)
						$_POST['taxa']=str_replace(".","",$_POST['taxa']);
					$_POST['taxa']=str_replace(",",".",$_POST['taxa']);
					//echo $_POST['valor'];
					//print_r($_POST);
					if($cClass -> acaoCrud($_POST,'tele','update','id',$_POST['id']))
						echo 'OK tele-salva';
						//echo '--';
					else
						echo 'erro';
					break;
				case 'entregar':
					if($cClass -> acaoCrud($_POST,'tele','update','id',$_POST['id']))
					{
						$result=$cClass->pesquisarQuantidadeEntregarTele($_POST['id']);
						while($detalhes=mysqli_fetch_array($result))
						{
							$quantidade='';
							if($detalhes['formaQuantidade']==$detalhes['formaVenda'])
								$quantidade=$detalhes['quantidade']*$detalhes['quantidadeVenda'];
							elseif(($detalhes['formaQuantidade']=="l")&&($detalhes['formaVenda']=="ml")) 
								$quantidade=(($detalhes['quantidade']*$detalhes['quantidadeVenda'])/10)/100;
							elseif(($detalhes['formaQuantidade']=="ml")&&($detalhes['formaVenda']=="l"))
								$quantidade=(($detalhes['quantidade']*$detalhes['quantidadeVenda'])*10)*100;
							else
								echo 'Não foi possível atualizar a quantidade no estoque, verifique as formas de quantidade e venda!';
							if($quantidade<>'')
							{
								$q=$cClass->pesquisaCampo('produto_estoque','quantidade',$detalhes['id']);
								$q=$q-$quantidade;
								//echo $quantidade.'-'.$detalhes['quantidade'].'-'.$detalhes['quantidadeVenda'];
								$campos = array('id' => $detalhes['id'],'quantidade' => $q);
								if($cClass->acaoCrud($campos,'produto_estoque','update','id',$detalhes['id']))
									echo 'OK';
								else
									echo 'Não foi possível atualizar a quantidade no estoque';
							}
							else//item não está vinculado a nenhum item do estoque
								echo 'OK';
						}
					}
					else
						echo 'erro';
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
