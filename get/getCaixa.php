<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php
	include_once '../classes/crudClass.php';
	$cClass = new crudClass();	
	//////////////////////////////////
		if(isset($_GET['action']))
		{
			switch ($_GET['action']) 
			{
				case 'carregaItens':
					$cClass->listarItensPedidoCaixa($_GET['idpedido']);
					if(0<>mysqli_num_rows($cClass->getconsulta()))
					{
						echo '<thead>                   
                                <th><input type="checkbox" id="checkall" onchange="percorreTabela()"/></th>
                                <th><small>Quant.</small></th>
                                <th><small>Quant. a ser paga</small></th>
                                <th>Item</th>
                                <th>Mesa</th>
                                <th>Pedido</th>
                                <th>Valor Unitário</th>
                              </thead>
                              <tbody>';  
                        while($array_=mysqli_fetch_array($cClass->getconsulta()))
						{
							$quantidade_a_pagar=$array_["quantidade"]-$array_["quantidade_paga"];
							$disabled='';
							if($quantidade_a_pagar=='0')
								$disabled='disabled';
							echo '<tr id="tr-'.$array_["id"].'" value="teste">
                                    <td><div class="col-md-1"><input type="checkbox" class="checkthis" '.$disabled.' onchange="percorreTabela()"/></div></td>
                                    <td><div class="col-md-2">'.$array_["quantidade"].'</div></td>
                                    <td class="col-quantidade">
                                      <div class="input-group" style="max-width:130px">
                                         <span class="input-group-btn">
                                                <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant['.$array_["id"].']" '.$disabled.'>
                                                  <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="quant['.$array_["id"].']" class="form-control input-number" value="'.$quantidade_a_pagar.'" min="1" max="'.$quantidade_a_pagar.'" '.$disabled.' onchange="percorreTabela()">
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant['.$array_["id"].']" '.$disabled.'>
                                                <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                            </span>
                                          </div>
                                        </td>
                                        <td>'.$array_["descricao"].'</td>
                                        <td>'.$array_["mesa"].'</td>
                                        <td>'.$array_["nome"].'</td>
                                        <td class="col-valor">R$ '.$array_["valor"].'</td>
                                      </tr>';
						}
                    	echo '</tbody>';
					}
					else
					{
						echo '<center>Não há itens neste pedido!';
					}
					break;
				case 'carregaTotaisPedido':
					$result=$cClass->pesquisarValoresTotaisPedido($_GET['idpedido']);
					if($result)
					{
						echo '
						<div class="col-lg-2 col-md-2 col-sm-2">
                              <span class="help-block">Adicionar mais itens:</span>
                              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#lista_itens_cardapio">Adicionar Itens</button>
                          </div>
							<div class="col-lg-1 col-md-1 col-sm-1">
                              <span class="help-block">Garçom(+10%):</span>
                              <input id="porcentagem_garcom" type="checkbox" class="form-control" style="cursor:hand" onchange="porcentagem_garcom()">
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                              <span class="help-block">Já pagou:</span>
                              <input id="valorpago" type="text" class="form-control" value='.$result["valorpago"].' disabled>
                            </div>
						<div class="col-lg-2 col-md-2 col-sm-2">
                              <span class="help-block">Total:</span>
                              <input id="total" type="text" class="form-control" value='.$result["valor"].' disabled>
                            </div>
                            
                            <div class="col-lg-2 col-md-2 col-sm-2">
                              <span class="help-block">Valor a Pagar:</span>
                              <input id="valorapagar" type="text" class="form-control" value='.$result["valorapagar"].' disabled>
                            </div>';
                    }
                    else
                    	echo 'erro';
					break;
				case 'carregaDetalhesPedido':
					$result=$cClass->pesquisarDetalhesPedido($_GET['idpedido']);
					if($result)
					{
						echo '<div class="row">
						<div class="col-md-3">
                            <h4><span class="label label-info">Pedido Nº: '.$result['id'].'</span></h4>  
                          </div>
                          <div class="col-md-4">
                            <h4><span class="label label-info">Cliente: '.$result['nome'].'</span></h4>  
                          </div>
                          <div class="col-md-3">
                            <h4><span class="label label-info">Garçom: '.$result['garcom'].'</span></h4>  
                          </div>
                          <div class="col-md-1">
                            <h4><span class="label label-info">Mesa: '.$result['descricao'].'</span></h4>  
                          </div>
                          
                          </div>
                          <div class="row">
                          <div class="col-md-6">
                            <h4><span class="label label-info">Obs.: '.$result['obs'].'</span></h4>  
                          </div>
                          </div><hr>';
                    }
                    else
                    	echo 'erro';
					break;
				case 'pagarItem':
					if ($cClass->alterar('quantidade_paga','quantidade_paga+'.$_POST['quantidade_paga'],'pedido_has_item_cardapio','id',$_POST['id']))
					{
						echo 'OK paga-item';
					}
					break;
				
				case 'pagarItemNovo':/*FUNÇÃO PARA PAGAR OS ITENS*/
					$quantidade=$_POST['quantidade_paga'];
					$campos = array('pedido_id' => $_POST['pedido_id'],'item_cardapio_id' => $_POST['id']);
					$cClass->pesquisaTabela('pedido_has_item_cardapio',$campos);
					while($array_ = mysqli_fetch_array($cClass->getconsulta()))
					{
						if($array_['quantidade']!=$array_['quantidade_paga'])
						{
							$retira=$array_['quantidade']-$array_['quantidade_paga'];
							if($quantidade>=$retira)
							{								
								if($cClass->alterar('quantidade_paga',$array_['quantidade'],'pedido_has_item_cardapio','id',$array_['id']))
									$quantidade=$quantidade-$retira;
							}
							else
							{
								if ($quantidade>0) 
								{
									if ($cClass->alterar('quantidade_paga','quantidade_paga+'.$quantidade,'pedido_has_item_cardapio','id',$array_['id']))
										$quantidade=$quantidade-$quantidade;	
								}
							}
						}
					}
					echo 'OK paga-item';
					break;
				case 'carregaItensNovo':
					$cClass->listarItensPedidoCaixaNovo($_GET['idpedido']);
					if(0<>mysqli_num_rows($cClass->getconsulta()))
					{
						echo '<thead>                   
                                <th><input type="checkbox" id="checkall" onchange="percorreTabela()"/></th>
                                <th><small>Quant.</small></th>
                                <th><small>Quant. a ser paga</small></th>
                                <th>Item</th>
                                <th>Mesa</th>
                                <th>Pedido</th>
                                <th>Valor Unitário</th>
                              </thead>
                              <tbody>';  
                        while($array_=mysqli_fetch_array($cClass->getconsulta()))
						{
							$quantidade_a_pagar=$array_["quantidade"]-$array_["quantidade_paga"];
							$disabled='';
							if($quantidade_a_pagar=='0')
								$disabled='disabled';
							echo '<tr id="tr-'.$array_["id"].'" value="teste">
                                    <td><div class="col-md-1"><input type="checkbox" class="checkthis" '.$disabled.' onchange="percorreTabela()"/></div></td>
                                    <td><div class="col-md-2">'.$array_["quantidade"].'</div></td>
                                    <td class="col-quantidade">
                                      <div class="input-group" style="max-width:130px">
                                         <span class="input-group-btn">
                                                <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant['.$array_["id"].']" '.$disabled.'>
                                                  <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="quant['.$array_["id"].']" class="form-control input-number" value="'.$quantidade_a_pagar.'" min="1" max="'.$quantidade_a_pagar.'" '.$disabled.' onchange="percorreTabela()">
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant['.$array_["id"].']" '.$disabled.'>
                                                <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                            </span>
                                          </div>
                                        </td>
                                        <td>'.$array_["descricao"].'</td>
                                        <td>'.$array_["mesa"].'</td>
                                        <td>'.$array_["nome"].'</td>
                                        <td class="col-valor">R$ '.$array_["valor"].'</td>
                                      </tr>';
						}
                    	echo '</tbody>';
					}
					else
					{
						echo '<center>Não há itens neste pedido!';
					}
					break;
				case 'teste':
					$cClass->verificaValidadeLicenca();
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
</html>