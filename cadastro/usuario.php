<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>  
<script src="../js/funcoes_gerais.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
  <title>FoodControl - Usuários</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">
    body{
        background-color: #690202;
    }

    p.credit {
  	font-size: 12px; 
  	margin-bottom: 20px; 
  	color: #ccc;
    width:100%;
    position: relative;
    left: 0;
    bottom: 0;
	}

  .input-group-addon.success {
    color: rgb(255, 255, 255);
    background-color: rgb(92, 184, 92);
    border-color: rgb(76, 174, 76);
  }

  .input-group-addon.danger {
    color: rgb(255, 255, 255);
    background-color: rgb(217, 83, 79);
    border-color: rgb(212, 63, 58);
  }
    </style>

    <script type="text/javascript">
    	function salvar()
	    {
	      var acao=document.getElementById('salvarButton').value;
	      var id=document.getElementById('id').value;
        var login=document.getElementById('login').value;
        var reseta_senha=$("#resetasenha").is(":checked");
        var nivel=document.getElementById('nivel').value;
        
        if((login.length>=3)&&(document.getElementById('login').className.indexOf('verified')!=-1))
        {
          if(acao=='novo')
            reseta_senha='1';
          var queryString = "id="+id+"&login="+login+"&reseta_senha="+reseta_senha+"&nivel="+nivel;
          //alert(queryString);
          buscaDados("statusCadastro",queryString,"../get/getUsuario.php?action="+acao,"Não foi possível salvar",'true');
        }
        else
        {
         alert("Informe um login válido!");
         return;
        }
	    }

	    function excluir()
	    {
	      var id_delete=document.getElementById('id_delete').value;
	      var queryString = "id="+id_delete;
	      buscaDados("statusExcluir",queryString,"../get/getUsuario.php?action=delete","Não foi possível excluir o usuário",'../');
	    }

      function verifica_login()
      {
        var login = $("#login").val();

        if(login.length >= 3)
        {
          $("#statusCadastro").html('Verificando disponibilidade...<p><img src="../images/large-facebook.gif"/>');

          $.ajax({ 
          type: "POST", 
          url: "../get/getUsuario.php?action=verifica_login", 
          data: "login="+ login, 
          success: function(msg)
          { 
              msg=msg.trim();
              if(msg == 'OK')
              { 
                $("#login").addClass("verified");
                $("#span-login").removeClass("danger");
                $("#span-login").addClass("success");
                $("#icon-login").attr('class','glyphicon glyphicon-ok');
                $("#statusCadastro").html('');
              } 
              else 
              {             
                $("#login").removeClass("verified");
                $("#span-login").removeClass("success");
                $("#span-login").addClass("danger");
                $("#icon-login").attr('class','glyphicon glyphicon-remove');
                $("#statusCadastro").html('');
              }
          }
          });
        } 
        else
        {
          $("#login").removeClass("verified");
          $("#span-login").removeClass("success");
          $("#span-login").addClass("danger");
          $("#icon-login").attr('class','glyphicon glyphicon-remove');
          $("#statusCadastro").html('<font color="Red">O login precisa ter no mínimo 3 caracteres</font>');
        }
        
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
		        if(action=='novo')
		        {
		          $('#salvarButton').val("novo");
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
		        var data_login = '';
		        if (typeof $(this).data('login') !== 'undefined') 
		        {
		          data_login = $(this).data('login');
		        }
		        $('#login_delete').val(data_login);
		        $('#login').val(data_login);
		        //************************************************
            var data_nivel = '';
            if (typeof $(this).data('nivel') !== 'undefined') 
            {
              data_nivel = $(this).data('nivel');
            }
            $('#nivel').val(data_nivel);
            //************************************************
            var data_resetasenha = '';
            if (typeof $(this).data('resetasenha') !== 'undefined') 
            {
              data_resetasenha = $(this).data('resetasenha');
            }
            if(data_resetasenha=='1')
              document.getElementById("resetasenha").checked=true;
            else
              document.getElementById("resetasenha").checked=false;
            //************************************************
      		});
    	});
    </script>
    <!-- style for table panel with filters -->
  	<link href="css/paneltablewithfilters.css" rel="stylesheet">
  	<script src="js/paneltablewithfilters.js" type="text/javascript"></script>  
