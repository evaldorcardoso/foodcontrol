<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'delete':
					if($cClass -> deletar('cliente','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'novo':
					if($cClass -> inserir($_POST,'cliente'))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'novo_from_pedido':
					echo 'OK cliente='.$cClass -> inserir_retornando_id($_POST,'cliente');
					break;
				case 'editar':
					if($cClass -> acaoCrud($_POST,'cliente','update','id',$_POST['id']))
						echo 'OK';
					else
						echo 'erro';
					break;
				case 'listar':
					$cClass->listar('cliente','nome');
                    $count=0;
                    if(mysqli_num_rows($cClass->getConsulta())==0)
                        echo '<center><h4 style="color:#EB2626">Nenhum Cliente para mostrar...</h4></center>';
                    else
                    {
                    	echo '<thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="Nome" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Endereço" disabled></th>
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
                                        <small style="color:#EB2626;font-size: 100%">'.$array_["endereco"].'</small>
                                    </td>
                                    <td>
                                        <small style="color:#080808;font-size: 110%">'.$array_["telefone"].'</small>
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
			?>
			
				<script>
					setTimeout(function () { // wait 3 seconds and reload
		        	location.href="../index.php";
		        	}, 2000);
		        
				</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
			<?php
		}
?>
