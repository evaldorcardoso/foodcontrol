<script type='text/javascript' src='js/jquery-2.1.1.min.js'></script>
<link rel="stylesheet" href="css/bootstrap.css"><!--REFERENCIA Á PÁGINA CONTENDO O ESTILO CSS -->
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/funcoes_gerais.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="images/favicon.ico">
<!-- style for table panel with filters -->
<link href="caixa/paneltablewithfilters.css" rel="stylesheet">
<script src="caixa/paneltablewithfilters.js" type="text/javascript"></script>  
<head>
	<title>FoodControl - Licença</title>
	<link rel="stylesheet" href="css/pricingtables.css">
    <style type="text/css">
    	body{
    		background: -webkit-linear-gradient(90deg, #04496E 10%, #007152 90%);
    		background: -moz-linear-gradient(90deg, #04496E 10%, #007152 90%);
    		background: -ms-linear-gradient(90deg, #04496E 10%, #007152 90%);
    		background: -o-linear-gradient(90deg, #04496E 10%, #007152 90%);
    		background: linear-gradient(90deg, #04496E 10%, #007152 90%);
    	}
    </style>
    <script src="js/waitingfor.js" type="text/javascript"></script>
    <script src="js/envia_dados.js" type="text/javascript"></script>
    <script type="text/javascript">
    	function novaLicenca(idUsuario,codigo)
    	{
    		var queryString="idUsuario="+idUsuario+"&codigo="+codigo;
    		buscaDados('statusNovaLicenca',queryString,'get/getLicenca.php?action=novo','Não foi possível inserir a licença','true');
    	}

    	function renovaLicenca()
    	{
    		var id=document.getElementById("btnRenovar").value;
    		var codigo=document.getElementById("inputLicenca").value;
    		var queryString="id="+id+"&codigo="+codigo;
    		//alert("enviando: "+queryString);
    		buscaDados("statusLicenca",queryString,'get/getLicenca.php?action=renovar','Não foi possível validar a licença informada','true');
    	}

    	$(document).ready(function() 
	    {
	      //vai ler apenas os cliques com atributo data-toggle=modal
	      $('[data-toggle=modal]').click(function ()
	      {
	        var action='';
	        if (typeof $(this).data('action') !== 'undefined') 
	        {
	          action = $(this).data('action');
	        }
	        if(action=='novo_cadastro')
	        {
	          $('#salvarButton').val("novo_cadastro");
	        }
	        if(action=='editar')
	        {
	          $('#salvarButton').val("editar");
	        }
	        
	        //************************************************
	        var data_id = '';
	        if (typeof $(this).data('id') !== 'undefined') 
	        {
	          data_id = $(this).data('id');
	        }
	        $('#id_delete').val(data_id);
	        $('#id').val(data_id);
	        //************************************************
	        var data_dispositivo = '';
	        if (typeof $(this).data('dispositivo') !== 'undefined') 
	        {
	          data_dispositivo = $(this).data('dispositivo');
	        }
	        $('#dispositivo_delete').val(data_dispositivo);
	        $('#dispositivo').val(data_dispositivo);
	        //************************************************
	        var data_codigo = '';
	        if (typeof $(this).data('codigo') !== 'undefined') 
	        {
	          data_codigo = $(this).data('codigo');
	        }

	        $('#codigo').val(data_codigo);
	        //************************************************
	        var data_serie = '';
	        if (typeof $(this).data('serie') !== 'undefined') 
	        {
	          data_serie = $(this).data('serie');
	        }
	        $('#serie').val(data_serie);
	      });
      	});

		function salvar()
	    {
	        var acao=document.getElementById('salvarButton').value;
	        var id=document.getElementById('id').value;
	        var dispositivo=document.getElementById('dispositivo').value;
	        var codigo=document.getElementById('codigo').value;
	        var serie=document.getElementById('serie').value;
	        
	        var queryString = "id="+id+"&dispositivo="+dispositivo+"&codigo="+codigo+"&serie="+serie;

	        var campos=['codigo','dispositivo','serie'];

	        if(validaCampos(campos))
	         buscaDados("statusCadastro",queryString,"get/getLicenca.php?action="+acao,"Não foi possível cadastrar",'true');
	    }

      function excluir()
      {
        var id_delete=document.getElementById('id_delete').value;
        var queryString = "id="+id_delete;
        buscaDados("statusExcluir",queryString,"get/getLicenca.php?action=delete","Não foi possível excluir o dispositivo",'true');
      }

    </script>
</head>
<body>
<?php
include_once "classes/crudClass.php";
$cClass=new crudClass();
?>

	<!-- MODAL EXCLUIR ITEM -->
    <div class="row">
      <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
   
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-list-alt"></span> Excluir Item do Cardápio:</h4>
                  </div>
                  <form id="deleteForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Prosseguir com a exclus&#227o deste Item?</h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="id_delete" id="id_delete" disabled/>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="dispositivo_delete" id="descricao_delete" disabled/>
                                  </div>
                              </div>
                              <br><br>
                              <center><div id='statusExcluir'></div></center>
                          </div>  
                          <div class="modal-footer">
                            <div class="pull-right">
                              <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                              <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button  type="button" class="btn btn-danger" onclick='excluir()' ><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                            </div>
                          </div>
                        </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>

    <!-- MODAL CADASTRO ITEM -->
    <div class="row">
      <div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
   
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-list-alt"></span> Cadastro de Licenças:</h4>
                  </div>
                  <form id="cadastroForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4></h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <span class="help-block">Codigo:</span>
                                      <input type="text" class="form-control" name="id" id="id" disabled/>
                                  </div>
                                  <div class="col-lg-8 col-md-8 col-sm-8" style="padding-bottom: 10px;">
                                      <span class="help-block">Descricao:</span>
                                      <input type="text" class="form-control" name="descricao" id="dispositivo"/>
                                  </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10" style="padding-bottom: 10px;">
                                  <span class="help-block">Licença</span>
                                  <input id="codigo" type="text" class="form-control"> 
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10" style="padding-bottom: 10px;">
                                  <span class="help-block">Identificação do Dispositivo:</span>
                                  <input id="serie" type="text" class="form-control"> 
                                </div>
                              </div>
                              <center><div id='statusCadastro'></div></center>
                          </div>  
                          <div class="modal-footer">
                            <div class="pull-right">
                              <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                              <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button id="salvarButton" type="button" class="btn btn-success" onclick='salvar()' value="novo_cadastro"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
                            </div>
                          </div>
                        </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>

<div class="container">
	<center><img style="max-width:500px;margin-bottom:20px" src="images/logo-foodcontrol.png"/>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
						<?php
						include_once 'classes/mac.php';
                        $pegamac = new Mac;
                        $pcmac=$pegamac->MacId();
    					if($cClass->verificaLicenca($pcmac))
    					{
                            $cClass->listar('licenca','id');
                            while($array_=mysqli_fetch_array($cClass->getconsulta()))
							{ 
								$codigo=base64_decode($array_['codigo']);
								$p_barra1=strpos($codigo, '/');//posicao da barra 1
								$p_barra2=strripos($codigo, '/');//posicao da barra 2
								$idUsuario=substr($codigo, 0,$p_barra1);
								$data=substr($codigo, $p_barra2+1);//pega o valor depois do ultimo '/' encontrado
								$data_now=time();
								$mac=substr($codigo, $p_barra1+1,($p_barra2-$p_barra1)-1);
								if(strcmp($mac, $pcmac)==0)
								{
									?>
									<!-- PRICE ITEM -->
									<?php 
									if(strtotime(date("d-m-Y",$data))<strtotime(date("d-m-Y",$data_now))){
											echo '<div class="panel price panel-red">
													<div class="panel-heading arrow_box text-center">
														<h3>Sua licença expirou!</h3>
														<p>Para continuar a usar o sistema você precisa renovar sua licença</p>
														<p>'.$pcmac.'</p>
													</div>';
										}
										else
										echo '<div class="panel price panel-blue">
												<div class="panel-heading arrow_box text-center">
													<h3>LICENÇA</h3>
												</div>';
									?>
										
										<div class="panel-body text-center">
											<p><?php echo 'Identificação desta máquina: '.$pcmac; ?></p><br>
											<p>Validade da sua licença nesta máquina:</p>
											<p class="lead" style="font-size:40px"><strong><?php echo date("d/m/Y",$data);?></strong></p>
										</div>
										<ul class="list-group list-group-flush text-center">
											<!--<li class="list-group-item"><i class="icon-ok text-info"></i> </li>
											<li class="list-group-item"><i class="icon-ok text-info"></i> </li>-->
										</ul>
										<div class="panel-footer">
											<p style="color:#000">Informe sua licença abaixo:
											<input id="inputLicenca" type="text" class="form-control"/><br>
											<div id="statusLicenca"></div>
											<button id="btnRenovar" class="btn btn-lg btn-block btn-primary" onclick="renovaLicenca()" value="<?php echo $array_['id'];?>">Validar Licença</button>
										</div>
									</div>
									<!-- /PRICE ITEM -->
									<?php
									break;
								}
							} 
    					}
    					else
    					{
    						echo 'Seu computador não corresponde a nenhuma licença instalada!';
							?>
							<div id="statusNovaLicenca"></div>
							<button id="btnNovaLicenca" class="btn btn-lg btn-block btn-success" onclick="novaLicenca('','')">Instalar nova licença</button>
							<?php
    					}
    					?>
			</div>
		</div>
	<hr><br>
	<h3 style="color:#ffffff; ">
          Gerenciamento de Licenças:
    </h3></center>
	<button class="btn btn-success" data-toggle="modal" data-target="#modalCadastro" data-action="novo"><span class="glyphicon glyphicon-plus"></span> Novo Dispositivo</button>
      	<div class="row">          
            <div class="col-md-12">
              <div class="panel panel-primary filterable">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-md-1">
                        <h3 style="font-size: 110%"></h3>
                      </div>
                      <div class="col-md-4 col-md-offset-3">
                            <p class="credit" style="margin-bottom: -20px;">Clique em cima do item para mais opções... </p>      
                          </div>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                    </div>
                  </div>
                  <div class="panel-body">
                      <ul class="list-group">
                        <div class=" table table-hover table-responsive">
                          <?php 
                            
                            $cClass->listar('licenca','dispositivo');
                            $count=0;
                            if(0==mysqli_num_rows($cClass->getConsulta()))
                            {
                              ?>
                              <li class="list-group-item">
                                <center><h4 style="color:#EB2626">Nenhum Item para mostrar...</h4></center>
                              </li>
                              <?php
                            }
                            else
                            {
                              ?>
                              <table class="table table-hover table-condensed">
                                <thead>
                                  <tr class="filters">
                                      <th><input type="text" class="form-control" placeholder="Descrição" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Licença" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Identificação" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Validade" disabled></th>
                                  </tr>
                                </thead>
                              <?php
                              while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                              {
                                $count++;
                                ?>
                                    <tr <?php echo 'class="success";'?>>
                                      <td style="cursor:hand"
                                      data-toggle="modal" 
                                      data-target="#modalCadastro"
                                      data-id="<?php echo $array_['id'];?>"
                                      data-dispositivo="<?php echo $array_['dispositivo'];?>"
                                      data-codigo="<?php echo $array_['codigo'];?>"
                                      data-serie="<?php echo $array_['serie'];?>"
                                      data-action="editar"
                                      >
                                        <small style="color:#080808;font-size: 110%"><?php echo $array_['dispositivo'];?></small>
                                      </td>
                                       <td>
                                        <small style="color:#EB2626;font-size: 100%"><?php echo $array_['codigo'];?></small>
                                      </td>

                                      <td>
                                        <small style="color:#080808;font-size: 110%">
                                          <?php echo $array_['serie'];?>
                                        </small>
                                      </td>
                                      <td>
                                        <small style="color:#080808;font-size: 110%">
                                          <?php 
                                          	$codigo=base64_decode($array_['codigo']);
											$p_barra1=strpos($codigo, '/');//posicao da barra 1
											$p_barra2=strripos($codigo, '/');//posicao da barra 2
											$idUsuario=substr($codigo, 0,$p_barra1);
											$data=substr($codigo, $p_barra2+1);//pega o valor depois do ultimo '/' encontrado
											echo date("d/m/Y",$data);
                                          ?>
                                        </small>
                                      </td>
                                    <div class="pull-right action-buttons">
                                      <!-- clique do botão excluir -->
                                      <td><p><button class="btn btn-danger btn-sm" data-toggle="modal" 
                                        type="button" 
                                        data-target="#delete"
                                        data-id="<?php echo $array_['id'];?>"
                                        data-descricao="<?php echo $array_['dispositivo'];?>"
                                        data-action="excluir" rel="tooltip">
                                        <span class="glyphicon glyphicon-trash"></span></button></p>
                                      </td>
                                    </div>                                  
                                </tr>
                                <?php
                              }//end while
                            }  
                        ?>
                        </table>
                      </div>
                      </ul>
                  </div>
                  <div class="panel-footer">
                      <div class="row">
                          <div class="col-md-2">
                              <h4>
                                  Total: <span class="label label-info"><?php echo $count;?></span>
                              </h4>
                          </div>
                      </div>
                      
                  </div>
              </div>
            </div>
        </div>
<center><a class="btn btn-lg btn-warning" href="index.php"><span class="glyphicon glyphicon-home"></span>  Retornar ao Sistema</a></center>
</div>
</body>