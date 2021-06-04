<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>  
<script src="../js/waitingfor.js" type="text/javascript"></script>  
<script src="../js/funcoes_gerais.js" type="text/javascript"></script>  
<script src="../js/funcoes_valores.js" type="text/javascript"></script>  
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
  <title>FoodControl - Dívidas</title>
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
    </style>
    
    <script type="text/javascript">
    	function salvar()
	    {
	      var acao=document.getElementById('salvarButton').value;
	      var id=document.getElementById('id').value;
	      var credor_id=document.getElementById('id_credor').value;
        var descricao=document.getElementById('descricao').value;
        var data_vencimento=document.getElementById('data_vencimento').value;
        var data_pagamento=document.getElementById('data_pagamento').value;
        var situacao=document.getElementById("situacao").value;
        var valor=document.getElementById('valor').value;
        var queryString = "id="+id+"&credor_id="+credor_id+"&descricao="+descricao+"&data_vencimento="+data_vencimento;
        queryString+="&data_pagamento="+data_pagamento+"&situacao="+situacao+"&valor="+valor;
        var campos=['data_vencimento','id_credor','valor','situacao','descricao'];
        //alert(queryString);
        if(validaCampos(campos))
	         buscaDados("statusCadastroDivida",queryString,"../get/getDivida.php?action="+acao,"Não foi possível cadastrar",'../');
	    }

	    function excluir()
	    {
	      var id_delete=document.getElementById('id_delete').value;
	      var queryString = "id="+id_delete;
	      buscaDados("statusExcluir",queryString,"../get/getDivida.php?action=delete","Não foi possível excluir a dívida",'true');
	    }

      function salvarCredor()
      {
        var acao='novo';
        var id=document.getElementById('credor_id').value;
        var nome=document.getElementById('credor_nome').value;
        var telefone=document.getElementById('credor_telefone').value;
        var celular=document.getElementById('credor_celular').value;
        var queryString = "id="+id+"&nome="+nome+"&telefone="+telefone;
        queryString+="&celular="+celular;
        var campos=['credor_nome','credor_telefone'];
        if(validaCampos(campos))
         buscaDados("statusCadastroCredor",queryString,"../get/getCredor.php?action="+acao,"Não foi possível cadastrar",'../');
      }

      function alteraSituacao()
      {
        if(document.getElementById('situacao').value=="1")
          document.getElementById("data_pagamento").disabled=false;
        else
          document.getElementById("data_pagamento").disabled=true;
      }

      function listaCredores()
      {
        buscaDadosBanco("statusCredores","","../get/getCredor.php?action=listar","Erro","getListaCredor","tab-credores","../");            
      }

	    $(document).ready(function() 
	    {


        //vai ler apenas os cliques com atributo data-toggle=modal
        $('[data-toggle=modal]').click(function ()
        {
          var data_target = '';
          if (typeof $(this).data('target') !== 'undefined') 
          {
            data_target = $(this).data('target');
          }
          if(data_target=='#lista_credores')
          {
            listaCredores();
          }

          var action='';
          if (typeof $(this).data('action') !== 'undefined') 
          {
            action = $(this).data('action');
          }
          if(action=="excluir")
          {
            //************************************************

            var data_id = '';
            if (typeof $(this).data('id') !== 'undefined') 
            {
              data_id = $(this).data('id');
            }
            $('#id_delete').val(data_id);
            //************************************************
            var data_nome = '';
            if (typeof $(this).data('nome') !== 'undefined') 
            {
              data_nome = $(this).data('nome');
            }
            $('#credor_nome_delete').val(data_nome);
            //************************************************
            var data_descricao = '';
            if (typeof $(this).data('descricao') !== 'undefined') 
            {
              data_descricao = $(this).data('descricao');
            }
            $('#descricao_delete').val(data_descricao);
          }
        });


        
    	});

    </script>
    <!-- style for table panel with filters -->
  	<link href="css/paneltablewithfilters.css" rel="stylesheet">
  	<script src="js/paneltablewithfilters.js" type="text/javascript"></script>  
