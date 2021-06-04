<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'delete':
					if($cClass -> deletar('credor','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'novo':
					if($cClass -> inserir($_POST,'credor'))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'editar':
					if($cClass -> acaoCrud($_POST,'credor','update','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'listar':
					$cClass->listar('credor','nome');
                    $count=0;
                    if(mysqli_num_rows($cClass->getConsulta())==0)
                        echo '<center><h4 style="color:#EB2626">Nenhum Credor para mostrar...</h4></center>';
                    else
                    {
                    	echo '<thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="Nome" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Telefone" disabled></th>
                                </tr>
                             </thead>';
                    	while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                        {
                            $count++;
                            echo '<tr style="cursor:hand"
                                  data-toggle="seleciona" 
                                  data-id="'.$array_["id"].'"
                                  data-nome="'.$array_["nome"].'"
                                  data-action="seleciona">
                                    <td>
                                        <small style="color:#080808;font-size: 110%">'.$array_["nome"].'</small>
                                    </td>
                                    <td>
                                        <small style="color:#EB2626;font-size: 100%">'.$array_["telefone"].'</small>
                                    </td>
                                    <td>
                                        <small style="color:#080808;font-size: 110%">'.$array_["celular"].'</small>
                                    </td>
                                  </tr>';
                        }//end while
                    }
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
