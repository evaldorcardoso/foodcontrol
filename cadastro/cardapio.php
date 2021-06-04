<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>  
<script src="../js/waitingfor.js" type="text/javascript"></script>  
<script src="../js/funcoes_gerais.js" type="text/javascript"></script>
<script src="../js/funcoes_valores.js" type="text/javascript"></script>
<script src="../js/bootstrap-toggle.min.js"></script>
<link rel="stylesheet" href="../css/bootstrap.css">
<link href="../css/bootstrap-toggle.min.css" rel="stylesheet"><!-- REFERENCIA AO CHECKBOX TOGGLE-->
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
  <title>FoodControl - Cardápio</title>
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
        var descricao=document.getElementById('descricao').value;
        var valor=document.getElementById('valor').value;
        
        var categoria=document.getElementById('categoria').value;
        
        var queryString = "id="+id+"&descricao="+descricao+"&valor="+valor+"&categoria="+categoria;
        if(document.getElementById("checkitem").checked)
        {
          var produtoEstoqueId=document.getElementById("produto_estoque_id").value;
          var formaVenda=document.getElementById("formaVenda").value;
          var quantidadeVenda=document.getElementById("quantidadeVenda").value;
          queryString+="&produto_estoque_id="+produtoEstoqueId+"&formaVenda="+formaVenda+"&quantidadeVenda="+quantidadeVenda;
        }
        if(document.getElementById("cbxAtivo").checked)
          queryString+="&ativo=1";
        else
          queryString+="&ativo=0";

        queryString+="&item_tele="+document.getElementById("item_tele").value;

        var campos=['valor','descricao','categoria'];

        //valor= valor.replace(/\./g,'').replace(',', '.');

        //alert(valor);

        if(validaCampos(campos))
         buscaDados("statusCadastro",queryString,"../get/getItemCardapio.php?action="+acao,"Não foi possível cadastrar",'true');
      }

      function excluir()
      {
        var id_delete=document.getElementById('id_delete').value;
        var queryString = "id="+id_delete;
        buscaDados("statusExcluir",queryString,"../get/getItemCardapio.php?action=delete","Não foi possível excluir o item",'../');
      }

      

      function HabilitaTipoVenda()
      {
        if(document.getElementById("checkitem").checked)
        {
          document.getElementById("produto_estoque_id").disabled=false;
          document.getElementById("formaVenda").disabled=false;
          document.getElementById("quantidadeVenda").disabled=false;
        }
        else
        {
          document.getElementById("produto_estoque_id").disabled=true;
          document.getElementById("formaVenda").disabled=true;
          document.getElementById("quantidadeVenda").disabled=true;
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
        var data_descricao = '';
        if (typeof $(this).data('descricao') !== 'undefined') 
        {
          data_descricao = $(this).data('descricao');
        }
        $('#descricao_delete').val(data_descricao);
        $('#descricao').val(data_descricao);
        //************************************************
        var data_valor = '';
        if (typeof $(this).data('valor') !== 'undefined') 
        {
          data_valor = $(this).data('valor');
        }

        $('#valor').val(data_valor);
        //************************************************
        var data_categoria = '';
        if (typeof $(this).data('categoria') !== 'undefined') 
        {
          data_categoria = $(this).data('categoria');
        }
        $('#categoria').val(data_categoria);
        //************************************************
        var data_forma_venda = '';
        if (typeof $(this).data('forma-venda') !== 'undefined') 
        {
          data_forma_venda = $(this).data('forma-venda');
        }
        $('#formaVenda').val(data_forma_venda);
        //************************************************
        var data_quantidade_venda = '';
        if (typeof $(this).data('quantidade-venda') !== 'undefined') 
        {
          data_quantidade_venda = $(this).data('quantidade-venda');
        }
        $('#quantidadeVenda').val(data_quantidade_venda);
        //************************************************
        var data_produto_estoque_id = '';
        if (typeof $(this).data('produto-estoque-id') !== 'undefined') 
        {
          data_produto_estoque_id = $(this).data('produto-estoque-id');
        }
        $('#produto_estoque_id').val(data_produto_estoque_id);
        //************************************************
        var data_item_tele = '';
        if (typeof $(this).data('item-tele') !== 'undefined') 
        {
          data_item_tele = $(this).data('item-tele');
        }
        $('#item_tele').val(data_item_tele);

        if(data_produto_estoque_id!='')
        {
          document.getElementById("checkitem").checked=true;
          $('#checkitem').bootstrapToggle('on') 
        }
        else
        {
          document.getElementById("checkitem").checked=false;
          $('#checkitem').bootstrapToggle('off') 
        }
        //************************************************
        var data_ativo = '';
        if (typeof $(this).data('ativo') !== 'undefined') 
        {
          data_ativo = $(this).data('ativo');
        }
        if(data_ativo=='1')
          document.getElementById("cbxAtivo").checked=true;
        else
          document.getElementById("cbxAtivo").checked=false;
        HabilitaTipoVenda();
      });

      });
    </script>
    <!-- style for table panel with filters -->
    <link href="../caixa/paneltablewithfilters.css" rel="stylesheet">
    <script src="../caixa/paneltablewithfilters.js" type="text/javascript"></script>  