</head>
<body>
<div class="container">
       <!-- MODAL EXCLUIR DIVIDA -->
    <div class="row">
      <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
   
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-user"></span> Excluir Dívida:</h4>
                  </div>
                  <form id="deleteForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Prosseguir com a exclus&#227o desta dívida?</h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="id_delete" id="id_delete" disabled/>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="descricao_delete" id="descricao_delete" disabled/>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="credor_nome_delete" id="credor_nome_delete" disabled/>
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

    <!-- MODAL LISTAR CREDORES -->
    <div class="row">
      <div class="modal fade" id="lista_credores" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="panel panel-default">
              <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <div class="row">
                  <center>
                    <h4>Selecione um credor:</h4>
                  </center>
                </div>
              </div>
            <center><div id="statusCredores"></div></center>
            <div class="row">          
            <div class="col-md-12">
              <form id="credorForm" accept-charset="utf-8">
                <div class="modal-body" style="padding: 5px;">
                  <div class="panel panel-primary filterable">
                      <div class="panel-heading">
                        <center>
                          <h4 style="font-size: 110%"></h4>
                        </center>
                        <div class="pull-right">
                            <button type="button" class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                        </div>
                      </div>
                      <div class="panel-body">
                          <ul class="list-group">
                            <div class=" table table-hover table-responsive">
                              <table id="tab-credores" class="table table-hover table-condensed">
                                <?php
                                  include_once '../classes/crudClass.php';
                                  $cClass = new crudClass();  
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
                    } ?>
                              </table>
                          </div>
                          </ul>
                      </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
          </div>
      </div>
    </div>

    <!-- MODAL CADASTRO CREDOR -->
    <div class="row">
      <div class="modal fade" id="novo_credor" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
   
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-user"></span> Cadastro de Credor:</h4>
                  </div>
                  <form id="cadastroForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4></h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <span class="help-block">Codigo:</span>
                                      <input type="text" class="form-control" name="credor_id" id="credor_id" disabled/>
                                  </div>
                                  <div class="col-lg-10 col-md-10 col-sm-10" style="padding-bottom: 10px;">
                                      <span class="help-block">Nome:</span>
                                      <input type="text" class="form-control" name="nome" id="credor_nome"/>
                                  </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                  <span class="help-block">Telefone:</span>
                                  <input id="credor_telefone" type="text" class="form-control"> 
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                  <span class="help-block">Celular:</span>
                                  <input id="credor_celular" type="text" class="form-control"> 
                                </div>
                              </div>
                              <center><div id='statusCadastroCredor'></div></center>
                          </div>  
                          <div class="modal-footer">
                            <div class="pull-right">
                              <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                              <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button id="salvarButtonCredor" type="button" class="btn btn-success" onclick='salvarCredor()' value="novo"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
                            </div>
                          </div>
                        </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>

    <?php 

