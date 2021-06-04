<?php
	session_start();
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'delete':
					if($cClass -> deletar('usuario','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'novo':
					if($_POST['reseta_senha']=='false')
						unset($_POST['reseta_senha']);
					else
						$_POST['reseta_senha']=1;
					if($cClass -> inserir($_POST,'usuario'))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'editar':
					if($_POST['reseta_senha']=='false')
						unset($_POST['reseta_senha']);
					else
						$_POST['reseta_senha']=1;
					$cClass -> acaoCrud($_POST,'usuario','update','id',$_POST['id']);
					echo 'OK';
					break;
				case 'verifica_login':
					$result=$cClass -> pesquisarTabela2('usuario','login',$_POST['login']);
					if(mysqli_num_rows($result))
						echo '<span style="color: red;">Este login já está sendo usado.</span>';
					else
						echo 'OK';
					break;
				case 'login':
					$cClass -> pesquisarTabela('usuario','login',$_POST['login']);
					if(0==mysqli_num_rows($cClass->getconsulta()))
						echo 'erro';//usuario invalido
					else
					{
						$array_=mysqli_fetch_assoc($cClass->getconsulta());
						if($array_['reseta_senha']=='1')
							echo 'OK reseta='.$array_['id'];
						else
						{
							if($array_['senha']==md5($_POST['senha']))
							{
								echo 'OK';
								$_SESSION["id"]=$array_['id'];
								$_SESSION['login']=$array_['login'];
								$_SESSION['nivel']=$array_['nivel'];
							}
							else
								echo 'erro';//senha invalida
						}
					}
					break;
				case 'reseta':
					if($cClass -> acaoCrud($_POST,'usuario','update','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'logout':
					if (isset($_SESSION['login'])){
  						session_unset(); // Eliminar todas as variáveis da sessão
  						session_destroy(); // Destruir a sessão
  					}
  					
  					echo 'OK';
					break;
				default:
					echo 'erro';
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
