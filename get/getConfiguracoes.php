<?php
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'backup':
					
	            	if(substr_count($_SERVER['PHP_SELF'], '/')>2)
	            	{
	            		include_once('../classes/crudClass.php');
	            		include_once('../classes/Ini.class.php');
	            		$config = new IniParser( '../config.ini' );	
	            		include '../classes/DBBackup.class.php';
	            	}
    				else
    				{
    					include_once('classes/crudClass.php');
    					include_once('classes/Ini.class.php');
    					$config = new IniParser( 'config.ini' );	
    					include 'classes/DBBackup.class.php';
    				}
					
					$db = new DBBackup(array(
					'driver' => 'mysql',
					'host' => $config->getValue('server'),
					'user' => $config->getValue('usuario'),
					'password' => $GLOBALS['id_cliente'],
					'database' => $config->getValue('banco')
					));
					$backup = $db->backup();
					if(!$backup['error'])
					{
						echo 'OK-backup-'.$backup['msg'];
					} 
					else
						echo 'Erro inesperado.';
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
