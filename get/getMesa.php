<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'delete':
					if($cClass -> deletar('mesa','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'novo':
					if($cClass -> inserir($_POST,'mesa'))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'editar':
					if($cClass -> acaoCrud($_POST,'mesa','update','id',$_POST['id']))
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
			?>
			
				<script>
					setTimeout(function () { // wait 3 seconds and reload
		        	location.href="../index.php";
		        	}, 2000);
		        
				</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
			<?php
		}
?>
