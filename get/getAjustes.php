<?php
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'salvar':
						include_once('../classes/Ini.class.php');
    					$config = new IniParser( '../config.ini' );
						//setar algum valor
    					$config->setValue('previsao_tempo_feed', $_POST['previsao_tempo']);
    					$config->setValue('local', $_POST['local']);
    					$config->setValue('type', $_POST['estilo_menu']);	
    					$config->setValue('printer', $_POST['printer']);
    					$config->setValue('printer_cozinha', $_POST['printer_cozinha']);
    					$config->setValue('printer_copa', $_POST['printer_copa']);
    					$config->setValue('razao_social', $_POST['razao_social']);
    					$config->setValue('CNPJ', $_POST['CNPJ']);
    					$config->setValue('imprimir_cupom_obs', $_POST['imprimir_cupom_obs']);
    					$config->setValue('modo_venda', $_POST['modo_venda']);
    					$config->saveFile();
						echo 'OK';
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
