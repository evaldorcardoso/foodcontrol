<?php
	session_start();
	?>
<script type='text/javascript' src='js/jquery-2.1.1.min.js'></script>
<link rel="stylesheet" href="css/bootstrap.css"><!--REFERENCIA Á PÁGINA CONTENDO O ESTILO CSS -->
<script src="js/bootstrap.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="images/favicon.ico">
<head>
	<title>FoodControl - Login</title>
	<link rel="stylesheet" href="css/login-form.css">
	<script src="js/envia_dados.js" type="text/javascript"></script>  
  <script src="js/waitingfor.js" type="text/javascript"></script>  
    <style type="text/css">

    </style>

    <script type="text/javascript">

    	function entrar()
    	{
    		var login=document.getElementById('login_value').value;
    		var senha=document.getElementById('senha_value').value;
    		
    		if(login=='')
    			alert('Informe um login válido');
    		else
    		{
    			var queryString="login="+login+"&senha="+senha;
    			buscaDados("statusLogin",queryString,"get/getUsuario.php?action=login","Verifique seu login e senha","true");
    		}
    	}

    	function reseta_senha()
    	{
    		var id=document.getElementById('id_reseta').value;
    		var senha=document.getElementById('senha_reseta').value;
    		if(senha=='')
    			alert('Informe uma senha válida');
    		else
    		{
    			var queryString="id="+id+"&senha="+senha+"&reseta_senha=0";
    			buscaDados("statusReseta",queryString,"get/getUsuario.php?action=reseta","Não foi possível salvar a nova senha","true");
    		}
    	}

    	$(document).ready(function() 
	    {
    		$('#login_form').submit(function () {
 				entrar();
 				return false;
			});
		});

		$(document).ready(function() 
	    {
    		$('#resetasenha_form').submit(function () {
 				reseta_senha();
 				return false;
			});
		});
    </script>
</head>
<body>

	<!-- MODAL reseta Senha  -->
    <div class="row">
    	<div class="modal fade" id="modalResetaSenha" tabindex="3" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          	<div class="modal-dialog">
              	<div class="panel panel-primary">
                  	<div class="panel-heading">
                   		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          	<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-user"></span> Cadastre uma senha:</h4>
                  	</div>
                  	<form id="resetasenha_form" accept-charset="utf-8">
                      	<div class="modal-body" style="padding: 5px;">
                            <h4>Você precisa redefinir sua senha</h4>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                	<span class="help-block">Código:</span>
                                    <input type="text" class="form-control" name="id_reseta" id="id_reseta" disabled/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                	<span class="help-block">Nova Senha:</span>
                                    <input type="password" class="form-control" name="senha_reseta" id="senha_reseta"/>
                                </div>
                            </div>
                        	<br><br>
                        	<center><div id='statusReseta'></div></center>
                        </div>  
                        <div class="modal-footer">
                            <div class="pull-right">
                              <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                              <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button  type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
                            </div>
                        </div>
                    </form>
              	</div><!-- /.panel -->
          	</div><!-- /.modal-dalog -->
      	</div><!-- /.modal -->
    </div>

<?php
if(isset($_SESSION['login']))
{
  include_once('classes/crudClass.php');
  $cClass=new crudClass();
  $campos = array('login' => $_SESSION['login']);       
  $cClass->pesquisaTabela('usuario',$campos);
  if(mysqli_num_rows($cClass->getconsulta())==0)
  {
    session_unset(); // Eliminar todas as variáveis da sessão
    session_destroy(); // Destruir a sessão
    ?>
    <script>
          setTimeout(function () { // wait 3 seconds and reload
              location.reload();
          });    
    </script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
<?php 
  }
  else
  {
  ?>
  <script>
          setTimeout(function () { // wait 3 seconds and reload
              location.href="index.php";
          });    
  </script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
<?php 
  }
}
else
{?>
  <div class="login-body">
    <article class="container-login center-block">
		<section>
			<ul id="top-bar" class="nav nav-tabs nav-justified">
				<!--<li class="active"><a href="#login-access">Accesso</a></li>-->
				<!--<li><a href="#">Password dimenticata</a></li>-->
				<img style="max-width:500px;margin-bottom:20px;margin-left:-20px" src="images/logo-foodcontrol.png"/>
			</ul>
      <?php
if(($_SERVER['HTTP_HOST']!='localhost')&&($_SERVER['HTTP_HOST']!='evaldorc.com.br'))
{
  echo '<center><h3 style="color:#fff">Você não tem permissão para usar o sistema!</h3>
                <h4 style="color:#fff">Consulte o fornecedor do sistema para obter mais informações</h4></center>';
  print_r($_SERVER);
  echo $_SERVER['HTTP_X_FORWARDED_FOR'] ;
}
else
{
  
?>
			<div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12">
				<div id="login-access" class="tab-pane fade active in">
					<h2><i class="glyphicon glyphicon-log-in"></i> Accesso</h2>						
					<form id="login_form" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal">
						<div class="form-group ">
							<label for="login" class="sr-only">Login</label>
                  <input type="text" class="form-control" name="login_value" id="login_value" placeholder="Login" tabindex="1" value=""/>
						</div>
						<div class="form-group ">
							<label for="password" class="sr-only">Senha</label>
								<input type="password" class="form-control" name="senha_value" id="senha_value"
									placeholder="Senha" value="" tabindex="2" />

						</div>
						<br/>
						<div class="form-group ">				
							<button type="submit" name="log-me-in" id="submit" tabindex="5" class="btn btn-lg btn-primary">Entrar</button>
						</div>
						<center><div id="statusLogin"></div></center>
					</form>			
				</div>
			</div>
      <?php 
    }
    ?>
		</section>
	</article>
</div>
<?php
}
?>
<center><br><br><br>
  <p class="container-login center-block credit" style="color:#fff;margin-top:100px">Copyright © 2015 - Todos os direitos reservados</p>
</center>
</body>