</head>
<body>

  
<div class="container">
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
                                      <input type="text" class="form-control" name="descricao_delete" id="descricao_delete" disabled/>
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
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-list-alt"></span> Cadastro de Item no Cardápio:</h4>
                  </div>
                  <form id="cadastroForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4></h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <span class="help-block">Codigo:</span>
                                      <input type="text" class="form-control" name="id" id="id" disabled/>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <span class="help-block">Descricao:</span>
                                      <input type="text" class="form-control" name="descricao" id="descricao"/>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <span class="help-block">Item Ativo?</span>
                                    <input id="cbxAtivo" type="checkbox" data-toggle="toggle" data-on="Sim" data-off="Não"/>
                                  </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                                  <span class="help-block">Valor: R$</span>
                                  <input id="valor" type="text" class="form-control" onKeydown="Formata(this,20,event,2)"> 
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7" style="padding-bottom: 10px;">
                                  <span class="help-block">Categoria:</span>
                                    <select id="categoria" name="categoria" class="form-control" required="required" onchange="HabilitaTipoVenda()">
                                      <option value="1">Comida</option>
                                      <option value="2">Bebida</option>
                                    </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                                  <span class="help-block">Descontar do estoque?</span>
                                  <input type="checkbox" id="checkitem" onchange="HabilitaTipoVenda()" data-toggle="toggle" data-on="Sim" data-off="Não"/>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7" style="padding-bottom: 10px;">
                                  <span class="help-block">Item visível para:</span>
                                  
                                  <select id="item_tele" name="item_tele" class="form-control" required="required">
                                      <option value="0">Cardápio</option>
                                      <option value="1">Tele-Entrega</option>
                                      <option value="2">Cardápio e Tele-Entrega</option>
                                    </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                                  <span class="help-block">Item do Estoque:</span>
                                  <select id="produto_estoque_id" name="produto_estoque_id" class="form-control" required="required" disabled>
                                      <option value="" selected></option>
                                      <?php
                                        $result=$cClass->listar2('produto_estoque','descricao');
                                        if(0<>mysqli_num_rows($result))
                                        {
                                          while($arr=mysqli_fetch_array($result))
                                          { ?>
                                            <option value="<?php echo $arr['id'];?>"><?php echo $arr['descricao'];?></option>
                                          <?php 
                                          }
                                        }
                                      ?>
                                  </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                                  <span class="help-block">Formato de venda:</span>
                                  <select id="formaVenda" name="formaVenda" class="form-control" required="required" disabled>
                                      <option value="" selected></option>
                                      <option value="ml">Miligrama (ml)</option>
                                      <option value="l">Litro (L)</option>
                                      <option value="un">Unidade (Un)</option>
                                  </select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 10px;">
                                  <span class="help-block">Quant. de venda:</span>
                                  <input id="quantidadeVenda" type="text" class="form-control"> 
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
          Cadastro de Cardápio:
        </h3>          
      </center><hr>
      <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Cadastro de Cardápio</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>
          <button class="btn btn-success" data-toggle="modal" data-target="#modalCadastro" data-action="novo"><span class="glyphicon glyphicon-plus"></span> Novo Item</button>
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
                            
                            $cClass->listar('item_cardapio','descricao');
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
                                      <th><input type="text" class="form-control" placeholder="Valor (R$)" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Categoria" disabled></th>
                                  </tr>
                                </thead>
                              <?php
                              while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                              {
                                $count++;
                                ?>
                                    <tr <?php if ($array_['ativo']=='1') echo 'class="success"'; else echo 'class="danger"'?>>
                                      <td style="cursor:hand"
                                      data-toggle="modal" 
                                      data-target="#modalCadastro"
                                      data-id="<?php echo $array_['id'];?>"
                                      data-descricao="<?php echo $array_['descricao'];?>"
                                      data-valor="<?php echo $array_['valor'];?>"
                                      data-categoria="<?php echo $array_['categoria'];?>"
                                      data-item-tele="<?php echo $array_['item_tele'];?>"
                                      data-produto-estoque-id="<?php echo $array_['produto_estoque_id'];?>"
                                      data-forma-venda="<?php echo $array_['formaVenda'];?>"
                                      data-quantidade-venda="<?php echo $array_['quantidadeVenda'];?>"
                                      data-ativo="<?php echo $array_['ativo'];?>"
                                      data-action="editar"
                                      >
                                        <small style="color:#080808;font-size: 110%"><?php echo $array_['descricao'];?></small>
                                      </td>
                                       <td>
                                        <small style="color:#EB2626;font-size: 100%"><?php echo $array_['valor'];?></small>
                                      </td>
                                      <td>
                                        <small style="color:#080808;font-size: 110%">
                                          <?php if($array_['categoria']==1) echo "Comida";else echo "Bebida";?>
                                        </small>
                                      </td>
                                    <div class="pull-right action-buttons">
                                      <!-- clique do botão excluir -->
                                      <td><p><button class="btn btn-danger btn-sm" data-toggle="modal" 
                                        type="button" 
                                        data-target="#delete"
                                        data-id="<?php echo $array_['id'];?>"
                                        data-descricao="<?php echo $array_['descricao'];?>"
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