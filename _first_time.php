<script type='text/javascript' src='js/jquery-2.1.1.min.js'></script>
<link rel="stylesheet" href="css/bootstrap.css"><!--REFERENCIA Á PÁGINA CONTENDO O ESTILO CSS -->
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/waitingfor.js" type="text/javascript"></script>
<script src="js/envia_dados.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="images/favicon.ico">
<head>
	<title>FoodControl</title>
    <style type="text/css">
    	body{
        background-color: #690202;
      }

      p.credit {
        margin-top: -3%;
      }

      @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);

	body {padding-top:50px;}

	.box {
    border-radius: 3px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    padding: 10px 25px;
    text-align: right;
    display: block;
    margin-top: 60px;
    background-color:#fff;
    margin-bottom: 60px;
	}
	.box-icon {
    background-color: #57a544;
    border-radius: 50%;
    display: table;
    height: 100px;
    margin: 0 auto;
    width: 100px;
    margin-top: -61px;
	}
	.box-icon span {
    color: #fff;
    display: table-cell;
    text-align: center;
    vertical-align: middle;
	}
	.info h4 {
    font-size: 26px;
    letter-spacing: 2px;
    text-transform: uppercase;
	}
	.info > p {
    color: #717171;
    font-size: 16px;
    padding-top: 10px;
    text-align: justify;
	}
	.info > a {
    background-color: #03a9f4;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
	}
	.info > a:hover {
    background-color: #0288d1;
    box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.16), 0 2px 5px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
	}

	.text-center{
	margin-left: auto;
    margin-right: auto;
    width: 60%;
	}
    </style>

    <script type="text/javascript">
    	function novaLicenca(idUsuario,codigo)
    	{
    		var queryString="idUsuario="+idUsuario+"&codigo="+codigo;
    		buscaDados('statusNovaLicenca',queryString,'get/getLicenca.php?action=novo','Não foi possível criar uma nova licença','true');
    	}

    	function novoUsuario(login)
	    {
        	var nivel='4';
            var reseta_senha='1';
          	var queryString = "login="+login+"&reseta_senha="+reseta_senha+"&nivel="+nivel;
          	buscaDados("statusCadastro",queryString,"get/getUsuario.php?action=novo","Não foi possível criar o usuário",'true');
        }

    </script>
