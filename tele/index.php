<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>  
<script src="../js/funcoes_gerais.js" type="text/javascript"></script>
<script src="../caixa/paneltablewithfilters.js" type="text/javascript"></script>  
<link rel="stylesheet" href="../css/bootstrap.css">
<link href="../caixa/paneltablewithfilters.css" rel="stylesheet"><!-- style for table panel with filters -->
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
    <title>FoodControl - Tele Entregas</title>
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

      $(document).ready(function() 
      {
          valorTotalFixo = '';
          //vai ler apenas os cliques com atributo data-toggle=modal
          $('[data-toggle=modal]').click(function ()
          {
            //************************************************
            var data_id = '';
            if (typeof $(this).data('id') !== 'undefined') 
            {
              data_id = $(this).data('id');
            }
            $('#id_delete').val(data_id);
            $('#id_entrega').val(data_id);
            //************************************************
            var data_cliente = '';
            if (typeof $(this).data('cliente') !== 'undefined') 
            {
              data_cliente = $(this).data('cliente');
            }
            $('#cliente_delete').val(data_cliente);
            $('#cliente').val(data_cliente);
            //************************************************
            var data_valor = '';
            if (typeof $(this).data('valor') !== 'undefined') 
            {
              data_valor = $(this).data('valor');
            }
            $('#valor_entrega').val(data_valor);
            $('#inpValorTotal').val(data_valor);
            //************************************************
            var data_id_usuario = '';
            if (typeof $(this).data('id-usuario') !== 'undefined') 
            {
                data_id_usuario = $(this).data('id-usuario');
            }
            //************************************************
            var list, index;
            list = document.getElementsByClassName("list-group-item lgi");
            for (index = 0; index < list.length; ++index) {
                list[index].setAttribute("onclick", "selecionaCliente(this.id.substr(8),"+data_id_usuario+")");
            }
            document.getElementById('selecionaClienteButton').setAttribute("onclick", "selecionaCliente(document.getElementById('id_cliente').value,"+data_id_usuario+")");
          });
      });

    	function salvaTele(cliente_id,usuario_id)
	    {
        var currentdate = new Date(); 
        var data_tele= currentdate.getFullYear() +"/"+ (((currentdate.getMonth()+1) < 10)?"0":"") + (currentdate.getMonth()+1) +"/"+ ((currentdate.getDate() < 10)?"0":"") + currentdate.getDate();
	      var queryString = "cliente_id="+cliente_id+"&usuario_id="+usuario_id+"&data_tele="+data_tele+"&valor=0&situacao=0";
        if(cliente_id!='')
          buscaDados("statusCadastro",queryString,"../get/getTele.php?action=novo","Não foi possível cadastrar",'true');
	    }

	    function excluir()
	    {
	      var id_delete=document.getElementById('id_delete').value;
	      var queryString = "id="+id_delete;
	      buscaDados("statusExcluir",queryString,"../get/getTele.php?action=delete","Não foi possível excluir a Tele",'true');
	    }

      function entregar()
      {
        var id=document.getElementById('id_entrega').value;
        var queryString = "id="+id+"&situacao=1";
        buscaDados("statusEntregar",queryString,"../get/getTele.php?action=entregar","Não foi possível entregar a Tele","true");
      }

      function selecionaCliente(cliente_id,usuario_id)
      {
        salvaTele(cliente_id,usuario_id);
        //alert('cliente='+cliente_id+' usuario='+usuario_id);
      }
	    
      function salvarCliente()
      {
        var nome=document.getElementById('nome_cliente').value;
        var endereco=document.getElementById('endereco_cliente').value;
        var bairro=document.getElementById('bairro_cliente').value;
        var cidade=document.getElementById('cidade_cliente').value;
        var telefone=document.getElementById('telefone_cliente').value;
        var queryString = "nome="+nome+"&endereco="+endereco;
        queryString+="&bairro="+bairro+"&cidade="+cidade+"&telefone="+telefone;
        var campos=['nome_cliente','endereco_cliente','telefone_cliente'];
        if(validaCampos(campos))
          buscaDados("statusCadastro",queryString,"../get/getCliente.php?action=novo_from_pedido","Não foi possível cadastrar",'');
      }

    </script>
    
</head>
<body>
<?php
  include_once '_modal_clientes.html';