if(isset($_GET["id"]))
{?>
    <center>
        <h3 style="color:#ffffff; ">
          Cadastro de Dívidas:
        </h3>          
    </center><hr>
    <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="divida.php" class="btn btn-default"><div>Cadastro de Dívidas</div></a>
            <a href="#" class="btn btn-default active"><div>Nova/Editar Dívida</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>
    <div class="modal-dialog modal-lg">      
      <div class="col-md-10 col-md-offset-1">
          <button class="btn btn-default" onclick="location.href='divida.php'"><span class="glyphicon glyphicon-chevron-left"></span> Voltar a listagem</button>
          <br><br>
          <div class="panel panel-warning">
                  <div class="panel-heading">
                          
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-user"></span> Cadastro de Dívida:</h4>
                  </div>
                  <form id="cadastroForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4></h4>
                              <?php
                              $divida= array('id' =>'' ,'credor_id' =>'','nome' =>'' ,'descricao' => '','data_vencimento' =>'' ,'data_pagamento' =>'' ,'situacao' =>'' ,'valor' =>'' );
                              if($_GET['id']!='')
                              {
                                $resultado=$cClass->listarDivida($_GET['id']);
                                $divida=mysqli_fetch_array($resultado);
                              }
                              ?>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <span class="help-block">Codigo:</span>
                                      <input type="text" class="form-control" name="id" id="id" disabled value="<?php echo $divida['id'];?>"/>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                                      <span class="help-block">Data de Vencimento*:</span>
                                      <input id="data_vencimento" type="date" class="form-control" value="<?php echo $divida['data_vencimento'];?>"> 
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <span class="help-block">Descrição*:</span>
                                      <input id="descricao" type="text" class="form-control" value="<?php echo $divida['descricao'];?>"> 
                                  </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                  <span class="help-block">Cod.*:</span>
                                  <input type="text" class="form-control" name="credor_id" id="id_credor" disabled value="<?php echo $divida['credor_id'];?>"/>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-10" style="padding-bottom: 10px;">
                                  <span class="help-block">Credor*:</span>
                                  <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="text" class="form-control" placeholder="Informe o credor" name="nome_credor" id="nome_credor" value="<?php echo $divida['nome'];?>">
                                    <div class="input-group-btn search-panel">
                                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#lista_credores" data-action="credor" id="credorButton">
                                        <span id="search_concept"><span class="glyphicon glyphicon-search"></span>  Procurar</span>
                                      </button>
                                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novo_credor" data-action="novo_credor" id="novoCredorButton">
                                        <span id="search_concept"><span class="glyphicon glyphicon-plus"></span>  Novo</span>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                                  <span class="help-block">Situação*:</span>
                                  <select id="situacao" name="situacao" class="form-control" required="required" onchange="alteraSituacao()">
                                      <option value="">Selecione...</option>
                                      <option value="0" 
                                      <?php if($divida['situacao']=='0')
                                              echo ' selected';?>
                                              >Em Aberto</option>
                                      <option value="1"
                                      <?php if($divida['situacao']=='1')
                                              echo ' selected';?>
                                              >Pago</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                                  <span class="help-block">Data de Pagamento:</span>
                                  <input id="data_pagamento" type="date" class="form-control" value="<?php echo $divida['data_pagamento'];?>" disabled> 
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 pull-right" style="padding-bottom: 10px;">
                                  <span class="help-block">Valor*:</span>
                                  <input id="valor" type="text" class="form-control" value="<?php echo $divida['valor'];?>" onKeydown="Formata(this,20,event,2)"> 
                                </div>
                              </div>
                              <center><div id='statusCadastroDivida'></div></center>
                          </div>  
                          <div class="modal-footer">
                            <div class="pull-right">
                              <button id="salvarButton" type="button" class="btn btn-success" onclick='salvar()' <?php if($_GET['id']!='') echo 'value="editar"';else echo 'value="novo"';?>><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
                            </div>
                          </div>
                        </form>
          </div><!-- /.panel -->
      </div>
    </div>
<?php }
else
{ ?>
    <center>
        <h3 style="color:#ffffff; ">
          Cadastro de Dívidas:
        </h3>          
    </center><hr>
    <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Cadastro de Dívidas</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>
          <button class="btn btn-success"  onclick="location.href='divida.php?id='"><span class="glyphicon glyphicon-plus"></span> Nova Dívida</button>
          <div class="row">          
            <div class="col-md-12">
              <div class="panel panel-primary filterable">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-md-1">
                        <h3 style="font-size: 110%"></h3>
                      </div>
                      <div class="col-md-4 col-md-offset-3">
                            <p class="credit" style="margin-bottom: -20px;">Clique em cima do nome da dívida para mais opções... </p>      
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
                            $cClass->listarDividas();
                            $count=0;
                            if(mysqli_num_rows($cClass->getConsulta())==0)
                            {
                              ?>
                                  <center><h4 style="color:#EB2626">Nenhuma dívida para mostrar...</h4></center>
                              <?php
                            }
                            else
                            {
                              ?>
                              <table class="table table-hover table-condensed">
                                <thead>
                                  <tr class="filters">
                                      <th><input type="text" class="form-control" placeholder="Descrição" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Credor" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Data Vencimento" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Valor" disabled></th>
                                  </tr>
                                </thead>
                              <?php
                              while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                              {
                                $count++;
                                ?>
                                    <tr>
                                      <td style="cursor:hand" onclick="location.href='divida.php?id=<?php echo $array_['id'];?>'">
                                        <small style="color:#080808;font-size: 110%"><?php echo $array_['descricao'];?></small>
                                      </td>
                                      <td style="color:#080808;font-size: 110%">
                                        <small style="color:#080808;font-size: 110%"><?php echo $array_['nome'];?></small>
                                      </td>
                                       <td>
                                        <small style="color:#EB2626;font-size: 100%"><?php echo date_format(date_create($array_['data_vencimento']),'d/m/Y');?></small>
                                      </td>
                                      <td>
                                        <small style="color:#080808;font-size: 110%"><?php echo $array_['valor'];?></small>
                                      </td>
                                    <div class="pull-right action-buttons">
                                      <!-- clique do botão excluir -->
                                      <td><p><button class="btn btn-danger btn-sm" data-toggle="modal" 
                                        type="button" 
                                        data-target="#delete"
                                        data-id="<?php echo $array_['id'];?>"
                                        data-descricao="<?php echo $array_['descricao'];?>"
                                        data-nome="<?php echo $array_['nome'];?>"
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
          <?php
        }
        ?>
</div>
</body>