</head>
<body>
<?php
date_default_timezone_set('America/Sao_Paulo');
include_once('classes/crudClass.php');
?>
<div class="container">
	<center>
        <img class="img img-responsive" style="max-width:500px;margin-top:20px" src="images/logo-foodcontrol.png">
            <span class="label label-danger pull-right" style="margin-right:300px"><?php echo 'Versão '.$GLOBALS['versao'];?></span>
        </img>
        
    </center>
    <?php
    if(isset($_GET['firstrun']))
    {
    	switch ($_GET['firstrun']) 
    	{
    		case '1':
    			?>
    			<div class="row">
        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:80px">
            			<div class="box">
                    		<img class="img img-responsive box-icon" src="images/ajustes.png"></img>
                    		<form action="?firstrun=2" method="POST">
                			<div class="info">
                    			<h4 class="text-center">Passo 1 - Banco de Dados</h4>
                    			<p class="text-center">Vamos definir algumas coisas necessárias para a conexão com o Banco de Dados:</p>
                    			<div class="input-group" style="margin-top:10px">
  									<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span>Servidor</span>
  									<input name="server" type="text" class="form-control" placeholder="ex: localhost" aria-describedby="basic-addon1" value="localhost">
								</div>
								<div class="input-group" style="margin-top:10px">
  									<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Usuário</span>
  									<input name="user" type="text" class="form-control" placeholder="ex: root" aria-describedby="basic-addon1" value="root">
								</div>
								<div class="input-group" style="margin-top:10px">
  									<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span>Banco de Dados</span>
  									<input name="database" type="text" class="form-control" placeholder="ex: foodcontrol" aria-describedby="basic-addon1" value="foodcontrol">
								</div><br>
                    			<button class="btn btn-primary" type="submit">Próximo</button>
                			</div>
                		</form>
            			</div>
        			</div>
    			</div>
    			<?php
    		break;
    		case '2':
    			?>
    			<div class="row">
        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:80px">
            			<div class="box">
                    		<img class="img img-responsive box-icon" src="images/ajustes.png"></img>
                    			<form action="?firstrun=3" method="POST">
                					<div class="info">
                    					<h4 class="text-center">Passo 2 - Licença</h4>
                    					
                <?php
                
    			if(isset($_POST['server']))
    			{
    				include_once('classes/Ini.class.php');
    				$config = new IniParser( 'config.ini' );
					//setar algum valor
    				$config->setValue('server', $_POST['server']);
    				$config->setValue('usuario', $_POST['user']);
    				$config->setValue('banco', $_POST['database']);
    				$config->saveFile();
                    if(date_default_timezone_get()!='America/Sao_Paulo')
                        echo '<center><h5 style="color:#CB0000"> *Antes de criar a licença ajuste a região do servidor para "America/Sao_Paulo" no php.ini</h5><br>Quando terminar atualize a página para continuar...</center>';
                    else
                    {
        				include_once "classes/crudClass.php";
    					$cClass=new crudClass();
                        include_once 'classes/mac.php';
                        $pegamac = new Mac;
                        $mac=$pegamac->MacId();
    					if($cClass->verificaLicenca($mac))
    					{
                            echo '<br><br><center><h3 class="tetx-center" style="color:#6EE421">Licença instalada com sucesso!!</h3></center>';
                            echo '<br><button class="btn btn-primary" type="submit">Próximo</button>';
    					}
    					else
    					{
    						
                            ?>
                            <center>
                                <p>Vamos criar uma licença para o uso do sistema!</p>
                                <div id="statusNovaLicenca"></div>
                                <button class="btn btn-success" type="button" onclick="novaLicenca('','')">Criar licença</button>
                            </center>
                            <?php
    					}
                    }
    			}
                else
                {
                    include_once('classes/Ini.class.php');
                    $config = new IniParser( 'config.ini' );
                    if(($config->getValue('server')!='')and($config->getValue('usuario')!='')and($config->getValue('banco')!=''))
                    {
                        include_once "classes/crudClass.php";
                        $cClass=new crudClass();
                        $cClass->listar('licenca','id');
                        if(0==mysqli_num_rows($cClass->getconsulta()))
                        {
                            $idUsuario=$GLOBALS['id_cliente'];
                            include_once 'classes/mac.php';
                            $pegamac = new Mac;
                            $mac=$pegamac->MacId();
                            $codigo=$mac.$idUsuario.(time()+86400);
                            //echo time().'    '.$codigo;
                            $codigo=base64_encode($codigo);
                            ?>
                            <center>
                                <p>Vamos criar uma licença para o uso do sistema!</p>
                                <div id="statusNovaLicenca"></div>
                                <button class="btn btn-success" type="button" onclick="novaLicenca('<?php echo $idUsuario;?>','<?php echo $codigo;?>')">Criar licença</button>
                            </center>
                            <?php
                        }
                        else
                        {
                            echo '<br><br><center><h3 class="tetx-center" style="color:#6EE421">Licença instalada com sucesso!!</h3></center>';
                            echo '<br><button class="btn btn-primary" type="submit">Próximo</button>';
                        } 
                    }
                    else
                    {
                        echo '<center><h5 style="color:#CB0000">*Algo não foi configurado corretamente volte para a tela anterior</h5></center>';
                    }

                }
    			?>
    								</div>
               					</form>
            			</div>
        			</div>
    			</div>
    			<?php
    		break;
    		case '3':
    			?>
    			<div class="row">
        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:80px">
            			<div class="box">
                             <?php
                        include_once "classes/crudClass.php";
                        $cClass=new crudClass();
                        $cClass->listar('usuario','id');
                        if(0==mysqli_num_rows($cClass->getconsulta()))
                        {
                            ?>
                    		<img class="img img-responsive box-icon" src="images/ajustes.png"></img>
                    		<form action="?firstrun=4" method="POST">
                			<div class="info">

                    			<h4 class="text-center">Passo 3 - Criar usuário</h4>
                    			<p class="text-center">Vamos criar um usuário com nível de administrador para ter acesso ao sistema:</p>
                    			<div class="input-group" style="margin-top:10px">
  									<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Login</span>
  									<input name="user" type="text" class="form-control" placeholder="ex: admin" aria-describedby="basic-addon1">
								</div>
								<br><button class="btn btn-primary" type="submit">Próximo</button>
                			</div>
                		</form>
                        <?php
                        }
                        else
                        { ?>
                            <br><br><center><h3 class="tetx-center" style="color:#6EE421">Já existem usuários cadastrados!!</h3></center>
                            <br><button onclick="location.href='?firstrun=5'" class="btn btn-primary" type="button">Próximo</button> 
                        <?php
                        }
                        ?>
            			</div>
        			</div>
    			</div>
    			<?php
    		break;
    		case '4':
    			?>
    			<div class="row">
        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:80px">
            			<div class="box">
                    		<img class="img img-responsive box-icon" src="images/ajustes.png"></img>
                    			<form action="?firstrun=3" method="POST">
                					<div class="info">
                    					<h4 class="text-center">Passo 4 - Finalização</h4>
                    <?php
                    	include_once "classes/crudClass.php";
						$cClass=new crudClass();
						$cClass->listar('usuario','id');
						if(0==mysqli_num_rows($cClass->getconsulta()))
						{
							?>
                			<center>
								<p>Clique no botão abaixo para criar o usuário:</p>
                    			<div id="statusCadastro"></div>
                    			<button class="btn btn-success" type="button" onclick="novoUsuario('<?php echo $_POST["user"];?>')">Criar usuário</button>
                    		</center>
                			<?php
                		}
                		else
                		{ ?>
                			<br><br><center><h3 class="tetx-center" style="color:#6EE421">Usuário cadastrado com sucesso!!</h3></center>
							<br><button onclick="location.href='?firstrun=5'" class="btn btn-primary" type="button">Próximo</button> <?php
                		}

    		break;
    		case '5':
    			?>
    				<div class="row">
        				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:80px">
            				<div class="box">
                				<div class="box-icon">
                    				<img class="img img-responsive" src="images/happy.png"></img>
                				</div>
                				<div class="info">
                					<center>
                    				<h4 class="text-center">TUDO PRONTO!</h4>
                    				<p>Você terminou de configurar o sistema FoodControl e pode começar a usá-lo!</p>
                    				<?php 
                    				include_once('classes/Ini.class.php');
    								$config = new IniParser( 'config.ini' );
									//setar algum valor
    								$config->setValue('type','metro');
    								$config->saveFile();
    								?>
                    				<button onclick="location.href='index.php'" class="btn btn-success">Ir para o Sistema</button>
                    				<center>
                				</div>
            				</div>
        				</div>
    				</div> 
    			<?php
    		break;
    		default:
    			?>
    			<script> 
            		setTimeout(function () { location.href="index.php"; });
          		</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
          		<?php
    			break;
    	}
    }
	else
	{
    ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:80px">
            <div class="box">
                <div class="box-icon">
                    <img class="img img-responsive" src="images/happy.png"></img>
                </div>
                <div class="info">
                    <h4 class="text-center">BEM VINDO!</h4>
                    <p>Parece que você está instalando o sistema pela primeira vez, vamos configurá-lo em alguns instantes e deixá-lo pronto para uso!</p>
                    <a href="?firstrun=1" class="btn">Começar</a>
                </div>
            </div>
        </div>
    </div>
    <?php
	} ?>

</div>


</body>