</head>
<body>
<div class="container">
    <!-- MODAL EXCLUIR USUARIO -->
    <div class="row">
      <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-primary">
   
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-user"></span> Excluir Usuário:</h4>
                  </div>
                  <form id="deleteForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Prosseguir com a exclus&#227o deste Usuário?</h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="id_delete" id="id_delete" disabled/>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="login_delete" id="login_delete" disabled/>
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

    <!-- MODAL CADASTRO USUARIO -->
    <div class="row">
      <div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-primary">
   
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-user"></span> Cadastro de Usuário:</h4>
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
                            <span class="help-block">Usuário:</span>
                            <div class="input-group">
                              <input type="text" class="form-control verified" name="login" id="login" onchange="verifica_login()">
                              <span id="span-login" class="input-group-addon primary"><span id="icon-login" class="glyphicon glyphicon-user"></span></span>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            <span class="help-block">Senha:</span>
                            <input id="resetasenha" type="checkbox"> Resetar Senha
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                            <span class="help-block">Nível:</span>
                              <select id="nivel" name="nivel" class="form-control" required="required">
                                <option value="1">Nível 1</option>
                                <option value="2">Nível 2</option>
                                <option value="3">Nível 3</option>
                                <option value="4">Nível 4</option>
                              </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-10 col-md-10 col-sm-10" style="padding-bottom: 10px;">
                            <div class="list-group">
                              <li class="list-group-item">
                                <h5 class="list-group-item-heading"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Nível 1</h5>
                                <p class="list-group-item-text">*Garçom - Podem criar e editar pedidos</p>
                              </li>
                              <li class="list-group-item">
                                <h5 class="list-group-item-heading"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Nível 2</h5>
                                <p class="list-group-item-text">*Auxiliar e Cozinha - Podem visualizar pedidos e entregar itens</p>
                              </li>
                              <li class="list-group-item">
                                <h5 class="list-group-item-heading"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Nível 3</h5>
                                <p class="list-group-item-text">*Caixa - Pode fechar pedidos</p>
                              </li>
                              <li class="list-group-item">
                                <h5 class="list-group-item-heading"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Nível 4</h5>
                                <p class="list-group-item-text">Tem acesso total ao sistema</p>
                              </li>
                            </div>
                          </div>
                        </div>
                        <center><div id='statusCadastro'></div></center>
                      </div>  
                      <div class="modal-footer">
                        <div class="pull-right">
                          <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                          <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                          <button id="salvarButton" type="button" class="btn btn-success" onclick='salvar()' value="novo"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
                        </div>
                      </div>    
                  </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>
    
    <center>
        <h3 style="color:#ffffff; ">
          Cadastro de Usuário:
        </h3>          
      </center><hr>
      <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Cadastro de Usuários</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>

      <button class="btn btn-success" data-toggle="modal" data-target="#modalCadastro" data-action="novo"><span class="glyphicon glyphicon-plus"></span> Novo Usuário</button>
          <div class="row">          
            <div class="col-md-12">
              <div class="panel panel-primary filterable">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-md-1">
                        <h3 style="font-size: 110%"></h3>
                      </div>
                      <div class="col-md-4 col-md-offset-3">
                            <p class="credit" style="margin-bottom: -20px;">Clique em cima do usuário para mais opções... </p>      
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
                            include_once "../classes/crudClass.php";
                            $cClass = new crudClass();
                            $cClass->listar('usuario','login');
                            $count=0;
                            if(0==mysqli_num_rows($cClass->getConsulta()))
                            {
                              ?>
                              <li class="list-group-item">
                                <center><h4 style="color:#EB2626">Nenhum usuário para mostrar...</h4></center>
                              </li>
                              <?php
                            }
                            else
                            {
                              ?>
                              <table class="table table-hover table-condensed">
                                <thead>
                                  <tr class="filters">
                                      <th><input type="text" class="form-control" placeholder="Login" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Nivel" disabled></th>
                                  </tr>
                                </thead>
                              <?php
                              while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                              {
                                $count++;
                                ?>
                                    <tr>
                                      <td style="cursor:hand"
                                      data-toggle="modal" 
                                      data-target="#modalCadastro"
                                      data-id="<?php echo $array_['id'];?>"
                                      data-login="<?php echo $array_['login'];?>"
                                      data-nivel="<?php echo $array_['nivel'];?>"
                                      data-resetasenha="<?php echo $array_['reseta_senha'];?>"
                                      data-action="editar"
                                      >
                                        <small style="color:#080808;font-size: 110%"><?php echo $array_['login'];?></small>
                                      </td>
                                      <td>
                                        <small style="color:#080808;font-size: 110%"><?php echo $array_['nivel'];?></small>
                                      </td>
                                    <div class="pull-right action-buttons">
                                      <!-- clique do botão excluir -->
                                      <td><p><button class="btn btn-danger btn-sm" data-toggle="modal" 
                                        type="button" 
                                        data-target="#delete"
                                        data-id="<?php echo $array_['id'];?>"
                                        data-login="<?php echo $array_['login'];?>"
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
</div>
</body>