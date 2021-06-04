<?php
	include_once '../classes/crudClass.php';
	include_once '../classes/mac.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'novo':
						$_POST['idUsuario']=$GLOBALS['id_cliente'];
						include_once '../classes/mac.php';
						$pegamac = new Mac;
						$mac=$pegamac->MacId();
						$_POST['codigo']=base64_encode($_POST['idUsuario'].'/'.$mac.'/'.(time() + 86400));//adiciona um dia a mais
						if($cClass -> inserir($_POST,'licenca'))
							echo 'OK';
						else
							echo 'erro';
					break;
				case 'novo_cadastro':
					//array_push($_POST['idUsuario'], $GLOBALS['id_cliente']);
					$_POST += array('idUsuario' => $GLOBALS['id_cliente']);
					if($cClass -> inserir($_POST,'licenca'))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'renovar':
					$result=$cClass->pesquisarTabela2('licenca','id',$_POST['id']);
					if(0<>mysqli_num_rows($result))
					{
						while($array=mysqli_fetch_array($result))
						{
							$codigo=$array['codigo'];
							$idUsuario=$array['idUsuario'];
							break;
						}
						$codigoNEW=base64_decode($_POST['codigo']);
						$p_barra1=strpos($codigoNEW, '/');//posicao da barra 1
						$p_barra2=strripos($codigoNEW, '/');//posicao da barra 2
						$idUsuario=substr($codigoNEW, 0,$p_barra1);
						$data=substr($codigoNEW, $p_barra2+1);//pega o valor depois do ultimo '/' encontrado
						$data_now=time();
						$mac=substr($codigoNEW, $p_barra1+1,($p_barra2-$p_barra1)-1);
						include_once '../classes/mac.php';
						$pegamac = new Mac;
						$pcmac= $pegamac->MacId();
						if($idUsuario==$GLOBALS['id_cliente'])
						{
							if(strcmp($mac, $pcmac)==0)
							{
								if(strtotime(date("d-m-Y",$data))>=strtotime(date("d-m-Y",$data_now)))
								{
									if($cClass -> acaoCrud($_POST,'licenca','update','id',$_POST['id']))
										echo 'OK';
									else
										echo 'erro';
								}
								else
									echo 'A data da licença é inferior a data atual';
							}
							else
								echo 'Esta licença não pertence a este computador';
						}
						else
							echo 'Esta licença não pertence a este usuário';
					}
					else
						echo 'Não achei a licença no banco de dados';
					break;

				case 'editar':
						$result=$cClass->pesquisarTabela2('licenca','id',$_POST['id']);
						if(0<>mysqli_num_rows($result))
						{
							while($array=mysqli_fetch_array($result))
							{
								$codigo=$array['codigo'];
								$idUsuario=$array['idUsuario'];
								break;
							}
						$codigoNEW=base64_decode($_POST['codigo']);
						$p_barra1=strpos($codigoNEW, '/');//posicao da barra 1
						$p_barra2=strripos($codigoNEW, '/');//posicao da barra 2
						$idUsuario=substr($codigoNEW, 0,$p_barra1);
						$data=substr($codigoNEW, $p_barra2+1);//pega o valor depois do ultimo '/' encontrado
						$data_now=time();
						$mac=substr($codigoNEW, $p_barra1+1,($p_barra2-$p_barra1)-1);
						if($idUsuario==$GLOBALS['id_cliente'])
						{
							if(strtotime(date("d-m-Y",$data))>=strtotime(date("d-m-Y",$data_now)))
							{
								if($cClass -> acaoCrud($_POST,'licenca','update','id',$_POST['id']))
									echo 'OK';
								else
									echo 'erro';
							}
							else
								echo 'A data da licença é inferior a data atual';
						}
						else
							echo 'Esta licença não pertence a este usuário';
						}
						else
							echo 'Não achei a licença no banco de dados';
					break;
				case 'delete':
					if($cClass -> deletar('licenca','id',$_POST['id']))
						echo 'OK';
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
			echo '<script>
					setTimeout(function () { // wait 3 seconds and reload
		        	location.href="../index.php";
		        	}, 2000);
		        
				</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->';
		}
?>