?>
<div class="container">

    <!-- MODAL ENTREGAR TELE -->
    <div class="row">
      <div class="modal fade" id="entregar" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-send"></span> Entregar Tele-Entrega:</h4>
                  </div>
                  <form id="entregarForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Esta tele foi entregue?</h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <span class="help-block">Código:</span>
                                      <input type="text" class="form-control" name="id_entrega" id="id_entrega" disabled/>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <span class="help-block">Valor Total:</span>
                                      <input type="text" class="form-control" name="valor_entrega" id="valor_entrega" disabled/>
                                  </div>
                              </div>
                              <br><br>
                              <center><div id='statusEntregar'></div></center>
                          </div>  
                          <div class="modal-footer">
                            <div class="pull-right">
                              <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                              <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button  type="button" class="btn btn-primary" onclick='entregar()' ><span class="glyphicon glyphicon-upload"></span> Confirmar Entrega</button>
                            </div>
                          </div>
                        </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>

    <!-- MODAL EXCLUIR Tele -->
    <div class="row">
      <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
   
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-send"></span> Excluir tele-Entrega:</h4>
                  </div>
                  <form id="deleteForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Prosseguir com a exclus&#227o desta Tele?</h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="id_delete" id="id_delete" disabled/>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="cliente_delete" id="cliente_delete" disabled/>
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

    
    
    <center><img class="img img-responsive" style="max-width:300px;margin-top:10px" src="../images/logo-foodcontrol.png"><hr></center>
  <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Modo Tele-Entrega</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>     

      <button class="btn btn-success" data-toggle="modal" href="#clientes" data-id-usuario="<?php echo $_SESSION['id'];?>"><span class="glyphicon glyphicon-plus"></span> Nova Tele</button>
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
                            $cClass->listarTeles(0);
                            $count=0;
                            if(mysqli_num_rows($cClass->getConsulta())==0)
                            {
                              ?>
                                <center><h4 style="color:#EB2626">Nenhuma Tele-Entrega a realizar...</h4></center>
                              <?php
                            }
                            else
                            {
                              ?>
                              <table class="table table-hover table-condensed">
                                <thead>
                                  <tr class="filters">
                                      <th><input type="text" class="form-control" placeholder="Cliente" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Valor" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Data" disabled></th>
                                  </tr>
                                </thead>
                              <?php
                              while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                              {
                                $count++;
                                ?>
                                    <tr>
                                      <td style="cursor:hand" onclick="location.href='tele.php?id=<?php echo $array_['id'];?>'">
                                        <small style="color:#080808;font-size: 110%"><?php echo $array_['nome'];?></small>
                                      <td>
                                        <small style="color:#080808;font-size: 110%"><?php echo number_format($array_['valor']+$array_['taxa'],2);?></small>
                                      </td>
                                      <td>
                                        <small style="color:#080808;font-size: 110%"><?php $date=date_create($array_['data_tele']);
                                                                                                  echo date_format($date,'d/m/Y');?></small>
                                      </td>
                                    <div class="pull-right action-buttons">
                                      <!-- clique do botão entregar -->
                                      <td><button class="btn btn-primary btn-sm" data-toggle="modal" 
                                        type="button" 
                                        data-target="#entregar"
                                        data-id="<?php echo $array_['id'];?>"
                                        data-aluguel-choppeira="<?php echo $array_['aluguel_choppeira'];?>"
                                        data-valor="<?php echo $array_['valor'];?>"
                                        data-action="entregar" rel="tooltip" style="margin-left:-20px">
                                        <span class="glyphicon glyphicon-upload"></span> Entregar</button>
                                      </td>
                                      <!-- clique do botão imprimir -->
                                      <td><button class="btn btn-default btn-sm"
                                        type="button" 
                                        onclick="window.open('../get/getTeleImprimir.php?id=<?php echo $array_['id'];?>')"
                                        style="margin-left:-25px">
                                        <span class="glyphicon glyphicon-print"></span> Imprimir</button>
                                      </td>
                                      <!-- clique do botão excluir -->
                                      <td><button class="btn btn-danger btn-sm" data-toggle="modal" 
                                        type="button" 
                                        data-target="#delete"
                                        data-id="<?php echo $array_['id'];?>"
                                        data-cliente="<?php echo $array_['nome'];?>"
                                        data-action="excluir" rel="tooltip" style="margin-left:-20px">
                                        <span class="glyphicon glyphicon-trash"></span> Excluir</button>
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