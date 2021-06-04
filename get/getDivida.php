<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'delete':
					if($cClass -> deletar('divida','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'novo':
					$_POST['valor']=str_replace(".","",$_POST['valor']);
					$_POST['valor']=str_replace(",",".",$_POST['valor']);
					if($_POST['data_pagamento']=='')
						unset($_POST['data_pagamento']);
					if($cClass -> inserir($_POST,'divida'))
						echo 'OK divida';
					else
						echo 'erro';
					break;
				case 'editar':
					if((strlen($_POST['valor'])-strrpos($_POST['valor'], "."))>3)
						$_POST['valor']=str_replace(".","",$_POST['valor']);
					$_POST['valor']=str_replace(",",".",$_POST['valor']);
					if($_POST['data_pagamento']=='')
						unset($_POST['data_pagamento']);
					if($cClass -> acaoCrud($_POST,'divida','update','id',$_POST['id']))
						echo 'OK divida';
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
			echo '
				<script>
					setTimeout(function () { // wait 3 seconds and reload
		        	location.href="../index.php";
		        	}, 2000);
		        
				</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
			';
		}
?>
