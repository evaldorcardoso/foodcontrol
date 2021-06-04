<script type='text/javascript' src='js/jquery-2.1.1.min.js'></script>
<link rel="stylesheet" href="css/bootstrap.css"><!--REFERENCIA Á PÁGINA CONTENDO O ESTILO CSS -->
<script src="js/bootstrap.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="images/favicon.ico">
<head>
	<title>FoodControl - Licença</title>
	<link rel="stylesheet" href="pricingtables.css">
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
    		buscaDados('statusNovaLicenca',queryString,'get/getLicenca.php?action=novo','Não foi possível inserir a licença','');
    	}

    	function renovaLicenca()
    	{
    		var id=document.getElementById("btnRenovar").value;
    		var codigo=document.getElementById("inputLicenca").value;
    		var queryString="id="+id+"&codigo="+codigo;
    		//alert("enviando: "+queryString);
    		buscaDados("statusLicenca",queryString,'get/getLicenca.php?action=renovar','Não foi possível validar a licença informada','true');
    	}
    </script>
</head>
<body>
<?php
include_once "classes/crudClass.php";
$cClass=new crudClass();
?>
<div class="container">
	<center><img style="max-width:500px;margin-bottom:20px" src="images/logo-foodcontrol.png"/>
		<div class="row">
				<div class="col-md-4 col-md-offset-4">
						<?php
						$cClass->listar('licenca','id');
						if(0==mysqli_num_rows($cClass->getconsulta()))
						{
							$idUsuario=$GLOBALS['id_cliente'];
							$codigo=base64_encode($idUsuario.time());
							?>
							<div id="statusNovaLicenca"></div>
							<script>novaLicenca('<?php echo $idUsuario;?>','<?php echo $codigo;?>');</script>
							<?php
						}
						else
						{ 
							while($array_=mysqli_fetch_array($cClass->getconsulta()))
							{ 
								$codigo=base64_decode($array_['codigo']);
								$idUsuario=substr($codigo, 0,6	);
								//$data=date("d/m/Y",substr($codigo, 6));
								//$data_now=date("d/m/Y",time());
								$data=substr($codigo, 6);
								$data_now=time();
								//echo $data.' '.$data_now;
								?>
								<!-- PRICE ITEM -->
								<?php 
								if(strtotime(date("d-m-Y",$data))<=strtotime(date("d-m-Y",$data_now))){
										echo '<div class="panel price panel-red">
												<div class="panel-heading arrow_box text-center">
													<h3>Sua licença expirou!</h3>
													<p>Para continuar a usar o sistema você precisa renovar sua licença</p>
												</div>';
									}
									else
									echo '<div class="panel price panel-blue">
											<div class="panel-heading arrow_box text-center">
												<h3>LICENÇA</h3>
											</div>';
								?>
									
									<div class="panel-body text-center">
										<p>Validade da sua licença:</p>
										<p class="lead" style="font-size:40px"><strong><?php echo date("d/m/Y",substr($codigo, 6));;?></strong></p>
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
						}?>
					</div>
		</div>
	<a class="btn btn-lg btn-warning" href="index.php"><span class="glyphicon glyphicon-home"></span>  Retornar ao Sistema</a>
	</center>
</div>
</body>